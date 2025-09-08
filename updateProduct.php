<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product | Diamond </title>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="style.css">

    <link rel="icon" href="resource/logo_title.png">
</head>

<body>
    <div class="container-fluid" >
        <div class="row gy-4">
            <?php

            include "header.php";
            if (isset($_SESSION["product"])) {
                $product_id = $_SESSION["product"]["id"];
            ?>

                <div class="col-12 ">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="h1 fw-bold"><i class="bi bi-gem p-2 text-success"></i>Update Gemstone</h1>
                        </div>

                        <div class="col-12 mt-5 mb-5">
                            <div class="row">

                                <div class="col-12 col-lg-3 border border-success border-top-0 border-start-0 border-bottom-0">
                                    <div class="row">

                                        <div class="c12">
                                            <label class="form-label fw-bold" style="font-size:18px ;">Select Category</label>
                                        </div>

                                        <div class="col-12">
                                            <select class="form-select" id="category" disabled>
                                                <?php
                                                $category_rs = Database::search("SELECT category.id,category.name FROM `category` INNER JOIN `product` ON category.id=product.category_id WHERE product.id='" . $product_id . "'");
                                                $category_data = $category_rs->fetch_assoc();
                                                ?>
                                                <option value="<?php echo $category_data["id"]; ?>"><?php echo $category_data["name"]; ?></option>
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
                                            <select class="form-select" id="condition" disabled>
                                                <?php
                                                $condition_rs = Database::search("SELECT condition.id,condition.name FROM `condition` INNER JOIN `product` ON condition.id=product.condition_id WHERE product.id='" . $product_id . "'");
                                                $condition_data = $condition_rs->fetch_assoc();
                                                ?>
                                                <option value="<?php echo $condition_data["id"]; ?>"><?php echo $condition_data["name"]; ?></option>

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
                                            <select class="form-select" id="shape" disabled>
                                                <?php
                                                $cut_rs = Database::search("SELECT * FROM `cut` INNER JOIN `product` ON cut.id=product.cut_id WHERE product.id='" . $product_id . "'");
                                                $cut_data = $cut_rs->fetch_assoc();
                                                ?>
                                                <option value="<?php echo $cut_data["id"]; ?>"><?php echo $cut_data["name"]; ?></option>

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
                                            <select class="form-select" id="regions" disabled>
                                                <?php
                                                $region_rs = Database::search("SELECT region.id,region.name FROM `region` INNER JOIN `product` ON region.id=product.region_id WHERE product.id='".$product_id."'");
                                                $region_data = $region_rs->fetch_assoc();
                                                ?>
                                                <option value="<?php echo $region_data["id"]; ?>"><?php echo $region_data["name"]; ?></option>

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
                                                <button type="button" class="btn btn-primary" onclick="updateCertificate();">Save changes</button>
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
                                            <input type="text" class="form-control" id="l" value="<?php echo $_SESSION["product"]["length"] ;?>" disabled>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control" id="w" value="<?php echo $_SESSION["product"]["width"] ;?>" disabled>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control" id="d" value="<?php echo $_SESSION["product"]["depth"] ;?>" disabled>
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
                                    <input type="text" class="form-control" id="weight" value="<?php echo $_SESSION["product"]["weight"] ;?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 mt-5">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label fw-bold" style="font-size:18px ;">Title</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="title" value="<?php echo $_SESSION["product"]["title"] ;?>">
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

                                            <select class="form-select" id="clr" disabled>
                                                <?php
                                                $clr_rs = Database::search("SELECT color.id,color.name FROM `color` INNER JOIN `product` ON color.id=product.color_id WHERE product.id='".$product_id."'");
                                                    $clr_data = $clr_rs->fetch_assoc();

                                                ?>
                                                    <option value="<?php echo $clr_data["id"]; ?>"><?php echo $clr_data["name"]; ?></option>
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

                                            <select class="form-select" id="tone" disabled>
                                                <?php
                                                $tone_rs = Database::search("SELECT tone.id,tone.name FROM `tone` INNER JOIN `product` ON tone.id=product.tone_id WHERE product.id='".$product_id."'");
                                                    $tone_data = $tone_rs->fetch_assoc();

                                                ?>
                                                    <option value="<?php echo $tone_data["id"]; ?>"><?php echo $tone_data["name"]; ?></option>
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

                                            <select class="form-select" id="clarity" disabled>
                                                <?php
                                                $clarity_rs = Database::search("SELECT clarity.id,clarity.grade FROM `clarity` INNER JOIN `product` ON clarity.id=product.clarity_id WHERE product.id='".$product_id."'");
                                                    $clarity_data = $clarity_rs->fetch_assoc();

                                                ?>
                                                    <option value="<?php echo $clarity_data["id"]; ?>"><?php echo $clarity_data["grade"]; ?></option>
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
                    <input type="number" class="form-control" value="<?php echo $_SESSION["product"]["qty"] ;?>" min="0" id="qty">
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
                                <input type="text" class="form-control" id="cost" value="<?php echo $_SESSION["product"]["price"] ;?>" disabled>
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
                                        <input type="text" class="form-control" id="dc" value="<?php echo $_SESSION["product"]["delivery_fee"] ;?>">
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
                                        <input type="text" class="form-control" id="doc" value="<?php echo $_SESSION["product"]["delivery_fee_other"] ;?>">
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
                    <textarea cols="30" rows="15" class="form-control" id="desc"><?php echo $_SESSION["product"]["description"] ;?></textarea>
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



        <div class="offset-lg-4 col-12 col-lg-4 d-grid mt-5 mb-5">
            <button class="btn btn-danger" onclick="updateProduct();"><i class="bi bi-gem p-2">Update</i> </button>
        </div>

    </div>
    </div>


    </div>
    </div>


<?php
            } else {
?>
    <script>
        window.location.reload();
    </script>
<?php
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