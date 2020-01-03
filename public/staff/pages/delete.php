<?php require_once '../../../private/initialize.php'; 

require_login();
$id = $_GET['id'];
$page = find_page_by_id($id);

// echo "You are viewing pageID: " . $id;

if (request_is_post()) {
	$page = [];
	$page['id'] = $id;
	$f_page = find_page_by_id($id);
	$result = delete_page($page['id']);
	$_SESSION['message'] = 'Page deleted';
	redirect_to(url_for('/staff/subjects/show.php?id='.h(u($f_page['subject_id']))));
	
} else {
	if (!isset($_GET['id'])) {
		redirect_to(url_for('/staff/subjects/show.php?id='.h(u($f_page['subject_id']))));
	}
}


 ?>

 <?php include SHARED_PATH . '/staff_header.php'; ?>

 <header>
 	<h2>GBI Staff Area</h2>
 </header>

 <div id="content">
 	<a href="<?php echo url_for('/staff/subjects/show.php?id='.h(u($f_page['subject_id']))); ?>">&laquo; Back to list</a>

 	<div class="page delete">
 		<h1>Delete Page</h1>
 		<p>Are you sure you want to delete page?</p>
 		<form action="<?php echo url_for('/staff/pages/delete.php?id='. $id); ?>" method="post">
 			<dl>
 				<dd><?php echo $page['menu_name']; ?></dd>
 			</dl>
 			<dl>
 				<dd><input type="submit" name="delete" value="Delete page"></dd>
 			</dl>
 		</form>
 	</div>
 </div>