<?php

require_once("/var/www/html/app/includes/connection.php"); 

$device=explode(",",$_SESSION['device']);
if (empty($metod)) {
$metod="pusto";
}
else
{
    $login=$_SESSION['session_username'];

$query2 =mysql_query("SELECT * FROM wp_users WHERE user_login='".$login."' ");
$query2=mysql_fetch_assoc($query2);
 $result=$query2['DEVICE'];
//$query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `DEVICE` =  '".$metod."' WHERE  `wp_users`.`user_login` ='".$login."' ");
$result="del";

}

		$device_act="yes";
		unset($device[$i]);
sort($device);
$device= implode(",",$device);
$query =mysql_query("UPDATE  `radius`.`radreply` SET  `name` =  '".$metod."' WHERE  `username` ='".$metod2."' ");

$arr = array
('type' => "router_device",
'count'=>count($device),
'name'=>$metod,
  'device' => $metod2,
  'metod'=>"name",
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;

?>
