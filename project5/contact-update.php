<?php
require 'config.php';

// Connect to MySQL
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    // Get the contact from the DB
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        $msg = 'Something went wrong! Contact doesn\'t exist with that id.';
        redirect('contacts.php', $msg, 'danger');
    }

    if (!empty($_POST)) {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

        $stmt = $pdo->prepare('UPDATE contacts SET id = ?, name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
        $stmt->execute([$_GET['id'], $name, $email, $phone, $title, $created, $_GET['id']]);
        $msg = 'Updated successfully!';
        redirect('contacts.php', $msg, 'success');
    }
} else {
    $msg = 'Something went wrong! No ID was specified.';
    redirect('contacts.php', $msg, 'danger');
}

?>

<?= template_header('Contact Update') ?>
<?= template_nav() ?>

<!-- START PAGE CONTENT -->
<h1 class="title">Contact Update</h1>

<form action="contact-update.php?id=<?= $contact['id'] ?>" method="post" class="">
    <div class="field">
        <label for="" class="label">Name</label>
        <div class="control">
            <input type="text" name="name" class="input" value="<?= $contact['name'] ?>" required>
        </div>
    </div>
    <div class="field">
        <label for="" class="label">Email</label>
        <div class="control">
            <input type="text" name="email" class="input" value="<?= $contact['email'] ?>" required>
        </div>
    </div>
    <div class="field">
        <label for="" class="label">Phone</label>
        <div class="control">
            <input type="text" name="phone" class="input" value="<?= $contact['phone'] ?>" required>
        </div>
    </div>
    <div class="field">
        <label for="" class="label">Title</label>
        <div class="control">
            <input type="text" name="title" class="input" value="<?= $contact['title'] ?>" required>
        </div>
    </div>
    <div class="field">
        <div class="control">
            <input type="submit" class="button" value="Update">
        </div>
    </div>
</form>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>