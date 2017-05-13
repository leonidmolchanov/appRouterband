<?php
include("/var/www/wordpress/wp-includes/pluggable.php");
include("/var/www/wordpress/wp-includes/class-phpass.php");
$wp_hasher = new PasswordHash(8, TRUE);

$password_hashed = '$P$BRzr608B/jhZF/mO24Tkfxm0tK/dcv0';
$plain_password = 'andreyandrey';

if($wp_hasher->CheckPassword($plain_password, $password_hashed)) {
	echo "paroli ok";
} else {
	echo "paroli no";
}

?>