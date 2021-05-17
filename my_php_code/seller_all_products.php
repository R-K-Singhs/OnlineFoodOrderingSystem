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

    <!-- <link rel="stylesheet" href="../my_css_code/welcome.css"> -->
</head>

<?php
require "./db_manager.php";
if ($_SESSION["loginstatus"] != "seller") {
    $_SESSION["postpage"] = "sellerLogin";
    header("Location:login.php");
}

$db = new DbManager();
$db->connDatabase();

$query = "SELECT * FROM fooddetails WHERE shopId=" . $_SESSION["sid"] . " order by id desc; ";
// echo $query;

$result = $db->getData($query);
if ($result->num_rows > 0) {
    $AllProducts = json_encode($result->fetch_all(MYSQLI_ASSOC));
} else {
    $AllProducts = true;
}
?>

<style>
    button {
        width: 5rem;
    }

    .logout {
        display: none;
    }

    .show {
        display: inline;
    }

    .card {
        width: 18rem;
    }

    @media screen and (max-width: 780px) {

        .card {
            width: 40rem;
        }

    }
</style>


<body>
    <nav class="navbar navbar-expand-lg navbar-light position-fixed bg-light" style="z-index: 1; width: 100%;">

        <div class="d-inline-block align-center rounded-circle " style="width: 50px; height: 50px;background-color: rgb(22, 65, 22); text-align: center;"><img src="../my_images/my_logo.png" width="45" height="40" class="d-inline-block align-center" alt="">
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item active">
                    <a class=" font-weight-bold btn btn-outline-secondary m-1" href="sellerHomePage.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class=" font-weight-bold btn btn-outline-secondary m-1" href="seller_all_products.php">Your Product</a>
                </li>
                <li class="nav-item active">
                    <a class=" font-weight-bold btn btn-outline-secondary m-1" href="seller_add_product.php">Add Product</a>
                </li>
                <li class="nav-item active">
                    <a class=" font-weight-bold btn btn-outline-secondary m-1" href="sellerProfile.php">Your Profile</a>
                </li>

            </ul>

        </div>
        <div>
            <div class=" border border-primary align-center bg-warning p-1">
                <div class="d-inline" onclick="logout()">
                    <div class=" d-inline-block">
                        <?php echo $_SESSION["sname"]; ?>
                    </div>
                    <img src="<?php echo $_SESSION["sprofileimg"]; ?>" width="40" height="40" class="  rounded-circle border border-success " alt="">
                </div>
                <div class="logout" id="idlogout">
                    <button type="button" class="btn btn-danger btn-sm" onclick="btnlog()">Logout</button>
                </div>
            </div>
        </div>
    </nav>
    <div style="height: 70px;"></div>
    <div class="container w-100 d-flex flex-wrap text-center">

        <div class=" w-100 d-flex flex-wrap justify-content-center text-center" id="allproduct">
        </div>
        <h1 class=" w-100 text-center" id="empty" style="display: none; margin: 20%;"><b>"Empty"</b></h1>

        <div id="sample" style="display: none;">
            <div class=" card m-2">
                <img class="card-img-top" height="200px" src="../my_images/wallpaper1.jpg" alt="Card image cap">
                <div class=" d-flex justify-content-between bg-success p-0">
                    <span class=" btn btn-dark m-1 w-100">product name</span>
                    <span class=" btn btn-primary m-1 w-100">Price &#8377 <span>00.00</span></span>
                    <span class="w-100 btn btn-danger m-1 w-100 text-center">Delete</span>
                </div>
            </div>

        </div>
</body>
<script>
    var data = <?php echo $AllProducts; ?>;
    var productid; //for clicked product
    var item;

    if (data == true) {
        document.getElementById("empty").style.display = "block";
    } else {
        document.getElementById("empty").style.display = "none";
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

            document.querySelectorAll("#id" + data[x]["id"] + ">div>div>span")[0].innerHTML = data[x]["name"];
            document.querySelector("#id" + data[x]["id"] + ">div>div>span>span").innerHTML = data[x]["price"];
            document.querySelectorAll("#id" + data[x]["id"] + ">div>div>span")[2].setAttribute("onclick", "deletebtn(" + data[x]["id"] + ")");

        }
    }


    function deletebtn(productid) {

        // alert(productid);
        var req = new XMLHttpRequest;
        req.open("Get", "set_session_data.php?deleteselleritem=" + productid, true);

        if (confirm("are you sure to delete your item") == true) {
            req.send();
        }
        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200) {

                if (req.responseText == "done") {
                    // alert(req.responseText);
                    location.href = "seller_all_products.php ";
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
                    location.href = "show_seller_product_details.php ";
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