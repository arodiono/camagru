"use strict";
function setLike(post_id)
{
    var data = new FormData();
    data.append('post_id', post_id);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/post/like', true);
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
    xhr.open('POST', '/post/comment', true);
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
