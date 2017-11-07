<?php
$title = 'Tuffy Bay';
$css_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_header.php';
?>

<div class="container">
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
</div>

<?php
$js_files = array();
include $_SERVER['DOCUMENT_ROOT'] . '/page_modules/html_footer.php';
?>