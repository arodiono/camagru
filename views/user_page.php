<header class="profile">
    <div class="col-4 profile-img">
        <?php if($user['avatar'] !== null): ?>
        <img src="/uploads/<?=$user['login']?>/<?=$user['avatar']?>.jpg" alt="">
        <?php else: ?>
        <img src="/img/default-user-image.png" alt="">
        <?php endif; ?>
    </div>
    <div class="col-6 profile-info">
        <p>@<?=$user['login']?></p>
        <p><?=$user['fullname']?></p>
        <p><?=$user['description']?></p>
    </div>
<!--    --><?php //if (Session::isLoggedOnUser() && $user['login'] === $_SESSION['username']):?>
<!--        <a href="/user/config"><i class="icon icon-cog"></i></a>-->
<!--    --><?php //endif; ?>
</header>
<div class="profile-posts">
<?php
    foreach ($posts as $post)
    {
        extract($post);
        include 'views/template/profile_post.php';
    }
?>
</div>
