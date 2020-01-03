
<?php require_once '../../../private/initialize.php'; ?>

<?php require_login(); 

	redirect_to(url_for('staff/index.php'));
?>

<?php $page_title = 'Pages'; ?>
<?php include SHARED_PATH . '/staff_header.php'; ?>
<?php 

	// $pages_set = find_all_pages();
	// confirm_query_result($pages_set);

	// $pages = [
	// 	['id' => 1, 'position' => 1, 'visible' => 1, 'name' => 'About Globe Bank'],
	// 	['id' => 2, 'position' => 2, 'visible' => 1, 'name' => 'Consumer'],
	// 	['id' => 3, 'position' => 3, 'visible' => 2, 'name' => 'Small Business'],
	// 	['id' => 4, 'position' => 4, 'visible' => 1, 'name' => 'Commercial']

	// ];
	// $sql = "SELECT * , pages.id AS pages_id, pages.menu_name AS pages_name, subjects.menu_name AS subjects_name FROM pages,subjects GROUP BY pages_id, subjects_name";
	$pages_set = find_all_pages();

	// $count = mysqli_num_rows($pages_set);
	// echo $count;
	// var_dump($data);
	// var_export($data);
	// while ($info = mysqli_fetch_assoc($data)) {
	// 	echo $info['pages_name'];
	// }
 ?>


<header>
	<h2>GBI Staff Area</h2>
</header>

<navigation>
	<ul>
		<li><a href="<?php echo url_for('/staff/index.php');?>">Menu</a></li>
	</ul>
</navigation>

<div id="content">
	<div class="actions">
		<a href="<?php echo url_for('staff/pages/new.php'); ?>">Create New Pages</a>
	</div>
	<table class="list">
		<tr>
			<th>ID</th>
			<th>Subject Name</th>
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
				<td><?php 
					$subject = find_subject_by_id($page['subject_id']);
					echo $subject['menu_name'];
				 ?></td>
				<td><?php echo h($page['position']); ?></td>
				<td><?php echo h($page['visible'] == 1 ? 'true' : 'false'); ?></td>
				<td><?php echo h($page['menu_name']); ?></td>
				<td><a href="show.php?id=<?php echo h(u($page['id'])); ?>">View</a></td>
				<td><a href="<?php echo url_for('staff/pages/edit.php?id='. h(u($page['id']))); ?>">Edit</a></td>
				<td><a href="<?php echo url_for('staff/pages/delete.php?id='. $page['id']); ?>">Delete</a></td>
			</tr>
		<?php endwhile; ?>	
	</table>
	<?php 
	mysqli_free_result($pages_set); 
	clear_session_message(); 
		?>
</div>

<?php include SHARED_PATH . '/staff_footer.php'; ?>
