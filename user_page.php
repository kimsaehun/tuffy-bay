<?php 
include 'functions.php';
$tuffy_inventory = new tuffy_inventory($DB_connection);

//if user is not logged in, kick them out
if(!$tuffy_user->is_loggedin())
{
	header("Location: http://" .$_SERVER['SERVER_NAME']);
	exit;
}

//if user presses "ADD"
if (isset($_POST['add_item']))
{
	$tuffy_inventory->inventory_add_item($_POST['item_name'], $_POST['item_count'], $_POST['item_price'], $_POST['item_description']);
}//if user deletes an item
else if (isset($_POST['delete_item']))
{
	$tuffy_inventory->inventory_delete_item($_POST['id_to_delete']);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div>
	<img src="res/img/TuffyBay_Banner_v1.png" width="1326px" height="396px" />
</div>

<!--USER INFO AND ACTION LINKS-->
<?php echo "Hello ".$_SESSION['user']['username']."!"; ?>
<a href="<?php echo "http://" .$_SERVER['SERVER_NAME']. "?action=logout"; ?>">LOGOUT</a>
|
<a href="<?php echo "http://" .$_SERVER['SERVER_NAME']; ?>">Home</a>
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
		<?php $inv_items = $tuffy_inventory->inventory_display(); ?>
		<?php foreach($inv_items as $item): ?>
			<tr>
				<td><?php echo $item['name']?></td>
				<td><?php echo $item['count']?></td>
				<td><?php echo $item['price']?></td>
				<td><?php echo $item['description']?></td>
				<td>
					<form method="post">
						<input type="text" hidden name="id_to_delete" value="<?php echo $item['id']; ?>">
						<button name="delete_item">delete</button>
					</form>
				</td>

			</tr>
		<?php endforeach; ?>
		</table>
	</div>
<?endif; ?>

<!--ADMIN CONSOLE, display post data-->
<br><br>
<div style="border: solid black 1px;padding: 10px 20px 40px 20px;">
	<strong>admin "console"</strong><br>
	<?php echo "post data: "; var_dump($_POST); ?>	
</div>

</body>
</html>