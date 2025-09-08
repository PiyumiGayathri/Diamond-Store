<?php
session_start();
require "connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header | Diamond</title>

    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <nav class="navbar bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand p-2" href="#">
                        <img src="resource/logo_title.png" class="d-inline-block align-text-top" style="height: 60px;">
                        <span class="headerTxt p-2 " style="font-family: PTSansBI;color: #001f3d;">Preciously Exclusive Gems...</span>
                    </a>
                </div>
            </nav>
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <?php
                if (!isset($_SESSION["user"])) {
                ?>
                    <button class="btn" style="cursor: pointer;background-color: #001f3d;margin-right:30px;"><a href="index.php" class="text-decoration-none text-white">Sign In | Sign Up</a></button>

                    <ul class="navbar-nav ">
                        <li class="nav-item" style="padding-right:30px;">
                            <a class="nav-link active" href="#">Help and Contact</a>
                        </li>
                        <li class="nav-item" style="padding-right:30px;">
                            <a class="nav-link active" href="#">Sell</a>
                        </li>
                        <li class="nav-item dropdown" style="padding-right:60px;">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                My Account
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">My Profile</a></li>
                                <li><a class="dropdown-item" href="#">My Sellings</a></li>
                                <li><a class="dropdown-item" href="#">My Store</a></li>
                                <li><a class="dropdown-item" href="#">Watchlist</a></li>
                                <li><a class="dropdown-item" href="#">Purchasing History</a></li>
                                <li><a class="dropdown-item" href="#">Chat</a></li>
                                <li><a class="dropdown-item" href="#">Saved items</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php

                } else {
                ?>
                    <ul class="navbar-nav ">
                        <li class="nav-item" style="padding-right:30px;">
                            <a class="nav-link active" href="userProfile.php">Welcome <?php echo $_SESSION["user"]["fname"] . " " . $_SESSION["user"]["lname"]; ?></a>
                        </li>
                        <li class="nav-item" style="padding-right:30px;">
                            <a class="nav-link btn" style="cursor: pointer;background-color: #001f3d;color: white;" onclick="signout();">Sign Out</a>
                        </li>
                        <li class="nav-item" style="padding-right:30px;">
                            <a class="nav-link active" href="home.php">Home</a>
                        </li>
                        <li class="nav-item" style="padding-right:30px;cursor:pointer;">
                            <a class="nav-link active" onclick="window.location.href = 'myProducts.php';">Sell</a>
                        </li>
                        <li class="nav-item dropdown" style="padding-right:50px;">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                My Account
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="userProfile.php">My Profile</a></li>
                                <li><a class="dropdown-item" href="myproducts.php">My Store</a></li>
                                <li><a class="dropdown-item" href="watchlist.php">Watchlist</a></li>
                                <li><a class="dropdown-item" href="cart.php">Cart</a></li>
                                <li><a class="dropdown-item" href="buyingHistory.php">Purchasing History</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php

                }
                ?>

            </div>
        </div>
    </nav>

    <script src="script.js"></script>
</body>

</html>