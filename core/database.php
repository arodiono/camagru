<?php

class Database
{
	private static $database;

	public static function getConnection()
	{
		if (!self::$database)
		{
			require APP . 'config/config.php';
			try
			{
				$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
				self::$database = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $options);
			}
			catch (Exception $e)
			{
				echo 'Database Error ' . $e->getCode() . ' Please try again later.' . '<br>';
				exit;
			}
		}
		return self::$database;
	}
}
