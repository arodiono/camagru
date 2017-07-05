<?php

class Controller
{
	public $model;
	public $view;

	function __construct()
	{
		Session::init();

		$this->model = new Model();
		$this->view = new View();
	}
}
