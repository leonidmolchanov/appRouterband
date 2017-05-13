<?php
require_once('/var/www/html/app/includes/connection.php'); 
require_once('/var/www/html/wordpress/wp-includes/pluggable.php'); 
require_once('/var/www/html/wordpress/wp-includes/class-phpass.php'); 
//require_once('/var/www/html/wordpress/wp-blog-header.php');
//require_once('/var/www/html/wordpress/wp-includes/registration.php');
	header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');
 $login=$_SESSION['session_username'];
$device=explode(",",$_SESSION['device']);
if (empty($metod)) {
$metod="pusto";
}
elseif ($metod=="email")
{
	$query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `user_email` =  '".$metod2."' WHERE  `wp_users`.`user_login` ='".$login."' ");
$arr = array
('type' => "profile_change",
'count'=>count($device),
  'change' => "status",
  'metod'=>$metod,
  'metod2'=>$metod2,
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;	
	
}
elseif ($metod=="telnumber")
{
$query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `user_url` =  '".$metod2."' WHERE  `wp_users`.`user_login` ='".$login."' ");
$arr = array
('type' => "profile_change",
'count'=>count($device),
  'change' => "status",
  'metod'=>$metod,
   'metod2'=>$metod2,
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;	
	
}
elseif ($metod=="password")
{
$pass_hash=wp_hash_password($metod2);
	$query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `user_pass` =  '".$pass_hash."' WHERE  `wp_users`.`user_login` ='".$login."' ");
$arr = array
('type' => "profile_change",
'count'=>count($device),
  'change' => "status",
  'metod'=>$metod,
  'metod2'=>$metod2,
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;	
	
}

?>
