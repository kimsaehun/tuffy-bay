<?php
$title = 'Tuffy Bay';
$css_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_header.php';
?>

<div class="container">
	<div>
		<img src="images/TuffyBay_Banner.png" width="100%" />
	</div>

	<!--USER INFO AND ACTION LINKS-->
	<?php echo "Hello ".$_SESSION['user']['username']."!"; ?>
	<a href="<?php echo "http://" .$_SERVER['SERVER_NAME']. "?action=logout"; ?>">LOGOUT</a>
	|
	<a href="<?php echo "http://" .$_SERVER['SERVER_NAME']; ?>">Home</a>
	|
	<a href="<?php echo "http://" .$_SERVER['SERVER_NAME']. "/manage_user.php"; ?>">manage account</a>
	<ul>
	    <li>
	        <h5>Social Media</h5>
	        <ul>
	            <li><a href="#"> Facebook</a></li>
	            <li><a href="#"> Twitter</a></li>
	        </ul>
	    </li>
	</ul>
	<!--ADMIN SECTION (INVENTORY)-->
	<?php if ($_SESSION['user']['type'] == 1): ?>
		<h2>ADMIN SECTION</h2>

		<!--item adding-->
		<div style = "border: 1px solid #eee;padding: 10px 20px;margin:10px;">
			<i>add an item to inventory:</i>
			<form method="post">
				name: <input type="text" name="item_name">
				how many: <input type="text" name="item_count">
				price: <input type="text" name="item_price">
				description: <textarea name = "item_description"></textarea>
				<button name="add_item" type="submit">ADD</button>
			</form>
		</div>

		<!--item display/editing/deleting-->
		<div style="border: 1px solid #eee;padding: 10px 20px;margin:10px;">
			<i>current inventory:</i>
			<table>
				<tr>
					<th>Name</th>
					<th>Price</th>
					<th>Count</th>
					<th>description</th>
				</tr>
			</table>
		</div>
	<?php endif; ?>
	<!--ADMIN CONSOLE, display post data-->
	<br><br>
	<div style="border: solid black 1px;padding: 10px 20px 40px 20px;">
		<strong>admin "console"</strong><br>
		<?php echo "post data: "; var_dump($_POST); ?>
	</div>
</div>

<?php
$js_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_footer.php';
?>