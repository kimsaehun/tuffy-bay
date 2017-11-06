<?php
$title = 'Tuffy Bay';
$css_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_header.php';
?>

<div class="checkout">
	 <div class="container">
		 <ol class="breadcrumb">
		  <li><a href="index.html">Home</a></li>
		  <li class="active">Cart</li>
		 </ol>
		 <div class="col-md-9 product-price1">
			 <div class="check-out">
				 <div class=" cart-items">
					 <h3>My Shopping Bag (<span id="num-items">2</span>)</h3>
						<script>$(document).ready(function(c) {
							$('.close1').on('click', function(c){
								$('.cart-header').fadeOut('slow', function(c){
									$('.cart-header').remove();
								});
								});
							});
					   </script>
					<script>$(document).ready(function(c) {
							$('.close2').on('click', function(c){
								$('.cart-header1').fadeOut('slow', function(c){
									$('.cart-header1').remove();
								});
								});
							});
					   </script>

					 <div class="in-check" >
						  <ul class="unit">
							<li><span>Item</span></li>
							<li><span>Product Name</span></li>
							<li><span>Unit Price</span></li>
							<li> </li>
							<div class="clearfix"> </div>
						  </ul>
						  <ul class="cart-header">
						   <div class="close1"> </div>
							<li class="ring-in"><a href="single.html" ><img src="images/f1.jpg" class="img-responsive" alt=""></a>
							</li>
							<li><span>Woo Dress</span></li>
							<li><span>$ 60.00</span></li>
							<li> <a href="single.html" class="add-cart cart-check">ADD TO CART</a></li>
							<div class="clearfix"> </div>
							</ul>
					 </div>
				  </div>
			 </div>
		 </div>
		 <div class="col-md-3 cart-total">
			 <div class="price-details">
				 <h3>Price Details</h3>
				 <span>Total</span>
				 <span class="total" id="total-price">350.00</span>
				 <span>Tax</span>
				 <span class="total" id="tax-price">100.00</span>
				 <div class="clearfix"></div>
			 </div>
			 <h4 class="last-price">TOTAL</h4>
			 <span class="total final" id="final-price">450.00</span>
			 <div class="clearfix"></div>
			 <a class="order" href="#">Place Order</a>
	 </div>
</div>

<?php
$js_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_footer.php';
?>