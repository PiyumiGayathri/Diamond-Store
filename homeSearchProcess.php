<?php
require "connection.php";

$search = $_POST["s"];
$category_id = $_POST["c"];
$page = $_POST["p"];

$query = "SELECT * FROM `product`";

if (!empty($search) && $category_id == 0) {
    $query .= "WHERE `title` LIKE '%" . $search . "%'";
} else if ($category_id != 0 && empty($search)) {
    $query .= "WHERE `category_id`='" . $category_id . "' ";
} else if (!empty($search) && $category_id != 0) {
    $query .= "WHERE `title` LIKE '%" . $search . "%' AND `category_id`='" . $category_id . "'";
}

?>

<div class="col-12">
                                    <div class="row justify-content-center">
                                        <?php

                                        if ("0" != $page) {
                                            $page_no = $page;
                                        } else {
                                            $page_no = 1;
                                        }

                                        $product_rs = Database::search($query);
                                        $product_rows = $product_rs->num_rows;

                                        $products_per_page = 4;
                                        $number_of_pages = ceil($product_rows / $products_per_page);

                                        $page_results = ($page_no - 1) * $products_per_page;

                                        $selected_rs = Database::search($query . " LIMIT " . $products_per_page . " OFFSET " . $page_results . "");
                                        $selected_rows = $selected_rs->num_rows;

                                        for ($x = 0; $x < $selected_rows; $x++) {
                                            $selected_data = $selected_rs->fetch_assoc();

                                        ?>

                                            <!--product card -->

                                                <div class="col-6 card mb-3 mt-3 p-3" style="max-width: 650px;">
                                                    <div class="row g-0">
                                                        <div class="col-12 text-start text-danger fw-bold p-0 m-0">#<?php echo $selected_data["id"];?></div>

                                                        <?php
                                                        $product_img_rs = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $selected_data["id"] . "'");
                                                        $product_img_data = $product_img_rs->fetch_assoc();
                                                        ?>
                                                        <div class="col-md-4 mt-2">
                                                            <img src="<?php echo $product_img_data["code"]; ?>" class="img-fluid rounded-start">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card-body">
                                                                <h5 class="card-title fw-bold"><?php echo $selected_data["title"]; ?></h5>

                                                                <span class="card-text">Dimensions(mm) : <?php echo $selected_data["length"]; ?>(l) * <?php echo $selected_data["width"]; ?>(w) * <?php echo $selected_data["depth"]; ?>(d)</span><br>

                                                                <?php
                                                                $found_rs = Database::search("SELECT * FROM `region` WHERE `id`='" . $selected_data["region_id"] . "'");
                                                                $found_data = $found_rs->fetch_assoc();
                                                                ?>

                                                                <span class="card-text ">Found in : <?php echo $found_data["name"]; ?></span> &nbsp;&nbsp;|&nbsp;&nbsp;

                                                                <?php
                                                                $shape_rs = Database::search("SELECT * FROM `cut` WHERE `id`='" . $selected_data["cut_id"] . "'");
                                                                $shape_data = $shape_rs->fetch_assoc();
                                                                ?>

                                                                <span class="card-text">Shape : <?php echo $shape_data["name"]; ?></span><br>

                                                                <?php
                                                                $condition_rs = Database::search("SELECT * FROM `condition` WHERE `id`='" . $selected_data["condition_id"] . "'");
                                                                $condition_data = $condition_rs->fetch_assoc();
                                                                ?>

                                                                <span class="card-text">Condition : <?php echo $condition_data["name"]; ?></span><br>

                                                                <span class="card-text fw-bold fs-5 text-success">Rs: <?php echo $selected_data["price"]; ?> .00</span><br>
                                                                <span class="card-text text-primary"><?php echo $selected_data["qty"]; ?> Items in Stock</span>

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
                                                </div>
                                            

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
                                                                                                            ?>
                                                                                                            onclick="homeSearch(<?php echo($page_no - 1);?>);"
                                                                                                            <?php
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
                                                        <a class="page-link text-white bg-dark border border-dark" onclick="homeSearch(<?php echo $x;?>);"><?php echo $x; ?></a>
                                                    </li>
                                                <?php

                                                } else {
                                                ?>
                                                    <li class="page-item ">
                                                        <a class="page-link text-white bg-dark border border-dark" onclick="homeSearch(<?php echo $x;?>);"><?php echo  $x; ?></a>
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
                                                                                                            ?>
                                                                                                            onclick="homeSearch(<?php echo ($page_no + 1) ;?>);"
                                                                                                            <?php
                                                                                                        }
                                                                                                        ?> aria-label="Next">
                                                    <span aria-hidden="true" class="text-dark">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>