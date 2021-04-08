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

// Connect to MySQL
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$poll) {
        die ('Poll does not exist with that ID'); // TODO: THIS NEEDS TO BE REDIRECT TO CONTACTS.PHP WITH A MESSAGE
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM polls WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $stmt = $pdo->prepare('DELETE FROM poll_answers WHERE poll_id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the poll.';
        } else {
            header('Location: polls.php');
            exit;
        }
    }
} else {
    die ('No ID Specified'); // TODO: THIS NEEDS TO BE REDIRECT TO CONTACTS.PHP WITH A MESSAGE
}

?>

<?= template_header('Delete Poll') ?>
<?= template_nav() ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Delete Poll</h1>
<?php if ($msg) : ?>
    <div class="notification is-success">
        <h2 class="title is-2">
            <?php echo $msg; ?>
        </h2>
    </div>
<?php endif; ?>

<h2 class="subtitle">Are you sure you want to delete poll number: <?= $poll['id'] ?></h2>
<a href="poll-delete.php?id=<?= $poll['id'] ?>&confirm=yes" class="button is-success">Yes</a>
<a href="poll-delete.php?id=<?= $poll['id'] ?>&confirm=no" class="button is-danger">No</a>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>