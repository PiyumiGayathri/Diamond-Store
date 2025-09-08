<?php
require "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products | Admins | Diamond</title>

    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="resource/logo_title.png">
</head>

<body style="background-color: #001f3d;">

    <div class="container-fluid" id="a">
        <div class="row">
            <div class=" col-12 text-center">
                <label class="form-label text-white fs-1 mt-4">Manage Products</label>
            </div>

            <div class="col-12 mt-3">
                <div class="row">
                    <div class="offset-0 offset-lg-3 col-12 col-lg-6 mb-3">
                        <div class="row">
                            <div class="col-9">
                                <input type="text" class="form-control" placeholder="Search by product name" id="product">
                            </div>
                            <div class="col-3 d-grid">
                                <button class="btn btn-info" onclick="searchProduct();">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" id="table">
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

                    $product_rs = Database::search($query);
                    $product_rows = $product_rs->num_rows;

                    $products_per_page = 8;
                    $number_of_pages = ceil($product_rows / $products_per_page);

                    $page_results = ($page_no - 1) * $products_per_page;

                    $selected_rs = Database::search($query . " LIMIT " . $products_per_page . " OFFSET " . $page_results . "");
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




            <!--  -->
            <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-lg justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="<?php

                                                        if ($page_no <= 1) {
                                                            echo "#";
                                                        } else {
                                                            echo "?page=" . ($page_no - 1);
                                                        }
                                                        ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php
                        for ($x = 1; $x <= $number_of_pages; $x++) {
                            if ($x == $page_no) {
                        ?>
                                <li class="page-item active">
                                    <a class="page-link" href="<?php
                                                                echo "?page=" . $x;
                                                                ?>"><?php echo $x; ?></a>
                                </li>
                            <?php

                            } else {
                            ?>
                                <li class="page-item ">
                                    <a class="page-link" href="<?php
                                                                echo "?page=" . $x;
                                                                ?>"><?php echo  $x; ?></a>
                                </li>
                        <?php
                            }
                        }
                        ?>


                        <li class="page-item">
                            <a class="page-link" href="<?php

                                                        if ($page_no >= $number_of_pages) {
                                                            echo "#";
                                                        } else {
                                                            echo "?page=" . ($page_no + 1);
                                                        }
                                                        ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>


            <hr />

            <div class="col-12 bg-light">
                <div class="row">
                    <div class="col-12 text-center mt-3">
                        <h3 class=" fw-bold text-black-50"><i class="bi bi-gem p-2"></i>Manage Categories</h3>
                    </div>

                    <div class="col-12 mb-3 mt-3">
                        <div class="row gap-1 justify-content-center">

                            <?php
                            $category_rs = Database::search("SELECT * FROM `category`");
                            $category_num = $category_rs->num_rows;
                            for ($x = 0; $x < $category_num; $x++) {
                                $category_data = $category_rs->fetch_assoc();
                            ?>
                                <div class="col-12 col-lg-3 border border rounded" style="height: 50px;">
                                    <div class="row">
                                        <div class="col-8 mt-2 mb-2">
                                            <label class="form-label fs-5"><i class="bi bi-gem p-2"></i><?php echo $category_data["name"]; ?></label>
                                        </div>
                                        <div class="col-4  text-center mt-2 mb-2">
                                            <label class="form-label fs-4"><i class="bi bi-trash3-fill text-danger"></i></label>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <div class="col-12 col-lg-3 border border-success rounded mt-2" style="height: 50px;" onclick="addNewCategory();">
                                <div class="row">
                                    <div class="col-8 mt-2 mb-2">
                                        <label class="form-label fw-bold fs-5">Add New</label>
                                    </div>
                                    <div class="col-4 text-center mt-2 mb-2">
                                        <label class="form-label fs-4"><i class="bi bi-plus-square-fill text-success"></i></label>
                                    </div>

                                </div>
                            </div>
                            <!-- model2 -->
                            <div class="modal" tabindex="-1" id="addCategoryModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add New Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-12">
                                                <label class="form-label">New Category Name : </label>
                                                <input type="text" class="form-control" id="n">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" onclick="confirmCategory();">Save New Category</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- model2 -->
                        </div>
                    </div>
                </div>
            </div>

            <script src="bootstrap.bundle.js"></script>
            <script src="script.js"></script>
</body>

</html>
