
			<form class="sign-up" method="post">
				<input type="text" name="login" value="" placeholder="Username" required="">
				<input type="email" name="email" value="" placeholder="Email" required="">
				<input type="password" name="password" value="" placeholder="Password" required="">
				<input type="password" name="passwordConfirm" value="" placeholder="Confirm password" required="">
				<input type="button" onclick="sendRequest()" value="Sign up">
			</form>
			<script>
				function sendRequest()
				{
					var request = new XMLHttpRequest();
					var form = document.querySelector('.sign-up');
					var data = new FormData(form);

					request.open('POST', 'registerAction', true);

					request.send(data);

					request.onreadystatechange = function() {
						if (this.readyState != 4) return;

						if (this.status != 200) {
							alert( 'Error: ' + (this.status ? this.statusText : 'Request failed') );
							return;
						}
						var div = document.createElement('div');
						div.className = "error";
						div.innerHTML = this.responseText;
						document.body.appendChild(div);
					}

				}
			</script>
			<?php
				$this->renderNotification();
			?>
