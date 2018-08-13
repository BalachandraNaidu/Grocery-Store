<?php
require_once "config/mysql.class.php";
$database = new DataBasePDO();
session_start();	
	$producget="select * from product where status=1 and (price-specialprice)>=10";
	$productlist=$database->getAllResults($producget);

?>

<?php require_once "topheader.php"; ?>
	
<body>
<?php require_once "header.php"; ?>
<?php require_once "banner.php"; ?>
	<div class="top-brands">
		<div class="container">
			<h3>Hot Offers</h3>
			<div class="agile_top_brands_grids">
				<?php  foreach($productlist as $productlist1){
					$discount_amount=$productlist1['price']-$productlist1['specialprice'];
					if($discount_amount==$productlist1['price']){
						$discount_amount=0;
						$specialprice=$productlist1['price'];
						$price="";
					}else{
						$specialprice=$productlist1['specialprice'];
						$price='&#x20B9;'.$productlist1['price'];
					}
					echo '				<div class="col-md-3 top_brand_left">
					<div class="hover14 column">
						<div class="agile_top_brand_left_grid">
							<div class="tag"><img src="'.$productlist1["img_path"].'" alt=" " class="img-responsive" /></div>
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block" >
										<div class="snipcart-thumb">
											<a href="single.php?id='.$productlist1['product_slno'].'"><img title=" " alt=" " src="'.str_replace("../","",$productlist1["img_path"]).'" width="140px" height="140px"/></a>		
											<p>'.$productlist1["name"].'</p>

											<h4>&#x20B9;'.$specialprice.'<span>'.$price.'</span></h4>
										</div>
										<div class="snipcart-details top_brand_home_details">
											<input type="button" name="submit" product_id="'.$productlist1["product_slno"].'" class="button addtocart" value="Add to cart"/>
										</div>
									</div>
								</figure>
							</div>
						</div>
					</div>
				</div>
';
				 }?>


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
