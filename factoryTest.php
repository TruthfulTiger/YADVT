<?php
require_once 'User.php';
require_once 'IUserFactory.php';
require_once 'Factory.php';


use \DesignPatterns\FactoryPattern\Factory;

// Used to test functions or for debugging

$user = Factory::CreateUser('joebloggs1', 'jbloggs@test.com', 'test123', 'User');
$user2 = Factory::CreateUser('fredbloggs1', 'fbloggs@test.com', 'test123', 'User');
$admin = Factory::CreateUser('admin1','admin@test.com', 'test456', 'Admin');

echo ('Name: '.$user->GetName().'; Email: '.$user->GetEmail().'; Password: '.$user->GetPWord().'; Role: '.$user->GetRole().'<br>');
echo ('Name: '.$user2->GetName().'; Email: '.$user2->GetEmail().'; Password: '.$user2->GetPWord().'; Role: '.$user2->GetRole().'<br>');

echo ('Name: '.$admin->GetName().'; Email: '.$admin->GetEmail().'; Password: '.$admin->GetPWord().'; Role: '.$admin->GetRole().'<br>');

