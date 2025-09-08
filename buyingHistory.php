<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buying History | Diamond</title>

    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="resource/logo_title.png">
</head>

<body>
    <div class="Container-fluid" style="background-color: #001f3d;">
        <div class="row">
            <?php

            include "header.php";

            if (isset($_SESSION["user"])) {
                $umail = $_SESSION["user"]["email"];

                $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `user_email`='$umail'");
                $invoice_rows = $invoice_rs->num_rows;

            ?>


                <div class="col-12 text-center mb-3 mt-3">
                    <span class="" style="font-size: 50px;color: white;">Purchasing History</span>
                </div>

                <?php
                if ($invoice_rows == 0) {
                ?>
                    <div class="col-12 bg-body text-center bg-light" style="height: 450px ;">
                        <span class="fs-1 fw-bolder text-black-50 d-block" style="margin-top: 200px;">You have not purchased any product yet...</span>
                    </div>
                <?php
                } else {

                ?>
                    <div class="col-12 p-lg-5">
                        <div class="row">
                            <div class="col-12  d-lg-block bg-light">
                                <div class="row">
                                    <div class="col-2 col-lg-1 border border-1 border-dark text-center p-2">
                                        <label class="form-label fw-bold ">ID</label>
                                    </div>
                                    <div class="col-4 col-lg-4 border border-1 border-dark d-none d-lg-block p-2">
                                        <label class="form-label fw-bold">Order Details</label>
                                    </div>
                                    <div class="col-2 col-lg-1 text-end border border-1 border-dark p-2">
                                        <label class="form-label fw-bold">Qty</label>
                                    </div>
                                    <div class="col-4 col-lg-2 text-end border border-1 border-dark p-2">
                                        <label class="form-label fw-bold">Amount</label>
                                    </div>
                                    <div class="col-2 col-lg-2 text-center border border-1 border-dark d-none d-lg-block p-2">
                                        <label class="form-label fw-bold">Purchase Date & Time</label>
                                    </div>
                                    <div class="col-4 col-lg-2 border border-1 border-dark text-center p-2">
                                        <label class="form-label fw-bold ">Action</label>
                                    </div>
                                </div>
                            </div>

                            <?php
                            for ($x = 0; $x < $invoice_rows; $x++) {
                                $invoice_data = $invoice_rs->fetch_assoc();

                            ?>
                                <div class="col-12 bg-light">
                                    <div class="row">
                                        <div class="col-2 col-lg-1 text-center text-lg-start border border-1 border-dark">
                                            <label class="form-label fs-6 py-5"><?php echo $invoice_data["id"]; ?></label>
                                        </div>

                                        <div class="col-12 col-lg-4 border border-1 border-dark d-none d-lg-block">
                                            <div class="card mx-0 mx-lg-3 my-3" style="max-width: 540px;">
                                                <div class="row g-0">

                                                    <?php
                                                    $product_id = $invoice_data["product_id"];
                                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $invoice_data["product_id"] . "'");
                                                    $product_data = $product_rs->fetch_assoc();
                                                    ?>
                                                    <label class="p-2 text-danger"># <?php echo $product_id; ?></label>
                                                    <div class="col-md-4 d-none d-lg-block">
                                                        <?php
                                                        $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $invoice_data["product_id"] . "'");
                                                        $img_data = $img_rs->fetch_assoc();

                                                        if ($img_rs->num_rows > 0) {
                                                        ?>
                                                            <img src="<?php echo $img_data["code"]; ?>" class="img-fluid rounded-start p-1">
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <img src="resource/gems/emptyGem.png" class="img-fluid rounded-start p-3">
                                                        <?php
                                                        }
                                                        ?>

                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?php echo $product_data["title"]; ?></h5>
                                                            <?php
                                                            $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $product_data["user_email"] . "'");
                                                            $user_data = $user_rs->fetch_assoc();
                                                            ?>
                                                            <p class="card-text"><b>Seller : </b><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></p>
                                                            <p class="card-text"><b>Price : </b>Rs. <?php echo $product_data["price"]; ?>. 00</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-2 col-lg-1 text-center text-lg-end border border-1 border-dark">
                                            <label class="form-label fs-4 py-5">1</label>
                                        </div>
                                        <div class="col-4 col-lg-2  text-center text-lg-end border border-1 border-dark">
                                            <label class="form-label fs-5 py-5 "><?php echo $invoice_data["total"]; ?>. 00</label>
                                        </div>
                                        <div class="col-12 col-lg-2 text-center border border-1 border-dark d-none d-lg-block">
                                            <label class="form-label fs-5 py-5"><?php echo $invoice_data["date"]; ?></label>
                                        </div>
                                        <div class="col-4 col-lg-2 border border-1 border-dark">
                                            <div class="row">
                                                <button class="col-10 col-lg-10 offset-1 offset-lg-1 btn btn-outline-dark mt-3 mt-lg-5 " onclick="openFeedback(<?php echo $invoice_data['id']; ?>);">
                                                    <i class="bi bi-info-circle-fill"></i> Feedback
                                                </button>
                                                <!-- <button class="col-10 col-lg-10 offset-1 offset-lg-1 btn btn-outline-dark mt-1" onclick="deleteProduct(<?php echo $invoice_data['product_id']; ?>);">
                                                    <i class="bi bi-trash3-fill"></i> Delete
                                                </button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal -->
                                <div class="modal" tabindex="-1" id="feedbackModal<?php echo $invoice_data['id']; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add New feedback</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-9">
                                                                        <div class="col-3">
                                                                            <label class="form-label fw-bold">User email</label>
                                                                        </div>
                                                                        <div class="col-9">
                                                                            <input type="text" class="form-control" value="<?php echo $umail; ?>">
                                                                        </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <label class="form-label fw-bold">Feedback</label>
                                                                </div>
                                                                <div class="col-9">
                                                                    <textarea id="feed<?php echo $invoice_data['id']; ?>" cols="50" rows="8" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <div class="row">
                                                                <div class="col-3 mt-3">
                                                                    <label class="form-label fw-bold">Add Images</label>
                                                                </div>
                                                                <div class="col-12 mt-4 p-4">
                                                                    <div class="row gap-2">
                                                                        <div class="col-3 border border-2 rounded">
                                                                            <img src="resource/gems/emptyGem.png" class="img-fluid" id="p0">
                                                                        </div>
                                                                        <div class="col-3 border border-2 rounded">
                                                                            <img src="resource/gems/emptyGem.png" class="img-fluid" id="p1">
                                                                        </div>
                                                                        <div class="col-3 border border-2 rounded">
                                                                            <img src="resource/gems/emptyGem.png" class="img-fluid" id="p2">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 offset-2 mt-3">
                                                                    <input type="file" class="d-none" id="imageUploader<?php echo $invoice_data['id']; ?>" multiple>
                                                                    <label for="imageUploader<?php echo $invoice_data['id']; ?>" class="col-12 btn btn-info" onclick="changeFeedbackImage();">Upload Images</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" onclick="saveFeedback(<?php echo $invoice_data['id']; ?>);">Save Feedback</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal -->
                            <?php

                            }
                            ?>

                            <div class="col-12">
                                <hr>
                            </div>


                        </div>
                    </div>
                <?php
                }
                ?>


            <?php

            }

            ?>

            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>