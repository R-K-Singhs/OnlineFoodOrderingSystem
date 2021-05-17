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
        #box {
            width: 60%;
            left: 20%;
            top: 30px;
            position: absolute;
            z-index: 2;
            padding: 10px;
            display: none;
        }

        .text {
            font-size: 20px;
            padding-left: 40px;
        }

        #cross {
            font-size: 30px;
            position: absolute;
            padding: 0px;
            margin: 0px;
            top: 0px;
            right: 10px;
        }

        #cross:hover {
            font-size: 32px;
            color: red;
            cursor: pointer;
        }

        .logout {
            display: none;
        }

        .show {
            display: inline;
        }

        th,
        td {
            text-align: center;
        }
    </style>
</head>

<?php
include "db_manager.php";
if ($_SESSION["loginstatus"] != "user") {
    $_SESSION["postpage"] = "userLogin";
    header("Location:login.php");
}
$db = new DbManager();
$db->connDatabase();

$query = "SELECT * FROM userorder  WHERE userId=" . $_SESSION["uid"] . " ORDER BY id DESC;";
$result = $db->getData($query);
if ($result != NULL && $result->num_rows > 0) {
    $data = json_encode($result->fetch_all(MYSQLI_ASSOC));
} else {
    $data = true;
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
    <h1 class="text-center"><b>Your Order</b></h1>
    <hr>
    <div id="box" class="bg-primary" tabindex="0">
        <span id="cross" onclick="document.getElementById('box').style.display='none'">&times;</span>
        <h2 class="w-100 text-center"><b>Product seller</b></h2>
        <div class="w-100 d-flex justify-content-center p-4">
            <div class="w-100 d-flex flex-column justify-content-center ">
                <span class="text">shope name : <b id="shopename">genral store</b></span>
                <span class="text">seller name : <b id="sname">seller name</b></span>
                <span class="text">seller mo.no. : <b id="smono">8987016626</b></span>
                <span class="text">shop opening time : <b id="sot">00.00</b></span>
                <span class="text">shop closeing time : <b id="sct">00.00</b></span>
            </div>
            <img src="../my_images/wallpaper.jpg" id="img" class="border border-dark" alt="no image" height="150px" width="150px">
        </div>
        <p class=" w-100 text-center m-1 p-0">email Id : <span id="semail">rahulsinghss15121998@gmail.com</span></p>
        <p class="p-0 m-0"><b>Address:</b></p>
        <p class="w-100 text-left p-2" id="saddress">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iure reprehenderit, libero harum nobis possimus a doloremque incidunt officiis. Nemo impedit, animi, aliquid consequatur recusandae itaque repudiandae similique deleniti sequi, placeat magni atque.</p>
    </div>
    <div id="orderlist">
    </div>
    <h1 class="text-center" id="empty" style="display: none; margin: 20%;"><b>" EMPTY ORDER LIST"</b></h1>


    <div id="sample" style="display: none;">
        <div class="d-flex flex-nowrap justify-content-center m-2 p-1 bg-light  border border-dark" style="border-radius: 5px;">
            <div class="d-flex flex-column border border-dark bg-success text-center">
                <img src="../my_images/bg-image1.jpg" height="150px" width="150px" alt="loading...">

            </div>
            <div class="d-flex flex-wrap w-100 flex-column justify-content-between border border-dark">
                <table class="   border border-primary bg-success text-white">
                    <tr>
                        <th>name</th>
                        <th>price/item</th>
                        <th>quantity</th>
                        <th>Total price</th>
                    </tr>

                </table>
                <p class=" p-0 text-primary" style="margin-left: 10px;">Your order status</p>

                <div>
                    <div class=" d-flex flex-wrap justify-content-around text-center w-100">
                        <span class="rounded p-1  h-75">Placed</span>
                        <p class="rounded p-1 h-75"><b>===>></b></p>
                        <span class="rounded p-1 h-75">confirm</span>
                        <p class="rounded p-1 h-75"><b>===>></b></p>
                        <span class="rounded p-1 h-75">Packed</span>
                        <p class="rounded p-1 h-75"><b>===>></b></p>
                        <span class="rounded p-1 h-75">Dispatch</span>
                    </div>
                </div>
                <h2 class=" text-center" style="display: none;">Delievered</h2>

            </div>

            <div class="d-flex flex-column text-center bg-secondary justify-content-around border border-dark" style="width: 150px;">
                <!-- <span>Time date</span> -->
                <button class="btn btn-primary btn-sm m-1">show seller</button>
                <button class="btn btn-success btn-sm m-1">Got item</button>
                <button class="btn btn-warning btn-sm m-1">cancel/delete</button>
            </div>

        </div>

    </div>


</body>

<script>
    var data = <?php echo $data; ?>;
    var productid;
    var sellerid;

    var container = document.getElementById("orderlist");
    var sample = document.getElementById("sample").innerHTML;

    if (data == true) {
        document.getElementById("empty").style.display = "block";
    } else {
        var mytable = document.getElementById("table");
        for (var x in data) {
            var mydiv = document.createElement("div");
            mydiv.setAttribute("id", "id" + data[x]["id"]);
            // mydiv.setAttribute("class", "d-flex fle-column justify-content-around");
            mydiv.innerHTML = sample;
            container.appendChild(mydiv);
            var img = document.querySelector("#id" + data[x]["id"] + ">div>div>img");
            img.setAttribute("onclick", "imageclicked(" + data[x]["productId"] + ")");
            img.setAttribute("src", data[x]["productimage"]);

            let table = document.querySelector("#id" + data[x]["id"] + ">div>div>table");
            // table.setAttribute("id", "table" + data[x]["id"]);
            let tr = document.createElement("tr");
            // tr.setAttribute("class", "d-flex justify-content-around");

            let td1 = document.createElement("td");
            td1.innerHTML = data[x]["productname"];
            let td2 = document.createElement("td");
            td2.innerHTML = data[x]["productprice"];
            let td3 = document.createElement("td");
            td3.innerHTML = data[x]["quantity"];
            let td4 = document.createElement("td");
            td4.innerHTML = data[x]["totalprice"];
            tr.appendChild(td1);
            tr.appendChild(td2);
            tr.appendChild(td3);
            tr.appendChild(td4);
            table.appendChild(tr);

            let status = document.querySelectorAll("#id" + data[x]["id"] + ">div>div>div>div>span");
            let arrows = document.querySelectorAll("#id" + data[x]["id"] + ">div>div>div>div>p");

            let btn = document.querySelectorAll("#id" + data[x]["id"] + ">div>div>button");
            btn[0].setAttribute("onclick", "showseller(" + data[x]["sellerId"] + ")");
            btn[1].setAttribute("onclick", "receivedItem(" + data[x]["id"] + ")");
            btn[2].setAttribute("onclick", "cancelItem(" + data[x]["id"] + ")");

            if (data[x]["deliveryrequest"] != true) {
                btn[1].disabled = true;
            }
            // console.log(data[x]["delivered"]);
            if (data[x]["delivered"] == null) {
                if (data[x]["placed"] != null) {
                    status[0].style.backgroundColor = "greenyellow";
                    arrows[0].style.color = "greenyellow";
                    if (data[x]["confirm"] != null) {
                        status[1].style.backgroundColor = "greenyellow";
                        arrows[1].style.color = "greenyellow";
                        if (data[x]["packed"] != null) {
                            status[2].style.backgroundColor = "greenyellow";
                            arrows[2].style.color = "greenyellow";
                            if (data[x]["dispatch"] != null) {
                                status[3].style.backgroundColor = "greenyellow";
                            }
                        }
                    }
                }

            } else {
                btn[1].disabled = true;
                // btn[2].disabled = true;
                document.querySelector("#id" + data[x]["id"] + ">div>div>div").style.display = "none";
                document.querySelector("#id" + data[x]["id"] + ">div>div>h2").style.display = "block";
            }



        }
    }

    function showseller(sellerid) {

        let box = document.getElementById("box");


        var req = new XMLHttpRequest;
        req.open("Get", "set_session_data.php?showseller=" + sellerid, true);
        req.send();
        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200) {
                if (req.responseText != "faield") {
                    var data = JSON.parse(req.responseText);
                    document.getElementById("shopename").innerHTML = data[0]["shopName"];
                    document.getElementById("sname").innerHTML = data[0]["name"];
                    document.getElementById("smono").innerHTML = data[0]["mobile"];
                    document.getElementById("sot").innerHTML = data[0]["sot"];
                    document.getElementById("sct").innerHTML = data[0]["sct"];
                    document.getElementById("saddress").innerHTML = data[0]["address"];
                    document.getElementById("semail").innerHTML = data[0]["email"];
                    document.getElementById("img").src = data[0]["profile"];

                    box.style.display = "block";
                    box.focus();

                } else {
                    // console.log(req.responseText);
                    alert("there are some issue..");
                }
            }
        }
    }

    function receivedItem(productid) {
        var req = new XMLHttpRequest;
        console.log(productid);
        req.open("Get", "set_session_data.php?receivedorder=" + productid, true);
        if (confirm("surelly are you received your correct item") == true) {
            req.send();
        }

        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200) {
                console.log(req.responseText);

                if (req.responseText === "done") {
                    location.href = "user_order_list.php ";

                } else {
                    alert("this item has some issue..");
                }

            }
        }
    }

    function cancelItem(productid) {
        var req = new XMLHttpRequest;
        req.open("Get", "set_session_data.php?cancelorder=" + productid, true);
        if (confirm("are you sure to cancel this order") == true) {
            req.send();
        }

        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200) {
                if (req.responseText == "done") {
                    location.href = "user_order_list.php ";
                } else {
                    alert("this item has some issue..");
                }
            }
        }

    }

    function imageclicked(productid) {
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