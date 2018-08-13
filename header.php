

<!-- header -->
	<div class="agileits_header">
		<div class="w3l_offers">
			<a href="product.php">Today's special Offers !</a>
		</div>
		<div class="w3l_search">
			<form action="#" method="post">
				<input type="text" name="Product" value="Search a product..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search a product...';}" required="">
				<input type="submit" value=" ">
			</form>
		</div>
		<div class="product_list_header">  
			<form action="savecart.php" method="post" class="last">
                <fieldset>
                    <input type="hidden" name="cmd" value="_cart" />
                    <input type="hidden" name="display" value="1" />
                    <input type="submit" name="submit" value="View your cart" class="button" />
                </fieldset>
            </form><li></li>
		</div>
		<div class="w3l_header_right">
			<ul>
				

				<?php
					if((!isset($_SESSION["user"])) && (!isset($_SESSION["admin"]))){
				?>
					<li class="dropdown profile_details_drop">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user" aria-hidden="true"></i><span class="caret"></span></a>
						<div class="mega-dropdown-menu">
							<div class="w3ls_vegetables">
								<ul class="dropdown-menu drp-mnu">
									<li><a href="login.php">Login</a></li> 
									<li><a href="login.php">Sign Up</a></li>
								</ul>
							</div>                  
						</div>	
					</li>
				<?php	}else{?>
					<li class="dropdown profile_details_drop" style="color:white;font-weight: bold;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user" aria-hidden="true"></i><?php if(isset($_SESSION["user"])){echo $_SESSION["user"][0]["email"]; }else{
								echo $_SESSION["admin"][0]["email"];
							}?></a>								
						<div class="mega-dropdown-menu">
							<div class="w3ls_vegetables">
								<ul class="dropdown-menu drp-mnu">
									<li><a href="logout.php">Logout</a></li> 
								</ul>
							</div>                  
						</div>	
					</li>
				<?php	}
				?>

			</ul>
		</div>
		
		<div class="clearfix"> </div>
	</div>
<!-- script-for sticky-nav -->
	<script>
	$(document).ready(function() {
		 var navoffeset=$(".agileits_header").offset().top;
		 $(window).scroll(function(){
			var scrollpos=$(window).scrollTop(); 
			if(scrollpos >=navoffeset){
				$(".agileits_header").addClass("fixed");
			}else{
				$(".agileits_header").removeClass("fixed");
			}
		 });
		 
	});
	</script>
<!-- //script-for sticky-nav -->

	<div class="logo_products">
			<div class="w3ls_logo_products_left">
				<h1><a href="index.php"><span>Grocery</span> Store</a></h1>
			</div>
			<div class="w3ls_logo_products_left1">
				<ul class="special_items">
					<li><a href="about.php">About The site</a><i>/</i></li>
					<li><a href="product.php">Best Deals</a><i></i></li>
				</ul>
			</div>
			<div class="w3ls_logo_products_left1">
				<ul class="phone_email">
					<li><i class="fa fa-phone" aria-hidden="true"></i>(+91) 9963089038</li>
					<li><i class="fa fa-envelope-o" aria-hidden="true"></i><a href="mailto:store@grocery.com">ybalunaidu@gmail.com</a></li>
				</ul>
			</div>
			<div class="clearfix"> </div>
	</div>
	<div id="showalert" class="alert alert-success alert-dismissable">
	  <a href="#" class="close" onclick="$(this).parent().hide()" aria-label="close">&times;</a>
	  <strong>Success!</strong> product added to cart.
	</div>
