<video style="width: 100%;"></video>
<script>
    'use strict';
    var constraints = { audio: false, video: { width: 600, height: 600 } };

    navigator.mediaDevices.getUserMedia(constraints).then(function(mediaStream) {
            var video = document.querySelector('video');
            video.srcObject = mediaStream;
            video.onloadedmetadata = function(e) {
                video.play();
            };
        })
        .catch(function(err) { console.log(err.name + ": " + err.message); });

    var capture = function() {

        if (!mediaStream) {
            return;
        }

        var video = document.querySelector('video');
        var canvas      = document.getElementById('canvasTag');
        canvas.removeEventListener('click', savePhoto);
        var videoWidth  = video.videoWidth;
        var videoHeight = video.videoHeight;

        if (canvas.width !== videoWidth || canvas.height !== videoHeight) {
            canvas.width  = videoWidth;
            canvas.height = videoHeight;
        }

        var ctx    = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
        photoReady = true;
        document.getElementById('photoViewText').innerHTML = 'Click or tap below to save as .jpg';
        canvas.addEventListener('click', savePhoto);

    };
</script>