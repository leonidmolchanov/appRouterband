<?php

require_once("/var/www/html/app/includes/connection2.php"); 

$device=explode(",",$_SESSION['device']);
for ($i =0; $i <=count($device)-1; $i++)
{
$serial_device=$device[$i];
$device_act[$i] =mysql_query("SELECT * FROM radreply WHERE username='".$serial_device."' ");
$device_act[$i]=mysql_fetch_assoc($device_act[$i]);
$device_name[$i]=$device_act[$i]['name'];
$device_login[$i]=$device_act[$i]['login'];
$device_password[$i]=$device_act[$i]['password'];
}
if (empty($metod)) {
$metod="pusto";
}
else
{
    $login=$_SESSION['session_username'];
//$query =mysql_query("UPDATE  wp_users SET (SN='".$metod."') WHERE user_login='".$andre."' ");
$query =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `SN` =  '".$metod."' WHERE  `wp_users`.`user_login` ='".$login."' ");
$result="logout";
$_SESSION['master']=$metod;
}

$arr = array
('type' => "router_device",
'count'=>count($device),
'master'=>$_SESSION['master'],
  'device' => $device,
  'devicename'=>$device_name,
   'login' => $device_login,
  'password'=>$device_password,
  'metod'=>$result,
  'sn'=>$metod,
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;

?>
