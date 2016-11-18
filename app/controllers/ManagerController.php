<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Http\Request;

class ManagerController extends Controller {
	public function indexAction() {
		$this->assets->addCss('public/css/manager.css');

		/* New Response */
		$response = new Response();

		/* Check session */
		if($this->session->has("id") && $this->session->has("checked")) {
			if($this->session->get("checked") === "true") {

				/* Get value from session */
				$id = $this->session->get("id");
				/* End get value from session */

				/* Send id */
				$this->view->id_u = $id;
			}
			else {
				$this->response->redirect("login");
			}
		}
		else {
			$this->response->redirect("login");
		}
	}
	public function recentAction() {
		/* Add css */
		$this->assets->addCss('public/css/recent.css');

		/* New Response */
		$response = new Response();

		/* Check session */
		if($this->session->has("id") && $this->session->has("checked")) {
			if($this->session->get("checked") === "true") {

				/* Get value from session */
				$id = $this->session->get("id");
				/* End get value from session */

				/* Find user */
				$results_ul = Users::find(
					[
						"delete_property = :set:",
						"bind" => [
							"set" => 0,
						],
					]
				);
				$results_u = Users::findFirst(
					[
						"id = :id:",
						"bind" => [
							"id" => $id,
						],
					]
				);
				$results_r = Recent::find(
					[
						"user_id = :id:",
						"bind" => [
							"id" => $id,
						],
					]
				);
				/* End find users */

				/* Send to View */
				/* Set data to send */
				$this->view->recent = $results_r;
				$this->view->user = $results_u;
				$this->view->listuser = $results_ul;
				/* End set data and send data to view */
			}
			else {
				$this->response->redirect("login");
			}
		}
		else {
			$this->response->redirect("login");
		}
		/* End check session */
	}
	public function editAction() {
		$this->assets->addCss('public/css/manager.css');
		$this->assets->addCss('public/css/edit.css');

		/* New Response */
		$response = new Response();

		/* Check session */
		if($this->session->has("id") && $this->session->has("checked")) {
			if($this->session->get("checked") === "true") {

				/* Get value from session */
				$id = $this->session->get("id");
				/* End get value from session */

				$results = Users::findFirst(
					[
						"id = :id:",
						"bind" => [
							"id" => $id,
						],
					]
				);

				/* Send id */
				$this->view->user = $results;
			}
			else {
				$this->response->redirect("login");
			}
		}
		else {
			$this->response->redirect("login");
		}
	}
	public function edittedAction() {
		/* New Response */
		$response = new Response();

		/* New Request */
		$request = new Request();

		/* Check session */
		if($this->session->has("id") && $this->session->has("checked")) {
			if($this->session->get("checked") === "true") {

				/* Get value from session */
				$id = $this->session->get("id");

				/* Get form's value */
				$old = $this->request->getPost("old");
				$new = $this->request->getPost("new");

				$user = Users::findFirst(
					[
						"id = :id:",
						"bind" => [
							"id" => $id,
						],
					]
				);

				$results = Users::findFirst(
					[
						"id = :id: AND password = :pass:",
						"bind" => [
							"id" => $id,
							"pass" => $old,
						],
					]
				);
				if(!$results) {
					$this->view->mess = "The Old Password is not Match !";
					$this->response->redirect("manager/edit");
				}
				else {
					$aff = $results->update(
						[
							"password" => $new,
						]
					);
					if($aff) {
						$this->view->mess = "Your password was change !";
						$this->response->redirect("manager");
					}
				}
			}
			else {
				$this->response->redirect("login");
			}
		}
		else {
			$this->response->redirect("login");
		}
	}
	public function deleteAction($id_recent) {
		/* New Response */
		$response = new Response();

		/* Check session */
		if($this->session->has("id") && $this->session->has("checked")) {
			if($this->session->get("checked") === "true") {

				/* Get id user is current login */
				$id = $this->session->get("id");

				/* Delete recent by its id */
				$results = Recent::findFirst(
					[
						"user_id = :user_id: AND id = :recent_id:",
						"bind" => [
							"user_id" => $id,
							"recent_id" => $id_recent
						],
					]
				);
				if($results !== false) {
					$results->delete();
					$this->response->redirect("manager/recent");
				}
			}
			else {
				$this->response->redirect("login");
			}
		}
		else {
			$this->response->redirect("login");
		}
	}
	public function usersAction() {

		/* Add css */
		$this->assets->addCss('public/css/users.css');

		/* New Response */
		$response = new Response();

		/* Check session */
		if($this->session->has("id") && $this->session->has("checked")) {
			if($this->session->get("checked") === "true") {

				$id = $this->session->get("id");
				$results = Users::findFirst(
					[
						"id = :id:",
						"bind" => [
							"id" => $id,
						],
					]
				);
				if($results !== false) {
					$property = $results->delete_property;
					if($property == 1) {
						$users = Users::find(
							[
								"delete_property = :set:",
								bind => [
									"set" => 0,
								],
							]
						);
						$this->view->users = $users;
						$this->view->current = $results;
					}
					else {
						$mess = "<p class='warning'>Bạn không có quyền admin để sử dụng trang này !</p>";
						$this->view->mess = $mess;
						$this->view->current = $results;
					}
				}
			}
			else {
				$this->response->redirect("login");
			}
		}
		else {
			$this->response->redirect("login");
		}
	}
	public function blockAction($id) {
		/* New Response */
		$response = new Response();

		/* Check session */
		if($this->session->has("id") && $this->session->has("checked")) {
			if($this->session->get("checked") === "true") {

				$user = Users::findFirst(
					[
						"id = :id:",
						"bind" => [
							"id" => $id,
						],
					]
				);
				if($user !== false) {
					$user->update(
						[
							"blocked" => 1,
						]
					);
					$this->response->redirect("manager/users");
				}
			}
			else {
				$this->response->redirect("login");
			}
		}
		else {
			$this->response->redirect("login");
		}
	}
	public function unblockAction($id) {
		/* New Response */
		$response = new Response();

		/* Check session */
		if($this->session->has("id") && $this->session->has("checked")) {
			if($this->session->get("checked") === "true") {

				$user = Users::findFirst(
					[
						"id = :id:",
						"bind" => [
							"id" => $id,
						],
					]
				);
				if($user !== false) {
					$user->update(
						[
							"blocked" => 0,
						]
					);
					$this->response->redirect("manager/users");
				}
			}
			else {
				$this->response->redirect("login");
			}
		}
		else {
			$this->response->redirect("login");
		}
	}
	public function logoutAction() {
		$response = new Response();
		if($this->session->has("id") && $this->session->has("checked") && $this->session->get("checked") === "true") {
			$this->session->remove("id");
			$this->session->remove("checked");
			$this->session->destroy();
			$this->response->redirect("login");
		}
		else {
			$this->response->redirect("login");
		}
	}
}