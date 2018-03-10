<?php


$title = '';
$desc = "";

require_once 'header.php';
require_once 'Dragon.php';
use \DesignPatterns\FactoryPattern\Dragon;

$dragonid = \Main\db::TestInput($_GET['id']);
$dragon = new Dragon();
$dragon->load($dragonid); // load from Dragon class (should explore use of strategy pattern to improve loading later, now I understand it better)

$dragonname = \Main\db::TestInput($_GET['dragonname']);
$title = $dragonname;
$desc = $dragon->getDesc();
$elements = explode(',', $dragon->getElements());


if ($dragon->getEggimage() != null) {

echo '<img class="details float-md-right" src="images/Dragons/'.$dragon->getEggimage().'" alt="'.$dragon->getDragonname().'">'; } ?>
    <h1 class="blog-header"><?php echo $title;?></h1>
    <p class="blog-description"><?php echo $desc;?></p>
<div class="container">
        <?php
        if ($dragon->getType() == 4 or $dragon->getType() == 5) {
            $maxlevel = 'N/A'; ?>
            <div class="d-flex text-center align-items-center">
                <img class="adult" src="images/Dragons/<?php echo $dragon->getAdultimage();?>" alt="<?php echo $dragon->getDragonname().' adult'; ?>">
            </div>
    <?php    } else if ($dragon->getElderimage() != null) {
            $maxlevel = 'N/A'; ?>
            <div class="row">
            <div class="col-md-3">
                <img class="details" src="images/Dragons/<?php echo $dragon->getBabyimage();?>" alt="<?php echo $dragon->getDragonname().' baby'; ?>">
            </div>
            <div class="col-md-3">
                <img class="details" src="images/Dragons/<?php echo $dragon->getTeenimage();?>" alt="<?php echo $dragon->getDragonname().' juvenile'; ?>">
            </div>
        <div class="col-md-3">
            <img class="details" src="images/Dragons/<?php echo $dragon->getAdultimage();?>" alt="<?php echo $dragon->getDragonname().' adult'; ?>">
        </div>
        <div class="col-md-3">
            <img class="details" src="images/Dragons/<?php echo $dragon->getElderimage();?>" alt="<?php echo $dragon->getDragonname().' elder'; ?>">
        </div>
    </div>
    <?php
        } else {
            $maxlevel = $dragon->getMaxlevel();
            ?>
        <div class="row">
            <div class="col-md-4">
                <img class="details" src="images/Dragons/<?php echo $dragon->getBabyimage();?>" alt="<?php echo $dragon->getDragonname().' baby'; ?>">
            </div>
            <div class="col-md-4">
                <img class="details" src="images/Dragons/<?php echo $dragon->getTeenimage();?>" alt="<?php echo $dragon->getDragonname().' juvenile'; ?>">
            </div>
            <div class="col-md-4">
                <img class="details" src="images/Dragons/<?php echo $dragon->getAdultimage();?>" alt="<?php echo $dragon->getDragonname().' adult'; ?>">
            </div>
        </div>

   <?php     }        ?>
    <table class="table table-sm table-responsive-md">
        <thead>
        <caption class="sr-only">More information on <?php echo $dragon->getDragonname(); ?></caption>
        </thead>
        <tbody>
        <tr>
            <th scope="row">Available at park level</th>
            <td><?php echo $dragon->getUnlocklvl();?></td>
        </tr>
            <tr>
        <th scope="row">Max dragon level</th>
        <td><?php echo $maxlevel;?></td>
        </tr>
        <tr>
        <th scope="row">Type</th>
        <td><?php if ($dragon->getTypeicon() !=null) {?> <img class="iconSmall" src="images/Icons/<?php echo $dragon->getTypeicon();?>" alt="<?php echo $dragon->getTypename(); ?>"> <?php } else {echo $dragon->getTypename();} ?></td>
        </tr>
            <tr>
                <?php if ($dragon->getEggimage() != null) {  ?>
        <th scope="row">Regular breeding time</th>
        <td><?php if ($dragon->getBreedreg() == null) {echo 'N/A';} else {echo $dragon->getBreedreg();}  ?></td>
        </tr>
            <tr>
        <th scope="row">Upgraded breeding time</th>
        <td><?php if ($dragon->getBreedup() == null) {echo 'N/A';} else {echo $dragon->getBreedup();}  ?></td>
        </tr>
            <tr>
        <th scope="row">Incubation time</th>
        <td><?php if ($dragon->getBreedreg() == null) {echo 'N/A';} else {echo $dragon->getBreedreg();}  ?></td>
        </tr>
        <?php if($elements !=null) { ?>
            <tr>
                <th scope="row">Elements</th><td>
                <?php
                for ($e = 0; $e < count($elements); $e++) {
                echo '<img class="iconSmall" src="images/Icons/'.$elements[$e].'" alt="'.$elements[$e].'">'; } }?>
                </td></tr>
  <?php }
?>
        <?php if($dragon->getNotes() !=null ) { ?>
            <tr>
                <th scope="row">Notes</th>
                <td><?php echo $dragon->getNotes();?></td>
            </tr>
        <?php }
        ?>

        </tbody>
    </table>
</div><!-- /container -->

<?php require_once 'footer.php'; ?>