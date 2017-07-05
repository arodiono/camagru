<?php

class UserController extends Controller
{

	function __construct()
	{
		$class_name = str_replace('Controller', '', __CLASS__);
		$view_name = $class_name . 'View';
		$model_name = $class_name . 'Model';
		$this->model = new $model_name();
		$this->view = new $view_name();
	}

	public function index()
	{

	}

	public function register()
	{
		$this->model->register();
	}

	public function login()
	{

	}

	public function logout()
	{

	}
}
