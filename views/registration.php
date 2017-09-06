<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Cookie|Raleway:300" rel="stylesheet">
    <title><?=$title ?></title>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1 class="text-center">Camagru</h1>
            <p class="text-center">Sign up to see photos from your friends</p>
            <div class="form">
                <form method="post" name="registration" action="javascript:void(null);" id="signup">
                    <div class="form-group">
                        <input id="login" class="form-control" type="text" name="username" placeholder="Username" autofocus="">
                    </div>
                    <div class="form-group">
                        <input id="fullname" class="form-control" type="text" name="fullname" placeholder="Full name" autofocus="">
                    </div>
                    <div class="form-group">
                        <input id="email" class="form-control" type="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input id="password" class="form-control" type="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input id="passwordConfirm" class="form-control" type="password" name="passwordConfirm" placeholder="Confirm password">
                    </div>
                    <input class="btn btn-default btn-inline" type="submit" value="Sign up">
                </form>
                <div class="form-box-footer">
                    <p class="text-center">Have an account?</p>
                    <a class="btn btn-default btn-inline" href="/login">Log in</a>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/signup.js"></script>
</body>
</html>