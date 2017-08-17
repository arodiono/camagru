<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?='//' . $_SERVER['HTTP_HOST'] . '/' ?>css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display|Raleway:300" rel="stylesheet">
    <title><?=$title ?></title>
</head>
<body>
<div class="container">
    <div class="form-box">
        <h1 class="header-logo text-center">Camagru</h1>
        <div class="form">
            <form method="post" name="login">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input id="email" class="form-control" type="email" name="email" placeholder="Enter email adress">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" class="form-control" type="password" name="password" placeholder="Enter Password">
                </div>
                <input class="btn" type="button" onclick="sendRequest(); " value="Login">
            </form>

            <div class="form-box-footer">
                <a href="/password/forgot">Forgot password?</a>
                <p class="text-center">Don`t have an account?</p>
                <a class="btn btn-default btn-inline" href="/register">Sign up</a>
            </div>
        </div>
    </div>
    <script src="<?='//' . $_SERVER['HTTP_HOST'] . '/' ?>js/registration.js"></script>
</div>
</body>
</html>




<!--<div class="login-form">-->
<!--	<form method="post" name="login">-->
<!--		<div class="form-group">-->
<!--			<label for="email">Email address</label>-->
<!--			<input id="email" class="form-control" type="email" name="email" placeholder="Enter email adress">-->
<!--		</div>-->
<!--		<div class="form-group">-->
<!--			<label for="password">Password</label>-->
<!--			<input id="password" class="form-control" type="password" name="password" placeholder="Enter Password">-->
<!--		</div>-->
<!--		<input class="btn" type="button" onclick="sendRequest(); " value="Login">-->
<!--	</form>-->
<!--    <a href="/password/forgot">Forgot password?</a>-->
<!--</div>-->


<script>
"use strict";
function sendRequest()
{
	removeAlert();
	var request = new XMLHttpRequest();
	var data = new FormData(document.forms.login);
	var message = "<div class=\"alert alert-danger\"><strong>Warning! </strong> All fields must not be empty</div>";
	if (!data.get("email") || !data.get("password")) {
		renderAlert(message);
		return;
	}
	request.open('POST', 'login/login', true);
	request.send(data);
	request.onreadystatechange = function() {
		if (this.readyState != 4)
			return;
		if (this.status != 200 && this.status != 201) {
			renderAlert( 'Error: ' + (this.status ? this.statusText : 'Request failed') );
			return;
		}
		if (this.status == 201) {
			setTimeout( location.href = "//" + location.host, 500 );
		}
		renderAlert(this.responseText);
		return;
	}
}
function renderAlert(body) {
	var div = document.createElement('div');
	var container = document.querySelector(".login-form");
	div.innerHTML = body;
	container.insertBefore(div, container.firstChild);
}
function removeAlert() {
	var container = document.querySelector(".login-form");
	var alert = document.querySelector(".alert");
	if (alert)
		alert.remove();
}

</script>
