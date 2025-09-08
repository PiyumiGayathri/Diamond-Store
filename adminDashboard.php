<?php
session_start();

require "connection.php";
if (isset($_SESSION["admin"])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard | Diamond</title>

        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css">

        <link rel="icon" href="resource/logo_title.png">
    </head>

    <body>
        <?php

        $today = date("Y-m-d");
        $thisMonth = date("m");
        $thisYear = date("Y");

        ?>

            <div class="container-fluid">
                <div class="row">

                    <div class="col-12 col-lg-3">
                        <div class="row">

                            <div class="col-12 align-items-start vh-100" style="background-color: #001f3d0a;">
                                <div class="row g-1 text-center">
                                    <div class="col-12">
                                        <img class="mt-5" src="resource/logo_title.png" style="height: 80px;width:80px;">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <h4>Welcome Admin <br><?php echo $_SESSION["admin"]["fname"] . " " . $_SESSION["admin"]["lname"]; ?></h4>
                                        <hr class="border border-1 border-dark">
                                    </div>
                                    <div class="nav flex-column nav-pills me-3 mt-3" role="tablist" aria-orientation="vertical">
                                        <nav class="nav flex-column">
                                            <a href="adminDashboard.php" class="nav-link active" aria-current="page">Dashboard</a>
                                            <a href="manageUsers.php" class="nav-link">Manage Users</a>
                                            <a href="manageProducts.php" class="nav-link">Manage Products</a>
                                            <a href="sellingHistory.php" class="nav-link">Selling History</a>
                                            <div class="mt-2">
                                                <button onclick="adminSignout();" class="btn btn-dark">Sign Out</button>
                                            </div>
                                        </nav>

                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="background-color: #001f3d;margin-top: -200px;">
                                <div class="row">
                                    <div class="col-12 text-center my-3">
                                        <label class="form-label fs-4 text-white">Your Total Active Time</label>
                                    </div>
                                    <div class="col-12 text-center my-3">
                                        <?php

                                        $start_date = new dateTime("2022-01-28 00:00:00");

                                        $tdate = new DateTime();
                                        $tz = new DateTimeZone("Asia/Colombo");
                                        $tdate->setTimezone($tz);

                                        $end_date = new DateTime($tdate->format("Y-m-d H:i:s"));

                                        $difference = $end_date->diff($start_date);
                                        //diff eken date dekak adu karala wenasa ganna puluwan

                                        ?>

                                        <label class="form-label fs-4" style="color:#f5dabd;">
                                            <?php

                                            echo nl2br($difference->format('%Y') . "Years " . $difference->format('%m') . "Months " . $difference->format('%d') . "Days \n"
                                                . $difference->format('%H') . "Hours | " . $difference->format('%i') . "Minutes | " . $difference->format('%s') . "Seconds ", false);

                                            ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-9">
                        <div class="row">
                            <div style="background-color: #001f3d;">
                                <h1 class="p-3 text-center" style="color: white;">Dashboard</h1>
                            </div>

                            <div class="col-6 mt-5 rounded bg-body">
                                <div class="row">

                                    <?php
                                    $freq_rs = Database::search("SELECT product_id, `total` AS `value_occurance` FROM `invoice`
                                ORDER BY `value_occurance` DESC LIMIT 1");

                                    $freq_rows = $freq_rs->num_rows;

                                    if ($freq_rows > 0) {
                                        $freq_data = $freq_rs->fetch_assoc();

                                        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $freq_data["product_id"] . "'");
                                        $product_data = $product_rs->fetch_assoc();

                                        $seler_image_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $product_data["user_email"] . "'");
                                        $seler_image_data = $seler_image_rs->fetch_assoc();

                                        $seller_detail_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $product_data["user_email"] . "'");
                                        $seller_detail_data = $seller_detail_rs->fetch_assoc();

                                    ?>

                                        <div class="col-12 text-center">
                                            <label class="form-label fs-4 text-success">Most Successful Seller So Far</label><br>
                                            <span class="fs-6 text-danger">(Rs. <?php echo $freq_data["value_occurance"]; ?>.00 Earned Recently)</span><br>
                                        </div>
                                        <div class="col-12 text-center">
                                            <img src="<?php echo $seler_image_data["path"]; ?>" class="img-fluid rounded-top" style="height: 100px; margin-left: 0px;">
                                        </div>
                                        <div class="col-12 text-center my-2">

                                            <span class="fs-5 fw-bold"><?php echo $seller_detail_data["fname"] . " " . $seller_detail_data["lname"]; ?></span><br>
                                            <span class="fs-6"><?php echo $seller_detail_data["email"]; ?></span><br>
                                            <span class="fs-6"><?php echo $seller_detail_data["mobile"]; ?></span>
                                        </div>

                                    <?php

                                    } else {
                                    ?>

                                        <div class="col-12 text-center">
                                            <label class="form-label fs-4">Most Successful Seller</label>
                                        </div>
                                        <div class="col-12 text-center">
                                            <img src="resource/profile_image/403019_avatar_male_man_person_user_icon.png" class="img-fluid rounded-top" style="height: 250px; margin-left: 0px;">
                                        </div>
                                        <div class="col-12 text-center my-2">
                                            <span class="fs-5 fw-bold">_____</span><br>
                                            <span class="fs-6">____</span><br>
                                            <span class="fs-6">____</span>
                                        </div>

                                    <?php
                                    }
                                    ?>

                                </div>

                                <div class="col-6 offset-3 mt-5">
                                    <div class="row">
                                        <div class="col-12 text-white text-center rounded bg-danger">
                                            <br>
                                            <span class="fs-4">Total Users</span><br>

                                            <?php
                                            $user_rs = Database::search("SELECT * FROM `user`");
                                            $user_num = $user_rs->num_rows;
                                            ?>
                                            <span class="fs-5"><?php echo $user_num; ?> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 offset-1 mt-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row g-1">

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 text-center rounded" style="height:100px ;background-color: #001f3d0a; border:solid; border-width:1;">
                                                        <br>
                                                        <span class="fs-4">Daily Earnings</span><br>
                                                        <?php

                                                        $a = "0";
                                                        $b = "0";
                                                        $c = "0";
                                                        $e = "0";
                                                        $f = "0";

                                                        $invoice_rs = Database::search("SELECT * FROM `invoice`");
                                                        $invoice_rows = $invoice_rs->num_rows;

                                                        for ($x = 0; $x < $invoice_rows; $x++) {
                                                            $invoice_data = $invoice_rs->fetch_assoc();

                                                            $f = $f + $invoice_data["qty"];
                                                            //me wenakan okkoma qty eka gannawa 

                                                            $d = $invoice_data["date"];
                                                            $splitDate = explode(" ", $d);
                                                            //date time eka e deka athare thiyena ida use karala wen kara gannawa
                                                            $purchase_date = $splitDate[0];

                                                            if ($purchase_date == $today) {
                                                                $a = $a + $invoice_data["total"]; //today total selling
                                                                $c = $c + $invoice_data["qty"]; //today total qty
                                                            }

                                                            $splitMonth = explode("-", $purchase_date);
                                                            // date -> year  month  date widiyata wen karanwa
                                                            $purchase_year = $splitMonth[0];
                                                            $purchase_month = $splitMonth[1];

                                                            if ($purchase_year == $thisYear) {
                                                                if ($purchase_month == $thisMonth) {
                                                                    $b = $b + $invoice_data["total"]; //this month total selling
                                                                    $e = $e + $invoice_data["qty"]; //this month total qty
                                                                }
                                                            }
                                                        }

                                                        ?>
                                                        <span class="fs-5 fw-bold">Rs. <?php echo $a; ?> .00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 text-center rounded" style="height:100px ;background-color: #001f3d0a; border:solid; border-width:1;;">
                                                        <br>
                                                        <span class="fs-4">Monthly Earnings</span><br>
                                                        <span class="fs-5 fw-bold">Rs. <?php echo $b; ?> .00</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12  text-center rounded" style="height:100px ;background-color: #001f3d0a; border:solid; border-width:1;">
                                                        <br>
                                                        <span class="fs-4">Today Sellings</span><br>
                                                        <span class="fs-5 fw-bold"><?php echo $c; ?> items</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 text-center rounded" style="height:100px;background-color: #001f3d0a; border:solid; border-width:1; ;">
                                                        <br>
                                                        <span class="fs-4">Monthly Sellings</span><br>
                                                        <span class="fs-5 fw-bold"><?php echo $e; ?> items</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 text-center rounded" style="height:100px ;background-color: #001f3d0a; border:solid; border-width:1;;">
                                                        <br>
                                                        <span class="fs-4">Total Sellings</span><br>
                                                        <span class="fs-5 fw-bold"><?php echo $f; ?> items</span>
                                                    </div>
                                                </div>
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
    header('Location:http://localhost/auction/index.php');
}
    ?>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>

    </body>

    </html>