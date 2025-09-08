<?php

session_start();
require "connection.php";

if(isset($_SESSION["user"])){
    if(isset($_GET["id"])){

        $email = $_SESSION["user"]["email"];
        $product_id = $_GET["id"];

        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id`='".$product_id."' AND `user_email`='".$email."'");
        $cart_rows = $cart_rs->num_rows;

        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$product_id."'");
        $product_data = $product_rs->fetch_assoc();
        
        $product_qty = $product_data["qty"];

        if($cart_rows == 1){
            $cart_data = $cart_rs->fetch_assoc();
            $current_qty = $cart_data["qty"];
            $new_qty = (int)$current_qty + 1;

            if($product_qty >= $new_qty){

                Database::iud("UPDATE `cart` SET `qty`='".$new_qty."' WHERE `product_id`='".$product_id."' AND `user_email`='".$email."'");
                echo "Product Added To Cart!";

            }else{
                echo "Invalid Quantity";
            }
        }else{
            Database::iud("INSERT INTO `cart` (`product_id`,`user_email`,`qty`) VALUES ('".$product_id."' , '".$email."' , '1')");
            echo "Product Added Successfully!";
        }
    }else{
        echo "Something Went Wrong!";
    }
}else{
    echo "Please sign In or Register!";
}

?>