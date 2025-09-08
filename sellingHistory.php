<?php
require "connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selling History | Diamond</title>

    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="resource/logo_title.png">
</head>

<body style="background-color: #001f3d;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="text-white mt-4">Selling History</h1>
            </div>

            <div class="col-10 offset-1 bg-light mt-3 mb-3 p-2">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label class="form-label">Search by Invoice ID : </label>
                        <input type="text" class="form-control " id="searchTxt" onkeyup="searchInvoiceId();">
                    </div>
                    <div class="col-12 col-lg-2 offset-lg-1"></div>
                    <div class="col-12 col-lg-3">
                        <label class="form-label text-danger">From Date : </label>
                        <input type="date" class="form-control" id="fDate">
                    </div>
                    <div class="col-12 col-lg-3">
                        <label class="form-label text-danger">To Date : </label>
                        <input type="date" class="form-control" id="tDate">
                    </div>

                    <div class="col-12 col-lg-8 offset-lg-2 mt-3 d-grid mb-2">
                        <button class="btn btn-primary " onclick="findSellings();">Find Selling</button>
                    </div>
                </div>
            </div>
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

                    <?php

                    $query = "SELECT * FROM `invoice`";
                    $page_no;

                    if (isset($_GET["page"])) {
                        $page_no = $_GET["page"];
                    } else {
                        $page_no = 1;
                    }

                    $invoice_rs = Database::search($query);
                    $invoice_num = $invoice_rs->num_rows;

                    $results_per_page = 20;
                    $number_of_pages = ceil($invoice_num / $results_per_page);

                    $page_results = ($page_no - 1) * $results_per_page;

                    $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

                    $selected_num = $selected_rs->num_rows;

                    for ($x = 0; $x < $selected_num; $x++) {
                        $selected_data = $selected_rs->fetch_assoc();
                    ?>

                        <div class="col-12 border border-1 border-dark" id="viewing">
                            <div class="row">
                                <div class="col-4 col-lg-2 bg-light py-2 text-center">
                                    <span class="fw-bold "><?php echo $selected_data["id"]; ?></span>
                                </div>
                                <?php
                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $selected_data["product_id"] . "'");
                                $product_data = $product_rs->fetch_assoc();
                                ?>
                                <div class="col-2 col-lg-2 bg-light py-2 text-center">
                                    <span><?php echo $product_data["title"]; ?></span>
                                </div>
                                <?php
                                $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $selected_data["user_email"] . "'");
                                $user_data = $user_rs->fetch_assoc();
                                ?>

                                <div class="col-4 col-lg-2 bg-light py-2 text-center  d-none d-lg-block">
                                    <span><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></span>
                                </div>
                                <div class="col-4 col-lg-2 bg-light py-2 text-center">
                                    <span>Rs. <?php echo $selected_data["total"]; ?>. 00</span>
                                </div>
                                <div class="col-2 bg-light py-2 text-center d-none d-lg-block">
                                    <span><?php echo $selected_data["qty"]; ?></span>
                                </div>
                                <div class="col-2 col-lg-2 bg-light py-2 d-grid">
                                    <?php
                                    if ($selected_data["status"] == 0) {
                                    ?>
                                        <button class="btn btn-success fw-bold mt-1 mb-1" id="btn<?php echo $selected_data['id']; ?>" onclick="changestatus('<?php echo $selected_data['id']; ?>');">Confirm Order</button>
                                    <?php
                                    } else if ($selected_data["status"] == 1) {

                                    ?>
                                        <button class="btn btn-warning fw-bold mt-1 mb-1" id="btn<?php echo $selected_data['id']; ?>" onclick="changestatus('<?php echo $selected_data['id']; ?>');">Packing</button>
                                    <?php

                                    } else if ($selected_data["status"] == 2) {
                                    ?>
                                        <button class="btn btn-info fw-bold mt-1 mb-1" id=" btn<?php echo $selected_data['id']; ?>" onclick="changestatus('<?php echo $selected_data['id']; ?>');">Dispatch</button>
                                    <?php
                                    } else if ($selected_data["status"] == 3) {

                                    ?>
                                        <button class=" btn btn-primary fw-bold mt-1 mb-1" id="btn<?php echo $selected_data['id']; ?>" onclick="changestatus('<?php echo $selected_data['id']; ?>');">Shipping</button>
                                    <?php

                                    } else if ($selected_data["status"] == 4) {

                                    ?>
                                        <button class=" btn btn-danger fw-bold mt-1 mb-1 disabled" id="btn<?php echo $selected_data['id']; ?>" onclick="changestatus('<?php echo $selected_data['id']; ?>');">Delivered</button>
                                    <?php

                                    }
                                    ?>

                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

                </div>
            </div>
            <div class=" offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3 mt-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-lg justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="
                                                <?php if ($page_no <= 1) {
                                                    echo ("#");
                                                } else {
                                                    echo "?page=" . ($page_no - 1);
                                                } ?>
                                                " aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php

                        for ($x = 1; $x <= $number_of_pages; $x++) {
                            if ($x == $page_no) {
                        ?>
                                <li class="page-item active">
                                    <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                </li>
                        <?php
                            }
                        }

                        ?>

                        <li class="page-item">
                            <a class="page-link" href="
                                                <?php if ($page_no >= $number_of_pages) {
                                                    echo ("#");
                                                } else {
                                                    echo "?page=" . ($page_no + 1);
                                                } ?>
                                                " aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>


                    </ul>
                </nav>
            </div>

        </div>

    </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>