<?php
session_start();
if ($_SESSION["loginstatus"] != "user") {
    $_SESSION["postpage"] = "userLogin";
    header("Location:login.php");
}
?>
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

            background: url("../my_images/wallpaper1.jpg") no-repeat center center/cover;
        }

        * {
            box-sizing: border-box;
        }

        span {
            color: blue;
        }

        h4 {
            color: red;
            font-weight: bold;
            padding-left: 2rem;
            /* text-align: center; */
        }

        span {
            font-family: cursive;
        }
    </style>

</head>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["postpage"] = "editprofile";
    header("Location:user_sign_up.php");
}
?>

<body>
    <nav class="navbar navbar-expand-lg navbar-light position-fixed bg-light " style="z-index: 1; width: 100%;">

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
                    <a class=" font-weight-bold btn btn-outline-secondary m-1" href="#">Your Profile</a>
                </li>
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
        </div>
    </nav>
    <div style="height: 70px;"></div>

    <div class="text-center">
        <a href="<?php echo $_SESSION["uprofileimg"]; ?>"> <img src="<?php echo $_SESSION["uprofileimg"]; ?>" width="200px" height="200px" class="rounded-circle border border-success " alt="..."></a>
        <div class=" text-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <button type="submit" class="btn btn-secondary m-2">Edit Profile</button>
            </form>
        </div>

    </div>
    <div class=" rounded container bg-success border border-success p-3" style="margin-bottom: 3rem;">
        <div class=" rounded container bg-primary border border-success p-3">
            <div class=" rounded container bg-warning border border-success p-3">
                <div class=" rounded container bg-secondary border border-success p-3">
                    <div class=" rounded container bg-light border border-success p-3">
                        <h4>Name: <span><?php echo $_SESSION["uname"]; ?></span></h4>
                        <hr>
                        <h4>Mobile Number: <span><?php echo $_SESSION["umobile"]; ?></span></h4>
                        <hr>
                        <h4>Date Of Birth: <span><?php echo $_SESSION["udob"]; ?></span></h4>
                        <hr>
                        <h4>Email Id: <span><?php echo $_SESSION["uemail"]; ?></span></h4>
                        <hr>
                        <h4>Address: <span><?php echo $_SESSION["uaddress"]; ?></span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>