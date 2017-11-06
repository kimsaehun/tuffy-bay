<?php
include 'functions.php';
$title = ''; # Enter title of page
$css_files = array(
  'bootstrap.min.css'
);
$tuffy_inventory = new tuffy_inventory($DB_connection);


if (isset($_POST['search_item']))
{
    $search_result = $tuffy_inventory->search_item($_POST['search_input']);
}

include $_SERVER['DOCUMENT_ROOT'] . '/php/phtml/html_header.phtml';
?>

<!--SEARCH BAR-->
<div class="row" align="center">
    <form method="post">
        <input type="text" name="search_input">
        <button type="submit" name="search_item">SEARCH</button>
    </form>
</div>

<div class="container">
	<div style="margin-top: 50px;" class="row" align="center">
		<?php if (!isset($_POST['search_item'])): ?>
		<h3>no search input</h3>
		<?php elseif ($search_result !== null): ?>
			<table class="table">
			<tr>
				<th>Name</th>
				<th>amount</th>
				<th>Price</th>
				<th>Description</th>
			</tr>
			<?php foreach ($search_result as $item): ?>
				<tr>
					<td><a href="/item_page.php?itemid=<?php echo $item['id'];?>"><?php echo $item['name']?></a></td>
					<td><?php echo $item['count']?></td>
					<td>$<?php echo $item['price']?></td>
					<td><?php echo $item['description']?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php else: ?>
			<h3>found no matches</h3>
		<?php endif; ?>
	</div>
</div>


<?php
$js_files = array(
  # put js files here
);
include $_SERVER['DOCUMENT_ROOT'] . '/php/phtml/html_footer.phtml';
?>