<?php

class LoginModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		$email = $_POST['email'];
		$password = $_POST['password'];

		if ( !filter_var($email, FILTER_VALIDATE_EMAIL) )
		{
			Session::add('errorMessage', 'Incorrect email or password.');
			return false;
		}

		$request = $this->database->prepare("SELECT *
					FROM `users`
					WHERE `email` = \"$email\"");
		$request->execute();

		if ($request->rowCount() == 0)
        {
            Session::add('errorMessage', 'Incorrect email or password.');
            return false;
        }
		$data = $request->fetch();
		if ($data->active != 1)
		{
			Session::add('errorMessage', 'Account not activated.');
			return false;
		}
		if ($data->email !== $email || !password_verify($password, $data->password))
		{
			Session::add('errorMessage', 'Incorrect email or password.');
			return false;
		}
		else
		{
			Session::set('logged_on_user', true);
            Session::set('user_id', $data->user_id);
            Session::set('username', $data->username);
            Session::set('profile_picture', $data->profile_picture);
            return true;
		}
	}
}
