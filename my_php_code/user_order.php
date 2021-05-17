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
        .mycard {
            width: 100;
        }

        @media screen and (max-width: 500px) {

            .img {
                width: 25%;
                /* height: 300px; */
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

if ($_SESSION["productId"] != "") {
    $query = "SELECT * FROM fooddetails WHERE id=" . $_SESSION["productId"];
    $result = $db->getData($query);
    if ($result->num_rows > 0) {
        $AllProducts = json_encode($result->fetch_all(MYSQLI_ASSOC));
    }
} else {
    $AllProducts = $_SESSION["orderall"];
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
        </div>
    </nav>
    <h1 class=" text-center"><strong>Order Now</strong></h1>
    <hr>
    <div class="m-2">
        <div class="m-1 border border-primary bg-secondary d-flex flex-wrap justify-content-center text-center" id="allproduct">
        </div>

        <div class=" m-1 border border-primary bg-info d-flex flex-column">
            <div class="p-2 border border-dark m-2">
                <h4><b>Select Address</b></h4>
                <div id="alladdress">
                    <div class="d-flex p-1 border border-secondary m-1">
                        <input type="radio" name="radio" style="width: 20px; height: 20px;">
                        <p style="text-align: left; margin-left: 20px;">Lorem ipsum, dolor sit amet consectetur
                            adipisicing
                            elit. Recusandae
                            tempora praesentium nobis ut
                            maiores
                            sunt distinctio, consectetur quia autem adipisci.</p>
                    </div>
                    <div class="d-flex  p-1 border border-secondary m-1">
                        <input type="radio" name="radio" style="width: 20px; height: 20px;">
                        <p style="text-align: left; margin-left: 20px;">Lorem ipsum, dolor sit amet consectetur
                            adipisicing
                            elit. Recusandae tempora praesentium nobis ut
                            maiores
                            sunt distinctio, consectetur quia autem adipisci.</p>
                    </div>
                </div>
                <div class="w-100 d-flex justify-content-end " style="margin-right: 50px;">
                    <span class="btn btn-secondary rounded">Add Address</span>
                </div>
            </div>
            <div class="p-2 border border-dark d-flex flex-column justify-content-around m-2 ">
                <h4><b>Order Details</b></h4>
                <table id="table" class="w-100 bg-light text-center border border-secondary">
                    <tr>
                        <th>SR.No.</th>
                        <th>Item name</th>
                        <th>price/item</th>
                        <th>Quantity</th>
                        <th>Total price</th>
                    </tr>

                </table>
                <div class="m-3 d-flex justify-content-between">
                    <div class="d-inline">
                        <h4>Delievery Charge: &#8377 40.00</h4>
                        <h3>Payable amount: <b id="totalprice">&#8377 00.00</b> </h3>
                    </div>
                    <span class="btn btn-danger rounded" style="height: 3rem;" onclick="confirmOrder()">Confirm Order</span>
                </div>

            </div>
        </div>

    </div>

    <div id="sample" style="display: none;">
        <div class=" mycard m-2 border border-dark d-flex  bg-dark">
            <img class="rounded m-1 img" height="97%" width="50%" src="../my_images/wallpaper1.jpg" alt="Card image cap">
            <div class="d-flex text-center w-100 flex-column bg-success ">
                <h2 class="border border-warning bg-info text-center m-2 p-1"><strong>Food Name</strong></h2>
                <br>
                <div class="d-flex flex-column flex-wrap justify-content-around text-center">
                    <div class="d-flex justify-content-around">
                        <div class="">
                            <h4><b>PRICE</b></h4>
                            <h6 class=" p-2 text-white border bg-primary  border-dark"> &#8377 <b>00.00</b></h6>
                        </div>
                        <div>
                            <h4><b>QUANTITY</b></h4>
                            <div class="d-flex flex-wrap justify-content-around text-center border border-dark p-1 bg-light ">
                                <span class=" rounded border border-dark btn btn-danger p-0 rounded-circle" style="width: 30px; height: 30px;">
                                    <b">-</b>
                                </span>

                                <span class=" rounded border border-dark bg-warning" style="width: 30px; height: 30px;">1</span>

                                <span class="rounded border border-dark btn btn-primary p-0 rounded-circle " style="width: 30px; height: 30px;"><b>+</b></span>
                            </div>
                        </div>
                    </div>
                    <span class=" m-4">
                        <!-- <h4>Delievery Charge: &#8377 00.00</h4> -->
                        <h3>Payable amount : &#8377 <b> 00.00</b> </h3>
                    </span>
                    <div class="w-100 d-flex justify-content-center">
                        <p class="btn btn-secondary rounded m-1">Remove From Orderlist</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

<script>
    var data = <?php echo $AllProducts; ?>;
    var sample = document.getElementById("sample").innerHTML;
    var productContainer = document.getElementById("allproduct");
    var click;
    var mytable = document.getElementById("table");
    var tablesrno = 1;
    var Totalprice = 0;

    function confirmOrder() {
        var userId = "<?php echo ($_SESSION["uid"]); ?>";
        var dataarray = new Array();
        var index = 0;
        for (var x in data) {
            var quant = document.getElementById("quant" + data[x]["id"]).innerHTML;
            var totalprice = document.getElementById("price" + data[x]["id"]).innerHTML;
            if (parseInt(price) != 0) {
                var orderdata = {
                    productid: data[x]["id"],
                    userid: userId,
                    sellerid: data[x]["shopId"],
                    //  datetime: Date(),
                    quantity: quant,
                    price: totalprice,
                    productprice: data[x]["price"],
                    orderplaced: true,
                    productname: data[x]["name"],
                    productimage: data[x]["image1"],
                }
                dataarray[index] = orderdata;
                index++;

            }
        }
        // console.log(JSON.stringify(dataarray));
        if (confirm("Are you sure to place your order")) {
            var req = new XMLHttpRequest;
            req.open("GET", "set_session_data.php?orderitem=" + JSON.stringify(dataarray), true);
            req.send();
            req.onreadystatechange = function() {
                if (req.readyState == 4 && req.status == 200) {
                    // console.log(req.responseText);
                    if (req.responseText == "done") {
                        alert("Your order placed successfuly");
                        location.href = "user_order_list.php";
                    } else {
                        alert("Your order not placed successfuly");
                    }
                }
            }
        }

    }

    function decbtn(click) {
        // console.log(click);
        var element = document.getElementById("quant" + click);
        var itemprice = document.getElementById("itemprice" + click).innerHTML;
        var setprice = document.getElementById("price" + click);
        var qt = element.innerHTML;
        if (qt <= 1) {
            element.innerHTML = 1;
            setprice.innerHTML = (itemprice);
            updatetable();
        } else {
            qt--;
            element.innerHTML = qt;
            setprice.innerHTML = qt * itemprice;
            updatetable();
        }
    }

    function incbtn(click) {
        // console.log(click);
        var element = document.getElementById("quant" + click);
        var itemprice = document.getElementById("itemprice" + click).innerHTML;
        var setprice = document.getElementById("price" + click);
        var qt = element.innerHTML;
        if (qt <= 0) {
            element.innerHTML = 1;
            setprice.innerHTML = (itemprice);
            updatetable();
        } else {
            qt++;
            element.innerHTML = qt;
            setprice.innerHTML = qt * itemprice;
            updatetable();
        }
    }

    function removefromlist(click) {
        // console.log(click);
        if (confirm("Are you sure to remove this item from order list")) {
            document.getElementById("id" + click).style.display = "none";
            document.getElementById("price" + click).innerHTML = 0;
            updatetable();
        }

    }
    // set items................................
    for (var x in data) {

        var newdiv = document.createElement("div");
        newdiv.setAttribute("id", "id" + data[x]["id"]);
        newdiv.innerHTML = sample;
        productContainer.append(newdiv);
        var img = document.querySelector("#id" + data[x]["id"] + ">div>img");
        img.setAttribute("onclick", "clicked(" + data[x]["id"] + ")");
        img.setAttribute("src", data[x]["image1"]);
        document.querySelector("#id" + data[x]["id"] + ">div>div>h2>strong").innerHTML = data[x]["name"];
        var eleprice = document.querySelector("#id" + data[x]["id"] + ">div>div>div>div>div>h6>b");
        eleprice.setAttribute("id", "itemprice" + data[x]["id"]);
        eleprice.innerHTML = data[x]["price"];

        var quant = document.querySelectorAll("#id" + data[x]["id"] + ">div>div>div>div>div>div>span");
        quant[1].setAttribute("id", "quant" + data[x]["id"]);
        quant[0].setAttribute("onclick", "decbtn(\"" + data[x]['id'] + "\")");
        quant[2].setAttribute("onclick", "incbtn(\"" + data[x]["id"] + "\")");

        var totalprice = document.querySelector("#id" + data[x]["id"] + ">div>div>div>span>h3>b");
        totalprice.setAttribute("id", "price" + data[x]["id"]);
        totalprice.innerHTML = data[x]["price"];

        document.querySelector("#id" + data[x]["id"] + ">div>div>div>div>p").setAttribute("onclick", "removefromlist(\"" + data[x]["id"] + "\")");
    }

    // set table data..........................
    for (var x in data) {
        var tr = document.createElement("tr");
        var td1 = document.createElement("td");
        td1.innerHTML = tablesrno;
        tablesrno++;
        var td2 = document.createElement("td");
        td2.innerHTML = data[x]["name"];
        var td3 = document.createElement("td");
        td3.innerHTML = data[x]["price"];

        var td4 = document.createElement("td");
        td4.innerHTML = document.getElementById("quant" + data[x]["id"]).innerHTML;
        var td5 = document.createElement("td");
        var price = document.getElementById("price" + data[x]["id"]).innerHTML;
        td5.innerHTML = price;

        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5);
        mytable.appendChild(tr);
        Totalprice = Totalprice + parseInt(price);
    }

    if (Totalprice != 0) {
        document.getElementById("totalprice").innerHTML = Totalprice + 40;
    } else {
        document.getElementById("totalprice").innerHTML = 0;
        alert("you have no item selected");
        location.href = "userHomePage.php";
    }

    function updatetable() {
        tablesrno = 1;
        Totalprice = 0;
        mytable.innerHTML = "";

        var tr = document.createElement("tr");
        var th1 = document.createElement("th")
        th1.innerHTML = "SR.No.";
        var th2 = document.createElement("th");
        th2.innerHTML = "Item name";
        var th3 = document.createElement("th");
        th3.innerHTML = "price/item";
        var th4 = document.createElement("th");
        th4.innerHTML = "Quantity";
        var th5 = document.createElement("th");
        th5.innerHTML = "Total price";

        tr.appendChild(th1);
        tr.appendChild(th2);
        tr.appendChild(th3);
        tr.appendChild(th4);
        tr.appendChild(th5);
        mytable.appendChild(tr);

        for (var x in data) {
            var tr = document.createElement("tr");
            var td1 = document.createElement("td");
            td1.innerHTML = tablesrno;
            var td2 = document.createElement("td");
            td2.innerHTML = data[x]["name"];
            var td3 = document.createElement("td");
            td3.innerHTML = data[x]["price"];
            var td4 = document.createElement("td");
            td4.innerHTML = document.getElementById("quant" + data[x]["id"]).innerHTML;
            var td5 = document.createElement("td");
            var price = document.getElementById("price" + data[x]["id"]).innerHTML;
            td5.innerHTML = price;
            if (price != 0) {
                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);
                tr.appendChild(td5);
                mytable.appendChild(tr);
                tablesrno++;
            }
            Totalprice = Totalprice + parseInt(price);

        }

        if (Totalprice != 0) {
            document.getElementById("totalprice").innerHTML = Totalprice + 40;
        } else {
            document.getElementById("totalprice").innerHTML = 0;
            alert("you have no item selected");
            location.href = "userHomePage.php";
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