

	<?php require_once("includes/connection.php"); ?>
	<?php
		include("/var/www/wordpress/wp-includes/pluggable.php");
include("/var/www/wordpress/wp-includes/class-phpass.php");
$parametr1=$argv[1]; 
$parametr2=$argv[2]; 
                                                                                            
$ipaddress=ip2long($parametr1);
$query =mysql_query("SELECT * FROM wp_router WHERE ip='".$ipaddress."' ");
$query=mysql_fetch_assoc($query);
$sn_router = $query[SN];
$query =mysql_query("SELECT * FROM wp_users WHERE SN='".$sn_router."' ");
$query=mysql_fetch_assoc($query);
$user_login = $query[user_login];
$query_push =mysql_query("SELECT * FROM wp_users WHERE SN='".$sn_router."' ");
$query_push=mysql_fetch_assoc($query_push);
$push_status = $query_push[push];
if($push_status==1)
{

// ОТправка push
if($parametr2==0)
{
	$msg=$user_login.", Ваше устройство ".$sn_router." ушло со связи!";

}
else if($parametr2==1)
{
	$msg=$user_login.", Ваше устройство ".$sn_router." вернулось на связь!";

}
$data = array("platform" => "0",
"alias" => $user_login, 
"msg" => $msg);                                                                    
$data_string = json_encode($data);                                                                                   

$data2 = array("platform" => "1",
"alias" => $user_login, 
"msg" => $msg);                                                                    
$data_string2 = json_encode($data2);   

$ch = curl_init('https://api.pushbots.com/push/all');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',
    'x-pushbots-appid: 5884b7214a9efaa84c8b4567',
    'x-pushbots-secret: 3950d20e5ab8cb2dbd9a6bec3d57767e'                                                                                                                                           
));    

$ch2 = curl_init('https://api.pushbots.com/push/all');                                                                      
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch2, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',
    'x-pushbots-appid: 5884b7214a9efaa84c8b4567',
    'x-pushbots-secret: 3950d20e5ab8cb2dbd9a6bec3d57767e'                                                                                                                                           
)); 

                  
echo $data_string;
$result = curl_exec($ch);
$result2 = curl_exec($ch2);
echo $result;



}
else
{
	$letter=$user_login;
}


$email='leonid@rsinternet.ru';
$subject='Тестовое письмо';
//mail($email, $subject, $letter);

$data3 = array( 
"uuid" => '6ad10d3d01b59656');  

$ch3 = curl_init('https://api.pushbots.com/2/subscriptions');                                                                      
curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data3);                                                                  
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch3, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',
    'x-pushbots-appid: 5884b7214a9efaa84c8b4567',
    'x-pushbots-secret: 3950d20e5ab8cb2dbd9a6bec3d57767e'                                                                                                                                           
)); 
 
// curl -X GET \
//-H "x-pushbots-appid: 54cc0a511d0ab13c0528b459d" \
//https://api.pushbots.com/2/subscriptions/56d0a0deaa760e1711a44e18

$result3=curl_exec($ch3);
echo $result3;
?>