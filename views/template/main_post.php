<article class="post-box" id="post_<?=$post_id?>">
    <div class="post-header">
        <?php if($avatar !== null):?>
        <a href="/<?php $login?>"><img class="post-user-img" src="/uploads/<?php echo $login . '/' . $avatar . '.jpg' ?>" alt=""></a>
        <?php else:?>
        <a href="/<?=$login?>"><img class="post-user-img" src="/img/default-user-image.png" alt=""></a>
        <?php endif;?>
        <a class="post-username" href="/<?=$login?>"><?=$login?></a>
    </div>
    <div class="post-img-box">
        <img class="post-img" src="/uploads/<?=$login . '/' . $img_id . '.jpg' ?>" alt="">
    </div>
    <div class="post-footer">
        <div class="post-footer-actions">
            <i class="icon icon-heart red" onclick="setLike(<?=$post_id . PHP_EOL?>)"></i>
            <i class="icon icon-comment" onclick="setFocusInput(<?=$post_id . PHP_EOL?>)"></i>
            <i class="icon icon-paper-plane"></i>
        </div>
        <?php
        $like = $likes == 1 ? 'like' : 'likes';
        echo '<div class="post-likes"><p>' . $likes . ' ' . $like . '</p></div>' . PHP_EOL;
        ?>
    <div class="post-comments-block">
        <?php if (!empty($description)): ?>
            <div class="post-comment">
                <p><span class="post-comment-username"><a href="/<?=$login?>"><?=$login?></a></span><?=trim($description)?></p>
            </div>
        <?php endif; ?>
        <?php
        if (!empty($comments)){
            foreach ($comments as $comment){?>
            <div class="post-comment">
                <p><span class="post-comment-username"><a href="/<?=$comment['login']?>"><?=$comment['login']?></a></span><?= trim($comment['text'])?></p>
            </div>
        <?php }}?>
    </div>
    </div>
    <div class="post-footer-form">
        <form class="comment-form" name="comment-post_<?=$post_id?>" action="javascript:void(null);" onsubmit="sendComment(<?=$post_id?>)">
            <input class="post-comment-input" type="text" name="comment" placeholder="Add a comment...">
        </form>
    </div>
</article>