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
<!--                    <div>-->
<!--                        --><?php //if(Session::isLoggedOnUser()):?>
<!--                            <a href="/post/add"><i class="icon icon-camera"></i></a>-->
<!--                        --><?php //endif;?>
<!--                    </div>-->
                    <h1 class="header-logo"><a href="<?='//' . $_SERVER['HTTP_HOST'] . '/' ?>">Camagru</a></h1>
                    <div>
                        <?php if(Session::isLoggedOnUser()):?>
                           <a href="#" id="menu"><span></span></a>
                        <?php else:?>
                            <a href="/login"><i class="icon icon-user"></i></a>
                        <?php endif;?>
                </nav>
                <div class="dropdown-menu hidden">
                    <a href="/post/add">Add photo</a>
                    <a href="/<?=$_SESSION['username']?>">My profile</a>
                    <a href="/user/config">Edit profile</a>
                    <a href="/login/logout">Log out</a>
                </div>
            </div>
            <script>
                'use strict';
                var menu = document.getElementById('menu');
                menu.addEventListener('click', function () {
                    var dropdown = document.querySelector('.dropdown-menu');
                    if (dropdown.style.display == 'block')
                        dropdown.style.display = 'none';
                    else
                        dropdown.style.display = 'block';
                    this.classList.toggle( "active" );
                })
            </script>
        </header>

        <div class="container">
