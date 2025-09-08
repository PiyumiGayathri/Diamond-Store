<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products | Diamond</title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="resource/logo_title.png">
</head>

<body>
    <div class="container-fluid">
        <div class="row gy-4">
            <?php

            include "header.php";
            if (isset($_SESSION["user"])) {

            ?>

                <div class="col-12 ">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="h1 fw-bold"><i class="bi bi-gem p-2 text-success"></i>Add Gemstone</h1>
                        </div>

                        <div class="col-12 mt-5 mb-5">
                            <div class="row">

                                <div class="col-12 col-lg-3 border border-success border-top-0 border-start-0 border-bottom-0">
                                    <div class="row">

                                        <div class="c12">
                                            <label class="form-label fw-bold" style="font-size:18px ;">Select Category</label>
                                        </div>

                                        <div class="col-12">
                                            <select class="form-select" id="category">
                                                <option value="0">Select Category</option>
                                                <?php
                                                $category_rs = Database::search("SELECT * FROM `category` ");
                                                $category_rows = $category_rs->num_rows;

                                                for ($x = 0; $x < $category_rows; $x++) {
                                                    $category_data = $category_rs->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo $category_data["id"]; ?>"><?php echo $category_data["name"]; ?></option>

                                                <?php
                                                }
                                                ?>

                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 border border-success border-top-0 border-start-0 border-bottom-0">
                                    <div class="row">

                                        <div class="c12">
                                            <label class="form-label fw-bold" style="font-size:18px ;">Select Condition</label>
                                        </div>

                                        <div class="col-12">
                                            <select class="form-select" id="condition">
                                                <option value="0">Select Condition</option>
                                                <?php
                                                $condition_rs = Database::search("SELECT * FROM `condition` ");
                                                $condition_rows = $condition_rs->num_rows;

                                                for ($x = 0; $x < $condition_rows; $x++) {
                                                    $condition_data = $condition_rs->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo $condition_data["id"]; ?>"><?php echo $condition_data["name"]; ?></option>

                                                <?php
                                                }
                                                ?>

                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-lg-3 border border-success border-top-0 border-start-0 border-bottom-0">
                                    <div class="row">

                                        <div class="c12">
                                            <label class="form-label fw-bold" style="font-size:18px ;">Select Shape</label>
                                        </div>

                                        <div class="col-12">
                                            <select class="form-select" id="shape">
                                                <option value="0">Select Shape</option>
                                                <?php
                                                $cut_rs = Database::search("SELECT * FROM `cut` ");
                                                $cut_rows = $cut_rs->num_rows;

                                                for ($x = 0; $x < $cut_rows; $x++) {
                                                    $cut_data = $cut_rs->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo $cut_data["id"]; ?>"><?php echo $cut_data["name"]; ?></option>

                                                <?php
                                                }
                                                ?>

                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="row">

                                        <div class="c12">
                                            <label class="form-label fw-bold" style="font-size:18px ;">Found in</label>
                                        </div>

                                        <div class="col-12">
                                            <select class="form-select" id="regions">
                                                <option value="0">Select Region</option>
                                                <?php
                                                $region_rs = Database::search("SELECT * FROM `region` ");
                                                $region_rows = $region_rs->num_rows;

                                                for ($x = 0; $x < $region_rows; $x++) {
                                                    $region_data = $region_rs->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo $region_data["id"]; ?>"><?php echo $region_data["name"]; ?></option>

                                                <?php
                                                }
                                                ?>

                                            </select>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="col-12 mt-3 mb-5">
                            <div class="row">

                                <div class="col-12 col-lg-6 border border-success border-start-0 border-top-0 border-bottom-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size:18px ;">Add Images</label>
                                        </div>
                                        <div class="col-12 mt-4 p-4">
                                            <div class="row gap-2">
                                                <div class="col-3 border border-2 rounded">
                                                    <img src="resource/empty-folder.png" class="img-fluid" id="i0">
                                                </div>
                                                <div class="col-3 border border-2 rounded">
                                                    <img src="resource/empty-folder.png" class="img-fluid" id="i1">
                                                </div>
                                                <div class="col-3 border border-2 rounded">
                                                    <img src="resource/empty-folder.png" class="img-fluid" id="i2">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6 offset-2 mt-3">
                                            <input type="file" class="d-none" id="imageUploader" multiple>
                                            <label for="imageUploader" class="col-12 btn btn-success" onclick="changeProductImage();">Upload Images</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4 offset-lg-1">
                                    <label class="form-label fw-bold" style="font-size: 18px;">
                                        Gem Laboratory Certificate
                                    </label>

                                    <div class="col-4 mt-3">
                                        <label class="col-12 btn btn-success" onclick="openCModal();">Upload Certificate</label>
                                    </div>
                                </div>
                                <!-- modal -->
                                <div class="modal" tabindex="-1" id="cm">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger fw-bold">Upload Gem Lab Certificate</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-4 offset-4 border border-2 rounded mt-4">
                                                            <img src="resource/page.png" class="img-fluid" id="ci">
                                                        </div>
                                                        <div class="col-4 offset-4 mt-3">
                                                            <input type="file" id="imageUpCe" accept="application/pdf">
                                                        </div>

                                                        <label class="form-label mt-2 text-center">
                                                            <span class="text-danger">*</span> Please upload the certificate as a PDF document.
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" onclick="saveCertificate();">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- modal -->
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label fw-bold" style="font-size:18px ;">Dimensions (mm)</label>
                                </div>
                                <div class="col-12">
                                    <div class="row gap-1">

                                        <div class="col-3">
                                            <input type="text" class="form-control" id="l" placeholder="length"></input>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control" id="w" placeholder="width"></input>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control" id="d" placeholder="depth"></input>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6  mt-5 border border-success border-start-0 border-bottom-0 border-top-0">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label fw-bold" style="font-size:18px ;">Weight (cts)</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="weight">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 mt-5">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label fw-bold" style="font-size:18px ;">Title</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="title" placeholder="type title"></input>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <div class="row">

                                <div class=" col-12 col-lg-4 border border-success border-start-0 border-bottom-0 border-top-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size:18px ;">Select Colour</label>
                                        </div>
                                        <div class="col-8">

                                            <select class="form-select" id="clr">
                                                <option value="0">Select Colour</option>
                                                <?php
                                                $clr_rs = Database::search("SELECT * FROM `color`");
                                                $clr_rows = $clr_rs->num_rows;

                                                for ($a = 0; $a < $clr_rows; $a++) {
                                                    $clr_data = $clr_rs->fetch_assoc();

                                                ?>
                                                    <option value="<?php echo $clr_data["id"]; ?>"><?php echo $clr_data["name"]; ?></option>

                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-12 col-lg-4 border border-success border-start-0 border-bottom-0 border-top-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size:18px ;">Select Colour tone</label>
                                        </div>
                                        <div class="col-8">

                                            <select class="form-select" id="tone">
                                                <option value="0">Select Colour</option>
                                                <?php
                                                $tone_rs = Database::search("SELECT * FROM `tone`");
                                                $tone_rows = $tone_rs->num_rows;

                                                for ($a = 0; $a < $tone_rows; $a++) {
                                                    $tone_data = $tone_rs->fetch_assoc();

                                                ?>
                                                    <option value="<?php echo $tone_data["id"]; ?>"><?php echo $tone_data["name"]; ?></option>

                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-12 col-lg-4 border border-success border-start-0 border-bottom-0 border-top-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size:18px ;">Select Gem Clarity</label>
                                        </div>
                                        <div class="col-8">

                                            <select class="form-select" id="clarity">
                                                <option value="0">Select Colour</option>
                                                <?php
                                                $clarity_rs = Database::search("SELECT * FROM `clarity`");
                                                $clarity_rows = $clarity_rs->num_rows;

                                                for ($a = 0; $a < $clarity_rows; $a++) {
                                                    $clarity_data = $clarity_rs->fetch_assoc();

                                                ?>
                                                    <option value="<?php echo $clarity_data["id"]; ?>"><?php echo $clarity_data["grade"]; ?></option>

                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <div class="col-12 col-lg-6 mt-5">
            <div class="row">
                <div class="col-12">
                    <label class="form-label fw-bold" style="font-size:18px ;">Add Quantity</label>
                </div>
                <div class="col-6">
                    <input type="number" class="form-control" value="0" min="0" id="qty">
                </div>
            </div>
        </div>

        <div class="col-12 mt-5">
            <div class="row">

                <div class="col-12 col-lg-6 border border-success border-top-0 border-start-0 border-bottom-0">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label fw-bold" style="font-size:18px ;">Price</label>
                        </div>

                        <div class="col-12 col-lg-8">
                            <div class="input-group mb-2 mt-2 offset-1">
                                <span class="input-group-text bg-dark text-white">Rs.</span>
                                <input type="text" class="form-control" id="cost">
                                <span class="input-group-text bg-dark text-white">.00</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold" style="font-size:18px ;">Delivery Cost</label>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <label class="form-label text-black-50">Delivery Cost Within Colombo</label>
                                </div>
                                <div class="col-12 col-lg-8">
                                    <div class="input-group mb-2 mt-2 offset-1">
                                        <span class="input-group-text bg-dark text-white">Rs.</span>
                                        <input type="text" class="form-control" id="dc">
                                        <span class="input-group-text bg-dark text-white">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <label class="form-label text-black-50">Delivery Cost Out of Colombo</label>
                                </div>
                                <div class="col-12 col-lg-8">
                                    <div class="input-group mb-2 mt-2 offset-1">
                                        <span class="input-group-text bg-dark text-white">Rs.</span>
                                        <input type="text" class="form-control" id="doc">
                                        <span class="input-group-text bg-dark text-white">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>


        <div class="col-12 mt-5">
            <div class="row">
                <div class="col-12">
                    <label class="form-label fw-bold" style="font-size:18px ;">Description</label>
                </div>
                <div class="col-12">
                    <textarea cols="30" rows="15" class="form-control" id="desc"></textarea>
                </div>
            </div>
        </div>



        <div class="col-12 mt-5 p-4" style="background: rgb(242,242,242);
background: linear-gradient(90deg, rgba(242,242,242,1) 0%, rgba(132,140,213,1) 50%, rgba(255,255,255,1) 100%);">
            <label class="form-label fw-bold" style="font-size:18px ;">Notice...</label> <br>
            <label class="form-label">
                We are taking 3.5% bargain of the sold price of every
                gemstone you sell in this platform.
            </label>
        </div>

        <div class="offset-lg-4 col-12 col-lg-4 d-grid mt-5 mb-3">
            <button class="btn btn-danger" onclick="saveProduct();"><i class="bi bi-gem p-2">Save</i> </button>
        </div>

    </div>
    </div>


    </div>
    </div>


<?php
            } else {
                header("Location:home.php");
            }
?>


<?php
include "footer.php";
?>
</div>
</div>

<script src="bootstrap.bundle.js"></script>
<script src="script.js"></script>
</body>

</html>