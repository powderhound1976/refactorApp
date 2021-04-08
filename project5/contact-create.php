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

$page = 'contact-create.php';
$pdo = pdo_connect_mysql();

$msg = "";

if (!empty($_POST)) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

    $stmt = $pdo->prepare('INSERT INTO contacts VALUES (NULL,?,?,?,?,?)');
    $stmt->execute([$name, $email, $phone, $title, $created]);
    $msg = 'Created successfully!';
    redirect('contacts.php', $msg, 'success');
}

?>

<?= template_header('Create Contact') ?>
<?= template_nav() ?>

<!-- START PAGE CONTENT -->
<h1 class="title">New Contact</h1>
<?php if ($msg) : ?>
    <div class="notification is-success">
        <h2 class="title is-2">
            <?php echo $msg; ?>
        </h2>
    </div>
<?php endif; ?>
<form action="" method="post">
    <div class="field">
        <label for="" class="label">
            Name
        </label>
        <div class="control has-icons-left">
            <input type="text" name="name" class="input" placeholder="Name"><span class="icon is-small is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label for="" class="label">
            Email
        </label>
        <div class="control has-icons-left">
            <input type="text" name="email" class="input" placeholder="Email"><span class="icon is-small is-left">
                <i class="fas fa-envelope"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label for="" class="label">
            Phone
        </label>
        <div class="control has-icons-left">
            <input type="text" name="phone" class="input" placeholder="Phone Number"><span class="icon is-small is-left">
                <i class="fas fa-phone"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <label for="" class="label">
            Job Title
        </label>
        <div class="control has-icons-left">
            <input type="text" name="title" class="input" placeholder="Job Title"><span class="icon is-small is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
    </div>
    <div class="field">
        <div class="control">
            <button class="button is-link">Submit</button>
        </div>
    </div>
</form>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>