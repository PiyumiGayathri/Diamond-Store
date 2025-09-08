<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist | Diamond</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo_title.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

</head>

<body>

    <div class="container-fluid" style="background-color: #d0d1d3;">
        <div class="row">

            <?php
            include "header.php";
            if (isset($_SESSION["user"])) {
                $user_email = $_SESSION["user"]["email"];
            ?>


                <div class="col-12">
                    <div class="row">
                        <div class="col-12 mt-3 mb-4 shadow ">
                            <div class="row">

                                <div class="col-12">
                                    <label class="form-label fs-1 fw-bolder"></label>
                                </div>

                                <div class="col-11 col-lg-2 border border-2 border-0 border-end">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                            <li class="breadcrumb-item active " area-current="page">Watchlist</li>
                                        </ol>
                                    </nav>
                                    <nav class="nav nav-pills flex-column">
                                        <a class="nav-link active bg-secondary text-white" aria-current="page" href="#"><i class="bi bi-heart p-2"></i>My Watchlist</a>
                                        <a class="nav-link text-dark" href="cart.php"><i class="bi bi-cart4 p-2"></i>My Cart</a>
                                    </nav>
                                </div>

                                <div class="col-lg-10 mt-4">
                                    <div class="row">
                                        <div class="offset-lg-2 col-8 col-lg-6 mb-3">
                                            <input type="text" class="form-control" placeholder="Search in watchlist..." id="searchWTxt">
                                        </div>
                                        <div class="col-4 col-lg-2 mb-3 d-grid">
                                            <button class="btn btn-info" onclick="searchWatchlist();"><i class="bi bi-search p-2"></i>Search</button>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $user = $_SESSION["user"]["email"];
                                $watch_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '" . $user . "'");

                                $watch_rows = $watch_rs->num_rows;

                                if ($watch_rows == 0) {
                                ?>

                                    <!-- Empty View -->
                                    <div class="col-12 col-lg-10 offset-lg-2">
                                        <div class="row">
                                            <div class="col-12 emptyView"></div>
                                            <div class="col-12 text-center">
                                                <label class="form-label fs-3 fw-bold">You Have No Items in Your Watchlist Yet!</label>
                                            </div>
                                            <div class="offset-lg-5 col-12 col-lg-2 d-grid mb-3">
                                                <a href="home.php" class="btn btn-outline-danger fs-4"><i class="bi bi-gem p-2"></i>Shop Now</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Empty View -->
                                <?php
                                } else {
                                ?>

                                    <div class="col-12 col-lg-10 offset-lg-2" id="wProduct">
                                        <div class="row">

                                            <?php
                                            for ($x = 0; $x < $watch_rows; $x++) {

                                                $watch_data = $watch_rs->fetch_assoc();

                                            ?>

                                                <!--product card -->


                                                <div class="card mb-3 mt-3 p-3 offset-lg-1" style="max-width:800px;">
                                                    <div class="row g-0">
                                                        <?php
                                                        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $watch_data["product_id"]. "'");
                                                        $product_data = $product_rs->fetch_assoc();
                                                        ?>
                                                            <div class="col-10 text-start text-danger fw-bold p-0 m-0">#<?php echo $product_data["id"]; ?></div>

                                                            <?php
                                                            $product_img_rs = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $product_data["id"] . "'");
                                                            $product_img_data = $product_img_rs->fetch_assoc();
                                                            ?>
                                                            <div class="col-md-4 mt-2">
                                                                <img src="<?php echo $product_img_data["code"]; ?>" class="img-fluid rounded-start">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="card-body text-center">

                                                                    <h5 class="card-title fw-bold"><?php echo $product_data["title"]; ?></h5>

                                                                    <span class="card-text fw-bold fs-5 text-primary">Rs: <?php echo $product_data["price"]; ?> .00</span><br>
                                                                    
                                                                    <span class="card-text text-black-50" style="font-size: 16px;"><?php echo $product_data["length"]; ?>(l)*<?php echo $product_data["width"]; ?>(w)*<?php echo $product_data["depth"]; ?>(d)</span><br>
                                                                    <?php
                                                                    $region_rs = Database::search("SELECT * FROM `region` WHERE `id`='".$product_data["region_id"]."'");
                                                                    $region_data = $region_rs->fetch_assoc();
                                                                    ?>
                                                                    <span class="card-text text-black-50" style="font-size: 16px;">Found in : <?php echo $region_data["name"]; ?></span>

                                                                    <?php
                                                                    $shape_rs = Database::search("SELECT * FROM `cut` WHERE `id`='".$product_data["cut_id"]."'");
                                                                    $shape_data = $shape_rs->fetch_assoc();
                                                                    ?>
                                                                    <span class="card-text text-black-50" style="font-size: 16px;">Shape : <?php echo $shape_data["name"]; ?></span><br>

                                                                    <?php
                                                                    $condition_rs = Database::search("SELECT * FROM `condition` WHERE `id`='".$product_data["condition_id"]."'");
                                                                    $condition_data = $condition_rs->fetch_assoc();
                                                                    ?>
                                                                    <span class="card-text text-black-50" style="font-size: 16px;">condition : <?php echo $condition_data["name"]; ?></span><br>
                                                                    
                                                                    <span class="card-text text-black-50"  style="font-size: 16px;"><?php echo $product_data["qty"]; ?> Items in Stock</span>

                                                                </div>
                                                            </div>


                                                            <div class="col-md-2">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <button class="col-12 btn btn-outline-dark mt-3">
                                                                        <i class="bi bi-bag-heart p-2"></i>Buy
                                                                        </button>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <button class="col-12 btn btn-outline-dark mt-3">
                                                                        <i class="bi bi-cart4 p-2"></i>Cart
                                                                        </button>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <button class="col-12 btn btn-outline-dark mt-3">
                                                                            <i class="bi bi-trash3 p-2" id="r<?php echo$watch_data['id']; ?>" onclick="removeFromWatchlist('<?php echo$watch_data['id']; ?>');"></i>Remove
                                                                        </button>
                                                                    </div>
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
                                <?php


                                }

                                ?>




                            </div>
                        </div>
                    </div>
                </div>

            <?php
            } else {
                echo "Please Login First!";
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