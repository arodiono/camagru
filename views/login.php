<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?='//' . $_SERVER['HTTP_HOST'] . '/' ?>css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Cookie|Raleway:300" rel="stylesheet">
    <title><?=$title ?></title>
</head>
<body>
<div class="container">
    <div class="form-box">
        <h1 class="header-logo text-center">Camagram</h1>
        <div class="form">
            <form name="login">
                <div class="form-group">
                    <input id="email" class="form-control" type="email" name="email" placeholder="Email" autofocus>
                </div>
                <div class="form-group">
                    <input id="password" class="form-control" type="password" name="password" placeholder="Password">
                </div>
                <input type="submit" class="btn btn-gradient btn-inline"  value="Log in">
            </form>

            <div class="form-box-footer">
                <a href="/password/forgot"><p class="text-center">Forgot password?</p></a>
                <p class="text-center">Don`t have an account?</p>
                <a class="btn btn-default btn-inline" href="/signup">Sign up</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    'use strict';
    var form = document.querySelector('form');
    form.addEventListener('submit', sendRequest);
    form.lastChild.addEventListener('click', sendRequest);
    function sendRequest(e)
    {
        e.preventDefault();
        removeAlert();
        var request = new XMLHttpRequest();
        var data = new FormData(e.target);
        var message = "<div class=\"alert alert-danger\"><strong>Warning! </strong> All fields must not be empty</div>";
        if (!data.get("email") || !data.get("password")) {
            renderAlert(message);
            return;
        }
        request.open('POST', 'login/login', true);
        request.send(data);
        request.onreadystatechange = function() {
            if (this.readyState !== 4)
                return;
            if (this.status !== 200 && this.status !== 201) {
                renderAlert( 'Error: ' + (this.status ? this.statusText : 'Request failed') );
                return;
            }
            if (this.status === 201) {
                setTimeout( location.href = "//" + location.host, 500 );
            }
            renderAlert(this.responseText);
            return;
        }
    }
    function renderAlert(body) {
        var div = document.createElement('div');
        var container = document.querySelector(".form");
        div.innerHTML = body;
        container.insertBefore(div, container.firstChild);
    }
    function removeAlert() {
        var alert = document.querySelector(".alert");
        if (alert)
            alert.remove();
    }
</script>
</body>
</html>