<?php

class Model
{
	public static $database;

	function __construct()
	{
		$this->database = Database::getConnection();
	}
}
