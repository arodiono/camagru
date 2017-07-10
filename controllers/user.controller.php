<?php

class UserController extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->model = new UserModel();
		// $this->view = new View();
	}

	public function index()
	{

	}

	public function register()
	{
		$data['title'] = 'Register';
		$this->view->render('register', $data);
	}

	public function registerAction($data)
	{
		$registration = $this->model->addNewUser($data);
		$this->view->renderNotification();
	}

	public function validateFormInput()
	{
		$validation = $this->model->validateFormInput();
		if ($validation)
		{
			$this->registerAction($validation);
		}
		else
		{
			$this->view->renderNotification();
		}
	}

	public function login()
	{

	}

	public function logout()
	{

	}
}
