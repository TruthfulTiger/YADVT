<?php
namespace DesignPatterns\ObserverPattern;

require_once 'IObserver.php';
require_once "db.inc.php";
require_once "User.php";
require_once 'ObjectProperties.php';

use Main\db;
use \DesignPatterns\FactoryPattern\User;
use \Main\ObjectProperties;


class UserLog extends ObjectProperties implements IObserver {

    // Attributes
    private $_id;
    private $_email;
    private $_time;
    private $_action;

    // Constructor
    public function __construct()
    {
        $this->_id = null;
        $this->_time = date('Y-m-d H:i:s');
    }

    // Properties

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->_time;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->_action = $action;
    }

    // Methods

    public function Update(IObservable $observable)
    {
        // Insert loggable details into database - or at least try to
        $db = db::GetInstance();
        $sql = 'insert into `userlog` (`userEmail`, `time`, `action`) values (?, ?, ?)';

        $query = $db -> dbc -> prepare($sql);


        $query -> execute(array($this->_email, $this->_time, $this->_action));    //named parameters value

    }
}