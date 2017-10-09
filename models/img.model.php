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

        $img = imagecreatefrompng($path . $filename . '.png');
        $x = imagesx($img);
        $y = imagesy($img);
        $size = min($x, $y);
        $rect = [
            'x' => 0,
            'y' => 0,
            'width' => $size,
            'height' => $size
        ];
        if ($size === $y) {
            $rect['x'] = ($x - $size) / 2;
        }
        else {
            $rect['y'] = ($y - $size) / 2;
        }
        $im2 = imagescale(imagecrop($img, $rect), 200);
        if ($im2 !== FALSE) {
            imagepng($im2, $path . $filename . '_thumb.png');
        }
        return $filename;
    }
}