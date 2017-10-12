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
        $posts = new PostsModel();
        $data['posts'] = $posts->getLastPosts(0);
        $this->view->render('main', $data);
        echo "<script type=\"text/javascript\" src=\"/js/infinite-scroll.js\"></script>";
	}

	public function getPosts()
    {
        $offset = intval($_POST['offset']);
        $posts = new PostsModel();
        $data['posts'] = $posts->getLastPosts($offset);
        if (!empty($data['posts']))
        {
            ob_start();
            $this->view->renderNoTemplate('main', $data);
            echo ob_get_contents();
        }
    }
}
