<?php
$title = "Delete account";
require_once "header.php";

require_once 'Factory.php';
use \DesignPatterns\FactoryPattern\Factory;

if (isset($_GET['id'])) {
    $id = \Main\db::TestInput($_GET['id']);
} else {
    $id = '';
}

// Make sure that both user session and delete id are set before proceeding
if (isset($_GET['delete']) and isset($_SESSION['user'])) {
    $delete = \Main\db::TestInput($_GET['delete']);
    $id = \Main\db::TestInput($_GET['id']);
    Factory::DeleteUser($id);
}
 ?>

    <h1 class="blog-header"><?php echo $title;?></h1>
    <div class="container">
    <p>You are about to delete your account. Are you sure you want to do this?</p>
        <div class="row">
            <div class="d-flex text-center align-items-center">
                <p><a class="btn btn-secondary" href="deleteuser.php?delete=1&id=<?php echo $id;?>">Yes</a> <a class="btn btn-secondary" href="profile.php">No</a></p>
            </div>
        </div>
    </div><!-- /container -->

<?php require_once 'footer.php'; ?>