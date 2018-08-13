<?php
require_once "../config/mysql.class.php";
$database = new DataBasePDO();
session_start();
if(!isset($_SESSION["admin"])){
	header("Location: /grocery_store/admin/index.php");
}
$AdminStatus="";
$Addedmsg="";
if(isset($_POST['Name']) && isset($_FILES['logoimg'])){
	$quec="select * from category where status='1' and name='".$_POST['Name']."'";
	$resc=$database->getAllResults($quec);
	if(sizeof($resc)==0){
		$target_dir = "../images/uploads/";
		$target_file = $target_dir . basename($_FILES["logoimg"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_FILES['logoimg'])) {
		    $check = getimagesize($_FILES["logoimg"]["tmp_name"]);
		    if($check !== false) {
		        if (move_uploaded_file($_FILES["logoimg"]["tmp_name"], $target_file)) {
			        echo "The file ". basename( $_FILES["logoimg"]["name"]). " has been uploaded.";
			    } else {
			        echo "Sorry, there was an error uploading your file.";
			    }
		    } else {
		        echo "File is not an image.";
		        $uploadOk = 0;
		    }
		}
		$img_path="";
		$query="insert into `category` (name,img_path,status) values('".$_POST['Name']."','".$target_file."',1)";
		$result=$database->executeQuery($query);
		if($result){
			$Addedmsg="successfully added";
		}
	}else{
		$Addedmsg="category allready exists";
	}
}
$categoryget="select * from category where status=1";
$categorylist=$database->getAllResults($categoryget);
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


.topspace20{
	margin-top:10px;
}
.marginleftone{
	margin-left: 0px !important;
}
</style>	
<body>
<?php require_once "../header.php"; ?>

<!-- mail -->
		<div class="mail">
			<br/>
			<p class="error"><?php echo $AdminStatus;?></p>
				<div class="col-md-6 agileinfo_mail_grid_right">
					<h3>Add Category</h3>
					<p><?php echo $Addedmsg?></p>
					<form action="#" class="topspace20" method="post" enctype="multipart/form-data">
						<div class="col-md-12 wthree_contact_left_grid">
							<input type="text" name="Name" placeholder="Type" required="">
						</div>
						<div class="col-md-12 topspace20 wthree_contact_left_grid">
							<input type="file" name="logoimg" required="">
						</div>
						<div class="col-md-12 topspace20 wthree_contact_left_grid">
							<input class="marginleftone btn btn-success" type="submit" value="Submit">
						</div>

					</form>
				</div>
				<div class="col-md-6 agileinfo_mail_grid_right topspace20">
					<table class="table table-bordered">
						<tr>
							<th>s.no</th>
							<th>brand</th>
							<th>status</th>
						</tr>
						<?php foreach($categorylist as $categorylist1){ ?>
								<tr>
									<td><?php echo $categorylist1["cate_slno"];?></td>
									<td><?php echo $categorylist1["name"];?></td>
									<td><?php echo $categorylist1["status"];?></td>
								</tr>
						<?php }?>
					</table>
				</div>
				<div class="col-md-6 agileinfo_mail_grid_right">

				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
<!-- //mail -->


<?php require_once "../footer.php"; ?>
