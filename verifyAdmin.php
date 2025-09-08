<?php
session_start();

require "connection.php";

if(isset($_GET["v"])){

    $vCode = $_GET["v"];
    
    $admin = Database::search("SELECT * FROM `admin` WHERE `verification_code`='".$vCode."'");
    $admin_rows = $admin->num_rows;

    //verification code ekak awa hinda aniwaryen result eka unique wenna oni e hinda enne eka row ekai
    if($admin_rows == 1){
        $admin_data = $admin->fetch_assoc();
        $_SESSION["admin"] = $admin_data;

        echo "success!";
    }else{
        "Invalid Verification Code!";
    }

}else{
    echo "Please Enter Your Verification Code!";
}
?>