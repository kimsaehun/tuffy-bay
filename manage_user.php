<?php
include 'functions.php';
	
//if user is not logged in, kick them out
if(!$tuffy_user->is_loggedin())
{
	header("Location: http://" .$_SERVER['SERVER_NAME']);
	exit;
}

$user_id = $_SESSION['user']['id'];

if (isset($_POST['change_email']))
{
	$email_updated = $tuffy_user->update_email($user_id, $_POST['new_email']);
	if (!$email_updated)
	{
		$msg = "email already used";
	}
	else
	{
		$msg = "successfully updated email";
	}
}
else if (isset($_POST['change_password']))
{
	$password_updated = $tuffy_user->update_password($user_id, $_POST['curr_password'], $_POST['new_password']);
	if (!$password_updated)
	{
		$msg = "password doesn't match or SQL error";
	}
	else
	{
		$msg = "successfully updated password";
	}
}
else if (isset($_POST['money_to_add']))
{
	$money_updated = $tuffy_user->add_money($user_id, $_POST['money_to_add']);
	if ($money_updated){ $msg = "$".$_POST['money_to_add']." has been added to balance"; }
	else { $msg = "SQL error"; }
}
else if (isset($_POST['add_credit_card']))
{
	$security_code = $_POST['security_code'];
    $card_num = $_POST['creditCard1'] . $_POST['creditCard2'] . $_POST['creditCard3'] . $_POST['creditCard4'];
	$tuffy_user->insert_card_info($_SESSION['user']['id'], $card_num, $security_code);
}

$title = 'manage user info'; # Enter title of page
$css_files = array(
  "bootstrap.min.css"
);
include $_SERVER['DOCUMENT_ROOT'] . '/php/phtml/html_header.phtml';
?>

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

<?php
	$js_files = array(
	  "cart.js"
	); 
	include $_SERVER['DOCUMENT_ROOT'] . '/php/phtml/html_footer.phtml'; 
?>