<?php

require "connection.php";

if(isset($_GET["id"])){
    $watchlist_id = $_GET["id"];

    $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `id`='".$watchlist_id."'");
    $watchlist_rows = $watchlist_rs->num_rows;
    $watchlist_data = $watchlist_rs->fetch_assoc();

    if($watchlist_rows == 0){
        echo "Something Went wrong, Please Try again Later!";
    }
    else{

        Database::iud("INSERT INTO `recents` (`product_id`,`user_email`) VALUES ('".$watchlist_data["product_id"]."' , '".$watchlist_data["user_email"]."')");

        Database::iud("DELETE FROM `watchlist` WHERE `id`='".$watchlist_id."'");

        echo ("successfully Removed!");
    }
}else{
    echo "Please Select a Product";
}
?>