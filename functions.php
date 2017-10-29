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
				$selectQuery = "SELECT username,type FROM " .USERS_TABLE. " WHERE id = " . $_SESSION['user']['id'];
	  			$idMatch = $conn->query($selectQuery);

	  			if ($idMatch->num_rows == 1)
  				{
  					$user_row = mysqli_fetch_assoc($idMatch);

		  			$_SESSION['user']['username'] = $user_row['username'];
		  			$_SESSION['user']['type'] = $user_row['type'];
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
			$conn = $this->conn;

			$insertQuery = "INSERT INTO " .INVENTORY_TABLE. " (name, count, price, description) VALUES ('$name', '$count', '$price', '$description')";
			$insertResult = $conn->query($insertQuery);

			//if insert was successful
			if ($insertResult){return true;}
			return false;
		}

		function inventory_display()
		{
			$conn = $this->conn;

			$selectQ = "SELECT * FROM ".INVENTORY_TABLE." LIMIT 10";
			$selectResult = $conn->query($selectQ);

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
	}



	$tuffy_user = new tuffy_user($DB_connection);
?>