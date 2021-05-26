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

</head>

<?php
require "./db_manager.php";
if ($_SESSION["loginstatus"] != "seller" || !isset($_SESSION["loginstatus"])) {
    $_SESSION["postpage"] = "sellerLogin";
    header("Location:login.php");
}

$db = new DbManager();
$db->connDatabase();

$query = "SELECT * FROM userorder WHERE sellerId=" . $_SESSION["sid"] . " order by id desc; ";
// echo $query;
$result = $db->getData($query);
if ($result->num_rows > 0) {
    $AllProducts = json_encode($result->fetch_all(MYSQLI_ASSOC));
} else {
    $AllProducts = true;
}
?>

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

    .bt {
        width: 90px;
    }

    th,
    td {
        text-align: center;
    }
</style>

<body>
    <nav class=" w-100 navbar navbar-expand-lg navbar-light bg-light" style="z-index: 1; width: 100%;">

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
            <form class="form-inline my-2 my-lg-0">
                <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
                <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> -->
            </form>
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

    <div class=" bg-light w-100  p-2" style="overflow: auto;">

        <table id="table" class=" table w-100  rounded border border-success p-5 ">
            <tr class="bg-success">
                <th>Name</th>
                <th>Quantity</th>
                <th>Date Time</th>
                <th>Total Price</th>
                <th>Customer</th>
                <th>Confirm</th>
                <th>Packed</th>
                <th>Dispatch</th>
                <th>Delivered</th>
            </tr>

        </table>


    </div>
    <div id="box" class="bg-primary" tabindex="0">
        <span id="cross" onclick="document.getElementById('box').style.display='none'">&times;</span>
        <h2 class="w-100 text-center"><b>Custmer Details</b></h2>
        <div class="w-100 d-flex justify-content-center p-4">
            <div class="w-100 d-flex flex-column justify-content-center ">

                <span class="text">customer name : <b id="uname">user name</b></span>
                <span class="text">customer mo.no. : <b id="umono">8987016626</b></span>
                <span class="text">customer Email Id : <b id="uemail">rahulsinghss15121998@gmail.com</b></span>

            </div>
            <img src="../my_images/wallpaper.jpg" id="img" class="border border-dark" alt="no image" height="150px" width="150px">
        </div>
        <p class="p-0 m-0"><b>Address:</b></p>
        <p class="w-100 text-left p-2" id="uaddress"></p>
    </div>
    <h1 class="text-center" id="empty" style="display: none; margin: 20%;"><b>" EMPTY ORDER LIST"</b></h1>
</body>

<script>
    var data = <?php echo $AllProducts; ?>;
    var orderid;
    var userId;

    if (data == true) {
        document.getElementById("empty").style.display = "block";
    } else {

        var mytable = document.getElementById("table");

        for (var x in data) {
            var tr = document.createElement("tr");
            var td1 = document.createElement("td");
            td1.innerHTML = data[x]["productname"];

            var td2 = document.createElement("td");
            td2.innerHTML = data[x]["quantity"];

            let date = new Date(data[x]["dateTime"]);
            let currdate = new Date();
            var td3 = document.createElement("td");

            if (date.getFullYear() === currdate.getFullYear() && date.getMonth() === currdate.getMonth() && date.getDay() === currdate.getDay()) {
                // console.log(currdate.getDay());
                // console.log(date.getDay());
                td3.innerHTML = "<b>" + date.getHours() + ":" + date.getMinutes() + "  </b> Today";
            } else {
                td3.innerHTML = "<b>" + date.getHours() + ":" + date.getMinutes() + "</b>  " +
                    date.getDate() + "/" + date.getMonth() + "/" + date.getFullYear();
            }

            var td4 = document.createElement("td");
            var btn1 = document.createElement("button");
            btn1.innerHTML = "<b>&#8377</b> " +
                data[x]["totalprice"];
            btn1.setAttribute("class", "btn btn-danger bt");
            // btn1.setAttribute("onclick", "showcustomer(" + data[x]["userId"] + ")");
            td4.append(btn1);

            var td5 = document.createElement("td");
            var btn2 = document.createElement("button");
            btn2.innerHTML = "Show";
            btn2.setAttribute("class", "btn btn-primary bt");
            btn2.setAttribute("onclick", "showcustomer(" + data[x]["userId"] + ")");
            td5.append(btn2);

            var td6 = document.createElement("td");
            var btn3 = document.createElement("button");
            btn3.innerHTML = "Confirm";
            btn3.setAttribute("class", "btn btn-info bt");
            btn3.setAttribute("onclick", "confirmorder(" + data[x]["id"] + ")");
            btn3.disabled = true;
            td6.append(btn3);

            var td7 = document.createElement("td");
            var btn4 = document.createElement("button");
            btn4.innerHTML = "Packed";
            btn4.setAttribute("class", "btn btn-info bt");
            btn4.setAttribute("onclick", "packedorder(" + data[x]["id"] + ")");
            btn4.disabled = true;
            td7.append(btn4);

            var td8 = document.createElement("td");
            var btn5 = document.createElement("button");
            btn5.innerHTML = "Dispatch";
            btn5.setAttribute("class", "btn btn-info bt");
            btn5.setAttribute("onclick", "dispatchorder(" + data[x]["id"] + ")");
            btn5.disabled = true;
            td8.append(btn5);

            var td9 = document.createElement("td");
            var btn6 = document.createElement("button");
            btn6.innerHTML = "Del Req";
            btn6.setAttribute("class", "btn btn-info bt");
            btn6.setAttribute("onclick", "deliveryReq(" + data[x]["id"] + ")");
            btn6.disabled = true;
            td9.append(btn6);

            if (data[x]["delivered"] == true) {

                btn1.disabled = true;
                btn1.style.backgroundColor = "greenyellow";
                btn1.style.color = "black";

                btn2.disabled = true;
                btn2.style.backgroundColor = "greenyellow";
                btn2.style.color = "black";

                btn3.disabled = true;
                btn3.style.backgroundColor = "greenyellow";
                btn3.style.color = "black";


                // btn4.disabled = true;
                btn4.style.backgroundColor = "greenyellow";
                btn4.style.color = "black";

                // btn5.disabled = true;
                btn5.style.backgroundColor = "greenyellow";
                btn5.style.color = "black";

                // btn6.disabled = true;
                btn6.style.backgroundColor = "greenyellow";
                btn6.style.color = "black";

            } else if (data[x]["dispatch"] == true) {

                btn3.style.backgroundColor = "greenyellow";
                btn3.style.color = "black";

                btn4.style.backgroundColor = "greenyellow";
                btn4.style.color = "black";


                btn5.style.backgroundColor = "greenyellow";
                btn5.style.color = "black";

                btn6.disabled = false;
                btn6.style.backgroundColor = "greenyellow";
                btn6.style.color = "black";

            } else if (data[x]["packed"] == true) {

                btn3.style.backgroundColor = "greenyellow";
                btn3.style.color = "black";

                btn4.style.backgroundColor = "greenyellow";
                btn4.style.color = "black";

                btn5.disabled = false;
                btn5.style.backgroundColor = "greenyellow";
                btn5.style.color = "black";

            } else if (data[x]["confirm"] == true) {

                btn3.style.backgroundColor = "greenyellow";
                btn3.style.color = "black";

                btn4.disabled = false;
                btn4.style.backgroundColor = "greenyellow";
                btn4.style.color = "black";

            } else {
                btn3.disabled = false;
                btn3.style.backgroundColor = "greenyellow";
                btn3.style.color = "black";
            }
            if (data[x]["deliveryrequest"] == true) {
                btn6.style.backgroundColor = "yellow";
                btn6.disabled = true;
            }
            if (data[x]["delivered"] == true) {
                btn6.style.backgroundColor = "greenyellow";
            }


            tr.appendChild(td1);
            tr.appendChild(td2);
            tr.appendChild(td3);
            tr.appendChild(td4);
            tr.appendChild(td5);
            tr.appendChild(td6);
            tr.appendChild(td7);
            tr.appendChild(td8);
            tr.appendChild(td9);
            mytable.appendChild(tr);

        }
    }

    function showcustomer(userId) {

        let box = document.getElementById("box");
        var req = new XMLHttpRequest;
        req.open("Get", "set_session_data.php?showuser=" + userId, true);
        req.send();
        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200) {
                if (req.responseText != "faield") {
                    var data = JSON.parse(req.responseText);
                    document.getElementById("uname").innerHTML = data[0]["name"];
                    document.getElementById("umono").innerHTML = data[0]["mobile"];
                    document.getElementById("uaddress").innerHTML = data[0]["address"];
                    document.getElementById("uemail").innerHTML = data[0]["email"];
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

    function confirmorder(orderid) {
        if (confirm("Are you sure to confirm this order")) {
            var req = new XMLHttpRequest;
            req.open("GET", "set_session_data.php?setconfirmorderId=" + orderid, true);
            req.send();
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    // console.log(req.responseText);
                    if (req.responseText == "done") {
                        location.href = "sellerHomePage.php";
                    }
                }
            }
        }
    }

    function packedorder(orderid) {
        if (confirm("Are you sure to packed this order")) {
            var req = new XMLHttpRequest;
            req.open("GET", "set_session_data.php?setpackedorderId=" + orderid, true);
            req.send();
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    // console.log(req.responseText);
                    if (req.responseText == "done") {
                        location.href = "sellerHomePage.php";
                    }
                }
            }
        }
    }

    function dispatchorder(orderid) {
        if (confirm("Are you sure to dispatch this order")) {
            var req = new XMLHttpRequest;
            req.open("GET", "set_session_data.php?setdispatchorderId=" + orderid, true);
            req.send();
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    // console.log(req.responseText);
                    if (req.responseText == "done") {
                        location.href = "sellerHomePage.php";
                    }
                }
            }
        }
    }

    function deliveryReq(orderid) {
        if (confirm("Are you sure to send out of delivery request for this order")) {
            var req = new XMLHttpRequest;
            req.open("GET", "set_session_data.php?setdeliveryreqId=" + orderid, true);
            req.send();
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    // console.log(req.responseText);
                    if (req.responseText == "done") {
                        location.href = "sellerHomePage.php";
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