<?php
require_once('/var/www/html/wordpress/wp-blog-header.php');
require_once('/var/www/html/wordpress/wp-includes/registration.php');
require_once('/var/www/html/wordpress/wp-load.php');
	header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');
/**
 * Регистрация нового пользователя
 */
 $login =   $_SESSION['session_username'];
  $email =  $_POST['email'];
 $name =   $metod;
$msg =  $metod2;


mail('info@routerband.ru', 'Сообщение от '.$name.'Логин: '.$login, $msg);

 
 


//On success
//if ( ! is_wp_error( $user_id ) ) {

//}
 $json = array(
    'type'    =>  'callbackform',
    'action' => 'good'
    
);  
	$string=trim(json_encode($json));
            echo $string;
      ?>