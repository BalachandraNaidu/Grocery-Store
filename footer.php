
<!-- footer -->
	<div class="footer">
		<div class="container">
			<div class="col-md-4 w3_footer_grid">
				<h3>information</h3>
				<ul class="w3_footer_grid_list">
					<li><a href="product.php">Best Deals</a></li>
					<li><a href="about.php">About Us</a></li>
				</ul>
			</div>
			<div class="col-md-4 w3_footer_grid">
				<h3>what in stores</h3>
				<ul class="w3_footer_grid_list">
					<li><a href="product.php">Frozen Snacks</a></li>
					<li><a href="product.php">Kitchen</a></li>
					<li><a href="product.php">Branded Foods</a></li>
					<li><a href="product.php">Households</a></li>
				</ul>
			</div>
			<div class="clearfix"> </div>
			<div class="agile_footer_grids">
				<div class="col-md-3 w3_footer_grid agile_footer_grids_w3_footer">
					<div class="w3_footer_grid_bottom">
						<h4>100% secure payments</h4>
						<img src="images/card.png" alt=" " class="img-responsive" />
					</div>
				</div>
				<div class="col-md-3 w3_footer_grid agile_footer_grids_w3_footer">
					<div class="w3_footer_grid_bottom">
						<h5>connect with us</h5>
						<ul class="agileits_social_icons">
							<li><a href="#" class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a href="#" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href="#" class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
							<li><a href="#" class="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							<li><a href="#" class="dribbble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="wthree_footer_copy">
				<p>© 2017 Grocery Store. All rights reserved | Design by Balachandra</p>
			</div>
		</div>
	</div>
<!-- //footer -->
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');       
        }
    );
});
</script>
<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {
			/*
				var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
				};
			*/
								
			$().UItoTop({ easingType: 'easeOutQuart' });
								
			});
	</script>

	<script>
		$("#showalert").hide();
		$(".addtocart").click(function(){
			var userlogin="<?php if(!empty($_SESSION["user"][0]["user_id"]))echo $_SESSION["user"][0]["user_id"] ;?>";
			if(userlogin){
				$.ajax({
					url: "ajaxsavecart.php",
					type:"POST" ,
					data:{"product_id":$(this).attr("product_id"),"user_id":userlogin},
					success: function(result){
						$("#showalert").show();
					    $("#toTopHover").click();
					}
				});
			}else{
				alert("please login to add product to cart");
			}
		});
		$(".deletecart").click(function(){
			var userlogin="<?php if(!empty($_SESSION["user"][0]["user_id"]))echo $_SESSION["user"][0]["user_id"] ;?>";
			var toremovetr=$(this);
			var r = confirm("Are you sure you want to delete this product");
			if (r == true) {
				if(userlogin){
				$.ajax({
						url: "deletecart.php",
						type:"POST" ,
						data:{"cart_slno":$(this).attr("product_id"),"user_id":userlogin},
						success: function(result){
							console.log(result);
							toremovetr.parents("tr").remove();				
						}
					});
				}else{
					alert("please login to add product to cart");
				}			
			}
			
		});

		$(".checklist").click(function(){
			var userlogin="<?php if(!empty($_SESSION["user"][0]["user_id"]))echo $_SESSION["user"][0]["user_id"] ;?>";
			var toremovetr=$(this);
			var r = confirm("Are you sure you want to checkout now");
			if (r == true) {
				if(userlogin){
				$.ajax({
						url: "checkout.php",
						type:"POST" ,
						data:{"checklist":$(this).attr("cart_slno_list")},
						success: function(result){
							window.location = "dashboard.php";
						}
					});
				}else{
					alert("please login to add product to cart");
				}			
			}
			
		});
	</script>
<!-- //here ends scrolling icon -->
<!--<script src="js/minicart.min.js"></script>
<script>
	// Mini Cart
	paypal.minicart.render({
		action: '#'
	});

	if (~window.location.search.indexOf('reset=true')) {
		paypal.minicart.reset();
	}
</script>-->
</body>
</html>