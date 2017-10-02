var offset = 0;
window.onscroll = function() {
    var body        = document.body;
    var html        = document.documentElement;
    var scrolled    = window.pageYOffset || document.documentElement.scrollTop;
    var height      = Math.max( body.scrollHeight, body.offsetHeight,
                        html.clientHeight, html.scrollHeight, html.offsetHeight );
    if (scrolled >= (height - document.documentElement.clientHeight)) {
        getPosts(window.offset += 10);
    }
};