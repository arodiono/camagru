<?php

class Route
{
	private $controller;
	private $action;
	private $params;

	public function __construct()
	{
		$this->splitUrl();

	}

	private function splitUrl()
	{
		$url = explode(DIRECTORY_SEPARATOR, $_SERVER['REQUEST_URI']);
		var_dump($url);
		$this->controller = isset($url[0]) ? $url[0] : null;
		$this->action = isset($url[1]) ? $url[1] : null;
		unset($url[0], $url[1]);
		$this->params = array_values($url);
	}
}
