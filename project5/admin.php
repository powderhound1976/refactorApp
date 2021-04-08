<?php
require 'config.php';

// Additional php code for this page goes here

// We need to start sessions, so you should alwasys start sessions using the below code.
session_start();

// if not logged in redirect to login page
// PASSWORD PROTECTED
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

?>

<?= template_header('Admin Panel') ?>
<?= template_nav() ?>

<!-- START PAGE CONTENT -->
<div class="columns">

    <!-- START LEFT NAV COLUMN-->
    <?= admin_nav() ?>
    <!-- END LEFT NAV COLUMN-->

    <!-- START RIGHT CONTENT COLUMN-->
    <div class="column column">
        <?php
        if (isset($_GET['type'])) {
            $_GET['type'] == 'success' ? (success($_GET['msg'])) : (danger($_GET['msg']));
        }
        ?>
        <h1 class="title">Admin Panel</h1>
        <p> This is where page content goes. </p>
    </div>
    <!-- END RIGHT CONTENT COLUMN-->
</div>


<?= template_footer() ?>