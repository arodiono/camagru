<?php

class Route
{
	private $controller;
	private $action;
	public $params;

	public function __construct()
	{
		$this->splitUrl();

		if(!$this->controller)
		{
			// Set default controller
			$this->controller = new MainController();
			$this->controller->index();
		}
		elseif (file_exists(APP . 'controllers/' . $this->controller . '.controller.php'))
		{
			// Set controller and model if exist
			$controller_name = ucfirst($this->controller) . 'Controller';
			$this->controller = new $controller_name();

			if ($this->action == null)
			{
				$this->controller->index();
			}
			elseif (method_exists($controller_name, $this->action))
			{
				$this->controller = new $controller_name();
				call_user_func_array(array($this->controller, $this->action), array($this->params));
			}
			else
			{
				// Set error if model not exist
				$this->controller = new ErrorController();
				$this->controller->error404();
			}
		}
		else
		{
			// Set error if controller not exist
			$this->controller = new ErrorController();
			$this->controller->error404();
		}
	}

	private function splitUrl()
	{
		$url = explode(DIRECTORY_SEPARATOR, trim($_SERVER['REQUEST_URI'], DIRECTORY_SEPARATOR));
		$this->controller = isset($url[0]) ? $url[0] : null;
		$this->action = isset($url[1]) ? $url[1] : null;
		unset($url[0], $url[1]);
		$this->params = array_values($url);
	}
}
