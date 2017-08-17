    <?php

class Controller
{
	public $model;
	public $view;

	function __construct()
	{
		Session::init();
		$this->view = new View();
	}
}
