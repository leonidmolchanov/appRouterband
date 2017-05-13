<?php

require_once("/var/www/html/app/includes/connection.php"); 


    $login=$_SESSION['session_username'];

$query2 =mysql_query("SELECT * FROM wp_uuid WHERE user_login='".$login."' ");
$query2=mysql_fetch_assoc($query2);

		

$arr = array
('type' => "uuid",
//'count'=>count($device),
  'device' => $query2,
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;

?>
