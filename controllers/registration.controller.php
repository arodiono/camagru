<?php

class RegistrationController extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->model = new RegistrationModel();
	}

	public function index()
	{
		$data['title'] = 'Register';
		$this->view->render('registration', $data);
	}

	public function register($data)
	{
		$registration = $this->model->addNewUser($data);
		$this->view->renderNotification();
	}

	public function validateFormInput()
	{
		$validation = $this->model->validateFormInput();
		if ($validation)
		{
			$this->register($validation);
			header('HTTP/1.0 201');
		}
		else
		{
			$this->view->renderNotification();
		}
	}
}
