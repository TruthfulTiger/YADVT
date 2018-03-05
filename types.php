<?php

$typeid = '';
$title = '';
$desc = "";

require_once 'header.php';
require_once 'db.inc.php';
use \Main\db;

$typename = db::TestInput($_GET['typename']);

function loadDragons(){
    $db = db::GetInstance();
    $typeid = db::TestInput($_GET['typeid']);
    if (!empty($_GET['sort'])) {
        $sort = db::TestInput($_GET['sort']);
        switch ($sort) {
            case 'ascdragons':
                $sql = "SELECT * FROM dragon AS d 
            JOIN dragontype AS t ON d.TypeID = t.TypeID
            JOIN dragonelement AS de ON de.DragonID = d.DragonID
            JOIN element AS e ON de.ElementID = e.ElementID
            WHERE t.TypeID= :dtype ORDER BY d.DragonName";
                break;
            case 'descdragons':
                $sql = "SELECT * FROM dragon AS d 
            JOIN dragontype AS t ON d.TypeID = t.TypeID
            JOIN dragonelement AS de ON de.DragonID = d.DragonID
            JOIN element AS e ON de.ElementID = e.ElementID
            WHERE t.TypeID= :dtype ORDER BY d.DragonName DESC ";
                break;
            case 'ascelement':
                $sql = "SELECT * FROM dragon AS d 
            JOIN dragontype AS t ON d.TypeID = t.TypeID
            JOIN dragonelement AS de ON de.DragonID = d.DragonID
            JOIN element AS e ON de.ElementID = e.ElementID
            WHERE t.TypeID= :dtype ORDER BY e.ElementName";
                break;
            case 'descelement':
                $sql = "SELECT * FROM dragon AS d 
            JOIN dragontype AS t ON d.TypeID = t.TypeID
            JOIN dragonelement AS de ON de.DragonID = d.DragonID
            JOIN element AS e ON de.ElementID = e.ElementID
            WHERE t.TypeID= :dtype ORDER BY e.ElementName DESC";
                break;
            default:
                $sql = "SELECT * FROM dragon AS d 
            JOIN dragontype AS t ON d.TypeID = t.TypeID
            JOIN dragonelement AS de ON de.DragonID = d.DragonID
            JOIN element AS e ON de.ElementID = e.ElementID
            WHERE t.TypeID= :dtype ORDER BY d.DragonID";
                break;
        }
    } else {
        if ($_GET['typeid'] == 4 or $_GET['typeid'] == 5) {
            $sql = "SELECT * FROM dragon AS d 
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                WHERE t.TypeID= :dtype";
        } else {
            $sql = "SELECT * FROM dragon AS d 
            JOIN dragontype AS t ON d.TypeID = t.TypeID
            JOIN dragonelement AS de ON de.DragonID = d.DragonID
            JOIN element AS e ON de.ElementID = e.ElementID
            WHERE t.TypeID= :dtype ";
        }
    }

    $query = $db -> dbc -> prepare($sql);
    $query->bindParam(':dtype', $typeid);

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
            <?php if ($typeid == 4 or $typeid == 5) { ?>
                <p><b>Unlock level:</b> <?php echo $r['UnlockLevel'];
            } else { ?>
                <p><b>Breed time (regular cave):</b> <?php if ($r['BreedTimeReg'] != null) {
                        echo $r['BreedTimeReg'] . "<br/>";
                    } else {
                        echo "Instant" . "<br/>";
                    }; ?>
                    <b>Breed time (upgraded):</b> <?php if ($r['BreedTimeUpgrade'] != null) {
                        echo $r['BreedTimeUpgrade'] . "<br/>";
                    } else {
                        echo "N/A" . "<br/>";
                    };
                    if ($r['ElementIcon'] !== null) { ?>
                    <b>Elements: </b><img class="iconSmall" src="images/Icons/<?php echo $r['ElementIcon']; ?>"
                                          alt="<?php echo $r['ElementName'];
                                          } ?>">
                </p>
            <?php } ?>
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
    echo "Couldn't load data.";
}

}

?>

    <h1 class="blog-header"><?php $title = $typename." dragons"; echo $title;?></h1>
    <p class="blog-description"><?php echo $desc;?></p>
    <div class="container">
        <?php
        $url = 'types.php?typeid='.$_GET['typeid'].'&typename='.$typename;
        if ($_GET['typeid'] < 4 or $_GET['typeid'] > 5) { ?>
        <div class="row">
            <div class="d-flex text-center align-items-center">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="sort" data-toggle="dropdown">Sort by
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="sort">
                        <li role="presentation" class="dropdown-header">Dragon</li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="<?php echo $url;?>&sort=ascdragons">A-Z</a></li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="<?php echo $url;?>&sort=descdragons">Z-A</a></li>
                        <li role="presentation" class="dropdown-header">Element</li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="<?php echo $url;?>&sort=ascelement">A-Z</a></li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="<?php echo $url;?>&sort=descelement">Z-A</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php }?>
        <div class="row">
            <!-- Load dragon data -->
            <?php loadDragons(); ?>
        </div>
    </div><!-- /container -->

<?php

require_once 'footer.php'; ?>