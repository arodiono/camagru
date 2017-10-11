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
			    if ($e->getCode() === 1049)
				    echo 'Welcome! ' . '<br>' . 'Create database and then' . ' click <a href="/config/setup.php">here</a> to setup';
				exit;
			}
		}
		return self::$database;
	}

	public static function checkTable()
    {
        $db = self::getConnection();
        $res = $db->prepare('SHOW TABLES LIKE \'users\'');
        $res->execute();
        if ($res->rowCount() === 0)
            return false;
        return true;
    }
}
