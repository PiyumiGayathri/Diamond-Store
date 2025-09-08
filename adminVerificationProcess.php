
<?php
require "connection.php";

require "mail/SMTP.php";
require "mail/PHPMailer.php";
require "mail/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST["e"])){
    $email = $_POST["e"];

    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email`='".$email."'");
    $admin_rows = $admin_rs->num_rows;

    if($admin_rows > 0){
        $code = uniqid();
        Database::iud("UPDATE `admin` SET `verification_code`='".$code."' WHERE `email`='".$email."'");

        $mail = new PHPMailer;

        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'piyumigayagd@gmail.com';
        $mail->Password = 'bdxfdamnwexoiaho';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('piyumigayagd@gmail.com', 'Admin Verification');
        $mail->addReplyTo('piyumigayagd@gmail.com', 'Admin Verification');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Admin Login Verification Code';
        $bodyContent = '<h1 style="color:blue;">Your Verification Code for Diamond Store: '.$code.'</h1>';
        $mail->Body    = $bodyContent;

        if(!$mail->send()){
            echo "Verification code sending failed";
        }else{
            echo "ok";
        }

    }else{
        echo "Invalid User!";
    }
}else{
    echo "Email Required!";
}
?>