<?php
require 'config.php';
$page = 'login.php';
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
<h1 class="title">Login</h1>
<form action="authenticate.php" method="post">
  <div class="field">
    <p class="control has-icons-left">
      <input name="username" class="input" type="text" placeholder="Username" required>
      <span class="icon is-small is-left">
        <i class="fas fa-user"></i>
      </span>
    </p>
  </div>
  <div class="field">
    <p class="control has-icons-left">
      <input name="password" class="input" type="password" placeholder="Password" required>
      <span class="icon is-small is-left">
        <i class="fas fa-lock"></i>
      </span>
    </p>
  </div>
  <div class="field">
    <p class="control">
      <button class="button is-success">
        Login
      </button>
    </p>
  </div>
</form>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>