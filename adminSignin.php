<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diamond</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="resource/logo_title.png">
</head>

<body class="body-main">
    <div class="ontainer-fluid vh-100 d-flex justify-content-center">
        <div class="row align-items-center">

            <div class="col-12">
                <div class="row">

                    <!-- header -->
                    <div class="col-6">
                        <div class="row">
                            <div class="col-12 mx-lg-5 offset-7 offset-lg-0 mt-2 mt-lg-0">
                                <img src="resource/logo_main_2.png" class="w-75">
                            </div>
                        </div>
                    </div>
                    <!-- header -->

                    <!-- content -->
                    <div class="col-12 col-lg-6 d-flex justify-content-center">
                        <div class="row">

                            <div class="col-12">
                                <d class="row">
                                    <p class="fs-1 fw-bold text-center text-black-50">Welcome To Diamond Auctions!</p>
                                </d>
                            </div>

                            <div class="col-8 offset-2 border shadow mb-5 p-4" id="signIn" style="padding-top: -20px;">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <p class="title2">Sign In</p>
                                    </div>
                                    <?php
                                    $email = "";
                                    $password = "";
                                    if (isset($_COOKIE["email"])) {
                                        $email = $_COOKIE["email"];
                                    }
                                    if (isset($_COOKIE["password"])) {
                                        $password = $_COOKIE["password"];
                                    }
                                    ?>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" id="adminEmail" value="<?php echo $email; ?>">
                                                <button class="btn btn-primary mt-4 col-12" onclick="sendAdminVerificationCode();">Send Verification Code</button>
                                            </div>
                                            <!-- modal -->
                                            <div class="modal" tabindex="-1" id="adminVerificationModal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Admin Verification</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label class="form-label">Enter Your Verification Code</label>
                                                            <input type="text" class="form-control" id="vcode">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" onclick="verifyAdmin();">Verify</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- modal -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content -->

                    <!-- footer -->
                    <div class="col-12 mt-4">
                        <p class="text-center fw-bold">&copy; 2022 diamondAuctions.lk || All Rights Reserved</p>
                    </div>
                    <!-- footer -->

                </div>
            </div>

        </div>
    </div>

    <script src="script.js"></script>
    <script src="bootstrap.js"></script>
</body>

</html>