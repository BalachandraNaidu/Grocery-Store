<?php
require_once "config/mysql.class.php";
$database = new DataBasePDO();
session_start();
print_r($_POST);//die();
	$query="delete from `cart`  where  user_id=".$_POST['user_id']." and cart_slno=".$_POST['cart_slno'];
    $result=$database->executeQuery($query);
?>