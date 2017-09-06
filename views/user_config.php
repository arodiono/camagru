<?php extract($user); ?>
<div class="content">
<div class="user-config">
    <form method="post" class="photoUpload" action="/user/changePhoto">
        <div class="profile-img center-block upload">
            <?php if($profile_picture != null): ?>
            <img src="/uploads/<?=$username?>/<?=$profile_picture?>.png" alt="">
            <?php else: ?>
            <img src="/img/default-user-image.png" alt="">
            <?php endif; ?>
            <div class="profile-img-text text-center">Click here to change photo</div>
            <input name="img" class="input" hidden>
        </div>
    </form>
    <div class="user-config-form">
    <form action="javascript:void(null);" name="edit">
        <div class="form-group">
            <label for="login">Username</label>
            <input class="form-control" name="username" type="text" disabled value="<?=$username?>">
        </div>
        <div class="form-group">
            <label for="fullname">Fullname</label>
            <input class="form-control" name="fullname" type="text" value="<?=$fullname?>">
        </div>
        <div class="form-group">
            <label for="fullname">Bio</label>
            <input class="form-control" name="biography" type="text" value="<?=$biography?>">
        </div>
        <button class="btn btn-default  btn-inline" type="submit">Done</button>
    </form>
        <div class="user-config-actions">
            <a class="btn btn-default btn-inline" href="/password/reset/<?=$email?>/<?=$hash?>">Change password</a>
            <form action="javascript:void(null);">
                <button class="btn btn-default btn-inline">Delete profile</button>
            </form>
        </div>
        <script type="text/javascript">
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
                makeDroppable(window.document.querySelector('.upload'), function(files) {
                    var reader = new FileReader;
                    reader.readAsDataURL(files[0]);
                    reader.onloadend = function () {
                        var form = document.querySelector('.photoUpload');
                        var input = document.querySelector('.input');
                        input.value = reader.result;
                        form.submit();
                    };
                });
            })(this);


            document.forms.edit.addEventListener('submit', function () {
                removeAlert();
                var ajax = new XMLHttpRequest();
                ajax.open('POST', '/user/edit', true);
                ajax.send(new FormData(this));
                ajax.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        renderAlert(this.responseText);
                    }
                }
            }, true);
            function renderAlert(body) {
                var div = document.createElement('div');
                var container = document.querySelector(".user-config-form");
                div.innerHTML = body;
                container.insertBefore(div, container.firstChild);
            }
            function removeAlert() {
                var alert = document.querySelector(".alert");
                if (alert)
                    alert.remove();
            }
        </script>

    </div>
</div>
</div>