
<?php
	session_start();
	?>

	<?php require_once("includes/connection.php"); ?>
	<?php
	
		include("/var/www/html/wordpress/wp-includes/pluggable.php");
include("/var/www/html/wordpress/wp-includes/class-phpass.php");
	header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');
  
	if(isset($_SESSION["session_username"]))
	{
	// вывод "Session is set"; // в целях проверки
	//header("Location: intropage.php");
	}

// получаем логин и пароль через post
 $username = htmlspecialchars($_POST["a"]);
  $password = htmlspecialchars($_POST["b"]);
	if(!empty($_POST['a']) && !empty($_POST['b'])) 
						{
		
$wp_hasher = new PasswordHash(8, TRUE);
$query =mysql_query("SELECT * FROM wp_users WHERE user_login='".$username."' ");
$query_old=$query;
$query=mysql_fetch_assoc($query);
$password_hashed = $query[user_pass];
$plain_password = $password;
$usermac=$query[SN];
$userdevice=$query[DEVICE];
$userbalance=$query[BALANCE];
// connect to router base
$host='localhost'; // 
$database='radius'; // 
$user='root'; // 
$pswd='LikeFly1986'; // 

$dbh = mysql_connect($host, $user, $pswd) or die("��ибка подкл��ени� MySQL.");
mysql_select_db($database) or die("��ибка.");
$query2 = mysql_query("SELECT * FROM radreply WHERE username='".$usermac."' ");
$query2_old=$query2;
$query2=mysql_fetch_assoc($query2);
$query2[ip]=ip2long($query2[value]);
if($wp_hasher->CheckPassword($plain_password, $password_hashed)) 
{
	$password_check=1;
	
	$numrows=mysql_num_rows($query_old);
	if($numrows=1)
	 {
	 	$_SESSION['session_username']=$username;
	 	$_SESSION['mac']=$query[MAC];
	 	$_SESSION['ip']=$query2[ip];
	 	$_SESSION['router_login']=$query2[login];
	 	$_SESSION['router_password']=$query2[password];
	 	$_SESSION['email']=$query[user_email];
	 	 	$_SESSION['telnumber']=$query[user_url];
	 	$_SESSION['user_nicename']=$query[user_nicename];
	 	$_SESSION['device']=$query[DEVICE];
	 	$_SESSION['master']=$query[SN];
	 	$_SESSION['push']=$query[push];
	 	$_SESSION['email_msg']=$query[email_msg];
	 	 $phpsesid =mysql_query("UPDATE  `wordpress`.`wp_users` SET  `phpsesid` =  '".session_id()."' WHERE  `wp_users`.`user_login` ='".$username."' ");
// проверка ping
     $handle = fsockopen(long2ip($query2[ip]), 8728, $errno, $errstr, 10);
if ($handle !== false)
{
$status="online";
$log="access";
fclose($handle);
} else {
	$log="access";
$status="offline";
}  

     
	}



}

else {
$log="err1";
			} 



						}
	
	
	
	
	else {
$log="err2";
			}
			
			$arr = array
('type' => 'profile',
 'login' => $username, 
'phpsesid' =>   session_id(),
 'name' => $query[user_nicename], 
 'email' => $query[user_email], 
 'status' => $status, 
  'log' => $log, 
  'balance' => $userbalance,
 'mac' => $query[MAC]);
 $string=trim(json_encode($arr));
 strip_tags($string);
            echo $string;
	?>