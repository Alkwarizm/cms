<?php 
require '../../../private/initialize.php';

require_login();
$page_title = 'GBI Edit Page';

include SHARED_PATH . '/staff_header.php';

// $menu_name = '';
// $position = '';
// $visible = '';

$id = $_GET['id'];
$page = find_page_by_id($id);

if (request_is_post()) {
	$page = [];
	$page['id'] = $id;
	$page['subject_id'] = isset($_POST['subject']) ? $_POST['subject'] : '';
	//htmlspecialchars not needed... only when outputing
	$page['menu_name'] = isset($_POST['menu_name']) ? ($_POST['menu_name']): ''; 
	$page['position'] = isset($_POST['position']) ? ($_POST['position']): '';
	$page['visible'] = isset($_POST['visible']) ? ($_POST['visible']): '';
	$page['content'] = isset($_POST['content']) ? ($_POST['content']): '';

	

	// echo $sql;
	//Update statements returns true/false
	$result = update_page($page);
	if ($result === true) {
		$_SESSION['message'] = 'Page successfully updated';
		redirect_to(url_for('/staff/pages/show.php?id='. $id));
	} else {
		$errors = $result;
	}
	
	
} elseif (!isset($_GET['id'])) {

	redirect_to(url_for('staff/pages/index.php'));

} else {
	
	


}

$subjects_set = find_all_subjects();
$pages_count = count_pages_by_subject_id($page['subject_id']);


 ?>


 <?php  ?>
 <header>
 	<h2>Edit Pages</h2>
 </header>
 <a href="<?php echo url_for('/staff/subjects/show.php?id='.h(u($page['subject_id']))); ?>">&laquo; Back to list</a>
 <p>Editing Page with ID: <?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']): ''; ?></p>
 <?php echo display_errors($errors); ?>
 <div id="content">
 	<form action="<?php echo url_for('/staff/pages/edit.php?id='. $id); ?>" method="post">
 		<dl>
 			<dt>Menu Name:</dt>
 			<dd><input type="text" name="menu_name" value="<?php echo $page['menu_name']; ?>"></dd>
 		</dl>
 		<dl>
 			<dt>Subject Name:</dt>
 			<dd><select name="subject">p
 				<?php 
 					while ($subject=mysqli_fetch_assoc($subjects_set)) {
 							echo "<option value=\"{$subject['id']}\" >" . $subject['menu_name'] . "</option>";
 						}	

 				 ?>
 			</select></dd>
 		</dl>
		<dl>
 			<dt>Position:</dt>
 			<dd><select name="position">
 				<?php 
 					for ($i=1; $i <= $pages_count ; $i++) { 
 							echo "<option value=\"{$i}\" ";
 							if ($page['position'] == $i) {
 								echo "selected=\"selected\" ";
 							}
 							echo ">" . $i . "</option>";
 						}	
 				 ?>
 			</select></dd>
 		</dl>
 		<dl>
 			<dt>Visible:</dt>
 			<dd><input type="hidden" name="visible" value="0"></dd>
 			<dd>
 				<?php 

 				echo "<input type=\"checkbox\" name=\"visible\" value=\"1\" ";
 				if ($page['visible'] == 1) {
 						echo "checked ";
 					}	
 				echo "/>";

 				 ?>

 			</dd>
 		</dl> 	
 		<dl>
 			<dt>Content</dt>
 			<dd>
 				<textarea name="content">
 					<?php echo $page['content']; ?>
 				</textarea>
 			</dd>
 		</dl>	
 		<dl>
 			<dd><input type="submit" name="edit" value="Save"></dd>
 		</dl>
 		<?php mysqli_free_result($subjects_set); ?>
 	</form>
 </div>

 <?php include SHARED_PATH . '/staff_footer.php'; ?>