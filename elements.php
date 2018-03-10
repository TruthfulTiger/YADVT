<?php

$elementid = '';
$title = '';
$desc = "";

require_once 'header.php';
require_once 'db.inc.php';
require_once 'LoadDragons.php';
require_once 'FilterDragons.php';

use \DesignPatterns\FactoryPattern\LoadDragons;
use \DesignPatterns\FactoryPattern\FilterDragons;
use \Main\db;

$elementname = db::TestInput($_GET['element']);
function loadDragons(){

    $dragonlist = new LoadDragons();

    $dragonlist->setOutput(new FilterDragons());
    $dragons = (array)$dragonlist->loadOutput(); ?>
<div class="row">
<?php
    if ($dragons != null) {
        foreach ($dragons as $r) {
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

                    <b>Type: </b><?php if ($r['TypeIcon'] != null) { ?><img class="iconSmall"
                                                                            src="images/Icons/<?php echo $r['TypeIcon']; ?>"
                                                                            alt="<?php echo $r['TypeName']; ?>"> <?php } else {
                        echo $r['TypeName'];
                    } ?><br/>
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a href="dragondetail.php?dragonname=<?php echo $r['DragonName']; ?>&id=<?php echo $r['DragonID']; ?>"
                           class="button btn btn-sm btn-outline-secondary">View</a>
                        <?php if (isset($_SESSION['user'])) {
                            echo '<button type="button" class="btn btn-sm btn-outline-secondary">I have it</button>';
                        } ?>
                    </div>
                    <small class="badge badge-pill badge-success">Available</small>
                </div>
            </div>
            <?php
        }

    }
}

?>
    </div>

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