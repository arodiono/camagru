<div class="login-form">
	<form method="post" name="reset">
		<div class="form-group">
			<label for="password">Password</label>
			<input id="password" class="form-control" type="password" name="password" placeholder="Enter Password">
			<p class="form-text text-muted">Password must be equal to or longer than 8 characters.</p>
		</div>
		<div class="form-group">
			<label for="passwordConfirm">Confirm password</label>
			<input id="passwordConfirm" class="form-control" type="password" name="passwordConfirm" placeholder="Confirm password">
		</div>
		<input class="btn" type="button" onclick="sendRequest(); " value="Reset Password">
	</form>
</div>
<script>
	"use strict";
	function sendRequest()
	{
		removeAlert();
		var request = new XMLHttpRequest();
		var data = new FormData(document.forms.reset);
		var message = "<div class=\"alert alert-danger\"><strong>Warning! </strong> All fields must not be empty</div>";
		if (!data.get("password") && !data.get("passwordConfirm")) {
			renderAlert(message);
			return;
		}
		request.open('POST', '/password/update/', true);
		request.send(data);
		request.onreadystatechange = function() {
			if (this.readyState != 4)
				return;
			if (this.status != 200 && this.status != 201) {
				renderAlert( 'Error: ' + (this.status ? this.statusText : 'Request failed') );
				return;
			}
			if (this.status == 201) {
                setTimeout( location.href = "//" + location.host + '/login', 500 );
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
