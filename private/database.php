<?php 

	require_once 'db_credentials.php';

	//connect to db
	function db_connect(){
		$connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
		confirm_db_connect();
		return $connection;
	}
	//close db connections
	function db_disconnect($connection){
		if (isset($connection)) {
			mysqli_close($connection);
		}
	}
	//handle db connection error
	function confirm_db_connect(){
		if (mysqli_connect_errno()) {
			$msg = "Database connection failed: ";
			$msg .= mysqli_connect_error();
			$msg .= " ( ".mysqli_connect_errno(). " )";
			exit($msg);
		}
	}

	//Handling SQL injection
	function db_escape($connection, $string) {
		return mysqli_real_escape_string($connection, $string);
	}
	



 ?>