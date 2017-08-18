<?php

class PostsModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function getLastPosts()
    {
        $request = "SELECT `posts`.`img_id`, `posts`.`description`, `posts`.`date`, `users`.`login`, `users`.`avatar`
                    FROM `users`
                    INNER JOIN `posts` ON `posts`.`user_id` = `users`.`user_id`
                    ORDER BY `post_id`
                    DESC LIMIT 10";
        $select = $this->database->prepare($request);
        $select->execute();
        return $select->fetchAll(2);
    }
}