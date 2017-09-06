<div class="content">

<?php
if (!empty($posts))
{
    foreach ($posts as $item)
    {
        extract($item);
        include 'views/template/main_post.php';
    }
}

?>
</div>
