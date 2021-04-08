<?php
require 'config.php';

$page = 'register.php';

if (isset($_POST['username'], $_POST['password'], $_POST['email'])) {
  if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      // Username exists
      redirect('register.php', 'Username exists, please choose another!', 'danger');
    } else {
      //Username doesn't exits, insert new account
      if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {
        //We don't want to expose passwords in out database, so hash the password and use password_verify when a user logs in
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $uniqid = uniqid();
        $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
        $stmt->execute();
        //send confirmation email

        $from = 'christopherreynolds@mail.weber.edu';
        $subject = 'Account activation required';
        $header = 'From' . $from . "\r\n" . 'Reply-To: ' . $from
          . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n"
          . 'MIME-VERSION: 1.0' . "\r\n"
          . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        $activate_link = 'http://icarus.cs.weber.edu/~cr92915/web3400/project5/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
        $message = '<p>Please click the following link to activate your account: <a ref="' . $activate_link . '">' . $activate_link . '</a></p>';
        echo "<a href='$activate_link'>$activate_link<a/>";
      } else {
        //Something is wrong with the sql statemnt, check to make sure accounts table exists with all 3 fields
        redirect('register.php', 'Could not prepare statement!', 'danger');
      }
    }
    $stmt->close();
  } else {
    redirect('register.php', 'Could not prepare statement!', 'danger');
  }
  $con->close();
}

?>

<?= template_header('Register') ?>
<?= template_nav() ?>

<!-- START PAGE CONTENT -->

<?php
$response = '';

if (isset($_POST['email'], $_POST['name'], $_POST['subject'], $_POST['msg'])) {
  var_dump($_POST);
  // send email
  $to = 'renies@gmail.com';
  $from = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['msg'];
  $headers = 'From: ' . $_POST['email'] . "\r\n" . 'Reply-To: ' . $_POST['email'] . "\r\n" . 'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $message, $headers);

  // update response
  $response = 'Message Sent!';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  <script src="js/bulma.js"></script>
  <title>Register</title>
</head>

<body>
  <section class="section">
    <div class="container">
      <?php
      if (isset($_GET['type'])) {
        $_GET['type'] == 'success' ? (success($_GET['msg'])) : (danger($_GET['msg']));
      }
      ?>
      <h1 class="title">
        Register Your Account
      </h1>
      <?php if ($response) : ?>
        <div class="notification is-success">
          <h2 class="title is-2">
            <?php echo $response; ?>
          </h2>
        </div>
      <?php endif; ?>

      <form action="" method="post">
        <div class="field">
          <label class="label">Email</label>
          <div class="control has-icons-left">
            <input name='email' class="input" type="email" placeholder="Enter your email" value="">
            <span class="icon is-small is-left">
              <i class="fas fa-envelope"></i>
            </span>
          </div>
        </div>
        <div class="field">
          <label class="label">Username</label>
          <div class="control has-icons-left">
            <input name="username" class="input" type="text" placeholder="Enter Username">
            <span class="icon is-small is-left">
              <i class="fas fa-user"></i>
            </span>
          </div>
        </div>

        <div class="field">
          <label class="label">Password</label>
          <div class="control">
            <input name="password" class="input" type="password" placeholder="Enter Password">
          </div>
        </div>

        <div class="field">
          <div class="control">
            <button class="button is-link">
              <span class="icon">
                <i class="fas fa-paper-plane"></i>
              </span>
              <span>Submit Registration </span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>
</body>

</html>
<!-- END PAGE CONTENT -->

<?= template_footer() ?>