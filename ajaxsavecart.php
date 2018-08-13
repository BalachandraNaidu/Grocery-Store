<?php
require_once "config/mysql.class.php";
$database = new DataBasePDO();
session_start();
$check="select * from `cart` where  user_id='".$_POST['user_id']."' and status=1 and  product_id='".$_POST['product_id']."'";
$checkresult=$database->getAllResults($check);
if(empty($checkresult)){
	$query="insert into `cart` (user_id,product_id,quantity,status) 
                     values('".$_POST['user_id']."','".$_POST['product_id']."',1,1)";
    $result=$database->executeQuery($query);
}else{
	$quantity=$checkresult[0]["quantity"]+1;
	$query="update `cart`  set quantity=".$quantity." where  cart_slno=".$checkresult[0]['cart_slno'];
    $result=$database->executeQuery($query);
}
?>