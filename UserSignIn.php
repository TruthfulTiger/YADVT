<?php

// This is now redundant code - has been left to show how I tried to do things before realising the whole user class
// needs to be observable, so why did I have two separate places for user-related things?
namespace DesignPatterns\ObserverPattern;
require_once "db.inc.php";
require_once 'ObjectProperties.php';

use \Main\db;
use \Main\ObjectProperties;

class UserSignIn extends ObjectProperties implements IObservable
{
    // Attributes
    private $_observers = [];
    private $_email;
    private $_timestamp;
    private $_result;
	private $_db;

    // Constructor
    public function __construct($email) {
        $this->_email = $email;
        $this->_timestamp = date('Y-m-d H:i:s');
		$this->_db = db::GetInstance();
    }

    // Properties

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return false|string
     */
    public function getTimestamp()
    {
        return $this->_timestamp;
    }

    // Methods

	public function LoginCheck() {
		$sql = "select * from `user` where `email` = ?";   //prepared statements

		$query = $this->_db -> dbc -> prepare($sql);

		$query -> execute(array($this->_email));   //prepared statements value

		$this->_result = $query -> fetch();
		// password_verify( $password, $hash ) - $hash contains retrieved password from db to compare against form input
    if ($this->_result && password_verify($_POST['password'], $this->_result['password']))
    {
        $sql = "update user set lastLogin = :ldate where email = :email";    //prepared statements

        $query = $this->_db->dbc->prepare($sql);
        $query->bindParam(':ldate', $this->_timestamp);
        $query->bindParam(':email', $this->_email);

        $query -> execute();   //prepared statements value

        $user = array($this->_result['userID'], $this->_result['email'], $this->_result['username'], $this->_result['role']);
        $_SESSION['user'] = $user;

        $this->Notify();
        echo "<script>location.assign('profile.php'); </script>";
    } else {
        echo "<script>location.assign('LoginForm.php?update=fail'); </script>";
    }
}

    public function Attach(IObserver $observer)
    {
        $this->_observers[] = $observer;
    }

    public function Detach(IObserver $observer)
    {
        $index = array_search($observer, $this->_observers, true);
        if($index !==false) {
            array_splice($this->_observers, $index, 1);
        }
    }

    public function Notify()
    {

        foreach ($this->_observers as $observer) {
				$observer->Update($this);
			}
    }
}