<?php

include_once 'config/init.php';

if (!$login->isLoggedIn()) {
    header('Location: login.php' );

} else {
    $message = new Message();
    $user = new User();
    $userDetail = $user->getUserDetails();
}


if(isset($_GET['id'])){
    $incoming = $_GET['id'];
} else {
    $incoming = 0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Messages | <?= APP_NAME ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <!--    Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/fontawesome.css"/>
    <link rel="stylesheet" href="assets/css/message.css">
    <script>
        let id = <?= htmlentities($userDetail['user_id']) ?>;
        let incoming = <?= $incoming ?>;
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
            <li class="nav-item">
                <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="messages.php"><i class="fas fa-chat"></i> Messages <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">

    <div class="jumbotron m-4">
        <h3>Hello <?= htmlentities($userDetail['username']) ?></h3>
        <a href="logout.php">Logout</a>
    </div>

    <main class="content">
        <div class="container p-0">

            <h1 class="h3 mb-3">Messages</h1>

            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-lg-5 col-xl-3 border-right">



                        <div id="message_sidebar"></div>

                        <hr class="d-block d-lg-none mt-1 mb-0">
                    </div>
                    <div class="col-12 col-lg-7 col-xl-9">
                        <div id="_chatbox_">
                        <div class="py-2 px-4 border-bottom d-none d-lg-block">
                            <div class="d-flex align-items-center py-1">
                                <div class="position-relative">
                                    <img src="#" class="rounded-circle mr-1 user-avatar"  width="40" height="40">
                                </div>
                                <div class="flex-grow-1 pl-3">
                                    <span id="user_name"><strong></strong></span>
                                </div>

                            </div>
                        </div>

                            <div class="position-relative">
                                <div class="chat-messages p-4">
                               <div id="chatbox"></div>
                                </div>
                            </div>


                        <div class="flex-grow-0 py-3 px-4 border-top">
                            <div class="input-group">
                                <input type="hidden" id="receiver_id" value="">
                                <input type="text" id="message_box" class="form-control" placeholder="Type your message">
                                <button id="send_message" class="btn btn-primary">Send</button>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            </div>
        </div>
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sha512.min.js"></script>
<script src="assets/js/index.js"></script>
<script src="assets/js/register.js"></script>
<script src="assets/js/message.js"></script>
</body>
</html>