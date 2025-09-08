<?php
session_start();
require "connection.php";

if (isset($_SESSION["product"])) {
    $product_id = $_SESSION["product"]["id"];

    $title = $_POST["t"];
    $qty = $_POST["q"];
    $delivery_within_colombo = $_POST["dwc"];
    $delivery_out_of_colombo = $_POST["doc"];
    $description = $_POST["des"];


    Database::iud("UPDATE `product` SET `title` = '".$title."' , `description` = '".$description."' , `qty` = '".$qty."' , `delivery_fee` = '".$delivery_within_colombo."' , `delivery_fee_other` = '".$delivery_out_of_colombo."'
    WHERE `id` = '".$product_id."' ");

    echo "Product has been Updated!";

    $length = sizeof($_FILES);
    $allowed_image_extensions = array("image/jpg" , "image/jpeg" , "image/png" , "image/svg+xml");
    
    Database::iud("DELETE FROM `image` WHERE `product_id` = '".$product_id."'");
    if($length <= 3 && $length > 0){

        for($x = 0; $x < $length; $x++){
            if(isset($_FILES["i".$x])){
                
                $img_file = $_FILES["i".$x];
                $file_type = $img_file["type"];

                if(in_array($file_type , $allowed_image_extensions)){
                    $new_img_extension;
                    if($file_type == "image/jpg"){
                        $new_img_extension = ".jpg";
                    }else if($file_type == "image/jpeg"){
                        $new_img_extension = ".jpeg";
                    }else if($file_type == "image/png"){
                        $new_img_extension = ".png";
                    }else if($file_type == "image/svg+xml"){
                        $new_img_extension = ".svg";
                    }else{
                        echo "Invalid Image Type!";
                    }
                    $file_name = "resource//gems//".$title."_".$x."_".uniqid().$new_img_extension;
                    move_uploaded_file($img_file["tmp_name"],$file_name);

                    //remove existing images and add new images

                    
                    Database::iud("INSERT INTO `image` (`code` , `product_id`) VALUES ('".$file_name."' , '".$product_id."')");
                }else{
                    echo "This image type doesn't allowed in system!";
                }
            }

        }

    }
    Database::iud("UPDATE `certificate` SET `status`='1' WHERE `product_id`='".$product_id."'");
    
}else{
    header("Location:myProducts.php");
}
