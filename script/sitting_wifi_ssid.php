

<?php

require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support')) {

if (empty($metod)) {
	$action="process";
}
else
{
$ARRAY = $API->comm("/interface/wireless/set", array(
"numbers"=> "wlan1",
 "ssid"=> $metod,
));

$action="add";
}

$API->disconnect();


$arr=array(
'type'=>'wifi_sitting',
'metod'=>$action,
'body'=>array(
'ssid'=>$ARRAY
));
$string=trim(json_encode($arr));
            echo $string;
}
else {
print "Ошибка соединения";
}
//print_r($ARRAY2);
?>