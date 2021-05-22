<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
        #mynav:hover {
            color: chartreuse;
            background-color: rgb(65, 39, 22);
        }

        body {
            /* background: url("../my_images/nature2.jpg") no-repeat center center/cover; */
            background-color: gray;
        }

        .card {
            width: 20rem;
            border: 3px solid green;
        }

        @media screen and (max-width: 780px) {

            .card {
                width: 30rem;
            }

        }

        @media screen and (max-width: 500px) {

            .card {
                width: 25rem;
            }

        }

        @media screen and (max-width: 410px) {

            .card {
                width: 18rem;
            }

        }

        .logout {
            display: none;
        }

        .show {
            display: inline;
        }

        .carousel-inner img {

            height: 400px;
        }
    </style>
</head>

<?php
require "./db_manager.php";
if ($_SESSION["loginstatus"] === "seller") {
    $_SESSION["postpage"] = "userLogin";
    header("Location:login.php");
}
$db = new DbManager();
$db->connDatabase();

$query = "SELECT * FROM fooddetails";
$result = $db->getData($query);
if ($result->num_rows > 0) {
    $AllProducts = json_encode($result->fetch_all(MYSQLI_ASSOC));
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

            <div class="form-inline my-2 my-lg-0">

                <select name="filter" id="filter" class="form-control mr-sm-2 p-2 border border-secondary" onchange="filterChanged(this)">
                    <option value="" style="display: none;" disabled selected><b>Filter</b></option>
                    <optgroup label="product types ">
                        <option value="All">All product</option>
                        <option value="Foods">Foods</option>
                        <option value="Fruits">Fruits</option>
                        <option value="Glosary">Glosary</option>
                        <option value="Stationary">Stationary</option>
                        <option value="Sports">Sports</option>
                        <option value=" sweets">sweets</option>
                    </optgroup>
                </select>

            </div>
        </div>
        <div>
            <div class=" border border-primary align-center bg-warning p-1">
                <div class="d-inline" onclick="logout()">
                    <div class=" d-inline-block">
                        <?php echo $_SESSION["uname"]; ?>
                    </div>
                    <img src="<?php echo $_SESSION["uprofileimg"]; ?>" width="40" height="40" class="  rounded-circle border border-success " alt="">
                </div>
                <div class="logout" id="idlogout">
                    <button type="button" class="btn btn-danger btn-sm" onclick="btnlog()">Logout</button>
                </div>
            </div>
        </div>
    </nav>
    <div id="carouselExampleIndicators" style="height: 400px;" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="../my_images/wallpaper1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../my_images/wallpaper2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../my_images/wallpaper3.jpg" alt="Third slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../my_images/wallpaper4.jpg" alt="Third slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../my_images/wallpaper5.jpg" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>west food</h5>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eum autem libero aut aperiam ea
                        voluptatibus, nemo facilis adipisci dolor quia. </p>
                </div>
            </div>

        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class=" w-100 d-flex flex-wrap justify-content-center text-center" id="allproduct">

        <div id="sample" style="display: none;">
            <div class=" card m-2">
                <img class="card-img-top" height="200px" src="../my_images/wallpaper1.jpg" alt="Card image cap">
                <div class="card-body d-flex justify-content-between bg-secondary">
                    <p class="rounded p-0 m-0 d-inline text-white" style="font-size: 2em;">No name</p>
                    <div class="btn btn-primary">Price &#8377 <span>00.00</span>
                    </div>
                </div>

                <div class=" d-flex justify-content-between bg-success p-0">
                    <span class=" btn btn-danger m-1 w-100">Order Now</span>
                    <button class=" btn btn-dark m-1 w-100">Add To Cart</button>
                </div>
            </div>
        </div>

</body>

<script>
    var data = <?php echo $AllProducts; ?>;
    var productid; //for clicked product
    var item;

    var sample = document.getElementById("sample").innerHTML;
    var productContainer = document.getElementById("allproduct");

    for (var x in data) {
        var newdiv = document.createElement("div");
        newdiv.setAttribute("id", "id" + data[x]["id"]);
        newdiv.innerHTML = sample;
        productContainer.append(newdiv);
        var img = document.querySelector("#id" + data[x]["id"] + ">div>img");
        img.setAttribute("onclick", "clicked(" + data[x]["id"] + ")");
        img.setAttribute("src", data[x]["image1"]);

        document.querySelector("#id" + data[x]["id"] + ">div>div>span").setAttribute("onclick", "btnOrder(" + data[x]["id"] + ")");
        document.querySelector("#id" + data[x]["id"] + ">div>div>button").setAttribute("onclick", "addToCart(" + data[x]["id"] + ")");
        document.querySelector("#id" + data[x]["id"] + ">div>div>div>span").innerHTML = data[x]["price"];
        document.querySelector("#id" + data[x]["id"] + ">div>div>p").innerHTML = data[x]["name"];

    }

    function btnOrder(productid) {
        // alert(productid);
        var req = new XMLHttpRequest;
        req.open("Get", "set_session_data.php?id=" + productid, true);
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

    function addToCart(productid) {
        console.log("clicked");
        var req = new XMLHttpRequest;
        req.open("GET", "set_session_data.php?productid=" + productid, true);
        req.send();
        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200) {

                if (req.responseText == "exist") {
                    alert("This product already exists in your cart");
                } else if (req.responseText == "faield") {
                    alert("This product this product is not added in your cart");
                } else {
                    // document.getElementById("cartno").innerHTML = req.responseText;
                    alert("This item is added in your cart successfuly");
                }
            }
        }

    }

    function filterChanged(item) {
        var foodtype = item.options[item.selectedIndex].value;
        var req = new XMLHttpRequest;
        req.open("GET", "set_session_data.php?foodtype=" + foodtype, true);
        req.send();
        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200) {
                if (req.responseText == "empty") {
                    alert("Product Not Found");
                } else {
                    productContainer.innerHTML = "";
                    var data = JSON.parse(req.responseText);
                    for (var x in data) {
                        var newdiv = document.createElement("div");
                        newdiv.setAttribute("id", "id" + data[x]["id"]);
                        newdiv.innerHTML = sample;
                        productContainer.append(newdiv);
                        var img = document.querySelector("#id" + data[x]["id"] + ">div>img");
                        img.setAttribute("onclick", "clicked(" + data[x]["id"] + ")");
                        img.setAttribute("src", data[x]["image1"]);

                        document.querySelector("#id" + data[x]["id"] + ">div>div>span").setAttribute("onclick", "btnOrder(" + data[x]["id"] + ")");
                        document.querySelector("#id" + data[x]["id"] + ">div>div>button").setAttribute("onclick", "addToCart(" + data[x]["id"] + ")");
                        document.querySelector("#id" + data[x]["id"] + ">div>div>div>span").innerHTML = data[x]["price"];
                        document.querySelector("#id" + data[x]["id"] + ">div>div>p").innerHTML = data[x]["name"];

                    }
                }
            }
        }
    }

    function clicked(productid) {

        // alert(productid);
        var req = new XMLHttpRequest;
        req.open("Get", "set_session_data.php?id=" + productid, true);
        req.send();
        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200) {

                if (req.responseText == "yes") {
                    // alert(req.responseText);
                    location.href = "show_product_details.php ";
                } else {
                    alert("this item has some issue..");
                }
            }
        }
    }
</script>
<script>
    function btnlog() {
        if (confirm("Are you sure to Logout")) {
            var req = new XMLHttpRequest;
            req.open("GET", "logout.php", true);
            req.send();
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    location.href = "Welcome.php"
                }
            }
        }
    }

    function logout() {
        document.getElementById("idlogout").classList.toggle("show");
    }
</script>

</html>