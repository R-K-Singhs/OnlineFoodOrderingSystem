<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <style>
        #expandedImg {
            border: solid 3px grey;
        }

        #allimages img {
            margin: 2px;
            border: solid 2px black;
        }
    </style>
</head>

<?php
require "./db_manager.php";

if ($_SESSION["loginstatus"] != "user") {
    $_SESSION["postpage"] = "userLogin";
    header("Location:login.php");
}
$db = new DbManager();
$db->connDatabase();
if ($_SESSION["productId"] != "") {

    // echo $_SESSION["productId"];
    $query = "SELECT * FROM fooddetails WHERE id=" . $_SESSION["productId"];
    $result = $db->getData($query);
    $product = $result->fetch_assoc();
    // echo $prodetails["name"];
    if ($result->num_rows > 0) {
        $AllProducts = json_encode($product);
        // echo $AllProducts;
    }

    $query = "SELECT * FROM usercart WHERE userId=" . $_SESSION["uid"];
    $result = $db->getData($query);
    $product = $result->fetch_assoc();
    $nop = 0;
    // echo $prodetails["name"];
    if ($result->num_rows > 0) {
        $nop = $result->num_rows;
    }
}

?>

<body>
    <nav class="navbar navbar-expand-lg navbar-light  bg-light " style="z-index: 1; width: 100%;">
        <div class="d-inline-block align-center rounded-circle " style="width: 50px; height: 50px;background-color: rgb(22, 65, 22); text-align: center;"><img src="../my_images/my_logo.png" width="45" height="40" class="d-inline-block align-center" alt="">
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item active">
                    <a class=" font-weight-bold btn btn-outline-secondary m-1" href="userHomePage.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class=" font-weight-bold btn btn-outline-secondary m-1" href="user_order_list.php">Your Order</a>
                </li>
                <li class="nav-item active">
                    <a class=" font-weight-bold btn btn-outline-secondary m-1" href="user_cart.php">Your Cart</a>
                </li>
                <li class="nav-item active">
                    <a class=" font-weight-bold btn btn-outline-secondary m-1" href="userProfile.php">Your Profile</a>
                </li>
            </ul>

        </div>
        <div class="btn btn-warning text-center">
            <a href="user_cart.php" style="text-decoration: none;">
                <span class=" p-1 rounded-circle bg-warning border border-danger" id="cartno" style="font-size: 1rem; margin-right: 2px;"><?php echo $nop; ?></span>
                <img src="../my_images/cart_icon.png" width="35px" height="35px" alt="">

            </a>
        </div>
    </nav>

    <div class=" d-flex justify-content-center p-2">
        <img id="expandedImg" src="../my_images/wallpaper1.jpg" width="100%" height="500px" alt="Loading.......">
    </div>
    <!-- The grid: four columns -->
    <div id="allimages" class="d-flex justify-content-center bg-secondary p-2 flex-wrap">
    </div>

    <div class="d-flex justify-content-between p-2 bg-secondary border border-dark text-center">
        <span class="text-center text-white">
            <h3 id="name" class="text-dark">Item: <strong>Product name</strong></h3>
        </span>
        <span class="btn btn-primary">Price &#8377 <span id="price"> 00.00</span> </span>
    </div>
    <div class="bg-secondary text-white p-3">
        <h3 class="text-white text-center bg-dark  p-2 rounded "><b style="color:lawngreen" id="type"></b></h3>
        <hr>
        <div id="discription" class="p-3 text-center"></div>
    </div>
    <div class="d-flex justify-content-between p-2 bg-secondary border border-dark text-center">
        <button class="btn btn-dark">
            <a href="userHomePage.php" style="text-decoration: none; color:white">
                <h5><b>Cancle</b></h5>
            </a>
        </button>
        <button class="btn btn-danger " onclick="btnOrder()">
            <h5><b>Order
                    Now</b></h5>
        </button>
    </div>
    <button onclick="addToCart(this)" class=" w-100 p-2 text-white" style="background-color: black;">
        <h3><b>Add to Cart</b></h3>
    </button>

    <div id="sampleimg" style="display: none;">
        <img width="80px" height="80px" alt="Nature" onclick="myFunction(this);">
    </div>
</body>

<script>
    var data = <?php echo $AllProducts; ?>;
    var sample = document.getElementById("sampleimg").innerHTML;
    var productContainer = document.getElementById("allimages");
    var cart;

    document.getElementById("expandedImg").src = data["image1"];
    document.querySelector("#name>strong").innerHTML = data["name"];
    document.getElementById("price").innerHTML = data["price"];
    document.getElementById("type").innerHTML = data["type"];
    document.getElementById("discription").innerHTML = data["discription"];
    for (var i = 1; i < 11; i++) {
        if (data["image" + i] != "") {
            var newdiv = document.createElement("div");
            newdiv.innerHTML = sample;
            newdiv.setAttribute("id", "id" + i);
            productContainer.append(newdiv);
            document.querySelector("#id" + i + ">img").setAttribute("src", data["image" + i]);

        }

    }

    function myFunction(imgs) {
        // Get the expanded image
        var expandImg = document.getElementById("expandedImg");
        // Use the same src in the expanded image as the image being clicked on from the grid
        expandImg.src = imgs.src;

    }

    function btnOrder() {

        // alert(productid);
        var req = new XMLHttpRequest;
        req.open("Get", "set_session_data.php?id=" + data["id"], true);
        req.send();
        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200) {

                if (req.responseText == "yes") {
                    // alert(req.responseText);
                    location.href = "user_order.php ";
                } else {
                    alert("this item has some issue..");
                }
            }
        }
    }

    function addToCart(cart) {
        console.log("clicked");
        var req = new XMLHttpRequest;
        req.open("GET", "set_session_data.php?productid=" + data["id"], true);
        req.send();
        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200) {

                if (req.responseText == "exist") {
                    alert("This product already exists in your cart");
                } else if (req.responseText == "faield") {
                    alert("This product this product is not added in your cart");
                } else {
                    document.getElementById("cartno").innerHTML = req.responseText;
                    alert("This item is added in your cart successfuly");
                }
            }
        }

    }
</script>

</html>