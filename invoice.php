<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice | Diamond</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="icon" href="resource/logo_title.png">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php
            include "header.php";

            if(isset($_GET["id"])){
                $oid = $_GET["id"];
                if (isset($_SESSION["user"])) {
                    $umail = $_SESSION["user"]["email"];
    
                
                ?>
    
                    <div class="col-12">
                        <hr>
                    </div>
    
                    <div class="col-12 btn-toolbar justify-content-end">
                        <button class="btn btn-dark me-2" onclick="printInvoice();"><i class="bi bi-printer-fill">Print</i></button>
                    </div>
    
                    <div class="col-12">
                        <hr>
                    </div>
    
                    <div class="col-12 p-5" id="page">
                        <div class="row">
    
                            <div class="col-6 ">
                                <div class="row">
                                    <div class="col-12 fw-bold text-start">
                                        <h5 class="mt-2">DIAMOND STORE</h5>
                                        <span>Niwithigala, Ratnapura, Sri Lanka</span><br>
                                        <span>+94 112 785694</span><br>
                                        <span>diamond.store@gmail.com</span>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-12">
                                <hr class="border border-1 border-dark">
                            </div>
    
                            <div class="col-12 mb-4">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="fw-bold">INVOICE TO : </h5>
    
                                        <?php
                                        $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $umail . "'");
                                        $address_data = $address_rs->fetch_assoc();
                                        ?>
    
                                        <h3><?php echo $_SESSION["user"]["fname"] . " " . $_SESSION["user"]["lname"]; ?></h3>
                                        <span><?php echo $address_data["line1"] . ", " . $address_data["line2"]; ?></span><br>
                                        <span><?php echo $umail; ?></span>
                                    </div>
    
                                    <?php
                                    $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $oid . "'");
                                    $invoice_data = $invoice_rs->fetch_assoc();
                                    ?>
    
                                    <div class="col-6 text-end mt-4">
                                        <h1 class="text-success">INVOICE <?php echo $invoice_data["id"]; ?></h1>
                                        <span class="fw-bold">Date & Time of invoice : </span><br>
                                        <span><?php echo $invoice_data["date"]; ?></span>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-12 mt-3" >
                                <table class="table">
                                    <thead>
                                        <tr class="border border-1 border-secondary">
                                            <th class="border border-1 border-secondary">#</th>
                                            <th class="border border-1 border-secondary">Order ID & Product</th>
                                            <th class="border border-1 border-secondary">Unit Price</th>
                                            <th class="border border-1 border-secondary">Quantity</th>
                                            <th class="border border-1 border-secondary text-center">Price</th>
                                        </tr>
                                    </thead>
    
                                    <tbody>
                                        <tr style="height :72px;">
                                            <td class=" fs-3 border border-1 border-secondary"><?php echo $invoice_data["id"]; ?></td>
                                            <td class="border border-1 border-secondary">
                                                <span class="fw-bold  p-2">ORDER ID : <?php echo $oid; ?></span><br>
    
                                                <?php
                                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $invoice_data["product_id"] . "'");
                                                $product_data = $product_rs->fetch_assoc();
                                                ?>
    
                                                <span class="fw-bold fs-4 p-2 "><?php echo $product_data["title"]; ?></span>
                                            </td>
                                            <td class="fw-bold fs-6 text-end pt-4 border border-1 border-secondary">Rs. <?php echo $product_data["price"]; ?>.00</td>
                                            <td class="fw-bold fs-6 text-end pt-4 border border-1 border-secondary"><?php echo $invoice_data["qty"]; ?></td>
                                            <td class="fw-bold fs-6 pt-4 p-5 border border-1 border-secondary">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <table >
                                                            <tr>
                                                                <?php
                                                                $city_rs = Database::search("SELECt * FROM `city` WHERE `id`='" . $address_data["city_id"] . "'");
                                                                $city_data = $city_rs->fetch_assoc();
    
                                                                $delivery = 0;
    
                                                                if ($city_data["district_id"] == "1") {  //colombo wala id eka denne
                                                                    $delivery = $product_data["delivery_fee"];
                                                                } else {
                                                                    $delivery = $product_data["delivery_fee_other"];
                                                                }
    
                                                                $t = $invoice_data["total"];
                                                                $g = $t - $delivery;
    
                                                                ?>
                                                                <td  style="font-size: 16px;">SUB TOTAL</td>
                                                                <td class="text-end " style="font-size: 18px;">Rs. <?php echo $g; ?>.00</td>
    
                                                            </tr>
                                                            <tr>
                                                                <td  style="font-size: 16px;">Delivery Fee</td>
                                                                <td class="text-end" style="font-size: 18px;">Rs. <?php echo $delivery; ?>.00</td>
    
                                                            </tr>
                                                            <tr>
                                                                <td  style="font-size: 16px;">GRAND TOTAL</td>
                                                                <td class="text-end text-danger" style="font-size: 18px;">Rs. <?php echo $t; ?>.00</td>
                                                            </tr>
                                                            <tr class="border border-2 border-dark"></tr>
                                                        </table>
                                                    </div>
                                                </div>
    
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 text-center mt-4" >
                                <span class="fs-1 fw-bold text-success">Thank You For Dealing With Us!</span>
                            </div>
    
                            <div class="col-12 border-start border-5 border-success mt-3 mb-3 rounded" style="background-color: #e7f2ff;">
                                <div class="row">
                                    <div class="col-12 mt-3 mb-3">
                                        <span><label class="form-label fw-bold fs-5">NOTICE : </label></span><br>
                                        <span class="text-decoration-underline">
                                        <label class="form-label fs-6 ">Purchased Items can Return Before 14 Days of Delivery. Terms and Conditions Apply.</label>
                                        </span>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-12">
                                <hr class="border border-1 border-primary">
                            </div>
    
                            <div class="col-12 text-center mb-3">
                                <label class="form-label fs-5 text-black-50 fw-bold">
                                    Invoice was created on a computer and it is valid wihout the signature and Seal.
                                </label>
                            </div>
    
                        </div>
                    </div>
                <?php
                }
            
            }else{
                echo "Can't access to this page now,  Try again later!";
            }

            include "footer.php";
            ?>
        </div>
    </div>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>