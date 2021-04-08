<?php

// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'W00392915';
$DATABASE_PASS = 'Christophercs!';
$DATABASE_NAME = 'W00392915';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
  //If there is an error with the connection, stop the script and dislpay the error.
  exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

function pdo_connect_mysql()
{
  // db connection constants
  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'W00392915';
  $DATABASE_PASS = 'Christophercs!';
  $DATABASE_NAME = 'W00392915';

  // db connection
  try {
    return new PDO(
      'mysql:host=' . $DATABASE_HOST . ';dbname=' .
        $DATABASE_NAME . ';charset=utf8',
      $DATABASE_USER,
      $DATABASE_PASS
    );


  } catch (PDOException $exctption) {
    die('Failed to connect to the database.');
  }
}


function template_header($title = "Page title")
{
  echo <<<EOT
 <!DOCTYPE html>
  <html>

    <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>$title</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
     <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
     <script defer src="js/bulma.js"></script>
    </head>

  <body>
EOT;
}

function template_nav()
{
  echo <<<EOT
  <!-- START NAV -->
    <nav class="navbar is-light">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item" href="index.php">
            <span class="icon is-large">
              <i class="fas fa-home"></i>
            </span>
            <span>Site title</span>
          </a>
          <div class="navbar-burger burger" data-target="navMenu">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <div id="navMenu" class="navbar-menu">
          <div class="navbar-start">
            <!-- navbar link go here -->
          </div>
          <div class="navbar-end">
            <div class="navbar-item">
              <div class="buttons">
                <a href="profile.php" class="button">
                  <span class="icon"><i class="fas fa-user"></i></span>
                  <span>Profile</span>
                </a>
                <a href="#" class="button">
                  <span class="icon"><i class="fas fa-address-book"></i></span>
                  <span>Button</span>
                </a>
                <a href="logout.php" class="button">
                  <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                  <span>Logout</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- END NAV -->

    <!-- START MAIN -->
    <section class="section">
        <div class="container">
EOT;
}

function admin_nav()
{
  echo <<<EOT
    <div class="column is-one-quarter">
        <aside class="menu">
            <p class="menu-label"> Admin menu </p>
            <ul class="menu-list">
                <li>
                    <a a href="admin.php" class="is-active">Admin</a>
                </li>
                <li>
                    <a a href="profile.php">Profile</a>
                </li>
                <li>
                    <a href="polls.php">Polls</a>
                <li>
                    <a a href="contacts.php">Contacts</a>
                </li>
            </ul>
        </aside>
    </div>
  EOT;
}

function template_footer()
{
  echo <<<EOT
        </div>
    </section>
    <!-- END MAIN-->

    <!-- START FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>Footer content goes here</p>
        </div>
    </footer>
    <!-- END FOOTER -->
    </body>
  </html>
EOT;
}

function success($message)
{
  echo <<<EOT
    <div class="notification is-success">
      <h2 class="title is-2">
  EOT;
  echo $message;
  echo <<<EOT
      </h2>
    </div>
EOT;
}

function danger($message)
{
  echo <<<EOT
    <div class="notification is-danger">
      <h2 class="title is-2">
  EOT;
  echo $message;
  echo <<<EOT
      </h2>
    </div>
EOT;
}

function redirect($location, $msg, $type)
{
  header('Location: ' . $location . '?msg=' . $msg . '&type=' . $type);
}
