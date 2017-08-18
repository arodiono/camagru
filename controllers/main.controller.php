<?php

class MainController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        $data['title'] = 'Camagru';

        if (Session::isLoggedOnUser())
		{
		    $posts = new PostsModel();
            $data['posts'] = $posts->getLastPosts();
			$this->view->render('main', $data);
		}
		else
		{
//		    $data['header'] = 'Sign up to see photos from your friends';
            $this->view->renderNoTemplate('registration', $data);

//            header('Location: //' . $_SERVER['HTTP_HOST'] . '/login');
        }

	}
}
