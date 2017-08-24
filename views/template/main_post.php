<article class="post-box" id="post_<?=$item['post_id']?>">
    <div class="post-header">
        <a href="/<?=$item['login']?>"><img class="post-user-img" src="/uploads/<?= $item['login'] . '/' . $item['avatar'] . '.jpg' ?>" alt=""></a>
        <a class="post-username" href="/<?=$item['login']?>"><?=$item['login']?></a>
    </div>
    <div class="post-img-box">
        <img class="post-img" src="/uploads/<?= $item['login'] . '/' . $item['img_id'] . '.jpg' ?>" alt="">
    </div>
    <div class="post-footer">
        <div class="post-footer-actions">
            <i class="icon icon-heart red" onclick="setLike(<?=$item['post_id'] . PHP_EOL?>)"></i>
            <i class="icon icon-comment" onclick="setFocusInput(<?=$item['post_id'] . PHP_EOL?>)"></i>
            <i class="icon icon-paper-plane"></i>
        </div>
        <?php
        $like = $item['likes'] == 1 ? 'like' : 'likes';
        echo '<div class="post-likes"><p>' . $item['likes'] . ' ' . $like . '</p></div>' . PHP_EOL;
        ?>
    <div class="post-comments-block">
        <?php if (!empty($item['description'])): ?>
            <div class="post-comment">
                <p><span class="post-comment-username"><a href="/<?=$item['login']?>"><?=$item['login']?></a></span><?=trim($item['description'])?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($item['comments'])): ?>
        <? foreach ($item['comments'] as $comment): ?>
            <div class="post-comment">
                <p><span class="post-comment-username"><a href="/<?=$comment['login']?>"><?=$comment['login']?></a></span><?= trim($comment['text'])?></p>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
    </div>
    <div class="post-footer-form">
        <form class="comment-form" name="comment-post_<?=$item['post_id']?>" action="javascript:void(null);" onsubmit="sendComment(<?=$item['post_id']?>)">
            <input class="post-comment-input" type="text" name="comment" placeholder="Add a comment...">
        </form>
    </div>
</article>