<?php
$title = "Home";
$desc = "This will be the home page";
require_once 'header.php';
require_once 'db.inc.php';
use \Main\db;

if (!empty($_GET['update'])) {
    $update = \Main\db::TestInput($_GET['update']);
    if ($update == 'success') {
        $message = "You have successfully registered. You may now log in.";
    } else if ($update == 'delete') {
        $message = "Account has been deleted.";
    } else {
        $message = "Sorry, registration failed. Please contact the webmaster if you continue to experience problems.";
    }
}

function loadDragons($limit) {
    $db = db::GetInstance();
    $sql = "SELECT * FROM dragon 
            JOIN dragonelement ON dragon.DragonID = dragonelement.DragonID
            JOIN dragontype ON dragon.TypeID = dragontype.TypeID
            JOIN element ON dragonelement.ElementID = element.ElementID ORDER BY dragon.DragonID DESC LIMIT $limit";
    $query = $db -> dbc -> prepare($sql);

    $query -> execute();

    $query -> setFetchMode(PDO::FETCH_ASSOC); // [PDO::FETCH_NUM for integer key value]

    $result = $query -> fetchAll();
    foreach ($result as $r) { ?>
        <div class="col-md-4">
            <h4><?php echo $r['DragonName']; ?></h4>
            <img class="eggImage" src="images/Dragons/<?php {echo $r['AdultImage'];} ?>"
                 alt="<?php echo $r['DragonName']; ?>">
            <p><a href="dragondetail.php?dragonname=<?php echo $r['DragonName']; ?>&id=<?php echo $r['DragonID']; ?>" class="btn btn-secondary" role="button">View details &raquo;</a></p>
        </div>

    <?php }
}

?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            <?php
            if (!empty($message)) {
                $colour = '';
                $update == 'success' ? $colour = 'alert-success' : $colour = 'alert-danger'?>
                <div class="alert <?php echo $colour;?> alert-dismissable">
                    <a class="panel-close close" data-dismiss="alert">×</a> <?php echo $message; ?>
                </div>
            <?php   }
            ?>
            <h1 class="display-3">Yet Another Dragonvale Tracker?</h1>
            <p>I know, there are plenty of dragon databases and egg trackers out there already - so why should you use this one?</p>
            <p>Well, there are one or two nifty features that I have yet to see anywhere else...</p>
            <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
        </div>
    </div>
    <div class="container">
        <h3>Newly added</h3>
        <p>These dragons have recently been added to the collection:</p>
        <!-- Example row of columns -->
        <div class="row">
            <!-- Load dragons -->
            <?php loadDragons(6); ?>
        </div>

        <hr>

    </div> <!-- /container -->

<?php
require_once 'footer.php';
?>