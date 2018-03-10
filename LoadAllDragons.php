<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 16/02/2018
 * Time: 15:07
 */

namespace DesignPatterns\FactoryPattern;

require_once 'db.inc.php';
require_once 'ILoadDragons.php';
require_once 'Dragon.php';
require_once 'Sort.php';
require_once 'PagingDragons.php';

use \Main\db;

// Paging script ref: https://stackoverflow.com/questions/44792931/how-to-create-pagination-with-pdo-php
class LoadAllDragons extends Dragon implements ILoadDragons
{
    // Attributes
    private $_sort;
    private $_page;

    // Constructor
    public function __construct() {
        $this->_sort = new Sort();
        $this->_page = new PagingDragons();
    }

    // Properties
    /**
     * @return Sort
     */
    public function getSort(): Sort
    {
        return $this->_sort;
    }

    /**
     * @return PagingDragons
     */
    public function getPage(): PagingDragons
    {
        return $this->_page;
    }

    // Methods

    public function loadDragons()
    {
        $db = db::GetInstance();

        $startingLimit = $this->_page->countDragons();
        $sortitem = $this->_sort->sortDragons();
        $limit = $this->_page->getLimit();

        $sql = "SELECT e.ElementName, e.ElementID, e.ElementNotes, GROUP_CONCAT(e.ElementIcon) as elements, d.*, de.*, t.* FROM dragon AS d 
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                JOIN dragonelement AS de ON de.DragonID = d.DragonID
                JOIN element AS e ON de.ElementID = e.ElementID
                GROUP BY de.DragonID
                ORDER BY $sortitem 
                LIMIT $limit OFFSET $startingLimit";

        $query = $db -> dbc -> prepare($sql);

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
                    $this->_elementid = $data['ElementID'];
                    $this->_elementname = $data['ElementName'];
                    $this->_elementnotes = $data['ElementNotes'];
                    $this->_elements = $data['elements'];
                    array_push($dragons, $data);
                }
                echo $this->_page->pageLinks();
            return $dragons;
        } else {
            echo "No results found.";
            return null;
        }
    }
}