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

class FilterDragons extends Dragon implements ILoadDragons
{
    // Attributes
    private $_where;
    private $_id;
    protected $_type;

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
    public function getWhere()
    {
        return $this->_where;
    }

    public function loadDragons()
    {
        $db = db::GetInstance();
        if (!empty($_GET['elementid'])) {
            $this->_id = $db::TestInput($_GET['elementid']);
            $this->_where = 'e.ElementID';
        }

        if (!empty($_GET['typeid'])) {
            $this->_id = db::TestInput($_GET['typeid']);
            $this->_where = 't.TypeID';
            $this->_type = $this->_id;
        }

        $sort = new Sort();
        $page = new PagingDragons();

        $startingLimit = $page->countDragons();
        $limit = $page->getLimit();

        $sortitem = $sort->sortDragons();

        if (!empty($this->_type) && $this->_type == 4 || $this->_type == 5) {
            $sql = "SELECT * FROM dragon AS d 
        JOIN dragontype AS t ON d.TypeID = t.TypeID
        WHERE $this->_where = :filter";
        } else {
            $sql = "SELECT e.ElementName, e.ElementID, e.ElementNotes, GROUP_CONCAT(e.ElementIcon) as elements, d.*, de.*, t.* FROM dragon AS d 
        JOIN dragontype AS t ON d.TypeID = t.TypeID
        JOIN dragonelement AS de ON de.DragonID = d.DragonID
        JOIN element AS e ON de.ElementID = e.ElementID
        WHERE $this->_where = :filter
        GROUP BY de.DragonID
        ORDER BY $sortitem";
        }

        $query = $db -> dbc -> prepare($sql);
        $query->bindParam(':filter', $this->_id);

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
                $this->_typeid = $data['TypeID'];
                $this->_typename = $data['TypeName'];
                $this->_maxlevel = $data['MaxLevel'];
                $this->_typeicon = $data['TypeIcon'];
                if (!empty($_GET['typeid']) && $this->_id < 4 || $this->_id > 5) {
                    $this->_elementid = $data['ElementID'];
                    $this->_elementname = $data['ElementName'];
                    $this->_elementnotes = $data['ElementNotes'];
                    $this->_elements = $data['elements'];
                }
                array_push($dragons, $data);
            }
            return $dragons;
        } else {
            echo "No results found.";
            return null;
        }

    }
}