function changeForm() {
    var signin = document.getElementById("signIn");
    var signup = document.getElementById("signUp");

    signin.classList.toggle("d-none");
    signup.classList.toggle("d-none");
}

function signup() {
    var fname = document.getElementById("f");
    var lname = document.getElementById("l");
    var email = document.getElementById("e");
    var password = document.getElementById("p");
    var mobile = document.getElementById("m");
    var gender = document.getElementById("g");

    var form = new FormData();
    form.append("f", fname.value);
    form.append("l", lname.value);
    form.append("e", email.value);
    form.append("p", password.value);
    form.append("m", mobile.value);
    form.append("g", gender.value);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "Success!") {
                alert("Signed Up successfully!");
                window.location.reload();
            } else {

                alert(response);
            }
        }
    }
    request.open("POST", "signupProcess.php", true);
    request.send(form);
}

function signin() {
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var rememberMe = document.getElementById("rMe");

    var form = new FormData();
    form.append("e", email.value);
    form.append("p", password.value);
    form.append("r", rememberMe.checked);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "Successfully Signed In!") {
                window.location.replace("home.php");
            } else {
                alert(response);
            }
        }
    };
    request.open("POST", "signinProcess.php", true);
    request.send(form);

}

var resetPwModal;

function forgotPw() {
    var email = document.getElementById("email");

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "Success!") {
                alert("Verification Code Sent To Your email!");
                var modal = document.getElementById("newPwModal");
                resetPwModal = new bootstrap.Modal(modal);
                resetPwModal.show();
            } else {
                alert(response);
            }
        }
    };
    request.open("GET", "forgotPwProcess.php?email=" + email.value, true);
    request.send();

}

function show1() {
    var newP = document.getElementById("newP");
    var eye = document.getElementById("eye");

    if (newP.type == "password") {
        newP.type = "text";
        eye.className == "bi bi-eye";
    } else {
        newP.type = "password";
        eye.className == "bi bi-eye-slash-fill";
    }

}

function show2() {
    var newRp = document.getElementById("newRp");
    var eye = document.getElementById("eye");

    if (newRp.type == "password") {
        newRp.type = "text";
        eye.className == "bi bi-eye";
    } else {
        newRp.type = "password";
        eye.className == "bi bi-eye-slash-fill";
    }


}

function saveNewPw() {
    var vCode = document.getElementById("vCode");
    var newP = document.getElementById("newP");
    var newRp = document.getElementById("newRp");
    var email = document.getElementById("email");

    var form = new FormData();
    form.append("e", email.value);
    form.append("np", newP.value);
    form.append("rp", newRp.value);
    form.append("vc", vCode.value);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "Success!") {
                resetPwModal.hide();
                alert("New Password Saved Successfully!");
            } else {
                alert(response);
            }

        }


    };
    request.open("POST", "PasswordReset.php", true);
    request.send(form);
}

function signout() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "success!") {
                window.location.reload();
            } else {
                alert(response);
            }


        }

    };
    request.open("GET", "signoutProcess.php", true);
    request.send();
}

function changeImage() {
    var view = document.getElementById("viewImg");
    var file = document.getElementById("profileImg");

    file.onchange = function () {
        var file1 = this.files[0];
        var url = window.URL.createObjectURL(file1);
        //create temporary URL 
        view.src = url;
    }
}

function updateProfile() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var mobile = document.getElementById("mobile");
    var line1 = document.getElementById("line1");
    var line2 = document.getElementById("line2");
    var province = document.getElementById("province");
    var district = document.getElementById("district");
    var city = document.getElementById("city");
    var postalCode = document.getElementById("pcode");
    var image = document.getElementById("profileImg");

    var form = new FormData();
    form.append("fn", fname.value);
    form.append("ln", lname.value);
    form.append("m", mobile.value);
    form.append("l1", line1.value);
    form.append("l2", line2.value);
    form.append("p", province.value);
    form.append("d", district.value);
    form.append("c", city.value);
    form.append("pc", postalCode.value);

    if (image.files.length == 0) {
        var confirmation = confirm("Are you sure you don't want to update Profile image?");

        if (confirmation) {
            //confirmation kiyana eka functin ekak
            alert("you have not selected any image!");
        }

    } else {
        form.append("image", image.files[0]);
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            alert(response);

        }

    };
    request.open("POST", "updateProfileProcess.php", true);
    request.send(form);
}

function showPassword() {
    var input = document.getElementById("pw");
    var eye = document.getElementById("eye");

    if (input.type == "password") {
        input.type = "text";
        eye.className = "bi bi-eye-fill";
    } else {
        input.type = "password";
        eye.className = "bi bi-eye-slash-fill";
    }
}

function sortProduct(page, id) {
    var search = document.getElementById("search").value;
    var priceTo = document.getElementById("pt").value;
    var priceFrom = document.getElementById("pf").value;
    var sortPrice = document.getElementById("ps").value;
    var length = document.getElementById("length").value;
    var width = document.getElementById("width").value;
    var depth = document.getElementById("depth").value;
    var region = document.getElementById("region").value;
    var shape = document.getElementById("shape").value;
    var condition = document.getElementById("condition").value;

    var time = "0";
    if (document.getElementById("n").checked) {
        time = "1";
    } else if (document.getElementById("o").checked) {
        time = "2";
    }

    var form = new FormData();
    form.append("search", search);
    form.append("pt", priceTo);
    form.append("pf", priceFrom);
    form.append("ps", sortPrice);
    form.append("l", length);
    form.append("w", width);
    form.append("d", depth);
    form.append("r", region);
    form.append("s", shape);
    form.append("c", condition);
    form.append("t", time);


    form.append("p", page);
    form.append("c_id", id);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            document.getElementById("sort").innerHTML = response;
        }

    };

    request.open("POST", "productPageSortProcess.php", true);
    request.send(form);

}


function clearSort() {
    window.location.reload();
}

function homeSearch(page) {
    var search = document.getElementById("s").value;
    var category = document.getElementById("c").value;

    var form = new FormData();
    form.append("s", search);
    form.append("c", category);
    form.append("p", page);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            document.getElementById("home_Search").className = "d-block";
            document.getElementById("home_Search").innerHTML = response;

        }

    };

    request.open("POST", "homeSearchProcess.php", true);
    request.send(form);
}



function changeProductImage() {
    var image = document.getElementById("imageUploader");

    image.onchange = function () {

        var file_count = image.files.length;

        if (file_count <= 3) {

            for (var x = 0; x < file_count; x++) {

                var file = this.files[x];
                var url = window.URL.createObjectURL(file);
                document.getElementById("i" + x).src = url;

            }

        } else {
            alert("You can only add upto 3 images");
        }
    }
}


function saveProduct() {
    var category = document.getElementById("category");
    var condition = document.getElementById("condition");
    var shape = document.getElementById("shape");
    var length = document.getElementById("l");
    var width = document.getElementById("w");
    var depth = document.getElementById("d");
    var title = document.getElementById("title");
    var weight = document.getElementById("weight");
    var region = document.getElementById("regions");
    var colour = document.getElementById("clr");
    var tone = document.getElementById("tone");
    var clarity = document.getElementById("clarity");
    var qty = document.getElementById("qty");
    var price = document.getElementById("cost");
    var dc = document.getElementById("dc");
    var doc = document.getElementById("doc");
    var description = document.getElementById("desc");
    var dc = document.getElementById("dc");

    var productImg = document.getElementById("imageUploader");
    // var certificateImg = document.getElementById("imageUpCe");

    var f = new FormData();
    f.append("ca", category.value);
    f.append("s", shape.value);
    f.append("r", region.value);
    f.append("t", title.value);
    f.append("l", length.value);
    f.append("w", width.value);
    f.append("d", depth.value);
    f.append("weight", weight.value);
    f.append("con", condition.value);
    f.append("col", colour.value);
    f.append("tone", tone.value);
    f.append("clarity", clarity.value);
    f.append("qty", qty.value);
    f.append("p", price.value);
    f.append("dc", dc.value);
    f.append("doc", doc.value);
    f.append("desc", description.value);

    var file_count = productImg.files.length;

    for (var x = 0; x < file_count; x++) {
        f.append("i" + x, productImg.files[x]);
    }

    // f.append("certificateImg", certificateImg.files[0]);


    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            // if (response = "Images Saved successfully!") {
            //     window.location.reload();
            // } else {
            //     alert(response);
            // }
            alert(response);
        }
    }
    request.open("POST", "addProductProcess.php", true);
    request.send(f);
}

var m;

function openCModal() {
    var modal = document.getElementById("cm");
    m = new bootstrap.Modal(modal);
    m.show();
}

function saveCertificate(id) {
    var fileC = document.getElementById("imageUpCe");

    var form = new FormData();
    form.append("certificate", fileC.files[0])

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            alert(response);
        }
    };
    request.open("POST", "saveCertificateProcess.php", true);
    request.send(form);
}


function myProducts_sort(page) {
    var search = document.getElementById("myProducts_search").value;

    var sortPrice = document.getElementById("sort").value;

    var region = document.getElementById("r").value;
    var shape = document.getElementById("s").value;
    var condition = document.getElementById("c").value;

    var time = "0";
    if (document.getElementById("new").checked) {
        time = "1";
    } else if (document.getElementById("old").checked) {
        time = "2";
    }

    var form = new FormData();
    form.append("search", search);
    form.append("ps", sortPrice);
    form.append("r", region);
    form.append("s", shape);
    form.append("c", condition);
    form.append("t", time);

    form.append("p", page);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            document.getElementById("productCard").innerHTML = response;
        }

    };

    request.open("POST", "myProductsSortProcess.php", true);
    request.send(form);

}

function changeStatus(id) {
    var product_id = id;

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "Deactivated!") {

                alert("Product Deactivated!");
                window.location.reload();

            } else if (response == "Activated!") {

                alert("Product Activated!");
                window.location.reload();

            } else {
                alert(response);
            }

        }
    }
    request.open("GET", "changeStatusProcess.php?p=" + product_id, true);
    request.send();
}

function product(id) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "Success!") {
                window.location = "updateProduct.php";
            } else {
                alert(response);
            }

        }
    }
    request.open("GET", "createProduct.php?id=" + id, true);
    request.send();
}

function updateProduct() {
    var title = document.getElementById("title");
    var qty = document.getElementById("qty");
    var description = document.getElementById("desc");
    var delivery_within_colombo = document.getElementById("dc");
    var delivery_out_of_colombo = document.getElementById("doc");
    var images = document.getElementById("imageUploader");
    // var imgCe = document.getElementById("imageUploaderCertificate");

    var form = new FormData();
    form.append("t", title.value);
    form.append("q", qty.value);
    form.append("des", description.value);
    form.append("dwc", delivery_within_colombo.value);
    form.append("doc", delivery_out_of_colombo.value);

    var img_count = images.files.length;
    for (x = 0; x < img_count; x++) {
        form.append("i" + x, images.files[x]);
    }

    // form.append("certificateImg", certificateImg.files[0]);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            alert(response);
        }
    }
    request.open("POST", "updateProductProcess.php", true);
    request.send(form);
}

function updateCertificate() {
    var fileC = document.getElementById("imageUpCe");

    var form = new FormData();
    form.append("certificate", fileC.files[0])

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            alert(response);
        }
    };
    request.open("POST", "updateCertificateProcess.php", true);
    request.send(form);
}

function searchWatchlist() {
    var txt = document.getElementById("searchWTxt");

    var form = new FormData();
    form.append("txt", txt.value);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            document.getElementById("wProduct").innerHTML = response;

        }
    }
    request.open("POST", "watchlistSearchProcess.php", true);
    request.send(form);
}

function checkValue(qty) {
    var input = document.getElementById("qtyInput");
    if (input.value <= 0) {
        alert("Quantity must be 1 or more!");
        input.value = 1;
    } else if (input.value > qty) {
        alert("Maximum Quantity Arrived!");
        input.value = qty;
    }
}


function qty_inc(qty) {
    var input = document.getElementById("qtyInput");
    if (input.value < qty) {
        var newValue = parseInt(input.value) + 1;
        input.value = newValue.toString();
    } else {
        alert("Maximum Quantity has Achieved!");
        input.value = qty;
    }

}

function qty_dec() {
    var input = document.getElementById("qtyInput");
    if (input.value > 1) {
        var newValue = parseInt(input.value) - 1;
        input.value = newValue.toString();
    } else {
        alert("Minimum Quantity has Achieved!");
        input.value = 1;
    }
}

function removeProductFromCart(id) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "Success!") {
                window.location.reload();
            } else {
                alert(response);
            }

        }
    }
    request.open("GET", "removeFromCartProcess.php?id=" + id, true);
    request.send();
}

function checkout(total){
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            var obj = JSON.parse(response);

            var mail = obj["mail"];

            if (response == "1") {
                alert("Please Signin or Signup First!");
                window.location = "index.php";
            } else if (response == "2") {
                alert("We can't verify your address,Please update your profile first!");
                window.location = "userProfile.php";

            } else {

                // Payment completed. It can be a successful failure.
                payhere.onCompleted = function onCompleted(orderId) {

                    console.log("Payment completed. OrderID:" + orderId);
                    // Note: validate the payment and show success or failure page to the customer

                    // savePayment(orderId, id, mail, amount, qty);
                };

                // Payment window closed
                payhere.onDismissed = function onDismissed() {
                    // Note: Prompt user to pay again or show an error page
                    console.log("Payment dismissed");
                };

                // Error occurred
                payhere.onError = function onError(error) {
                    // Note: show an error page
                    console.log("Error:" + error);
                };

                // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": "1221217", // Replace your Merchant ID,
                    "hash": obj["hash"],
                    "return_url": "http://localhost/auction/singleProduct.php?id=" + obj["mobile"], // Important
                    "cancel_url": "http://localhost/auction/singleProduct.php?id=" + obj["mobile"], // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": obj["id"],
                    "items": obj["item"],
                    "amount": total,
                    "currency": "LKR",
                    "first_name": obj["fname"],
                    "last_name": obj["lname"],
                    "email": mail,
                    "phone": obj["mobile"],
                    "address": obj["address"],
                    "city": obj["city"],
                    "country": "Sri Lanka",
                    "delivery_address": obj["address"],
                    "delivery_city": obj["city"],
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": "",
                };

                // Show the payhere.js popup, when "PayHere Pay" is clicked
                // document.getElementById('payhere-payment').onclick = function(e) {
                payhere.startPayment(payment);
                // };
            }
        }
    }
    request.open("GET", "cartBuyNowProcess.php?total="+2000, true);
    request.send();
}

function removeFromWatchlist(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "successfully Removed!") {
                window.location.reload();
            } else {
                alert(response);
            }

        }
    }

    request.open("GET", "removeWatchlistProcess.php?id=" + id, true);
    request.send();

}


function searchCart() {
    var txt = document.getElementById("cartSearch");

    var form = new FormData();
    form.append("txt", txt.value);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            document.getElementById("cartProduct").innerHTML = response;

        }
    }
    request.open("POST", "cartSearchProcess.php", true);
    request.send(form);
}

function addToCart(id) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            alert(response);

        }
    }

    request.open("GET", "addToCartProcess.php?id=" + id, true);
    request.send();
}

function addToWatchlist(id) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            alert(response);
            window.location.reload();

        }
    }
    request.open("GET", "addToWatchlistProcess.php?id=" + id, true);
    request.send();
}

function loadMainImg(id) {
    var img = document.getElementById("productImg" + id).src;
    var mainImg = document.getElementById("mainImg");
    mainImg.style.backgroundImage = "url(" + img + ")";
}

function openCertificate(id) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            var URL = "resource/certificates/" + response;

            function download(url) {
                const a = document.createElement('a')
                a.href = url
                a.download = url.split('/').pop()
                document.body.appendChild(a)
                a.click()
                document.body.removeChild(a)
            }

            download(URL);

        }
    }
    request.open("GET", "openCertificateProcess.php?id=" + id, true);
    request.send();
}

function buyNow(id) {
    var qty = document.getElementById("qtyInput").value;
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            var obj = JSON.parse(response);

            var mail = obj["mail"];
            var amount = obj["amount"];

            if (response == "1") {
                alert("Please Signin or Signup First!");
                window.location = "index.php";
            } else if (response == "2") {
                alert("We can't verify your address,Please update your profile first!");
                window.location = "userProfile.php";

            } else {

                // Payment completed. It can be a successful failure.
                payhere.onCompleted = function onCompleted(orderId) {

                    console.log("Payment completed. OrderID:" + orderId);
                    // Note: validate the payment and show success or failure page to the customer

                    savePayment(orderId, id, mail, amount, qty);
                };

                // Payment window closed
                payhere.onDismissed = function onDismissed() {
                    // Note: Prompt user to pay again or show an error page
                    console.log("Payment dismissed");
                };

                // Error occurred
                payhere.onError = function onError(error) {
                    // Note: show an error page
                    console.log("Error:" + error);
                };

                // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": "1221217", // Replace your Merchant ID,
                    "hash": obj["hash"],
                    "return_url": "http://localhost/auction/singleProduct.php?id=" + id, // Important
                    "cancel_url": "http://localhost/auction/singleProduct.php?id=" + id, // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": obj["id"],
                    "items": obj["item"],
                    "amount": amount,
                    "currency": "LKR",
                    "first_name": obj["fname"],
                    "last_name": obj["lname"],
                    "email": mail,
                    "phone": obj["mobile"],
                    "address": obj["address"],
                    "city": obj["city"],
                    "country": "Sri Lanka",
                    "delivery_address": obj["address"],
                    "delivery_city": obj["city"],
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": "",
                };

                // Show the payhere.js popup, when "PayHere Pay" is clicked
                // document.getElementById('payhere-payment').onclick = function(e) {
                payhere.startPayment(payment);
                // };
            }
        }
    }
    request.open("GET", "buyNowProcess.php?id=" + id + "&qty=" + qty, true);
    request.send();

}

function savePayment(orderId, id, mail, amount, qty) {
    var form = new FormData();
    form.append("o", orderId);
    form.append("i", id);
    form.append("m", mail);
    form.append("a", amount); // product price + delivery fee
    form.append("q", qty);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            if (response == "1") {
                window.location = "invoice.php?id=" + orderId;
            } else {
                alert(response);
            }
        }

    }
    request.open("POST", "savePaymentToInvoice.php", true);
    request.send(form);
}

function printInvoice() {
    var body = document.body.innerHTML;
    var page = document.getElementById("page").innerHTML;
    document.body.innerHTML = page;
    window.print();
    document.body.innerHTML = body;
}

// function deleteProduct(id) {
//     var request = new XMLHttpRequest();
//     request.onreadystatechange = function () {
//         if (request.readyState == 4) {
//             var response = request.responseText;
//             alert(response);
//             window.location.reload();
//         }

//     }
//     request.open("GET", "buyingHistoryDeleteProduct.php?id=" + id, true);
//     request.send();
// }

function deleteAll() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            alert(response);
            window.location.reload();
        }

    }
    request.open("GET", "buyingHistoryDeleteAll.php", true);
    request.send();
}

var fm;

function openFeedback(id) {

    var feedbackModal = document.getElementById("feedbackModal" + id);
    fm = new bootstrap.Modal(feedbackModal);
    fm.show();

    // request.open("GET", "addFeedbackProcess.php?id="+id, true);
    // request.send();
}

function changeFeedbackImage() {
    var image = document.getElementById("imageUploader");

    image.onchange = function () {

        var file_count = image.files.length;

        if (file_count <= 3) {

            for (var x = 0; x < file_count; x++) {

                var file = this.files[x];
                var url = window.URL.createObjectURL(file);
                document.getElementById("p" + x).src = url;
            }

        } else {
            alert("You can only add upto 3 images");
        }
    }
}

function saveFeedback(id) {
    var feedback = document.getElementById("feed" + id);
    var image = document.getElementById("imageUploader" + id);

    var form = new FormData();
    form.append("feed", feedback.value);
    form.append("id", id);

    var file_count = image.files.length;

    for (var x = 0; x < file_count; x++) {
        form.append("i" + x, image.files[x]);
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            if (response == "a") {
                image.classList.add = "disabled";
                alert("Successfully Updated!");
            } else {
                alert(response);
            }

        }
    }
    request.open("POST", "saveFeedbackProcess.php", true);
    request.send(form);

}

function sendAdminVerificationCode() {
    var email = document.getElementById("adminEmail").value;

    var form = new FormData();
    form.append("e", email);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            var adminVerificationModal = document.getElementById("adminVerificationModal");
            adminVeification = new bootstrap.Modal(adminVerificationModal);
            adminVeification.show();

        }
    }
    request.open("POST", "adminVerificationProcess.php", true);
    request.send(form);
}

function verifyAdmin() {
    var verification = document.getElementById("vcode");

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "success!") {
                window.location.replace("adminDashboard.php");
            } else {
                alert(response);
            }
        }
    }

    request.open("GET", "verifyAdmin.php?v=" + verification.value, true);
    request.send();
}

function viewProductModal(id) {
    var m = document.getElementById("viewProductModal" + id);
    pm = new bootstrap.Modal(m);
    pm.show();
}

function blockProduct(id) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "Blocked!") {
                document.getElementById("pb" + id).innerHTML = "Unblock";
                document.getElementById("pb" + id).classList = "btn btn-outline-success";

            } else if (response == "Unblocked!") {
                document.getElementById("pb" + id).innerHTML = "Block";
                document.getElementById("pb" + id).classList = "btn btn-outline-danger";
            } else {
                alert(response);
            }

        }
    }

    request.open("GET", "ProductBlockProcess.php?id=" + id, true);
    request.send();
}

function addNewCategory() {
    var m = document.getElementById("addCategoryModal");
    cm = new bootstrap.Modal(m);
    cm.show();
}

var newCategory;

function confirmCategory() {

    newCategory = document.getElementById("n").value;

    var form = new FormData();
    form.append("name", newCategory);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            if (response == "Success!") {
                alert("Saved Successfully!");
            } else {
                alert(response);
            }

        }
    }

    request.open("POST", "addNewCategoryProcess.php", true);
    request.send(form);
}

function searchProduct() {
    var txt = document.getElementById("product").value;

    var form = new FormData();
    form.append("product", txt);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            document.getElementById("table").innerHTML = response;
        }
    }

    request.open("POST", "manageProductsearch.php", true);
    request.send(form);
}

function viewUserModal(email) {
    var m = document.getElementById("viewUserModal" + email);
    pm = new bootstrap.Modal(m);
    pm.show();
}

function blockUser(email) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == "Blocked!") {
                document.getElementById("pb" + email).innerHTML = "Unblock";
                document.getElementById("pb" + email).classList = "btn btn-outline-success";

            } else if (response == "Unblocked!") {
                document.getElementById("pb" + email).innerHTML = "Block";
                document.getElementById("pb" + email).classList = "btn btn-outline-danger";
            } else {
                alert(response);
            }

        }
    }

    request.open("GET", "userBlockProcess.php?email=" + email, true);
    request.send();
}


function searchUser() {
    var txt = document.getElementById("user").value;

    var form = new FormData();
    form.append("user", txt);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;
            document.getElementById("table").innerHTML = response;
        }
    }

    request.open("POST", "manageUsersSearch.php", true);
    request.send(form);
}

function changestatus(id) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            if (response == 1) {
                document.getElementById("btn" + id).innerHTML = "Packing";
                document.getElementById("btn" + id).classList = "btn btn-warning fw-bold mt-1 mb-1";
            } else if (response == 2) {
                document.getElementById("btn" + id).innerHTML = "Dispatch";
                document.getElementById("btn" + id).classList = "btn btn-info fw-bold mt-1 mb-1";
            } else if (response == 3) {
                document.getElementById("btn" + id).innerHTML = "Shipping";
                document.getElementById("btn" + id).classList = "btn btn-primary fw-bold mt-1 mb-1";
            } else if (response == 4) {
                document.getElementById("btn" + id).innerHTML = "Dilivered";
                document.getElementById("btn" + id).classList = " btn btn-danger fw-bold mt-1 mb-1 disabled";
            } else {
                alert(response);
            }

        }
    }

    request.open("GET", "changeInvoiceStatusProcess.php?id=" + id, true);
    request.send();
}

function searchInvoiceId() {
    var txt = document.getElementById("searchTxt").value;

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var response = request.responseText;

            document.getElementById("table").innerHTML = response;
            
        }
    }

    request.open("GET", "searchInvoiceIdProcess.php?id=" + txt, true);
    request.send();
}

function findSellings() {
    var toDate = document.getElementById("tDate").value;
    var fromDate = document.getElementById("fDate").value;

    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var response = request.responseText;

            document.getElementById("table").innerHTML = response;

        }
    }

    request.open("GET", "findSellingProcess.php?f=" + fromDate + "&t=" + toDate, true);
    request.send();


}

function adminSignout(){
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            var response = request.responseText;

            window.location.replace("index.php");
        }
    }

    request.open("GET", "adminSignutProcess.php", true);
    request.send();

}