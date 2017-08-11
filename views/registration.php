<div class="registration-form">
	<form method="post" name="registration">
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
		<input class="btn" type="button" onclick="sendRequest(); " value="Submit">
		<p class="form-text text-muted">After submitting the form you will receive an email with the activation code</p>
	</form>
</div>
<script src="<?='//' . $_SERVER['HTTP_HOST'] . '/' ?>js/registration.js"></script>
