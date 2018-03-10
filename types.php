<?php

$typeid = '';
$title = '';
$desc = "";

require_once 'header.php';
require_once 'db.inc.php';
require_once 'LoadDragons.php';
require_once 'FilterDragons.php';

use \DesignPatterns\FactoryPattern\LoadDragons;
use \DesignPatterns\FactoryPattern\FilterDragons;
use \Main\db;

$typename = db::TestInput($_GET['typename']);

function loadDragons(){
    $typeid = db::TestInput($_GET['typeid']);

    $dragonlist = new LoadDragons();

    $dragonlist->setOutput(new FilterDragons());
    $dragons = (array)$dragonlist->loadOutput(); ?>

<div class="row">
<?php    if ($dragons != null) {
        foreach ($dragons as $r) {
            $elements = explode(',', $r['elements']);
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
                        if ($elements != null) { ?>
                            <b>Elements: </b> <?php
                            for ($e = 0; $e < count($elements); $e++) {
                                echo '<img class="iconSmall" src="images/Icons/' . $elements[$e] . '" alt="' . $elements[$e] . '">';
                            }
                        } ?>
                        <br/>
                    </p>
                <?php } ?>
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
            </div> <?php
        }
    }
}

?>
    </div>

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