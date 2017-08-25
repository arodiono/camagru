<?php

class UserController extends Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->model = new UserModel();
	}

	public function index($username = null, $post_id = null)
	{

	    if ($post_id == null)
        {
            if ($username === null)
                $username = $_SESSION['username'];
            $data['title'] = $username;
            $data['user'] = $this->model->getUserData($username);
            $data['posts'] = $this->model->getUserPosts($username);
            $this->view->render('user_page', $data);
        }
        else
        {
            $post = new PostsModel();
            $data['post'] = $post->getPost($post_id);
            $data['title'] = '@' . $username . ' | ' . $data['post'][0]['description'];
            $this->view->render('post', $data);
        }
	}

	public function config()
    {
        $data['user'] = $this->model->getUserData($_SESSION['username']);
        $data['title'] = 'Edit profile';
        $this->view->render('user_config', $data);
    }

	public function activate($data)
	{
		$activate = $this->model->activateUser($data);
		$this->view->renderNotification();
	}

}
