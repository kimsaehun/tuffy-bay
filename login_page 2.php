<?php 
include 'functions.php';
if(!$tuffy_user->is_loggedin())
	{header("Location: http://" .$_SERVER['SERVER_NAME']); exit;}

$tuffy_inventory = new tuffy_inventory($DB_connection);
if (isset($_POST['add_item']))
{
	$tuffy_inventory->inventory_add_item($_POST['item_name'], $_POST['item_count'], $_POST['item_price'], $_POST['item_description']);
}
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
 <?php if(!$tuffy_user->is_loggedin()): ?>
	<form method="post">
		<input type="text" name="login-username">LOGIN<br>
		<input type="text" name="login-password">PASSWORD<br>
		<button type="submit">LOGIN</button>
	</form>
	<?php else: ?>
		<?php if ($_SESSION['user']['type'] == 1): ?>
			type admin
			ADD NEW ITEM to inventory
			<form method="post">
				name: <input type="text" name="item_name">
				how many: <input type="text" name="item_count">
				price: <input type="text" name="item_price">
				description: <textarea name = "item_description"></textarea>
				<button name="add_item" type="submit">ADD</button>
			</form>

			UPDATE INVENTORY
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

			<!--display list of inventory here, maybe a search function, then allow them to edit the count and stuff-->
		<?endif; ?>
		<?php echo "Hello ".$_SESSION['user']['username']."!"; ?>
		<a href="<?php echo "http://" .$_SERVER['SERVER_NAME']. "?action=logout"; ?>">LOGOUT</a>
	<?php endif; ?>
	<?php var_dump($_POST); ?>
 </body>
 </html>