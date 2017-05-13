<?php
function Ping(){
// false proxy used to generate connection error
$ProxyServer = $_SESSION['ip'];
$ProxyPort = 8728;
$timeout=10;
// must use next two statements
Set_Time_Limit(0); //Time for script to run .. not sure how it works with 0 but you need it
Ignore_User_Abort(True); //this will force the script running at the end

$handle = fsockopen($ProxyServer, $ProxyPort,$errno,$errstr,$timeout); 
if (!$handle){
$result=$errstr;
$arr=array(
'metod'=>"api",
'result'=>$result,
);
print_r($arr);
return 0;
}
else {
// copied method for PING like time operation
$status = socket_get_status($handle);

//Time the responce
list($usec, $sec) = explode(" ", microtime(true));
$start=(float)$usec + (float)$sec;


$timeout=120;
stream_set_timeout($handle,$timeout); 
//send somthing
ini_set('display_errors','0');
$write=fwrite($handle,"echo this\n");
if(!$write){
return 0;
}

stream_set_blocking($handle,0); 
//Try to read. the server will most likely respond with a "ICMP Destination Unreachable" and end the read. But that is a responce!
fread($handle,1024);
fclose($handle);
$arr=array(
'metod'=>"api",
'result'=>'true',
);
print_r($arr);
ini_set('display_errors','1');

//Work out if we got a responce and time it 
list($usec, $sec) = explode(" ", microtime(true));
$laptime=((float)$usec + (float)$sec)-$start;
if($laptime>$timeout)
return 0;
//else 
// $laptime = round($laptime,3);
return $laptime;

}
}

// must use ErrorHandler to avoid php error being printed to screen
function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
{
// you can set this to what ever you like.
return 0;
}

$old_error_handler = set_error_handler("userErrorHandler");

$time = Ping();

?>