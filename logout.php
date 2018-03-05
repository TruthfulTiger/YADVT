<?php session_start();
require_once 'UserLog.php';
require_once 'UserSignIn.php';
require_once 'User.php';

use \DesignPatterns\ObserverPattern; // Tried to get this working with observer to detach listener - couldn't get it to work

// Delete certain session
session_unset();


// Delete all session variables
session_destroy();
echo "<script>location.assign('index.php'); </script>";


