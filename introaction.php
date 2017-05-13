<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');
session_start();

if(!isset($_SESSION["session_username"])):
echo "no session";
else:
?>

<?
$router_ip = $_SESSION["ip"];
$type = htmlspecialchars($_POST["type"]);
$mac_address = htmlspecialchars($_POST["b"]);
$mac_process = htmlspecialchars($_POST["d"]);
$type_block = htmlspecialchars($_POST["c"]);
include("script/mikrotik_security_post.php");

$string=trim(json_encode($json));
            echo $string;
?>

<?php endif; ?>