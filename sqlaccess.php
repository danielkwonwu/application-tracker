<?php

$mysqli = new mysqli('localhost', 'tester', 'cse330tester', 'APPTRACKER');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}

?>