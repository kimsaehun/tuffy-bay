<?php
include 'functions.php';
$title = 'Shopping Cart'; # Enter title of page
$css_files = array(
  "cart.css"
);

//if user is not logged in, kick them out
if(!$tuffy_user->is_loggedin())
{
  header("Location: http://" .$_SERVER['SERVER_NAME']);
  exit;
}

?>
<?php
  $tuffy_inventory = new tuffy_inventory($DB_connection);

  $cart = $tuffy_inventory->display_cart($_SESSION['user']['id']);
  $total_price = 0.00;


  if (isset($_POST['order_cart']))
  {
    $tuffy_inventory->purchase_cart($_SESSION['user']['id'], $cart, $_POST['total_price']);
    if (!$tuffy_inventory->not_enough_money)
    {
      header("Location: http://" .$_SERVER['SERVER_NAME'] . "/orders.php");
      exit;
    }
  }
  else if(isset($_POST['update_quan']))
  {
    $tuffy_inventory->update_cart_count($_SESSION['user']['id'], $_POST['item_id'], $_POST['quantity']);
    $cart = $tuffy_inventory->display_cart($_SESSION['user']['id']);
  }
  include $_SERVER['DOCUMENT_ROOT'] . '/php/phtml/html_header.phtml';
?>
<h3>Shopping Cart</h3>

<?php if ($cart === false): ?>
<p>Your shopping cart is empty.</p>
<?php else: ?>
<?php foreach($cart as $item): ?>
  <?php
    $total_price += $item['price'] * $item['in_cart_count'];
  ?>
<form method="post">
  <div class="item-card">
    <span class="name"><?php echo $item['name']; ?></span>
    <input type="number" name="quantity" min="1" value = "<?php echo $item['in_cart_count']; ?>">
    <input hidden type="number" name="item_id" value = "<?php echo $item['id']; ?>">
    <button type = "submit" name = "update_quan">update</button>
    <span>price: $<?php echo $item['price']; ?></span>

    <!--easier to do this through php for now-->
    <span class="base-price"></span>
    <span class="price"></span>
    <input type="hidden" name="item-id-1" value="1">
  </div>
</form>
<?php endforeach; ?>
<?php $total_price = number_format((float)$total_price, 2, '.', '');?>
<div>total: $<?php echo $total_price; ?></div>
<form method="post">
  <div id="purchase-btn">
    <input hidden name="total_price" value = "<?php echo $total_price; ?>">
    <button type="submit" name="order_cart">Buy Now!</button>
  </div>
</form>
<?php endif; ?>


<h3>Wishlist</h3>

<p>Your wishlist is empty</p>

<div class="wish-card">
  <span class="name">Item Name</span>
</div>

<?php if ($tuffy_inventory->not_enough_money): ?>
<h2 style="color:red"><?php echo "not enough money, add money"; ?></h2>
<?php endif; ?>
<?php
//js file was causing some errors
$js_files = array(
  ""
);
include $_SERVER['DOCUMENT_ROOT'] . '/php/phtml/html_footer.phtml';
?>