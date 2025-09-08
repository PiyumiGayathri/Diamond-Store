<?php
require "connection.php";

require "mail/PHPMailer.php";
require "mail/Exception.php";
require "mail/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_GET["email"])) {
    $email = $_GET["email"];

    $email_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");

    if ($email_rs->num_rows == 1) {
        $vCode = uniqid();

        Database::iud("UPDATE `user` SET `verification_code`='" . $vCode . "' WHERE `email`='" . $email . "'");

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'piyumigayagd@gmail.com';
        $mail->Password = 'cujdwvahguiaaayi';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('piyumigayagd@gmail.com', 'Reset Password Diamond Auctions');
        $mail->addReplyTo('piyumigayagd@gmail.com', 'Reset Password Diamond Auctions');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Diamond Auctions Forgot Password Verification Code';
        $bodyContent = '<h1 style="color:green; ">Your Verification Code is: ' . $vCode . '</h1>';
        $mail->Body    = $bodyContent;

        if (!$mail->send()) {
            echo "Verification Code Sending Failed";
        } else {
            echo "Success!";
        }
    } else {
        echo "Invalid Email";
    }
}
?>