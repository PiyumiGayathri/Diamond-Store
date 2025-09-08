<?php
require "connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diamond Auctions</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo_title.png">
</head>

<body>

    <div class="container-fluid vh-100 d-flex justify-content-center">
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
                                    <p class="fs-1 fw-bold text-center text-black-50">Welcome To Diamond Store!</p>
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
                                                <input type="email" class="form-control" id="email" value="<?php echo $email; ?>">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" value="<?php echo $password; ?>">
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="rMe">
                                                    <label for="rMe" class="form-check-label">Remember Me</label>
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                <a href="#" class="link-primary" onclick="forgotPw();">Forgot Password</a>
                                            </div>
                                            <div class="col-12 col-lg-6 d-grid mt-4">
                                                <button class="btn btn-primary" onclick="signin();">Sign In</button>
                                            </div>
                                            <div class="col-12 col-lg-6 d-grid mt-4">
                                                <button class="btn btn-success" onclick="changeForm();">Join Now</button>
                                            </div>
                                            <div class="col-12 d-grid mt-4">
                                                <h5 class="text-decoration-underline" onclick="window.location.href = 'adminSignin.php';" style="cursor: pointer;">Sign In as Admin?</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- forgot password modal -->
                            <div class="modal" id="newPwModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5 fw-bold">Password Reset</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-2">
                                                <div class="mb-3">
                                                    <label for="vCode" class="col-form-label">Verification Code</label>
                                                    <input type=text class="form-control" id="vCode"></input>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="col-8 ">
                                                        <label for="newP" class="col-form-labe fw-boldl">New Password</label>
                                                        <div class="input-group mb-3">
                                                            <input type="password" id="newP" class="form-control" placeholder="new password">
                                                            <button class="btn btn-outline-secondary" type="button" onclick="show1();">
                                                                <i class="bi bi-eye" id="eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-8 ">
                                                        <label for="newRp" class="col-form-label">Retype New Password</label>
                                                        <div class="input-group mb-3">
                                                            <input type="password" id="newRp" class="form-control" placeholder="retype new password">
                                                            <button class="btn btn-outline-secondary" type="button" onclick="show2();">
                                                                <i class="bi bi-eye" id="eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success" onclick="saveNewPw();">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- forgot password modal -->

                            <div class="col-12 col-lg-8 offset-lg-2 border shadow mb-4 p-4 d-none" id="signUp">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <p class="title2">Create New account</p>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="f">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="l">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" id="e">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" id="p">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">Mobile</label>
                                                <input type="text" class="form-control" id="m">
                                            </div>
                                            <div class="col-6">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select name="gender" class="form-select" id="g">
                                                    <?php
                                                    $gender_rs = Database::search("SELECT * FROM `gender`");
                                                    $gender_rows = $gender_rs->num_rows;

                                                    for ($x = 0; $x < $gender_rows; $x++) {
                                                        $gender_data = $gender_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $gender_data["id"]; ?>"><?php echo $gender_data["name"]; ?></option>
                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12 col-lg-6 d-grid mt-4">
                                                <button class="btn btn-primary" onclick="signup();">Sign Up</button>
                                            </div>
                                            <div class="col-12 col-lg-6 d-grid mt-4">
                                                <button class="btn btn-danger" onclick="changeForm();">Sign In to Current Account</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- content -->

                    <!-- footer -->
                    <div class="col-12 mt-4">
                        <p class="text-center fw-bold">&copy; 2022 diamond@store.lk || All Rights Reserved</p>
                    </div>
                    <!-- footer -->

                </div>
            </div>
        </div>
    </div>


    <script src="bootstrap.js"></script>
    <script src="script.js"></script>
</body>

</html>