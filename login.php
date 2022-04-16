<?php

include_once 'config/init.php';

if ($login->isLoggedIn()) {
    header('Location: index.php');
    die();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | <?= APP_NAME ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
        <div class="card">
            <div class="card-body">
                <h2>Login</h2>
                <form id="login_form">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text"  class="form-control" id="username"  placeholder="Enter username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                    </div>

                    <button type="button" id="login_button" name="login" class="btn btn-primary">Login</button>
                    <a href="register.php">No account</a>
                </form>
            </div>

        </div>
</div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://parsleyjs.org/dist/parsley.min.js"></script>
<script src="assets/js/sha512.min.js"></script>
<script src="assets/js/login.js"></script>
</body>
</html>
