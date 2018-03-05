<?php

namespace DesignPatterns\FactoryPattern;

require_once 'ObjectProperties.php';
require_once 'ICRUD.php';
require_once 'UserLog.php';
require_once 'IObservable.php';
require_once 'db.inc.php';

use DesignPatterns\ObserverPattern\IObservable;
use DesignPatterns\ObserverPattern\IObserver;
use DesignPatterns\ObserverPattern\UserLog;
use \Main\ObjectProperties;
use \Main\db;

class User extends ObjectProperties implements ICRUD, IObservable // Handles user responsibilities. Could probably be broken down into more manageable pieces
{
    // Attributes
    private $_observers = [];
    private $_id;
    private $_username;
    private $_email;
    private $_password;
    private $_role;
    private $_image;
    private $_firstName;
    private $_lastName;
    private $_GCID;
    private $_location;
    private $_created;
    private $_lastLogin;
    private $_modified;
    private $_outcome;
    private $_result;
    private $_time;
    private $_action;
    private $_log;

    // Constructor
    public function __construct($username = '', $email = '', $password = '', $role = '') {
        $this->_username = $username;
        $this->_email = $email;
        $this->_password = $password;
        $this->_role = $role;
        $this->_created = date('Y-m-d H:i:s');
        $this->_lastLogin= date('Y-m-d H:i:s');
        $this->_modified = date('Y-m-d H:i:s');
        $this->_outcome = null; // Used for setting success or fail messages
        $this->_time = date('Y-m-d H:i:s');
        $this->_log = new UserLog();
    }

    // Properties

    /**
     * @return mixed
     */
    public function getOutcome()
    {
        return $this->_outcome;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->_username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->_password;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->_email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->_role;
    }

    /**
     * @return mixed
     */
    public function getGCID()
    {
        return $this->_GCID;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->_location;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->_created;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->_lastLogin;
    }

    /**
     * @return mixed
     */
    public function getModified()
    {
        return $this->_modified;
    }


    /**

     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->_firstName = $firstName;
    }


    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @param mixed $image
     */
    public function setImage(string $image)
    {
        $this->_image = $image;
    }

    /**
     * @param mixed $GCID
     */
    public function setGCID(string $GCID)
    {
        $this->_GCID = $GCID;
    }

    /**
     * @param mixed $location
     */
    public function setLocation(string $location)
    {
        $this->_location = $location;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->_username = $username;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role)
    {
        $this->_role = $role;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->_lastName = $lastName;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->_password = $password;
    }

    /**
     * @param mixed $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->_lastLogin = $lastLogin;
    }

    /**
     * @param mixed $modified
     */
    public function setModified($modified)
    {
        $this->_modified = $modified;
    }


    // Methods - Reference: PHP hacks by Jack D. Herrington

    public function load($id) {
        $db = db::GetInstance();
        $data = array();

        $sql = "select * from user WHERE userID = ?";    //named parameters

        $query = $db->dbc->prepare($sql);

        $query->execute(array($id));

        $result = $query->fetchAll();

        foreach ($result as $data) {
            $this->_id = $data['userID'];
            $this->_email = $data['email'];
            $this->_username = $data['username'];
            $this->_role = $data['role'];
            $this->_password = $data['password'];
            $this->_firstName = $data['firstName'];
            $this->_lastName = $data['lastName'];
            $this->_image = $data['image'];
            $this->_GCID = $data['GCID'];
            $this->_location = $data['location'];
            $this->_lastLogin = $data['lastLogin'];
            $this->_created = $data['created'];
            $this->_modified = $data['modified'];
       //     $this->_timezone = $data['timezone'];
        }
        return $data;
        $this->_log->setEmail($this->_email);
        $this->_action = $this->_log->setAction("Loaded user data.");
        $this->Notify();
    }

    public function insertRecord()
    {
        $this->clearOutcome();
        $db = db::GetInstance();

        $sql = 'insert into `user` (`username`, `password`, `email`) values (?, ?, ?)';

        $query = $db -> dbc -> prepare($sql);

        $query -> execute(array($this->_username, $this->_password, $this->_email));    //named parameters value
        $this->_log->setEmail($this->_email);
        $this->_action = $this->_log->setAction("User record created.");
        $this->Notify();

        if($query) {
            $this->_outcome = 'Success';
        }
        else {
            $this->_outcome = 'Fail';
        }
    }

    public function clearOutcome() {
        $this->_outcome = null;
    }

    public function updateRecord($id)
    {
        $this->clearOutcome();
        $db = db::GetInstance();

        $sql = "update `user` SET `password` = :password, `role` = :role, `image` = :image, `username` = :username, `firstName` = :firstName, `lastName` = :lastName, `GCID` = :GCID, `location` = :location, `modified` = :modified where userID = :id";    //prepared statements

        $query = $db->dbc->prepare($sql);

    //    $query->bindParam(':email', $this->_email);
        $query->bindParam(':password', $this->_password);
        $query->bindParam(':role', $this->_role);
        $query->bindParam(':image', $this->_image);
        $query->bindParam(':username', $this->_username);
        $query->bindParam(':firstName', $this->_firstName);
        $query->bindParam(':lastName', $this->_lastName);
        $query->bindParam(':GCID', $this->_GCID);
        $query->bindParam(':location', $this->_location);
        $query->bindParam(':modified', $this->_modified);
        $query->bindParam(':id', $id);

        $_SESSION['user'][2] = $this->_username;

        $query -> execute();   //prepared statements value

        $this->_action = $this->_log->setAction("User record updated.");
        $this->_log->setEmail($this->_email);
        $this->Notify();
        if($query) {
            $this->_outcome = 'Success';
        }
        else {
            $this->_outcome = 'Fail';
        }
    }

    public function deleteRecord($id)
    {
        $this->clearOutcome();
        $db = db::GetInstance();
        $this->_outcome = '';

        $sql = "DELETE FROM `user` WHERE userID= ?";

        $query = $db -> dbc -> prepare($sql);

        $query->execute(array($id));
        $this->_log->setEmail($this->_email);
        $this->_action = $this->_log->setAction("User record deleted.");
        $this->Notify();
        if ($query) {
            $this->_outcome = 'Success';
        } else {
            $this->_outcome = 'Fail';
        }
    }

    public function LoginCheck() {
        $db = db::GetInstance();
        $sql = "select * from `user` where `email` = :email";   //prepared statements

        $query = $db -> dbc -> prepare($sql);
        $query->bindParam(':email', $this->_email);

        $query -> execute();   //prepared statements value

        $this->_result = $query -> fetch();
        // password_verify( $password, $hash ) - $hash contains retrieved password from db to compare against form input
        if ($this->_result && password_verify($_POST['password'], $this->_result['password']))
        {
            $this->_action = $this->_log->setAction("Successfully logged in.");
            $sql = "update user set lastLogin = :ldate where email = :email";    //prepared statements

            $query = $db->dbc->prepare($sql);
            $query->bindParam(':ldate', $this->_lastLogin);
            $query->bindParam(':email', $this->_email);

            $query -> execute();   //prepared statements value

            $user = array($this->_result['userID'], $this->_result['email'], $this->_result['username'], $this->_result['role']);
            $_SESSION['user'] = $user;
            $this->_log->setEmail($this->_email);
            $this->_action = "Successfully logged in.";

            echo "<script>location.assign('profile.php'); </script>";
        } else {
            $this->_log->setEmail($this->_email);
            $this->_action = $this->_log->setAction("Failed login attempt.");
            echo "<script>location.assign('LoginForm.php?update=fail'); </script>";
        }
        $this->Notify();
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
            $observer->Update($this->_email, $this->_time, $this->_action);
        }
    }
}

?>