<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;
use Phalcon\Http\Response;

class RegisterController extends Controller {

	public function indexAction() {
		$this->assets->addCss('public/css/register.css');

		/* New request */
		$request = new Request();
		/* New response */
		$response = new Response();

		$messages = array();

		if($this->request->isPost()) {

			$nick_name = $user_name = $password = $cpassword = "";

			$nick_name = $this->request->getPost("nick_name");
			$user_name = $this->request->getPost("user_name");
			$password = $this->request->getPost("password");
			$cpassword = $this->request->getPost("cpassword");

			if(empty($nick_name)) {
				$messages[] = "The nick name field is required !";
			}
			if(empty($user_name)) {
				$messages[] = "The user name field is required !";
			}
			if(empty($password)) {
				$messages[] = "The password field is required !";
			}
			if(empty($cpassword)) {
				$messages[] = "The confirm password field is required !";
			}

			if($password !== $cpassword) {
				$this->flash->warning("Password is not match !");
			}
			else {
				$iuser = Users::count(
					[
						" user_name = :user_name:",
						"bind" => [
							"user_name" => $user_name,
						],
					]
				);
				if($iuser == 1) {
					$this->flash->warning("Tên đăng nhập đã tồn tại !");
				}
				else {
					$user = new Users();
					$aff = $user->save(
						[
							"nick_name" => $nick_name,
							"user_name" => $user_name,
							"password"	=> $password,
							"delete_property" => 0,
							"blocked" => 0,
						]
					);
					if($aff) {
						$this->flash->warning("Đăng ký thành công !");
					}
					else {
						$this->flash->warning("Không thể đăng ký do hệ thông lỗi !");
					}
				}
			}
		}
	}

}