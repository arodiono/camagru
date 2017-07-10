<div class="register-form">
	<form method="post" name="register">
		<div class="form-group">
			<label for="login">Username</label>
			<input id="login" class="form-control" type="text" name="login" placeholder="Enter your name" autofocus="">
		</div>
		<div class="form-group">
			<label for="email">Email address</label>
			<input id="email" class="form-control" type="email" name="email" placeholder="Enter email adress">
			<p class="form-text text-muted">We'll never share your email with anyone else.</p>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input id="password" class="form-control" type="password" name="password" placeholder="Enter Password">
			<p class="form-text text-muted">Password must be equal to or longer than 8 characters.</p>
		</div>
		<div class="form-group">
			<label for="passwordConfirm">Confirm password</label>
			<input id="passwordConfirm" class="form-control" type="password" name="passwordConfirm" placeholder="Confirm password">
		</div>
		<input class="btn" type="button" onclick="sendRequest()" value="Submit">
		<p class="form-text text-muted">After submitting the form you will receive an email with the activation code</p>
	</form>
</div>
<script>
	"use strict";
	function sendRequest()
	{
		var request = new XMLHttpRequest();
		var data = new FormData(document.forms.register);
		var message = "<div class=\"alert alert-danger\"><strong>Warning! </strong> All fields must not be empty</div>";
		if (!data.get("login") || !data.get("email")
			|| !data.get("password") || !data.get("passwordConfirm")) {
			// removeAlert();
			renderAlert(message);
			return;
		}
		request.open('POST', 'validateFormInput', true);
		request.send(data);
		request.onreadystatechange = function() {
			if (this.readyState != 4)
				return;
			if (this.status != 200) {
				alert( 'Error: ' + (this.status ? this.statusText : 'Request failed') );
				return;
			}
			if (this.status == 200) {
				setTimeout( 'location="login";', 1000 );
			}
			// removeAlert();
			renderAlert(this.responseText);
			return;
		}
	}
	function renderAlert(body) {
		var div = document.createElement('div');
		var container = document.querySelector(".register-form");
		div.innerHTML = body;
		container.insertBefore(div, container.firstChild);
	}
	function removeAlert() {
		var container = document.querySelector(".register-form");
		var alert = document.querySelector(".alert");
		if (alert) {
			container.removeChild(alert);
		}
	}
</script>
