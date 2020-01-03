<?php require_once '../../../private/initialize.php'; ?>
<?php require_login(); ?>
<?php 
if (request_is_post()) {
	$id = $_GET['id'];
	$result = delete_user(h($id));
	if ($result == true) {
		$_SESSION['message'] = 'User Deleted successfully';
		redirect_to(url_for('/staff/admins/index.php'));
	}

}else {
	if(isset($_GET['id']) && $_GET['id'] != '') {
		$id = $_GET['id'];
		$result = find_user_by_id(h($id));
		$user = mysqli_fetch_assoc($result);
	}else {
		redirect_to(url_for('/staff/admins/index.php'));
	}
}




 ?>
<?php $page_title = 'GBI Admin | Delete'; ?>
<?php include SHARED_PATH . '/staff_header.php'; ?>

<header>
	<h2>Delete User</h2>
</header>
<div id="content">
	<a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to list</a>

	<div class="subject delete">
		<h1>Delete User</h1>
		<p>Are you sure you want to delete user?</p>
		<form action="<?php url_for('/staff/admins/delete.php?id='. h(u($user['id']))); ?>" method="post">
			<dl>
				<dd><?php echo h($user['username']); ?></dd>
			</dl>
			<dl>
				<dd><input type="submit" name="delete" value="Delete user"></dd>
			</dl>
		</form>
	</div>
</div>

<?php include SHARED_PATH . '/staff_footer.php'; ?>
