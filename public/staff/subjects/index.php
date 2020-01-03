<?php require_once '../../../private/initialize.php'; ?><!-- Always!!(static) to prevent injection  -->
<?php require_login(); ?>
<?php 

	$subject_set = find_all_subjects();
	// confirm_query_result($subject_set);


 ?>

<?php $page_title = 'Subjects'; ?>
<?php include SHARED_PATH . '/staff_header.php'; ?>

<header>
    <h2>GBI Staff Area</h2>
</header>

<navigation>
    <ul>
      <li><a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
    </ul>
</navigation>

<div class="actions"><a href="<?php echo url_for('staff/subjects/new.php'); ?>">Create New Subjects</a></div>

<!--display status msg -->

<div id="content">
	<table class="list">
		<tr>
			<th>ID</th>
			<th>Position</th>
			<th>Visible</th>
			<th>Name</th>
			<th>Pages</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		<?php while ($subject = mysqli_fetch_assoc($subject_set)): ?>
			<?php $pages_count = count_pages_by_subject_id($subject['id']); ?>
		<tr>
			<td><?php echo h($subject['id']); ?></td>
			<td><?php echo h($subject['position']); ?></td>
			<td><?php echo h($subject['visible'] == 1 ? 'true' : 'false'); ?></td>
			<td><?php echo h($subject['menu_name']); ?></td>
			<td><?php echo h($pages_count); ?></td>
			<td><a href="show.php?id=<?php echo $subject['id']; ?>">View</a></td>
			<td><a href="<?php echo url_for('/staff/subjects/edit.php?id=' . htmlspecialchars(urlencode($subject['id']))); ?>">Edit</a></td>
			<td><a href="<?php echo url_for('/staff/subjects/delete.php?id='. h(u($subject['id']))); ?>">Delete</a></td>
		</tr>
	<?php endwhile; ?>
	</table>	
	<?php 
		// Release memory
		mysqli_free_result($subject_set);
		clear_session_message(); 
		
	 ?>
</div>

 <?php include SHARED_PATH .'/staff_footer.php'; ?>