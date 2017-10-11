<?php

class PasswordModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function remindPassword()
	{
		$email = $_POST['email'];

		if ( !filter_var($email, FILTER_VALIDATE_EMAIL) )
		{
			Session::add('errorMessage', 'Invalid e-mail address');
			return false;
		}

		$request = $this->database->prepare("SELECT `email`, `hash`
					FROM `users`
					WHERE `email` = \"$email\"");
		$request->execute();

		$data = $request->fetch();

		if ($data != null)
		{
			if ($this->sendResetPasswordMail($data->email, $data->hash))
			{
				Session::add('infoMessage', 'The password recovery instruction was successfully sent to your e-mail');
				return true;
			}
			else
			{
				Session::add('errorMessage', 'Error when sending a message');
				return false;
			}
		}
		else
		{
			Session::add('errorMessage', 'Invalid e-mail address');
			return false;
		}
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

	public function resetPassword($email, $password)
	{
		$request = "UPDATE `users`
					SET `password` = \"$password\"
					WHERE `email` = \"$email\"";
		$update = $this->database->prepare($request);
		$update->execute();
		$count = $update->rowCount();
		if ($count == 1)
		{
			Session::add('infoMessage', 'Password successfully updated');
			return true;
		}
		else
		{
			Session::add('errorMessage', 'Please try again later');
			return false;
		}
	}

	private function sendResetPasswordMail($email, $hash)
	{
		$link = 'http://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $email . '/'. $hash . '/';

		$subject = 'Camagram account password reset';

		$message = file_get_contents(APP . 'views/mail/header.php');
		$message .= '<h3>To reset your account password, please follow the link</h3></br>' . $link;
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

	public function validateMailAndHash($email = null, $hash = null)
    {
        if ($email === null || $hash === null)
            return false;
        $request = "SELECT `email`, `hash`
                    FROM `users`
					WHERE `email` = \"$email\"
					AND `hash` = \"$hash\"";
        $select = $this->database->prepare($request);
        $select->execute();
        $count = $select->rowCount();
        if ($count == 1)
            return true;
        else
            return false;
    }
}
