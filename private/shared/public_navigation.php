<?php 
	// $page_id = $page_id ?? ''; //PHP 7
	$page_id = isset($page_id) ? $page_id : '';
	$subject_id = $subject_id ?? '';
	$visible = $visible ?? 'true';


?>

<navigation>
	<?php $nav_subjects = find_all_subjects(['visible' => $visible]); ?>
	<ul class="subjects">
		<!-- Display Subjects -->
		<?php while ($subjects = mysqli_fetch_assoc($nav_subjects)): ?>
			<li class="<?php echo $subjects['id'] === $subject_id ? 'selected': ''; ?>">
				<!-- Display first page when subject is selected -->
				<a href="<?php echo url_for('/index.php?subject_id=' . h(u($subjects['id']))); ?>">
					<?php echo h($subjects['menu_name']); ?>
				</a>
				<!-- Display Pages for each Subject -->
				<?php if($subjects['id'] == $subject_id) { ?>
				<?php $nav_pages = find_pages_by_subject_id($subjects['id'], ['visible' => $visible]); ?>
				<ul class="pages">
					<?php while ($pages = mysqli_fetch_assoc($nav_pages)): ?>
					<li class="<?php if($pages['id'] == $page_id){ echo 'selected'; } ?>">
						<a href="<?php echo url_for('/index.php?id='. h(u($pages['id']))); ?>">
							<?php echo h($pages['menu_name']); ?>
						</a>
					</li>
					<?php endwhile; ?>
				</ul>
				<?php mysqli_free_result($nav_pages); } ?>
			</li>
		<?php endwhile; ?>	
	</ul>
	<?php mysqli_free_result($nav_subjects); ?>
</navigation>