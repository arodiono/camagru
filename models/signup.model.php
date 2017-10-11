<?php

class SignupModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function validateFormInput()
	{
		$username = $_POST['username'];
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
		if ( $this->isUserExist($username) )
		{
			Session::add('errorMessage', 'Username already exist');
			return false;
		}
		if ( $this->isEmailExist($email) )
		{
			Session::add('errorMessage', 'User email already exist');
			return false;
		}
		return array('username' => $username, 'fullname' => $fullname, 'email' => $email, 'password' => $password);
	}

	public function addNewUser($data)
	{
		extract($data, EXTR_OVERWRITE);
		$passwordHash = password_hash($password, PASSWORD_BCRYPT);
		$activationHash = hash('md5', uniqid(rand(), true));

		if ( !$this->writeNewUser($username, $fullname, $passwordHash, $email, $activationHash) )
		{
			Session::add('errorMessage', 'Registration failed. Please try again later');
			return false;
		}
		if ( !$this->sendActivationMail($username, $email, $activationHash) )
		{
			Session::add('errorMessage', 'Error when sending a mail with an activation code. Please try again later');
			return false;
		}
		Session::add('infoMessage', 'User successfully registered');
		return true;
	}

	public function isUserExist($username)
	{
		$request = $this->database->prepare("SELECT `username`
								FROM `users`
								WHERE `username`=\"$username\"");
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

	private function writeNewUser($username, $fullname, $password, $email, $hash)
	{
		$data = array($username, $fullname, $password, $email, $hash);
		$request = "INSERT INTO `users`(`username`, `fullname`, `password`, `email`, `hash`)
					VALUES(?, ?, ?, ?, ?)";
		$insert = $this->database->prepare($request);
		$insert->execute($data);

		$count = $insert->rowCount();
		if ($count == 1)
			return true;
		else
			return false;
	}

	private function sendActivationMail($username, $email, $hash)
	{
		$link = 'http://' . $_SERVER['HTTP_HOST'] . '/user/activate/' . $email . '/'. $hash . '/';

		$subject = 'Camagru account activation';

		$message = file_get_contents(APP . 'views/mail/header.php');
		$message .= '<h3>To activate your account, please follow the link</h3></br>' . $link;
		$message .= file_get_contents(APP . 'views/mail/footer.php');

        $encoding = "utf-8";
        $subject_preferences = array(
            "input-charset" => $encoding,
            "output-charset" => $encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );
        $header = "Content-type: text/html; charset=".$encoding." \r\n";
        $header .= "From: Camagram <noreply@camagram.com> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";
        $header .= iconv_mime_encode("Subject", $subject, $subject_preferences);

		$send = mail($email, $subject, $message, $header);
		if( $send == true )
			return true;
		else
			return false;
	}
}
