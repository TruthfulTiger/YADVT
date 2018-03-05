<?php
require_once 'User.php';
require_once 'Factory.php';
require_once 'db.inc.php';

use \DesignPatterns\FactoryPattern\Factory;

if(isset($_POST['register'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $rawpassword = $_POST['password'];
    $role = 'User';
    $username = $email;

    // Hash password
    $password = password_hash($rawpassword, PASSWORD_DEFAULT); // hash password to store in database

    // Create user with above credentials
    $user = Factory::CreateUser($username, $email, $password, $role);
    if($user) {
        header('Location: index.php?update=success');
    } else {
        header('Location: index.php?update=fail');
    }
}

// Moved into User class
/*    //insert operation
    $db = db::GetInstance();

    $sql = "insert into `user` (`username`, `password`, `email`) values (:username, :password, :email)";    //named parameters

    $query = $db -> dbc -> prepare($sql);

    $result = $query -> execute(array(":username" => $username, ":password" => $password, ":email" => $email));    //named parameters value

    if($result)
        header('Location: index.php');
    else
        echo "Failed to register user.";
}
else {
    echo "Sorry, there was a problem.";
}*/

