<?php

namespace DesignPatterns\FactoryPattern;

interface IUserFactory
{
    public static function CreateUser($username, $email, $password, $role);
}


?>