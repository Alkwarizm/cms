<?php 
	if (!isset($page_title)) {
		$page_title = 'Staff Area';
	}
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo $page_title; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale-1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="<?php echo url_for('/css/staff.css'); ?>">
</head>
<body>
	<?php 
			echo display_session_message();
	 ?>
	