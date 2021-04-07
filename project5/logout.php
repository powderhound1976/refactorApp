<?php
// logout script

session_start();
session_destroy();

// redirect to homepage.

header('Location: index.php');