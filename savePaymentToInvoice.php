<?php
session_start();

require "connection.php";

if(isset($_SESSION["user"])){
    $order_id = $_POST["o"];
    $product_id = $_POST["i"];
    $mail = $_POST["m"];
    $amount = $_POST["a"];
    $qty = $_POST["q"];

    $product_rs = Database::search("SELECT * FROM `product` WHERE id='".$product_id."'");

    $product_data = $product_rs->fetch_assoc();

    $current_qty = $product_data["qty"];
    $new_qty = $current_qty - $qty;

    Database::iud("UPDATE `product` SET `qty`='".$new_qty."' WHERE `id`='".$product_id."'");

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y:m:d H:i:s");

    Database::iud("INSERT INTO `invoice` (`order_id`,`date`,`total`,`qty`,`product_id`,`user_email`,`status`) VALUES 
    ('".$order_id."' , '".$date."' , '".$amount."' , '".$qty."' , '".$product_id."' , '".$mail."','0')");

    echo ("1");

}
else{
    echo "something went wrong!";
}
?>