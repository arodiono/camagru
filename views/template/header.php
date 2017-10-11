<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<link href="https://fonts.googleapis.com/css?family=Cookie|Roboto:300" rel="stylesheet">
		<title><?=$title ?></title>
	</head>
	<body>
        <header>
            <div class="container">
                <nav>
                    <h1 class="header-logo"><a href="<?='//' . $_SERVER['HTTP_HOST'] . '/' ?>">Camagram</a></h1>

                        <?php if(Session::isLoggedOnUser()):?>
                           <a href="#" id="menu"><span></span></a>
                            <script>
                                var menu = document.getElementById('menu');
                                menu.addEventListener('click', function () {
                                    var dropdown = document.querySelector('.dropdown-menu');
                                    if (dropdown.style.display === 'block')
                                        dropdown.style.display = 'none';
                                    else
                                        dropdown.style.display = 'block';
                                    this.classList.toggle( "active" );
                                });
                            </script>
                        <?php else:?>
                            <button class="btn btn-gradient" onclick="window.location.pathname = '/login'">Login</button>
                        <?php endif;?>
                </nav>
                <div class="dropdown-menu hidden">
                    <a href="/post">Add photo</a>
                    <a href="/<?=$_SESSION['username']?>">My profile</a>
                    <a href="/user/config">Edit profile</a>
                    <a href="/login/logout">Log out</a>
                </div>
            </div>
        </header>
        <div class="container">