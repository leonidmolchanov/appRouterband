<?php
require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;
$router_login=$_SESSION['router_login'];
$router_password=$_SESSION['router_password'];

if ($API->connect($router_ip_long, $router_login, $router_password)) {

$ARRAY = $API->comm("/interface/wireless/security-profiles/print", array(
 
));
$ARRAY2 = $API->comm("/interface/wireless/registration-table/print", array(
 
));
$ARRAY3 = $API->comm("/ip/dhcp-server/lease/print", array(
 
));
$ARRAY4 = $API->comm("/caps-man/registration-table/print", array(
 
));
$capsman_status = $API->comm("/caps-man/manager/print", array(
 
));
$API->disconnect();
?>

<?
}
else {
print "Ошибка соединения";
}
//print_r($ARRAY2);

$arr[$i]['signal']=$ARRAY2[$i]['signal-strength-ch1'];
if($capsman_status['0']['enabled']=='true')
{
    $ARRAY2=$ARRAY4;
}
else
{
}

$arr=[];
$count_array2=count($ARRAY2);
$count_array2=$count_array2-1;
for ($i =0; $i <=$count_array2; $i++)
{

for ($y =0; $y <=$count_array2; $y++)
{
if($ARRAY2[$i]['mac-address']==$ARRAY3[$y]['mac-address'])
{
$arr[$i]['interface']=$ARRAY3[$y]['host-name'];
}
else
{
}
}
$arr[$i]['host_name']=$ARRAY3[$i]['host-name'];
$arr[$i]['interface']=$ARRAY2[$i]['interface'];

$arr[$i]['mac']=$ARRAY2[$i]['mac-address'];

$arr[$i]['signal']=$ARRAY2[$i]['signal-strength-ch1'];

$arr[$i]['ccq']=$ARRAY2[$i]['tx-ccq']."%";

$arr[$i]['rate']=$ARRAY2[$i]['tx-rate'];

$arr[$i]['ip']=$ARRAY2[$i]['last-ip'];

$arr[$i]['uptime']=$ARRAY2[$i]['uptime'];

if($capsman_status['0']['enabled']=='true')
{
$arr[$i]['signal']=$ARRAY2[$i]['rx-signal'];
$arr[$i]['ip']="Недоступно";
$arr[$i]['ccq']="Недоступно";
}
else
{
}

}

if (empty($arr)) {
 $arr="deny";
}
else
{
}

$arr2=Array(
'type'=>'wifi_info',
'count'=>count($ARRAY2),
'capsman'=>$capsman_status['0']['enabled'],
'body'=>$arr,
);
 $string=trim(json_encode($arr2));
            echo $string;
?>
