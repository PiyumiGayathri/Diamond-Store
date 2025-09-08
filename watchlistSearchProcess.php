<?php
session_start();
require "connection.php";

$user = $_SESSION["user"]["email"];
$txt = $_POST["txt"];

$query = "SELECT * FROM `product` INNER JOIN `watchlist` ON product.id = watchlist.product_id 
WHERE watchlist.user_email='" . $user . "'";

if (!empty($txt)) {
    $query .= "AND `title` LIKE '%" . $txt . "%'";
}
?>


<?php
$product_rs = Database::search($query);
$product_rows = $product_rs->num_rows;
for ($x = 0; $x < $product_rows; $x++) {
    $product_data = $product_rs->fetch_assoc();

?>
    <div class="card mb-3 mt-3 p-3 offset-1" style="max-width:800px;">
        <div class="row g-0">
            <div class="col-10 text-start text-danger fw-bold p-0 m-0">#<?php echo $product_data["product_id"]; ?></div>

            <?php
            $product_img_rs = Database::search("SELECT * FROM `image` WHERE `product_id` = '" . $product_data["product_id"] . "'");
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
                    $region_rs = Database::search("SELECT * FROM `region` WHERE `id`='" . $product_data["region_id"] . "'");
                    $region_data = $region_rs->fetch_assoc();
                    ?>
                    <span class="card-text text-black-50" style="font-size: 16px;">Found in : <?php echo $region_data["name"]; ?></span>

                    <?php
                    $shape_rs = Database::search("SELECT * FROM `cut` WHERE `id`='" . $product_data["cut_id"] . "'");
                    $shape_data = $shape_rs->fetch_assoc();
                    ?>
                    <span class="card-text text-black-50" style="font-size: 16px;">Shape : <?php echo $shape_data["name"]; ?></span><br>

                    <?php
                    $condition_rs = Database::search("SELECT * FROM `condition` WHERE `id`='" . $product_data["condition_id"] . "'");
                    $condition_data = $condition_rs->fetch_assoc();
                    ?>
                    <span class="card-text text-black-50" style="font-size: 16px;">condition : <?php echo $condition_data["name"]; ?></span><br>

                    <span class="card-text text-black-50" style="font-size: 16px;"><?php echo $product_data["qty"]; ?> Items in Stock</span>

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
                            <i class="bi bi-trash3 p-2"></i>Remove
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php
}

?>