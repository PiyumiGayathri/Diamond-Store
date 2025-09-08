<?php
require "connection.php";

$fname = $_POST["f"];
$lname = $_POST["l"];
$email = $_POST["e"];
$mobile = $_POST["m"];
$password = $_POST["p"];
$gender = $_POST["g"];

//validate signup data

if(empty($fname) || empty($lname) || empty($email) || empty($mobile) || empty($password)){
    echo "Every Field should Be Filled";
}else if(strlen($fname) > 50){
    echo "First Name Should Have Less Than 50 Characters";
}else if(strlen($lname) > 50){
    echo "Last Name Should Have Less Than 50 Characters";
}else if(strlen($email) > 100){
    echo "Email Should Have Less Than 50 Characters";
}else if(strlen($mobile) != 10){
    echo "Mobile Should Have 10 Characters";
}else if(strlen($password) < 8 || strlen($password) > 20){
    echo "Password Should Have 8-20 Characters";
}else if(strlen($fname) > 50){
    echo "First Name Should Have Less Than 50 Characters";
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo "Please Enter Valid Email";
}else if(!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/",$mobile)){
    echo "Please Enter Valid Mobile Number";
}else{
$user_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' OR `mobile`='".$mobile."'");
$user_rows = $user_rs->num_rows;

if($user_rows > 0){
    echo "User With This Email or Mobile Already Exists.";
}else{
    //set joined datetime
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone(($tz));
    $date = $d->format("Y-m-d H:i:s");

    Database::iud("INSERT INTO `user` (`email` , `fname` , `lname` , `mobile` , `password` , `joined_date` , `status` , `gender_id`)
    VALUES ('".$email."' , '".$fname."' , '".$lname."' , '".$mobile."' , '".$password."' , '".$date."' , '1' , '".$gender."')");

    echo "Success!";
}
}   
?>