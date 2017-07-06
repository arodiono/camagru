<?php

require_once 'config.php';

try
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
}
catch (Exception $e)
{
	echo "Error! Can`t connect to database";
}

try
{
	$insert = $db->prepare("CREATE TABLE `db_camagru00`.`users`(
		`id` INT NOT NULL AUTO_INCREMENT,
		`login` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`password` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`email` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`hash` VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
		`active` INT(1) UNSIGNED NOT NULL DEFAULT '0',
		PRIMARY KEY(`id`)
	) ENGINE = InnoDB CHARSET = utf8 COLLATE utf8_general_ci;
	");
	$insert->execute();
}
catch (Exception $e)
{
	echo "Error! Can`t add table to database";
}
