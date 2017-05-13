<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');

session_start();

if(!isset($_SESSION["session_username"])):
echo "no session";
else:
?>
	
<?//php include("includes/header.php"); 
$type = htmlspecialchars($_POST["type"]);
$metod = htmlspecialchars($_POST["metod"]);
$metod2 = htmlspecialchars($_POST["metod2"]);
$metod3 = htmlspecialchars($_POST["metod3"]);
$router_ip=$_SESSION['ip'];
if ($type == 'profile')
{
$_SESSION['telnumber']= preg_replace('/http:/', '',$_SESSION['telnumber']);
$_SESSION['telnumber']= preg_replace('/%20/', '',$_SESSION['telnumber']);
$_SESSION['telnumber']=trim($_SESSION['telnumber'], '/ ');
$arr = array
('type' => $type,
 'login' => $_SESSION['session_username'], 
 'name' => $_SESSION['user_nicename'], 
 'email' => $_SESSION['email'], 
  'telnumber' => $_SESSION['telnumber'], 
 'ip' => $_SESSION['ip'],
 'push' => $_SESSION['push'], 
 'pushmsg' => $_SESSION['push'], 
 'email_msg' => $_SESSION['email_msg'],  
 'mac' => $_SESSION['mac']);
 $string=trim(json_encode($arr));
            echo $string;
            $router_ip=$_SESSION['ip'];
  
         }
          elseif ($type == 'status')
{
            include("script/status.php");
}   
elseif ($type == 'news')
{
            include("script/news.php");
}   
elseif ($type == 'callbackform')
{
            include("script/callbackform.php");
}   
 elseif ($type == 'profile_change')
{
            include("script/profile_change.php");
}   
 elseif ($type == 'uuid')
{
            include("script/uuid.php");
}   
elseif ($type == 'profile_sittings')
{
            include("script/profile_sittings.php");
}        
elseif ($type == 'router_info')
{
            include("script/router_info.php");
}
elseif ($type == 'router_device')
{
           include("script/router_device.php");
}
elseif ($type == 'router_add')
{
           include("script/router_add.php");
}
elseif ($type == 'router_name')
{
           include("script/router_name.php");
}
elseif ($type == 'router_del')
{
           include("script/router_del.php");
}
elseif ($type == 'router_secret')
{
           include("script/router_secret.php");
}
elseif ($type == 'router_information')
{
           include("script/router_information.php");
}
elseif ($type == 'security')
{
 
           include("script/mikrotik_security.php");
}
elseif ($type == 'security_service')
{
 
           include("script/security_service.php");
}
elseif ($type == 'security_firewall')
{
 
           include("script/security_firewall.php");
}

elseif ($type == 'wifi_info')
{
            include("script/mikrotik_wifi_info.php");
}
elseif ($type == 'wifi_scan_fre')
{
            include("script/wifi_scan_fre.php");
}
elseif ($type == 'wifi_scan_ssid')
{
            include("script/wifi_scan_ssid.php");
}
elseif ($type == 'wifi_inform')
{
            include("script/wifi_inform.php");
}
elseif ($type == 'wifi_sitting')
{
 include("script/mikrotik_wifi_sitting.php");
}
elseif ($type == 'sitting_reboot')
{
 include("script/mikrotik_reboot.php");
}
elseif ($type == 'sitting_modules')
{
 include("script/sitting_modules.php");
}
elseif ($type == 'sitting_shaper')
{
 include("script/sitting_shaper.php");
}
elseif ($type == 'sitting_modules_set')
{
 include("script/sitting_modules_set.php");
}
elseif ($type == 'sitting_wifi_ssid')
{
 include("script/sitting_wifi_ssid.php");
}
elseif ($type == 'sitting_wifi_pasw')
{
 include("script/sitting_wifi_pasw.php");
}
elseif ($type == 'diagnostic')
{
 include("script/eth_num.php");
}
elseif ($type == 'diagnostic_ping')
{
   include("script/diagnostic_ping.php");
}
elseif ($type == 'diagnostic_traceroute')
{
   include("script/diagnostic_traceroute.php");
}
elseif ($type == 'diagnostic_speedtest')
{
   include("script/diagnostic_speedtest.php");
}
elseif ($type == 'diagnostic_all')
{
   include("script/diagnostic_all.php");
}
elseif ($type == 'eth_speed')
{
include("script/eth_speed.php");
}
?>
	
	
<?php endif; ?>