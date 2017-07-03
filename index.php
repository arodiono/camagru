<?php

ini_set('display_errors', 1);

define('APP', __DIR__ . DIRECTORY_SEPARATOR);

spl_autoload_register(function ($class) {
	include APP . 'core/' . strtolower($class) . '.php';
});

$app = new Route();

?>
