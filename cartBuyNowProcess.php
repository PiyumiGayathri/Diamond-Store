<?php
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    $email = $_SESSION["user"]["email"];

    $amount = $_GET["total"];

    $array;
    $order_id = uniqid();

    $user_rs = Database::search("SELECT * FROM `user` INNER JOIN `user_has_address` ON user.email = user_has_address.user_email 
    INNER JOIN `city` ON user_has_Address.city_id = city.id  WHERE `email`='" . $email . "'");
    $user_data = $user_rs->fetch_assoc();

    $address = $user_data["line1"] . ", " . $user_data["line2"];
    $merchant_id = "1221217";
    $merchant_secret = "MzMxNzE0MDEzMDE0MjU4Mzc3MDUyMDE0ODE2ODEwMjMxNDc1ODQyNA==";
    $currency = "LKR";

    $fname = $_SESSION["user"]["fname"];
    $lname = $_SESSION["user"]["lname"];
    $mobile = $_SESSION["user"]["mobile"];

    $item = $user_data["fname"]."_".$user_data["lname"].$order_id;

    if ($user_data["name"] != null) {
        $city = $user_data["name"];

        //create hash value
        $hash = strtoupper(
            md5(
                $merchant_id .
                    $order_id .
                    number_format($amount, 2, '.', '') .
                    $currency .
                    strtoupper(md5($merchant_secret))
            )
        );


        $array["merchent_id"] = $merchant_id;
        $array["hash"] = $hash;
        $array["item"] = $item;
        $array["id"] = $order_id;
        $array["amount"] = $amount;
        $array["fname"] = $fname;
        $array["lname"] = $lname;
        $array["mobile"] = $mobile;
        $array["address"] = $address;
        $array["city"] = $city;
        $array["mail"] = $email;

        echo json_encode($array);
        //convert the array to a json text   
    } else {
        echo "2";
    }
} else {
    echo "1";
}
