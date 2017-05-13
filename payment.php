<?php

//$notification_type = htmlspecialchars($_POST["notification_type"]);

//$operation_id = htmlspecialchars($_POST["operation_id"]);

$amount = htmlspecialchars($_POST["amount"]);

//$withdraw_amount = htmlspecialchars($_POST["withdraw_amount"]);

//$currency = htmlspecialchars($_POST["currency"]);

//$datetime = htmlspecialchars($_POST["datetime"]);

//$sender = htmlspecialchars($_POST["sender"]);

//$codepro = htmlspecialchars($_POST["codepro"]);

//$label = htmlspecialchars($_POST["label"]);

//$sha1_hash = htmlspecialchars($_POST["sha1_hash"]);

//$test_notification = htmlspecialchars($_POST["test_notification"]);

//$unaccepted = htmlspecialchars($_POST["unaccepted"]);


//$msg=$operation_id.$label.$sha1_hash;
//$msg=$operation_id.$unaccepted.$test_notification.$sha1_hash.$label.$codepro.$sender.$datetime.$currency.$withdraw_amount.$amount;
mail('leonid@rsinternet.ru', 'Routerband', $amount);
$string="test";
echo $string;
?>