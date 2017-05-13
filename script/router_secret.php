<?php

require_once("/var/www/html/app/includes/connection2.php"); 

$device=explode(",",$_SESSION['device']);
if (empty($metod)) {
$metod="pusto";
}
else
{
    $login=$_SESSION['session_username'];


$query2 =mysql_query("SELECT * FROM `radius`.`radreply`  WHERE username='".$metod."' ");
$query2=mysql_fetch_assoc($query2);
 $router_login=$query2['login'];
 $router_password=$query2['password'];

$query =mysql_query("UPDATE  `radius`.`radreply` SET  `login` =  '".$metod2."' WHERE  `username` ='".$metod."' ");
$query2 =mysql_query("UPDATE  `radius`.`radreply` SET  `password` =  '".$metod3."' WHERE  `username` ='".$metod."' ");
}

		
	

$arr = array
('type' => "router_device",
'count'=>count($device),
'login'=>$metod2,
  'password' =>  $metod3,
  'metod'=>"secret",
   ); 
 

 $string=trim(json_encode($arr));
            echo $string;

?>
