<?php
$title = "Egg list";
$desc = "List of all dragons available.";

require_once 'header.php';
require_once 'db.inc.php';
use \Main\db;

function loadDragons(){
    $db = db::GetInstance();
    if (!empty($_GET['sort'])) {
        $sort = db::TestInput($_GET['sort']); // Sorting menu
        switch ($sort) {
            case 'ascdragons': // This DEFINITELY needs streamlining via strategy pattern or some other means; have found, however, that listing multiple rows via class wouldn't work - hence using this method instead. Will explore improvements on own time when I have access to more time and patience
                $sql = "SELECT * FROM dragon 
            JOIN dragonelement ON dragon.DragonID = dragonelement.DragonID
            JOIN dragontype ON dragon.TypeID = dragontype.TypeID
            JOIN element ON dragonelement.ElementID = element.ElementID ORDER BY DragonName";
                break;
            case 'descdragons':
                $sql = "SELECT * FROM dragon 
            JOIN dragonelement ON dragon.DragonID = dragonelement.DragonID
            JOIN dragontype ON dragon.TypeID = dragontype.TypeID
            JOIN element ON dragonelement.ElementID = element.ElementID ORDER BY DragonName DESC";
                break;
            case 'asctype':
                $sql = "SELECT * FROM dragon 
            JOIN dragonelement ON dragon.DragonID = dragonelement.DragonID
            JOIN dragontype ON dragon.TypeID = dragontype.TypeID
            JOIN element ON dragonelement.ElementID = element.ElementID ORDER BY TypeName";
                break;
            case 'desctype':
                $sql = "SELECT * FROM dragon 
            JOIN dragonelement ON dragon.DragonID = dragonelement.DragonID
            JOIN dragontype ON dragon.TypeID = dragontype.TypeID
            JOIN element ON dragonelement.ElementID = element.ElementID ORDER BY TypeName DESC";
                break;
            case 'ascelement':
                $sql = "SELECT * FROM dragon 
            JOIN dragonelement ON dragon.DragonID = dragonelement.DragonID
            JOIN dragontype ON dragon.TypeID = dragontype.TypeID
            JOIN element ON dragonelement.ElementID = element.ElementID ORDER BY ElementName";
                break;
            case 'descelement':
                $sql = "SELECT * FROM dragon 
            JOIN dragonelement ON dragon.DragonID = dragonelement.DragonID
            JOIN dragontype ON dragon.TypeID = dragontype.TypeID
            JOIN element ON dragonelement.ElementID = element.ElementID ORDER BY ElementName DESC";
                break;
            default:
                $sql = "SELECT * FROM dragon 
            JOIN dragonelement ON dragon.DragonID = dragonelement.DragonID
            JOIN dragontype ON dragon.TypeID = dragontype.TypeID
            JOIN element ON dragonelement.ElementID = element.ElementID ORDER BY DragonID";
                break;
        }
    } else {
        $sql = "SELECT * FROM dragon 
            JOIN dragonelement ON dragon.DragonID = dragonelement.DragonID
            JOIN dragontype ON dragon.TypeID = dragontype.TypeID
            JOIN element ON dragonelement.ElementID = element.ElementID";
    }


    $query = $db -> dbc -> prepare($sql);


    $query -> execute();

    $query -> setFetchMode(PDO::FETCH_ASSOC); // [PDO::FETCH_NUM for integer key value]

    $result = $query -> fetchAll();

    foreach ($result as $r) { ?>
        <div class="col-md-4">
        <div class="text-center">
            <img class="eggImage" src="images/Dragons/<?php if ($r['EggImage'] !=null ) {echo $r['EggImage']; } else {echo $r['AdultImage'];} ?>"
                 alt="<?php echo $r['DragonName'] . " egg"; ?>">
            <h5><?php echo $r['DragonName']; ?></h5>
        </div>
        <p><b>Breed time (regular cave):</b> <?php if ($r['BreedTimeReg'] != null) {echo $r['BreedTimeReg']."<br/>";} else { echo "Instant". "<br/>"; }; ?>
        <b>Breed time (upgraded):</b> <?php if ($r['BreedTimeUpgrade'] != null) {echo $r['BreedTimeUpgrade']."<br/>";} else { echo "N/A". "<br/>"; };
            if ($r['ElementIcon'] !=null ) { ?>
            <b>Elements: </b><img class="iconSmall" src="images/Icons/<?php echo $r['ElementIcon']; ?>" alt="<?php echo $r['ElementName']; }?>"><br/>
        <b>Type: </b><?php if ($r['TypeIcon'] != null) { ?><img class="iconSmall" src="images/Icons/<?php echo $r['TypeIcon']; ?>" alt="<?php echo $r['ElementName']; ?>"> <?php } else {echo $r['TypeName'];} ?><br/>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="dragondetail.php?dragonname=<?php echo $r['DragonName']; ?>&id=<?php echo $r['DragonID']; ?>" class="button btn btn-sm btn-outline-secondary">View</a>

                    <?php if (isset($_SESSION['user'])) {
                        echo '<button type="button" class="btn btn-sm btn-outline-secondary">I have it</button>';
                    } ?>
                </div>
                <small class="badge badge-pill badge-success">Available</small>
            </div>
            </div>
        <?php }

}

?>

<h1 class="blog-header"><?php echo $title;?></h1>
<p class="blog-description"><?php echo $desc;?></p>
    <div class="container">
        <div class="row">
            <div class="d-flex text-center align-items-center">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="sort" data-toggle="dropdown">Sort by
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="sort">
                        <li role="presentation" class="dropdown-header">Dragon</li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="dragonlist.php?sort=ascdragons">A-Z</a></li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="dragonlist.php?sort=descdragons">Z-A</a></li>
                        <li role="presentation" class="dropdown-header">Type</li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="dragonlist.php?sort=asctype">A-Z</a></li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="dragonlist.php?sort=desctype">Z-A</a></li>
                        <li role="presentation" class="dropdown-header">Element</li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="dragonlist.php?sort=ascelement">A-Z</a></li>
                        <li role="presentation"><a class="dropdown-item" role="menuitem" href="dragonlist.php?sort=descelement">Z-A</a></li>
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