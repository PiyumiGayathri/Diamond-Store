<?php
session_start();
require "connection.php";

$user = $_SESSION["user"]["email"];
$txt = $_POST["txt"];

$query = "SELECT * FROM `product` INNER JOIN `cart` ON product.id = cart.product_id 
WHERE cart.user_email='" . $user . "'";

if (!empty($txt)) {
    $query .= "AND `title` LIKE '%" . $txt . "%'";
}

?>

<?php
 $total = 0;
 $subTotal = 0;
 $shipping = 0;

?>
<div class="col-12">
        <div class="row">

            <?php
            $cart_rs = Database::search($query);
            $cart_rows = $cart_rs->num_rows;
            
            for ($x = 0; $x < $cart_rows; $x++) {
                $cart_data = $cart_rs->fetch_assoc();

                $product_rs = Database::search($query. "AND cart.product_id = '" . $cart_data["product_id"] . "'");
                $product_data = $product_rs->fetch_assoc();

                $total = $total + ($product_data["price"] * $cart_data["qty"]);

                $address_rs = Database::search("SELECT district.id AS `did` FROM `user_has_address` INNER JOIN `city` ON
                                            user_has_address.city_id=city.id INNER JOIN `district` ON city.district_id = district.id WHERE 
                                            `user_email`='" . $user . "'");

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

                <div class="card mb-3 mx-0 col-lg-6 col-12" style="background-color: #f8f8f8;">
                    <div class="row g-0">
                        <div class="col-md-12 mt-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                <span class="fw-bold text-danger fs-5"># <?php echo $product_data["product_id"] ;?></span><br>
                                    <span class="fw-bold text-black-50 fs-5">Seller :</span>&nbsp;
                                    <span class="fw-bold text-black fs-5"><?php echo $seller; ?></span>&nbsp;
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-4">
                            <span class="d-inline-block p-2" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content='<?php echo $product_data["description"]; ?>' title="Product Details">

                                <?php
                                $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $product_data["product_id"] . "'");
                                $img_rows = $img_rs->num_rows;
                                $img_data = $img_rs->fetch_assoc();

                                if ($img_rows != 0) {
                                ?>
                                    <img src="<?php echo $img_data["code"]; ?>" class="img-fluid rounded-start" style="max-width: 200px;">
                                <?php
                                } else {
                                ?>
                                    <img src="resource/gems/emptyGem.png" class="img-fluid rounded-start" style="max-width: 200px;">
                                <?php
                                }
                                ?>


                            </span>


                        </div>
                        <div class="col-md-5">
                            <div class="card-body">

                                <h3 class="card-title text-success"><?php echo $product_data["title"]; ?></h3>

                                <?php
                                $condition_rs = Database::search("SELECT * FROM `condition` WHERE `id`='" . $product_data["condition_id"] . "'");
                                $condition_data = $condition_rs->fetch_assoc();
                                ?>

                                &nbsp; <span class="fw-bold text-black-50">Condition : <?php echo $condition_data["name"]; ?></span>
                                <br>
                                <span class="fw-bold fs-5">Price :</span>&nbsp;
                                <span class="fw-bold text-black fs-5">Rs. <?php echo $product_data["price"]; ?>.00</span>
                                <br>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4 mt-2">
                                            <label class="fw-bold fs-5 d-grid">Quantity :</label>
                                        </div>
                                        <div class="col-12">
                                            <input type="number" class="mt-3 fs-4 fw-bold px-3 cardqtytext d-grid" value="<?php echo $cart_data["qty"]; ?>">
                                        </div>

                                    </div>
                                </div>
                                <br>

                                <span class="fw-bold ">Delivery Fee :</span>&nbsp;
                                <span class="fw-bold text-black ">Rs. <?php echo $ship; ?>.00</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-body d-grid">
                                <a class="btn btn-outline-dark mb-2"><i class="bi bi-bag-heart fs-5 p-2"></i>Buy</a>
                                <a class="btn btn-outline-dark mb-2" onclick='removeProductFromCart(<?php echo $cart_data["id"]; ?>);'><i class="bi bi-trash3 fs-5 p-2"></i>Remove</a>
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12 mt-3 mb-3">
                            <div class="row">
                                <div class="col-6 col-md-6">
                                    <span class="fw-bold fs-5 text-black-50">Requested Total <i class="bi bi-info-circle"></i></span>
                                </div>
                                <div class="col-6 col-md-6 text-end">
                                    <span class="fw-bold fs-5 text-black-50">Rs. <?php echo ($product_data["price"] * $cart_data["qty"]) + $ship; ?>.00</span>
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



