<div class="login-form">
	<form method="post" name="forgot">
		<div class="form-group">
			<label for="email">Email address</label>
			<input id="email" class="form-control" type="email" name="email" placeholder="Enter email adress">
		</div>
		<input class="btn" type="button" onclick="sendRequest(); " value="Remind Password">
	</form>
</div>
<script>
	"use strict";
	function sendRequest()
	{
		removeAlert();
		var request = new XMLHttpRequest();
		var data = new FormData(document.forms.forgot);
		var message = "<div class=\"alert alert-danger\"><strong>Warning! </strong> All fields must not be empty</div>";
		if (!data.get("email")) {
			renderAlert(message);
			return;
		}
		request.open('POST', '/password/remind', true);
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
		var alert = document.querySelector(".alert");
		if (alert)
			alert.remove();
	}

</script>
