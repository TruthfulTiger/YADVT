<?php

$title = "Search results for ";
$desc = "";

require_once 'header.php';
require_once 'db.inc.php';
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
    $searchname = db::TestInput($_POST['searchname']);
    $db = db::GetInstance();

    $sql = "SELECT * FROM dragon AS d WHERE DragonName LIKE :dragon";

    $query = $db -> dbc -> prepare($sql);

    $search = '%'.$searchname.'%'; // Because bound parameters don't accept wildcards

    $query->bindParam(':dragon', $search);

    $query -> execute();

    $query -> setFetchMode(PDO::FETCH_ASSOC); // [PDO::FETCH_NUM for integer key value]

    $result = $query -> fetchAll();
    if ($result) {
        foreach ($result as $r) {
            ?>
            <div class="col-md-4">
                <div class="text-center">
                    <img class="eggImage" src="images/Dragons/<?php if ($r['EggImage'] !=null ) {echo $r['EggImage']; } else {echo $r['AdultImage'];}?>"
                         alt="<?php echo $r['DragonName'] . " egg"; ?>">
                    <h5><?php echo $r['DragonName']; ?></h5>
                </div>
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
    } else {
        echo "No results found for ".$searchname;
    }
}

require_once 'footer.php'; ?>