<?php 
	//-------------------------SETUP--------------------------

	//set config file values
	include "config.php";

	//connect to database
	$DB_connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	if($DB_connection)
		{echo '<script>console.log("Connection Successful with: (' . DB_DATABASE . ') database")</script>';}
	else 
		{echo 'Could not connect to database (' . DB_DATABASE . ')';}


	/*NOTES: we can either just make functions or 
			organize it into object-oriented style by making classes*/

	//--------------------GLOBAL FUNCTIONS--------------------

	//say hi
	function say_hi()
	{
		echo "hi";
	}


	//-------------------------CLASSES------------------------

	//this handles data
	class tuffy_user
	{
		public $conn;	//necessary to connect to database

		//object constructor: 1st var: database link
		function __construct($DB_connection)
		{
			$this->conn = $DB_connection;
		}

		function tuffy_hi()
		{
			echo "tuffy hi";
		}
	}


	$user_obj = new tuffy_user($DB_connection)
?>