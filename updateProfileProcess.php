<?php

session_start();

require "connection.php";

if(isset($_SESSION["user"])){

    $fname = $_POST["fn"];
    $lname = $_POST["ln"];
    $mobile = $_POST["m"];
    $line1 = $_POST["l1"];
    $line2 = $_POST["l2"];
    $province = $_POST["p"];
    $district = $_POST["d"];
    $city = $_POST["c"];
    $postalCode = $_POST["pc"];
    
    if(isset($_FILES["image"])){
        $image = $_FILES["image"];

        $allowed_image_extensions = array("image/jpg","image/jpeg","image/png","image/svg+xml");
        //svg file ekaka xml part ekakuth tynwa e hinda thamai svg+xml kiyala type eka denne

        $file_extension = $image["type"];
        // echo $file_extension;

        if(!in_array($file_extension,$allowed_image_extensions)){
            echo "Please insert a valid image";
        }else{
            $new_file_extension;

            if($file_extension == "image/jpg"){
                $new_file_extension = ".jpg";
            }else if($file_extension == "image/jpeg"){
                $new_file_extension = ".jpeg";
            }else if($file_extension == "image/png"){
                $new_file_extension = ".png";
            }else if($file_extension == "image/svg+xml"){
                $new_file_extension = ".svg";
            }

            //echo $new_file_extension;
        
            $file_name = "resource/users/".$_SESSION["user"]["fname"]."_".uniqid().$new_file_extension;
            
            move_uploaded_file($image["tmp_name"],$file_name);

            $image_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email` = '".$_SESSION["user"]["email"]."'");
            $image_rows = $image_rs->num_rows;

            if($image_rows == 1){
                Database::iud("UPDATE `profile_image` SET `path` = '".$file_name."' WHERE `user_email` = '".$_SESSION["user"]["email"]."'");

            }else{
                Database::iud("INSERT INTO `profile_image` (`path`,`user_email`) VALUES ('".$file_name."' , '".$_SESSION["user"]["email"]."')");
            }


        }
        
    }

    Database::iud("UPDATE `user` SET `fname` = '".$fname."' , `lname` = '".$lname."' , `mobile` = '".$mobile."'
            WHERE `email` = '".$_SESSION["user"]["email"]."'");
            

            $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '".$_SESSION["user"]["email"]."'");
            $address_rows = $address_rs->num_rows;


            if($address_rows == 1){
                Database::iud("UPDATE `user_has_address` SET `line1`='".$line1."' , `line2`='".$line2."' , `city_id`='".$city."' , `postal_code`='".$postalCode."'
                Where `user_email` = '".$_SESSION["user"]["email"]."'");
            }else{
                Database::iud("INSERT INTO `user_has_address` (`line1` , `line2` , `user_email` , `city_id` , `postal_code`) VALUES ('".$line1."' , '".$line2."' , '".$_SESSION["user"]["email"]."' , '".$city."' , '".$postalCode."') ");

            }

            echo "Successfully Updated!";

}else{
    echo "Please login first!";
}

?>