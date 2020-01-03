<?php 
	//performs all actions necessary to log in a user
	function log_in_user($user) {
		// regenerating ID prevents session fixation
		session_regenerate_id();
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['last_login'] = time();
		$_SESSION['username'] = $user['username'];

		return true;
	}

	// contains the logic for checking if a user is logged in
	// forms the core of require_login
	// uses the user_id in order to look up the user record
	function is_logged_in() {

		return isset($_SESSION['user_id']);
	}

	function log_out_user() {
		unset($_SESSION['username']); //or $_SESSION['username'] = NULL
		unset($_SESSION['user_id']);
		unset($_SESSION['last_login']);
	}

	// uses is_logged_in to authorize user 
	function require_login() {

		if (!is_logged_in()) {
			redirect_to(url_for('/staff/login.php'));
		}
	}




 ?>