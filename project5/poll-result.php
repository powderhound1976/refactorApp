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

$page = 'poll-request.php';
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    // MySQL query that selects the poll records by the GET request "id"
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    // Fetch record
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the poll record exists with the id specified
    if ($poll) {
        // MySQL Query that selects all the poll answers
        $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ? ORDER BY votes DESC');
        $stmt->execute([$_GET['id']]);
        // Fetch the answers
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Total number of votes, will be used to calculate the percentage
        $total_votes = 0;

        foreach ($poll_answers as $poll_answer) {
            // Every poll answer votes will be added to total votes
            $total_votes += $poll_answer['votes'];
        }
    } else {
        redirect('polls.php', 'The poll with that id does not exist.', 'danger');
    } 
} else {
    redirect('polls.php', 'No poll ID specified.', 'danger');
}

?>

<?= template_header('Poll Results') ?>
<?= template_nav() ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Poll Results</h1>
<h2 class="subitle"><?= $poll['title'] ?> (Total Votes: <?= $total_votes ?></h2>

<div class="container">
    <?php foreach ($poll_answers as $poll_answer) : ?>
        <p><?= $poll_answer['title'] ?> (<?= $poll_answer['votes'] ?> Votes)</p>
        <progress class="progress is-primary is-large" 
        value="<?= @round(($poll_answer['votes'] / $total_votes) * 100) ?>" 
        max="<?= $total_votes ?>"></progress>
    <?php endforeach ?>
</div>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>