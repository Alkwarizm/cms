<?php require_once '../private/initialize.php'; ?>

<?php 
	
	$preview = false;
	// Previewing pages
	if (isset($_GET['preview'])) {
		$preview = $_GET['preview'] == 'true' && is_logged_in() ? true : false;
	}
	//preview page irrespective of it's visibility
	$visible = !$preview;

	//get page id to display
	//only display visible pages
	if (isset($_GET['id'])) {
		$page_id = $_GET['id'];
		$page = find_page_by_id($page_id, ['visible' => $visible]);

		if(!$page) {
			redirect_to(url_for('/index.php'));
		}
		//Highlight selected subject
		$subject_id = $page['subject_id'];

	} else {
		//show static page
	}
	// Displaying first page of selected subject
	//check if subject is visible
	if (isset($_GET['subject_id'])) {
		$subject_id = $_GET['subject_id'];
		$subject = find_subject_by_id($subject_id, ['visible' => $visible]);
		if (!$subject) {
			redirect_to(url_for('/index.php'));
		}

		$page_set = find_pages_by_subject_id($subject_id,['visible' => $visible]);
		$page = mysqli_fetch_assoc($page_set);
		mysqli_free_result($page_set);

		if (!$page) {
			redirect_to(url_for('/index.php'));
		}
		//fetch first page
		$page_id = $page['id'];

	}

	//Previewing pages
	// if (isset($_GET['preview']) && isset($_GET['id'])) {
	// 	$page_id = $_GET['id'];
	// 	$page = find_page_by_id($page_id);

	// }

 ?>

 <?php include SHARED_PATH . '/public_header.php'; ?>


<div id="main">
	<?php include SHARED_PATH . '/public_navigation.php'; ?>

	<div id="page">

		<?php 
			//page from navigation
			if (isset($page)) {
				// TODO put special chars escaping back in
				$allowed_tags = '<div><img><p><em><p><strong><br><ul><li><h1><h2>';
				echo strip_tags($page['content'], $allowed_tags);
			} else {
				//static page
				include SHARED_PATH . '/static_homepage.php';
			}

		 ?>
	</div>

</div>


<?php include SHARED_PATH . '/public_footer.php'; ?>