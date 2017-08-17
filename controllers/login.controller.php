<?php

class LoginController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->model = new LoginModel();
	}
	public function index()
	{
		$data['title'] = 'Login';
        $this->view->renderNoTemplate('login', $data);
	}

	public function login()
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
