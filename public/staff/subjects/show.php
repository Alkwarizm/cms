<?php require_once '../../../private/initialize.php'; ?>

<?php require_login(); ?>
<?php
$id = $_GET['id'];
// $page = $_GET['page'];
$subject = find_subject_by_id($id);
$pages_set = find_pages_by_subject_id($id);
$page_title = 'GBI Subject';
// echo  'Showing subject with ID: ' .$id;
?>

<?php include SHARED_PATH . '/staff_header.php'; ?>
<header>
	<h2>GBI Staff Area</h2>
</header>

<div id="content">
	<a href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to list</a><br />
	<h2>Subject: <?php echo htmlspecialchars($subject['menu_name']); ?></h2>
	<div class="attributes">
		<dl>
			<dt>Menu Name</dt>
			<dd><?php echo htmlspecialchars($subject['menu_name']); ?></dd>
		</dl>
		<dl>
			<dt>Position</dt>
			<dd><?php echo htmlspecialchars($subject['position']); ?></dd>
		</dl>
		<dl>
			<dt>Visible</dt>
			<dd><?php echo htmlspecialchars($subject['visible'])==1 ? 'true':'false'; ?></dd>
		</dl>
	</div>
	<hr />
	<h3>Pages</h3>
	<div class="actions">
		<a href="<?php echo url_for('staff/pages/new.php?id='.h(u($subject['id']))); ?>">Create New Pages</a>
	</div>
	<table class="list">
		<tr>
			<th>ID</th>
			<th>Position</th>
			<th>Visible</th>
			<th>Page Name</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		<?php while($page = mysqli_fetch_assoc($pages_set)): ?>
			<tr>
				<td><?php echo h($page['id']); ?></td>
				<td><?php echo h($page['position']); ?></td>
				<td><?php echo h($page['visible'] == 1 ? 'true' : 'false'); ?></td>
				<td><?php echo h($page['menu_name']); ?></td>
				<td><a href="<?php echo url_for('/staff/pages/show.php?id='. h(u($page['id']))); ?>">View</a></td>
				<td><a href="<?php echo url_for('staff/pages/edit.php?id='. h(u($page['id']))); ?>">Edit</a></td>
				<td><a href="<?php echo url_for('staff/pages/delete.php?id='. $page['id']); ?>">Delete</a></td>
			</tr>
		<?php endwhile; ?>	
	</table>
	<?php 
	mysqli_free_result($pages_set); 
		?>
</div>

<?php include SHARED_PATH . '/staff_footer.php'; ?>
<?php clear_session_message(); ?>
