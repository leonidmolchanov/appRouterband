<?php
require_once('/var/www/html/app/includes/connection.php'); 
require_once('/var/www/html/wordpress/wp-includes/pluggable.php'); 
require_once('/var/www/html/wordpress/wp-includes/class-phpass.php'); 
//require_once('/var/www/html/wordpress/wp-blog-header.php');
//require_once('/var/www/html/wordpress/wp-includes/registration.php');
	header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');
 $login=$_SESSION['session_username'];
$device=explode(",",$_SESSION['device']);
if (empty($metod)) {
$metod="pusto";
}
mysql_set_charset("utf8");
$query2 =mysql_query("SELECT * FROM wp_posts WHERE post_type='post' ");
$i=1;
while ($array = mysql_fetch_assoc($query2)){
$result[$i]=$array;
$i=$i+1;
}


$arr = array
('type' => "news",
'count' => count($result),
  'body'=>$result,
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;	
	


?>
