<?php require_once '../../../private/initialize.php'; ?>

<?php require_login(); ?>
<?php $page_title = 'GBI Admin | Create User'; ?>
<?php 

	if (request_is_post()) {
		$user = [];
		$user['username'] = isset($_POST['username']) ? $_POST['username'] : '';
		$user['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
		$user['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : '';
		$user['email'] = isset($_POST['email']) ? $_POST['email'] : '';
		$user['password'] = isset($_POST['password']) ? $_POST['password'] : '';
		$user['conf_password'] = isset($_POST['conf_password']) ? $_POST['conf_password'] : '';

		// var_dump($user);
		$result = insert_user($user);
		if ($result === true) {
			$_SESSION['message'] = 'User Created successfully';
			$new_id = mysqli_insert_id($db);
			redirect_to(url_for('/staff/admins/show.php?id=' . h(u($new_id))));
		} else {
			$errors = $result;
		}
	} else {

	}










 ?>

<?php include SHARED_PATH . '/staff_header.php'; ?>

<header>
	<h2>Create User</h2>
</header>

<?php echo display_errors($errors); ?>

<div><a href="<?php echo url_for('staff/admins/index.php'); ?>">&laquo; Back to list</a></div>

<div id="content">
	<form action="<?php echo url_for('staff/admins/new.php'); ?>" method="POST">
 	<dl>
 		<dt>Username:</dt>
 		<dd><input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username']: ''; ?>"></dd>
 	</dl>
 	<dl>
 		<dt>First Name:</dt>
 		<dd><input type="text" name="first_name" value="<?php echo isset($_POST['first_name']) ?$_POST['first_name'] : ''; ?>"></dd>
 	</dl>
 	<dl>
 		<dt>Last Name:</dt>
 		<dd><input type="text" name="last_name" value="<?php echo isset($_POST['last_name']) ? $_POST['last_name']: ''; ?>"></dd>
 	</dl>
 	<dl>
 		<dt>Email:</dt>
 		<dd><input type="email" name="email" value="<?php echo isset($_POST['email']) ?$_POST['email'] : ''; ?>"></dd>
 	</dl>
 	<dl>
 		<dt>Password:</dt>
 		<dd><input type="password" name="password"></dd>
 	</dl>
 	<dl>
 		<dt>Confirm password:</dt>
 		<dd><input type="password" name="conf_password"></dd>
 	</dl>
 	<dl>
 		<dd><input type="submit" name="submit" value="Create"></dd>
 	</dl>
 </form>

</div>

<?php include SHARED_PATH . '/staff_footer.php'; ?>