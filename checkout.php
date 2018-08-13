<?php
require_once "config/mysql.class.php";
$database = new DataBasePDO();
	$cart_slno_list=explode(",",trim($_POST["checklist"],","));
	print_r($cart_slno_list);//die();

	foreach ($cart_slno_list as $key => $value) {
		$query="update `cart`  set status=2 where  cart_slno=".$value;
		$result=$database->executeQuery($query);	
	}
	
?>