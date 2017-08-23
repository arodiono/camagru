<?php

class UserController extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->model = new UserModel();
	}

	public function index($username = null)
	{
	    if ($username === null)
	        $username = $_SESSION['username'];
	    $data['user'] = $this->model->getUserData($username);
	    $data['posts'] = $this->model->getUserPosts($username);
        $this->view->render('user_page', $data);
	}

	public function activate($data)
	{
		$activate = $this->model->activateUser($data);
		$this->view->renderNotification();
	}

}
