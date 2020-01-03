<?php require_once '../../../private/initialize.php'; ?>

<?php require_login(); ?>

<?php 
	$users = [];
	$users = find_all_users();





 ?>

<?php $page_title = 'GBI Staff Admin'; ?>
<?php include SHARED_PATH .  '/staff_header.php'; ?>

<header>
	<h2>GBI Staff Administrator</h2>
</header>

<navigation>
	<ul>
		<li><a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
	</ul>
</navigation>

<div id="content">
	<div class="actions">
		<a href="<?php echo url_for('staff/admins/new.php'); ?>">Create New User</a>
	</div>
	<table class="list">
		<tr>
			<th>ID</th>
			<th>Userame</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		<?php while($user = mysqli_fetch_assoc($users)): ?>
			<tr>
				<td><?php echo h($user['id']); ?></td>
				<td><?php echo h($user['username']); ?></td>
				<td><?php echo h($user['first_name']); ?></td>
				<td><?php echo h($user['last_name']); ?></td>
				<td><?php echo h($user['email']); ?></td>
				<td><a href="show.php?id=<?php echo h(u($user['id'])); ?>">View</a></td>
				<td><a href="<?php echo url_for('staff/admins/edit.php?id='. h(u($user['id']))); ?>">Edit</a></td>
				<td><a href="<?php echo url_for('staff/admins/delete.php?id='. h(u($user['id']))); ?>">Delete</a></td>
			</tr>
		<?php endwhile;  ?>	
		<?php mysqli_free_result($users); ?>
	</table>
	
</div>
<?php include SHARED_PATH . '/staff_footer.php'; ?>
<?php clear_session_message(); ?>