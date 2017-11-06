<?php 
	include 'functions.php';

	//if user is not logged in, kick them out
	if(!$tuffy_user->is_loggedin())
	{
		header("Location: http://" .$_SERVER['SERVER_NAME']);
		exit;
	}
	
	$tuffy_inventory = new tuffy_inventory($DB_connection);
	$title = 'Success purchase'; # Enter title of page
	$css_files = array('bootstrap.min.css');


	$in_delivery_orders = array();
	$finished_orders = array();
	$return_requests = array();
	$orders = $tuffy_inventory->display_orders($_SESSION['user']['id']);
	foreach ($orders as $item_order)
	{
		if ($item_order['return_request'] == 1)
		{
			array_push($return_requests, $item_order);
		}
		else if ($item_order['has_arrived'] == 0)
		{
			array_push($in_delivery_orders, $item_order);
		}
		else
		{
			array_push($finished_orders, $item_order);
		}
	}

	if (isset($_POST['asked_return']))
	{
		$tuffy_inventory->return_request($_POST['order_id']);
		header("Refresh:0");
	}
	include $_SERVER['DOCUMENT_ROOT'] . '/php/phtml/html_header.phtml';
?>

<div class="container-fluid">
	<h2>Open orders(in delivery): </h2>

	<table class="table">
		<tr>
			<th>Name</th>
			<th>amount</th>
			<th>Price</th>
			<th>Description</th>
			<th>payment method</th>
			<th>Date ordered</th>
			<th>actions</th>
		</tr>
	<?php foreach($in_delivery_orders as $item): ?>
	<div class="row">
		<div class = "col-xs-12">
		<tr>

			<td><a href="/item_page.php?itemid=<?php echo $item['inventory_id'];?>"><?php echo $item['name']?></a></td>
			<td><?php echo $item['amount']?></td>
			<td>$<?php echo $item['price']?></td>
			<td><?php echo $item['description']?></td>
			<td><?php echo $item['payment_used']?></td>
			<td><?php echo get_time_ago(strtotime($item['date_ordered'])); ?></td>
			<td>
			<form method="post">
				<input hidden name="order_id" = value = "<?php echo $item['id']; ?>">
				<button type = "submit" name = "asked_return">return</button>
			</form>
			</td>
		</tr>
		</div>
	</div>
	<?php endforeach;?>
	</table>
	

	<h2>Orders: </h2>

	<table class="table">
		<tr>
			<th>Name</th>
			<th>amount</th>
			<th>Price</th>
			<th>Description</th>
			<th>payment method</th>
			<th>Date ordered</th>
			<th>Date Arrived</th>
		</tr>
	<?php foreach($finished_orders as $item): ?>
	<div class="row">
		<div class = "col-xs-12">
		<tr>
			<td><a href="/item_page.php?itemid=<?php echo $item['inventory_id'];?>"><?php echo $item['name']?></a></td>
			<td><?php echo $item['amount']?></td>
			<td>$<?php echo $item['price']?></td>
			<td><?php echo $item['description']?></td>
			<td><?php echo $item['payment_used']?></td>
			<td><?php echo get_time_ago(strtotime($item['date_ordered'])); ?></td>
			<td><?php echo get_time_ago(strtotime($item['date_arrived'])); ?></td>
		</tr>
		</div>
	</div>
	<?php endforeach;?>
	</table>


	<h2>Returns requests: </h2>

	<table class="table">
		<tr>
			<th>Name</th>
			<th>amount</th>
			<th>Price</th>
			<th>Description</th>
			<th>payment method</th>
			<th>Date ordered</th>
		</tr>
	<?php foreach($return_requests as $item): ?>
	<div class="row">
		<div class = "col-xs-12">
		<tr>
			<td><a href="/item_page.php?itemid=<?php echo $item['inventory_id'];?>"><?php echo $item['name']?></a></td>
			<td><?php echo $item['amount']?></td>
			<td>$<?php echo $item['price']?></td>
			<td><?php echo $item['description']?></td>
			<td><?php echo $item['payment_used']?></td>
			<td><?php echo get_time_ago(strtotime($item['date_ordered'])); ?></td>
		</tr>
		</div>
	</div>
	<?php endforeach;?>
	</table>
</div>


<?php 
	$js_files = array();
	include $_SERVER['DOCUMENT_ROOT'] . '/php/phtml/html_footer.phtml';
?>

