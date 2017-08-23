<?php

class SignupModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function validateFormInput()
	{
		$login = $_POST['login'];
		$fullname = $_POST['fullname'];
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
		return array('login' => $login, 'fullname' => $fullname, 'email' => $email, 'password' => $password);
	}

	public function addNewUser($data)
	{
		extract($data, EXTR_OVERWRITE);
		$passwordHash = password_hash($password, PASSWORD_BCRYPT);
		$activationHash = hash('md5', uniqid(rand(), true));

		if ( !$this->writeNewUser($login, $fullname, $passwordHash, $email, $activationHash) )
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

	public function isUserExist($login)
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

	private function writeNewUser($login, $fullname, $password, $email, $hash)
	{
		$data = array($login, $fullname, $password, $email, $hash);
		$request = "INSERT INTO `users`(`login`, `fullname`, `password`, `email`, `hash`)
					VALUES(?, ?, ?, ?, ?)";
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
}
