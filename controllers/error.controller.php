<?php

class ErrorController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function error404()
	{
		$data['title'] = '404 Not Found';
		header('HTTP/1.0 404 Not Found', true, 404);
		$this->view->render('404', $data);
	}
}