<?php

require "connection.php";

$query1 = "SELECT * FROM `user`";
if (isset($_POST["user"])) {
    $query1 .= "WHERE `fname` LIKE '%" . $_POST["user"] . "%' OR `lname` LIKE '%" . $_POST["user"] . "%'";
}


?>

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
                            <div class="col-2 bg-light py-2 text-center col-lg-2">
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

                    $user_rs = Database::search($query1);
                    $user_rows = $user_rs->num_rows;

                    $users_per_page = 8;
                    $number_of_pages = ceil($user_rows / $users_per_page);

                    $page_results = ($page_no - 1) * $users_per_page;

                    $selected_rs = Database::search($query1 . " LIMIT " . $users_per_page . " OFFSET " . $page_results . "");
                    $selected_rows = $selected_rs->num_rows;

                    for ($x = 0; $x < $selected_rows; $x++) {
                        $selected_data = $selected_rs->fetch_assoc();
                    ?>
                        <div class="col-12 border border-1 border-dark">
                            <div class="row">
                                <div class="col-2 col-lg-2 bg-light py-2 text-center">
                                    <span class="fw-bold "><?php echo $selected_data['email']; ?></span>
                                </div>
                                <div class="col-4 col-lg-1 bg-light py-2 text-center">
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
                                <div class="col-2 bg-light py-2 text-center">
                                    <span><?php echo $selected_data["mobile"]; ?></span>
                                </div>
                                <div class="col-2 bg-light py-2 text-center d-none d-lg-block">
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




            