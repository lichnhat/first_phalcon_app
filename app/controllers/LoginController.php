<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model;
use Phalcon\Http\Response;

class LoginController extends Controller {

	public function indexAction() {
		$this->assets->addCss('public/css/style.css');
		
		$response = new Response();
		if($this->session->has("id") && $this->session->has("checked") && $this->session->get("checked") === "true") {
			$this->response->redirect("manager");
		}
		else {
			if($this->request->isPost()) {
				/* New Object */
				$model = new Users();
				$request = new Request();
				/* Initial Errors variable */
				$messages = array();
				$user_name = $pass = "";

				/* Check Form Login */
				if($request->isPost()) {
					$user_name = $this->request->getPost('user_name');
					$pass = $this->request->getPost('password');
				}
				if($user_name == "") {
					$messages[] = "User Name Field not allow empty !";
				}
				if($pass == "") {
					$messages[] = "Password Field not allow empty !";
				}
				/* Excute Query or Redirect user to login if there have some errors */
				if(empty($messages)) {
					/* Get imfomation from table */
					$results = Users::findFirst(
						[
							"user_name = :name: AND password = :pass: AND blocked != :set:",
					        "bind" => [
					            "name" => $user_name,
					            "pass" => $pass,
					            "set"  => 1,
					        ],
						]
					);
					if($results === false) {
						$messages[] = "User has been block or do not live !";
						$this->flash->warning("User not exist !");
						$this->response->redirect("login");
					}
					else {
						$id = $results->id;
						$this->session->set("id",$id);
						$this->session->set("checked", "true");
						/* Insert user's infomation to Database */
						$ip = $_SERVER["REMOTE_ADDR"];
						$recent = new Recent();
						$recent->user_id = $id;
						$recent->ip = $ip;
						$recent->save();
						$this->response->redirect("manager");
					}			
				}
				else {
					$this->flash->warning("Username not exist or Password in-correct !");
					$this->response->redirect("login");
				}
			}
		}
	}

}