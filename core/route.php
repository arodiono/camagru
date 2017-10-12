<?php

class Route
{
	private $controller;
	private $action;
	public $params;

	public function __construct()
	{
		$this->splitUrl();

		if($this->controller == null) {
			$this->controller = new MainController();
			$this->controller->index();
		}
		elseif ($this->isUser()) {
            $user = $this->controller;
            $this->controller = new UserController();
            $this->controller->index($user, $this->action);
        }
		elseif (file_exists(APP . 'controllers/' . $this->controller . '.controller.php')) {
			$controller_name = ucfirst($this->controller) . 'Controller';
			$this->controller = new $controller_name();

			if ($this->action == null) {
				$this->controller->index();
			}
			elseif (method_exists($controller_name, $this->action)) {
				$this->controller = new $controller_name();
				call_user_func_array(array($this->controller, $this->action), array($this->params));
			}
			else {
				$this->controller = new ErrorController();
				$this->controller->error404();
			}
		}
		else {
			$this->controller = new ErrorController();
			$this->controller->error404();
		}
	}

	private function isUser()
    {
        $res = new SignupModel();
        return $res->isUserExist($this->controller);
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
