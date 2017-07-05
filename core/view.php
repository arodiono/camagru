<?php

class View
{

	public function render($content, $data = array())
	{
		if(is_array($data))
		{
			extract($data);
		}
		include_once APP . 'views/template/header.php';
		include_once APP . 'views/' . $content . '.php';
		include_once APP . 'views/template/footer.php';
	}
}
