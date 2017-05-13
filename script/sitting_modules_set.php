<?php

require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;
// Snmp
if($metod=="snmp")
{
$apiString="/snmp/set";
if($metod2=="set")
{
$option="yes";

if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY = $API->comm($apiString, array(
"enabled"=> $option,
));
$API->disconnect();
}
else {
print "Ошибка соединения";
}
}
else if($metod2=="unset")
{
$option="no";

if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY = $API->comm($apiString, array(
"enabled"=> $option,
));
$API->disconnect();
}
else {
print "Ошибка соединения";
}

}
}
// Bridge

else if($metod=="bridge")
{

if ($API->connect($router_ip_long, 'support', 'support')) {

$findBridge = $API->comm("/interface/bridge/print", array(
"?name" => "bridge",
));
if(empty($findBridge))
{
$findBridge="error";
}
else
{
$findBridge="good";
$ARRAY2 = $API->comm("/interface/bridge/set", array(
"numbers"=> "bridge",
"name"=> "bridge-local",
));
}
$action="set";


$API->disconnect();

}

else {
print "Ошибка соединения";
}
}


else if($metod=="reboot")
{

if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY2 = $API->comm("/system/script/add", array(
"name"=> "reboot",
"owner"=> "support",
"policy"=> "reboot,read,write,policy",
"source"=> "system reboot",
));

$action="set";


$API->disconnect();

}

else {
print "Ошибка соединения";
}
}



else if($metod=="routerband")
{

if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY2 = $API->comm("/ip/firewall/nat/add", array(
"chain"=> "srcnat",
"action"=> "masquerade",
"dst-address"=> "10.0.0.1",
"out-interface"=> "routerband",
"log"=> "no",
"comment"=> "routerband",
));

$action="set";


$API->disconnect();

}

else {
print "Ошибка соединения";
}
}


else if($metod=="pxe")
{

if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY2 = $API->comm("/ip/dhcp-server/network/set", array(
"next-server"=> "10.0.0.1",
"boot-file-name"=> "grldr",
"comment"=> "routerband-pxe",
"numbers"=> "0",
));

$ARRAY3 = $API->comm("/ip/dhcp-server/set", array(
"name"=> "dhcppxe",
"numbers"=> "defconf",
));

$action="set";


$API->disconnect();

}

else {
print "Ошибка соединения";
}
}


else if($metod=="shaper")
{

$Layer7ver="0.1";

$Layer7Arr=array(
'Skype'=>'^..\x02.............',
'radmin'=>'^\x01\x01(\x08\x08|\x1b\x1b)$',
'rdp'=>' rdp\r\nrdpdr.*cliprdr.*rdpsnd',
'http'=>'http/(0\.9|1\.0|1\.1) [1-5][0-9][0-9]|post [\x09-\x0d -~]* http/[01]\.[019]',
'GIF_FILE'=>'gif',
'PNG_FILE'=>'png',
'yandex'=>'video.yandex.ru',
'youtube'=>'googlevideo.com',
'rutube'=>'rutube.ru',
'odnoklassniki'=>'odnoklassniki.ru',
'version'=>'');



if ($API->connect($router_ip_long, 'support', 'support')) {


// Layer7Fliter
foreach($Layer7Arr as $key => $value)
   {

$Layer7 = $API->comm("/ip/firewall/layer7-protocol/add", array(
"name"=> $key,
"comment"=> $Layer7ver,
"regexp"=>$value,
));

   }

$AdressListver="0.1";
$AdressList=array(
'GROUP-A'=>'192.168.0.1',
'GROUP-B'=>'192.168.0.2',
'GROUP-D'=>'192.168.88.0/24',
'GROUP-C'=>'192.168.88.0.4',
'CLASS-A-SITES'=>'0.0.0.0',
'CLASS-B-SITES'=>'0.0.0.0',
'CLASS-C-SITES'=>'0.0.0.0',
'vkontakte'=>'87.240.128.0/18',
'version'=>'');

// Address List
foreach($AdressList as $key => $value)
   {

$AdressListQue = $API->comm("/ip/firewall/address-list/add", array(
"list"=> $key,
"comment"=> $AdressListver,
"address"=>$value,
"disabled"=>"no"
));

   }



$mangleVer="0.1";
$mangle['CLASS-D-GROUP-D-DL']['CLASS-D']='GROUP-D';
$mangle['CLASS-D-GROUP-C-DL']['CLASS-D']='GROUP-C';
$mangle['CLASS-D-GROUP-B-DL']['CLASS-D']='GROUP-B';
$mangle['CLASS-D-GROUP-A-DL']['CLASS-D']='GROUP-A';


// mangle
foreach($mangle as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$test=$value;


$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-packet",
"comment"=> $key,
"chain"=>"forward",
"connection-mark"=>$key2,
"src-address-list"=>"!ShaperExclude",
"new-packet-mark"=>$key,
"passthrough"=>"yes",
"dst-address-list"=>$value
));
}
   }



$mangle5['CLASS-D-GROUP-D-UP']['CLASS-D']='GROUP-D';
$mangle5['CLASS-D-GROUP-C-UP']['CLASS-D']='GROUP-C';
$mangle5['CLASS-D-GROUP-B-UP']['CLASS-D']='GROUP-B';
$mangle5['CLASS-D-GROUP-A-UP']['CLASS-D']='GROUP-A';
// mangle
foreach($mangle5 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$test=$value;


$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-packet",
"comment"=> $key,
"chain"=>"prerouting",
"connection-mark"=>$key2,
"dst-address-list"=>"!ShaperExclude",
"new-packet-mark"=>$key,
"passthrough"=>"yes",
"src-address-list"=>$value
));
}
   }
   
   
   
   
   
//Single
$AllTraffic = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"comment"=> "ALLTRAFIC",
"chain"=>"forward",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-D",
"passthrough"=>"yes"
));




$manglePort=array(
'Proxy'=>'3128',
'HTTPS'=>'443',
'FTP'=>'20,21',
'SMTP'=>'25',
'SMTPS'=>'465',
'Imap'=>'143',
'POP3S'=>'995',
'POP3'=>'110',
'IMAPS'=>'993',
);

// manglePort
foreach($manglePort as $key => $value)
   {

$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> $key,
"dst-port"=>$value,
"disabled"=>"no",
"new-connection-mark"=>"CLASS-C",
"passthrough"=>"yes",
"protocol"=>"tcp"
));

   }





$mangleL7=array(
'GIF_FILE'=>'GIF_FILE',
'PNG_FILE'=>'PNG_FILE',
'HTTP'=>'http',
'YouTube'=>'youtube',
'RuTube'=>'rutube',
'odnoklassniki'=>'odnoklassniki'
);

// mangL7
foreach($mangleL7 as $key => $value)
   {

$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> $key,
"layer7-protocol"=>$value,
"disabled"=>"no",
"new-connection-mark"=>"CLASS-C",
"passthrough"=>"yes",
"protocol"=>"tcp"
));

   }
   
   
   //Single
//1


$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "vkontakte",
"src-address-list"=>"vkontakte",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-C",
"passthrough"=>"yes"
));

$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "CLASS-C-SITES",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-C",
"passthrough"=>"yes",
"src-address-list"=>"CLASS-C-SITES"
));


$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "CLASS-C-SITES",
"dst-address-list"=>"CLASS-C-SITES",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-C",
"passthrough"=>"yes",
));


$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "100Kb Connections",
"connection-bytes"=>"0-100000",
"protocol"=>"tcp",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-C",
"passthrough"=>"yes"
));




$mangle2['CLASS-D-GROUP-D-DL']['CLASS-C']='GROUP-D';
$mangle2['CLASS-D-GROUP-C-DL']['CLASS-C']='GROUP-C';
$mangle2['CLASS-D-GROUP-B-DL']['CLASS-C']='GROUP-B';
$mangle2['CLASS-D-GROUP-A-DL']['CLASS-C']='GROUP-A';

// mangle
foreach($mangle2 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-packet",
"comment"=> $key,
"chain"=>"forward",
"connection-mark"=>$key2,
"src-address-list"=>"!ShaperExclude",
"new-packet-mark"=>$key,
"passthrough"=>"yes",
"disabled"=>"no",
"dst-address-list"=>$value,
));
}
   }


$mangle3['CLASS-D-GROUP-D-UP']['CLASS-C']='GROUP-D';
$mangle3['CLASS-D-GROUP-C-UP']['CLASS-C']='GROUP-C';
$mangle3['CLASS-D-GROUP-B-UP']['CLASS-C']='GROUP-B';
$mangle3['CLASS-D-GROUP-A-UP']['CLASS-C']='GROUP-A';

// mangle
foreach($mangle3 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-packet",
"comment"=> $key,
"chain"=>"prerouting",
"disabled"=>"no",
"connection-mark"=>$key2,
"src-address-list"=>$value,
"new-packet-mark"=>$key,
"passthrough"=>"yes",
"dst-address-list"=>"!ShaperExclude"
));
}
   }



$manglePort=array(
'ICQ'=>'5190',
'Mail.ru Agent'=>'2041,2042',
'IRC'=>'6667-6669',
'SSH'=>'22',
'TELNET'=>'23',
'SNMP'=>'161-162',
'PPTP'=>'1723',
);

// manglePort
foreach($manglePort as $key => $value)
   {

$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> $key,
"dst-port"=>$value,
"disabled"=>"no",
"new-connection-mark"=>"CLASS-B",
"passthrough"=>"yes",
"protocol"=>"tcp"
));

   }



$mangle2Port=array(
'Jabber'=>'Jabber',
'Skype'=>'Skype',
);

// l7Port
foreach($mangle2Port as $key => $value)
   {

$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> $key,
"layer7-protocol"=>$value,
"disabled"=>"no",
"new-connection-mark"=>"CLASS-B",
"passthrough"=>"yes"
));

//Single
$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "L2TP",
"dst-port"=>"1701",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-B",
"passthrough"=>"yes",
"protocol"=>"udp"
));

$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "CLASS-B-SITES",
"src-address-list"=>"CLASS-B-SITES",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-B",
"passthrough"=>"yes"
));


$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "CLASS-B-SITES",
"dst-address-list"=>"CLASS-B-SITES",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-B",
"passthrough"=>"yes"
));


$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "50b Connections",
"connection-bytes"=>"0-50000",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-B",
"passthrough"=>"yes",
"protocol"=>"tcp"
));

   }





$mangle6['CLASS-B-GROUP-D-DL']['CLASS-B']='GROUP-D';
$mangle6['CLASS-B-GROUP-C-DL']['CLASS-B']='GROUP-C';
$mangle6['CLASS-B-GROUP-B-DL']['CLASS-B']='GROUP-B';
$mangle6['CLASS-B-GROUP-A-DL']['CLASS-B']='GROUP-A';

// mangle
foreach($mangle6 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-packet",
"comment"=> $key,
"chain"=>"forward",
"connection-mark"=>$key2,
"dst-address-list"=>$value,
"new-packet-mark"=>$key,
"passthrough"=>"yes",
"disabled"=>"no",
"src-address-list"=>"!ShaperExclude",
));
}
   }


$mangle7['CLASS-B-GROUP-D-UP']['CLASS-B']='GROUP-D';
$mangle7['CLASS-B-GROUP-C-UP']['CLASS-B']='GROUP-C';
$mangle7['CLASS-B-GROUP-B-UP']['CLASS-B']='GROUP-B';
$mangle7['CLASS-B-GROUP-A-UP']['CLASS-B']='GROUP-A';

// mangle
foreach($mangle7 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-packet",
"comment"=> $key,
"chain"=>"prerouting",
"disabled"=>"no",
"connection-mark"=>$key2,
"dst-address-list"=>"!ShaperExclude",
"new-packet-mark"=>$key,
"passthrough"=>"yes",
"src-address-list"=>$value,
));
}
   }



$manglePort=array(
'DNS'=>'53',
'NNTP'=>'119',
'Winbox'=>'8291',
'VNC'=>'5900-5901',
);

// manglePort
foreach($manglePort as $key => $value)
   {

$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> $key,
"dst-port"=>$value,
"disabled"=>"no",
"new-connection-mark"=>"CLASS-A",
"passthrough"=>"yes",
"protocol"=>"tcp"
));

   }
//Single


$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "ntp",
"dst-port"=>"123",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-A",
"passthrough"=>"yes",
"protocol"=>"udp"
));

$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "DNS",
"dst-port"=>"53",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-A",
"passthrough"=>"yes",
"protocol"=>"udp"
));

$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "Radmin",
"layer7-protocol"=>"radmin",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-A",
"passthrough"=>"yes"
));


$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "rdp",
"layer7-protocol"=>"rdp",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-A",
"passthrough"=>"yes"
));

$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "PING",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-A",
"passthrough"=>"yes",
"protocol"=>"icmp"
));



$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "CLASS-A-SITES",
"src-address-list"=>"CLASS-A-SITES",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-A",
"passthrough"=>"yes"
));


$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "CLASS-A-SITES",
"dst-address-list"=>"CLASS-A-SITES",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-A",
"passthrough"=>"yes"
));


$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-connection",
"chain"=>"forward",
"comment"=> "5 Kbites",
"connection-bytes"=>"0-5000",
"disabled"=>"no",
"new-connection-mark"=>"CLASS-A",
"passthrough"=>"yes",
"protocol"=>"tcp"
));



$mangle8['CLASS-A-GROUP-D-DL']['CLASS-A']='GROUP-D';
$mangle8['CLASS-A-GROUP-C-DL']['CLASS-A']='GROUP-C';
$mangle8['CLASS-A-GROUP-B-DL']['CLASS-A']='GROUP-B';
$mangle8['CLASS-A-GROUP-A-DL']['CLASS-A']='GROUP-A';

// mangle
foreach($mangle8 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-packet",
"comment"=> $key,
"chain"=>"forward",
"connection-mark"=>$key2,
"dst-address-list"=>$value,
"new-packet-mark"=>$key,
"passthrough"=>"yes",
"disabled"=>"no",
"src-address-list"=>"!ShaperExclude",
));
}
   }


$mangle9['CLASS-A-GROUP-D-UP']['CLASS-A']='GROUP-D';
$mangle9['CLASS-A-GROUP-C-UP']['CLASS-A']='GROUP-C';
$mangle9['CLASS-A-GROUP-B-UP']['CLASS-A']='GROUP-B';
$mangle9['CLASS-A-GROUP-A-UP']['CLASS-A']='GROUP-A';

// mangle
foreach($mangle9 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"action"=> "mark-packet",
"comment"=> $key,
"chain"=>"prerouting",
"disabled"=>"no",
"connection-mark"=>$key2,
"dst-address-list"=>"!ShaperExclude",
"new-packet-mark"=>$key,
"passthrough"=>"yes",
"src-address-list"=>$value,
));
}
   }


// Version control


$mangleQue = $API->comm("/ip/firewall/mangle/add", array(
"comment"=> $mangleVer,
"chain"=>"forward",
"disabled"=>"yes",
"layer7-protocol"=>"version",
));


$action="set";

//queue type


$queueType="0.1";
$queType=array(
'GROUP-A-DL'=>'50',
'GROUP-B-DL'=>'50',
'GROUP-D-DL'=>'50',
'GROUP-C-DL'=>'50');


foreach($queType as $key => $value)   
{   
$mangleQue = $API->comm("/queue/type/add", array(
"kind"=> "pcq",
"name"=> $key,
"pcq-burst-rate"=>"0",
"pcq-burst-threshold"=>"0",
"pcq-burst-time"=>"10s",
"pcq-classifier"=>"dst-address",
"pcq-dst-address-mask"=>"32",
"pcq-dst-address6-mask"=>"64",
"pcq-limit"=>$value,
"pcq-rate"=>"0",
"pcq-total-limit"=>"2000",
"pcq-src-address-mask"=>"32",
"pcq-src-address6-mask"=>"64"
));
}

$queType2=array(
'GROUP-A-UP'=>'150',
'GROUP-B-UP'=>'150',
'GROUP-D-UP'=>'150',
'GROUP-C-UP'=>'150');


foreach($queType2 as $key => $value)   
{   
$mangleQue = $API->comm("/queue/type/add", array(
"kind"=> "pcq",
"name"=> $key,
"pcq-burst-rate"=>"0",
"pcq-burst-threshold"=>"0",
"pcq-burst-time"=>"10s",
"pcq-classifier"=>"src-address",
"pcq-dst-address-mask"=>"32",
"pcq-dst-address6-mask"=>"64",
"pcq-limit"=>$value,
"pcq-rate"=>"0",
"pcq-total-limit"=>"2000",
"pcq-src-address-mask"=>"32",
"pcq-src-address6-mask"=>"64"
));
}

//Version

$QueVer = $API->comm("/queue/type/add", array(
"kind"=> "none",
"name"=> "version"
));

//queue Tree


//UpLink

$QueQue = $API->comm("/queue/tree/add", array(
"name"=> "DOWNLOAD",
"parent"=> "global",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"40M",
"priority"=>"8"
));


$QueQue = $API->comm("/queue/tree/add", array(
"name"=> "UPLOAD",
"parent"=> "global",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"40M",
"priority"=>"8"
));


//GROUP A Upload
$QueQue = $API->comm("/queue/tree/add", array(
"name"=> "GROUP-A-UP",
"parent"=> "UPLOAD",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"priority"=>"8"
));



$Que1['CLASS-AA-UP']['CLASS-A-GROUP-A-UP']='1';
$Que1['CLASS-BA-UP']['CLASS-B-GROUP-A-UP']='2';
$Que1['CLASS-CA-UP']['CLASS-C-GROUP-A-UP']='3';
$Que1['CLASS-DA-UP']['CLASS-D-GROUP-A-UP']='4';

foreach($Que1 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$Que = $API->comm("/queue/tree/add", array(
"name"=> $key,
"parent"=> "GROUP-A-UP",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"packet-mark"=>$key2,
"queue"=>"GROUP-A-UP",
"priority"=>$value
));
}
   }
   
   
// GROUP B Upload

$QueQue = $API->comm("/queue/tree/add", array(
"name"=> "GROUP-B-UP",
"parent"=> "UPLOAD",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"priority"=>"8"
));



$Que2['CLASS-AB-UP']['CLASS-A-GROUP-B-UP']='2';
$Que2['CLASS-BB-UP']['CLASS-B-GROUP-B-UP']='3';
$Que2['CLASS-CB-UP']['CLASS-C-GROUP-B-UP']='4';
$Que2['CLASS-DB-UP']['CLASS-D-GROUP-B-UP']='5';

foreach($Que2 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$Que = $API->comm("/queue/tree/add", array(
"name"=> $key,
"parent"=> "GROUP-B-UP",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"packet-mark"=>$key2,
"queue"=>"GROUP-B-UP",
"priority"=>$value
));
}
   }



// GROUP C Upload

$QueQue = $API->comm("/queue/tree/add", array(
"name"=> "GROUP-C-UP",
"parent"=> "UPLOAD",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"priority"=>"8"
));



$Que3['CLASS-AC-UP']['CLASS-A-GROUP-C-UP']='3';
$Que3['CLASS-BC-UP']['CLASS-B-GROUP-C-UP']='4';
$Que3['CLASS-CC-UP']['CLASS-C-GROUP-C-UP']='5';
$Que3['CLASS-DC-UP']['CLASS-D-GROUP-C-UP']='6';

foreach($Que3 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$Que = $API->comm("/queue/tree/add", array(
"name"=> $key,
"parent"=> "GROUP-C-UP",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"packet-mark"=>$key2,
"queue"=>"GROUP-C-UP",
"priority"=>$value
));
}
   }
   
   // GROUP D Upload

$QueQue = $API->comm("/queue/tree/add", array(
"name"=> "GROUP-D-UP",
"parent"=> "UPLOAD",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"priority"=>"8"
));



$Que4['CLASS-AD-UP']['CLASS-A-GROUP-D-UP']='4';
$Que4['CLASS-BD-UP']['CLASS-B-GROUP-D-UP']='5';
$Que4['CLASS-CD-UP']['CLASS-C-GROUP-D-UP']='6';
$Que4['CLASS-DD-UP']['CLASS-D-GROUP-D-UP']='7';

foreach($Que4 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$Que = $API->comm("/queue/tree/add", array(
"name"=> $key,
"parent"=> "GROUP-D-UP",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"packet-mark"=>$key2,
"queue"=>"GROUP-D-UP",
"priority"=>$value
));
}
   }
   
   
   //DOWNLOAD
   // GROUP A Download

$QueQue = $API->comm("/queue/tree/add", array(
"name"=> "GROUP-A-DL",
"parent"=> "DOWNLOAD",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"priority"=>"8"
));



$Que5['CLASS-AA-DL']['CLASS-A-GROUP-A-DL']='1';
$Que5['CLASS-BA-DL']['CLASS-B-GROUP-A-DL']='2';
$Que5['CLASS-CA-DL']['CLASS-C-GROUP-A-DL']='3';
$Que5['CLASS-DA-DL']['CLASS-D-GROUP-A-DL']='4';

foreach($Que5 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$Que = $API->comm("/queue/tree/add", array(
"name"=> $key,
"parent"=> "GROUP-A-DL",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"packet-mark"=>$key2,
"queue"=>"GROUP-A-DL",
"priority"=>$value
));
}
   } 



  // GROUP B Download

$QueQue = $API->comm("/queue/tree/add", array(
"name"=> "GROUP-B-DL",
"parent"=> "DOWNLOAD",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"priority"=>"8"
));



$Que6['CLASS-AB-DL']['CLASS-A-GROUP-B-DL']='2';
$Que6['CLASS-BB-DL']['CLASS-B-GROUP-B-DL']='3';
$Que6['CLASS-CB-DL']['CLASS-C-GROUP-B-DL']='4';
$Que6['CLASS-DB-DL']['CLASS-D-GROUP-B-DL']='5';

foreach($Que6 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$Que = $API->comm("/queue/tree/add", array(
"name"=> $key,
"parent"=> "GROUP-B-DL",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"packet-mark"=>$key2,
"queue"=>"GROUP-B-DL",
"priority"=>$value
));
}
   } 


  // GROUP C Download

$QueQue = $API->comm("/queue/tree/add", array(
"name"=> "GROUP-C-DL",
"parent"=> "DOWNLOAD",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"priority"=>"8"
));



$Que7['CLASS-AC-DL']['CLASS-A-GROUP-C-DL']='3';
$Que7['CLASS-BC-DL']['CLASS-B-GROUP-C-DL']='4';
$Que7['CLASS-CC-DL']['CLASS-C-GROUP-C-DL']='5';
$Que7['CLASS-DC-DL']['CLASS-D-GROUP-C-DL']='6';

foreach($Que7 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$Que = $API->comm("/queue/tree/add", array(
"name"=> $key,
"parent"=> "GROUP-C-DL",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"packet-mark"=>$key2,
"queue"=>"GROUP-C-DL",
"priority"=>$value
));
}
   } 



 // GROUP D Download

$QueQue = $API->comm("/queue/tree/add", array(
"name"=> "GROUP-D-DL",
"parent"=> "DOWNLOAD",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"priority"=>"8"
));



$Que8['CLASS-AD-DL']['CLASS-A-GROUP-D-DL']='4';
$Que8['CLASS-BD-DL']['CLASS-B-GROUP-D-DL']='5';
$Que8['CLASS-CD-DL']['CLASS-C-GROUP-D-DL']='6';
$Que8['CLASS-DD-DL']['CLASS-D-GROUP-D-DL']='7';

foreach($Que8 as $key => $items)
   {
 
foreach($items as $key2 => $value)   
{   
$Que = $API->comm("/queue/tree/add", array(
"name"=> $key,
"parent"=> "GROUP-D-DL",
"burst-limit"=>"0",
"burst-threshold"=>"0",
"burst-time"=>"0s",
"disabled"=>"no",
"limit-at"=>"0",
"max-limit"=>"0",
"packet-mark"=>$key2,
"queue"=>"GROUP-D-DL",
"priority"=>$value
));
}
   } 

// Version control

$QueTreeVer="0.1";

$Que = $API->comm("/queue/tree/add", array(
"comment"=> $QueTreeVer,
"parent"=>"global",
"disabled"=>"yes",
"name"=>"version",
));

$API->disconnect();

}

else {
print "Ошибка соединения";
}




}
else
{
}

$arr=array(
'type'=>'sitting_modules_set',
'metod'=>$metod,
'action'=>$metod2,
'status'=>$test);
$string=trim(json_encode($arr));
            echo $string;


//print_r($ARRAY2);
?>