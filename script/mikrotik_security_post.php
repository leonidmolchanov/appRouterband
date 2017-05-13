<?php


$router_ip_long=long2ip($router_ip);
$mac_process;
$json;
$json['mac']=$mac_address;
require('routeros_api.class.php');

//echo strpos($mac_process, 'block');

if ($mac_process == 'block')
{
$json["type"]="block";
$API = new routeros_api();
//$router_ip_long=long2ip($router_ip);

$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support'))
	 {
// Выбор правила
 if ($type_block == 'true'){
$json["metod"]="nat";
$ARRAY = $API->comm("/ip/firewall/nat/add", array(
 "chain"=> "dstnat",
 "action"=> "dst-nat",
 "to-addresses"=> "10.11.12.1",
 "to-ports"=> "8080",
 "protocol"=> "tcp",
 "dst-port"=> "80",
 "src-mac-address"=> $mac_address, 
  "log"=> "no",
));
  }
 else{
 $json["metod"]="easy";
$ARRAY = $API->comm("/ip/firewall/filter/add", array(
 "action"=> "drop",
  "src-mac-address"=> $mac_address, 
  "chain"=> "forward",
));

  }

$API->disconnect();



	}

}




elseif ($mac_process == 'unblock')
 			{
$json["metod"]="null";
$json["type"]="unblock";

$API = new routeros_api();
//$router_ip_long=long2ip($router_ip);

$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support'))
{
$kv='"';
//$find_mac='[find src-mac-address="$mac_process"]';
$find_mac_1='[find src-mac-address="';
$find_mac_2='"]';
$find_mac_3="'";
$find_mac=$find_mac_1.$mac_address.$find_mac_2;



$kv='"';
$find_mac=$kv.$find_mac;
$find_mac=$find_mac.$kv;

$ARRAY = $API->comm("/ip/firewall/filter/print", array(
"?src-mac-address" => $mac_address,
));

$ARRAY2 = $API->comm("/ip/firewall/filter/remove", array(
"numbers" => $ARRAY['0']['.id'],
));

$ARRAY_nat = $API->comm("/ip/firewall/nat/print", array(
"?src-mac-address" => $mac_address,
));



$ARRAY2_nat = $API->comm("/ip/firewall/nat/remove", array(
"numbers" => $ARRAY_nat['0']['.id'],
));

$API->disconnect();



	}


			}




?>