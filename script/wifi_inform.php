<?php
require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY = $API->comm("/interface/wireless/print", array(
));
$API->disconnect();
}
else {
print "Ошибка соединения";
}
if (empty($ARRAY)) {
 $ARRAY="deny";
}
else
{
}
$arr=Array(
'type'=>'wifi_inform',
'count'=>count($ARRAY),
'body'=>$ARRAY,
);


 $string=trim(json_encode($arr));
 $string=str_replace("-", "_", $string);
            echo $string;
?>