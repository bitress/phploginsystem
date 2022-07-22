<?php

include_once 'config/init.php';

if ($login->isLoggedIn()) {
    header('Location: index.php');
    die();
}

$reg = new Register();

$reg->generateCaptcha();
$firstNum = Session::getSession('first_number');
$secondNum = Session::getSession("second_number");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register | <?= APP_NAME ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/my-login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
</head>
<body class="my-login-page">
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card-wrapper">
                <div class="brand">
                    <img src="assets/images/logo/phpLoginRegisterSystem.png" alt="logo">
                </div>
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title">Register to <?= APP_NAME ?></h4>
                    <form>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username"  placeholder="Enter username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email"  placeholder="Enter email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" placeholder="Enter password" name="confirm_password" required>
                        </div>
                        <div class="form-group">
                            <label for="captcha">Captcha: What is <?= htmlentities($firstNum) . ' + ' . htmlentities($secondNum);   ?></label>
                            <input type="number" class="form-control" id="captcha" placeholder="Captcha" name="captcha" required>
                        </div>

                        <div class="form-group m-0">
                            <input type="hidden" id="token" value="<?= CSRF::generate('register_form') ?>"
                            <button type="button" id="register_button" name="register" class="btn btn-primary btn-block">
                                Register
                            </button>
                        </div>
                        <div class="mt-4 text-center">
                            Already have an account? <a href="login.php">Login</a>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="footer">
                    Copyright &copy; <?= date("Y") ?> &mdash; <?= APP_NAME ?>
                </div>
            </div>
        </div>
    </div>
</section>




<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sha512.min.js"></script>
<script src="https://parsleyjs.org/dist/parsley.min.js"></script>
<script src="assets/js/register.js"></script>
</body>
</html>
