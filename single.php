<?php
	require_once "config/mysql.class.php";
	$database = new DataBasePDO();

	if(!isset($_GET['id'])){
		$_GET['id']=1;
	}
	$producget="select * from product where product_slno=".$_GET['id'];
	$productlist=$database->getAllResults($producget);
	$productlist1=$productlist[0];

	$producvegitables="select * from product where status=1 and category=6 or category=3";
	$productvegitableslist=$database->getAllResults($producvegitables);

	$beverages="select * from product where status=1 and category=4 or category=5";
	$beverageslist=$database->getAllResults($beverages);

	$frozenfoods="select * from product where status=1 and category=2";
	$frozenfoodslist=$database->getAllResults($frozenfoods);

?>
<?php require_once "topheader.php"; ?>	
<body>
<?php require_once "header.php"; ?>
<!-- products-breadcrumb -->
	<div class="products-breadcrumb">
		<div class="container">
			<ul>
				<li><i class="fa fa-home" aria-hidden="true"></i><a href="index.php">Home</a><span>|</span></li>
				<li>Single Page</li>
			</ul>
		</div>
	</div>
<!-- //products-breadcrumb -->
<!-- banner -->
<div class="banner">
	<div class="w3l_banner_nav_center">			
		<div class="agileinfo_single">
				<?php $discount_amount=$productlist1['price']-$productlist1['specialprice'];
					if($discount_amount==$productlist1['price']){
						$discount_amount=0;
						$specialprice=$productlist1['price'];
						$price="";
					}else{
						$specialprice=$productlist1['specialprice'];
						$price='&#x20B9;'.$productlist1['price'];
					}?>
			<h5><?php echo $productlist1["name"]?></h5>
			<div class="col-md-4 agileinfo_single_left">
				<img id="example" src="<?php echo str_replace("../","",$productlist1["img_path"]);?>" alt=" " class="img-responsive" />
			</div>
			<div class="col-md-8 agileinfo_single_right">
				<div class="w3agile_description">
					<h4>Description :</h4>
					<p><?php echo $productlist1["description"]?></p>
				</div>
				<div class="snipcart-item block">
					<div class="snipcart-thumb agileinfo_single_right_snipcart">
						<h4><?php echo '&#x20B9;'.$productlist1["specialprice"];?><span><?php echo '&#x20B9;'.$productlist1["price"];?></span></h4>
					</div>
					<div class="snipcart-details agileinfo_single_right_details">
						<form action="#" method="post">
						<?php echo '
							<fieldset>
													<input type="hidden" name="cmd" value="_cart" />
													<input type="hidden" name="add" value="1" />
													<input type="hidden" name="business" value=" " />
													<input type="hidden" name="item_name" value="'.$productlist1["name"].'" />
													<input type="hidden" name="amount" value="'.$productlist1['price'].'" />
													<input type="hidden" name="discount_amount" value="'.$discount_amount.'" />
													<input type="hidden" name="currency_code" value="USD" />
													<input type="hidden" name="return" value=" " />
													<input type="hidden" name="cancel_return" value=" " />
													<input type="submit" name="submit" value="Add to cart" class="button addtocart" />
												</fieldset>
							'?>
						</form>
					</div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<!-- //banner -->
<!-- brands -->
	<div class="w3ls_w3l_banner_nav_right_grid w3ls_w3l_banner_nav_right_grid_popular">
		<div class="container">
				<div class="top-brands">
					<div class="container">
						<h3 style="margin-top: -100px">Hot Offers</h3>
							<div class="agile_top_brands_grids">
								<?php  foreach($productvegitableslist as $product_vlist){
									$discount_amount=$product_vlist['price']-$product_vlist['specialprice'];
									if($discount_amount==$product_vlist['price']){
										$discount_amount=0;
										$specialprice=$product_vlist['price'];
										$price="";
									}else{
										$specialprice=$product_vlist['specialprice'];
										$price='&#x20B9;'.$product_vlist['price'];
									}
									echo '				
									<div class="col-md-3 top_brand_left">
										<div class="hover14 column">
											<div class="agile_top_brand_left_grid">
												<div class="tag"><img src="'.$product_vlist["img_path"].'" alt=" " class="img-responsive" /></div>
												<div class="agile_top_brand_left_grid1">
													<figure>
														<div class="snipcart-item block" >
															<div class="snipcart-thumb">
																<a href="single.php?id='.$product_vlist['product_slno'].'"><img title=" " alt=" " src="'.str_replace("../","",$product_vlist["img_path"]).'" width="140px" height="140px"/></a>		
																<p>'.$product_vlist["name"].'</p>

																<h4>&#x20B9;'.$specialprice.'<span>'.$price.'</span></h4>
															</div>
															<div class="snipcart-details top_brand_home_details">
																<form action="#" method="post">
																	<fieldset>
																		<input type="hidden" name="cmd" value="_cart" />
																		<input type="hidden" name="add" value="1" />
																		<input type="hidden" name="business" value=" " />
																		<input type="hidden" name="item_name" value="'.$product_vlist["name"].'" />
																		<input type="hidden" name="amount" value="'.$product_vlist['price'].'" />
																		<input type="hidden" name="discount_amount" value="'.$discount_amount.'" />
																		<input type="hidden" name="currency_code" value="USD" />
																		<input type="hidden" name="return" value=" " />
																		<input type="hidden" name="cancel_return" value=" " />
																		<input type="submit" name="submit" value="Add to cart" class="button addtocart" />
																	</fieldset>
																</form>
															</div>
														</div>
													</figure>
												</div>
											</div>
										</div>
									</div>';}?>
								<div class="clearfix"> </div>
							</div>
						<!-- vegetables & fruits -->
						<div class="w3ls_w3l_banner_nav_right_grid1">
							<h6>vegetables & fruits</h6>
								<div class="agile_top_brands_grids">
								<?php  foreach($productvegitableslist as $product_vlist){
									$discount_amount=$product_vlist['price']-$product_vlist['specialprice'];
									if($discount_amount==$product_vlist['price']){
										$discount_amount=0;
										$specialprice=$product_vlist['price'];
										$price="";
									}else{
										$specialprice=$product_vlist['specialprice'];
										$price='&#x20B9;'.$product_vlist['price'];
									}
										echo '				
										<div class="col-md-3 top_brand_left">
											<div class="hover14 column">
												<div class="agile_top_brand_left_grid">
													<div class="tag"><img src="'.$product_vlist["img_path"].'" alt=" " class="img-responsive" /></div>
													<div class="agile_top_brand_left_grid1">
														<figure>
															<div class="snipcart-item block" >
																<div class="snipcart-thumb">
																	<a href="single.php?id='.$product_vlist['product_slno'].'"><img title=" " alt=" " src="'.str_replace("../","",$product_vlist["img_path"]).'" width="140px" height="140px"/></a>		
																	<p>'.$product_vlist["name"].'</p>

																	<h4>&#x20B9;'.$specialprice.'<span>'.$price.'</span></h4>
																</div>
																<div class="snipcart-details top_brand_home_details">
																	<form action="#" method="post">
																		<fieldset>
																			<input type="hidden" name="cmd" value="_cart" />
																			<input type="hidden" name="add" value="1" />
																			<input type="hidden" name="business" value=" " />
																			<input type="hidden" name="item_name" value="'.$product_vlist["name"].'" />
																			<input type="hidden" name="amount" value="'.$product_vlist['price'].'" />
																			<input type="hidden" name="discount_amount" value="'.$discount_amount.'" />
																			<input type="hidden" name="currency_code" value="USD" />
																			<input type="hidden" name="return" value=" " />
																			<input type="hidden" name="cancel_return" value=" " />
																			<input type="submit" name="submit" value="Add to cart" class="button addtocart" />
																		</fieldset>
																	</form>
																</div>
															</div>
														</figure>
													</div>
												</div>
											</div>
										</div>';}?>
									<div class="clearfix"> </div>
								</div>
							<div class="clearfix"> </div>
						</div>
						<!-- //vegetables & fruits -->
						<!-- beverages -->
						<div class="w3ls_w3l_banner_nav_right_grid1">
							<h6>beverages</h6>
								<div class="agile_top_brands_grids">
								<?php  foreach($beverageslist as $b_list){
									$discount_amount=$b_list['price']-$b_list['specialprice'];
									if($discount_amount==$b_list['price']){
										$discount_amount=0;
										$specialprice=$b_list['price'];
										$price="";
									}else{
										$specialprice=$b_list['specialprice'];
										$price='&#x20B9;'.$b_list['price'];
									}
										echo '				
										<div class="col-md-3 top_brand_left">
											<div class="hover14 column">
												<div class="agile_top_brand_left_grid">
													<div class="tag"><img src="'.$b_list["img_path"].'" alt=" " class="img-responsive" /></div>
													<div class="agile_top_brand_left_grid1">
														<figure>
															<div class="snipcart-item block" >
																<div class="snipcart-thumb">
																	<a href="single.php?id='.$b_list['product_slno'].'"><img title=" " alt=" " src="'.str_replace("../","",$b_list["img_path"]).'" width="140px" height="140px"/></a>		
																	<p>'.$b_list["name"].'</p>

																	<h4>&#x20B9;'.$specialprice.'<span>'.$price.'</span></h4>
																</div>
																<div class="snipcart-details top_brand_home_details">
																	<form action="#" method="post">
																		<fieldset>
																			<input type="hidden" name="cmd" value="_cart" />
																			<input type="hidden" name="add" value="1" />
																			<input type="hidden" name="business" value=" " />
																			<input type="hidden" name="item_name" value="'.$b_list["name"].'" />
																			<input type="hidden" name="amount" value="'.$b_list['price'].'" />
																			<input type="hidden" name="discount_amount" value="'.$discount_amount.'" />
																			<input type="hidden" name="currency_code" value="USD" />
																			<input type="hidden" name="return" value=" " />
																			<input type="hidden" name="cancel_return" value=" " />
																			<input type="submit" name="submit" value="Add to cart" class="button addtocart" />
																		</fieldset>
																	</form>
																</div>
															</div>
														</figure>
													</div>
												</div>
											</div>
										</div>';}?>
									<div class="clearfix"> </div>
								</div>
								<div class="clearfix"> </div>
						</div>
						<!-- //beverages -->
						<!-- frozenfoods -->
						<div class="w3ls_w3l_banner_nav_right_grid1">
							<h6>frozenfoods</h6>
								<div class="agile_top_brands_grids">
								<?php  foreach($frozenfoodslist as $f_list){
									$discount_amount=$f_list['price']-$f_list['specialprice'];
									if($discount_amount==$f_list['price']){
										$discount_amount=0;
										$specialprice=$f_list['price'];
										$price="";
									}else{
										$specialprice=$f_list['specialprice'];
										$price='&#x20B9;'.$f_list['price'];
								}
										echo '				
										<div class="col-md-3 top_brand_left">
											<div class="hover14 column">
												<div class="agile_top_brand_left_grid">
													<div class="tag"><img src="'.$f_list["img_path"].'" alt=" " class="img-responsive" /></div>
													<div class="agile_top_brand_left_grid1">
														<figure>
															<div class="snipcart-item block" >
																<div class="snipcart-thumb">
																	<a href="single.php?id='.$f_list['product_slno'].'"><img title=" " alt=" " src="'.str_replace("../","",$f_list["img_path"]).'" width="140px" height="140px"/></a>		
																	<p>'.$f_list["name"].'</p>

																	<h4>&#x20B9;'.$specialprice.'<span>'.$price.'</span></h4>
																</div>
																<div class="snipcart-details top_brand_home_details">
																	<form action="#" method="post">
																		<fieldset>
																			<input type="hidden" name="cmd" value="_cart" />
																			<input type="hidden" name="add" value="1" />
																			<input type="hidden" name="business" value=" " />
																			<input type="hidden" name="item_name" value="'.$f_list["name"].'" />
																			<input type="hidden" name="amount" value="'.$f_list['price'].'" />
																			<input type="hidden" name="discount_amount" value="'.$discount_amount.'" />
																			<input type="hidden" name="currency_code" value="USD" />
																			<input type="hidden" name="return" value=" " />
																			<input type="hidden" name="cancel_return" value=" " />
																			<input type="submit" name="submit" value="Add to cart" class="button addtocart"/>
																		</fieldset>
																	</form>
																</div>
															</div>
														</figure>
													</div>
												</div>
											</div>
										</div>';}?>
									<div class="clearfix"> </div>
								</div>
								<div class="clearfix"> </div>
						</div>
						<!-- //frozenfoods -->
					</div>
				</div>
		</div>
	</div>
<!-- //brands -->
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
<!-- //newsletter -->
<?php require_once "footer.php"; ?>
</body>
