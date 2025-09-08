<?php
require "connection.php";

$product_id = $_GET["id"];

$certificateResult = Database::search("SELECT * FROM `certificate` WHERE `product_id`='".$product_id."'");
$certificate_rows = $certificateResult->num_rows;

if($certificate_rows > 0){
    $certificate_data = $certificateResult->fetch_assoc();

$certificate_file = $certificate_data["code"];

echo($certificate_file);
}else{
    echo "There is no Certificate provided with this product!";
}


?>