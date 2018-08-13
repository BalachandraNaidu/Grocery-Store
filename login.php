<?php
require_once "config/mysql.class.php";
$database = new DataBasePDO();
session_start();
/*if(isset($_SESSION["user"])){
	require_once "dashboard.php";
}*/
$Addedmsg="";
if(isset($_POST["firstname"]) && isset($_POST["email"])){
	$Email=$_POST["email"];
	$query1="select * from users where email='".$Email."'";
	$user=$database->getAllResults($query1);
	if(empty($user)){
		$query="insert into `users` (firstname,lastname,email,password,status) 
	                     values('".$_POST["firstname"]."','".$_POST["lastname"]."','".$_POST["email"]."','".$_POST["Password"]."',1)";
	    $result=$database->executeQuery($query);
	    if($result){
			$Addedmsg="successfully added";
		}
	}else{
		$Addedmsg="User already exsists";
	}
}
else if (isset($_POST["Email"])) {
	$Email=$_POST["Email"];
	$query1="select * from users where email='".$Email."'";
	$user=$database->getAllResults($query1);
	if(!empty($user) && $user[0]['password']='".$Password."'){
			$_SESSION["user"]=$user;
			header("Location: /grocery_store/index.php");
	}else{
		$Addedmsg="invalid user";
	}
}
?>

<?php require_once "topheader.php"; ?>
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
    text-align: center;
    background: green;
    margin-top: 10px;
    margin-left: 31px;
    width: 50%;
    color: white;
    font-weight: bold;
}

.mail{
    
    width: 100%;
    padding-top: 0px;
}
.topspace20{
	margin-top:20px;
}
</style>	
<body>
<?php require_once "header.php"; ?>

<!-- mail -->
		<div class="mail">
			<div class="col-md-6 agileinfo_mail_grid_right">
				<h3>Login</h3>
				<p class="error"><?php echo $Addedmsg?></p>
				<form action="#" method="post">
					<div class="col-md-12 agileinfo_mail_grid_right">
						<input type="email" name="Email" placeholder="Email*" required="">
						<input type="password" name="Password" placeholder="password*" required="">
					</div>
					<input class="btn btn-success" type="submit" value="Login">
				</form>
			</div>
			<div class="col-md-6 agileinfo_mail_grid_right">
			<h3 >SignUp</h3>
			<form class="topspace20"action="#" method="post">
					<div class="col-md-12 agileinfo_mail_grid_right">
						<input type="text" name="firstname" placeholder="FirstName" required="">
						<input type="text" name="lastname" placeholder="LastName">
						<input type="email" name="email" placeholder="Email*" required="">
						<input type="password" name="Password" placeholder="Password*" required="">
					</div>
					<input class="btn btn-success" type="submit" value="SignUp">
				</form>		
		</div>
		<div class="clearfix"> </div>
		</div>
<!-- //mail -->


<?php require_once "footer.php"; ?>

</body>