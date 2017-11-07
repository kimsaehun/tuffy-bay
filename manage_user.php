<?php
$title = 'Tuffy Bay';
$css_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_header.php';
?>

<div class="container">
  <h3>change email</h3>
  <form method="post">
  	<label>New email adress: </label>
  	<input type="text" name="new_email">

  	<button type="submit" name="change_email">change email</button>
  </form>

  <h3>change password</h3>
  <form method = "post">
  	<label>Enter Current Password: </label>
  	<input type="password" name="curr_password">

  	<label>Enter New Password: </label>
  	<input type="password" name="new_password">

  	<button type="submit" name = "change_password">change password</button>
  </form>

  <h3>Add money to account</h3>
  <form method = "post">
  	<label>amount to add to balance: </label>
  	<input type="number" name="money_to_add">

  	<button type="submit" name = "add_money">add money</button>
  </form>

  <h2 style="color:red"><?php echo $msg; ?></h2>

  <?php if ($_SESSION['user']['credit_card_num'] === null): ?>
  <h3>Add Credit Card</h3>
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

    <button type="submit" name="add_credit_card">Add card</button>
  </form>
  <?php else: ?>
  <?php $card_splitted = display_credit_card($_SESSION['user']['credit_card_num']);
  echo "credit info: ";
  	foreach ($card_splitted as $fours)
  	{
  		echo $fours.' ';
  	}
  ?>
  <?php endif; ?>

  <!--user info-->
  <h1>USER INFO</h1>
  <div>
  	EMAIL: <?php echo $_SESSION['user']['email']; ?><br>
  	USERNAME: <?php echo $_SESSION['user']['username'] ?><br>
  	MONEY: <?php echo $_SESSION['user']['money'] ?>

  </div>
</div>

<?php
$js_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_footer.php';
?>