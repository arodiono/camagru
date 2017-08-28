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

    public function add()
    {
        $data['title'] = 'Upload new photo';
        $this->view->render('add_post', $data);
    }

    public function edit()
    {
        $image = new ImgModel();
        $img_id = $image->save();
        $data['title'] = 'Edit';
        $data['img_id'] = $img_id;
        $this->view->render('post_edit', $data);
    }
}