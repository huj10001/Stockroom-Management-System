<?php
	$db_name= "inventory";
	$un = "root";
	$pw = "";
	$host = "localhost";

	mysql_connect($host, $un, $pw) or die (mysql_error());
	//echo("Connected to database");

	mysql_select_db($db_name) or die(mysql_error());
	//echo("connected to employees");

?>