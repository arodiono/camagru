<?php

class UserController extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->model = new UserModel();
		$this->view = new View();
	}

	public function index()
	{

	}

	public function register()
	{
		$data['title'] = 'Register';
		$this->view->render('register', $data);
	}

	public function registerAction()
	{
		$registration = $this->model->addNewUser();
		$this->view->renderNotification();
	}

	public function login()
	{

	}

	public function logout()
	{

	}
}
