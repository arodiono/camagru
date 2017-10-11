<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('session.cookie_httponly', 1);

define('APP', __DIR__ . DIRECTORY_SEPARATOR);

date_default_timezone_set('Europe/Kiev');

spl_autoload_register(function ($class) {

	$core = APP . 'core/' . strtolower($class) . '.php';
	$controllers = APP . 'controllers/' . str_replace('controller', '', strtolower($class)) . '.controller.php';
	$models = APP . 'models/' . str_replace('model', '', strtolower($class)) . '.model.php';
	$views = APP . 'views/' . str_replace('view', '', strtolower($class)) . '.view.php';

	if (file_exists($core))
		include $core;
	elseif (file_exists($controllers))
		include $controllers;
	elseif (file_exists($models))
		include $models;
	elseif (file_exists($views))
		include $views;
});

if (!Database::checkTable())
    header('Location: /config/setup.php');

$app = new Route();

