<?php

class PostController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new PostsModel();
    }

    public function index()
    {
        if (!Session::isLoggedOnUser())
            header('Location: login');
        $data['title'] = 'Upload new photo';
        $this->view->render('add_post', $data);
    }

    public function like()
    {
        if (!Session::isLoggedOnUser())
            header('HTTP/1.1 401 Unauthorized');
        $result = $this->model->prepareLike();
        echo json_encode($result);
    }

    public function comment()
    {
        if (!Session::isLoggedOnUser())
            header('HTTP/1.1 401 Unauthorized');
        $result = $this->model->addComment();
        echo json_encode($result);
    }

    public function add()
    {
        if (!Session::isLoggedOnUser())
            header('Location: /login');
        if (empty($_POST))
            return;

        $file       = $_POST['img'];
        $caption    = $_POST['caption'];
        $image      = new ImgModel();
        $filename   = $image->save($file);
        $this->model->addPost($filename, $caption);
    }

    public function delete()
    {

        if (!Session::isLoggedOnUser()){
            header('HTTP/1.1 401 Unauthorized');
            return;
        }
        if (empty($_POST))
            return;

        $post_id = $_POST['post_id'];

        if ($this->model->deletePost($post_id))
        {
            header('HTTP/1.1 200 OK');

        }
        else {
            header('HTTP/1.1 401 Unauthorized');

        }
    }

}