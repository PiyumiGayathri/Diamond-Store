<?php
session_start();
require "connection.php";

$product_id = 0;

if (isset($_SESSION["user"])) {
    $email = $_SESSION["user"]["email"];

    $category = $_POST["ca"];
    $shape = $_POST["s"];
    $region = $_POST["r"];
    $title = $_POST["t"];
    $length = $_POST["l"];
    $width = $_POST["w"];
    $depth = $_POST["d"];
    $weight = $_POST["weight"];
    $condition = $_POST["con"];
    $clr = $_POST["col"];
    $clarity = $_POST["clarity"];
    $tone = $_POST["tone"];
    $qty = $_POST["qty"];
    $price = $_POST["p"];
    $dc = $_POST["dc"];
    $doc = $_POST["doc"];
    $desc = $_POST["desc"];

    if ($category == "0") {
        echo "Please Enter a Category";
    } else if (empty($condition)) {
        echo "Please Enter the Condition of the Stone(s)";
    } else if ($shape == "0") {
        echo "Please Enter the Shape of Your Stone(s)";
    } else if ($region == "0") {
        echo "Please Enter the Region of Your Stone(s)";
    } else if (empty($title)) {
        echo "Please Enter a Title";
    } else if (empty($weight)) {
        echo "Please Enter the Weight of the Gem!";
    } else if (strlen($title <= 100)) {
        echo "Title should have lower than 100 characters";
    } else if (!is_numeric($length)) {
        echo "Invalid input for Length";
    } else if (!is_numeric($width)) {
        echo "Invalid input for width";
    } else if (!is_numeric($depth)) {
        echo "Invalid input for Deapthi";
    } else if ($clr == "0") {
        echo "Please Enter a Colour";
    } else if ($clarity == "0") {
        echo "Please Enter the Clarity of Your Stone";
    } else if ($tone == "0") {
        echo "Please Enter the colour tone of Your Stone";
    } else if (empty($qty)) {
        echo "Please Enter the Quantity of Gems you Enter to the System";
    } else if ($qty == "0" | $qty == "e" | $qty < 0) {
        echo "Invalid input for Quantity";
    } else if (empty($price)) {
        echo "Please Enter the Price of the stone(s)";
    } else if (!is_numeric($price)) {
        echo "Invalid input for Price";
    } else if (empty($dc)) {
        echo "Please Enter the Delivery Cost within Colombo";
    } else if (!is_numeric($dc)) {
        echo "Invalid input for Delivery Cost Within Colombo";
    } else if (empty($doc)) {
        echo "Please Enter Delivery Cost over Colombo";
    } else if (!is_numeric($doc)) {
        echo "Invalid input for Delivery Cost over Colombo";
    } else if (empty($desc)) {
        echo "Please Enter the Description of the Stone(s)";
    } else {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y:m:d H:i:s");

        Database::iud("INSERT INTO `product` (`title` , `price` , `length` , `width` , `depth` , `weight` , `qty` , `description` , `datetime_added` , `color_id` , `clarity_id` , `tone_id` , `cut_id` , `category_id` , `delivery_fee` , `delivery_fee_other` , `condition_id` , `status_id` , `user_email` , `region_id`)
    VALUES ('" . $title . "' , '" . $price . "' , '" . $length . "' , '" . $width . "' , '" . $depth . "' , '" . $weight . "' , '" . $qty . "' , '" . $desc . "' , '" . $date . "' , '" . $clr . "' , '" . $clarity . "' , '" . $tone . "' ,  '" . $shape . "' , '" . $category . "' , '" . $dc . "' , '" . $doc . "' , '" . $condition . "' , '1' , '" . $email . "' , '" . $region . "') ");

        echo ("Product Added successfully!");

        $product_id = Database::$connection->insert_id;

        $imgLength = sizeof($_FILES);

        if ($imgLength <= 3 && $imgLength > 0) {

            $allowed_image_extensions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

            for ($x = 0; $x < $imgLength; $x++) {
                if (isset($_FILES["i" . $x])) {

                    $img_file = $_FILES["i" . $x];
                    $file_extension = $img_file["type"];

                    if (in_array($file_extension, $allowed_image_extensions)) {

                        $new_img_extension;

                        if ($file_extension == "image/jpg") {
                            $new_img_extension = ".jpg";
                        } else if ($file_extension == "image/jpeg") {
                            $new_img_extension = ".jpeg";
                        } else if ($file_extension == "image/png") {
                            $new_img_extension = ".png";
                        } else if ($file_extension == "image/xml+svg") {
                            $new_img_extension = ".svg";
                        } else {
                            "Cannot Add this Image Type To the system!";
                        }

                        $file_name = "resource/gems/" . $title . "_" . $x . "_" . uniqid() . $new_img_extension;
                        move_uploaded_file($img_file["tmp_name"], $file_name);

                        Database::iud("INSERT INTO `image` (`code` , `product_id`) VALUES ('" . $file_name . "' , '" . $product_id . "')");

                        echo "Images Saved successfully!";
                    } else {
                        echo "invalid image Type!";
                    }
                }
            }
        } else {
            echo "Invalid Image Count!";
        }

        Database::iud("UPDATE `certificate` SET `status`='1', product_id='".$product_id."' WHERE `user_email`='".$email."' AND `status`= '0'");
    }
}
