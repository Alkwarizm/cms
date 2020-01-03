<?php require_once '../private/initialize.php'; ?>

<?php 
	if (request_is_post()) {
		$language = $_POST['language'] ?? 'Any';
		$expire = time() + 60*60*24*365;
		setcookie('language', $language, $expire);
	} else {
		$language = $_COOKIE['language'] ?? 'None';
	}

 ?>


 <?php include SHARED_PATH . '/public_header.php'; ?>

 <div id="main">
 	<?php include SHARED_PATH . '/public_navigation.php'; ?>

 	<div id="page">
 		
 		<div id="content">
 			<h1>Set Language Preferences</h1>
 			<p>The currently selected language is: <?php echo($language); ?></p>

 			<form action="<?php echo url_for('/language.php'); ?>" method="POST">
 				<select name="language">
 					<?php 
 						$language_choices = ['Any', 'English', 'Spanish', 'French', 'German'];
 						foreach ($language_choices as $language_choice) {
 							echo "<option value=\"{$language_choice}\" ";
 							if ($language == $language_choice) {
 								echo "selected=selected";
 							}
 							echo ">". $language_choice . "</option>";
 						}
 					 ?>
 				</select>
 				<br /><br />
 				<input type="submit" name="submit" value="Set Preferences">
 			</form>
 		</div>

 	</div>

 </div>

<?php include SHARED_PATH . '/public_footer.php'; ?>
 

