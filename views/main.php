<?php
    foreach ($posts as $item)
    {
?>
        <article class="post-box">
            <div class="post-header">
                <a href="/user/<?=$item['login']?>"><img class="post-user-img" src="/uploads/<?= $item['login'] . '/' . $item['avatar'] . '.jpg' ?>" alt=""></a>
                <p class="post-username"><?=$item['login']?></p>
            </div>
            <div class="post-img-box">
                <img class="post-img" src="/uploads/<?= $item['login'] . '/' . $item['img_id'] . '.jpg' ?>" alt="">
            </div>
            <div class="post-footer">
                <div class="post-footer-actions">
                    <div class="set-like"></div>
                    <div class="set-comment"></div>
                </div>
                <?php
                    if (!empty($item['description'])){
                ?>
                        <div class="post-comment">
                            <p class="post-comment-username"><?=$item['login']?></p>
                            <p><?=trim($item['description'])?></p>
                        </div>
                        <?php
                    }
                ?>
            </div>
            <div class="post-footer-form">
                <form class="comment-form">
                    <input class="post-comment-input" type="text" name="comment" placeholder="Add a comment...">
                </form>
            </div>
        </article>
<?php
    }
?>



