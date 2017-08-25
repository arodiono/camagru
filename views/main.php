<?php foreach ($posts as $item)
    {
        extract($item);
        include 'views/template/main_post.php';
    }
?>
