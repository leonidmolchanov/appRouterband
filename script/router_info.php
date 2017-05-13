


<?php
$router_ip_long=long2ip($router_ip);

$sysres['1'] = snmpwalk($router_ip_long, "public", ".1.3.6.1.2.1.1.3.0");
$sysres['1']['0']=str_replace('STRING:', '', $sysres['1']['0']);
$sysres['1']['0'] = str_replace('"', '', $sysres['1']['0']); 
$sysres_clear=explode(")", $sysres['1']['0']);
$sysres['2'] = snmpwalk($router_ip_long, "public", "iso.3.6.1.2.1.47.1.1.1.1.2.65536");
$sysres['2']['0']=str_replace('STRING:', '', $sysres['2']['0']);
$sysres['2']['0'] = str_replace('"', '', $sysres['2']['0']); 
$sysres['6'] = snmpwalk($router_ip_long, "public", "iso.3.6.1.2.1.25.2.3.1.6.65536");
$sysres['6']['0']=str_replace('INTEGER:', '', $sysres['6']['0']);
$sysres['6']['0'] = str_replace('"', '', $sysres['6']['0']); 
$sysres['7'] = snmpwalk($router_ip_long, "public", "iso.3.6.1.2.1.25.2.3.1.5.65536");
$sysres['7']['0']=str_replace('INTEGER:', '', $sysres['7']['0']);
$sysres['7']['0'] = str_replace('"', '', $sysres['7']['0']); 
$sysres['8'] = snmpwalk($router_ip_long, "public", "iso.3.6.1.2.1.47.1.1.1.1.7.65536");
$sysres['8']['0']=str_replace('STRING:', '', $sysres['8']['0']);
$sysres['8']['0'] = str_replace('"', '', $sysres['8']['0']); 
$sysres['11'] = snmpwalk($router_ip_long, "public", ".1.3.6.1.2.1.25.3.3.1.2.1");
$sysres['11']['0']=str_replace('INTEGER:', '', $sysres['11']['0']);
$sysres['11']['11'] = str_replace('"', '', $sysres['11']['0']); 
$sysres['12'] = snmpwalk($router_ip_long, "public", "iso.3.6.1.2.1.25.2.3.1.6.131072");
$sysres['12']['0']=str_replace('INTEGER:', '', $sysres['12']['0']);
$sysres['12']['12'] = str_replace('"', '', $sysres['12']['0']); 
$sysres['13'] = snmpwalk($router_ip_long, "public", "iso.3.6.1.2.1.25.2.3.1.5.131072");
$sysres['13']['0']=str_replace('INTEGER:', '', $sysres['13']['0']);
$sysres['13']['0'] = str_replace('"', '', $sysres['13']['0']); 
$client_interface = snmpwalk($router_ip_long, "public", "iso.3.6.1.2.1.2.2.1.2");
$client_interface_count=count($client_interface);
$arr2 = [];
 $arr2[count]=$client_interface_count;
for($i =1; $i <= $client_interface_count; $i++) {
 $client_interface[$i-1]=str_replace('STRING:', '', $client_interface[$i-1]);
$client_interface[$i-1] = str_replace('"', '', $client_interface[$i-1]);
   $arr2[$i] = $client_interface[$i-1];
}

$arr = array
('type' => router_info,
 'info' => 
 array(
 'uptime' => $sysres_clear[1],
 'version'=>$sysres['2']['0'],
 'memory_free' => $sysres['6']['0'],
 'memory_full'=>$sysres['7']['0'],
 'proc_type' => $sysres['8']['0'],
 'proc_work'=>$sysres['11']['0'],
 'free_space' => $sysres['12']['0'],
 'full_space'=>$sysres['13']['0'],
 ) 
 
 
 , 
 'iface' =>$arr2
 
 
 );
 $string=trim(json_encode($arr));
            echo $string;

?>

