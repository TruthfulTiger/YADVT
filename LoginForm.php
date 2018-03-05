<?php
$title = "Login or register";
require_once "header.php";


if (!empty($_GET['update'])) {
    $update = \Main\db::TestInput($_GET['update']); // Sanitise get input to make sure no one's tried to tinker with it
    if ($update == 'success') {
        $message = "You have successfully logged in.";
    } else {
        $message = "Login was unsuccessful. Please try again.";
    }
}
?>

<!-- // Reference: https://www.codeply.com/go/hz4HCGtpb0/bootstrap-4-login-register-forms -->
<div class="container py-5">
    <h2 class="text-center pb-2"></h2>
    <div class="row">
        <!-- Login form -->
        <div class="col-lg-6 col-12 pb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="text-center mb-4">Login</h2>
                    <?php
                    if (!empty($message)) {
                        $colour = '';
                        $update == 'success' ? $colour = 'alert-success' : $colour = 'alert-danger'?>
                        <div class="alert <?php echo $colour;?> alert-dismissable">
                            <a class="panel-close close" data-dismiss="alert">×</a> <?php echo $message; ?>
                        </div>
                    <?php   }
                    ?>
                    <form class="py-2" role="form" action="login.php" method="post">
                        <div class="form-group">
                            <label for="inputEmailForm" class="sr-only form-control-label">Email</label>
                            <div class="mx-auto col-sm-10">
                                <input type="email" name="email" class="form-control" id="inputEmailForm" placeholder="email" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPasswordForm" name="password" class="sr-only form-control-label">Password</label>
                            <div class="mx-auto col-sm-10">
                                <input type="password" name="password" class="form-control" id="inputPasswordForm" placeholder="password" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mx-auto col-sm-10">
                                <div class="checkbox form-control form-control-sm text-center small">
                                    <label class="">
                                        <input type="checkbox" class=""> remember me</label><input type="text" class="hptrap">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mx-auto col-sm-10 pb-3 pt-2">
                                <button type="submit" name="login" class="btn btn-outline-secondary btn-lg btn-block">Sign-in</button>
                            </div>
                        </div>
                    </form>
                    <ul class="list-inline text-center">
                        <li class="list-inline-item px-3"><a href="" title="Twitter"><i class="display-3 ion-social-twitter-outline"></i></a>&nbsp; </li>
                        <li class="list-inline-item px-3"><a href="" title="Google"><i class="display-3 ion-social-googleplus-outline"></i></a>&nbsp; </li>
                        <li class="list-inline-item px-3"><a href="" title="Facebook"><i class="display-3 ion-social-facebook-outline"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Register form -->
        <div class="col-lg-6 col-12 pb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="text-center mb-4">Sign-up</h2>
                    <ul class="list-inline text-center py-2">
                        <li class="list-inline-item px-3"><a href="" title="Twitter"><i class="display-3 ion-social-twitter-outline"></i></a>&nbsp; </li>
                        <li class="list-inline-item px-3"><a href="" title="Google"><i class="display-3 ion-social-googleplus-outline"></i></a>&nbsp; </li>
                        <li class="list-inline-item px-3"><a href="" title="Facebook"><i class="display-3 ion-social-facebook-outline"></i></a></li>
                    </ul>
                    <form role="form" form id="register" action="register.php" method="post">
                        <div class="form-group">
                            <label for="input2EmailForm" class="sr-only form-control-label">email</label>
                            <div class="mx-auto col-sm-10">
                                <input type="email" name="email" class="form-control" id="input2EmailForm" placeholder="email" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input2PasswordForm" class="sr-only form-control-label">password</label>
                            <div class="mx-auto col-sm-10">
                                <input type="password" name="password" class="form-control" id="input2PasswordForm" placeholder="password" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input2Password2Form" class="sr-only form-control-label">verify</label>
                            <div class="mx-auto col-sm-10">
                                <input type="password" name="verify" class="form-control" id="verifyPassword2Form" placeholder="verify password" required=""><input type="text" class="hptrap">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mx-auto col-sm-10 pb-3 pt-2">
                                <button type="submit" name="register" class="btn btn-outline-secondary btn-lg btn-block">Register</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
<?php require_once 'footer.php'; ?>