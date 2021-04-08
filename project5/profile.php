<?php
require 'config.php';

$page = 'profile.php';
// We need to start sessions, so you should alwasys start sessions using the below code.
session_start();

// if not logged in redirect to login page
// PASSWORD PROTECTED
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// query the db for the profile details
// We don't have the password or email info stored in sessions so instead we can get the results from the DB

$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');

$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();

?>

<?= template_header('Profile') ?>
<?= template_nav() ?>
<?php
if (isset($_GET['type'])) {
    $_GET['type'] == 'success' ? (success($_GET['msg'])) : (danger($_GET['msg']));
}
?>
<!-- START PAGE CONTENT -->
<h1 class="title">Profile</h1>
<p>Your account details are below:</p>
<table class="table">
    <tr>
        <td>Username: </td>
        <td>
            <?= $_SESSION['name'] ?>
        </td>
    </tr>
    <tr>
        <td>Password: </td>
        <td><?= $password ?></td>
    </tr>
    <tr>
        <td>Email: </td>
        <td><?= $email ?></td>
    </tr>
</table>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>