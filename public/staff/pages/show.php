<?php require_once '../../../private/initialize.php'; ?>

<?php require_login(); ?>
<?php $page_title = 'GBI Pages' ?>
<?php include SHARED_PATH . '/staff_header.php'; ?>
<?php 
	$id = $_GET['id'];
	$page = find_page_by_id($id);
	$subject = find_subject_by_id($page['subject_id']);
 ?>

<header>
	<h2>GBI Staff Area</h2>
</header>
<div class="actions">
	<a href="<?php echo url_for('staff/subjects/show.php?id='.h(u($subject['id']))); ?>">&laquo; Back to list</a>
</div>
<navigation>
	<ul>
		<li><a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
	</ul>
</navigation>
<div>
	<h3>Pages</h3>
</div>

<div id="content">
	<?php echo 'Page ID: ' . h($id); ?>
	<div class="attributes">
		<h2>Page: <?php echo h($page['menu_name']); ?></h2>
		<table>
			<dl>
				<dt>Menu name</dt>
				<dd><?php echo h($page['menu_name']); ?></dd>
			</dl>
			<dl>
				<dt>Subject name</dt>
				<dd><?php 
				echo h($subject['menu_name']);
				 ?></dd>
			</dl>
			<dl>
				<dt>Position</dt>
				<dd><?php echo h($page['position']); ?></dd>
			</dl>
			<dl>
				<dt>Visible</dt>
				<dd><?php echo $page['visible']==1 ? 'true':'false' ; ?></dd>
			</dl>
			<dl>
				<dt>Position</dt>
				<dd><?php echo h($page['content']); ?></dd>
			</dl>
			<dl>
				<dd><a href="<?php echo url_for('index.php?preview=true&id=' . h(u($id))); ?>" target="_blank"><button>Preview</button></a></dd>
			</dl>
		</table>
	</div>
</div>
<?php include SHARED_PATH . '/staff_footer.php'; ?>
<?php clear_session_message(); ?>