<div class="content">
<div class="profile">
    <div class="row">
    <div class="profile-img">
        <?php if($user['profile_picture'] !== null): ?>
        <img src="/uploads/<?=$user['username']?>/<?=$user['profile_picture']?>.png" alt="">
        <?php else: ?>
        <img src="/img/default-user-image.png" alt="">
        <?php endif; ?>
    </div>
    <div class="profile-info">
        <div class="profile-username">@<?=$user['username']?></div>
        <div class="profile-counters">
            <div class="posts"><span>99</span><br>posts</div>
            <div class="followers"><span>12</span><br>followers</div>
            <div class="following"><span>45</span><br>following</div>
        </div>
        <button class="btn btn-default btn-inline">Follow</button>

    </div>
    </div>
    <div class="row">

        <div class="profile-fullname"><?=$user['fullname']?></div>
        <div class="profile-biography"><?=$user['biography']?></div>
    </div>
</div>
<div class="profile-posts">
<?php
    if (!empty($posts))
    {
        foreach ($posts as $post)
        {
                extract($post);
                include 'views/template/profile_post.php';
        }
    }
    else
    {
        echo "User has not uploaded any photos yet";
    }

?>
</div>
