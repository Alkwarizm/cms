<?php require_once '../../private/initialize.php'; ?>

<?php 
	$errors = [];
	$username = '';
	$password = '';

	if (request_is_post()) {
		$username = $_POST['username'] ?? '';
		$password = $_POST['password'] ?? '';

		//validation
		if (is_blank($username)) {
			$errors[] = 'Username cannot be blank';
		}
		if (is_blank($password)) {
			$errors[] = 'Password cannot be blank';
		}
		//If there are no errors, check user exists
		if (empty($errors)) {
			$user = find_user_by_username($username);
			$login_failed_msg = 'Log in was unsuccessful';

			if ($user) {
				//user found
				if (password_verify($password, $user['hashed_password'])) {
					//password is a match
					log_in_user($user);
					redirect_to(url_for('/staff/index.php'));
				}else {
					//password is not a match
					$errors[] = $login_failed_msg;
				}
			}else {
				//user not found
				$errors[] = $login_failed_msg;
			}
		}
		

		
	}


 ?>



<?php $page_title = 'Log in'; ?>

<?php include SHARED_PATH . '/staff_header.php'; ?>
<header>
	<h2>GBI Staff Area</h2>
</header>
<div id="content">
	<h1>Log in</h1>
	
	<?php echo !empty($errors) ? display_errors($errors) : ''; ?>

	<form action="<?php echo url_for('/staff/login.php'); ?>" method="post">
		Username: <br />
		<input type="text" name="username"><br />
		Password: <br />
		<input type="password" name="password" value=""><br />
		<input type="submit" name="submit" value="Submit">
	</form>


</div>




<?php include SHARED_PATH . '/staff_footer.php'; ?>