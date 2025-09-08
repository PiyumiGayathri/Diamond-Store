 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Product | Diamond </title>

     <link rel="stylesheet" href="bootstrap.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
     <link rel="stylesheet" href="style.css">

     <link rel="icon" href="resource/logo_title.png">
 </head>

 <body>
     <div class="container-fluid">
         <div class="row">
             <?php
                include "header.php";
                ?>

             <div class="col-12 mt-4 bg-white singleProduct">
                 <div class="row">
                     <div class="col-12" style="padding: 10px;">

                         <div class="row">

                             <?php


                                if (isset($_GET["id"])) {
                                    $product_id = $_GET["id"];

                                $product_rs = Database::search("SELECT product.id, product.price, product.qty, product.description, product.title
                                , product.length, product.width, product.depth, product.weight, product.datetime_added, product.delivery_fee, product.delivery_fee_other,
                                product.category_id, product.color_id, product.clarity_id, product.tone_id, product.cut_id, product.region_id, product.status_id, product.condition_id, product.user_email,
                                cut.name, region.name, condition.name, user.fname, user.lname FROM `product` INNER JOIN `cut` ON cut.id=product.cut_id INNER JOIN
                                `region` ON region.id= product.region_id INNER JOIN `condition` ON condition.id= product.condition_id INNER JOIN `color` ON color.id=product.color_id
                                INNER JOIN `tone` ON tone.id=product.tone_id INNER JOIN `clarity` ON clarity.id=product.clarity_id
                                INNER JOIN `user` ON user.email=product.user_email WHERE product.id='" . $product_id . "'");

                                $product_rows = $product_rs->num_rows;
                                if ($product_rows == 1) {
                                    $product_data = $product_rs->fetch_assoc();

                                ?>


                                 <div class="col-4 col-lg-2 order-2 order-lg-1">
                                     <ul>


                                         <?php
                                            $image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $product_id . "'");
                                            $image_rows = $image_rs->num_rows;
                                            $img = array();

                                            if ($image_rows != 0) {
                                                for ($x = 0; $x < $image_rows; $x++) {
                                                    $image_data = $image_rs->fetch_assoc();
                                                    $img[$x] = $image_data["code"];
                                            ?>

                                                 <li class="d-flex flex-column justify-content-center align-items-center mb-1">
                                                     <img src="<?php echo $img["$x"]; ?>" class="img-thumbnail mt-1 mb-1" id="productImg<?php echo $x; ?>" onclick="loadMainImg(<?php echo $x; ?>);">
                                                 </li>

                                         <?php
                                                }
                                            }
                                            ?>

                                     </ul>
                                 </div>

                                 <div class="col-8 pe-5 pe-lg-0 col-lg-4  order-2 order-lg-1 ">
                                     <div class="row">
                                         <div class="col-12 align-items-center border">
                                             <div id="mainImg" style="height: 450px; background-image: url('resource/gems/emptyGem.png'); background-position: center;background-size: contain;background-repeat: no-repeat;"></div>
                                         </div>
                                     </div>
                                 </div>


                                 <div class="col-12 col-lg-4 p-5 pt-0 order-3">
                                     <div class="row">

                                         <div class="col-12">

                                             <div class="row border-bottom">
                                                 <nav aria-label="breadcrumb">
                                                     <ol class="breadcrumb">
                                                         <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                                         <li class="breadcrumb-item active" aria-current="page"><?php echo $product_data["title"]; ?></li>
                                                     </ol>
                                                 </nav>
                                             </div>

                                             <div class="row">
                                                 <div class="col-12 my-2">
                                                     <span style="font-size: 23px; font-weight: 200;"><?php echo $product_data["title"]; ?></span>
                                                 </div>
                                             </div>

                                             <?php
                                                $price = $product_data["price"];

                                                ?>

                                             <div class="col-12">
                                                 <div class="col-12 my-2">
                                                     <span class="text-dark" style="font-size:23px ;font-weight: 200;">Rs. <?php echo $price; ?>.00</span><br>
                                                     <span style="font-size:16px ;font-weight: 200;"><span style="font-weight: 600;">In stock : </span><?php echo $product_data["qty"]; ?> items available</span>
                                                 </div>

                                                 <div class="col-12">
                                                     <div class="col-12 my-2">

                                                         <span style="font-size:16px ;font-weight: 200;"><span style="font-weight: 600;">Seller :</span> <?php echo $product_data["fname"]; ?>&nbsp;<?php echo $product_data["lname"]; ?></span><br>
                                                        

                                                         <hr>
                                                         <span style="font-size: 15px;font-weight: 200;"><span style="font-weight: 600;">Return Policy : </span>You can get 14 days to cancel your order with us.
                                                             This two week period starts from the day after you receive your order (or from the day after you receive the last item of your order). <br>
                                                             Email us: diamond.store@gmail.com
                                                         </span>
                                                         <hr>
                                                     </div>
                                                 </div>

                                                 <div class="row">
                                                     <div class="col-12">
                                                         <div class="row">
                                                             <div class="col-12 my-2">
                                                                 <div class="row g-2">

                                                                     <div class="border border-2 rounded overflow-hidden 
                                                                    float-left mt-1 position-relative product-qty">
                                                                         <div class="col-12">
                                                                             <span>Quantity : </span>
                                                                             <input type="text" id="qtyInput" onkeyup='checkValue(<?php echo $product_data["qty"]; ?>);' class="border-0 fs-5 fw-bold" style="outline: none;" pattern="[0-9]" value="1" />

                                                                             <div class="position-absolute qty-buttons">
                                                                                 <div class="justify-content-center d-flex flex-column align-items-center 
                                                                                    border border-1 border-secondary qty-inc">
                                                                                     <i class="bi bi-caret-up-fill text-black-50 fs-5" onclick='qty_inc(<?php echo $product_data["qty"]; ?>);'></i>
                                                                                 </div>
                                                                                 <div class="justify-content-center d-flex flex-column align-items-center 
                                                                                border border-1 border-secondary qty-dec">
                                                                                     <i class="bi bi-caret-down-fill text-black-50 fs-5" onclick="qty_dec();"></i>
                                                                                 </div>
                                                                             </div>

                                                                         </div>
                                                                     </div>

                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>

                                             </div>

                                         </div>
                                     </div>

                                 </div>
                                 <div class="col-12 col-lg-2 p-5 order-3 mt-0">
                                     <div class="row">
                                         <?php
                                            if ($product_data["qty"] > 0) {
                                            ?>
                                             <button class="col-12 btn btn-outline-dark mt-2 " onclick="buyNow(<?php echo $product_id;?>);">
                                                 <i class="bi bi-bag-heart fs-5 p-2"></i>Buy
                                             </button>
                                             <button class="col-12 btn btn-outline-dark mt-3" onclick='addToCart(<?php echo $product_data["id"]; ?>);'>
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
                                                $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `product_id` = '" . $product_data["id"] . "' AND
                                                                `user_email` = '" . $_SESSION["user"]["email"] . "'");
                                                $watchlist_rows = $watchlist_rs->num_rows;

                                                if ($watchlist_rows == 1) {
                                                ?>
                                                 <button class="col-12 btn border border-dark mt-3" onclick='addToWatchlist(<?php echo $product_data["id"]; ?>);'>
                                                     <i class="bi bi-heart-fill fs-5 p-1 text-danger" id='heart(<?php echo $product_data["id"]; ?>)'></i>Watchlist
                                                 </button>
                                             <?php
                                                } else {
                                                ?>
                                                 <button class="col-12 btn border border-dark mt-3" onclick='addToWatchlist(<?php echo $product_data["id"]; ?>);'>
                                                     <i class="bi bi-heart-fill fs-5 p-1" id='heart(<?php echo $product_data["id"]; ?>)'></i>Watchlist
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

                         <div class="col-12 col-lg-6 p-3">
                             <div class="row">
                                 <div class="col-12">
                                     <label style="font-size: 25px;" class="text-center">Item Details</label>
                                 </div>
                                 <div class="col-12 p-4 m-2" style="font-size: 17px;">
                                     <div class="row">

                                         <div class="col-4 border border-2 p-2">
                                             <label class="fw-bold">Dimensions (mm)</label>
                                         </div>
                                         <div class="col-8 border border-2 p-2">
                                             <label for=""><?php echo $product_data["length"]; ?>mm * <?php echo $product_data["width"]; ?>mm * <?php echo $product_data["depth"]; ?>mm</label>
                                         </div>

                                         <div class="col-4 border border-2 border-top-0 p-2">
                                             <label class="fw-bold">Weight (cts)</label>
                                         </div>
                                         <div class="col-8 border border-2 border-top-0 p-2">
                                             <label for=""><?php echo $product_data["weight"]; ?></label>
                                         </div>

                                         <div class="col-4 border border-2 border-top-0 p-2">
                                             <label class="fw-bold">Colour</label>
                                         </div>

                                         <?php
                                            $col_rs = Database::search("SELECT * FROM  `color` WHERE id ='" . $product_data["color_id"] . "'");
                                            $col_data = $col_rs->fetch_assoc();
                                            ?>
                                         <div class="col-8 border border-2 border-top-0 p-2">
                                             <div class="col-12">
                                                 <div class="row g-2">
                                                     <div class="col-2 border border-2 " style="background-color: <?php echo $col_data["code"]; ?>;"></div>
                                                     <div class="col-10">
                                                         <label for="">&nbsp;<?php echo $col_data["name"]; ?></label>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="col-4 border border-2 border-top-0 p-2">
                                             <label class="fw-bold">Tone</label>
                                         </div>
                                         <?php
                                            $tone_rs = Database::search("SELECT * FROM  `tone` WHERE id ='" . $product_data["tone_id"] . "'");
                                            $tone_data = $tone_rs->fetch_assoc();
                                            ?>
                                         <div class="col-8 border border-2 border-top-0 p-2">
                                             <div class="col-12">
                                                 <div class="row g-2">
                                                     <div class="col-2 border border-2 " style="background-color: <?php echo $tone_data["tone"]; ?>;"></div>
                                                     <div class="col-10">
                                                         <label for="">&nbsp;<?php echo $col_data["name"]; ?> (<?php echo $tone_data["scale"]; ?>)</label>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="col-4 border border-2 border-top-0 p-2">
                                             <label class="fw-bold">Clarity</label>
                                         </div>
                                         <?php
                                            $clarity_rs = Database::search("SELECT * FROM  `clarity` WHERE id ='" . $product_data["clarity_id"] . "'");
                                            $clarity_data = $clarity_rs->fetch_assoc();
                                            ?>
                                         <div class="col-8 border border-2 border-top-0 p-2">
                                             <label><?php echo $clarity_data["grade"]; ?></label>
                                         </div>

                                         <div class="col-4 border border-2 border-top-0 p-2">
                                             <label class="fw-bold">Certificate</label>
                                         </div>
                                         <div class="col-8 border border-2 border-top-0 p-2">
                                             <button class="btn btn-dark fw-bold" onclick="openCertificate(<?php echo $product_id;?>);">Download Certificate</button>
                                         </div>

                                         <div class="col-4 border border-2 border-top-0 p-2">
                                             <label class="fw-bold">Region</label>
                                         </div>

                                         <?php
                                            $reg_rs = Database::search("SELECT * FROM `region` WHERE `id`='" . $product_data["region_id"] . "'");
                                            $reg_data = $reg_rs->fetch_assoc();
                                            ?>
                                         <div class="col-8 border border-2 border-top-0 p-2">
                                             <label for=""><?php echo $reg_data["name"]; ?></label>
                                         </div>

                                         <div class="col-4 border border-2 border-top-0 p-2">
                                             <label class="fw-bold">Shape</label>
                                         </div>
                                         <?php
                                            $cut_rs = Database::search("SELECT * FROM `cut` WHERE `id`='" . $product_data["cut_id"] . "'");
                                            $cut_data = $cut_rs->fetch_assoc();
                                            ?>
                                         <div class="col-8 border border-2 border-top-0 p-2">
                                             <label for=""><?php echo $cut_data["name"]; ?></label>
                                         </div>

                                     </div>
                                 </div>
                             </div>
                         </div>


                         <div class="col-12">
                             <div class="row">
                                 <div class="col-12 bg-white">
                                     <div class="row me-0 mt-4 mb-3">
                                         <div class="col-12">
                                             <span style="font-size: 25px;" class="text-center">Item Description</span>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-12 bg-white">
                                     <div class="row">
                                         <div class="col-12">
                                             <div class="row">
                                                 <div class="">
                                                     <textarea cols="60" rows="10" class="form-control" readonly><?php echo $product_data["description"]; ?></textarea>
                                                 </div>
                                             </div>
                                         </div>

                                     </div>
                                 </div>
                             </div>
                         </div>

                         <hr class="mt-5">
                         <div class="col-12 p-2">
                             <div class="row">
                                 <label style="font-size: 25px;">You may also like</label>
                             </div>
                             <!-- product -->
                             <div class="col-12 col-lg-12 mt-3 mb-3 p-1" id="productCard">
                                 <div class="row gap-4 gap-lg-2">
                                     <?php

                                        $page_no;

                                        if (isset($_GET["page"])) {
                                            $page_no = $_GET["page"];
                                        } else {
                                            $page_no = 1;
                                        }

                                        $product_rs = Database::search("SELECT * FROM `product` WHERE `category_id`='" . $product_data["category_id"] . "' AND `id`!='".$product_id."'");
                                        $product_rows = $product_rs->num_rows;

                                        $products_per_page = 6;
                                        $number_of_pages = ceil($product_rows / $products_per_page);

                                        $page_results = ($page_no - 1) * $products_per_page;

                                        $selected_rs = Database::search("SELECT * FROM `product` WHERE `category_id`='" . $product_data["category_id"] . "' AND `id`!='".$product_id."' LIMIT " . $products_per_page . " OFFSET " . $page_results . "");
                                        $selected_rows = $selected_rs->num_rows;

                                        for ($x = 0; $x < $selected_rows; $x++) {
                                            $selected_data = $selected_rs->fetch_assoc();

                                        ?>

                                         <!--product card -->


                                         <div class="col-5 col-lg-2 card mb-3 mt-3" >
                                             <div class="row g-0">
                                                 <div class="col-12 text-center text-danger fw-bold p-0 m-0">#<?php echo $selected_data["id"]; ?></div>

                                                 <?php
                                                    $product_img_rs = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $selected_data["id"] . "'");
                                                    $product_img_rows = $product_img_rs->num_rows;
                                                    $product_img_data = $product_img_rs->fetch_assoc();

                                                    if ($product_img_rows != 0) {

                                                    ?>
                                                     <div class="col-6 offset-3 mt-2">
                                                         <img src="<?php echo $product_img_data["code"]; ?>" class="img-fluid rounded justify-content-center" style="height: 100px;">
                                                     </div>
                                                 <?php

                                                    } else {
                                                    ?>

                                                     <div style="height: 100px; background-image: url('resource/gems/emptyGem.png'); background-position: center;background-size: contain;background-repeat: no-repeat;"></div>

                                                 <?php
                                                    }
                                                    ?>
                                                 <div class="col-12">
                                                     <div class="card-body text-center">
                                                         <h5 class="card-title" style="font-size: 16px; font-weight: 800;"><?php echo $selected_data["title"]; ?></h5>
                                                         <span class="card-text fw-bold fs-5 text-success">Rs: <?php echo $selected_data["price"]; ?> .00</span><br>
                                                         <span class="card-text text-primary"><?php echo $selected_data["qty"]; ?> Items in Stock</span>

                                                     </div>
                                                 </div>
                                                 <div class="col-12 pt-0 p-3">
                                                     <div class="row">
                                                         <button class="col-12 btn btn-outline-dark mt-2 ">
                                                             <i class="bi bi-bag-heart fs-5 p-2"></i>Buy
                                                         </button>
                                                         <button class="col-12 btn btn-outline-dark mt-3">
                                                             <i class="bi bi-cart4 fs-5 p-2"></i>Cart
                                                         </button>
                                                         <button class="col-12 btn border border-dark mt-3">
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
                         <div class="col-12 p-5 mb-3">
                             <div class="col-12 col-lg-8  bg-light p-4">
                                 <div class="row p-2">
                                     <label style="font-size: 25px;">Feedbacks</label>
                                 </div>
                                 <div class="row overflow-scroll">
                                     <div class="rounded p-3 " style="height: 300px;">
                                         <div class="col-12 mt-1 mx-1">
                                             <div class="row border border-1 border-dark rounded me-0">
                                                 <?php
                                                    $feedback_rs = Database::search("SELECT * FROM `feedback` ORDER BY `date` DESC");
                                                    $feedback_rows = $feedback_rs->num_rows;

                                                    if ($feedback_rows == 0) {
                                                    ?>
                                                     <div class="col-10 mt-1 mb-1 ms-0 text-center ">
                                                         <span class="text-black-50">No Feedbacks Yet!</span>
                                                     </div>
                                                     <?php
                                                    } else {
                                                        for ($a = 0; $a < $feedback_rows; $a++) {
                                                            $feedback_data = $feedback_rs->fetch_assoc();
                                                        ?>
                                                         <div class="col-10 mt-1 mb-1 ms-0">
                                                             <span class="fw-bold"><?php echo $feedback_data["user_email"]; ?></span>
                                                         </div>
                                                         <div class="col-12">
                                                             <hr>
                                                         </div>
                                                         <div class="col-12">
                                                             <p class=" fw-bold text-black-50"><?php echo $feedback_data["txt"]; ?></p>
                                                         </div>
                                                         <div class="col-12">
                                                             <div class="row">
                                                                 <?php
                                                                    $feedback_img = Database::search("SELECT * FROM `feedback_img` INNER JOIN `feedback` ON
                                                                    feedback_img.feedback_id=feedback.id WHERE feedback.id='" . $feedback_data["id"] . "'");
                                                                    $feedback_img_rows = $feedback_img->num_rows;

                                                                    if ($feedback_img_rows != 0) {
                                                                        for ($b = 0; $b < $feedback_img_rows; $b++) {
                                                                            $feedback_img_data = $feedback_img->fetch_assoc();
                                                                    ?>

                                                                         <div class="col-6 col-lg-2">
                                                                             <img src="<?php echo $feedback_img_data["code"]; ?>" class="img-thumbnail"  style="height: 120px;">
                                                                         </div>

                                                                 <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                             </div>
                                                         </div>
                                                         <div class="offset-6 col-6 text-end">
                                                             <label class="form-label fs-6 text-success"><?php echo $feedback_data["date"]; ?></label>
                                                         </div>
                                                 <?php
                                                        }
                                                    }


                                                    ?>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                     </div>
                 </div>

                 <?php include "footer.php"; ?>
             </div>
         </div>

         <script src="bootstrap.bundle.js"></script>
         <script src="script.js"></script>
         <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
 </body>

 </html>

 <?php
                                } else {
                                    echo "Sorry For the Inconvenience!";
                                }
                                } else {
                                    echo "Something went wrong!";
                                }
    ?>