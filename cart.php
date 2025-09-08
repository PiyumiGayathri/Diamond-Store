<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | Diamond</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="icon" href="resource/logo_title.png">
</head>

<body>
    <div class="container-fluid" style="background-color: #d0d1d3;">
        <div class="row">
            <?php include "header.php";

            if (isset($_SESSION["user"])) {
                $email = $_SESSION["user"]["email"];

                $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $email . "'");
                $cart_rows = $cart_rs->num_rows;

                $total = 0;
                $subTotal = 0;
                $shipping = 0;

            ?>

                <div class="col-12 pt-3">
                    <div class="col-12 mb-3">
                        <div class="row">

                            <div class="col-12 text-center mb-2">
                                <label class="form-label" style="font-size: 60px;color: #001f3d;"><i class="bi bi-cart4  p-2"></i>Cart</label>
                            </div>
                            <div class="col-12 col-lg-2 ">
                                <div class="col-12 p-3  border border-1 border-light border-bottom-0 border-start-0 border-top-0">
                                    <div class="row">
                                        <nav aria-label="breadcrumb ">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                                <li class="breadcrumb-item active " area-current="page">Cart</li>
                                            </ol>
                                        </nav>
                                        <nav class="nav nav-pills flex-column">
                                            <a class="nav-link active bg-secondary text-white" aria-current="page" href="#"><i class="bi bi-cart4 p-2"></i>My Cart</a>
                                            <a class="nav-link text-dark" href="watchlist.php"><i class="bi bi-heart p-2"></i>My watchlist</a>
                                        </nav>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-10 col-12 mb-3 mt-5">
                                <div class="row">
                                    <div class="offset-lg-2 col-lg-6 col-9 mb-3">
                                        <input type="text" class="form-control" placeholder="Search in Cart..." id="cartSearch">
                                    </div>
                                    <div class="col-lg-2 col-3 d-grid mb-3">
                                        <button class="btn btn-info" onclick="searchCart();">Search</button>
                                    </div>

                                    <?php

                                    if ($cart_rows == 0) {

                                    ?>
                                        <!-- Empty View -->
                                        <div class="col-12" style="margin-top: 200px;">
                                            <div class="row">
                                                <div class="col-12 emptyCard"></div>
                                                <div class="col-12 text-center mb-2">
                                                    <label class="form-label fs-1 text-secondary">
                                                        You Have No Items in Your Cart Yet!
                                                    </label><br>
                                                </div>
                                                <div class="offset-lg-4 col-12 col-lg-3 d-grid mb-3">
                                                    <a href="home.php" class="btn btn-outline-success fs-3"><i class="bi bi-gem p-2"></i>Shop Now</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Empty View -->
                                    <?php

                                    } else {

                                    ?>
                                        <!-- Products -->
                                        <div class="col-12 p-4" id="cartProduct" style="margin-top: 220px;">
                                            <div class="row">

                                                <?php
                                                for ($x = 0; $x < $cart_rows; $x++) {
                                                    $cart_data = $cart_rs->fetch_assoc();

                                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $cart_data["product_id"] . "'");
                                                    $product_data = $product_rs->fetch_assoc();

                                                    $total = $total + ($product_data["price"] * $cart_data["qty"]);

                                                    $address_rs = Database::search("SELECT district.id AS `did` FROM `user_has_address` INNER JOIN `city` ON
                                                        user_has_address.city_id=city.id INNER JOIN `district` ON city.district_id = district.id WHERE 
                                                        `user_email`='" . $email . "'");

                                                    $address_data = $address_rs->fetch_assoc();

                                                    $ship = 0;

                                                    if ($address_data["did"] == 1) {
                                                        //methanata danne colombo disrict eke id eka

                                                        $ship = $product_data["delivery_fee"];
                                                        $shipping = $shipping + $ship;
                                                    } else {
                                                        $ship = $product_data["delivery_fee_other"];
                                                        $shipping = $shipping + $ship;
                                                    }

                                                    $seller_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $product_data["user_email"] . "'");
                                                    $seller_data = $seller_rs->fetch_assoc();
                                                    $seller = $seller_data["fname"] . " " . $seller_data["lname"];
                                                ?>

                                                    <div class="card col-12 col-lg-6 bg-light mt-3 p-2">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <span class="fw-bold text-danger "># <?php echo $product_data["id"]; ?></span><br>
                                                                        <span class="fw-bold text-black-50 " style="font-size: 18px;">Seller :</span>&nbsp;
                                                                        <span class="fw-bold text-black " style="font-size: 18px;"><?php echo $seller; ?></span>&nbsp;
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr>

                                                            <div class="col-2 p-2">
                                                                <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content='<?php echo $product_data["description"]; ?>' title="Product Details">

                                                                    <?php
                                                                    $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $product_data["id"] . "'");
                                                                    $img_rows = $img_rs->num_rows;
                                                                    $img_data = $img_rs->fetch_assoc();

                                                                    if ($img_rows != 0) {
                                                                    ?>
                                                                        <img src="<?php echo $img_data["code"]; ?>" class="img-fluid rounded-start" style="max-width: 100px;">
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <img src="resource/gems/emptyGem.png" class="img-fluid rounded-start" style="max-width: 100px;">
                                                                    <?php
                                                                    }
                                                                    ?>


                                                                </span>


                                                            </div>
                                                            <div class="col-6">
                                                                <div class="card-body">

                                                                    <h3 class="card-title text-success"><?php echo $product_data["title"]; ?></h3>

                                                                    <?php
                                                                    $condition_rs = Database::search("SELECT * FROM `condition` WHERE `id`='" . $product_data["condition_id"] . "'");
                                                                    $condition_data = $condition_rs->fetch_assoc();
                                                                    ?>

                                                                    &nbsp; <span class="text-black-50">Condition : <?php echo $condition_data["name"]; ?></span>
                                                                    <br>
                                                                    <span class="">Price :</span>&nbsp;
                                                                    <span class="text-danger">Rs. <?php echo $product_data["price"]; ?>.00</span>
                                                                    <br>
                                                                    <div class="col-12">
                                                                        <div class="row">
                                                                            <div class="col-4 mt-3">
                                                                                <label class="d-grid">Quantity :</label>
                                                                            </div>
                                                                            <div class="col-8">
                                                                                <input type="number" id="qtyInput" class="mt-3 border border-2 border-secondarypx-3 cardqtytext d-grid" value="<?php echo $cart_data["qty"]; ?>">
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <span class="">Delivery Fee :</span>&nbsp;
                                                                    <span class="text-primary">Rs. <?php echo $ship; ?>.00</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="card-body d-grid">
                                                                    <a class="btn btn-outline-dark mb-2" onclick="buyNow(<?php echo $product_data['id'] ;?>);"><i class="bi bi-bag-heart fs-5 p-2"></i>Buy</a>
                                                                    <a class="btn btn-outline-dark mb-2" onclick='removeProductFromCart(<?php echo $cart_data["id"]; ?>);'><i class="bi bi-trash3 fs-5 p-2"></i>Remove</a>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 ">
                                                                <div class="row">
                                                                    <div class="col-6 col-md-6">
                                                                        <span class="fw-bold text-black-50" style="font-size: 21px;">Requested Total <i class="bi bi-info-circle"></i></span>
                                                                    </div>
                                                                    <div class="col-6 col-md-6 text-end">
                                                                        <span class="fw-bold text-black-50" style="font-size: 21px;">Rs. <?php echo ($product_data["price"] * $cart_data["qty"]) + $ship; ?>.00</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Products -->

                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <!-- summary -->
                                        <div class="col-lg-8 col-12 offset-lg-1 bg-light" style="position: absolute;margin-top: 60px;">
                                            <div class="row">

                                                <div class="col-lg-3 col-12 text-center">
                                                    <div class="row">
                                                        <div class="col-12 mt-5">
                                                            <label class="form-label text-primary" style="font-size: 25px;">Cart Total Price</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-12 p-3">
                                                    <div class="row">

                                                        <div class="col-6 mb-3">
                                                            <span  style="font-size: 18px;">items (<?php echo $cart_rows; ?>)</span>
                                                        </div>

                                                        <div class="col-6 text-end mb-3">
                                                            <span  style="font-size: 18px;">Rs. <?php echo $total; ?> .00</span>
                                                        </div>

                                                        <div class="col-6">
                                                            <span style="font-size: 18px;">Shipping</span>
                                                        </div>

                                                        <div class="col-6 text-end">
                                                            <span style="font-size: 18px;">Rs. <?php echo $shipping; ?> .00</span>
                                                        </div>

                                                        <div class="col-12 mt-3">
                                                            <hr />
                                                        </div>

                                                        <div class="col-6 mt-2">
                                                            <span class="fw-bold" style="font-size: 22px;">Total</span>
                                                        </div>

                                                        <div class="col-6 mt-2 text-end">
                                                            <span class="fw-bold" style="font-size: 22px;">Rs. <?php echo ($shipping + $total); ?> .00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-12 p-5">
                                                    <div class="row">
                                                    <div class="col-12 mt-3 mb-3 d-grid">
                                                            <button class="btn btn-danger fw-bold" onclick="checkout('<?php echo ($shipping + $total); ?>');">CHECKOUT</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- summary -->
                                    <?php
                                    }

                                    ?>



                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <?php include "footer.php"; ?>
            <?php
            } else {
            ?>
                <!-- <script>alert("Sign in First!");</script> -->
            <?php
                // header("Location:http://localhost/auction/index.php");
            }
            ?>

        </div>
    </div>


    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
</body>

</html>