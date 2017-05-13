

<?php

require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY = $API->comm("/interface/wireless/security-profiles/print", array(
 
));
$ARRAY2 = $API->comm("/interface/wireless/print", array(
 
));

$API->disconnect();

$arr=array(
'type'=>'wifi_sitting',
'body'=>array(
'ssid'=>$ARRAY2[0]['ssid'],
'wifi_type'=>$ARRAY[0]['authentication-types'],
'wpa_key'=>$ARRAY[0]['wpa-pre-shared-key'],
'wpa2_key'=>$ARRAY[0]['wpa2-pre-shared-key']
));
$string=trim(json_encode($arr));
            echo $string;
}
else {
print "Ошибка соединения";
}
//print_r($ARRAY2);
?>
