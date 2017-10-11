<?php

class ImgModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function save($src)
    {
        $file       = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $src));
        $filename   = hash('md5', uniqid(rand(), true));
        $path       = 'uploads' . DIRECTORY_SEPARATOR . $_SESSION['username'] . DIRECTORY_SEPARATOR;

        if (!is_dir($path))
            mkdir($path);

        $img = $this->cropToFit(imagecreatefromstring($file));
        imagepng($img, $path . $filename .'.png', 0);

        $thumb = $this->cropToSquare($img);
        imagepng($thumb, $path . $filename .'_thumb.png', 0);

        return $filename;
    }

    public static function delete($username, $filename)
    {
        unlink('uploads' . DIRECTORY_SEPARATOR . $username . DIRECTORY_SEPARATOR . $filename . '.png');
        unlink('uploads' . DIRECTORY_SEPARATOR . $username . DIRECTORY_SEPARATOR . $filename . '_thumb.png');
    }

    public static function delTree($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    private function cropToFit($img)
    {
        $x = imagesx($img);
        $y = imagesy($img);
        $ratio = $x / $y;
        if($ratio > 1) {
            $x = 568;
            $y = 568 / $ratio;
        }
        else {
            $x = 1000 * $ratio;
            $y = 1000;
        }
        return imagescale($img, $x, $y);
    }

    private function cropToSquare($img)
    {
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
        return imagescale(imagecrop($img, $rect), 200);

    }
}