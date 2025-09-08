<?php

require "connection.php";

if(isset($_GET["email"])){

    $user_email = $_GET["email"];

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$user_email."'");
    $user_rows = $user_rs->num_rows;

    if($user_rows == 1){

        $user_data = $user_rs->fetch_assoc();

        if($user_data["status"] == 1){
            Database::iud("UPDATE `user` SET `status`= '2' WHERE `email`='".$user_email."'");
            echo ("Blocked!");
        }else if($user_data["status"] == 2){
            Database::iud("UPDATE `user` SET `status`= '1' WHERE `email`='".$user_email."'");
            echo ("Unblocked!");
        }

    }else{
        echo ("Couldn't find the User. Please try again later.");
    }

}else{
    echo ("Something went wrong.");
}

?>