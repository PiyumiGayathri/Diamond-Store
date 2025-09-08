<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"])){
    $pid = $_GET["id"];
    $qty = $_GET["qty"];
    $email = $_SESSION["user"]["email"];

    $array ;
    $order_id = uniqid();

    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$pid."'");
    $product_data = $product_rs->fetch_assoc();

        $city_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='".$email."'");
        $city_num = $city_rs->num_rows;
        $merchant_id = "1221217";
        $merchant_secret = "MjU4ODg0NjE3NTcyNDA1NTgxMDI1MzIyMDI4NTczNDQyMDQ2Nzg=";
        $currency = "LKR";
    
        if($city_num == 1){
           
            $city_data = $city_rs->fetch_assoc();
    
            $city_id = $city_data["city_id"];
            $address = $city_data["line1"].", ".$city_data["line2"];
    
            
            $district_rs = Database::search("SELECT * FROM `city` WHERE `id`='".$city_id."'");
            $district_data = $district_rs->fetch_assoc();
    
            $district_id = $district_data["district_id"];
            $delivery = "0";
    
            if($district_id == "5"){
                //colombo district id 
                $delivery = $product_data["delivery_fee"];
            }else{
                $delivery = $product_data["delivery_fee_other"];
            }
    
            $item = $product_data["title"];
            $amount = ((int)$product_data["price"] * (int)$qty) + (int)$delivery;
    
            $fname = $_SESSION["user"]["fname"];
            $lname = $_SESSION["user"]["lname"];
            $mobile = $_SESSION["user"]["mobile"];
            $user_address = $address;
            $city = $district_data["name"];
    
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
    
            $array["id"] = $order_id;
            $array["item"] = $item;
            $array["amount"] = $amount;
            $array["fname"] = $fname;
            $array["lname"] = $lname;
            $array["mobile"] = $mobile;
            $array["address"] = $address;
            $array["city"] = $city;
            $array["mail"] = $email;
    
            echo json_encode($array);
            //convert the array to a json text
    
    
        }else{
            echo "2";
        }

   

}else{
    echo "1";
}

?>