<?php

require_once("/var/www/html/app/includes/connection2.php"); 

$device=explode(",",$_SESSION['device']);
if (empty($metod)) {
$metod="pusto";
}
else
{
    $login=$_SESSION['session_username'];
//$query =mysql_query("UPDATE  wp_users SET (SN='".$metod."') WHERE user_login='".$andre."' ");
//$query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `SN` =  '".$metod."' WHERE  `wp_users`.`user_login` ='".$login."' ");
$query2 =mysql_query("SELECT * FROM radreply WHERE username='".$metod."' ");
$query2=mysql_fetch_assoc($query2);
 $result=trim(json_encode($query2));
 
 if($result=="false")
 {
 }
else
{
require_once("/var/www/html/app/includes/connection.php"); 
$query2 =mysql_query("SELECT * FROM `wordpress`.`wp_users`  WHERE user_login='".$login."' ");
$query2=mysql_fetch_assoc($query2);
 $result=$query2['DEVICE'];
 if (empty($result)) {
$query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `DEVICE` =  '".$metod."' WHERE  `wp_users`.`user_login` ='".$login."' ");
$result="add";
}
else
{
	$result=$query2['DEVICE'].",".$metod;
	$query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `DEVICE` =  '".$result."' WHERE  `wp_users`.`user_login` ='".$login."' ");
	$result="add";
}



}
}

$arr = array
('type' => "router_device",
'count'=>count($device),
'master'=>$_SESSION['master'],
  'device' => $device,
  'metod'=>$result,
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;

?>
