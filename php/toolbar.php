
<div id="toolbar">
	<!--LEFT SIDE OF NAVBAR-->
  	<a href="index.php">Home</a>
  	<a href="/cart.php">Cart</a>

  	<!--RIGHT SIDE OF NAVBAR-->
  	<span style="position: absolute;top: 0;right: 0;">
  	<!--USER INFO-->
  	<!--case: not logged in-->
	<?php if (!$tuffy_user->is_loggedin()): ?>
	<a href="/login.php" target="_self" title="Login">Login/Register</a>
	<?php else: //if user is logged in ?>

	<!--case: logged in-->
	<a href="/user_page.php">
		<?php
			echo $_SESSION['user']['username'];
			if ($_SESSION['user']['type'] == 1)
			{
				echo "(admin)";
			}
		?>
	</a>|
	<a href="<?php echo "http://" .$_SERVER['SERVER_NAME']. "?action=logout"; ?>">LOGOUT</a>
	<?php endif; ?>
	</span>
</div>