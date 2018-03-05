<?php

$title = "Profile";
require_once "header.php";

require_once 'User.php';
use \DesignPatterns\FactoryPattern\User;

if (!isset($_SESSION['user'])) {
    echo "<script>location.assign('index.php'); </script>";
} else {
    $id = $_SESSION['user'][0];
    $message = "";
    $user = new User();
    $user->load($id);
    if (!empty($_GET['update'])) {
        $update = \Main\db::TestInput($_GET['update']);
        if ($update == 'success') {
            $message = "Your details have been updated.";
        } else {
            $message = "Sorry, your details couldn't be updated.";
        }
    }

    if(isset($_POST['Update'])) {
        if(!empty($_POST['hptrap'])) { // If honeytrap contains anything, it's a spambot
            echo "Nice try, Spam-A-Lot :P";
        } else {
            if (!empty($_POST['FirstName'])) {
                $firstName = \Main\db::TestInput($_POST['FirstName']);
                $user->setFirstName($firstName);
            }
            if (!empty($_POST['LastName'])) {
                $lastName = \Main\db::TestInput($_POST['LastName']);
                $user->setLastName($lastName);
            }
            if (!empty($_POST['GCID'])) {
                $gcid = \Main\db::TestInput($_POST['GCID']);
                $user->setGCID($gcid);
            }
            if (!empty($_POST['Location'])) {
                $location = \Main\db::TestInput($_POST['Location']);
                $user->setLocation($location);
            }

            if (!empty($_POST['DisplayName'])) {
                $username = \Main\db::TestInput($_POST['DisplayName']);
                $user->setUsername($username);
            }

            // Hash password
            if (!empty($_POST['Password'])) {
                $rawpassword = $_POST['Password'];
                $password = password_hash($rawpassword, PASSWORD_DEFAULT);
                $user->setPassword($password);
            }

            $user->updateRecord($id);
            if ($user->getOutcome() == 'Success') {
                $url = 'profile.php?update=success';
            } else {
                $url = 'profile.php?update=fail';
            }
        } echo "<script>location.assign(".$url."); </script>";
    }
    ?>

<!-- Reference: https://www.codeply.com/go/V298LOj8OF -->
<div class="container">
    <div class="row my-2">
        <div class="col-lg-8 order-lg-2">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Profile</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#messages" data-toggle="tab" class="nav-link">Messages</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Edit</a>
                </li>
            </ul>
            <div class="tab-content py-4">
                <div class="tab-pane active" id="profile">
                    <?php
                    if (!empty($message)) {
                        $colour = '';
                        $update == 'success' ? $colour = 'alert-success' : $colour = 'alert-danger'?>
                        <div class="alert <?php echo $colour;?> alert-dismissable">
                            <a class="panel-close close" data-dismiss="alert">×</a> <?php echo $message; ?>
                        </div>
                    <?php   }
                    ?>
                    <h5 class="mb-3">User Profile</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <?php if ($user->getUsername() !=null) { ?>
                                <h6>Display Name</h6>
                                <p>
                                    <?php echo $user->getUsername(); ?>
                                </p>
                         <?php   } ?>

                            <?php if ($user->getFirstName() !=null or $user->getLastName() !=null) { ?>
                                <h6>Real Name</h6>
                                <p>
                                    <?php echo $user->getFirstName()." ".$user->getLastName(); ?>
                                </p>
                            <?php   } ?>

                            <?php if ($user->getLocation() !=null) { ?>
                                <h6>Location</h6>
                                <p>
                                    <?php echo $user->getLocation(); ?>
                                </p>
                            <?php   } ?>

                            <?php if ($user->getGCID() !=null) { ?>
                                <h6>Gamecenter ID</h6>
                                <p>
                                    <?php echo $user->getGCID(); ?>
                                </p>
                            <?php   } ?>
                        </div>
                        <div class="col-md-6">
                            <h6>Recent badges</h6>
                            <a href="#" class="badge badge-dark badge-pill">html5</a>
                            <a href="#" class="badge badge-dark badge-pill">react</a>
                            <a href="#" class="badge badge-dark badge-pill">codeply</a>
                            <a href="#" class="badge badge-dark badge-pill">angularjs</a>
                            <a href="#" class="badge badge-dark badge-pill">css3</a>
                            <a href="#" class="badge badge-dark badge-pill">jquery</a>
                            <a href="#" class="badge badge-dark badge-pill">bootstrap</a>
                            <a href="#" class="badge badge-dark badge-pill">responsive-design</a>
                            <hr>
                            <span class="badge badge-primary"><i class="fa fa-user"></i> 900 Followers</span>
                            <span class="badge badge-success"><i class="fa fa-cog"></i> 43 Forks</span>
                            <span class="badge badge-danger"><i class="fa fa-eye"></i> 245 Views</span>
                        </div>
                        <div class="col-md-12">
                            <h5 class="mt-2"><span class="fa fa-clock-o float-right"></span> Recent Activity</h5>
                            <table class="table table-sm table-hover table-striped">
                                <tbody>
                                <tr>
                                    <td>
                                        <strong>Abby</strong> joined ACME Project Team in <strong>`Collaboration`</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Gary</strong> deleted My Board1 in <strong>`Discussions`</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Kensington</strong> deleted MyBoard3 in <strong>`Discussions`</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>John</strong> deleted My Board1 in <strong>`Discussions`</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Skell</strong> deleted his post Look at Why this is.. in <strong>`Discussions`</strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--/row-->
                </div>
                <div class="tab-pane" id="messages">
                    <div class="alert alert-info alert-dismissable">
                        <a class="panel-close close" data-dismiss="alert">×</a> This is an <strong>.alert</strong>. Use this to show important messages to the user.
                    </div>
                    <table class="table table-hover table-striped">
                        <tbody>
                        <tr>
                            <td>
                                <span class="float-right font-weight-bold">3 hrs ago</span> Here is your a link to the latest summary report from the..
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="float-right font-weight-bold">Yesterday</span> There has been a request on your account since that was..
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="float-right font-weight-bold">9/10</span> Porttitor vitae ultrices quis, dapibus id dolor. Morbi venenatis lacinia rhoncus.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="float-right font-weight-bold">9/4</span> Vestibulum tincidunt ullamcorper eros eget luctus.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="float-right font-weight-bold">9/4</span> Maxamillion ais the fix for tibulum tincidunt ullamcorper eros.
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="edit">

                    <form role="form" method="post" action="profile.php">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">First name</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="FirstName" type="text" value="<?php echo $user->getFirstName(); ?>"><input type="text" name="hptrap" class="hptrap">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Last name</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="LastName" type="text" value="<?php echo $user->getLastName(); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Email</label>
                            <div class="col-lg-9">
                                <input required class="form-control" disabled name="Email" type="email" value="<?php echo $user->getEmail(); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Gamecenter ID</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" name="GCID" value="<?php echo $user->getGCID(); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Location</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="Location" type="text" value="<?php echo $user->getLocation(); ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Display name</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="DisplayName" type="text" value="<?php echo $user->getUsername(); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">New password</label>
                            <div class="col-lg-9">
                                <input class="form-control" name="Password" id="input2PasswordForm" type="password" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
                            <div class="col-lg-9">
                                <input class="form-control" id="verifyPassword2Form" type="password" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                <input type="reset" class="btn btn-secondary" value="Cancel">
                                <input type="submit" name="Update" class="btn btn-primary" value="Save Changes">
                                <a class="btn btn-danger" href="deleteuser.php?id=<?php echo $user->getId(); ?>">Delete account</a><br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 order-lg-1 text-center">
            <img src="<?php echo $user->getImage(); ?>" class="rounded-circle" alt="avatar">
            <h6 class="mt-2">Upload a different photo</h6>
            <label class="custom-file">
                <input type="file" accept="image/*" id="file" class="custom-file-input">
                <span class="custom-file-control">Choose file</span>
            </label>
        </div>
    </div>
</div>

<?php } require_once 'footer.php'; ?>
