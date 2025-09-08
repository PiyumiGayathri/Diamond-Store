<?php
session_start();
require "connection.php";

$email = $_SESSION["user"]["email"];
$product_id = $_GET["id"];

$product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$product_id."' AND `user_email`='".$email."'");
$product_rows = $product_rs->num_rows;

if($product_rows == 1){
    $product_data = $product_rs->fetch_assoc();
    $_SESSION["product"] = $product_data;
    echo "Success!";
}else{
    echo "Something Went Wrong!";
}
?>