<?php

include_once 'config/init.php';

if (isset($_GET['key'])){
    $confirm_key = $_GET['key'];
} else {
    $confirm_key = "";
}


if ($login->isLoggedIn()) {
    header('Location: index.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Confirm Email | <?= APP_NAME ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/my-login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <!--    Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/fontawesome.css"/>
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
                        <h4 class="card-title">Confirm Email</h4>
                            <div class="well">

                                <div class="form-group">
                                    <label for="confirmation_code">Confirmation Code</label>
                                    <input type="text" id="confirmation_code" class="form-control" placeholder="Enter the confirmation code" value="<?= $confirm_key ?>">
                                </div>

                                <div class="form-group m-0">
                                    <button type="button" id="confirm_button" class="btn btn-primary btn-block">
                                        Confirm Account
                                    </button>
                                </div>

                            </div>

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
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://parsleyjs.org/dist/parsley.min.js"></script>
<script src="assets/js/sha512.min.js"></script>
<script src="assets/js/index.js"></script>
</body>
</html>
