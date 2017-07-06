function sendRequest () {
	var request = new XMLHttpRequest();

	request.open('POST', 'registerAction', false);

	request.send();

	request.onreadystatechange = function() {
		if (this.readyState != 4) return;

		if (this.status != 200) {
			alert( 'Error: ' + (this.status ? this.statusText : 'Request failed') );
			return;
		}

	  // получить результат из this.responseText или this.responseXML
	}
}
