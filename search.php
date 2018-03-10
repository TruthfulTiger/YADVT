<?php

$title = "Search results for ";
$desc = "";

require_once 'header.php';
require_once 'db.inc.php';
require_once 'LoadDragons.php';
require_once 'SearchDragons.php';

use \DesignPatterns\FactoryPattern\LoadDragons;
use \DesignPatterns\FactoryPattern\SearchDragons;
use \Main\db;

$title = $title.db::TestInput($_POST['searchname']);

?>

    <h1 class="blog-header"><?php echo $title;?></h1>
    <p class="blog-description"><?php echo $desc;?></p>
    <div class="container">
        <div class="row">
            <!-- Load dragon data -->
            <?php if (isset($_POST['search'])) {
                loadDragons();
            }
             ?>
        </div>
    </div><!-- /container -->

<?php

function loadDragons(){

    $dragonlist = new LoadDragons();

    $dragonlist->setOutput(new SearchDragons());
    $dragons = (array)$dragonlist->loadOutput();

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
        <?php }
    }
}

require_once 'footer.php'; ?>