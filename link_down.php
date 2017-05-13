<?php require_once("includes/connection.php"); ?>
<?php
include("/var/www/html/wordpress/wp-includes/pluggable.php");
include("/var/www/html/wordpress/wp-includes/class-phpass.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');


$ipaddress=$argv[1];

$query2 =mysql_query("SELECT * FROM `radius`.`radreply`  WHERE value='".$ipaddress."' ");
$query2=mysql_fetch_assoc($query2);
$username=$query2['username'];
$router_name=$query2['name'];

$query =mysql_query("SELECT * FROM `wordpress`.`wp_users`  WHERE SN='".$username."' ");
$i=0;
while ($row = mysql_fetch_assoc($query)) {
$login[$i]=$row['user_login'];
$i++;
}


//$login=$query['user_login'];

for ($i =0; $i <=count($login)-1; $i++)
{

$query3 =mysql_query("SELECT * FROM `wordpress`.`wp_users`  WHERE user_login='".$login[$i]."' ");
$query3=mysql_fetch_assoc($query3);
$useremail=$query3['user_email'];
$emailmsg=$query3['email_msg'];
$push=$query3['push'];
if ($emailmsg=='1'){
$msg="Уважаемый " .$login[$i]. ", Ваше устройство " .$router_name. " ушло со связи!";
mail($useremail, 'Routerband', $msg);
}

elseif ($push=='1'){
$query4 =mysql_query("SELECT * FROM `wordpress`.`wp_uuid`  WHERE user='".$login[$i]."' ");
$i=0;
while ($row = mysql_fetch_assoc($query4)) {
$uuid[$i]=$row['uuid'];

$msg="Уважаемый " .$login[$i]. ", Ваше устройство " .$router_name. " ушло со связи!";
$data = array("platform" => "0",
"alias" => $row['uuid'],
"msg" => $msg);
$data_string = json_encode($data);

$ch = curl_init('https://api.pushbots.com/push/all');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'x-pushbots-appid: 5884b7214a9efaa84c8b4567',
    'x-pushbots-secret: 3950d20e5ab8cb2dbd9a6bec3d57767e'
));

$result = curl_exec($ch);



$data2 = array("platform" => "1",             
"alias" => $row['uuid'],                     
"msg" => $msg);                              
$data2_string = json_encode($data2);           

$ch2 = curl_init('https://api.pushbots.com/push/all');
curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch2, CURLOPT_POSTFIELDS, $data2_string);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'x-pushbots-appid: 5884b7214a9efaa84c8b4567',
    'x-pushbots-secret: 3950d20e5ab8cb2dbd9a6bec3d57767e'
));

$result2 = curl_exec($ch2);



mail('info@routerband.ru', 'Routerband', $result);
$i++;
}


}

else
{
}


}
?>