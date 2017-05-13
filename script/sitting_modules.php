<?php
require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support')) {

$bridge = $API->comm("/interface/bridge/print", array(
));
$snmp = $API->comm("/snmp/print", array(
));
$reboot = $API->comm("/system/script/print", array(
));
$routerband = $API->comm("/ip/firewall/nat/print", array(
));
$pxe = $API->comm("/ip/dhcp-server/print", array(
));
$dns_print = $API->comm("/ip/dns/print", array(
));
$API->disconnect();

}
else {
print "Ошибка соединения";
}
$bridge=$bridge ['0']['name'];
$snmp=$snmp ['0']['enabled'];
$rebootst="false";
$routerbandst="false";
$pxest="false";
for ($i = 0; $i <= count($reboot); $i++)
{
if ($reboot[$i][name]=="reboot") {
$rebootst="true";
}
else {
}
}


for ($i = 0; $i <= count($pxe); $i++)
{
if ($pxe[$i][name]=="dhcppxe") {
$pxest="true";
}
else {
}
}

for ($i = 0; $i <= count($routerband); $i++)
{
if ($routerband[$i][comment]=="routerband") {
$routerbandst="true";
}
else {
}
}




$arr=Array(
'type'=>'sitting-modules',
'count'=>count($ARRAY),
'snmp'=>$snmp,
'bridge'=>$bridge,
'reboot'=>$rebootst,
'routerband'=>$routerbandst,
'pxe'=>$pxest,
);
 $string=trim(json_encode($arr));
            echo $string;
?>