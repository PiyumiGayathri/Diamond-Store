<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"])){
    if(isset($_GET["id"])){

        $email = $_SESSION["user"]["email"];
        $product_id = $_GET["id"];

        $watchlis_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '".$email."' 
        AND `product_id` = '".$product_id."'");
        $watchlis_rows = $watchlis_rs->num_rows;

        if($watchlis_rows == 1){
            $watchlis_data = $watchlis_rs->fetch_assoc();
            $list_id = $watchlis_data["id"];

            Database::iud("DELETE FROM `watchlist` WHERE `id` = '".$list_id."'");
            echo "Poduct Removed From Watchlist!";

        }else{
            Database::iud("INSERT INTO `watchlist` (`product_id`,`user_email`) VALUES ('".$product_id."' , '".$email."')");
            echo "Product Added to the Watchlist!";
        }

    }else{
        echo "Something Went Wrong!";
    }
    
    
}else{
    echo "Please Login First!";
}

?>