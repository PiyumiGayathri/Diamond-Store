<?php
require "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | Admins | Diamond</title>

    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="resource/logo_title.png">
</head>

<body style="background-color: #001f3d;">

    <div class="container-fluid" id="a">
        <div class="row">
            <div class=" col-12 text-center">
                <label class="form-label text-white fs-1 mt-4">Manage Users</label>
            </div>

            <div class="col-12 mt-3">
                <div class="row">
                    <div class="offset-0 offset-lg-3 col-12 col-lg-6 mb-3">
                        <div class="row">
                            <div class="col-9">
                                <input type="text" class="form-control" placeholder="Search by product name" id="user">
                            </div>
                            <div class="col-3 d-grid">
                                <button class="btn btn-info" onclick="searchUser();">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" id="table">
                <div class="row">

                    <div class="col-12 mt-3 ">
                        <div class="row">
                            <div class="col-4 col-lg-2 bg-light py-2  text-center">
                                <span class="fw-bold">Email</span>
                            </div>
                            <div class="col-2 bg-light col-lg-1  py-2 text-center">
                                <span class="fw-bold">Password</span>
                            </div>
                            <div class="col-2 d-none d-lg-block bg-light py-2 col-lg-2  text-center">
                                <span class="fw-bold">Profile Picture</span>
                            </div>
                            <div class="col-4 col-lg-2 bg-light py-2 d-none d-lg-block text-center">
                                <span class="fw-bold">Full Name</span>
                            </div>
                            <div class="col-4 bg-light py-2 text-center col-lg-2">
                                <span class="fw-bold">Contact Number</span>
                            </div>
                            <div class="col-2 bg-light col-lg-2  py-2 d-none d-lg-block  text-center">
                                <span class="fw-bold">Registered Date</span>
                            </div>
                            <div class="col-2 col-lg-1 bg-light text-center">
                                <span class="fw-bold">Block / Unblock</span>
                            </div>
                        </div>
                    </div>

                    <?php

                    $query = "SELECT * FROM `user`";
                    $page_no;

                    if (isset($_GET["page"])) {
                        $page_no = $_GET["page"];
                    } else {
                        $page_no = 1;
                    }

                    $user_rs = Database::search($query);
                    $user_rows = $user_rs->num_rows;

                    $users_per_page = 8;
                    $number_of_pages = ceil($user_rows / $users_per_page);

                    $page_results = ($page_no - 1) * $users_per_page;

                    $selected_rs = Database::search($query . " LIMIT " . $users_per_page . " OFFSET " . $page_results . "");
                    $selected_rows = $selected_rs->num_rows;

                    for ($x = 0; $x < $selected_rows; $x++) {
                        $selected_data = $selected_rs->fetch_assoc();
                    ?>
                        <div class="col-12 border border-1 border-dark">
                            <div class="row">
                                <div class="col-4 col-lg-2 bg-light py-2 text-center">
                                    <span class="fw-bold "><?php echo $selected_data['email']; ?></span>
                                </div>
                                <div class="col-2 col-lg-1 bg-light py-2 text-center">
                                    <span><?php echo $selected_data["password"]; ?></span>
                                </div>
                                <div class="col-2 bg-light py-2 d-none d-lg-block" onclick="viewUserModal('<?php echo $selected_data['email'];?>');">
                                    <?php
                                    $image_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $selected_data["email"] . "'");
                                    $image_num = $image_rs->num_rows;
                                    if ($image_num == 0) {
                                    ?>
                                        <img src="resource/users/uAva.png" style="height: 40px;margin-left: 80px;" />
                                    <?php
                                    } else {
                                        $image_data = $image_rs->fetch_assoc();
                                    ?>
                                        <img src="<?php echo $image_data["path"]; ?>" style="height: 40px;margin-left: 80px;" />
                                    <?php
                                    }

                                    ?>
                                </div>
                                <div class="col-4 col-lg-2 bg-light py-2 text-center  d-none d-lg-block">
                                    <span><?php echo $selected_data["fname"]; ?> <?php echo $selected_data["lname"]; ?></span>
                                </div>
                                <div class="col-4 bg-light py-2 text-center col-lg-2">
                                    <span><?php echo $selected_data["mobile"]; ?></span>
                                </div>
                                <div class="col-2 bg-light py-2 text-center d-none d-lg-block col-lg-2">
                                    <span><?php echo $selected_data["joined_date"]; ?></span>
                                </div>
                                <div class="col-2 col-lg-1 bg-light py-2 d-grid">
                                    <?php
                                    if ($selected_data["status"] == 1) {
                                    ?>
                                        <button class="btn btn-outline-danger" id="pb<?php echo $selected_data['email']; ?>" onclick="blockUser('<?php echo $selected_data['email']; ?>');">Block</button>
                                    <?php
                                    } else {

                                    ?>
                                        <button class="btn btn--outline-success" id="pb<?php echo $selected_data['email']; ?>" onclick="blockUser('<?php echo $selected_data['email']; ?>');">Unblock</button>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>

                        <!-- modal 1 -->
                        <div class="modal" tabindex="-1" id="viewUserModal<?php echo $selected_data["email"]; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold text-primary"><?php echo $selected_data["fname"]; ?> <?php echo $selected_data["lname"]; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="offset-4 col-4">
                                            <?php
                                            $img_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $selected_data["email"] . "'");
                                            $img_data = $img_rs->fetch_assoc();
                                            
                                            if($img_rs->num_rows > 0){
                                                ?>
                                                <img src="<?php echo $img_data["path"]; ?>" class="img-fluid" style="height: 150px;" />
                                                <?php
                                            }else{
                                                ?>
                                                 <img src="resource/users/uAva.png" class="img-fluid" style="height: 150px;" />
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <span class="fs-5 fw-bold">User Name :</span>&nbsp;
                                            <span class="fs-5 text-danger"><?php echo $selected_data["fname"]; ?> <?php echo $selected_data["lname"]; ?></span><br />
                                            <span class="fs-5 fw-bold">Email :</span>&nbsp;
                                            <span class="fs-5">Rs. <?php echo $selected_data["email"]; ?></span><br />
                                            <span class="fs-5 fw-bold">Mobile :</span>&nbsp;
                                            <span class="fs-5"><?php echo $selected_data["mobile"]; ?></span><br />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal 1 -->

                    <?php
                    }

                    ?>

                </div>
            </div>




            <!--  -->
            <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-lg justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="<?php

                                                        if ($page_no <= 1) {
                                                            echo "#";
                                                        } else {
                                                            echo "?page=" . ($page_no - 1);
                                                        }
                                                        ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php
                        for ($x = 1; $x <= $number_of_pages; $x++) {
                            if ($x == $page_no) {
                        ?>
                                <li class="page-item active">
                                    <a class="page-link" href="<?php
                                                                echo "?page=" . $x;
                                                                ?>"><?php echo $x; ?></a>
                                </li>
                            <?php

                            } else {
                            ?>
                                <li class="page-item ">
                                    <a class="page-link" href="<?php
                                                                echo "?page=" . $x;
                                                                ?>"><?php echo  $x; ?></a>
                                </li>
                        <?php
                            }
                        }
                        ?>


                        <li class="page-item">
                            <a class="page-link" href="<?php

                                                        if ($page_no >= $number_of_pages) {
                                                            echo "#";
                                                        } else {
                                                            echo "?page=" . ($page_no + 1);
                                                        }
                                                        ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <script src="bootstrap.bundle.js"></script>
            <script src="script.js"></script>
</body>

</html>