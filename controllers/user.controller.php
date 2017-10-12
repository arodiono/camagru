<?php

class UserController extends Controller
{
    protected $user_id;
    protected $username;
    protected $fullname;
    protected $biography;

	public function __construct()
	{
		parent::__construct();
		$this->model = new UserModel();
	}

	public function index($username = null, $post_id = null)
	{
	    if ($post_id == null)
        {
            if ($username === null) {
                $username = $_SESSION['username'];
            }
            if ($username === null) {
                header('Location: login');
            }
            $data['title'] = $username;
            $data['user'] = $this->model->getUserDataFromName($username);
            $data['posts'] = $this->model->getUserPosts($username);
            $this->view->render('user_page', $data);
        }
        else
        {
            $post = new PostsModel();

            if (!($data['post'] = $post->getPost($post_id)))
            {
                $error = new ErrorController();
                $error->error404();
                return;
            }
            $data['title'] = '@' . $username . ' | ' . $data['post'][0]['caption'];
            $this->view->render('post', $data);
        }
	}

	public function config()
    {
        if (!Session::isLoggedOnUser()) {
            header('Location: /login');
        }
        $data['user'] = $this->model->getUserDataFromName($_SESSION['username']);
        $data['title'] = 'Edit profile';
        $this->view->render('user_config', $data);
    }

    public function edit()
    {
        if (empty($_POST)) {
            return;
        }
        $this->user_id = $_SESSION['user_id'];
        $this->fullname = $_POST['fullname'];
        $this->biography = $_POST['biography'];

        $result = $this->model->editUser($this->user_id, $this->fullname, $this->biography);
        if ($result)
            echo '<div class="alert alert-success">User data updated successfully</div>';
        else
            echo '<div class="alert alert-danger">User data not updated</div>';
        unset($_POST);
    }

    public function changePhoto()
    {
        if (empty($_POST)) {
            return;
        }
        $file = $_POST['img'];
        $image = new ImgModel();
        $filename = $image->save($file);
        $user_id   = $_SESSION['user_id'];
        $this->model->editProfilePicture($user_id, $filename);
        header('Location: config');
    }

	public function activate($data)
	{
		$activate = $this->model->activateUser($data);
		$this->view->renderNotification();
		if ($activate)
		    header('Location: /');
	}

	public function delete()
    {
        $this->model->deleteUser();
    }
}
