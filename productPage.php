<?php
session_start();
require "connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page | Diamond</title>

    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="resource/logo_title.png">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <div class="row">

                    <?php

                    if (isset($_GET["c_id"])) {
                        $product_category_id = $_GET["c_id"];

                    ?>

                        <div class="col-12 col-lg-2 my-3 border px-2 rounded bg-light">
                            <div class="row">
                                <div class="col-12 fs-5 p-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class=" form-label fw-bold">Search in Detail</label>
                                        </div>
                                        <div class="col-11">
                                            <div class="row">
                                                <div class="col-10">
                                                    <input type="text" placeholder="Search by keyword..." class="form-control" id="search">
                                                </div>
                                                <div class="col-1 p-1">
                                                    <label class="form-label"><i class="bi bi-search fs-5"></i></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <hr>
                                        </div>


                                        <div class="col-12">
                                            <label class="form-label fw-bold text-black-50" style="font-size: 16px;" id="t">Price</label>
                                        </div>
                                        <div class="row">

                                            <div class="col-6 mb-2 mt-2">
                                                <input type="text" class="form-control" placeholder="From" id="pf">
                                            </div>

                                            <div class="col-6 mb-2 mt-2">
                                                <input type="text" class="form-control" placeholder="To" id="pt">
                                            </div>

                                        </div>

                                        <div class="col-12 bg-body rounded mb-2">
                                            <div class="row">
                                                <div class="col-12 mt-2 mb-2">
                                                    <select class="form-select border border-2 " id="ps">
                                                        <option value="0">Sort Price</option>
                                                        <option value="1">Price High to Low</option>
                                                        <option value="2">Price Low to High</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <hr>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold text-black-50" style="font-size: 16px;" id="t">Dimensions (mm)</label>
                                        </div>
                                        <div class="row">

                                            <div class="col-6 mb-2 mt-2">
                                                <input type="text" class="form-control" placeholder="length" id="length">
                                            </div>

                                            <div class="col-6 mb-2 mt-2">
                                                <input type="text" class="form-control" placeholder="width" id="width">
                                            </div>

                                            <div class="col-6 mb-2 mt-2">
                                                <input type="text" class="form-control" placeholder="depth" id="depth">
                                            </div>

                                        </div>

                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-black-50" style="font-size: 16px;">Region</label>
                                        </div>
                                        <div class="col-8 offset-1">
                                            <div class="row">

                                                <select id="region" class="form-select">
                                                    <option value="0">Select Region</option>
                                                    <?php
                                                    $region_rs1 = Database::search("SELECT * FROM `region`");
                                                    $region_rows1 = $region_rs1->num_rows;
                                                    for ($x = 0; $x < $region_rows1; $x++) {
                                                        $region_data1 = $region_rs1->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $region_data1["id"]; ?>"><?php echo $region_data1["name"]; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-black-50" style="font-size: 16px;">Shape</label>
                                        </div>
                                        <div class="col-8 offset-1">
                                            <div class="row">

                                                <select id="shape" class="form-select">
                                                    <option value="0">Select Shape</option>
                                                    <?php
                                                    $cut_rs = Database::search("SELECT * FROM `cut`");
                                                    $cut_rows = $cut_rs->num_rows;
                                                    for ($x = 0; $x < $cut_rows; $x++) {
                                                        $cut_data = $cut_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $cut_data["id"]; ?>"><?php echo $cut_data["name"]; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-black-50" style="font-size: 16px;">By Condition</label>
                                        </div>
                                        <div class="col-8 offset-1">
                                            <div class="row">

                                                <select id="condition" class="form-select">
                                                    <option value="0">Select Condition</option>
                                                    <?php
                                                    $condition_rs1 = Database::search("SELECT * FROM `condition`");
                                                    $condition_rows1 = $condition_rs1->num_rows;
                                                    for ($x = 0; $x < $condition_rows1; $x++) {
                                                        $condition_data1 = $condition_rs1->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $condition_data1["id"]; ?>"><?php echo $condition_data1["name"]; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-black-50" style="font-size: 16px;" id="t">Time Added</label>
                                        </div>

                                        <div class="col-12" style="font-size: 15px;">
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="n" name="time">
                                                    <label class="form-check-label" for="n">
                                                        Newest To Oldest
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="o" name="time">
                                                    <label class="form-check-label" for="o">
                                                        Oldest To Newest
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-12 text-center mt-3 mb-3">
                                            <div class="row g-2">
                                                <div class="col-12  col-lg-6 d-grid">
                                                    <button class="btn btn-outline-dark fw-bold" onclick="sortProduct(0,'<?php echo $product_category_id; ?>');">Sort</button>
                                                </div>
                                                <div class="col-12  col-lg-6 d-grid">
                                                    <button class="btn btn-outline-dark fw-bold" onclick="clearSort();">Clear</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- filer process -->

                        <!-- product -->
                        <div class="col-12 col-lg-10 mt-3 mb-3 p2 bg-white" id="productCard">
                            <div class="row" id="sort">
                                <div class="offset-1 col-10 text-center">
                                    <div class="row justify-content-center">
                                        <?php

                                        $page_no;

                                        if (isset($_GET["page"])) {
                                            $page_no = $_GET["page"];
                                        } else {
                                            $page_no = 1;
                                        }

                                        $product_rs = Database::search("SELECT * FROM `product` WHERE `category_id`='" . $product_category_id . "'");
                                        $product_rows = $product_rs->num_rows;

                                        $products_per_page = 4;
                                        $number_of_pages = ceil($product_rows / $products_per_page);

                                        $page_results = ($page_no - 1) * $products_per_page;

                                        $selected_rs = Database::search("SELECT * FROM `product` WHERE `category_id`='" . $product_category_id . "' LIMIT " . $products_per_page . " OFFSET " . $page_results . "");
                                        $selected_rows = $selected_rs->num_rows;

                                        for ($x = 0; $x < $selected_rows; $x++) {
                                            $selected_data = $selected_rs->fetch_assoc();

                                        ?>

                                            <!--product card -->


                                            <div class="card mb-3 mt-3 p-3" style="max-width: 650px;">
                                                <div class="row g-0">
                                                    <div class="col-12 text-start text-danger fw-bold p-0 m-0">#<?php echo $selected_data["id"]; ?></div>

                                                    <?php
                                                    $product_img_rs = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $selected_data["id"] . "'");
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

                                                            <?php
                                                            if ($selected_data["qty"] > 0) {
                                                            ?>
                                                                <button class="col-12 btn btn-outline-dark mt-2 "  onclick="window.location.replace('singleProduct.php?id='+<?php echo $selected_data['id'] ;?>);">
                                                                    <i class="bi bi-bag-heart fs-5 p-2"></i>Buy
                                                                </button>
                                                                <button class="col-12 btn btn-outline-dark mt-3" onclick='addToCart(<?php echo $selected_data["id"]; ?>);'>
                                                                    <i class="bi bi-cart4 fs-5 p-2"></i>Cart
                                                                </button>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <button class="col-12 btn btn-outline-dark mt-2 " onclick="alert('This product is out of stock!');">
                                                                    <i class="bi bi-bag-heart fs-5 p-2"></i>Buy
                                                                </button>
                                                                <button class="col-12 btn btn-outline-dark mt-3" onclick="alert('This product is out of stock!');">
                                                                    <i class="bi bi-cart4 fs-5 p-2"></i>Cart
                                                                </button>

                                                            <?php
                                                            }


                                                            if (isset($_SESSION["user"])) {
                                                                $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `product_id` = '" . $selected_data["id"] . "' AND
                                                                `user_email` = '" . $_SESSION["user"]["email"] . "'");
                                                                $watchlist_rows = $watchlist_rs->num_rows;

                                                                if ($watchlist_rows == 1) {
                                                            ?>
                                                                    <button class="col-12 btn border border-dark mt-3" onclick='addToWatchlist(<?php echo $selected_data["id"]; ?>);'>
                                                                        <i class="bi bi-heart-fill fs-5 p-1 text-danger" id='heart(<?php echo $selected_data["id"]; ?>)'></i>Watchlist
                                                                    </button>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <button class="col-12 btn border border-dark mt-3" onclick='addToWatchlist(<?php echo $selected_data["id"]; ?>);'>
                                                                        <i class="bi bi-heart-fill fs-5 p-1" id='heart(<?php echo $selected_data["id"]; ?>)'></i>Watchlist
                                                                    </button>
                                                                <?php
                                                                }

                                                                ?>
                                                            <?php

                                                            } else {
                                                            ?>
                                                                <button class="col-12 btn mt-2 border border-dark" onclick='window.location="index.php";'>
                                                                    <i class="bi bi-heart-fill text-dark fs-5 p-1"></i>Watchlist
                                                                </button>
                                                            <?php
                                                            }
                                                            ?>
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
                                                <a class="page-link bg-body border border-dark" href="<?php

                                                                                                        if ($page_no <= 1) {
                                                                                                            echo "#";
                                                                                                        } else {
                                                                                                            echo "?page=" . ($page_no - 1);
                                                                                                        }
                                                                                                        ?>" aria-label="Previous">
                                                    <span class="text-dark" aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <?php
                                            for ($x = 1; $x <= $number_of_pages; $x++) {
                                                if ($x == $page_no) {
                                            ?>
                                                    <li class="page-item active">
                                                        <a class="page-link text-dark bg-white border border-dark" href="<?php
                                                                                                                            echo "?page=" . $x;
                                                                                                                            ?>"><?php echo $x; ?></a>
                                                    </li>
                                                <?php

                                                } else {
                                                ?>
                                                    <li class="page-item ">
                                                        <a class="page-link text-white bg-dark border border-dark" href="<?php
                                                                                                                            echo "?page=" . $x;
                                                                                                                            ?>"><?php echo  $x; ?></a>
                                                    </li>
                                            <?php
                                                }
                                            }
                                            ?>


                                            <li class="page-item">
                                                <a class="page-link  bg-body border border-dark" href="<?php

                                                                                                        if ($page_no >= $number_of_pages) {
                                                                                                            echo "#";
                                                                                                        } else {
                                                                                                            echo "?page=" . ($page_no + 1);
                                                                                                        }
                                                                                                        ?>" aria-label="Next">
                                                    <span aria-hidden="true" class="text-dark">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <!-- product -->

                </div>
            </div>
        <?php

                    } else {
                        echo "Something Went Wrong, Please Try Again Later!";
                    }
        ?>

        <!-- empty view -->

        <div class="offset-lg-2 col-12 col-lg-8 bg-body rounded mb-2 mt-2 d-none">
            <div class="row">
                <div class="offset-lg-1 col-12 col-lg-10 text-center">
                    <div class="row" id="view_area">
                        <div class="offset-5 col-2 mt-5">
                            <span class="fw-bold text-black-50"><i class="bi bi-search" style="font-size: 100px;"></i></span>
                        </div>
                        <div class="offset-3 col-6 mt-3 mb-5">
                            <span class="h1 text-black-50 fw-bold">No Items Compatible to Your Search...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- empty view -->

        <!-- body -->


        <?php
        include "footer.php";
        ?>

        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>

<?php

?>