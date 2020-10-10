<?php
	include '../dbase-conf.php';
	$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
	mysql_set_charset('utf8', $mysqli);
	if(mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	die ('Error connecting to mysql.');
	} 
?>