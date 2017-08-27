<?php

class ImgModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    static function save($img)
    {
        $user_id = $_SESSION['user_id'];
        $img_id = hash('md5', uniqid(rand(), true));

        $request = "INSERT INTO `posts` (`user_id`, `img_id`)
                    VALUES (\"$user_id\", \"$img_id\")";
        $insert = self::$database->prepare($request);
        if ($insert->execute())
        {
            
        }

    }
}