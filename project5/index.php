<?php
require 'config.php';

//additional php code for this page goes here

?>

<?= template_header('Home') ?>
<?= template_nav() ?>
<?php
if (isset($_GET['type'])) {
  $_GET['type'] == 'success' ? (success($_GET['msg'])) : (danger($_GET['msg']));
}
?>
<!-- START PAGE CONTENT -->
<h1 class="title">Home Page</h1>
<p>This is where page content goes.</p>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>