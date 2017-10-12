<div class="content">
    <div class="modal-actions">
        <a href="#" class="exit">< Cancel</a>
        <a href="#" class="next">Next ></a>
    </div>
    <div class="post-edit">
        <img src="/uploads/<?=$_SESSION['username']?>/<?=$img_id?>.png">
        <div class="active-canvas"></div>
    </div>
    <div class="controls">
        <img class="droppable" src="/img/stickers/alien.png" alt="">
        <img class="droppable" src="/img/stickers/bear.png" alt="">
        <img class="droppable" src="/img/stickers/glasses.png" alt="">
        <img class="droppable" src="/img/stickers/hipster.png" alt="">
        <img class="droppable" src="/img/stickers/koko.png" alt="">
        <img class="droppable" src="/img/stickers/swift.png" alt="">
        <img class="droppable" src="/img/stickers/zzz.png" alt="">
    </div>
</div>
<script type="text/javascript">
    var a = document.querySelector('.controls');
    var c = document.querySelector('.active-canvas');
    var d = document.querySelectorAll('.droppable');

    window.onload = function () {
        a.addEventListener('click', function (e) {
            document.querySelector('.active-canvas').appendChild(e.target);
        });
        for (var i = 0; i < d.length; i++) {
            d[i].addEventListener('mousedown', drag);
        }
    };
    function drag(e) {
        var coords = getCoords(e.target);
        var shiftX = e.pageX - coords.left;
        var shiftY = e.pageY - coords.top;

        e.target.style.cursor = 'none';
        e.target.style.position = 'absolute';
        e.target.style.zIndex = 1000;
        c.appendChild(e.target);

        function getCoords(elem) {
            var box = elem.getBoundingClientRect();
            return {
                top: box.top + pageYOffset,
                left: box.left + pageXOffset
            };

        }
        function moveAt(e) {
            e.target.style.left = e.pageX - c.getBoundingClientRect().left - shiftX  + 'px';
            e.target.style.top = e.pageY - c.getBoundingClientRect().top - shiftY + 'px';
        }
        document.onmousemove = function(e) {
            moveAt(e);
        };
        document.onmouseup = function() {
            e.target.style.cursor = 'move';
            document.onmousemove = null;
            e.onmouseup = null;
        };
        e.target.ondragstart = function() {
            return false;
        };
    }
</script>