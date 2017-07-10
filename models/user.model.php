<?php

class UserModel extends Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function validateFormInput()
	{
		$login = $_POST['login'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$passwordConfirm = $_POST['passwordConfirm'];

		if ( !$this->validatePassword($password, $passwordConfirm) )
		{
			return false;
		}
		if ( !filter_var($email, FILTER_VALIDATE_EMAIL) )
		{
			Session::add('errorMessage', 'Invalid email address');
			return false;
		}
		if ( $this->isUserExist($login) )
		{
			Session::add('errorMessage', 'Username already exist');
			return false;
		}
		if ( $this->isEmailExist($email) )
		{
			Session::add('errorMessage', 'User email already exist');
			return false;
		}
		return array('login' => $login, 'email' => $email, 'password' => $password);
	}

	public function addNewUser($data)
	{
		extract($data, EXTR_OVERWRITE);
		$passwordHash = password_hash($password, PASSWORD_BCRYPT);
		$activationHash = hash('md5', uniqid(rand(), true));

		if ( !$this->writeNewUser($login, $passwordHash, $email, $activationHash) )
		{
			Session::add('errorMessage', 'Registration failed. Please try again later');
			return false;
		}
		if ( !$this->sendActivationMail($login, $email, $activationHash) )
		{
			Session::add('errorMessage', 'Error when sending a mail with an activation code. Please try again later');
			return false;
		}
		Session::add('infoMessage', 'User successfully registered');
		return true;
	}

	private function isUserExist($login)
	{
		$request = $this->database->prepare("SELECT `login`
								FROM `users`
								WHERE `login`=\"$login\"");
		$request->execute();
		if ( empty( $request->fetch() ) )
			return false;
		else
			return true;
	}

	private function isEmailExist($email)
	{
		$request = $this->database->prepare("SELECT `email`
								FROM `users`
								WHERE `email`=\"$email\"");
		$request->execute();
		if ( empty( $request->fetch() ) )
			return false;
		else
			return true;
	}

	private function validatePassword($password, $passwordConfirm)
	{
		if ( $password !== $passwordConfirm)
		{
			Session::add('errorMessage', 'Passwords do not match');
			return false;
		}
		if ( strlen($password) < 8 )
		{
			Session::add('errorMessage', 'Password must be equal to or longer than 8 characters');
			return false;
		}
		return true;
	}

	private function writeNewUser($login, $password, $email, $hash)
	{
		$data = array($login, $password, $email, $hash);
		$request = "INSERT INTO `users`(`login`, `password`, `email`, `hash`)
					VALUES(?, ?, ?, ?)";
		$insert = $this->database->prepare($request);
		$insert->execute($data);

		$count = $insert->rowCount();
		if ($count == 1)
			return true;
		else
			return false;
	}

	private function sendActivationMail($login, $email, $hash)
	{
		$link = 'http://' . $_SERVER['HTTP_HOST'] . '/user/activate/' . $email . '/'. $hash . '/';

		$subject = 'Camagru account activation';

		$message = file_get_contents(APP . 'views/mail/header.php');
		$message .= '<h3>To activate your account, please follow the link</h3></br>' . $link;
		$message .= file_get_contents(APP . 'views/mail/footer.php');

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		$send = mail($email, $subject, $message, $headers);
		if( $send == true )
			return true;
		else
			return false;
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

	public function login()
	{
		$email = $_POST['email'];
		$password = $_POST['password'];

		$request = $this->database->prepare("SELECT `login`, `email`, `password`
					FROM `users`
					WHERE `email` = \"$email\"");
		$request->execute();

		$data = $request->fetch();
		if ($data->email !== $email || !password_verify($password, $data->password))
		{
			Session::add('errorMessage', 'Incorrect username or password.');
			return false;
		}
		else
		{
			Session::set('logged_on_user', $data->login);
			return true;
		}
	}

}
