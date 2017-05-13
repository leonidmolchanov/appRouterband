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
 $password =  $_POST['password'];
 $login =   $_POST['login'];
  $email =  $_POST['email'];
 $telnumber =   $_POST['telnumber'];
$name =  $_POST['name'];
 $lastname =   $_POST['lastname'];
$email_check=(filter_var($email, FILTER_VALIDATE_EMAIL));
if($email_check==false)
{
 $json = array(
    'err'    =>  'email',
    'request' => $user_id
);   
}
else
{

$userdata = array(
    'user_login'  =>  $login,
    'user_url'    =>  $telnumber,
    'user_pass'   =>  $password,
      'user_email'  =>  $email,
    'user_nicename'    =>  $lastname
);
$user_id = wp_insert_user( $userdata ) ;
 $json = array(
    'err'    =>  'no',
    'request' => $user_id
    
);  


mail($email, 'Успешная Регистрация', 'Поздравляем! Вы успешно прошли регистрацию в системе Routerband, для дальнейшего использования авторизируйтесь в приложении!');

}
 
 


//On success
//if ( ! is_wp_error( $user_id ) ) {

//}

	$string=trim(json_encode($json));
            echo $string;
      ?>