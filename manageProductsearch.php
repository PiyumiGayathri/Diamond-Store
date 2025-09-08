<?php

require "connection.php";

$query1 = "SELECT * FROM `product`";
if (isset($_POST["product"])) {
    $query1 .= "WHERE `title` LIKE '%" . $_POST["product"] . "%'";
}

?>

<div class="col-12">
    <div class="row">

        <div class="col-12 mt-3 ">
            <div class="row">
                <div class="col-2 col-lg-1 bg-light py-2 text-center">
                    <span class="fw-bold">Product_ID</span>
                </div>
                <div class="col-2 d-none d-lg-block bg-light py-2  text-center">
                    <span class="fw-bold">Image</span>
                </div>
                <div class="col-4 col-lg-2 bg-light py-2 text-center">
                    <span class="fw-bold">Title</span>
                </div>
                <div class="col-4 col-lg-2 bg-light py-2  text-center">
                    <span class="fw-bold">Price</span>
                </div>
                <div class="col-2 bg-light py-2 d-none d-lg-block text-center">
                    <span class="fw-bold">Qty</span>
                </div>
                <div class="col-2 bg-light  py-2 d-none d-lg-block  text-center">
                    <span class="fw-bold">Registered Date</span>
                </div>
                <div class="col-2 col-lg-1 bg-light text-center">
                    <span class="fw-bold">Block / Unblock</span>
                </div>
            </div>
        </div>

        <?php

        $query = "SELECT * FROM `product`";
        $page_no;

        if (isset($_GET["page"])) {
            $page_no = $_GET["page"];
        } else {
            $page_no = 1;
        }

        $product_rs = Database::search($query1);
        $product_rows = $product_rs->num_rows;

        $products_per_page = 8;
        $number_of_pages = ceil($product_rows / $products_per_page);

        $page_results = ($page_no - 1) * $products_per_page;

        $selected_rs = Database::search($query1 . " LIMIT " . $products_per_page . " OFFSET " . $page_results . "");
        var_dump($selected_rs);
        $selected_rows = $selected_rs->num_rows;

        for ($x = 0; $x < $selected_rows; $x++) {
            $selected_data = $selected_rs->fetch_assoc();
        ?>
            <div class="col-12 border border-1 border-dark">
                <div class="row">
                    <div class="col-2 col-lg-1 bg-light py-2 text-center">
                        <span class="fw-bold "><?php echo $selected_data['id']; ?></span>
                    </div>
                    <div class="col-2 bg-light py-2 d-none d-lg-block" onclick="viewProductModal(<?php echo $selected_data['id']; ?>);">
                                    <?php
                                    $image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $selected_data["id"] . "'");
                                    $image_num = $image_rs->num_rows;
                                    if ($image_num == 0) {
                                    ?>
                                        <img src="resource/gems/emptyGem.png" style="height: 40px;margin-left: 80px;" />
                                    <?php
                                    } else {
                                        $image_data = $image_rs->fetch_assoc();
                                    ?>
                                        <img src="<?php echo $image_data["code"]; ?>" style="height: 40px;margin-left: 80px;" />
                                    <?php
                                    }

                                    ?>
                                </div>
                    <div class="col-4 col-lg-2 bg-light py-2 text-center">
                        <span><?php echo $selected_data["title"]; ?></span>
                    </div>
                    <div class="col-4 col-lg-2 bg-light py-2 text-center">
                        <span><?php echo $selected_data["price"]; ?></span>
                    </div>
                    <div class="col-2 bg-light py-2 text-center d-none d-lg-block">
                        <span><?php echo $selected_data["qty"]; ?></span>
                    </div>
                    <div class="col-2 bg-light py-2 text-center d-none d-lg-block">
                        <span><?php echo $selected_data["datetime_added"]; ?></span>
                    </div>
                    <div class="col-2 col-lg-1 bg-light py-2 d-grid">
                        <?php
                        if ($selected_data["status_id"] == 1) {
                        ?>
                            <button class="btn btn-outline-danger" id="pb<?php echo $selected_data['id']; ?>" onclick="blockProduct('<?php echo $selected_data['id']; ?>');">Block</button>
                        <?php
                        } else {

                        ?>
                            <button class="btn btn--outline-success" id="pb<?php echo $selected_data['id']; ?>" onclick="blockProduct('<?php echo $selected_data['id']; ?>');">Unblock</button>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </div>

            <!-- modal 1 -->
            <div class="modal" tabindex="-1" id="viewProductModal<?php echo $selected_data["id"]; ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold text-primary"><?php echo $selected_data["title"]; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="offset-4 col-4">
                                <?php
                                $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $selected_data["id"] . "'");
                                $img_data = $img_rs->fetch_assoc();
                                ?>
                                <img src="<?php echo $img_data["code"]; ?>" class="img-fluid" style="height: 150px;" />
                            </div>
                            <div class="col-12">
                                <span class="fs-5 fw-bold">Product ID :</span>&nbsp;
                                <span class="fs-5 text-danger"><?php echo $selected_data["id"]; ?></span><br />
                                <span class="fs-5 fw-bold">Price :</span>&nbsp;
                                <span class="fs-5">Rs. <?php echo $selected_data["price"]; ?> .00</span><br />
                                <span class="fs-5 fw-bold">Quantity :</span>&nbsp;
                                <span class="fs-5"><?php echo $selected_data["qty"]; ?> Products</span><br />
                                <span class="fs-5 fw-bold">Seller :</span>&nbsp;
                                <?php
                                $seller_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $selected_data["user_email"] . "'");
                                $seller_data = $seller_rs->fetch_assoc();
                                ?>
                                <span class="fs-5"><?php echo $seller_data["fname"] . " " . $seller_data["lname"]; ?></span><br />
                                <span class="fs-5 fw-bold">Description :</span>&nbsp;
                                <span class="fs-5"><?php echo $selected_data["description"]; ?></span><br />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal 1 -->

        <?php
        }

        ?>

    </div>
</div>