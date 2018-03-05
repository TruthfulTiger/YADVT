<?php

// Reference: PDO CONNECTION CLASS IN PHP [OOP APPROACH WITH SINGLETON PATTERN]
// https://acomputerengineer.wordpress.com/2013/06/16/pdo-connection-class-in-php-oop-approach-with-singleton-pattern/
namespace Main;
use \PDO;

class db
{
    // Attributes
    private static $_instance;

    // Data associated with this singleton
    public $dbc; // Database connection - public for use across app

    // Constructor
    private function __construct() {
        $this->dbc = null;

        try{
            $this->dbc = new PDO('mysql:host=localhost;dbname=advweb1', "advweb1", "0HulBWOBZcVTdTG5", [PDO::ATTR_PERSISTENT => true]);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->dbc;
    }
    // Properties
    public static function GetInstance() {
        // Lazy load singleton
        if (empty(self::$_instance)) { // Have we created it?
            self::$_instance = new db();
        }
        return self::$_instance;
    }


    // Methods

    // Sanitises user input before processing data
    public static function TestInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
}

?>