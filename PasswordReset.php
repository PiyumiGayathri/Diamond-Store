<?php
require "connection.php";

$email = $_POST["e"];
$newPw = $_POST["np"];
$nrwRp = $_POST["rp"];
$vCode = $_POST["vc"];

if(empty($email)){
    echo "Email address is required!";
}else if(empty($newPw)){
    echo "Enter New Password!";
}else if(empty($nrwRp)){
    echo "Retype the New Password!";
}else if(empty($vCode)){
    echo "Please Enter the Verification code Sent To Your Email!";
}else if(strlen($newPw) < 8 || strlen($newPw) > 20){
    echo "Password Should Between 8-20 Characters!";
}else if($newPw != $nrwRp){
    echo "Passwords Not Matched!";
}else{
    $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' AND `verification_code`='".$vCode."'");
    $rows = $rs->num_rows;

    if($rows == 1){

        Database::iud("UPDATE `user` SET `password`='".$newPw."' WHERE `email`='".$email."'");
        echo "Success!";

    }else{
        echo "Invalid Email or Verification Code!";
    }
}
?>