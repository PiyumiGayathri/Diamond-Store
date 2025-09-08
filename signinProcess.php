<?php

session_start();
require "connection.php";


$email = $_POST["e"];
$password = $_POST["p"];
$rChecked = $_POST["r"];

//validate email,pw
if(empty($email) || empty($password)){
    echo "Fill All Fields First";
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo "Enter Valid Email";
}else if(strlen($email) > 100){
    echo "Incorrect Email";
}else if(strlen($password) > 20 || strlen($password) < 8){
    echo "Incorrect Password";
}else{
    $resultset = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' AND `password`='".$password."'");
    $rows = $resultset->num_rows;

    if($rows == 1){
        echo "Successfully Signed In!";
        $data = $resultset->fetch_assoc();
        $_SESSION["user"] = $data;

        if($rChecked == "true"){
            setcookie("email",$email,time()+(60*60*24*365));
            setcookie("password",$password,time()+(60*60*24*365));
        }else{
            setcookie("email" , "" ,  -1);
            setcookie("password" , "" ,  -1);
        }

    }else{
        echo "Invalid Email or Password";
    }
}

?>