<?php

include_once 'config/init.php';

    if (!$login->isLoggedIn()) {
        header('Location: login.php' );

    } else {


        $user = new User();
        $userDetail = $user->getUserDetails();

        $birthyear = date('Y', strtotime($userDetail['birthdate']));
        $birthmonth = date('n', strtotime($userDetail['birthdate']));
        $birthday = date('j', strtotime($userDetail['birthdate']));

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home | <?= APP_NAME ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <!--    Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/fontawesome.css"/>
    <style>
        .online {
            height: 10px;
            width: 10px;
            background-color: green;
            border-radius: 50%;
            display: inline-block;
        }

        .offline {
            height: 10px;
            width: 10px;
            background-color: gray;
            border-radius: 50%;
            display: inline-block;
        }
    </style>
    <script>
        let id = <?= htmlentities($userDetail['user_id']) ?>;
    </script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?= APP_NAME ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="messages.php"><i class="fas fa-chat"></i> Messages <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>
        <div class="container">

            <div class="jumbotron m-4">
                <img src="<?= htmlentities($userDetail['avatar']) ?>" class="img-thumbnail" width="250px" height="250px">
                <h3>Hello <?= htmlentities($userDetail['username']) ?> &nbsp;<span id="status"></span></h3>

                <a href="logout.php">Logout</a>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h3>Change Email</h3>
                    <form>
                        <div class="mb-3">
                            <label for="email-input">Email Address</label>
                            <input type="email" class="form-control" value="<?= htmlentities($userDetail['email']) ?>" id="email-input">
                        </div>
                        <div class="mb-3">
                            <button type="button" id="changeEmailBtn" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>

                    <h3>Change Profile</h3>
                    <form enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="profile_image">Profile Image</label>
                            <input type="file" class="form-control" id="avatar">
                        </div>
                        <div class="mb-3">
                            <label for="firstname-input">First Name</label>
                            <input type="text" class="form-control" value="<?= htmlentities($userDetail['first_name']) ?>" id="firstname-input">
                        </div>

                        <div class="mb-3">
                            <label for="lastname-input">Last Name</label>
                            <input type="text" class="form-control" value="<?= htmlentities($userDetail['last_name']) ?>" id="lastname-input">
                        </div>

                        <label for="birthday">Birthdate</label>
                        <div class="row">
                        <div class="mb-3 col-md-4">
                            <select name="birth_month" id="birth_month" class="form-control">
                                <?php for( $m=1; $m<=12; ++$m ): $month_label = date('F', mktime(0, 0, 0, $m, 1)); $current = date('n');?>
                                    <option value="<?= $m; ?>"<?= $birthmonth == $m ? ' selected' : ''?>><?php echo $month_label; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-2">
                            <select name="birth_day" id="birth_day" class="form-control">
                                <?php
                                for( $j=1; $j<=31; $j++ ): ?>
                                    <option value="<?= $j; ?>"<?= $birthday == $j ? ' selected' : ''?>><?= $j; ?></option>
                                <?php endfor;?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <select name="birth_year" id="birth_year" class="form-control">
                                <?php $year = date("Y"); $min = $year - 60;$max = $year;for( $i=$max; $i>=$min; $i-- ):?>
                                    <option value="<?= $i; ?>"<?= $birthyear == $i ? ' selected' : ''?>><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        </div>
                        <div class="mb-3">
                            <button type="button" id="changeProfileBtn" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>


                </div>
                <div class="col-md-6">
                    <h3>Change Password</h3>
                    <form>
                        <div class="mb-3">
                            <label for="old_password">Old Password</label>
                            <input type="password" class="form-control" value="" id="old_password">
                        </div>
                        <div class="mb-3">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control" value="" id="new_password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" value="" id="confirm_password">
                        </div>
                        <div class="mb-3">
                            <button type="button" id="changePasswordBtn" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/sha512.min.js"></script>
    <script src="assets/js/index.js"></script>
    <script src="assets/js/register.js"></script>
</body>
</html>