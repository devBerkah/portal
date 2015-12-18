<?php
	$db_name = "berkah";
	$connection = @mysql_connect("localhost","root","") or die (mysql_error());
	$db = @mysql_select_db($db_name, $connection) or die (mysql_error());
?>
