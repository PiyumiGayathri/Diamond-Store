<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $email = $_SESSION["user"]["email"];
    $invoice_id = $_POST["id"];
    $text = $_POST["feed"];


    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y:m:d H:i:s");

    $feedback_rs = Database::search("SELECT * FROM `feedback` WHERE `invoice_id`='" . $invoice_id . "' AND `user_email`='" . $email . "'");
    $feedback_rows = $feedback_rs->num_rows;


    if ($feedback_rows == 0) {
       Database::iud("INSERT INTO `feedback` (`txt`,`date`,`invoice_id`,`user_email`) VALUES ('" . $text . "','" . $date . "','" . $invoice_id . "','" . $email . "')");

       $feed_rs = Database::search("SELECT * FROM `feedback` WHERE `invoice_id`='" . $invoice_id . "' AND `user_email`='" . $email . "'");

       $feed_data = $feedback_rs->fetch_assoc();
    
        $imgLength = sizeof($_FILES);

        if ($imgLength <= 3 && $imgLength > 0) {

            $allowed_image_extensions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

            for ($x = 1; $x < $imgLength; $x++) {
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

                        $file_name = "resource/feedbackImg/" . $email . "_" . $x . "_" . uniqid() . $new_img_extension;
                        move_uploaded_file($img_file["tmp_name"], $file_name);

                        Database::iud("INSERT INTO `feedback_img` (`code` , `feedback_id`) VALUES ('" . $file_name . "' , '" . $feed_data["id"] . "')");

                        echo "Images Saved successfully!";
                    } else {
                        echo "invalid image Type!";
                    }
                }
            }
        } else {
            echo "Invalid Image Count!";
        }
    }else{
        Database::iud("Update `feedback` SET `txt`='".$text."' , `date`='".$date."' WHERE `invoice_id`='".$invoice_id."' AND `user_Email`='".$email."'");
        
        echo "a";
    }
} else {
    echo "something went wrong!";
}
