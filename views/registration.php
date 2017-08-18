<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="<?='//' . $_SERVER['HTTP_HOST'] . '/' ?>css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Cookie|Raleway:300" rel="stylesheet">
    <title><?=$title ?></title>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1 class="header-logo text-center">Camagru</h1>
            <p class="text-center">Sign up to see photos from your friends</p>
            <div class="form">
                <form method="post" name="registration">
                    <div class="form-group">
                        <input id="login" class="form-control" type="text" name="login" placeholder="Username" autofocus="">
                    </div>
                    <div class="form-group">
                        <input id="fullname" class="form-control" type="text" name="fullname" placeholder="Full name" autofocus="">
                    </div>
                    <div class="form-group">
                        <input id="email" class="form-control" type="email" name="email" placeholder="Email">
    <!--                    <p class="form-text text-muted">We'll never share your email with anyone else.</p>-->
                    </div>
                    <div class="form-group">
                        <input id="password" class="form-control" type="password" name="password" placeholder="Password">
    <!--                    <p class="form-text text-muted">Password must be equal to or longer than 8 characters.</p>-->
                    </div>
                    <div class="form-group">
                        <input id="passwordConfirm" class="form-control" type="password" name="passwordConfirm" placeholder="Confirm password">
                    </div>
                    <input class="btn btn-default btn-inline" type="button" onclick="sendRequest();" value="Sign up">
    <!--                <p class="form-text text-muted">After submitting the form you will receive an email with the activation code</p>-->
                </form>
                <div class="form-box-footer">
                    <p class="text-center">Have an account?</p>
                    <a class="btn btn-default btn-inline" href="/login">Log in</a>
                </div>
            </div>
        </div>
    <script src="<?='//' . $_SERVER['HTTP_HOST'] . '/' ?>js/registration.js"></script>
    </div>
</body>
</html>