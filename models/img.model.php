<?php

class ImgModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function save()
    {
        if (isset($_POST['img']))
        {
            $user_id = $_SESSION['user_id'];
            $path = 'uploads' . DIRECTORY_SEPARATOR . $_SESSION['username'] . DIRECTORY_SEPARATOR;
            $filename = hash('md5', uniqid(rand(), true));
            $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['img']));
            file_put_contents($path . $filename . '.png', $file);
            $request = "INSERT INTO `posts` (`user_id`, `img_id`)
                    VALUES (\"$user_id\", \"$filename\")";
            $insert = $this->database->prepare($request);
            $insert->execute();
            unset($_POST);
            return $filename;
        }
    }
}
