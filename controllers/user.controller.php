<?php

class UserController extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->model = new UserModel();
	}

	public function index()
	{

	}

	public function activate($data)
	{
		$activate = $this->model->activateUser($data);
		$this->view->renderNotification();
	}

}
