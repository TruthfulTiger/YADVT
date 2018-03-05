<?php session_start();
require_once 'UserLog.php';
require_once 'UserSignIn.php';

use \DesignPatterns\ObserverPattern;
use \DesignPatterns\FactoryPattern\User;

if(isset($_POST['login'])){
    if(!empty($_POST['hptrap'])) { // Check if honeypot is empty - if not, it's a spambot, treat accordingly
        echo "Nice try, Spam-A-Lot :P";
    } else {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        $sessionlog = new User($email);
        $sessionlog->setEmail($email);
      //  $sessionlog = new ObserverPattern\UserSignIn($email);

        $listener = new ObserverPattern\UserLog();

        $sessionlog->Attach($listener);
        $sessionlog->LoginCheck();

    }



    // Old code that's now been moved to UserSignin.php

/*     $db = db::GetInstance();

    $sql = "select * from `user` where `email` = ?";   //prepared statements

    $query = $db -> dbc -> prepare($sql);

    $query -> execute(array($email));   //prepared statements value

    $user = $query -> fetch();


    // password_verify( $password, $hash ) - $hash contains retrieved password from db to compare against form input
    if ($user && password_verify($_POST['password'], $user['password']))
    {
        echo "valid!";

        $_SESSION['user'] = ($user['username']);
        $sessionlog->LastLogin();

        // Update last login time
        $sql = "update `user` set `lastLogin` = ? where `email` = ?";    //prepared statements

        $query = $db -> dbc -> prepare($sql);

        $result = $query -> execute(array($lastLogin, $email));   //prepared statements value

        echo "Last login: ".$lastLogin;

    } else {
        echo "invalid";
    }
    header('Location: index.php');

} else {
    echo "Sorry, there was a problem.";*/
} 

