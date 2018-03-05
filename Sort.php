<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 19/02/2018
 * Time: 20:44
 */

namespace DesignPatterns\FactoryPattern;

require_once 'db.inc.php';
require_once 'ObjectProperties.php';

use \Main\db;
use \Main\ObjectProperties;


class Sort extends ObjectProperties
{
    // Attributes
    protected $_sort;
    protected $_sortitem;

    // Constructor

    // Properties
    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->_sort;
    }

    /**
     * @return mixed
     */
    public function getSortitem()
    {
        return $this->_sortitem;
    }

    // Methods
    public function sortDragons(){
        if (!empty($_GET['sort'])) {
            $this->_sort = db::TestInput($_GET['sort']); // Sorting menu
            switch ($this->_sort) {
                case 'ascdragons':
                    $this->_sortitem = 'd.DragonName';
                    break;
                case 'descdragons':
                    $this->_sortitem = 'd.DragonName DESC';
                    break;
                case 'asctype':
                    $this->_sortitem = 't.TypeName';
                    break;
                case 'desctype':
                    $this->_sortitem = 't.TypeName DESC';
                    break;
                case 'ascelement':
                    $this->_sortitem = 'e.ElementName';
                    break;
                case 'descelement':
                    $this->_sortitem = 'e.ElementName DESC';
                    break;
                default:
                    $this->_sortitem = "de.DragonID";
                    break;
            }
        } else {
            $this->_sortitem = "de.DragonID";
        }
        return $this->_sortitem;
    }

}