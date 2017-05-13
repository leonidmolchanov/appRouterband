<?php

require_once("/var/www/html/app/includes/connection.php"); 


    $login=$_SESSION['session_username'];
$query2 =mysql_query("SELECT * FROM wp_uuid WHERE uuid='".$metod."' ");
$query2=mysql_fetch_assoc($query2);
if(!$query2)
{
    $uuid="false";
       $result2 = mysql_query("INSERT INTO `wp_uuid` (uuid,user) VALUES ('$metod','$login')");
}
else
{
    $uuid="true";
}
$userdevice=$_SESSION['device'];
$usermac=$_SESSION['master'];
$ipaddress=long2ip($_SESSION['ip']);
   $handle = fsockopen($ipaddress, 8728, $errno, $errstr, 10);
if ($handle !== false)
{
$status="online";
$log="access";
fclose($handle);
} else {
	$log="access";
$status="offline";
}  
$arr = array
('type' => $type,
 'status' => $status,
 'uuid' => $query2,
 'uuidnum' => $metod,
  'device' => $userdevice,
  'SN' => $usermac,
 );
 $string=trim(json_encode($arr));
            echo $string;
            $router_ip=$_SESSION['ip'];
?>