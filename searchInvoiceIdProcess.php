<?php
require "connection.php";

if (isset($_GET["id"])) {
    $searching_invoice_id = $_GET["id"];

    $invoice_rs = Database::search("SELECT DISTINCT * FROM `invoice` WHERE `id`= '" . $searching_invoice_id . "'");
    $invoice_rows = $invoice_rs->num_rows;

    if ($invoice_rows == 1) {
        $invoice_data = $invoice_rs->fetch_assoc();
?>

        <div class="col-12" id="table">
            <div class="row">

                <div class="col-12 mt-3 ">
                    <div class="row">
                        <div class="col-4 col-lg-2 bg-light py-2  text-center">
                            <span class="fw-bold">Invoice ID</span>
                        </div>
                        <div class="col-2 bg-light col-lg-2  py-2 text-center">
                            <span class="fw-bold">Product</span>
                        </div>
                        <div class="col-2 d-none d-lg-block bg-light py-2 col-lg-2  text-center">
                            <span class="fw-bold">Buyer</span>
                        </div>
                        <div class="col-4 col-lg-2 bg-light py-2  text-center">
                            <span class="fw-bold">Amount</span>
                        </div>
                        <div class="col-4 bg-light py-2 text-center col-lg-2 d-none d-lg-block">
                            <span class="fw-bold">Qty</span>
                        </div>
                        <div class="col-2 bg-light col-lg-2  py-2 text-center">
                            <span class="fw-bold">Status</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 border border-1 border-dark">
                    <div class="row">
                        <div class="col-4 col-lg-2 bg-light py-2 text-center">
                            <span class="fw-bold "><?php echo $invoice_data["id"]; ?></span>
                        </div>
                        <?php
                        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $invoice_data["product_id"] . "'");
                        $product_data = $product_rs->fetch_assoc();
                        ?>
                        <div class="col-2 col-lg-2 bg-light py-2 text-center">
                            <span><?php echo $product_data["title"]; ?></span>
                        </div>
                        <?php
                        $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $invoice_data["user_email"] . "'");
                        $user_data = $user_rs->fetch_assoc();
                        ?>

                        <div class="col-4 col-lg-2 bg-light py-2 text-center  d-none d-lg-block">
                            <span><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></span>
                        </div>
                        <div class="col-4 col-lg-2 bg-light py-2 text-center">
                            <span>Rs. <?php echo $invoice_data["total"]; ?>. 00</span>
                        </div>
                        <div class="col-2 bg-light py-2 text-center d-none d-lg-block">
                            <span><?php echo $invoice_data["qty"]; ?></span>
                        </div>
                        <div class="col-2 col-lg-2 bg-light py-2 d-grid">
                            <?php
                            if ($invoice_data["status"] == 0) {
                            ?>
                                <button class="btn btn-success fw-bold mt-1 mb-1" id="btn<?php echo $invoice_data['id']; ?>" onclick="changestatus('<?php echo $invoice_data['id']; ?>');">Confirm Order</button>
                            <?php
                            } else if ($invoice_data["status"] == 1) {

                            ?>
                                <button class="btn btn-warning fw-bold mt-1 mb-1" id="btn<?php echo $invoice_data['id']; ?>" onclick="changestatus('<?php echo $invoice_data['id']; ?>');">Packing</button>
                            <?php

                            } else if ($invoice_data["status"] == 2) {
                            ?>
                                <button class="btn btn-info fw-bold mt-1 mb-1" id=" btn<?php echo $invoice_data['id']; ?>" onclick="changestatus('<?php echo $invoice_data['id']; ?>');">Dispatch</button>
                            <?php
                            } else if ($invoice_data["status"] == 3) {

                            ?>
                                <button class=" btn btn-primary fw-bold mt-1 mb-1" id="btn<?php echo $invoice_data['id']; ?>" onclick="changestatus('<?php echo $invoice_data['id']; ?>');">Shipping</button>
                            <?php

                            } else if ($invoice_data["status"] == 4) {

                            ?>
                                <button class=" btn btn-danger fw-bold mt-1 mb-1 disabled" id="btn<?php echo $invoice_data['id']; ?>" onclick="changestatus('<?php echo $invoice_data['id']; ?>');">Delivered</button>
                            <?php

                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
?>