<?php 
	//-------------------------SETUP--------------------------

	//set config file values
	include "config.php";

	//connect to database
	$DB_connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	session_start();
	date_default_timezone_set('America/Los_Angeles');

	/*NOTES: we can either just make functions or 
			organize it into object-oriented style by making classes*/

	//--------------------GLOBAL FUNCTIONS--------------------

	//say hi
	function say_hi()
	{
		echo "hi";
	}

	//taken from http://www.w3schools.in/php-script/time-ago-function/
	function get_time_ago( $time )
	{
		if ($time == null){return "undefined";}

	    $time_difference = time() - $time;
	
	    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
	    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
	                30 * 24 * 60 * 60       =>  'month',
	                24 * 60 * 60            =>  'day',
	                60 * 60                 =>  'hour',
	                60                      =>  'minute',
	                1                       =>  'second'
	    );
	
	    foreach( $condition as $secs => $str )
	    {
	        $d = $time_difference / $secs;
	
	        if( $d >= 1 )
	        {
	            $t = round( $d );
	            return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
	        }
	    }
	}

	function create_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return $slug;
	}




	//-------------------------CLASSES------------------------

	//user logic (register, login, validation)
	class tuffy_user
	{
		public $conn;	//necessary to connect to database

		//object constructor: 1st var: database link
		function __construct($DB_connection)
		{
			$this->conn = $DB_connection;
		}

		//Registers user into database
		public $register_usernameTaken = false;

		function register_user($username_post, $password_post, $email_post)
		{
			$conn = $this->conn;
			$users_table = USERS_TABLE;

			//real_escape prevents code injection
			$username_post = $conn->real_escape_string($username_post);
			$password_post = $conn->real_escape_string($password_post);
			$email_post = $conn->real_escape_string($email_post);

			//password hash and salt
	  		$passHashed = password_hash($password_post, PASSWORD_DEFAULT);

			//Database values
	  		$selectQuery = "SELECT * FROM $users_table WHERE username = '$username_post'";
	  		$selectResult = $conn->query($selectQuery);

	  		//Is username already taken in database?
	  		if($selectResult->num_rows == 0)
  			{
  				$this->register_usernameTaken = false;
  			}else{
	  			$this->register_usernameTaken = true;
	  		}

		  	//If username is not in database, register!
	  		if(!$this->register_usernameTaken)
	  		{
				$insertQuery = "INSERT INTO $users_table (username, password, email) VALUES ('$username_post', '$passHashed', '$email_post')";
				$insertResult = $conn->query($insertQuery);

				if($insertResult)
				{
					//log them in after they successfully registers
					$this->login_user($username_post, $password_post);
					header("Location: http://" .$_SERVER['SERVER_NAME']);
					exit;
				}
			}
		}

		public $login_usernameFound = false;
		public $login_correctPassword = false;

		function login_user($username_post, $password_post)
		{
			$conn = $this->conn;
			$users_table = USERS_TABLE;

			//Check if username matches one in database
	  		$selectQuery = "SELECT * FROM $users_table WHERE username = '$username_post'";
	  		$usernameMatch = $conn->query($selectQuery);

	  		if($usernameMatch->num_rows == 0)
	  		{
	  			$this->login_usernameFound = false;
	  		}
	  		else
	  		{
	  			$this->login_usernameFound = true;
	  			//echo "Correct Username";
	  			$user_row = mysqli_fetch_assoc($usernameMatch); //Take the row where user was found
	  			$user_row_name = $user_row['username'];
	  			$user_row_pass = $user_row['password'];
	  			$user_row_ID = $user_row['id'];
	  			$user_row_type = $user_row['type'];
	  			$user_row_money = $user_row['money'];
	  			$user_row_email = $user_row['email'];

	  			//password_verify checks the the algo-options and unique salt of $user_row_pass and applies to $password_post
	  			if(password_verify($password_post, $user_row_pass))
	  			{
	  				// Check if a newer hashing algorithm is available
				    if (password_needs_rehash($user_row_pass, PASSWORD_DEFAULT))
				    {
				        // If so, create a new hash, and replace the old one
				        $new_hash_pass = password_hash($password_post, PASSWORD_DEFAULT);
				        $updateQuery = "UPDATE $table SET password = '$new_hash_pass' WHERE id = '$user_row_ID'";
				       	$conn->query($updateQuery);
				    }
				    $this->login_correctPassword = true;
	  			}
	  			else{$this->login_correctPassword = false;}
	  		}

	  		//If log in successful, save session data and redirect
	  		if($this->login_usernameFound && $this->login_correctPassword)
	  		{
	  			$_SESSION['user']['id'] = $user_row_ID;
	  			$_SESSION['user']['username'] = $user_row_name;
	  			$_SESSION['user']['type'] = $user_row_type;
	  			$_SESSION['user']['money'] = $user_row_money;
	  			$_SESSION['user']['email'] = $user_row_email;
	  			$_SESSION['user']['login_time'] = new DateTime("now");	//will use this later in is_loggedin() function
	  			
	  			//Cannot have any output before this like echo or print
	  			header("Location: http://" .$_SERVER['SERVER_NAME']);
	  			/* Make sure that code below does not get executed when we redirect. */
	  			exit;
	  		}

		}

		function is_loggedin()
		{
			$conn = $this->conn;

			if (isset($_SESSION['user']['id']))
			{
				$selectQuery = "SELECT username,money,type,email FROM " .USERS_TABLE. " WHERE id = " . $_SESSION['user']['id'];
	  			$idMatch = $conn->query($selectQuery);

	  			if ($idMatch->num_rows == 1)
  				{
  					$user_row = mysqli_fetch_assoc($idMatch);

  					//update the values on client side
		  			$_SESSION['user']['username'] = $user_row['username'];
		  			$_SESSION['user']['type'] = $user_row['type'];
		  			$_SESSION['user']['money'] = $user_row['money'];
		  			$_SESSION['user']['email'] = $user_row['email'];
  					return true;
  				}
			}
			return false;
		}

		function logout()
		{
			//empty out session data for user
			$_SESSION['user'] = [];
		}

		function update_email($user_id, $email)
		{
			//Check if email already exists
	  		$selectQ = "SELECT id FROM ".USERS_TABLE." WHERE email = '$email'";
	  		$emailMatch = $this->conn->query($selectQ);

	  		if($emailMatch->num_rows == 0)
	  		{
	  			$updateQ = "UPDATE ".USERS_TABLE." SET email = '$email' WHERE id = '$user_id'";
				$this->conn->query($updateQ);

				return true;
	  		}

	  		return false;
		}

		function update_password($user_id, $curr_password, $new_password)
		{
			$selectQ = "SELECT password FROM ".USERS_TABLE." WHERE id = '$user_id'";
			$selectResult = $this->conn->query($selectQ);
			$user_info = mysqli_fetch_assoc($selectResult);

			//check if current password matches (TODO: i think need to check using password_needs_rehash(); )
			if(password_verify($curr_password, $user_info['password']))
			{
				$hashed_pass = password_hash($new_password, PASSWORD_DEFAULT);

				$updateQ = "UPDATE ".USERS_TABLE." SET password = '$hashed_pass' WHERE id = '$user_id'";

				if ($this->conn->query($updateQ))
				{
					return true;
				}
			}
			else
			{
				return false;
			}
		}

		function add_money($user_id, $money_amount)
		{

			$updateQ = "UPDATE ".USERS_TABLE." SET money = money + '$money_amount' WHERE id = '$user_id'";
			if ($this->conn->query($updateQ))
			{
				return true;
			}

			return false;
		}
	}

	class tuffy_inventory
	{
		public $conn;	//necessary to connect to database

		//object constructor: 1st var: database link
		function __construct($DB_connection)
		{
			$this->conn = $DB_connection;
		}

		function inventory_add_item($name, $count, $price, $description)
		{
			$insertQuery = "INSERT INTO " .INVENTORY_TABLE. " (name, count, price, description) VALUES ('$name', '$count', '$price', '$description')";
			$insertResult = $this->conn->query($insertQuery);

			//if insert was successful
			if ($insertResult){return true;}
			return false;
		}

		function inventory_get_item($inventory_id)
		{
			$selectQ = "SELECT * FROM ".INVENTORY_TABLE." WHERE id = '$inventory_id'";
			$selectResult = $this->conn->query($selectQ);

			if (!$selectResult){return false;}

			$item = mysqli_fetch_assoc($selectResult);
			return $item;
		}

		function inventory_display()
		{
			$selectQ = "SELECT * FROM ".INVENTORY_TABLE." LIMIT 10";
			$selectResult = $this->conn->query($selectQ);

			if (!$selectResult){return false;}

			$inventory_arr = array();
			while($table_row = $selectResult->fetch_assoc())
			{
				$row_data = array(
							'id' => $table_row['id'],
							'name' => $table_row['name'],
							'count' => $table_row['count'],
							'price' => $table_row['price'],
							'description' =>$table_row['description']
							);
				array_push($inventory_arr, $row_data);
			}

			return $inventory_arr;
		}

		function inventory_delete_item($inventory_id)
		{
			$deleteQ = "DELETE FROM ".INVENTORY_TABLE." WHERE id = '$inventory_id'";
			$deleteResult = $this->conn->query($deleteQ);

			if ($deleteResult){return true;}
			return false;
		}

		//TODO THIS
		function inventory_buy_item($inventory_id, $user_id, $buying_count)
		{
			$selectQ = "SELECT count FROM ".INVENTORY_TABLE." WHERE id = '$inventory_id'";
			$selectResult = $this->conn->query($selectQ);

			if (!$selectResult){return false;}

			//DECREASE COUNT FROM DATABASE
			$item = mysqli_fetch_assoc($selectResult);
			$item_count = $item['count'];

			$new_item_count = $item_count - $buying_count;

			$updateQ = "UPDATE ".INVENTORY_TABLE." SET count = '$new_item_count' WHERE id = '$inventory_id'";
			$this->conn->query($updateQ);

			//ADD TO SHOPPING CART

		}

		//TODO (#3): improve searching algorithm
		function search_item($item_name)
		{
			$selectQ = "SELECT * FROM ".INVENTORY_TABLE." WHERE name = '$item_name'";
			$selectResult = $this->conn->query($selectQ);

			if ($selectResult->num_rows == 0){return null;}

			$search_results = array();
			while($table_row = $selectResult->fetch_assoc())
			{
				array_push($search_results, $table_row);
			}
			return $search_results;
		}

		function add_to_cart($inventory_id, $user_id, $count)
		{
			//check if its already in cart
			$selectQ = "SELECT id FROM ".SHOPCART_TABLE." WHERE user_id = '$user_id' AND item_id = '$inventory_id'";
			$selectResult = $this->conn->query($selectQ);

			if ($selectResult->num_rows == 1)
			{
				$shopcart_info = mysqli_fetch_assoc($selectResult);
				$shopcart_id = $shopcart_info['id'];

				$updateQ = "UPDATE ".SHOPCART_TABLE." SET amount = amount + '$count' WHERE id = '$shopcart_id'";
				$updateResult = $this->conn->query($updateQ);

				if ($updateResult){return true;}
				return false;
			}
			else if ($selectResult->num_rows == 0)
			{
				$insertQ = "INSERT INTO ".SHOPCART_TABLE." (item_id, user_id, amount) VALUES ('$inventory_id', '$user_id', '$count')";
				$insertResult = $this->conn->query($insertQ);

				if ($insertResult){return true;}
				return false;
			}
		}

		function display_cart($user_id)
		{
			$selectQ = "SELECT * FROM ".SHOPCART_TABLE." WHERE user_id = '$user_id'";
			$selectResult = $this->conn->query($selectQ);

			if ($selectResult->num_rows == 0){return false;}

			$shopcart_arr = array();
			while($table_row = $selectResult->fetch_assoc())
			{
				$item_data = $this->inventory_get_item($table_row['item_id']);

				$row_data = array(
							'id' => $item_data['id'],
							'name' => $item_data['name'],
							'stock_count' => $item_data['count'],
							'price' => $item_data['price'],
							'description' =>$item_data['description'],
							'in_cart_count' => $table_row['amount']
							);
				array_push($shopcart_arr, $row_data);
			}

			return $shopcart_arr;
		}

		public $not_enough_money = false;

		//$items is an array of items with their info, return false if not enough stock
		function purchase_cart($user_id, $items, $total)
		{
			//get user money
			$selectQ = "SELECT money FROM ".USERS_TABLE." WHERE id = '$user_id'";
			$selectResult = $this->conn->query($selectQ);
			$user_info = mysqli_fetch_assoc($selectResult);			

			//if not enough money
			if ($total > $user_info['money'])
			{
				$this->not_enough_money = true;
				return false;
			}

			//update items in inventory
			foreach ($items as $item)
			{
				//if not enough stock
				$item_db = $this->inventory_get_item($item['id']);
				if ($item['in_cart_count'] > $item_db['count'])
				{
					return false;
				}

				//update database count value
				$new_item_count = $item_db['count'] - $item['in_cart_count'];
				$updateQ = "UPDATE ".INVENTORY_TABLE." SET count = '$new_item_count' WHERE id = ".$item['id'];
				$this->conn->query($updateQ);

				//remove from cart
				$deleteQ = "DELETE FROM ".SHOPCART_TABLE." WHERE item_id = ".$item['id'];
				$this->conn->query($deleteQ);

				//add to orders table
				$this->insert_order($user_id, $item);

				//decrease user money
				$new_user_money = $user_info['money'] - $total;
				$updateMoney = "UPDATE ".USERS_TABLE." SET money = '$new_user_money' WHERE id = ".$user_id;
				$this->conn->query($updateMoney);
			}

		}


		//ORDERS
		function insert_order($user_id, $item)
		{
			$item_id = $item['id'];
			$item_name = $item['name'];
			$item_amt = $item['in_cart_count'];
			$item_price = $item['price'];
			$item_desc = $item['description'];
			$curr_time = new DateTime("now");
			$curr_time = $curr_time->format("Y-m-d H:i:s"); //this is how datetime is stored in sql


			$insertQ = "INSERT INTO ".ORDERS_TABLE." 
						(user_id, inventory_id, name, amount, price, description, date_ordered) 
						VALUES ('$user_id', '$item_id', '$item_name', '$item_amt', '$item_price', '$item_desc', '$curr_time')";

			$insertResult = $this->conn->query($insertQ);
		}

		function display_orders($user_id)
		{
			$selectQ = "SELECT * FROM ".ORDERS_TABLE." WHERE user_id = '$user_id'";
			$selectResult = $this->conn->query($selectQ);

			$order_arr = array();
			while($table_row = $selectResult->fetch_assoc())
			{
				array_push($order_arr, $table_row);
			}

			return $order_arr;
		}

		function update_cart_count($user_id, $item_id, $new_amount)
		{
			$updateQ = "UPDATE ".SHOPCART_TABLE." SET amount = '$new_amount' WHERE user_id = '$user_id' AND item_id = '$item_id'";
			$updateResult = $this->conn->query($updateQ);

			if ($updateResult){return true;}
			return false;
		}

		function delete_cart_count($user_id, $item_id)
		{

			$deleteQ = "DELETE FROM ".SHOPCART_TABLE." WHERE user_id = '$user_id' AND item_id = '$item_id'";
			$deleteResult = $this->conn->query($deleteQ);

			if ($deleteResult){return true;}
			return false;
		}

		function get_cart_count($user_id, $item_id)
		{
			$selectQ = "SELECT COUNT(*) FROM ".SHOPCART_TABLE." WHERE user_id = '$user_id' AND item_id = '$item_id'";
			$selectResult = $this->conn->query($selectQ);

			var_dump ($selectResult);
		}
	}



	$tuffy_user = new tuffy_user($DB_connection);
?>