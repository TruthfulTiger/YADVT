<?php session_start();

require_once 'db.inc.php';
use \Main\db;

$db = db::GetInstance();

    date_default_timezone_set('America/Denver'); // Set to timezone matching DV game servers

?>

<!doctype html>
<html lang=en_gb>
<head>
<meta charset="utf-8">
<title><?php echo $title?></title>
    <!-- CSS / other links -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href="sticky-footer-navbar.css" rel="stylesheet">
    <link href="custom.css" rel="stylesheet">
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="yamm.css">
<link href="offcanvas.css" rel="stylesheet">
</head>
<body>
<header>

        <!-- Static navbar; megamenu by http://geedmo.github.io/yamm3/ -->
        <nav class="yamm navbar navbar-expand-md navbar-dark bg-primary fixed-top" >
            <div class="container d-flex flex-column flex-md-row justify-content-between">
            <a class="navbar-brand" href="#">YADVT</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav">
                    <li class="nav-item <?php if($title == 'Home') { echo "active";} ?>">
                        <a class="nav-link" href="index.php" >Home <?php if($title == 'Home') { echo "<span class=\"sr-only\">(current)</span>";} ?></a>
                    </li>
                    <li class="nav-item <?php if($title == 'Egg list') { echo "active";} ?>">
                        <a class="nav-link" href="dragonlist.php">Egg list <?php if($title == 'Egg list') { echo "<span class=\"sr-only\">(current)</span>";} ?>
                        </a>
                    </li>
                    <li class="nav-item dropdown yamm-fw"><a class="nav-link dropdown-toggle" href="#" id="elements" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Elements
                        </a>
                        <div class="dropdown-menu yamm-content" aria-labelledby="elements">
                            <div class="row">
                            <?php elementMenu(); ?>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown "><a class="nav-link dropdown-toggle" href="#" id="types" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Types
                        </a>
                        <div class="dropdown-menu" aria-labelledby="types">
                            <?php typeMenu(); ?>
                    </li>

                </ul>
                <form class="form-inline mt-2 mt-md-0" method="post" action="search.php">
                    <input class="form-control mr-sm-2" type="text" name="searchname" placeholder="Find a dragon" aria-label="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" name = "search" type="submit">Search</button>
                </form>
                <ul class="navbar-nav float-md-right">
                    <?php if (!isset($_SESSION['user'])) { ?>
                        <li class="nav-item <?php if($title == 'Login or register') { echo "active";} ?>"><a class="nav-link" href="LoginForm.php">Login or register</a></li>
                    <?php } else { ?>
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="user" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo "Welcome ".$_SESSION['user'][2]; ?></a>
                            <div class="dropdown-menu" aria-labelledby="user">
                                <a class="dropdown-item" href="profile.php">Dashboard</a>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>

                        </li>
                    <?php }

                    function elementMenu() {
                        $db = db::GetInstance();
                        $sql = "select * from element";
                        $query = $db -> dbc -> prepare($sql);
                        $query -> execute();

                        $query -> setFetchMode(PDO::FETCH_ASSOC); // [PDO::FETCH_NUM for integer key value]

                        $result = $query -> fetchAll();

                    foreach ($result as $r) {
                        echo "<div class='col-sm-4'>";
                        echo "<a class=\"dropdown-item \" href='elements.php?element=".$r['ElementName']."&elementid=".$r['ElementID']."'>".$r['ElementName']."</a>";
                        echo "</div>";
                    }
                    }

                    function typeMenu() {
                    $db = db::GetInstance();
                    $sql = "select * from dragontype";
                    $query = $db -> dbc -> prepare($sql);
                    $query -> execute();

                    $query -> setFetchMode(PDO::FETCH_ASSOC); // [PDO::FETCH_NUM for integer key value]

                    $result = $query -> fetchAll();

                    foreach ($result as $r) {
                        echo "<a class=\"dropdown-item\" href='types.php?typename=".$r['TypeName']."&typeid=".$r['TypeID']."'>".$r['TypeName']."</a>";
                    }
                    }
                    ?>
                </ul>
            </div>
            </div>
        </nav>
        <?php
        if (isset($_SESSION['user'])) {
            require_once "user-menu.php";
        }
        ?>

</header>
<!-- Begin page content -->
<main role="main" class="container">