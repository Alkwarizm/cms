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
require_login();

if (request_is_post()) {

	$subject = [];
	$subject['menu_name'] = isset($_POST['menu_name']) ? $_POST['menu_name']: '';
	$subject['position'] = isset($_POST['position']) ? $_POST['position']: '';
	$subject['visible'] = isset($_POST['visible']) ? $_POST['visible']: '';

	// echo "Form parameters" . "<br>";
	// echo "Menu Name: " . $menu_name . "<br>";
	// echo "Position: " . $position . "<br>";
	// echo "Visible: " . $visible . "<br>";
	$result = insert_subject($subject);
	// echo $result;
	if ($result === true) {
		$new_id = mysqli_insert_id($db);
		$_SESSION['message'] = 'Subject created successfully';
		redirect_to(url_for('/staff/subjects/show.php?id='. $new_id));
	}else{
		$errors = $result;
	}
	

}else{
	//display blank form 
}

$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set) + 1;
mysqli_free_result($subject_set);
$subject['position'] = $subject_count;


 ?>
 <?php $page_title = 'GBI Create Subjects'; ?>
 <?php include SHARED_PATH . '/staff_header.php'; ?>
<header>
	<h2>Create New Subjects</h2>
</header> 
 <div><a href="<?php echo url_for('staff/subjects/index.php'); ?>">&laquo; Back to list</a></div>

 <?php echo display_errors($errors); ?>

<div id="content">
	<form action="<?php echo url_for('staff/subjects/new.php'); ?>" method="POST">
 	<dl>
 		<dt>Menu Name:</dt>
 		<dd><input type="text" name="menu_name"></dd>
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
 		<dd><input type="checkbox" name="visible" value="1"></dd>
 	</dl>
 	<dl>
 		<dd><input type="submit" name="submit" value="Create"></dd>
 	</dl>
 </form>

</div>
 
<?php include SHARED_PATH . '/staff_footer.php'; ?>