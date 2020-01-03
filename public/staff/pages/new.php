<?php 
require '../../../private/initialize.php';

require_login(); 
$page_title = 'Create Page';

// $menu_name = '';
// $position = '';
// $visible = '';

if(request_is_post()){
	$page = [];
	$page['subject_id'] = isset($_POST['subject']) ? $_POST['subject'] : '';
	$page['menu_name'] = isset($_POST['menu_name']) ? $_POST['menu_name'] : '';
	$page['position'] = isset($_POST['position']) ? $_POST['position'] : '';
	$page['visible'] = isset($_POST['visible']) ? $_POST['visible'] : '';
	$page['content'] = isset($_POST['content']) ? $_POST['content'] : '';
	

	$result = insert_page($page);
	if ($result === true) {
		$new_id = mysqli_insert_id($db);
		$_SESSION['message'] = 'Page successfully created';
		redirect_to(url_for('/staff/pages/show.php?id='. $new_id));
	} else {
		$errors = $result;
	}
	
	

	// echo $sql;
	
}else {

	//display errors
	$page['subject_id'] = $_GET['id'] ?? '1';
	$page['menu_name'] = '';
	$page['position'] = '';
	$page['visible'] = '';
}

	
	$subjects_set = find_all_subjects();
	$pages_count = count_pages_by_subject_id($page['subject_id']) + 1;

 ?>

 <?php include SHARED_PATH . '/staff_header.php'; ?>

 <header>
 	<h2>Create New Page</h2>
 </header>
 <div><a href="<?php echo url_for('/staff/subjects/show.php?id='.h(u($page['subject_id']))); ?>">&laquo; Back to list</a></div>
<?php echo display_errors($errors); ?>
 
 <div id="content">
 	 <form class="list" action="<?php echo url_for('/staff/pages/new.php'); ?>" method="post">
 	 	<dl>
 	 		<dt>Menu Name:</dt>
 	 		<dd><input type="text" name="menu_name" value=""></dd>
 	 	</dl>
 	 	<dl>
 	 		<dt>Position:</dt>
 	 		<dd><select name="position">
 	 			<?php 
 	 				for ($i=1; $i<= $pages_count; $i++) { 
 	 					echo "<option value=\"{$i}\" ";
 	 					if ($page['position'] == $i) {
 	 						echo "selected=\"selected\"";
 	 					}
 	 					echo ">". $i . "</option>";
 	 				}

 	 			 ?>
 	 		</select></dd>
 	 	</dl>

 	 	<dl>
 	 		<dt>Subject:</dt>
 	 		<dd><select name="subject">
 	 			<?php 
 	 				while ($subject = mysqli_fetch_assoc($subjects_set)) {
 	 					echo "<option value=\"{$subject['id']}\">" . $subject['menu_name'] . "</option>";
 	 				}
 	 			 ?>
 	 		</select></dd>	 
 	 	</dl>

 	 	<dl>
 	 		<dt>Visible:</dt>
 	 		<dd><input type="hidden" name="visible" value="0"></dd>
 	 		<dd><input type="checkbox" name="visible" value="1"></dd>
 	 	</dl>
 	 	<dl>
 	 		<dt>Content:</dt>
 	 		<dd>
 	 			<textarea name="content">
 	 				
 	 			</textarea>
 	 		</dd>
 	 	</dl>
 	 	<dl>
 	 		<dd><input type="submit" name="create" value="Create"></dd>
 	 	</dl>
 	 </form>
 	 <?php mysqli_free_result($subjects_set); ?>
 </div>


<?php include SHARED_PATH . '/staff_footer.php'; ?>