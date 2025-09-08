<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Diamond</title>

    <link rel="stylesheet" href="bootstrap.css">

    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="resource/logo_title.png">
</head>

<body style="background: rgb(242,242,242);
background: linear-gradient(90deg, rgba(242,242,242,1) 0%, rgba(132,140,213,1) 50%, rgba(255,255,255,1) 100%);">
    <div class="container-fluid">
        <div class="row">
            <?php include "header.php"; ?>

            <?php

            if (isset($_SESSION["user"])) {

                $email = $_SESSION["user"]["email"];

                $details_rs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON gender.id = user.gender_id WHERE `email`='" . $email . "' ");

                $image_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $email . "' ");
                $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON
               user_has_address.city_id = city.id INNER JOIN `district` ON 
               city.district_id = district.id INNER JOIN `province` ON
               district.province_id = province.id WHERE `user_email`='" . $email . "' ");

                $data = $details_rs->fetch_assoc();
                $image_data = $image_rs->fetch_assoc();
                $address_data = $address_rs->fetch_assoc();

            ?>

                <div class="co1-12">
                    <div class="row">

                        <div class="col-12  bg-body rounded mt-4 mb-4 d-grid">
                            <div class="row ">

                                <div class="col-12 col-lg-3">
                                    <div class="row">
                                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">

                                            <?php
                                            if (empty($image_data["path"])) {

                                            ?>
                                                <img src="resource/users/uAva.png" class="rounded mt-5" style="width:120px ;" id="viewImg">
                                            <?php
                                            } else {

                                            ?>
                                                <img src="<?php echo $image_data["path"]; ?>" class="rounded mt-5" style="width:150px ;" id="viewImg">
                                            <?php

                                            }
                                            ?>


                                            <span class="fw-bold"><?php echo $data["fname"] . "&nbsp" . $data["lname"]; ?></span>
                                            <span class="fw-bold text-black-50"><?php echo $data["email"]; ?></span>

                                            <input type="file" class="d-none" id="profileImg" accept="image/*">
                                            <label for="profileImg" class="btn btn-primary mt-5" onclick="changeImage();">Update Profile Image</label>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-8 border-start card mt-4 mb-5">
                                    <div class="row">
                                        <div class="p-3 card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h4 class="fw-bold">My Profile</h4>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-6">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" value="<?php echo $data["fname"]; ?>" id="fname">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" value="<?php echo $data["lname"]; ?>" id="lname">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Mobile</label>
                                                    <input type="text" class="form-control" value="<?php echo $data["mobile"]; ?>" id="mobile">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" value="<?php echo $data["password"]; ?>" id="pw" readonly aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                        <span class="input-group-text bg-primary" id="basic-addon2" onclick="showPassword();">
                                                            <i class="bi bi-eye-slash-fill text-white" id="eye"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" value="<?php echo $data["email"]; ?>" readonly>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Registered Date</label>
                                                    <input type="text" class="form-control" value="<?php echo $data["joined_date"]; ?>" readonly>
                                                </div>

                                                <?php
                                                if (!empty($address_data["line1"])) {

                                                ?>
                                                    <div class="col-12">
                                                        <label class="form-label">Address Line 1</label>
                                                        <input type="text" class="form-control" value="<?php echo $address_data["line1"]; ?>" id="line1">
                                                    </div>
                                                <?php


                                                } else {

                                                ?>
                                                    <div class="col-12">
                                                        <label class="form-label">Address Line 1</label>
                                                        <input type="text" class="form-control" id="line1">
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                                <?php
                                                if (!empty($address_data["line2"])) {

                                                ?>
                                                    <div class="col-12">
                                                        <label class="form-label">Address Line 2</label>
                                                        <input type="text" class="form-control" value="<?php echo $address_data["line2"]; ?>" id="line2">
                                                    </div>
                                                <?php


                                                } else {

                                                ?>
                                                    <div class="col-12">
                                                        <label class="form-label">Address Line 2</label>
                                                        <input type="text" class="form-control" id="line2">
                                                    </div>
                                                <?php
                                                }

                                                $province_rs = Database::search("SELECT * FROM `province`");
                                                $district_rs = Database::search("SELECT * FROM `district`");
                                                $city_rs = Database::search("SELECT * FROM `city`");


                                                ?>

                                                <div class="col-6">
                                                    <label class="form-label">Province</label>
                                                    <select class="form-select" id="province">
                                                        <option value="0">Select Province</option>
                                                        <?php

                                                        $province_rows = $province_rs->num_rows;
                                                        for ($a = 0; $a < $province_rows; $a++) {
                                                            $province_data = $province_rs->fetch_assoc();
                                                        ?>
                                                            <option value="<?php echo $province_data["id"]; ?>" <?php
                                                                                                                if (!empty($address_data["province_id"])) {
                                                                                                                    if ($province_data["id"] == $address_data["province_id"]) {
                                                                                                                ?>selected<?php

                                                                                                                        }
                                                                                                                    } ?>><?php echo $province_data["name"]; ?></option>

                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label">District</label>
                                                    <select class="form-select" id="district">
                                                        <option value="0">Select District</option>
                                                        <?php

                                                        $district_rows = $district_rs->num_rows;

                                                        for ($b = 0; $b < $district_rows; $b++) {
                                                            $district_data = $district_rs->fetch_assoc();

                                                        ?>
                                                            <option value="<?php echo $district_data["id"] ?>" <?php
                                                                                                                if (!empty($address_data["district_id"])) {
                                                                                                                    if ($district_data["id"] == $address_data["district_id"]) {
                                                                                                                ?>selected<?php
                                                                                                                        }
                                                                                                                    } ?>><?php echo $district_data["name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label">City</label>
                                                    <select class="form-select" id="city">
                                                        <option value="0">Select City</option>
                                                        <?php

                                                        $city_rows = $city_rs->num_rows;

                                                        for ($c = 0; $c < $city_rows; $c++) {
                                                            $city_data = $city_rs->fetch_assoc();

                                                        ?>
                                                            <option value="<?php echo $city_data["id"] ?>" <?php
                                                                                                            if (!empty($address_data["city_id"])) {
                                                                                                                if ($city_data["id"] == $address_data["city_id"]) {
                                                                                                            ?>selected<?php
                                                                                                                    }
                                                                                                                } ?>><?php echo $city_data["name"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Postal Code</label>
                                                    <?php
                                                    if (!empty($data["postal_code"])) {

                                                    ?>
                                                        <input type="text" class="form-control" value="<?php echo $address_data["postal_code"]; ?>" id="pcode">
                                                    <?php

                                                    } else {
                                                    ?>
                                                        <input type="text" class="form-control" id="pcode">
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Gender</label>

                                                    <input type="text" class="form-control" value="<?php echo $data["name"]; ?>" readonly>
                                                </div>
                                                <div class="col-12 d-grid mt-3">
                                                    <button class="btn btn-primary" onclick="updateProfile();">Update My Profile</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            <?php

            } else {
                header("Location:http://localhost/auction/home.php");
            }
            ?>



            <?php include "footer.php"; ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>