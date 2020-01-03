<?php require_once '../../../private/initialize.php'; 

//Need a subject to delete

require_login(); 

$id = $_GET['id'];

if (request_is_post()) {

	// echo $id;
	$result = delete_subject($id);
	// 
	$_SESSION['message'] = 'Subject deleted';
	redirect_to(url_for('staff/subjects/index.php'));

} else {

	if (!isset($_GET['id'])) {
		redirect_to(url_for('staff/subjects/index.php'));
	}

	$subject = find_subject_by_id($id);
}


?>

<?php 
	$page_title = 'Delete Subject';
	include SHARED_PATH . '/staff_header.php';
?>
<header>
	<h2>GBI Staff Area</h2>
</header>

<div id="content">
	<a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to list</a>

	<div class="subject delete">
		<h1>Delete Subject</h1>
		<p>Are you sure you want to delete subject?</p>
		<form action="<?php url_for('/staff/subjects/delete.php?id=' . $id); ?>" method="post">
			<dl>
				<dd><?php echo h($subject['menu_name']); ?></dd>
			</dl>
			<dl>
				<dd><input type="submit" name="delete" value="Delete subject"></dd>
			</dl>
		</form>
	</div>
</div>

<?php include SHARED_PATH . '/staff_footer.php'; ?>