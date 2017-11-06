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