<div class="content">
    <video autoplay></video>
    <div class="post-upload">
        <p>Drag file here or click to upload</p>
    </div>
    <div class="output"></div>

    <div class="modal">
        <div class="modal-content">
            <canvas class="canvas"></canvas>
            <div class="modal-actions">
                <a href="#" class="exit">< Cancel</a>
                <a href="#" class="next">Next ></a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        (function() {
            var video = document.querySelector('video');
            var canvas = document.querySelector('canvas');
            var modal = document.querySelector('.modal');

            function takeSnapshot() {
                var img = document.querySelector('img') || document.createElement('img');
                var context;
                var width = video.offsetWidth;
                var height = video.offsetHeight;
                var exit = document.querySelector('.exit');
                var next = document.querySelector('.next');

                canvas = canvas || document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;

                context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, width, height);

                img.src = canvas.toDataURL('image/png');
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
                exit.onclick = function() {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                };
                next.onclick = function () {
                    var ajax = new XMLHttpRequest();
                    var data = new FormData();
                    data.append('img', img.src);
                    ajax.open('POST', '/post/edit', false);
                    ajax.send(data);
                    ajax.onreadystatechange = function () {
                        if (ajax.status == 4)
                        {
                            console.log('ok');
                        }
                    }
                };
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
                console.log(files);
                var output = document.querySelector('.output');
                output.innerHTML = '';
                    if(files[0].type.indexOf('image/') === 0) {
                        output.innerHTML += '<img width="200" src="' + URL.createObjectURL(files[0]) + '" />';
                    }
                    output.innerHTML += '<p>'+files[0].name+'</p>';
            });
        })(this);
    </script>
</div>