<?php
require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY = $API->comm("/tool/bandwidth-test", array(
 "address"=> "213.21.23.38",
 "user"=> "support",
 "password"=> "support",
 "direction"=> "transmit",
 "random-data"=> "yes",
 "duration"=> "10",
));

$ARRAY2 = $API->comm("/tool/bandwidth-test", array(
 "address"=> "213.21.23.38",
 "user"=> "support",
 "password"=> "support",
 "direction"=> "receive",
 "random-data"=> "yes",
 "duration"=> "10",
));
$API->disconnect();

}
else {
print "Ошибка соединения";
}


$arr=[];



$arr=Array(
'type'=>'diagnostic_speedtest',
'count'=>count($ARRAY),
'tx'=>$ARRAY['11']['tx-total-average'],
'rx'=>$ARRAY2['11']['rx-total-average'],
);
 $string=trim(json_encode($arr));
            echo $string;
?>