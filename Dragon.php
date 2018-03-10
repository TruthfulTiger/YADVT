<?php

namespace DesignPatterns\FactoryPattern;

require_once 'ObjectProperties.php';
require_once 'ICRUD.php';
require_once 'db.inc.php';

use \Main\ObjectProperties;
use \Main\db;


class Dragon extends ObjectProperties implements ICRUD // Most of this is to allow for being able to add dragons via front end, although load() is used for details page
{
    // Attributes
    protected $_dragonid;
    protected $_dragonname;
    protected $_type;
    protected $_unlocklvl;
    protected $_breedreg;
    protected $_breedup;
    protected $_eggimage;
    protected $_babyimage;
    protected $_teenimage;
    protected $_adultimage;
    protected $_elderimage;
    protected $_desc;
    protected $_notes;
    protected $_elementid;
    protected $_elementname;
    protected $_elementicon;
    protected $_elementnotes;
    protected $_elements;
    protected $_typeid;
    protected $_typename;
    protected $_maxlevel;
    protected $_typeicon;
    protected $_outcome;

    // Constructor
    public function __construct() {

        $this->_outcome = null;
    }

    // Properties

    /**
     * @return mixed
     */
    public function getDragonid()
    {
        return $this->_dragonid;
    }

    /**
     * @return mixed
     */
    public function getDragonname()
    {
        return $this->_dragonname;
    }

    /**
     * @return mixed
     */
    public function getAdultimage()
    {
        return $this->_adultimage;
    }

    /**
     * @return mixed
     */
    public function getBabyimage()
    {
        return $this->_babyimage;
    }

    /**
     * @return mixed
     */
    public function getBreedreg()
    {
        return $this->_breedreg;
    }

    /**
     * @return mixed
     */
    public function getBreedup()
    {
        return $this->_breedup;
    }

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->_desc;
    }

    /**
     * @return mixed
     */
    public function getEggimage()
    {
        return $this->_eggimage;
    }

    /**
     * @return mixed
     */
    public function getElderimage()
    {
        return $this->_elderimage;
    }

    /**
     * @return mixed
     */
    public function getElementicon()
    {
        return $this->_elementicon;
    }

    /**
     * @return mixed
     */
    public function getElementid()
    {
        return $this->_elementid;
    }

    /**
     * @return mixed
     */
    public function getElementname()
    {
        return $this->_elementname;
    }

    /**
     * @return mixed
     */
    public function getElementnotes()
    {
        return $this->_elementnotes;
    }

    /**
     * @return mixed
     */
    public function getElements()
    {
        return $this->_elements;
    }

    /**
     * @return mixed
     */
    public function getMaxlevel()
    {
        return $this->_maxlevel;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->_notes;
    }

    /**
     * @return mixed
     */
    public function getTeenimage()
    {
        return $this->_teenimage;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return mixed
     */
    public function getTypeicon()
    {
        return $this->_typeicon;
    }

    /**
     * @return mixed
     */
    public function getTypeid()
    {
        return $this->_typeid;
    }

    /**
     * @return mixed
     */
    public function getTypename()
    {
        return $this->_typename;
    }

    /**
     * @return mixed
     */
    public function getUnlocklvl()
    {
        return $this->_unlocklvl;
    }

    /**
     * @param mixed $adultimage
     */
    public function setAdultimage($adultimage)
    {
        $this->_adultimage = $adultimage;
    }

    /**
     * @param mixed $babyimage
     */
    public function setBabyimage($babyimage)
    {
        $this->_babyimage = $babyimage;
    }

    /**
     * @param mixed $breedreg
     */
    public function setBreedreg($breedreg)
    {
        $this->_breedreg = $breedreg;
    }

    /**
     * @param mixed $breedup
     */
    public function setBreedup($breedup)
    {
        $this->_breedup = $breedup;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->_desc = $desc;
    }

    /**
     * @param mixed $dragonid
     */
    public function setDragonid($dragonid)
    {
        $this->_dragonid = $dragonid;
    }

    /**
     * @param mixed $dragonname
     */
    public function setDragonname($dragonname)
    {
        $this->_dragonname = $dragonname;
    }

    /**
     * @param mixed $eggimage
     */
    public function setEggimage($eggimage)
    {
        $this->_eggimage = $eggimage;
    }

    /**
     * @param mixed $elderimage
     */
    public function setElderimage($elderimage)
    {
        $this->_elderimage = $elderimage;
    }

    /**
     * @param mixed $elementicon
     */
    public function setElementicon($elementicon)
    {
        $this->_elementicon = $elementicon;
    }

    /**
     * @param mixed $elementid
     */
    public function setElementid($elementid)
    {
        $this->_elementid = $elementid;
    }

    /**
     * @param mixed $elementname
     */
    public function setElementname($elementname)
    {
        $this->_elementname = $elementname;
    }

    /**
     * @param mixed $elementnotes
     */
    public function setElementnotes($elementnotes)
    {
        $this->_elementnotes = $elementnotes;
    }

    /**
     * @param mixed $elements
     */
    public function setElements($elements): void
    {
        $this->_elements = $elements;
    }

    /**
     * @param mixed $maxlevel
     */
    public function setMaxlevel($maxlevel)
    {
        $this->_maxlevel = $maxlevel;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->_notes = $notes;
    }

    /**
     * @param mixed $teenimage
     */
    public function setTeenimage($teenimage)
    {
        $this->_teenimage = $teenimage;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * @param mixed $typeicon
     */
    public function setTypeicon($typeicon)
    {
        $this->_typeicon = $typeicon;
    }

    /**
     * @param mixed $typeid
     */
    public function setTypeid($typeid)
    {
        $this->_typeid = $typeid;
    }

    /**
     * @param mixed $typename
     */
    public function setTypename($typename)
    {
        $this->_typename = $typename;
    }

    /**
     * @param mixed $unlocklvl
     */
    public function setUnlocklvl($unlocklvl)
    {
        $this->_unlocklvl = $unlocklvl;
    }

    /**
     * @param mixed $outcome
     */
    public function setOutcome($outcome)
    {
        $this->_outcome = $outcome;
    }

    /**
     * @return mixed
     */
    public function getOutcome()
    {
        return $this->_outcome;
    }

    // Methods

    public function load($id)
    {
        $db = db::GetInstance();

        if ($id >= 11 and $id <= 14) {
            $sql = "SELECT * FROM dragon AS d 
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                WHERE d.DragonID= :dragon";
        }  else {
            $sql = "SELECT e.ElementName, e.ElementID, e.ElementNotes, GROUP_CONCAT(e.ElementIcon) as elements, d.*, de.*, t.* FROM dragon AS d 
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                JOIN dragonelement AS de ON de.DragonID = d.DragonID
                JOIN element AS e ON de.ElementID = e.ElementID              
                WHERE d.DragonID= :dragon
                GROUP BY de.DragonID";
        }

        $query = $db -> dbc -> prepare($sql);
        $query->bindParam(':dragon', $id);

        $query -> execute();

  //      $query -> setFetchMode(PDO::FETCH_ASSOC); // [PDO::FETCH_NUM for integer key value] - this doesn't work in classes for some reason

        $result = $query->fetchAll();

        if ($result) {
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
                if ($id < 11 or $id > 14) {
                    $this->_elementid = $data['ElementID'];
                    $this->_elementname = $data['ElementName'];
                 //   $this->_elementicon = $data['ElementIcon'];
                    $this->_elementnotes = $data['ElementNotes'];
                    $this->_elements = $data['elements'];
                }
                return $data;
            }
        } else {
            echo "No results found.";
            return null;
        }
    }

    public function insertRecord()
    {
        // TODO: Implement insertRecord() method.
    }

    public function updateRecord($id)
    {
        // TODO: Implement updateRecord() method.
    }

    public function deleteRecord($id)
    {
        // TODO: Implement deleteRecord() method.
    }
}