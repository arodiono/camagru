<?php

class ImgModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function save($img)
    {
        $file       = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
        $filename   = hash('md5', uniqid(rand(), true));
        $path       = 'uploads' . DIRECTORY_SEPARATOR . $_SESSION['username'] . DIRECTORY_SEPARATOR;

        if (!is_dir($path))
            mkdir($path);
        file_put_contents($path . $filename . '.png', $file);

        return $filename;
    }
}