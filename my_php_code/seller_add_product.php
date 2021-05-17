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

$sellerId = $_SESSION["sid"];
$db = new DbManager();
$db->connDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $foodname = $_POST["foodname"];
    $foodprice = $_POST["foodprice"];
    $fooddisc = $_POST["fooddisc"];
    $foodtype = $_POST["foodtype"];

    $sellerfoodimgdir = "../seller_food_images/sellerId_" . $_SESSION["sid"];

    $imgURL = array("", "", "", "", "", "", "", "", "", "");

    if (is_dir($sellerfoodimgdir)) {
        //echo "all ready have dir";
        $imgno = 1;
        $i = 0;

        while (true) {
            if ($_FILES["image" . $imgno]["size"] != 0) {
                if (move_uploaded_file($_FILES["image" . $imgno]["tmp_name"], $sellerfoodimgdir . "/" . $_FILES["image" . $imgno]["name"])) {
                    $imgURL[$i] = $sellerfoodimgdir . "/" . $_FILES["image" . $imgno]["name"];
                }
            }

            $imgno++;
            $i++;
            if ($imgno == 11) {
                break;
            }
        }
        $query = "INSERT INTO fooddetails (name,price,type,discription,shopId,image1,image2,image3,image4,image5,image6,image7,image8,image9,image10) VALUES('$foodname','$foodprice','$foodtype','$fooddisc','$sellerId','$imgURL[0]','$imgURL[1]','$imgURL[2]','$imgURL[3]','$imgURL[4]','$imgURL[5]','$imgURL[6]','$imgURL[7]','$imgURL[8]','$imgURL[9]')";

        if ($db->insertData($query)) {
            // echo ("<script> alert('Your Product added successfuly and ready for comming to online');</script>");
            header("Location:seller_all_products.php");
        } else {

            echo ("<script> alert('Your Product is not added try again becauses you entered \'  should not be in discription ');</script>");
        }
    } else {

        if (mkdir($sellerfoodimgdir, 0777, true)) {
            $imgno = 1;
            $i = 0;

            while (true) {
                if ($_FILES["image" . $imgno]["size"] != 0) {
                    if (move_uploaded_file($_FILES["image" . $imgno]["tmp_name"], $sellerfoodimgdir . "/" . $_FILES["image" . $imgno]["name"])) {
                        $imgURL[$i] = $sellerfoodimgdir . "/" . $_FILES["image" . $imgno]["name"];
                    }
                }
                $imgno++;
                $i++;
                if ($imgno == 11) {
                    break;
                }
            }
            $query = "INSERT INTO fooddetails (name,price,type,discription,shopId,image1,image2,image3,image4,image5,image6,image7,image8,image9,image10) VALUES('$foodname','$foodprice','$foodtype','$fooddisc','$sellerId','$imgURL[0]','$imgURL[1]','$imgURL[2]','$imgURL[3]','$imgURL[4]','$imgURL[5]','$imgURL[6]','$imgURL[7]','$imgURL[8]','$imgURL[9]')";

            if ($db->insertData($query)) {
                // echo ("<script> alert('Your Product added successfuly and ready for comming to online');</script>");
                header("Location:seller_all_products.php");
            } else {

                echo ("<script> alert('Your Product is not added try again');</script>");
            }
        }
    }
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
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light  bg-light" style="z-index: 1; width: 100%;">

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
    <div class="container p-3">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">

            <div class="container form-control m-2  bg-dark ">
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id=""><b>Item Types</b></span>
                    </div>
                    <select class="form-control" name="foodtype" onchange="itemTypeChange(this)" required>
                        <option value="" disabled selected>Choose Item Type</option>
                        <option value="Foods">Foods</option>
                        <option value="Fruits">Fruits</option>
                        <option value="Glosary">Glosary</option>
                        <option value="Stationary">Stationary</option>
                        <option value="Sports">Sports</option>
                        <option value=" sweets">sweets</option>

                    </select>
                </div>
                <hr>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id=""><b>Item name</b></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Enter food name" name="foodname" required>

                </div>
                <hr>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><b>Price</b></span>
                        <span class="input-group-text">&#8377</span>
                    </div>
                    <input type="number" class="form-control" placeholder="Enter Food Price" name="foodprice" required>
                </div>
                <hr>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><b>Discription</b></span>
                    </div>
                    <textarea name="fooddisc" id="" cols="30" rows="3" type="text" class="form-control" placeholder="Enter food discription" required></textarea>
                    <!-- <input type="text" class="form-control" placeholder="Enter food discription" name="fooddisc" required> -->
                </div>
                <hr>

                <span class="p-2 bg-success w-20 text-white" id=""><b>Select Food Images</b></span>
                <br>
                <hr>
                <div class="container border border-danger rounded d-flex flex-wrap justify-content-between">

                    <div class="card m-1" style="width: 10rem; overflow-x: none;">
                        <img class="card-img-top" style="height: 10rem;" src="" id="img1" alt="Required:">
                        <div class="card-body">
                            <input type="file" class=" m-1 form-control" onchange="readFile1(this)" name="image1" required>
                        </div>
                    </div>
                    <div class="card m-1" style="width: 10rem; overflow-x: none;">
                        <img class="card-img-top" style="height: 10rem;" src="" id="img2" alt="Optional:">
                        <div class="card-body">
                            <input type="file" class=" m-1 form-control" onchange="readFile2(this)" name="image2">
                        </div>
                    </div>
                    <div class="card m-1" style="width: 10rem; overflow-x: none;">
                        <img class="card-img-top" style="height: 10rem;" src="" id="img3" alt="Optional:">
                        <div class="card-body">
                            <input type="file" class=" m-1 form-control" onchange="readFile3(this)" name="image3">
                        </div>
                    </div>
                    <div class="card m-1" style="width: 10rem; overflow-x: none;">
                        <img class="card-img-top" style="height: 10rem;" src="" id="img4" alt="Optional:">
                        <div class="card-body">
                            <input type="file" class=" m-1 form-control" onchange="readFile4(this)" name="image4">
                        </div>
                    </div>
                    <div class="card m-1" style="width: 10rem; overflow-x: none;">
                        <img class="card-img-top" style="height: 10rem;" src="" id="img5" alt="Optional:">
                        <div class="card-body">
                            <input type="file" class=" m-1 form-control" onchange="readFile5(this)" name="image5">
                        </div>
                    </div>
                    <div class="card m-1" style="width: 10rem; overflow-x: none;">
                        <img class="card-img-top" style="height: 10rem;" src="" id="img6" alt="Optional:">
                        <div class="card-body">
                            <input type="file" class=" m-1 form-control" onchange="readFile6(this)" name="image6">
                        </div>
                    </div>
                    <div class="card m-1" style="width: 10rem; overflow-x: none;">
                        <img class="card-img-top" style="height: 10rem;" src="" id="img7" alt="Optional:">
                        <div class="card-body">
                            <input type="file" class=" m-1 form-control" onchange="readFile7(this)" name="image7">
                        </div>
                    </div>
                    <div class="card m-1" style="width: 10rem; overflow-x: none;">
                        <img class="card-img-top" style="height: 10rem;" src="" id="img8" alt="Optional:">
                        <div class="card-body">
                            <input type="file" class=" m-1 form-control" onchange="readFile8(this)" name="image8">
                        </div>
                    </div>
                    <div class="card m-1" style="width: 10rem; overflow-x: none;">
                        <img class="card-img-top" style="height: 10rem;" src="" id="img9" alt="Optional:">
                        <div class="card-body">
                            <input type="file" class=" m-1 form-control" onchange="readFile9(this)" name="image9">
                        </div>
                    </div>
                    <div class="card m-1" style="width: 10rem; overflow-x: none;">
                        <img class="card-img-top" style="height: 10rem;" src="" id="img10" alt="Optional:">
                        <div class="card-body">
                            <input type="file" class=" m-1 form-control" onchange="readFile10(this)" name="image10">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="m-1 btn rounded bg-danger" onclick="location.href='sellerHomePage.php'">Cancel</button>
                    <input type="submit" class="m-1 btn rounded bg-success" value=" Save Now">
                </div>

            </div>

        </form>

    </div>

</body>
<script>
    var item;
    var foodOpt = document.getElementsByClassName("food");

    function itemTypeChange(item) {
        var val = item.options[item.selectedIndex].value;
        if (val != "Foods") {
            console.log("if part");
            foodOpt[0].setAttribute("disabled", true);
        } else {
            console.log("else part");
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

<script>
    function readFile1(input) {
        let file = input.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function() {

            document.getElementById("img1").src = event.target.result;
        };
    }

    function readFile2(input) {
        let file = input.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function() {

            document.getElementById("img2").src = event.target.result;
        };
    }

    function readFile3(input) {
        let file = input.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function() {

            document.getElementById("img3").src = event.target.result;
        };
    }

    function readFile4(input) {
        let file = input.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function() {

            document.getElementById("img4").src = event.target.result;
        };
    }

    function readFile5(input) {
        let file = input.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function() {

            document.getElementById("img5").src = event.target.result;
        };
    }

    function readFile6(input) {
        let file = input.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function() {

            document.getElementById("img6").src = event.target.result;
        };
    }

    function readFile7(input) {
        let file = input.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function() {

            document.getElementById("img7").src = event.target.result;
        };
    }

    function readFile8(input) {
        let file = input.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function() {

            document.getElementById("img8").src = event.target.result;
        };
    }

    function readFile9(input) {
        let file = input.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function() {

            document.getElementById("img9").src = event.target.result;
        };
    }

    function readFile10(input) {
        let file = input.files[0];
        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function() {

            document.getElementById("img10").src = event.target.result;
        };
    }
</script>

</html>