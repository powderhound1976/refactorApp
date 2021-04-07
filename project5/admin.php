<?php
require 'config.php';

//additional php code for this page goes here

?>

<?= template_header('Home') ?>
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
        <h1 class="title"> Page Title Goes Here </h1>
        <p> This is where page content goes. </p>
    </div>
    <!-- END RIGHT CONTENT COLUMN-->
</div>


<?= template_footer() ?>