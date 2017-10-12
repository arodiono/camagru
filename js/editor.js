var video       = document.querySelector('video');
var canvas      = document.querySelector('canvas');
var upload      = document.querySelector('.post-upload');
var controls    = document.querySelector('.controls');
var drop        = document.querySelectorAll('.droppable');
var dragg       = document.querySelector('.draggable');

function editor() {
    controls.style.display = 'flex';
    dragg.style.display = 'block';

    for (var i = 0; i < drop.length; i++) {
        drop[i].addEventListener('click', add);
    }
}
function add(e) {
    var btn     = document.querySelector('button') || document.createElement('button');
    var input   = document.querySelector('input') || document.createElement('input');
    var newNode = e.target.cloneNode();

    newNode.classList.remove('droppable');
    newNode.style.cursor = 'move';
    newNode.style.position = 'absolute';
    newNode.style.top = '0px';
    newNode.style.left = '0px';
    newNode.addEventListener('mousedown', drag);
    newNode.addEventListener('touchstart', drag);
    newNode.addEventListener('contextmenu', remove);
    dragg.appendChild(newNode);
    btn.classList.add('next', 'center-block');
    btn.innerHTML = 'Share';
    document.querySelector('.content').appendChild(btn);
    btn.addEventListener('click', send);
}
function remove(e) {
    e.preventDefault();
    e.target.remove();
    if (document.querySelector('button').childElementCount === 0) {
        document.querySelector('button').remove();
    }
}
function drag(e) {
    var coords = getCoords(e.target);
    var shiftX = e.pageX - coords.left;
    var shiftY = e.pageY - coords.top;

    e.target.style.cursor = 'none';
    e.target.style.position = 'absolute';
    e.target.style.zIndex = 1000;
    dragg.appendChild(e.target);

    function getCoords(elem) {
        var box = elem.getBoundingClientRect();
        return {
            top: box.top + pageYOffset,
            left: box.left + pageXOffset
        };
    }
    function moveAt(e) {
        e.target.style.left = e.pageX - dragg.getBoundingClientRect().left - shiftX  + 'px';
        e.target.style.top = e.pageY - dragg.getBoundingClientRect().top - shiftY + 'px';
    }
    e.target.onmousemove = function(e) {
        moveAt(e);
    };
    e.target.ontouchmove = function(e) {
        moveAt(e);
    };
    document.ontouchend = function() {
        e.target.style.cursor = 'move';
        e.target.onmousemove = null;
        e.onmouseup = null;
    };
    document.onmouseup = function() {
        e.target.style.cursor = 'move';
        e.target.onmousemove = null;
        e.onmouseup = null;
    };
    e.target.ondragstart = function() {
        return false;
    };
}
(function() {
    function takeSnapshot() {
        var img = document.createElement('img');
        var context;
        var width = video.offsetWidth;
        var height = video.offsetHeight;;

        canvas = canvas || document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;
        context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, width, height);
        img.src = canvas.toDataURL('image/png', 1.0);
        img.classList.add('context');
        video.parentNode.insertBefore(img, video.parentNode.firstChild);
        video.pause();
        video.src="";
        video.remove();
        upload.remove();
        editor();
    }
    if (navigator.mediaDevices) {
        navigator.mediaDevices.getUserMedia({video: true})
            .then(function(stream) {
                video.src = window.URL.createObjectURL(stream);
                video.addEventListener('click', takeSnapshot);
            })
            .catch(function(error) {
                var content = document.querySelector('.content');
                var div = document.createElement('div');
                div.classList.add('text-center');
                div.innerHTML = 'Could not access the camera. Error: ' + error.name;
                content.insertBefore(div, content.firstChild);
                video.style.display = 'none';
            });
    }
})();
(function(window) {
    function triggerCallback(e, callback) {
        if(!callback || typeof callback !== 'function') {
            return;
        }
        var files;
        if(e.dataTransfer) {
            files = e.dataTransfer.files;
        } else if(e.target) {
            files = e.target.files;
        }
        callback.call(null, files);
    }
    function makeDroppable(ele, callback) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', '.png, .jpg, .jpeg');
        input.style.display = 'none';
        input.addEventListener('change', function(e) {
            triggerCallback(e, callback);
        });
        ele.appendChild(input);

        ele.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            ele.classList.add('dragover');
        });

        ele.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            ele.classList.remove('dragover');
        });

        ele.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            ele.classList.remove('dragover');
            triggerCallback(e, callback);
        });

        ele.addEventListener('click', function() {
            input.value = null;
            input.click();
        });
    }
    window.makeDroppable = makeDroppable;
})(this);
(function(window) {
    makeDroppable(window.document.querySelector('.post-upload'), function(files) {
        var reader = new FileReader;
        var video = document.querySelector('video');
        var img = document.createElement('img');

        reader.readAsDataURL(files[0]);
        reader.onloadend = function () {
            img.src = reader.result;
            img.classList.add('context');
            video.parentNode.insertBefore(img, video.parentNode.firstChild);
            video.pause();
            video.src="";
            video.remove();
            editor();
            upload.remove();
        };
    });
})(this);
function send() {
    var ajax = new XMLHttpRequest();
    var data = new FormData;

    data.append('img', addStickersToImage());
    data.append('caption', document.querySelector('input').value);
    ajax.open('POST', '/post/add', true);
    ajax.send(data);
    ajax.onreadystatechange = function() {
        if (this.readyState === 4) {
            window.location.pathname = '/';
        }
    }
}
function addStickersToImage() {
    var img         = document.querySelector('.context');
    var stickers    = dragg.childNodes;
    var canvas      = document.createElement('canvas');
    var context;

    canvas.width = img.offsetWidth;
    canvas.height = img.offsetHeight;
    context = canvas.getContext('2d');
    context.drawImage(img, 0, 0, img.offsetWidth, img.offsetHeight);

    for (var i = 0; i < stickers.length; i++) {
        context.drawImage(stickers[i], parseInt(stickers[i].style.left), parseInt(stickers[i].style.top));
    }
    return canvas.toDataURL('image/png', 1.0);
}