<?php

namespace DesignPatterns\FactoryPattern;

interface IFactory
{
    public static function CreateUser($username, $email, $password);
}


?>