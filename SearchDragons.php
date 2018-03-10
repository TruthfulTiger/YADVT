<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 16/02/2018
 * Time: 18:16
 */

namespace DesignPatterns\FactoryPattern;

require_once 'db.inc.php';
require_once 'ILoadDragons.php';
require_once 'Dragon.php';

use \Main\db;

class SearchDragons extends Dragon implements ILoadDragons
{
    public function loadDragons()
    {
        $id = null;
        $type = null;

        $searchname = db::TestInput($_POST['searchname']);
        $db = db::GetInstance();

        $sql = "SELECT * FROM dragon AS d WHERE DragonName LIKE :dragon";

        $query = $db -> dbc -> prepare($sql);

        $search = '%'.$searchname.'%'; // Because bound parameters don't accept wildcards

        $query->bindParam(':dragon', $search);

        $query -> execute();

  //      $query -> setFetchMode(PDO::FETCH_ASSOC); // [PDO::FETCH_NUM for integer key value]

        $result = $query -> fetchAll();

        if ($result) {
            $dragons = array();
            foreach ($result as $data) {
                $this->_dragonid = $data['DragonID'];
                $this->_dragonname = $data['DragonName'];
                $this->_type = $data['TypeID'];
                $this->_unlocklvl = $data['UnlockLevel'];
                $this->_breedreg = $data['BreedTimeReg'];
                $this->_breedup = $data['BreedTimeUpgrade'];
                $this->_eggimage = $data['EggImage'];
                $this->_babyimage = $data['BabyImage'];
                $this->_teenimage = $data['TeenImage'];
                $this->_adultimage = $data['AdultImage'];
                $this->_elderimage = $data['ElderImage'];
                $this->_desc = $data['Description'];
                $this->_notes = $data['Notes'];

                array_push($dragons, $data);
            }
            return $dragons;
        } else {
            echo "No results found.";
            return null;
        }

    }
}