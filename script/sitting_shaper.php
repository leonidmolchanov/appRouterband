<?php
require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support')) {

$L7Arr = $API->comm("/ip/firewall/layer7-protocol/print", array(
));

$ALArr = $API->comm("/ip/firewall/address-list/print", array(
));

$mangleArr = $API->comm("/ip/firewall/mangle/print", array(
));

$QueTreeArr = $API->comm("/queue/tree/print", array(
));

$QueTypeArr = $API->comm("/queue/type/print", array(
));
$API->disconnect();
}
else {
print "Ошибка со";
}


$L7Ver="false";
foreach($L7Arr as $key => $value)   
{   
if($value['name']=="version")
{
$L7Ver=$value['comment'];
}
else
{
}
}

$mangleVer="false";
foreach($mangleArr as $key => $value)   
{   
if($value['layer7-protocol']=="version")
{
$mangleVer=$value['comment'];
}
else
{
}
}
$ALVer="false";
foreach($ALArr as $key => $value)   
{   
if($value['list']=="version")
{
$ALVer=$value['comment'];
}
else
{
}
}


foreach($QueTreeArr as $key => $value)   
{   
$QueTreeVer="false";
if($value['name']=="version")
{
$QueTreeVer=$value['comment'];
}
else
{
}
}

$QueTypeVer="false";
foreach($QueTypeArr as $key => $value)   
{   
if($value['name']=="version")
{
$QueTypeVer="true";
}
else
{
}
}

//APP

foreach($mangleArr as $key => $value)   
{   

$appSkype="false";
if($value['comment']=="Skype")
{
$appSkype=$value['new-connection-mark'];

if($appSkype=="CLASS-A")
{
$appSkypeStr=0;
}

else if($appSkype=="CLASS-B")
{
$appSkypeStr=1;
}

else if($appSkype=="CLASS-C")
{
$appSkypeStr=2;
}

else if($appSkype=="CLASS-D")
{
$appSkypeStr=3;
}

else
{
$appSkypeStr="false";
}

}
else
{
}
}

// VIDEO

//YouTube

$videoYouTubeStr="false";
foreach($mangleArr as $key => $value)   
{   


if($value['comment']=="YouTube")
{
$videoYouTube=$value['new-connection-mark'];

if($videoYouTube=="CLASS-A")
{
$videoYouTubeStr=0;
}

else if($videoYouTube=="CLASS-B")
{
$videoYouTubeStr=1;
}

else if($videoYouTube=="CLASS-C")
{
$videoYouTubeStr=2;
}

else if($videoYouTube=="CLASS-D")
{
$videoYouTubeStr=3;
}

else
{
$videoYouTubeStr="false";
}

}
else
{
}
}



//RuTube

$videoRuTubeStr="false";
foreach($mangleArr as $key => $value)   
{   


if($value['comment']=="RuTube")
{
$videoRuTube=$value['new-connection-mark'];

if($videoRuTube=="CLASS-A")
{
$videoRuTubeStr=0;
}

else if($videoRuTube=="CLASS-B")
{
$videoRuTubeStr=1;
}

else if($videoRuTube=="CLASS-C")
{
$videoRuTubeStr=2;
}

else if($videoRuTube=="CLASS-D")
{
$videoRuTubeStr=3;
}

else
{
$videoRuTubeStr="false";
}

}
else
{
}
}
// Social
// Vkontakte


$SocialVkStr="false";
foreach($mangleArr as $key => $value)   
{   


if($value['comment']=="vkontakte")
{
$SocialVk=$value['new-connection-mark'];

if($SocialVk=="CLASS-A")
{
$SocialVkStr=0;
}

else if($SocialVk=="CLASS-B")
{
$SocialVkStr=1;
}

else if($SocialVk=="CLASS-C")
{
$SocialVkStr=2;
}

else if($SocialVk=="CLASS-D")
{
$SocialVkStr=3;
}

else
{
$SocialVkStr="false";
}

}
else
{
}
}


// Odnoklassniki


$SocialOdnoklassnikiStr="false";
foreach($mangleArr as $key => $value)   
{   


if($value['comment']=="odnoklassniki")
{
$SocialOdnoklassniki=$value['new-connection-mark'];

if($SocialOdnoklassniki=="CLASS-A")
{
$SocialOdnoklassnikiStr=0;
}

else if($SocialOdnoklassniki=="CLASS-B")
{
$SocialOdnoklassnikiStr=1;
}

else if($SocialOdnoklassniki=="CLASS-C")
{
$SocialOdnoklassnikiStr=2;
}

else if($SocialOdnoklassniki=="CLASS-D")
{
$SocialOdnoklassnikiStr=3;
}

else
{
$SocialOdnoklassnikiStr="false";
}

}
else
{
}
}

//Uplink info

$QueDL="false";
foreach($QueTreeArr as $key => $value)   
{   
if($value['name']=="DOWNLOAD")
{
//$QueDL=$value['max-limit'];
$QueDL=$value['max-limit'];
}
else
{
}
}


$QueUP="false";
foreach($QueTreeArr as $key => $value)   
{   
if($value['name']=="UPLOAD")
{
$QueUP=$value['max-limit'];
}
else
{
}
}

$arr=Array(
'type'=>'sitting_shaper',
'layer7'=>$L7Ver,
'ALVer'=>$ALVer,
'mangleVer'=>$mangleVer,
'QueTreeVer'=>$QueTreeVer,
'QueTypeVer'=>$QueTypeVer,
'app'=>Array(
'Skype'=>$appSkypeStr
),
'video'=>Array(
'YouTube'=>$videoYouTubeStr,
'RuTube'=>$videoRuTubeStr
),
'social'=>Array(
'vkontakte'=>$SocialVkStr,
'odnoklassniki'=>$SocialOdnoklassnikiStr
),
'uplink'=>Array(
'download'=>$QueDL,
'upload'=>$QueUP
)
);


 $string=trim(json_encode($arr));
 $string=str_replace("-", "_", $string);
            echo $string;
?>