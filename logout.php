<?php
	header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');
	session_start();
	unset($_SESSION['session_username']);
	session_destroy();
echo "no session";
	?>