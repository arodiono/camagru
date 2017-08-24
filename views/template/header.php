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
        <header>
            <div class="container">
                <nav>
                    <a href="/post/add"><i class="icon icon-camera"></i></a>
                    <h1 class="header-logo"><a href="<?='//' . $_SERVER['HTTP_HOST'] . '/' ?>">Camagru</a></h1>
                    <a href="/<?=$_SESSION['username']?>"><i class="icon icon-user"></i></a>
                </nav>
            </div>
        </header>
		<div class="container">

