<?php
$title = 'Tuffy Bay';
$css_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_header.php';
?>

<div class="product-model">
<div class="container">
   <ol class="breadcrumb">
   <li><a href="index.html">Home</a></li>
   <li class="active">Products</li>
  </ol>
   <h2>Our Products</h2>
  <div class="col-md-9 product-model-sec">

       <a href="single.html"><div class="product-grid love-grid">
         <div class="more-product"><span> </span></div>
         <div class="product-img b-link-stripe b-animate-go  thickbox">
           <img src="images/p12.jpg" class="img-responsive" alt=""/>
           <div class="b-wrapper">
           <h4 class="b-animate b-from-left  b-delay03">
           <button class="btns"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>Quick View</button>
           </h4>
           </div>
         </div></a>
         <div class="product-info simpleCart_shelfItem">
           <div class="product-info-cust">
             <h4>Jewellery #1</h4>
             <p>ID: SR4598</p>
             <span class="item_price">$187.95</span>
             <input type="text" class="item_quantity" value="1" />
             <input type="button" class="item_add items" value="ADD">
           </div>
           <div class="clearfix"> </div>
         </div>
       </div>
   </div>
   <div class="rsidebar span_1_of_left">
      <section  class="sky-form">
        <div class="product_right">
          <h4 class="m_2"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>Categories</h4>
          <div class="tab1">
            <ul class="place">
              <li class="sort">Fashion</li>
              <li class="by"><img src="images/do.png" alt=""></li>
               <div class="clearfix"> </div>
             </ul>
            <div class="single-bottom">
               <a href="#"><p>Gifts</p></a>
               <a href="#"><p>Flowers</p></a>
               <a href="#"><p>Shoes</p></a>
               <a href="#"><p>Suits</p></a>
               <a href="#"><p>Dresses</p></a>
              </div>
             </div>
           <div class="tab2">
            <ul class="place">
              <li class="sort">Women Ethnic Wear</li>
              <li class="by"><img src="images/do.png" alt=""></li>
               <div class="clearfix"> </div>
             </ul>
            <div class="single-bottom">
               <a href="#"><p>Sarees & More</p></a>
               <a href="#"><p>Salwar Suits</p></a>
              </div>
             </div>
           <div class="tab3">
            <ul class="place">
              <li class="sort">Personal Care</li>
              <li class="by"><img src="images/do.png" alt=""></li>
               <div class="clearfix"> </div>
             </ul>
            <div class="single-bottom">
               <a href="#"><p>Make Up</p></a>
              </div>
             </div>
           <div class="tab4">
            <ul class="place">
              <li class="sort">Jewellery</li>
              <li class="by"><img src="images/do.png" alt=""></li>
               <div class="clearfix"> </div>
             </ul>
            <div class="single-bottom">
               <a href="#"><p>Fashion</p></a>
               <a href="#"><p>Precious</p></a>
               <a href="#"><p>1 Gram Gold</p></a>
              </div>
             </div>
           <div class="tab5">
            <ul class="place">
              <li class="sort">Specials</li>
              <li class="by"><img src="images/do.png" alt=""></li>
               <div class="clearfix"> </div>
             </ul>
            <div class="single-bottom">
               <a href="#"><p>Cakes</p></a>
               <a href="#"><p>Party Items</p></a>
               <a href="#"><p></p></a>
               <a href="#"><p>Relax Chairs</p></a>
              </div>
             </div>

           <!--script-->
         <script>
           $(document).ready(function(){
             $(".tab1 .single-bottom").hide();
             $(".tab2 .single-bottom").hide();
             $(".tab3 .single-bottom").hide();
             $(".tab4 .single-bottom").hide();
             $(".tab5 .single-bottom").hide();

             $(".tab1 ul").click(function(){
               $(".tab1 .single-bottom").slideToggle(300);
               $(".tab2 .single-bottom").hide();
               $(".tab3 .single-bottom").hide();
               $(".tab4 .single-bottom").hide();
               $(".tab5 .single-bottom").hide();
             })
             $(".tab2 ul").click(function(){
               $(".tab2 .single-bottom").slideToggle(300);
               $(".tab1 .single-bottom").hide();
               $(".tab3 .single-bottom").hide();
               $(".tab4 .single-bottom").hide();
               $(".tab5 .single-bottom").hide();
             })
             $(".tab3 ul").click(function(){
               $(".tab3 .single-bottom").slideToggle(300);
               $(".tab4 .single-bottom").hide();
               $(".tab5 .single-bottom").hide();
               $(".tab2 .single-bottom").hide();
               $(".tab1 .single-bottom").hide();
             })
             $(".tab4 ul").click(function(){
               $(".tab4 .single-bottom").slideToggle(300);
               $(".tab5 .single-bottom").hide();
               $(".tab3 .single-bottom").hide();
               $(".tab2 .single-bottom").hide();
               $(".tab1 .single-bottom").hide();
             })
             $(".tab5 ul").click(function(){
               $(".tab5 .single-bottom").slideToggle(300);
               $(".tab4 .single-bottom").hide();
               $(".tab3 .single-bottom").hide();
               $(".tab2 .single-bottom").hide();
               $(".tab1 .single-bottom").hide();
             })
           });
         </script>
         <!-- script -->
      </section>
        <section  class="sky-form">
         <h4><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>Price</h4>
           <ul class="dropdown-menu1">
              <li><a href="">
             <div id="slider-range"></div>
             <input type="text" id="amount" style="border: 0; font-weight: NORMAL;   font-family: 'Arimo', sans-serif;" />
            </a></li>
           </ul>
        </section>
        <!---->
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
       <script type='text/javascript'>//<![CDATA[
       $(window).load(function(){
        $( "#slider-range" ).slider({
             range: true,
             min: 0,
             max: 400000,
             values: [ 8500, 350000 ],
             slide: function( event, ui ) {  $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
             }
        });
       $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );

       });//]]>
       </script>
    </div>
     </div>
 </div>
</div>

<?php
$js_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_footer.php';
?>