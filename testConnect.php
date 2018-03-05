<?php

require_once 'db.inc.php';
use \Main\db;

require_once 'User.php';
use \DesignPatterns\FactoryPattern\User;


selectAll();


// Pull all data and print results

function selectAll() {
    $db = db::GetInstance();

    $sql = "    SELECT * FROM element";    //named parameters

    $query = $db -> dbc -> prepare($sql);

    $query -> execute();

    $query -> setFetchMode(PDO::FETCH_ASSOC); // [PDO::FETCH_NUM for integer key value]

    $result = $query -> fetchAll();

    foreach ($result as $record) {
        echo "Name: ".$record['DragonName']."Elements: ".$record['ElementName']."<br/>";
    }
}




