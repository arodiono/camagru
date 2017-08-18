"use strict";
function sendRequest()
{
	removeAlert();
	var request = new XMLHttpRequest();
	var data = new FormData(document.forms.registration);
	var message = "<div class=\"alert alert-danger\"><strong>Warning! </strong> All fields must not be empty</div>";
	if (!data.get("login") || !data.get("email")
		|| !data.get("password") || !data.get("passwordConfirm")) {
		renderAlert(message);
		return;
	}
	request.open('POST', 'signup/validateFormInput', true);
	request.send(data);
	request.onreadystatechange = function() {
		if (this.readyState != 4)
			return;
		if (this.status != 200 && this.status != 201) {
			renderAlert( 'Error: ' + (this.status ? this.statusText : 'Request failed') );
			return;
		}
		if (this.status == 201) {
			setTimeout( 'location="login";', 1000 );
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
	var container = document.querySelector(".form");
	var alert = document.querySelector(".alert");
	if (alert)
		alert.remove();
}
