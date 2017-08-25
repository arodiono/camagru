<?php extract($user) ?>
<div class="user-config">
    <div class="profile-img center-block">
        <?php if($_SESSION['avatar'] != null): ?>
        <img src="/uploads/<?=$_SESSION['username']?>/<?=$_SESSION['avatar']?>.jpg" alt="">
        <?php else: ?>
        <img src="/img/default-user-image.png" alt="">
        <?php endif; ?>
        <a class="center-block" href="">Change photo</a>
    </div>
    <form class="user-config-form" action="javascript:void(null);">
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
        <button class="btn btn-default" type="submit">Done</button>
    </form>
    <a class="btn btn-default" href="/password/reset/<?=$email?>/<?=$hash?>">Change pass</a>

</div>