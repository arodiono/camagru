<?php

class MainController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (Session::isLoggedOnUser())
		{
			$data['title'] = 'Camagru';
			$this->view->render('main', $data);
		}
		else
		{

		}

	}
}
