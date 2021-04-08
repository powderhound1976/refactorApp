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

$msg = '';

// Connect to MySQL
$pdo = pdo_connect_mysql();

$stmt = $pdo->query('SELECT * FROM contacts GROUP BY id');

$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$type = isset($_GET['type']) ?: '';

?>

<?= template_header('Contacts') ?>
<?= template_nav() ?>
<?php
if (isset($_GET['type'])) {
    $_GET['type'] == 'success' ? (success($_GET['msg'])) : (danger($_GET['msg']));
}
?>

<!-- START PAGE CONTENT -->
<div class="columns">

    <!-- START LEFT NAV COLUMN-->
    <?= admin_nav() ?>
    <!-- END LEFT NAV COLUMN-->

    <!-- START RIGHT CONTENT COLUMN-->
    <div class="column column">
        <!-- START CONTACT PAGE CONTENT -->
        <h1 class="title">Contacts Page</h1>

        <a href="contact-create.php" class="button is-primary is-small">
            <span class="icon"><i class="fas fa-plus-square"></i></span>
            <span>Create a new contact</span>
        </a>
        <br><br>
        <div class="container">
            <table class="table is-hoveraeble is-bordered">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Phone</td>
                        <td>Title</td>
                        <td>Created</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact) : ?>
                        <tr>
                            <td>
                                <?= $contact['id'] ?>
                            </td>
                            <td>
                                <?= $contact['name'] ?>
                            </td>
                            <td>
                                <?= $contact['email'] ?>
                            </td>
                            <td>
                                <?= $contact['phone'] ?>
                            </td>
                            <td>
                                <?= $contact['title'] ?>
                            </td>
                            <td>
                                <?= $contact['created'] ?>
                            </td>
                            <td>
                                <a href="contact-update.php?id=<?= $contact['id'] ?>" class="button is-link is-small" title="Edit Contact">
                                    <span class="icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <a href="contact-delete.php?id=<?= $contact['id'] ?>" class="button is-danger is-small">
                                    <span class="icon"><i class="fas fa-trash-alt"></i></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- END CONTACT PAGE CONTENT -->

    </div>
    <!-- END RIGHT CONTENT COLUMN-->
</div>




<?= template_footer() ?>