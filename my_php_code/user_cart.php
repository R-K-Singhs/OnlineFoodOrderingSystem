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

$query = "SELECT * FROM usercart WHERE userId=" . $_SESSION["uid"];
$result = $db->getData($query);
$array = array();
$index = 0;
$str = "";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_ASSOC()) {
        // echo $row["productId"] . "<br>";
        $array[$index] = $row["productId"];
        $index++;
    }
    foreach ($array as $x => $y) {
        if ($x != 0) {
            $str .= " OR ";
        }
        $str .= " id=" . $y;
    }
    $query = "SELECT* FROM fooddetails WHERE " . $str . ";";
    $result = $db->getData($query);
    if ($result->num_rows > 0) {
        $AllProducts = json_encode($result->fetch_all(MYSQLI_ASSOC));
        // echo $AllProducts;
    }
} else {
    $AllProducts = "";
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
    <h1 class="text-center"><b>Your Cart</b></h1>
    <hr>
    <div class=" w-100 d-flex flex-wrap justify-content-center text-center" id="allproduct">
        <h1 id="empty" style="margin: 80px;" class="text-center"><b>"Empty"</b></h1>
    </div>
    <button class="btn btn-danger border border-dark m-3" style="width: 97%; height:50px" onclick="orderallcart()">
        <h3><b>ORDER ALL</b></h3>
    </button>

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
                <button class=" btn btn-dark m-1 w-100">Remove From Cart</button>
            </div>
        </div>
    </div>

</body>


<script>
    var data = <?php echo $AllProducts; ?>;
    var productid;

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
        document.querySelector("#id" + data[x]["id"] + ">div>div>button").setAttribute("onclick", "btnRemoveFromCart(" + data[x]["id"] + ")");
        document.querySelector("#id" + data[x]["id"] + ">div>div>div>span").innerHTML = data[x]["price"];
        document.querySelector("#id" + data[x]["id"] + ">div>div>p").innerHTML = data[x]["name"];

    }

    if (data == "") {
        document.getElementById("empty").style.display = "block";

    } else {
        document.getElementById("empty").style.display = "none";

    }

    function orderallcart() {
        // alert(productid);
        var req = new XMLHttpRequest;
        req.open("Get", "set_session_data.php?orderall=" + JSON.stringify(data), true);
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

    function btnRemoveFromCart(productid) {

        if (confirm("Are you sure to remove this item from your cart") == true) {
            var req = new XMLHttpRequest;
            req.open("Get", "set_session_data.php?removeCartId=" + productid, true);
            req.send();
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    if (req.responseText == "done") {
                        location.href = "user_cart.php ";
                    } else {
                        alert("this item has some issue..");
                    }
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