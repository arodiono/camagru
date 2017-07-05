<?php

class MainController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'Camagru';
		$this->view->render('main', $data);
	}
}
