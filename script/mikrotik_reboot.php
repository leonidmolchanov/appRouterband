

<?php

require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY = $API->comm("/system/script/print", array(
 "?name" => "reboot",
));
$ARRA2 = $API->comm("/system/script/run", array(
 "number" => $ARRAY[0]['.id'],
));

$API->disconnect();


for ($i =-1; $i <=count($ARRAY); $i++)
{
	if($ARRAY[$i]['name']=="reboot")
	{$result="yes";
	}
	else
	{
		$result="no";
	}
}
$arr=array(
'type'=>'reboot',
'action'=>'reboot',
);
$string=trim(json_encode($arr));
            echo $string;
}
else {
print "Ошибка соединения";
}
//print_r($ARRAY2);
?>