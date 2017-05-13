<?php
require('routeros_api.class.php');

$API = new routeros_api();
$router_ip_long=long2ip($router_ip);
$API->debug = false;

if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY = $API->comm("/interface/wireless/frequency-monitor", array(
"number"=> "wlan1",
 "duration"=> "10", 
));
$int_down = $API->comm("/interface/wireless/disable", array(
"numbers"=> "wlan1",
));
$int_up = $API->comm("/interface/wireless/enable", array(
"numbers"=> "wlan1",
));

$API->disconnect();
}
else {
print "Ошибка соединения";
}
$count=count($ARRAY)-1;
for ($i =0; $i<=count($ARRAY)-1; $i++)
{
  $fre=$ARRAY[$i]['freq'];
  settype($fre, integer);
  $use=$ARRAY[$i]['use'];
  settype($use, integer); 
   $nf=$ARRAY[$i]['nf'];
  settype($nf, integer); 
  $section=$ARRAY[$i]['.section'];
  settype($section, integer); 
  
  $arr2[$fre]['fre']=$fre;
    $arr2[$fre]['use']=$arr2[$fre]['use']+$use;
     $arr2[$fre]['nf']=$arr2[$fre]['nf']+$nf;

}

for ($i =1; $i<=count($arr2)-1; $i++)
{
$arr3[$i]=current($arr2);
$arr3[$i+1]=next($arr2);
}
if (empty($arr3)) {
 $arr3="deny";
}
else
{
}
$arr=Array(
'type'=>'wifi_scan_fre',
'count'=>count($arr2),
'body'=>$arr3,
);


 $string=trim(json_encode($arr));
            echo $string;
?>
