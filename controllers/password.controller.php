<?php

class PasswordController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->model = new passwordModel();
	}

	public function forgot()
	{
		$data['title'] = 'Forgot Password';
		$this->view->render('password_forgot', $data);
	}

	public function remind()
	{
		$result = $this->model->remindPassword();
		$this->view->renderNotification();
	}

	public function reset($data)
	{
        if ($data == null)
		{
			Session::add('errorMessage', 'Link is not valid');
			$this->view->renderNotification();
		}
		else
		{
			$valid = $this->model->validateMailAndHash($data[0], $data[1]);
			if ($valid)
			{
				$data['title'] = 'Reset Password';
				$this->view->render('password_reset', $data);
				Session::set('email', $data[0]);
			}
			else
			{
				Session::add('errorMessage', 'Link is not valid');
				$this->view->renderNotification();
			}
		}
	}

	public function update()
	{
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];

        if ($password !== $passwordConfirm)
        {
            Session::add('errorMessage', 'Passwords do not match');
            $this->view->renderNotification();
        }
        else
        {
            $reset = $this->model->resetPassword($_SESSION['email'], password_hash($password, PASSWORD_BCRYPT));
            if ($reset)
            {
                $this->view->renderNotification();
                header('HTTP/1.0 201');
            }
            else
            {
                $this->view->renderNotification();
            }
        }

	}
}
