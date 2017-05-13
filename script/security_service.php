<?php
require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY = $API->comm("/ip/service/print", array(
));

$API->disconnect();

}
else {
print "Ошибка соединения";
}


$arr=[];



$arr=Array(
'type'=>'security_service',
'count'=>count($ARRAY),
'body'=>$ARRAY,
);
 $string=trim(json_encode($arr));
            echo $string;
?>