<?php
require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support')) {

$resolve_yandex = $API->comm("/resolve", array(
 "domain-name"=> "yandex.ru",
));
$resolve_google = $API->comm("/resolve", array(
 "domain-name"=> "google.com",
));
$resolve_vk = $API->comm("/resolve", array(
 "domain-name"=> "vk.com",
));
$dns_print = $API->comm("/ip/dns/print", array(
));
$API->disconnect();

}
else {
print "Ошибка соединения";
}
$dns_print2=$dns_print ['0']['dynamic-servers'];
$dns_print=$dns_print ['0']['servers'];
$dns_print=$dns_print.$dns_print2;
$dns_print=explode(",",$dns_print);


for ($i = 0; $i <= count($dns_print)-1; $i++)
{
if ($API->connect($router_ip_long, 'support', 'support')) {

$dns_ping[$i] = $API->comm("/ping", array(
 "address"=> $dns_print[$i],
 "count"=> "1", 
));

$API->disconnect();

}
else {
print "Ошибка соединения";
}
$dns_ping[$i]=$dns_ping[$i]['0']['packet-loss'];
$arr_dns[$i]=Array(
'address'=>$dns_print[$i],
'ping'=>$dns_ping[$i],
);


}


if ($API->connect($router_ip_long, 'support', 'support')) {

$gateway_print = $API->comm("/ip/route/print", array(
));

$API->disconnect();

}
else {
print "Ошибка соединения";
}

for ($i = 0; $i <= count($gateway_print)-1; $i++)
{
$arr_gateway[$i]=$gateway_print[$i]['dst-address'];
if(strpos($gateway_print[$i]['dst-address'], '0.0.0.0')=='false')
{
//	$arr_gateway=$gateway_print[$i]['dst-address'];
$arr_gateway_result=$gateway_print[$i]['gateway-status'];

if(strpos($arr_gateway_result, 'reachable')!=='false')
{
$arr_gateway_result="ok";	
}
else
{
$arr_gateway_result=strpos($arr_gateway_result, 'reachable');	
}


}
else
{
}

	
}


$arr=[];

$arr_resolve=Array(
'yandex'=>$resolve_yandex,
'google'=>$resolve_google,
'vk'=>$resolve_vk,
);


$arr=Array(
'type'=>'diagnostic_all',
'count'=>count($ARRAY),
'count_dns'=>count($dns_print),
'resolve'=>$arr_resolve,
'dns'=>$arr_dns,
'gateway'=>$arr_gateway_result,
);
 $string=trim(json_encode($arr));
            echo $string;
?>