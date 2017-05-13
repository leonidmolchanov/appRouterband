<?php
require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY = $API->comm("/tool/traceroute", array(
 "address"=> $metod,
 "count"=> "1",
));

$API->disconnect();

}
else {
print "Ошибка соединения";
}


$arr=[];



$arr=Array(
'type'=>'diagnostic_ping',
'count'=>count($ARRAY),
'body'=>$ARRAY,
);
 $string=trim(json_encode($arr));
            echo $string;
?>