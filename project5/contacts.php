<?php
require 'config.php';

// Connect to MySQL
$pdo = pdo_connect_mysql();

$stmt = $pdo->query('SELECT * FROM contacts GROUP BY id');

$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Contacts') ?>
<?= template_nav() ?>

<!-- START PAGE CONTENT -->
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
<!-- END PAGE CONTENT -->

<?= template_footer() ?>