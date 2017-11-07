<?php
$title = 'Tuffy Bay';
$css_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_header.php';
?>

<div class="single-sec">
	 <div class="container">
		 <ol class="breadcrumb">
			 <li><a href="index.html">Home</a></li>
			 <li class="active">Products</li>
		 </ol>
		 <!-- start content -->
		 <div class="col-md-9 det">
				 <div class="single_left">
					 <div class="flexslider">
             <ul class="slides">
               <li data-thumb="images/s11.jpeg">
                 <img src="images/s11.jpeg" />
               </li>
             </ul>
           </div>
           <!-- FlexSlider -->
             <script defer src="js/jquery.flexslider.js"></script>
           <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
             <script>
           // Can also be used with $(document).ready()
           $(window).load(function() {
             $('.flexslider').flexslider({
             animation: "slide",
             controlNav: "thumbnails"
             });
           });
           </script>
				 </div>
				  <div class="single-right">
					 <h3>American Diamond Famina Ruby Copper, Brass Jewel Set</h3>
					 <div class="id"><h4>ID: SB2379</h4></div>
					  <div class="cost">
						  <div class="prdt-cost">
							 <ul>
								 <li>Price:</li>
								 <li class="active">$35000</li>
							 </ul>
             </div>
						 <div class="clearfix"></div>
					  </div>
             <form>
              <label for="item-quantity">Quantity:</label>
              <input id="item-quantity" type="number" name="item-quantity" value="1" min="1">
              <div class="button">
                <button type="submit">BUY NOW</button>
              </div>
             </form>
					  <div class="single-bottom1">
						<h6>Details</h6>
						<p class="prod-desc">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam. Ut wisi enim ad minim veniam iriure dolor in hendrerit in vulputate velit esse molestie consequat.</p>
					 </div>
				  </div>
				  <div class="clearfix"></div>
      <!---->
  </div>
</div>

<?php
$js_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_footer.php';
?>