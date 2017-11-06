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

//if($tuffy_user->has_credit_card()){}

?>
<?php
  $tuffy_inventory = new tuffy_inventory($DB_connection);

  $cart = $tuffy_inventory->display_cart($_SESSION['user']['id']);
  $total_price = 0.00;
  $not_enough_stock = false;

  if (isset($_POST['order_cart']))
  {
    $payment_used = "tuffy money";
    $tuffy_inventory->purchase_cart($_SESSION['user']['id'], $cart, $_POST['total_price'], $payment_used);
    if (!$tuffy_inventory->not_enough_money)
    {
      header("Location: http://" .$_SERVER['SERVER_NAME'] . "/orders.php");
      exit;
    }
  }
  else if (isset($_POST['use_credit_card']))
  {
    if (isset($_SESSION['user']['credit_card_num']))
    {
      $card_num = $_SESSION['user']['credit_card_num'];
      $last4 = substr($card_num, -4);
      $payment_used = "credit card **** **** **** ".$last4;
    }
    else
    {
      $security_code = $_POST['security_code'];
      $card_num = $_POST['creditCard1'] . $_POST['creditCard2'] . $_POST['creditCard3'] . $_POST['creditCard4'];
      $payment_used = "credit card **** **** **** ".$_POST['creditCard4'];
    }
    //echo $card_num;
    //echo "   ".$security_code;
    //echo $payment_used;

    $tuffy_inventory->purchase_cart($_SESSION['user']['id'], $cart, $_POST['total_price'], $payment_used);
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
  else if (isset($_POST['delete_shop_item']))
  {
    $tuffy_inventory->delete_cart_count($_SESSION['user']['id'], $_POST['item_id']);
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
    <button type ="submit" name = "delete_shop_item">delete</button>
    <span>price: $<?php echo $item['price']; ?></span>

    <?php 

    if ($item['in_cart_count'] > $item['stock_count'])
    {
      $not_enough_stock = true;
      echo "<span style='color:red'>(CANNOT PURCHASE: we currently only have ".$item['stock_count']." of these in stock)</span>";
    }
    ?>

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
    <button <?php if ($not_enough_stock){echo "disabled"; }?> type="submit" name="order_cart">Buy with tuffy money</button>
  </div>
</form>

<?php if (isset($_SESSION['user']['credit_card_num'])): ?>
  <form method="post">
  <div id="purchase-btn">
    <input hidden name="total_price" value = "<?php echo $total_price; ?>">
    <button <?php if ($not_enough_stock){echo "disabled"; }?> type="submit" name="use_credit_card">Buy with card on account</button>
    <?php 
    $last4display = substr($_SESSION['user']['credit_card_num'], -4);
    echo "credit card **** **** **** ".$last4display;
    ?>
  </div>
</form>
<?php else: ?>
  <a href="/manage_user.php"> or add a credit card</a>
<?php endif; ?>

<br>
<br>
Use a credit card(not on account):
<form method="post">
  Credit Card Number:
      <input type="number" min="1000" max="9999" name="creditCard1" required/>
      -
      <input type="number" min="1000" max="9999" name="creditCard2" required/>
      -
      <input type="number" min="1000" max="9999" name="creditCard3" required/>
      -
      <input type="number" min="1000" max="9999"  name="creditCard4" required/>
      <br />

      Security Code: <input type="number" name="security_code">
      Card Expiry:
      <input class="inputCard" name="expiry" id="expiry" type="month" required/>
   
  <button type="submit" name="use_credit_card">pay with card</button>
</form>



<?php endif; ?>


<h3>Wishlist</h3>

<p>Your wishlist is empty</p>

<div class="wish-card">
  <span class="name">Item Name</span>
</div>

<?php if ($tuffy_inventory->not_enough_money): ?>
<h2 style="color:red"><?php echo "not enough money, add money"; ?></h2>
<h3>or use a credit card</h3>
<?php endif; ?>


<?php
//js file was causing some errors
$js_files = array(
  ""
);
include $_SERVER['DOCUMENT_ROOT'] . '/php/phtml/html_footer.phtml';
?>