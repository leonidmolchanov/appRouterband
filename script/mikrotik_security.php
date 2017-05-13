
<?php

 
// Соединение с роутером
require('routeros_api.class.php');
$router_ip_long=long2ip($router_ip);
$API = new routeros_api();
$API->debug = false;
if ($API->connect($router_ip_long, 'support', 'support')) {

$ARRAY = $API->comm("/interface/wireless/security-profiles/print", array(

));
// ARP-table
$ARRAY2 = $API->comm("/ip/arp/print", array(
 
));
// Получаем список dhcp коиентов
$ARRAY3 = $API->comm("/ip/dhcp-server/lease/print", array(
 
));
$API->disconnect();
?>

<?


}
else {
print "Ошибка соединения";
}
//print_r($ARRAY3);






// Массивы для JSON
$arr_ip = [];
$arr_host = [];
$arr_mac = []; 
$arr_action = []; 
// Отладка циклов
$count_array2=count($ARRAY2);
$count_array2=$count_array2-1;
$count_array3=count($ARRAY3);
$count_array3=$count_array3-1;

//Общий цыкл
for ($i =0; $i <=$count_array2; $i++)
{
    
// Проверка нулевых данных в таблице
if (empty($arr_ip[$i]) == true)    
{
$arr_ip[$i]="Не определен";
}
else
{
}


if (empty($arr_host[$i]) == true)    
{
$arr_host[$i]="Не определено";
}
else
{
}


if (empty($arr_mac[$i]) == true)    
{
$arr_mac[$i]="none";
}
else
{
}    
 // Отбираем только бридж интерфейс   
if (strpos($ARRAY2[$i]['interface'], 'bridge-local') !== false)
{

// Вывод ip
$arr_ip[$i]=$ARRAY2[$i]['address'];

// Процес сверки имяни
for ($y =0; $y <=$count_array3; $y++)
{
if ($ARRAY2[$i]['address']==$ARRAY3[$y]['address'])
{
if (empty($ARRAY3[$y]['host-name']) == false)
{
     $arr_host[$i] = $ARRAY3[$y]['host-name'];

}
else
{
}
}

else {
  
	}
}

// Вывод mac
if (empty($ARRAY2[$i]['mac-address']) == false)
{
    $arr_mac[$i] = $ARRAY2[$i]['mac-address'];
}
else
{
}

// Проверяем машину в бан листах
if (empty($ARRAY2[$i]['mac-address']) == false)
{
$API_mac = new routeros_api();
$API_mac->debug = false;

if ($API_mac->connect($router_ip_long, 'support', 'support')) {

$ARRAY_mac = $API_mac->comm("/ip/firewall/filter/print", array(

));
$ARRAY_mac_nat = $API_mac->comm("/ip/firewall/nat/print", array(

));
$API_mac->disconnect();
$ARRAY_mac=print_r($ARRAY_mac,true);
$ARRAY_mac_nat=print_r($ARRAY_mac_nat,true);
$ARRAY_mac=$ARRAY_mac.$ARRAY_mac_nat;
if (strpos($ARRAY_mac, $ARRAY2[$i]['mac-address']) !== false)
{
 $arr_action[$i] = "unblock"; 
$mac_process="unblock";
$mac_process_button="Разблокировать";
}
else
{
$arr_action[$i] = "block";
$mac_process="block";
$mac_process_button="Заблокировать";
}


// Процесс поиска блокировки с уведомлением

}
?>


<?
}
else
{
$arr_action[$i] = "disable";
}
?>
<?
}
else
{
}
}
?>


<?
//print_r($arr_ip);
//print_r($arr_mac);
//print_r($arr_action);
//$arr2 = [];
  


 
 $arr=array(
 'type' => 'security',
 'count'=>$count_array2,
 'ip'=>$arr_ip,
 'host'=>$arr_host,
 'mac' => $arr_mac,
 'action'=>$arr_action,

 ) ;

$string=trim(json_encode($arr));
            echo $string;
?>


