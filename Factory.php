<?php

namespace DesignPatterns\FactoryPattern;

use DesignPatterns\ObserverPattern\IObservable;
use DesignPatterns\ObserverPattern\IObserver;

require_once 'IUserFactory.php';
require_once 'IObservable.php';
require_once 'User.php';


class Factory implements IUserFactory // Will use this for adding dragons, parks etc. but for now just creates and deletes users
{
    // Attributes

    // Constructor

    // Properties

    // Methods


    public static function CreateUser($username, $email, $password, $role)
    {
        $user = new User($username, $email, $password, $role);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setUsername($username);
        $user->setRole($role);

        $user->insertRecord();
        if ($user->getOutcome() == 'Success') {
            return $user;
        }
    }

    public static function DeleteUser($id) {
        $user = new User($id);
            unset($_SESSION['user']);
            session_destroy();
            $user->deleteRecord($id);
        if ($user->getOutcome() == 'Success') {
            echo "<script>location.assign('index.php'); </script>";
        } else {
            echo "Sorry, there was a problem.";
        }

    }

}
?>





