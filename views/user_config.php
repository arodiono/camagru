<?php extract($user) ?>
<div class="content">
<div class="user-config">
    <div class="profile-img center-block">
        <?php if($_SESSION['avatar'] != null): ?>
        <img src="/uploads/<?=$_SESSION['username']?>/<?=$_SESSION['avatar']?>.jpg" alt="">
        <?php else: ?>
        <img src="/img/default-user-image.png" alt="">
        <?php endif; ?>
        <a class="center-block" href="">Change photo</a>
    </div>
    <div class="user-config-form">
    <form action="javascript:void(null);">
        <div class="form-group">
            <label for="login">Username</label>
            <input class="form-control" name="login" type="text" disabled placeholder="<?=$login?>">
        </div>
        <div class="form-group">
            <label for="fullname">Fullname</label>
            <input class="form-control" name="fullname" type="text" placeholder="<?=$fullname?>">
        </div>
        <div class="form-group">
            <label for="fullname">Bio</label>
            <input class="form-control" name="description" type="text" placeholder="<?=$description?>">
        </div>
        <button class="btn btn-default  btn-inline" type="submit">Done</button>
    </form>

    <div class="user-config-actions">
        <a class="btn btn-default btn-inline" href="/password/reset/<?=$email?>/<?=$hash?>">Change password</a>
        <form action="javascript:void(null);">
            <button class="btn btn-default btn-inline">Delete profile</button>
        </form>
    </div>
    </div>
</div>
</div>