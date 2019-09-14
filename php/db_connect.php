<?php
define("DB_host", "");
define("DB_User", "");
define("DB_pwd", "");
define("DB_name", "");
function dbCreateConnection()
	{
	$connection = new mysqli(DB_host, DB_User, DB_pwd, DB_name);
	if ($connection === false)
		{
		die("Connection failed" . $connection->connect_error);
		return;
		}
		gettype($connection);
	return $connection;
	}
?>