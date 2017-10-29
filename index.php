<?php 
	include 'functions.php';
	$tuffy_inventory = new tuffy_inventory($DB_connection);

	//TODO: we should do authentication restrictions on javascript, doing it on php in the meantime
	$msg = "";
	if ( isset($_POST['login-username']) )
	{
		if ( !empty($_POST['login-username']) )
		{
			if( !empty($_POST['login-password']) )
			{
				$tuffy_user->login_user($_POST['login-username'], $_POST['login-password']);
				if (!$tuffy_user->login_usernameFound){$msg="username not valid";}
				else if (!$tuffy_user->login_correctPassword){$msg="wrong password";}
			}
			else{$msg="need password...";}
		}
		else{$msg="need username...";}
	}

	//logging out directs us to index.php (this page) using GET method. Handling it here
	if($_GET['action'] == "logout" && $tuffy_user->is_loggedin())
	{
		$tuffy_user->logout();
		$msg="logged out";
	}
?>



<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="_CSS/bootstrap.min.css">

<title>Tuffy Bay</title>
</head>
<body>
	<header>

	<!--USER INFO-->
	<?php if (!$tuffy_user->is_loggedin()): ?>
	<div id="lnk_login" style="position: relative;">
		<span style="position: absolute;top: 0;right: 0;color:#000000;font-family:Arial;font-size:13px;">
			<a href="/login_page.php" target="_self" title="Login">Login/Register</a>
		</span>
	</div>
	<?php else: //if user is logged in ?>

		<!--user info/links-->
		<span style="position: absolute;top: 0;right: 0;color:#000000;font-family:Arial;font-size:13px;">
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
		</span>
	<?php endif; ?>


	<!--DEPARTMENT NAVIGATION-->
	<div role="navigation">
		<form role="search" accept-charset="utf-8" action="/s/ref=nb_sb_noss" method="GET" name="site-search">
		<div data-value="search-alias=aps">Search Our Departments</div>
		<select tabindex="18" title="Search in" name="url" aria-describedby="searchDropdownDescription" data-nav-digest="qX7zOjG0eg7nh/k/d9rgJ/gOeJA" data-nav-selected="0">
		<option selected="selected" value="search-alias=aps">All Departments</option>
		<option value="search-alias=appliances">Appliances</option>
		<option value="search-alias=mobile-apps">Apps &amp; Games</option>
		<option value="search-alias=arts-crafts">Arts, Crafts &amp; Sewing</option>
		<option value="search-alias=automotive">Automotive Parts &amp; Accessories</option>
		<option value="search-alias=baby-products">Baby</option>
		<option value="search-alias=beauty">Beauty &amp; Personal Care</option>
		<option value="search-alias=stripbooks">Books</option>
		<option value="search-alias=popular">CDs &amp; Vinyl</option>
		<option value="search-alias=mobile">Cell Phones &amp; Accessories</option>
		<option value="search-alias=fashion">Clothing, Shoes &amp; Jewelry</option>
		<option value="search-alias=fashion-womens">Women</option>
		<option value="search-alias=fashion-mens">Men</option>
		<option value="search-alias=fashion-girls">Girls</option>
		<option value="search-alias=fashion-boys">Boys</option>
		<option value="search-alias=collectibles">Collectibles &amp; Fine Art</option>
		<option value="search-alias=computers">Computers</option>
		<option value="search-alias=digital-music">Digital Music</option>
		<option value="search-alias=electronics">Electronics</option>
		<option value="search-alias=gift-cards">Gift Cards</option>
		<option value="search-alias=grocery">Grocery &amp; Gourmet Food</option>
		<option value="search-alias=handmade">Handmade</option>
		<option value="search-alias=hpc">Health, Household &amp; Baby Care</option>
		<option value="search-alias=local-services">Home &amp; Business Services</option>
		<option value="search-alias=garden">Home &amp; Kitchen</option>
		<option value="search-alias=fashion-luggage">Luggage &amp; Travel Gear</option>
		<option value="search-alias=luxury-beauty">Luxury Beauty</option>
		<option value="search-alias=magazines">Magazine Subscriptions</option>
		<option value="search-alias=movies-tv">Movies &amp; TV</option>
		<option value="search-alias=mi">Musical Instruments</option>
		<option value="search-alias=office-products">Office Products</option>
		<option value="search-alias=pets">Pet Supplies</option>
		<option value="search-alias=software">Software</option>
		<option value="search-alias=sporting">Sports &amp; Outdoors</option>
		<option value="search-alias=tools">Tools &amp; Home Improvement</option>
		<option value="search-alias=toys-and-games">Toys &amp; Games</option>
		<option value="search-alias=vehicles">Vehicles</option>
		<option value="search-alias=videogames">Video Games</option>
		<option value="search-alias=wine">Wine</option>
		</select>


		<div>
			<img src="_IMG/TuffyBay_Banner_v1.png" width="1326px" height="496px" />
		</div>
		<div>
			<img src="_IMG/1072671_pr_disaster-relief_gw_desktop_sidekick_264x170._CB515367141_.png" alt="Donate to Disaster Relief efforts" width="264px" height="170px" /><hr />
			<div><img src="_IMG/Tuffy_computer_small.JPG" width="264px" height="170px" />
				<div>Get fast, free shipping with TuffyBay</div>
			</div>
		</div>
		</form>
	</div>
	</header>

	<!--ITEMS DISPLAY-->
	<div style="margin: 0px auto; width: 90%">
		<h1 style="text-align: center">Available Items: </h1>
		<table class="table">
			<tr>
				<th>Name</th>
				<th># in stock</th>
				<th>Price</th>
				<th>description</th>
			</tr>
		<?php $inv_items = $tuffy_inventory->inventory_display(); ?>
		<?php foreach($inv_items as $item): ?>
			<tr>
				<td><?php echo $item['name']?></td>
				<td><?php echo $item['count']?></td>
				<td>$<?php echo $item['price']?></td>
				<td><?php echo $item['description']?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	</div>
</body>
</html>
