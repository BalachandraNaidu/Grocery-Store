<?php
require_once "config/mysql.class.php";
$database = new DataBasePDO();
session_start();
if (empty($_SESSION["user"][0]["user_id"])) {
	header("Location: /grocery_store/index.php");
}else{
	$cartget="select * from cart where status=1 and  user_id=".$_SESSION["user"][0]["user_id"];
	$cartlist=$database->getAllResults($cartget);
	//print_r($cartlist);

	if(!empty($cartlist)){
		$listIN="";
		$cart_slnolist='';
		foreach ($cartlist as $key => $cartlistvalue) {
			$listIN.=$cartlistvalue['product_id'].",";
			$cart_slnolist.=$cartlistvalue['cart_slno'].",";
		}

		$productget="select * from product where product_slno IN(".trim($listIN,",").")";
		$productInfo=$database->getAllResults($productget);

		$productCr=array();
		foreach ($productInfo as $productInfokey => $productInfovalue) {
			$productCr[$productInfovalue['product_slno']]=$productInfovalue;
		}

		//print_r($productCr);
	}
}
?>




<?php require_once "topheader.php"; ?>
	
<body>
<?php require_once "header.php"; ?>

	<div class="top-brands">
		<div class="container">
			<h3>YOUR CART</h3>
			<div class="agile_top_brands_grids">
				<table id="cart" class="table table-hover table-condensed">
    				<thead>
						<tr>
							<th style="width:50%">Product</th>
							<th style="width:10%">Price</th>
							<th style="width:8%">Quantity</th>
							<th style="width:22%" class="text-center">Subtotal</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($cartlist as $cartlistkey => $cartlistvalue){
							$cartlistF=$productCr[$cartlistvalue["product_id"]];
						?>
						<tr>
							<td data-th="Product">
								<div class="row">
									<div class="col-sm-2 hidden-xs">
										<img src="<?php echo str_replace("../","",$cartlistF['img_path']);?>" alt="..." class="img-responsive"/>	
									</div>
									<div class="col-sm-10">
										<h4 class="nomargin"><?php echo $cartlistF['name'];?></h4>
										<p><?php echo $cartlistF['description'];?></p>
									</div>
								</div>
							</td>
							<?php if(($cartlistF['specialprice']!='') || ($cartlistF['specialprice']==0)){$price=$cartlistF['specialprice'];}else{$price=$cartlistF['price'];}?>
							<td data-th="Price"><?php echo $price;?></td>
							<td data-th="Quantity">
								<input type="number" class="form-control text-center" value="<?php echo $cartlistvalue["quantity"];?>">
							</td>
							<td data-th="Subtotal" class="button addtocart text-center"><?php echo $cartlistvalue["quantity"]*$price;?></td>
							<td class="actions" data-th="">
								<button class="btn btn-danger btn-sm deletecart" product_id="<?php echo $cartlistvalue['cart_slno'];?>"><i class="fa fa-trash-o"></i></button>
							</td>
						</tr>
						<?php }?>
					</tbody>
					<tfoot>
						<tr>
							<td><a href="index.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
							<td colspan="2" class="hidden-xs"></td>
							<td ></td>
							<td><a href="#" class="btn btn-success btn-block checklist" cart_slno_list="<?php echo $cart_slnolist?>">Checkout <i class="fa fa-angle-right"></i></a></td>
						</tr>
					</tfoot>
				</table>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<!-- //top-brands -->

<!-- newsletter -->
	<div class="newsletter">
		<div class="container">
			<div class="w3agile_newsletter_left">
				<h3>sign up for our newsletter</h3>
			</div>
			<div class="w3agile_newsletter_right">
				<form action="#" method="post">
					<input type="email" name="Email" value="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}" required="">
					<input type="submit" value="subscribe now">
				</form>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</body>
<?php require_once "footer.php"; ?>
