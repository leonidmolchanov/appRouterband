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
elseif ($metod=="request")
{
	$query2 =mysql_query("SELECT * FROM wp_users WHERE user_login='".$login."' ");
$query2=mysql_fetch_assoc($query2);
 $pushmsg=$query2['push'];
$emailmsg=$query2['email_msg'];
	$arr = array
('type' => "profile_sittings",
  'pushmsg'=> $pushmsg,
  'emailmsg'=>$emailmsg,
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;	
}
elseif ($metod=="push")
{
	if($metod2=="true")
	{
	$query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `push` =  '1' WHERE  `wp_users`.`user_login` ='".$login."' ");
	}
	else if($metod2=="false")
	{
	    $query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `push` =  '0' WHERE  `wp_users`.`user_login` ='".$login."' ");
	}
$arr = array
('type' => "profile_change",
  'status'=>$metod2,
  'type'=>"push",
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;	
	
}
elseif ($metod=="email")
{
if($metod2=="true")
	{
	$query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `email_msg` =  '1' WHERE  `wp_users`.`user_login` ='".$login."' ");
	}
	else if($metod2=="false")
	{
	    $query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `email_msg` =  '0' WHERE  `wp_users`.`user_login` ='".$login."' ");
	}

$arr = array
('type' => "profile_change",
  'status'=>$metod2,
  'type'=>"email",
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;	
	
}


?>