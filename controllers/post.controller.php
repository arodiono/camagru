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
        $result = $this->model->prepareLike();
        echo json_encode($result);
    }

    public function comment()
    {
        $result = $this->model->addComment();
        echo json_encode($result);
    }

//    public function create()
//    {
//        $data['title'] = 'Upload new photo';
//        $this->view->render('add_post', $data);
//    }

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

//    public function edit()
//    {
//        if (empty($_POST))
//            return;
//
//        $file       = $_POST['img'];
//        $image      = new ImgModel();
//        $filename   = $image->save($file);
//        $this->model->addPost($filename);
//
//        $data['title']  = 'Edit';
//        $data['img_id'] = $filename;
//        $this->view->render('post_edit', $data);
//    }
}