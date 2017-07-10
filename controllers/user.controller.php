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
			header('HTTP/1.0 201');
		}
		else
		{
			$this->view->renderNotification();
		}
	}

	public function activate($data)
	{
		$activate = $this->model->activateUser($data);
		$this->view->renderNotification();
	}

	public function login()
	{
		$data['title'] = 'Login';
		$this->view->render('login', $data);
	}

	public function loginAction()
	{
		$login = $this->model->login();
		if ($login)
		{
			header('HTTP/1.0 201');
		}
		else
		{
			$this->view->renderNotification();
		}
	}

	public function logout()
	{
		Session::destroy();
		header('Location: //' . $_SERVER['HTTP_HOST']);
	}
}
