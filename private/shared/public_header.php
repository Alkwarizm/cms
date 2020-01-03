<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Globe Bank <?php if(isset($page_title)){ echo '- ' . h($page_title); } ?><?php if(isset($preview) && $preview){ echo ' [PREVIEW] '; } ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo url_for('/css/public.css'); ?>">
</head>
<body>
	<header>
		<h1>
			<a href="<?php echo url_for('/index.php') ?>">
				<img src="<?php echo url_for('/images/gbi_logo.png'); ?>" width="298" height="71" alt="" />
			</a>
		</h1>
	</header>