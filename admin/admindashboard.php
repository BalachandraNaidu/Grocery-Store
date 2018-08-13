<?php
session_start();
if(!isset($_SESSION["admin"])){
	header("Location: /grocery_store/admin/index.php");
}

require_once "../config/mysql.class.php";
$database = new DataBasePDO();
$AdminStatus="";
if(isset($_POST["Email"])){
	$Email=$_POST["Email"];
	$Password=$_POST["Password"];
	$query1="select * from admin where status=1 and email='".$Email."' and password='".$Password."'";
	$admin=$database->getAllResults($query1);
	if(!empty($admin)){
		header("Location: /grocery_store/admin/admindashboard.php");
	}else{
		$AdminStatus="Admin Not Found";
	}
}
?>

<?php require_once "../topheader.php"; ?>
<style>
.agileinfo_mail_grid_right input[type="password"]{
    outline: none;
    padding: 10px;
    font-size: 14px;
    color: #212121;
    background: #f5f5f5;
    width: 100%;
    border: 1px solid #E6E6E6;
    margin-bottom: 10px;
}
.agileinfo_mail_grid_right input[type="email"]{
	margin-bottom: 10px;	
}
p.error{
    //padding: 8px;
    background: green;
    margin-left: 31px;
    width: 50%;
    color: white;
    font-weight: bold;
}

.mail{
    margin: 0px auto;
    width: 800px;
    padding-top: 0px;
}
.rowtopbottom{
	margin:120px;
}
.btn{
	font-size:25px;
}
</style>	
<body>
<?php require_once "../header.php"; ?>

<!-- banner -->
	<div class="row rowtopbottom">
		<div class="col-sm-3 col-sm-offset-1">
			<a class="btn btn-success" href="category.php">Category</a>
		</div>
		<div class="col-sm-3 col-sm-offset-1">
			<a class="btn btn-success"href="product.php">Product</a>
		</div>
		<div class="col-sm-3 col-sm-offset-1">
			<a class="btn btn-success" href="status.php">Status</a>
		</div>
	</div>
<!-- top-brands -->

<?php require_once "../footer.php"; ?>
