<?php
	session_start();
	?>

	<?php require_once("includes/connection.php"); ?>
	<?php include("includes/header.php"); ?>	 
	<?php
	header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');
  
	if(isset($_SESSION["session_username"])){
	// вывод "Session is set"; // в целях проверки
	header("Location: intropage.php");
	}

//	if(isset($_POST["login"])){
 $username = htmlspecialchars($_POST["a"]);
  $password = htmlspecialchars($_POST["b"]);
	if(!empty($_POST['a']) && !empty($_POST['b'])) {
	//$username=htmlspecialchars($_POST['a']);
	//$password=htmlspecialchars($_POST['b']);
		$query =mysql_query("SELECT * FROM wp_routers WHERE login='".$username."' AND password='".$password."'");
	
	$numrows=mysql_num_rows($query);
	if($numrows!=0)
 {
while($row=mysql_fetch_assoc($query))
 {
	$dbusername=$row['login'];
  $dbpassword=$row['password'];
 }
  if($username == $dbusername && $password == $dbpassword)
 {
	// старое место расположения
	//  session_start();
	 $_SESSION['session_username']=$username;	 
 /* Перенаправление браузера */
   //header("Location: intropage.php");
   echo "good";
	}
	} else {
	//  $message = "Invalid username or password!";
	
	echo  "2";
 }
	} else {
	    echo  "1";
    $message = "All fields are required!";
	}
//	}
	?>
	<!--
<div class="container mlogin">
<div id="login">
<h1>Вход</h1>
<form action="" id="loginform" method="post"name="loginform">
<p><label for="user_login">Имя опльзователя<br>
<input class="input" id="username" name="username"size="20"
type="text" value=""></label></p>
<p><label for="user_pass">Пароль<br>
 <input class="input" id="password" name="password"size="20"
  type="password" value=""></label></p> 
	<p class="submit"><input class="button" name="login"type= "submit" value="Log In"></p>
	<p class="regtext">Еще не зарегистрированы?<a href= "register.php">Регистрация</a>!</p>
   </form>
 </div>
  </div>
  -->
