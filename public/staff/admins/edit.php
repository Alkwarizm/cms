<?php require_once '../../../private/initialize.php'; ?>

<?php require_login(); ?>

<?php 

	$id = $_GET['id'];

	if (request_is_post()) {
		$user = [];
		$id = $_GET['id'];
		$user['id'] = $id;
		$user['username'] = isset($_POST['username'])? $_POST['username'] : '';
		$user['first_name'] = isset($_POST['first_name'])? $_POST['first_name'] : '';
		$user['last_name'] = isset($_POST['last_name'])? $_POST['last_name'] : '';
		$user['email'] = isset($_POST['email'])? $_POST['email'] : '';
		$user['password'] = isset($_POST['password'])? $_POST['password'] : ''; 
		$user['conf_password'] = isset($_POST['conf_password'])? $_POST['conf_password'] : ''; 
		$result = update_user($user);

		if ($result === true) {
			 $_SESSION['message'] = 'User Updated successfully';
			redirect_to(url_for('/staff/admins/show.php?id='. h(u($id))));
		} else {
			$errors = $result;
		}
	} else {
		if (!isset($_GET['id'])) {
			redirect_to(url_for('/staff/admins/index.php'));
		}else {
			$result = find_user_by_id($id);
			$user = mysqli_fetch_assoc($result);
		}
	}





 ?>

<?php $page_title = 'GBI Admin | Edit' ?>
<?php include SHARED_PATH . '/staff_header.php'; ?>

<header>
	<h2>Edit Users</h2>
</header>
<?php echo display_errors($errors); ?>
<div class="actions">
	<a href="<?php echo url_for('staff/admins/index.php') ?>">&laquo; Back to list</a>
</div>

<div id="content">
	<form action="<?php echo url_for('/staff/admins/edit.php?id='. h(u($user['id']))); ?>" method="post">
		<dl>
			<dt>User ID</dt>
			<dd><input type="text" name="id" disabled="" value="<?php echo h($user['id']); ?>"></dd>
		</dl>
 	<dl>
 		<dt>Username:</dt>
 		<dd><input type="text" name="username" value="<?php echo h($user['username']); ?>"></dd>
 	</dl>
 	<dl>
 		<dt>First Name:</dt>
 		<dd><input type="text" name="first_name" value="<?php echo h($user['first_name']); ?>"></dd>
 	</dl>
 	<dl>
 		<dt>Last Name:</dt>
 		<dd><input type="text" name="last_name" value="<?php echo h($user['last_name']); ?>"></dd>
 	</dl>
 	<dl>
 		<dt>Email:</dt>
 		<dd><input type="email" name="email" value="<?php echo h($user['email']); ?>"></dd>
 	</dl>
 	<dl>
 		<dt>Password:</dt>
 		<dd><input type="password" name="password" ></dd>
 	</dl>
 	<dl>
 		<dt>Confirm Password:</dt>
 		<dd><input type="password" name="conf_password"></dd>
 	</dl>
 	<dl>
 		<dd><input type="submit" name="submit" value="Edit"></dd>
 	</dl>
 </form>
</div>
<?php include SHARED_PATH . '/staff_footer.php'; ?>
