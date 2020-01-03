<?php require_once '../../../private/initialize.php'; ?>

<?php require_login(); ?>

<?php 
	$id = $_GET['id'];
	if (request_is_get()) {
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$id = $_GET['id'];
			$result = find_user_by_id($id);
			$user = mysqli_fetch_assoc($result);
		} else{
			redirect_to(url_for('/staff/admins/index.php'));
		}
		
	}

 ?>

<?php $page_title = 'GBI Staff Admin | User'; ?>
<?php include SHARED_PATH .  '/staff_header.php'; ?>

<header>
	<h2>GBI Staff Administrator</h2>
</header>
<div class="actions">
	<a href="<?php echo url_for('staff/admins/index.php') ?>">&laquo; Back to list</a>
</div>
<navigation>
	<ul>
		<li><a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
	</ul>
</navigation>

<div id="content">
	<h2>Username: <?php echo h($user['username']); ?></h2>
	<div class="attributes">
		<dl>
			<dt>First Name</dt>
			<dd><?php echo h($user['first_name']); ?></dd>
		</dl>
		<dl>
			<dt>Last Name:</dt>
			<dd><?php echo h($user['last_name']); ?></dd>
		</dl>
		<dl>
			<dt>Email</dt>
			<dd><?php echo h($user['email']); ?></dd>
		</dl>
		<dl>
			<dt>Hashed Password:</dt>
			<dd><?php echo h($user['hashed_password']) !== null ? 'true' : 'false'; ?></dd>
		</dl>
	</div>
</div>
<?php include SHARED_PATH . '/staff_footer.php'; ?>
<?php clear_session_message(); ?>
