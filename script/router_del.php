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
for ($i = 0; $i <= count($device); $i++)
{
	if($device[$i]==$metod)
	{
		$device_act="yes";
		unset($device[$i]);
sort($device);
$device= implode(",",$device);
$query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `DEVICE` =  '".$device."' WHERE  `wp_users`.`user_login` ='".$login."' ");
	}
	else
	{
		$device_act="no";
	}
}
$arr = array
('type' => "router_device",
'count'=>count($device),
'deleted'=>$device_act,
  'device' => $device,
  'metod'=>$result,
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;

?>
