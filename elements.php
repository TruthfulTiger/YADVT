<?php

$elementid = '';
$title = '';
$desc = "";

require_once 'header.php';
require_once 'db.inc.php';
use \Main\db;

$elementname = db::TestInput($_GET['element']);
function loadDragons(){
    $db = db::GetInstance();
    $elementid = $db::TestInput($_GET['elementid']);
    if (!empty($_GET['sort'])) {
        $sort = $db::TestInput($_GET['sort']);
        switch ($sort) {
            case 'ascdragons':
                $sql = "SELECT * FROM dragon AS d 
            JOIN dragontype AS t ON d.TypeID = t.TypeID
            JOIN dragonelement AS de ON de.DragonID = d.DragonID
            JOIN element AS e ON de.ElementID = e.ElementID
            WHERE e.ElementID= :element ORDER BY d.DragonName";
                break;
            case 'descdragons':
                $sql = "SELECT * FROM dragon AS d 
            JOIN dragontype AS t ON d.TypeID = t.TypeID
            JOIN dragonelement AS de ON de.DragonID = d.DragonID
            JOIN element AS e ON de.ElementID = e.ElementID
            WHERE e.ElementID= :element ORDER BY d.DragonName DESC ";
                break;
            case 'asctype':
                $sql = "SELECT * FROM dragon AS d 
            JOIN dragontype AS t ON d.TypeID = t.TypeID
            JOIN dragonelement AS de ON de.DragonID = d.DragonID
            JOIN element AS e ON de.ElementID = e.ElementID
            WHERE e.ElementID= :element ORDER BY t.TypeName";
                break;
            case 'desctype':
                $sql = "SELECT * FROM dragon AS d 
            JOIN dragontype AS t ON d.TypeID = t.TypeID
            JOIN dragonelement AS de ON de.DragonID = d.DragonID
            JOIN element AS e ON de.ElementID = e.ElementID
            WHERE e.ElementID= :element ORDER BY t.TypeName DESC";
                break;
            default:
                $sql = "SELECT * FROM dragon AS d 
            JOIN dragontype AS t ON d.TypeID = t.TypeID
            JOIN dragonelement AS de ON de.DragonID = d.DragonID
            JOIN element AS e ON de.ElementID = e.ElementID
            WHERE e.ElementID= :element ORDER BY d.DragonID";
                break;
        }
    } else {
        $sql = "SELECT * FROM dragon AS d 
            JOIN dragontype AS t ON d.TypeID = t.TypeID
            JOIN dragonelement AS de ON de.DragonID = d.DragonID
            JOIN element AS e ON de.ElementID = e.ElementID
            WHERE e.ElementID= :element";
    }

    $query = $db -> dbc -> prepare($sql);
    $query->bindParam(':element', $elementid);

    $query -> execute();

    $query -> setFetchMode(PDO::FETCH_ASSOC); // [PDO::FETCH_NUM for integer key value]

    $result = $query -> fetchAll();
    if ($result) {
        foreach ($result as $r) {
            ?>
            <div class="col-md-4">
                <div class="text-center">
                    <img class="eggImage" src="images/Dragons/<?php if ($r['EggImage'] != null) {
                        echo $r['EggImage'];
                    } else {
                        echo $r['AdultImage'];
                    } ?>"
                         alt="<?php echo $r['DragonName'] . " egg"; ?>">
                    <h5><?php echo $r['DragonName']; ?></h5>
                </div>
                <p><b>Breed time (regular cave):</b> <?php if ($r['BreedTimeReg'] != null) {
                        echo $r['BreedTimeReg'] . "<br/>";
                    } else {
                        echo "Instant" . "<br/>";
                    }; ?>
                    <b>Breed time (upgraded):</b> <?php if ($r['BreedTimeUpgrade'] != null) {
                        echo $r['BreedTimeUpgrade'] . "<br/>";
                    } else {
                        echo "N/A" . "<br/>";
                    }; ?>
                    <b>Elements: </b><img class="iconSmall" src="images/Icons/<?php echo $r['ElementIcon']; ?>"
                                          alt="<?php echo $r['ElementName'];
                                           ?>"><br/>
                    <b>Type: </b><?php if ($r['TypeIcon'] != null) { ?><img class="iconSmall" src="images/Icons/<?php echo $r['TypeIcon']; ?>" alt="<?php echo $r['TypeName']; ?>"> <?php } else {echo $r['TypeName'];} ?><br/>
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a href="dragondetail.php?dragonname=<?php echo $r['DragonName']; ?>&id=<?php echo $r['DragonID']; ?>" class="button btn btn-sm btn-outline-secondary">View</a>
                        <?php if (isset($_SESSION['user'])) {
                            echo '<button type="button" class="btn btn-sm btn-outline-secondary">I have it</button>';
                        } ?>
                    </div>
                    <small class="badge badge-pill badge-success">Available</small>
                </div>
            </div> <?php
        }
    } else {
        echo "No results found.";
    }


}

?>

    <h1 class="blog-header"><?php $title = $elementname." dragons"; echo $title;?></h1>
    <p class="blog-description"><?php echo $desc;
        $url = 'elements.php?elementid='.$_GET['elementid'].'&element='.$elementname;?></p>
    <div class="container">
        <div class="row">
            <div class="d-flex text-center align-items-center">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="sort" data-toggle="dropdown">Sort by
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="sort">
                        <li role="presentation" class="dropdown-header">Dragon</li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="<?php echo $url;?>&sort=ascdragons">A-Z</a></li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="<?php echo $url;?>&sort=descdragons">Z-A</a></li>
                        <li role="presentation" class="dropdown-header">Type</li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="<?php echo $url;?>&sort=asctype">A-Z</a></li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="<?php echo $url;?>&sort=desctype">Z-A</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Load dragon data -->
            <?php loadDragons(); ?>
        </div>
    </div><!-- /container -->

<?php

require_once 'footer.php'; ?>