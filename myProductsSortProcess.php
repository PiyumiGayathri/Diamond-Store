<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $user = $_SESSION["user"]["email"];

    $search = $_POST["search"];
    $sortPrice = $_POST["ps"];
    $region = $_POST["r"];
    $shape = $_POST["s"];
    $condition = $_POST["c"];
    $time = $_POST["t"];

    $query = "SELECT * FROM `product` WHERE `user_email`='" . $user . "'";


    if (!empty($search)) {
        $query .= "AND `title` LIKE '%" . $search . "%'";
    }

    if (!empty($region)) {
        $query .= "AND `region_id`='" . $region . "'";
    }

    if (!empty($shape)) {
        $query .= "AND `cut_id`='" . $shape . "'";
    }

    if (!empty($condition)) {
        $query .= "AND `condition_id`='" . $condition . "'";
    }

    if ($time != "0") {
        if ($time == "1") {
            $query .= "ORDER BY `datetime_added` DESC ";
        } else if ($time == "2") {
            $query .= "ORDER BY `datetime_added` ASC ";
        }
    }

    if ($sortPrice == 1) {
        $query .= "ORDER BY `price` DESC ";
    } else if ($sortPrice == 2) {
        $query .= "ORDER BY `price` ASC ";
    }


?>

    <div class="offset-1 col-10 text-center">
        <div class="row justify-content-center">
            <?php

            if ("0" != $_POST["p"]) {
                $page_no = $_POST["p"];
            } else {
                $page_no =  1;
            }

            $product_rs = Database::search($query);
            $product_rows = $product_rs->num_rows;

            $products_per_page = 6;
            $number_of_pages = ceil($product_rows / $products_per_page);

            $page_results = ($page_no - 1) * $products_per_page;

            $selected_rs = Database::search($query . " LIMIT " . $products_per_page . " OFFSET " . $page_results . "");
            $selected_rows = $selected_rs->num_rows;

            for ($x = 0; $x < $selected_rows; $x++) {
                $selected_data = $selected_rs->fetch_assoc();

            ?>

                <!--product card -->

                <?php
                $products_rs = Database::search($query);
                $products_rows = $products_rs->num_rows;

                for ($x = 0; $x < $products_rows; $x++) {
                    $product_data = $products_rs->fetch_assoc();
                ?>
                    <!-- <div class="card mb-3 mt-3 p-3" style="max-width: 650px;">
                                                    <div class="row g-0">

                                                        <?php
                                                        $product_img_rs = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $product_data["id"] . "'");
                                                        $product_img_data = $product_img_rs->fetch_assoc();
                                                        ?>
                                                        <div class="col-md-4 mt-2">
                                                            <img src="<?php echo $product_img_data["code"]; ?>" class="img-fluid rounded-start">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card-body">
                                                                <h5 class="card-title fw-bold"><?php echo $product_data["title"]; ?></h5>
                                                                <p class="card-text">(<?php echo $product_data["description"]; ?>)</p>

                                                                <?php
                                                                $found_rs = Database::search("SELECT * FROM `region` WHERE `id`='" . $product_data["region_id"] . "'");
                                                                $found_data = $found_rs->fetch_assoc();
                                                                ?>

                                                                <span class="card-text ">Found in : <?php echo $found_data["name"]; ?></span> &nbsp;&nbsp;|&nbsp;&nbsp;

                                                                <?php
                                                                $shape_rs = Database::search("SELECT * FROM `cut` WHERE `id`='" . $product_data["cut_id"] . "'");
                                                                $shape_data = $shape_rs->fetch_assoc();
                                                                ?>

                                                                <span class="card-text">Shape : <?php echo $shape_data["name"]; ?></span><br>

                                                                <?php
                                                                $condition_rs = Database::search("SELECT * FROM `condition` WHERE `id`='" . $product_data["condition_id"] . "'");
                                                                $condition_data = $condition_rs->fetch_assoc();
                                                                ?>

                                                                <span class="card-text">Condition : <?php echo $condition_data["name"]; ?></span><br>

                                                                <span class="card-text fw-bold fs-5 text-success">Rs: <?php echo $product_data["price"]; ?> .00</span><br>
                                                                <span class="card-text text-primary"><?php echo $product_data["qty"]; ?> Items in Stock</span>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 p-1">
                                                            <div class="row">
                                                                <button class="col-12 btn btn-outline-dark mt-2 ">
                                                                    <i class="bi bi-bag-heart fs-5 p-2"></i>Buy
                                                                </button>
                                                                <button class="col-12 btn btn-outline-dark mt-3">
                                                                    <i class="bi bi-cart4 fs-5 p-2"></i>Cart
                                                                </button>
                                                                <button class="col-12 btn btn-outline-dark mt-3">
                                                                    <i class="bi bi-heart-fill fs-5 p-1"></i>Watchlist
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div> -->
                    <!--product card -->


                    <div class="card mb-3 mt-3 p-3" style="max-width: 500px;">
                        <div class="row g-0">
                            <div class="col-12 text-start text-danger fw-bold p-0 m-0">#<?php echo $product_data["id"]; ?></div>

                            <?php
                            $product_img_rs = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $product_data["id"] . "'");
                            $product_img_rows = $product_img_rs->num_rows;
                            $product_img_data = $product_img_rs->fetch_assoc();

                            if ($product_img_rows != 0) {
                            ?>
                                <div class="col-md-4 mt-2">
                                    <img src="<?php echo $product_img_data["code"]; ?>" class="img-fluid rounded-start">
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="col-md-4 mt-2" style="height: 100px; background-image: url('resource/gems/emptyGem.png'); background-position: center;background-size: contain;background-repeat: no-repeat;"></div>
                            <?php
                            }
                            ?>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="fd<?php echo $product_data["id"]; ?>" <?php
                                                                                                                                                    if ($selected_data["status_id"] == 2) {
                                                                                                                                                    ?> checked <?php
                                                                                                                                                                                    } ?> onclick="changeStatus(<?php echo $selected_data['id']; ?>);" />
                                        <label class="form-check-label fw-bold text-black-50" for="fd<?php echo $product_data["id"]; ?>">
                                            <?php
                                            if ($selected_data["status_id"] == 2) {
                                            ?>
                                                Make Your Product Active
                                            <?php

                                            } else {
                                            ?>
                                                Make Your Product Deactive
                                            <?php

                                            }

                                            ?>
                                        </label>
                                    </div>
                                    <h5 class="card-title fw-bold"><?php echo $product_data["title"]; ?></h5>

                                    <span class="card-text fw-bold fs-5 text-success">Rs: <?php echo $product_data["price"]; ?> .00</span><br>
                                    <span class="card-text text-primary"><?php echo $selected_data["qty"]; ?> Items in Stock</span>

                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4 offset-4">
                                    <button class="col-12 btn btn-outline-dark mt-3" onclick="product(<?php echo $product_data['id']; ?>);">
                                        <i class="bi bi-arrow-clockwise fs-5 p-2"></i>Update
                                    </button>
                                </div>
                                <div class="col-4">
                                    <button class="col-12 btn btn-outline-dark mt-3">
                                        <i class="bi bi-trash3 fs-5 p-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <!--product card -->

            <?php
            }
            ?>


        </div>
    </div>
    <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3 ">
        <nav aria-label="Page navigation example">
            <ul class="pagination pagination-lg justify-content-center">
                <li class="page-item">
                    <a class="page-link bg-body border border-dark" <?php

                                                                    if ($page_no <= 1) {
                                                                        echo "#";
                                                                    } else {
                                                                    ?> onclick="myProducts_sort('<?php echo ($page_no - 1); ?>');" <?php
                                                                                                                                                                        }
                                                                                                                                                                            ?> aria-label="Previous">
                        <span class="text-dark" aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                for ($x = 1; $x <= $number_of_pages; $x++) {
                    if ($x == $page_no) {
                ?>
                        <li class="page-item active">
                            <a class="page-link text-dark bg-light border border-dark" onclick="<?php echo $x; ?>"><?php echo $x; ?></a>
                        </li>
                    <?php

                    } else {
                    ?>
                        <li class="page-item ">
                            <a class="page-link text-white bg-dark border border-dark" onclick="<?php echo $x; ?>"><?php echo  $x; ?></a>
                        </li>
                <?php
                    }
                }
                ?>


                <li class="page-item">
                    <a class="page-link  bg-body border border-dark" <?php

                                                                        if ($page_no >= $number_of_pages) {
                                                                            echo "#";
                                                                        } else {
                                                                        ?> onclick="myProducts_sort('<?php echo ($page_no + 1); ?>');" <?php
                                                                                                                                                                        }
                                                                                                                                                                            ?> aria-label="Next">
                        <span aria-hidden="true" class="text-dark">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
    </div>
    <!-- product -->

<?php

} else {
    echo "Something Went Wrong!";
}
