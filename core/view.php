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

	public function renderNotification()
	{
		$error = Session::get('errorMessage');
		$info = Session::get('infoMessage');

		if (isset($error))
		{
			foreach ($error as $value)
			{
				echo '<div class="error">' . $value . '</div>';
			}
		}
		if (isset($info))
		{
			foreach ($info as $value)
			{
				echo '<div class="info">' . $value . '</div>';
			}
		}

		Session::set('errorMessage', null);
		Session::set('infoMessage', null);
	}

	public static function renderEmail($data = array())
	{
		include_once APP . 'views/template/mail/header.php';
		foreach ($data as $value)
		{
			echo $value . '</br>';
		}
		include_once APP . 'views/template/mail/footer.php';
	}
}
