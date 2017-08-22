<?php
    foreach ($posts as $item)
    {
?>
        <article class="post-box" id="post_<?=$item['post_id']?>">
            <div class="post-header">
                <a href="/user/<?=$item['login']?>"><img class="post-user-img" src="/uploads/<?= $item['login'] . '/' . $item['avatar'] . '.jpg' ?>" alt=""></a>
                <a class="post-username" href="/user/<?=$item['login']?>"><?=$item['login']?></a>
            </div>
            <div class="post-img-box">
                <img class="post-img" src="/uploads/<?= $item['login'] . '/' . $item['img_id'] . '.jpg' ?>" alt="">
            </div>
            <div class="post-footer">
                <div class="post-footer-actions">
                    <i class="icon icon-heart red" onclick="setLike(<?=$item['post_id']?>)"></i>
                    <i class="icon icon-comment" onclick="setFocusInput(<?=$item['post_id']?>)"></i>
                    <i class="icon icon-paper-plane"></i>
                </div>
                <?php
                    $like = $item['likes'] == 1 ? 'like' : 'likes';
//                    if ($item['likes'] > 0)
                        echo '<div class="post-likes"><p>' . $item['likes'] . ' ' . $like . '</p></div>' . PHP_EOL;
                ?>
                <?php
                    if (!empty($item['description'])){
                ?>
                <div class="post-comments-block">
                    <div class="post-comment">
                        <p><span class="post-comment-username"><?=$item['login']?></span><?=trim($item['description'])?></p>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="post-footer-form">
                <form class="comment-form" name="comment-post_<?=$item['post_id']?>" action="javascript:void(null);" onsubmit="sendComment(<?=$item['post_id']?>)">
                    <input class="post-comment-input" type="text" name="comment" placeholder="Add a comment...">
                </form>
            </div>
        </article>
<?php
    }
?>
<script>
    "use strict";
    function setLike(post_id)
    {
        var data = new FormData();
        data.append('post_id', post_id);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'post/like', true);
        xhr.send(data);
        xhr.onreadystatechange = function()
        {
            if (this.readyState == 4)
            {
                var likes = JSON.parse(xhr.responseText);
                var text = likes == 1 ? 'like' : 'likes';
                var post = document.querySelector('#post_' + post_id + ' .post-likes p');
                post.innerHTML = likes + ' ' + text;
            }
        }
    }
    function sendComment(post_id)
    {
        var form = document.forms['comment-post_' + post_id];
        var data = new FormData(form);
        if (!data.get('comment'))
        {
            unsetFocusInput();
            return;
        }
        var xhr = new XMLHttpRequest();
        data.append('post_id', post_id);
        xhr.open('POST', 'post/comment', true);
        xhr.send(data);
        xhr.onreadystatechange = function()
        {
            if (this.readyState == 4)
            {
                var post = document.querySelector('#post_' + post_id + ' .post-comments-block');
                var comment = JSON.parse(xhr.responseText);
                var div = document.createElement('div');
                div.className = 'post-comment';
                div.innerHTML = "<p><span class=\"post-comment-username\">" + comment.author + "</span>" + comment.comment + "</p>";
                post.appendChild(div);
            }
        };
        unsetFocusInput();
        form.reset();
    }
    function setFocusInput(post_id)
    {
        var input = document.querySelector('#post_' + post_id + ' input');
        input.focus();
    }
    function unsetFocusInput() {
        var input = document.activeElement;
        input.blur();
    }
</script>