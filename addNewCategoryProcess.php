<?php
session_start();
require "connection.php";

if (isset($_POST["name"])) {

    if(!empty($_POST["name"])){

        if ($_SESSION["admin"]["email"]) {

            $category_name = $_POST["name"];
    
            $category_rs = Database::search("SELECT * FROM `category` WHERE `name` LIKE '%" . $category_name . "%'");
            $category_rows = $category_rs->num_rows;
    
            if ($category_rows == 0) {
                Database::iud("INSERT INTO `category` (`name`) VALUES ('".$category_name."')");
                echo "Success!";
            } else {
                echo "This Category is Already Exist!";
            }
        } else {
            echo "Please Sign in again As Admin!";
        }

    }else{
        echo "Please Enteer a Category Name!";
    }
} else {
    "Something Missing!";
}

