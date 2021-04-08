<?php
require 'config.php';

$page = 'activate.php';
//var_dump($_GET);

if (isset($_GET['email'], $_GET['code'])) {
  if ($stmt = $con->prepare('SELECT * FROM accounts WHERE email = ? AND activation_code = ?')) {
    $stmt->bind_param('ss', $_GET['email'], $_GET['code']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
      // Account exists with reqeuested email and code.
      if ($stmt = $con->prepare('UPDATE accounts SET activation_code = ? WHERE email = ? AND activation_code = ?')) {
        $newcode = 'activated';
        $stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
        $stmt->execute();
        $msg = 'Your account has been activated.';
        redirect('index.php', $msg, 'success');
      } else {
        $msg = 'The account is already activated or does not exist!';
        redirect('index.php', $msg, 'success');
      }
    }
  }
}
