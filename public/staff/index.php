<?php require_once '../../private/initialize.php'; ?><!-- Always!!(static) to prevent injection  -->
<?php $page_title = 'GBI Staff'; ?>
<?php require_login(); ?>

<?php include SHARED_PATH . '/staff_header.php'; ?>

  <header>
    GBI Staff Area
  </header>

  <navigation>
    <ul>
      <li>User: <?php echo $_SESSION['username'] ?? ''; ?></li>
      <li><a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
      <li><a href="<?php echo url_for('/staff/logout.php'); ?>">Logout</a></li>
    </ul>
  </navigation>

  <div id="content">
    <div id="main-menu">
      <h2>Main Menu</h2>
      <ul>
        <li><a href="<?php echo url_for('/staff/subjects/index.php'); ?>">Subjects</a></li>
        <li><a href="<?php echo url_for('/staff/admins/index.php'); ?>">Admin</a></li>
      </ul>
    </div>
  </div>


 <?php include SHARED_PATH .'/staff_footer.php'; ?>