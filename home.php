<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Diamond</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo_title.png">
</head>

<body>
    <div class="container-fluid vh-100 d-flex">
        <div class="row">
            <?php
            include "header.php";
            ?>

            <div class="col-12 justify-content-center">
                <div class="row mb-3">
                    <div class="input-group mb-3 col-12 col-lg-8">
                        <div class="col-8 offset-2 offset-lg-3 col-lg-6">

                            <div class="input-group mb-3 mt-3">
                                <input type="text" class="form-control" placeholder="Search Gemstones..." id="s">

                                <select class="form-select text-center" id="c">
                                    <option value="0">Select Category</option>

                                    <?php
                                    $category_rs = Database::search("SELECT * FROM `category` ORDER BY `name` ASC");
                                    $category_rows = $category_rs->num_rows;

                                    for ($x = 0; $x < $category_rows; $x++) {
                                        $category_data = $category_rs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo $category_data["id"]; ?>"><?php echo $category_data["name"]; ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>

                                <div class="col-2 col-lg-1">
                                    <a class="btn btn-secondary" onclick="homeSearch(0);">
                                        <i class="bi bi-search"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 d-none" id="home_Search">
                <div class="row">

                </div>
            </div>
            <div class="col-12 d-none d-lg-block shadow-lg">
                <div class="row">
                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active col-4 offset-4 ">
                                <img src="resource/logo_main_2.png" class="d-block">
                            </div>
                            <div class="carousel-item col-6 offset-3 w-100">
                                <img src="resource/themeGems/3.jpg" class="d-block">
                            </div>
                            <div class="carousel-item col-6 offset-3 w-100">
                                <img src="resource/themeGems/g.jpg" class="d-block">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <section style="background-color: #eee;">
                <div class="text-center container py-5">
                    <h4 class="mt-4 mb-5"><strong>All Categories</strong></h4>

                    <div class="row">

                        <?php

                        $category_rs2 = Database::search("SELECT * FROM `category`");
                        $category_rows2 = $category_rs2->num_rows;
                        for ($x = 0; $x < $category_rows; $x++) {
                            $category_data2 = $category_rs2->fetch_assoc();
                        ?>
                            <div class="col-lg-2 col-6 mb-4">
                                <div class="card">
                                    <div class="col-12">
                                        <?php
                                        if($category_data2["img_code"]== NULL){
                                            ?>
                                            <img src="resource/gems/emptyGem.png" class="center img-thumbnail border-white" style="height: 160px;" />
                                            <?php
                                        }else{
                                            ?>
                                            <img src="<?php echo $category_data2["img_code"]; ?>" class="center img-thumbnail border-white" style="height: 160px;" />
                                            <?php
                                        }
                                        
                                        ?>
                                        
                                    </div>
                                    <div class="card-body">

                                        <a class="text-center mb-3 fw-bold text-decoration-none" style="color:#001f3d ;" href="<?php echo "productPage.php?c_id=" . $category_data2["id"]; ?>">
                                            <?php echo $category_data2["name"]; ?>
                                        </a>
                                        <br>
                                        <a class="text-center  mb-3 text-danger text-decoration-none" style="color:#001f3d ;" href="<?php echo "productPage.php?c_id=" . $category_data2["id"]; ?>">
                                            See All
                                        </a>

                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>


                    </div>
                </div>
            </section>
            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>