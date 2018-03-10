<?php

namespace DesignPatterns\FactoryPattern;


require_once 'db.inc.php';
require_once 'FilterDragons.php';
use \Main\db;

class PagingDragons
{
    // Attributes
    private $_starting_limit;
    private $_limit;
    private $_total_pages;
    private $_total_results;
    private $_page;
    private $_currentPage;
    private $_sort;

    // Constructor
    public function __construct() {
        $this->_starting_limit = null;
        $this->_limit = 12;
        $this->_sort = null;
    }

    // Properties

    /**
     * @return mixed
     */
    /**
     * @return mixed
     */
    public function getTotalPages()
    {
        return $this->_total_pages;
    }
    /**
     * @return int
     */
    public function getStartingLimit(): int
    {
        return $this->_starting_limit;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->_limit;
    }

    /**
     * @return mixed
     */
    public function getTotalResults()
    {
        return $this->_total_results;
    }

    // Methods
    public function countDragons() {
        $db = db::GetInstance();
        $filter = new FilterDragons();
        $where = $filter->getWhere();

        if (!empty($_GET['elementid'])) {
            $sql = "SELECT COUNT(*) AS TotalDragons FROM dragon AS d
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                JOIN dragonelement AS de ON de.DragonID = d.DragonID
                JOIN element AS e ON de.ElementID = e.ElementID 
                WHERE e.ElementID = :filter
                GROUP BY de.DragonID";
        } else if (!empty($_GET['typeid'])) {
            $sql = "SELECT COUNT(*) AS TotalDragons FROM dragon AS d
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                JOIN dragonelement AS de ON de.DragonID = d.DragonID
                JOIN element AS e ON de.ElementID = e.ElementID 
                WHERE t.TypeID = :filter
                GROUP BY de.DragonID";
        } else {
            $sql = "SELECT COUNT(*) AS TotalDragons FROM dragon AS d
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                JOIN dragonelement AS de ON de.DragonID = d.DragonID
                JOIN element AS e ON de.ElementID = e.ElementID 
                GROUP BY de.DragonID";
        }

        $query = $db -> dbc -> prepare($sql);

        $query->bindParam(':filter', $where);

        $query -> execute();

        $this->_total_results = $query->rowCount();
        $this->_total_pages = ceil($this->_total_results/$this->_limit);

        if (!isset($_GET['page'])) {
            $this->_page = $this->_currentPage = 1;
        } else{
            $this->_page = $this->_currentPage = $db::TestInput($_GET['page']);
        }

        $this->_starting_limit = ($this->_page-1)*$this->_limit;

        return $this->_starting_limit;

    }

    public function pageLinks() {
        $prev = $this->_currentPage - 1;
        $next = $this->_currentPage + 1;
        $id = null;
        $name = null;
        $url = null;
        $sort = null;

        if (!empty($_GET['elementid'])) {
            $id = db::TestInput($_GET['elementid']);
            $name = db::TestInput($_GET['element']);
            $filter = '&element='.$name.'&elementid='.$id;
        } else if (!empty($_GET['typeid'])) {
            $id = db::TestInput($_GET['typeid']);
            $name = db::TestInput($_GET['typename']);
            $filter = '&typename='.$name.'&typeid'.$id;
        } else {
            $filter = null;
        }

        if (!empty($_GET['sort'])) {
            $this->_sort = db::TestInput($_GET['sort']);
            $sort = "&sort=$this->_sort";
        }

        ?>

        <div class="row">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center pagination-sm">
<!--                <?php
/*
                if ($prev < 1) {*/?>
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span>Previous</span>
                    </a>
                </li> <?php /*} else {
                    $url = "?page=$prev".$filter.$sort;
                    */?>
                    <li class="page-item">
                    <a class="page-link" href="<?php /*echo $url; */?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span>Previous</span>
                    </a>
                </li>
  --><?php /*          }*/

            for ($this->_page=1; $this->_page <= $this->_total_pages; $this->_page++) {
                $url = "?page=$this->_page".$filter.$sort;
                ?>
                <li class="page-item <?php if ($this->_page == $this->_currentPage) {echo "active";} ?>"><a class="page-link" href="<?php echo $url; ?>"><?php  echo $this->_page; ?></a></li>
            <?php }
         ?>
 <!--    <?php
/*
                if ($next > $this->_total_pages) {*/?>
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-label="Next">
                        <span>Next</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li> <?php /*} else {
                    $url = "?page=$next".$filter.$sort;
                    */?>
                    <li class="page-item">
                    <a class="page-link" href="<?php /*echo $url; */?>" aria-label="Next">
                        <span>Next</span>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                --><?php /*              } */?>
            </ul>
        </nav>
        </div>
<?php    }
}