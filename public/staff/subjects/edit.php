<?php 
require_once '../../../private/initialize.php';

// $test = $_GET['test'] ?? ''; //PHP > 7
// $test = isset($_GET['test']) ? $_GET['test'] : '' ;

// if ($test == '404') {
// 	error_404();
// }
// elseif ($test == '500') {
// 	error_500();
// }
// elseif ($test == 'redirect') {
// 	redirect_to(url_for('/staff/subjects/index.php'));
// }
// $menu_name = '';
// $position = '';
// $visible = '';
require_login(); 

$id = $_GET['id'];
// echo $id;

// $subject['id'] = $id;

if (request_is_post()) {
	$subject = [];
	$subject['menu_name'] = isset($_POST['menu_name']) ? $_POST['menu_name']: '';
	$subject['position'] = isset($_POST['position']) ? $_POST['position']: '';
	$subject['visible'] = isset($_POST['visible']) ? $_POST['visible']: '';
	$subject['id'] = $id;

	//Update statements return true / false
	$result = update_subject($subject);
	if ($result === true) {
		$_SESSION['message'] = 'Update Successful';
		redirect_to(url_for('/staff/subjects/show.php?id=' . $subject['id']));
	} else {
		$errors = $result;
		//var_dump($errors);
	}
	
	// echo "Form parameters" . "<br>";
	// echo "Menu Name: " . $menu_name . "<br>";
	// echo "Position: " . $position . "<br>";
	// echo "Visible: " . $visible . "<br>";



}else{
	// redirect_to(url_for('staff/subjects/new.php'));
	if (!isset($_GET['id'])) {
		redirect_to(url_for('staff/subjects/index.php'));
	} else {
		//display errors
		$subject = find_subject_by_id($id);
	}

}


$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set);
		// echo $subject_count;
mysqli_free_result($subject_set);
		// echo $id;

 ?>
 <?php $page_title = 'GBI Edit Subjects'; ?>
 <?php include SHARED_PATH . '/staff_header.php'; ?>
<header>
	<h2>Edit Subjects</h2>
</header>
 <div><a href="<?php echo url_for('staff/subjects/index.php'); ?>">&laquo; Back to list</a></div>
 <?php echo display_errors($errors); ?>
<div id="content">
	<form action="<?php echo url_for('/staff/subjects/edit.php?id='. h(u($id))); ?>" method="POST">
		<dl>
			<dt>Subject ID</dt>
			<dd><input type="text" name="id" disabled="" value="<?php echo $subject['id']; ?>"></dd>
		</dl>
 	<dl>
 		<dt>Menu Name:</dt>
 		<dd><input type="text" name="menu_name" value="<?php echo $subject['menu_name']; ?>"></dd>
 	</dl>
 	<dl>
 		<dt>Position:</dt>
 		<dd><select name="position">
 			<?php 
 				for($i=1; $i<=$subject_count; $i++){
 					echo "<option value=\"{$i}\" ";
 					if ($subject['position'] == $i) {
 						echo "selected";
 					}
 					echo " >" . $i . "</option>";
 				}

 			 ?>
 		</select></dd>
 	</dl>
 	<dl>
 		<dt>Visible:</dt>
 		<dd><input type="hidden" name="visible" value="0"></dd>
 			<dd><input type="checkbox" name="visible" value="1"<?php echo ($subject['visible'] == '1') ? "checked": ''; ?>></dd>
 	</dl>
 	<dl>
 		<dd><input type="submit" name="submit" value="Edit"></dd>
 	</dl>
 </form>
</div>
 

<?php include SHARED_PATH . '/staff_footer.php'; ?>