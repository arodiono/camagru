<?php

class Model
{
	public $database;

	function __construct()
	{
		$this->database = Database::getConnection();
	}
}
