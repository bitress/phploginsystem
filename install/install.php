<?php

    require_once 'Installer.php';



        $installer = new Installer();


        $installer->put("DB_NAME","test");
        $installer->install( 'config.php' );

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Installation Wizard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <!--    Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/fontawesome.css"/>

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<section class="signup-step-container">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>Database Information</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span> <i>Website Information</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab">3</span> <i>Email Configuration</i></a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab">4</span> <i>Installation</i></a>
                            </li>
                        </ul>
                    </div>

                    <form role="form" id="wizard_form" class="login-box">
                        <div class="tab-content" id="main_form">
                            <div class="tab-pane active" role="tabpanel" id="step1">
                                <h4 class="text-center">Database Information</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Database Host</label>
                                            <input class="form-control" name="db_host" type="text" placeholder="">
                                            <small class="form-text text-muted">This is your database hostname; </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Database Name</label>
                                            <input class="form-control" name="db_name" type="text" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Database Username</label>
                                            <input class="form-control" name="db_user" type="text" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Database Password</label>
                                            <input class="form-control" name="db_pass" type="password" placeholder="">
                                        </div>
                                    </div>


                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn next-step">Continue to next step</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step2">
                                <h4 class="text-center">Website Information</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Website Domain</label>
                                            <input class="form-control" name="web_domain" type="text" value="<?= htmlentities($_SERVER['HTTP_HOST']) ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Website Name</label>
                                            <input class="form-control" name="web_name" type="text" placeholder="">
                                        </div>
                                    </div>
                                </div>


                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <li><button type="button" class="default-btn next-step">Continue</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step3">
                                <h4 class="text-center">Email Configuration</h4>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mailer</label>
                                            <select class="form-control" name="mailer" id="mailer">
                                                <option value="mail">PHP mail()</option>
                                                <option value="smtp">SMTP</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                    <div class="smtp" id="smtp">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>SMTP Host</label>
                                                <input type="text" name="smtp_host" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>SMTP Port</label>
                                                <input type="text" name="smtp_port" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>SMTP Encryption</label>
                                                <input type="text" name="smtp_encryption" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>SMTP Username</label>
                                                <input type="text" name="smtp_username" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>SMTP Password</label>
                                                <input type="text" name="smtp_pass" class="form-control">
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <li><button type="button" class="default-btn next-step">Continue</button></li>
                                </ul>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="step4">
                                <h4 class="text-center">Congratulations</h4>

                                <div class="col-md-12">
                                    <p>phpLoginRegisterSystem is ready to install!</p>
                                    <p>Click <strong>Install</strong> button to install it.</p>
                                </div>

                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="default-btn prev-step">Back</button></li>
                                    <li><button type="button" name="install_btn" id="install_btn" type="button" class="default-btn next-step">Install</button></li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>



<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
<script src="assets/js/install.js"></script>
</body>
</html>
