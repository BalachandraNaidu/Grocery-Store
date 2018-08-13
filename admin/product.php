<?php
require_once "../config/mysql.class.php";
$database = new DataBasePDO();
session_start();
if(!isset($_SESSION["admin"])){
	header("Location: /grocery_store/admin/index.php");
}
$AdminStatus="";
$Addedmsg="";
if(isset($_POST['productname']) && isset($_FILES['productimg'])){
	$target_dir = "../images/uploads/";
	$target_file = $target_dir . basename($_FILES["productimg"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_FILES['productimg'])) {
	    $check = getimagesize($_FILES["productimg"]["tmp_name"]);
	    if($check !== false) {
	        if (move_uploaded_file($_FILES["productimg"]["tmp_name"], $target_file)) {
		        //echo "The file ". basename( $_FILES["productimg"]["name"]). " has been uploaded.";
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	$img_path="";
	$query="insert into `product` (name,category,img_path,price,specialprice,quantity,brand,description,status) 
	                     values('".$_POST['productname']."','".$_POST['categoryselect']."','".$target_file."',".$_POST['price'].",".$_POST['splprice'].",".$_POST['quantity'].",'".$_POST['brand']."','".$_POST['description']."',1)";
    //print_r($query);
	$result=$database->executeQuery($query);
	if($result){
		$Addedmsg="successfully added";
	}
}
$query="select name,cate_slno from category";
$categorylist=$database->getAllResults($query);
$producget="select name,brand,quantity from product where status=1";
$productlist=$database->getAllResults($producget);
//print_r($categorylist);
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


.topspace20,.wthree_contact_left_grid{
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
					<h3>Add Product</h3>
					<p><?php echo $Addedmsg?></p>
					<form action="#" class="topspace20" method="post" enctype="multipart/form-data">
						<div class="col-md-12 wthree_contact_left_grid">
							<select name="categoryselect" class="btn btn-success btn-block">
								<?php foreach($categorylist as $categorylist1){ ?>
								<option value="<?php echo $categorylist1["cate_slno"];?>"><?php echo $categorylist1["name"];?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-md-12 wthree_contact_left_grid">
							<input type="text" name="productname" placeholder="Product Name" required="">
						</div>
						<div class="col-md-12 wthree_contact_left_grid">
							<input type="text" name="quantity" placeholder="Quantity" required="">
						</div>
						<div class="col-md-12 wthree_contact_left_grid">
							<input type="text" name="price" placeholder="Price" required="">
						</div>
						<div class="col-md-12 wthree_contact_left_grid">
							<input type="text" name="splprice" placeholder="Spl Price">
						</div>
						<div class="col-md-12 wthree_contact_left_grid">
							<input type="text" name="brand" placeholder="brand">
						</div>
						<div class="col-md-12 wthree_contact_left_grid">
							<input type="text" name="description" placeholder="description">
						</div>
						<div class="col-md-12 wthree_contact_left_grid">
							<input type="file" name="productimg" required="">
						</div>
						
						<div class="col-md-12 topspace20 wthree_contact_left_grid">
							<input class="marginleftone btn btn-success" type="submit" value="Submit">
						</div>

					</form>
				</div>
				<div class="col-md-6 agileinfo_mail_grid_right topspace20">
					<table class="table table-bordered table-hover">
						<tr>
							<th>name</th>
							<th>brand</th>
							<th>qauntity</th>
						</tr>
						<?php foreach($productlist as $productlist1){ ?>
								<tr>
									<td><?php echo $productlist1["name"];?></td>
									<td><?php echo $productlist1["brand"];?></td>
									<td><?php echo $productlist1["quantity"];?></td>
								</tr>
						<?php }?>
					</table>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
<!-- //mail -->


<?php require_once "../footer.php"; ?>
