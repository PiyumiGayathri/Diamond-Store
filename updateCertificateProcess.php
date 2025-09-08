<?php
session_start();
require "connection.php";

if (isset($_SESSION["product"])) {
    $product_id = $_SESSION["product"]["id"];
    if (isset($_FILES["certificate"])) {
        $image = $_FILES["certificate"];

        $allowedExts = array("pdf", "doc", "docx");

        $allowedMimeTypes = array('application/msword', 'application/pdf');

        $extension = explode(".", $_FILES["certificate"]['name']);
        $extension1 = end($extension);

        if (!(in_array($extension1, $allowedExts))) {
            die('Please provide another file type .');
        }

        if (in_array($_FILES["certificate"]["type"], $allowedMimeTypes)) {
            move_uploaded_file($_FILES["certificate"]["tmp_name"], "resource/certificates/" . $_FILES["certificate"]["name"]);
        } else {
            die('Please provide another file type .');
        }

        move_uploaded_file($image["tmp_name"], $_FILES["certificate"]['name']);

        $certificate_rs = Database::search("SELECT * FROM `certificate` WHERE `user_email`='" . $_SESSION["user"]["email"] . "' AND `status`='1' AND `product_id`='" . $product_id . "'");
        $certificate_rows = $certificate_rs->num_rows;

        if ($certificate_rows == 0) {
            Database::iud("INSERT INTO `certificate` (`code`,`status`,`user_email`,`product_id`) VALUES 
        ('" . $_FILES["certificate"]['name'] . "' , '0' ,'" . $_SESSION["user"]["email"] . "','" . $product_id . "')");
        } else {
            Database::iud("UPDATE `certificate` SET `code`='" . $_FILES["certificate"]['name'] . "',`status`='0' ");
        }

        echo "Successfully Saved!";
    }
}
