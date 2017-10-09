<article class="post-box" id="post_<?=$post_id?>">
    <div class="post-header">
        <?php if($profile_picture !== null):?>
        <a href="/<?php $username?>"><img class="post-user-img" src="/uploads/<?php echo $username . '/' . $profile_picture . '.png' ?>" alt=""></a>
        <?php else:?>
        <a href="/<?=$username?>"><img class="post-user-img" src="/img/default-user-image.png" alt=""></a>
        <?php endif;?>
        <a class="post-username" href="/<?=$username?>"><?=$username?></a>
    </div>
    <div class="post-img-box">
        <img class="post-img" src="/uploads/<?=$username . '/' . $thumbnail . '.png' ?>" alt="">
    </div>
    <div class="post-footer">
        <div class="post-footer-actions">
            <i class="icon icon-heart red" onclick="setLike(<?=$post_id?>)"></i>
            <i class="icon icon-comment" onclick="setFocusInput(<?=$post_id?>)"></i>
            <i class="icon icon-paper-plane"></i>
        </div>
        <?php
        $like = $count == 1 ? 'like' : 'likes';
        echo '<div class="post-likes"><p>' . $count . ' ' . $like . '</p></div>' . PHP_EOL;
        ?>
    <div class="post-comments-block">
        <?php if (!empty($caption)): ?>
            <div class="post-comment">
                <p><span class="post-comment-username"><a href="/<?=$username?>"><?=$username?></a></span><?=trim($caption)?></p>
            </div>
        <?php endif; ?>
        <?php
        if (!empty($comments)){
            foreach ($comments as $comment){?>
            <div class="post-comment">
                <p><span class="post-comment-username"><a href="/<?=$comment['username']?>"><?=$comment['username']?></a></span><?= trim($comment['text'])?></p>
            </div>
        <?php }}?>
    </div>
    </div>
    <div class="post-footer-form">
        <form class="post-comment-form" name="comment-post_<?=$post_id?>" action="javascript:void(null);" onsubmit="sendComment(<?=$post_id?>)">
            <input class="post-comment-input" type="text" name="text" placeholder="Add a comment...">
            <button class="post-comment-btn" type="submit">Send</button>
        </form>
    </div>
</article>