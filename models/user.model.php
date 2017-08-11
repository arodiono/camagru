<?php

class UserModel extends Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function activateUser($data = array())
	{
		$email = $data[0];
		$hash = $data[1];
		$request = "UPDATE `users`
					SET `active` = 1
					WHERE `email` = \"$email\"
					AND `hash` = \"$hash\"";
		$update = $this->database->prepare($request);
		$update->execute();
		$count = $update->rowCount();
		if ($count == 1)
		{
			Session::add('infoMessage', 'User successfully activated');
			return true;
		}
		else
		{
			Session::add('errorMessage', 'User is not activated');
			return false;
		}
	}
}
