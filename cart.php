<?php
$title = 'Shopping Cart'; # Enter title of page
$css_files = array(
  "cart.css"
);
include $_SERVER['DOCUMENT_ROOT'] . 'php/phtml/html_header.phtml';
?>
<h3>Shopping Cart</h3>

<p>Your shopping cart is empty.</p>

<form action="" method="post">
  <div class="item-card">
    <span class="name">Item #1</span>
    <input type="number" name="quantity-1" min="1">
    <span class="base-price">9.00</span>
    <span class="price"></span>
    <input type="hidden" name="item-id-1" value="1">
  </div>
  <div class="item-card">
    <span class="name">Item #2</span>
    <input type="number" name="quantity-2" min="1">
    <span class="base-price">6.50</span>
    <span class="price"></span>
    <input type="hidden" name="item-id-2" value="2">
  </div>
  <div id="purchase-btn">
    <button type="submit">Buy Now!</button>
  </div>
</form>

<h3>Wishlist</h3>

<p>Your wishlist is empty</p>

<div class="wish-card">
  <span class="name">Item Name</span>
</div>
<?php
$js_files = array(
  "cart.js"
);
include $_SERVER['DOCUMENT_ROOT'] . 'php/phtml/html_footer.phtml';
?>