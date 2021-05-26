<?php
session_start();
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if (
    isset($_SESSION["sname"]) && isset($_SESSION["sid"])
    && isset($_SESSION["smobile"])
) {
    if (
        $_SESSION["sname"] != "" && $_SESSION["sid"] != ""
        && $_SESSION["smobile"] != ""
    ) {
        header("Location:sellerHomePage");
    }
}
if (
    isset($_SESSION["uname"]) && isset($_SESSION["uid"])
    && isset($_SESSION["umobile"])
) {
    if (
        $_SESSION["uname"] != "" && $_SESSION["uid"] != ""
        && $_SESSION["umobile"] != ""
    ) {
        header("Location:userHomePage.php");
    }
}
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

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

    <!-- thi is included for use of google cursive font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Orelega+One&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Orelega One', cursive;
            background: url("../my_images/wallpaper1.jpg") no-repeat center center/cover;
        }

        * {
            box-sizing: border-box;
        }

        h5 {
            padding: .5rem;
            margin: .1rem;
            font-size: 1.2rem;
            border: 2px solid green;
            background-color: red;
        }

        h6 {
            padding: .5rem;
            margin: .1rem;
            font-size: 1.2rem;
            text-align: center;
            border: 2px solid green;
            background-color: #4CAF50;
            color: yellow;
        }

        h6 a {
            text-decoration: none;
            color: yellow;
        }

        h2 {
            text-align: center;
            color: white;
        }

        .mycontainer {
            overflow: auto;
            margin: 25%;
            margin-bottom: 10px;
            border: 7px solid green;
            background-color: rgb(22, 65, 22);
        }
    </style>
</head>

<body>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
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
                <div class="carousel-caption d-none d-md-block">
                    <div class="container">
                        <div class="mycontainer">
                            <table onclick="userReq()">
                                <tr>
                                    <td style="background-color: blue;">
                                        <h5>B</h5>
                                        <h5>U</h5>
                                        <h5>Y</h5>
                                        <h5>E</h5>
                                        <h5>R</h5>
                                    </td>
                                    <td class="w-100">
                                        <h2 class="rounded-left">
                                            <div class="d-inline-block align-center rounded-circle" style="width: 50px; height: 50px;background-color:white"><img src="../my_images/my_logo.png" width="40" height="40" class="d-inline-block align-center" alt=""></div> Welcome you
                                        </h2>
                                        <h6 class="rounded-left"><a href="../my_php_code/login.php"> Login</a></h6>
                                        <h6 class="rounded-left"><a href="../my_php_code/user_sign_up.php">Creat Account</a></h6>
                                        <h6 class="rounded-left "><a href="../my_php_code/user_forgate_password.php">Forgate password</a></h6>

                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="mycontainer" style="margin-top: 10px;">
                            <table onclick="sellerReq()">
                                <tr>
                                    <td style="background-color: blue;">
                                        <h5>S</h5>
                                        <h5>E</h5>
                                        <h5>II</h5>
                                        <h5>E</h5>
                                        <h5>R</h5>
                                    </td>
                                    <td class="w-100">
                                        <h2 class="rounded-left">
                                            <div class="d-inline-block align-center rounded-circle" style="width: 50px; height: 50px;background-color:white"><img src="../my_images/my_logo.png" width="40" height="40" class="d-inline-block align-center" alt=""></div> Welcome you
                                        </h2>
                                        <h6 class="rounded-left"><a href="../my_php_code/login.php"> Login</a></h6>
                                        <h6 class="rounded-left"><a href="seller_sign_up.php">Creat Account</a></h6>
                                        <h6 class="rounded-left"><a href="../my_php_code/user_forgate_password.php">Forgate password</a></h6>

                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../my_images/wallpaper2.jpg" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <div class="container">
                        <div class="mycontainer">
                            <table onclick="userReq()">
                                <tr>
                                    <td style="background-color: blue;">
                                        <h5>B</h5>
                                        <h5>U</h5>
                                        <h5>Y</h5>
                                        <h5>E</h5>
                                        <h5>R</h5>
                                    </td>
                                    <td class="w-100">
                                        <h2 class="rounded-left">
                                            <div class="d-inline-block align-center rounded-circle" style="width: 50px; height: 50px;background-color:white"><img src="../my_images/my_logo.png" width="40" height="40" class="d-inline-block align-center" alt=""></div> Welcome you
                                        </h2>
                                        <h6 class="rounded-left"><a href="../my_php_code/login.php"> Login</a></h6>
                                        <h6 class="rounded-left"><a href="../my_php_code/user_sign_up.php">Creat Account</a></h6>
                                        <h6 class="rounded-left "><a href="">Forgate password</a></h6>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="mycontainer" style="margin-top: 10px;">
                            <table onclick="sellerReq()">
                                <tr>
                                    <td style="background-color: blue;">
                                        <h5>S</h5>
                                        <h5>E</h5>
                                        <h5>II</h5>
                                        <h5>E</h5>
                                        <h5>R</h5>
                                    </td>
                                    <td class="w-100">
                                        <h2 class="rounded-left">
                                            <div class="d-inline-block align-center rounded-circle" style="width: 50px; height: 50px;background-color:white"><img src="../my_images/my_logo.png" width="40" height="40" class="d-inline-block align-center" alt=""></div> Welcome you
                                        </h2>
                                        <h6 class="rounded-left"><a href="../my_php_code/login.php"> Login</a></h6>
                                        <h6 class="rounded-left"><a href="../my_php_code/sign_up.php">Creat Account</a></h6>
                                        <h6 class="rounded-left"><a href="">Forgate password</a></h6>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../my_images/wallpaper3.jpg" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <div class="container">
                        <div class="mycontainer">
                            <table onclick="userReq()">
                                <tr>
                                    <td style="background-color: blue;">
                                        <h5>B</h5>
                                        <h5>U</h5>
                                        <h5>Y</h5>
                                        <h5>E</h5>
                                        <h5>R</h5>
                                    </td>
                                    <td class="w-100">
                                        <h2 class="rounded-left">
                                            <div class="d-inline-block align-center rounded-circle" style="width: 50px; height: 50px;background-color:white"><img src="../my_images/my_logo.png" width="40" height="40" class="d-inline-block align-center" alt=""></div> Welcome you
                                        </h2>
                                        <h6 class="rounded-left"><a href="../my_php_code/login.php"> Login</a></h6>
                                        <h6 class="rounded-left"><a href="../my_php_code/user_sign_up.php">Creat Account</a></h6>
                                        <h6 class="rounded-left "><a href="">Forgate password</a></h6>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="mycontainer" style="margin-top: 10px;">
                            <table onclick="sellerReq()">
                                <tr>
                                    <td style="background-color: blue;">
                                        <h5>S</h5>
                                        <h5>E</h5>
                                        <h5>II</h5>
                                        <h5>E</h5>
                                        <h5>R</h5>
                                    </td>
                                    <td class="w-100">
                                        <h2 class="rounded-left">
                                            <div class="d-inline-block align-center rounded-circle" style="width: 50px; height: 50px;background-color:white"><img src="../my_images/my_logo.png" width="40" height="40" class="d-inline-block align-center" alt=""></div> Welcome you
                                        </h2>
                                        <h6 class="rounded-left"><a href="../my_php_code/login.php"> Login</a></h6>
                                        <h6 class="rounded-left"><a href="../my_php_code/sign_up.php">Creat Account</a></h6>
                                        <h6 class="rounded-left"><a href="">Forgate password</a></h6>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../my_images/wallpaper4.jpg" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <div class="container">
                        <div class="mycontainer">
                            <table onclick="userReq()">
                                <tr>
                                    <td style="background-color: blue;">
                                        <h5>B</h5>
                                        <h5>U</h5>
                                        <h5>Y</h5>
                                        <h5>E</h5>
                                        <h5>R</h5>
                                    </td>
                                    <td class="w-100">
                                        <h2 class="rounded-left">
                                            <div class="d-inline-block align-center rounded-circle" style="width: 50px; height: 50px;background-color:white"><img src="../my_images/my_logo.png" width="40" height="40" class="d-inline-block align-center" alt=""></div> Welcome you
                                        </h2>
                                        <h6 class="rounded-left"><a href="../my_php_code/login.php"> Login</a></h6>
                                        <h6 class="rounded-left"><a href="../my_php_code/user_sign_up.php">Creat Account</a></h6>
                                        <h6 class="rounded-left "><a href="">Forgate password</a></h6>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="mycontainer" style="margin-top: 10px;">
                            <table onclick="sellerReq()">
                                <tr>
                                    <td style="background-color: blue;">
                                        <h5>S</h5>
                                        <h5>E</h5>
                                        <h5>II</h5>
                                        <h5>E</h5>
                                        <h5>R</h5>
                                    </td>
                                    <td class="w-100">
                                        <h2 class="rounded-left">
                                            <div class="d-inline-block align-center rounded-circle" style="width: 50px; height: 50px;background-color:white"><img src="../my_images/my_logo.png" width="40" height="40" class="d-inline-block align-center" alt=""></div> Welcome you
                                        </h2>
                                        <h6 class="rounded-left"><a href="../my_php_code/login.php"> Login</a></h6>
                                        <h6 class="rounded-left"><a href="../my_php_code/sign_up.php">Creat Account</a></h6>
                                        <h6 class="rounded-left"><a href="">Forgate password</a></h6>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../my_images/wallpaper5.jpg" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <div class="container">
                        <div class="mycontainer">
                            <table onclick="userReq()">
                                <tr>
                                    <td style="background-color: blue;">
                                        <h5>B</h5>
                                        <h5>U</h5>
                                        <h5>Y</h5>
                                        <h5>E</h5>
                                        <h5>R</h5>
                                    </td>
                                    <td class="w-100">
                                        <h2 class="rounded-left">
                                            <div class="d-inline-block align-center rounded-circle" style="width: 50px; height: 50px;background-color:white"><img src="../my_images/my_logo.png" width="40" height="40" class="d-inline-block align-center" alt=""></div> Welcome you
                                        </h2>
                                        <h6 class="rounded-left"><a href="../my_php_code/login.php"> Login</a></h6>
                                        <h6 class="rounded-left"><a href="../my_php_code/user_sign_up.php">Creat Account</a></h6>
                                        <h6 class="rounded-left "><a href="">Forgate password</a></h6>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="mycontainer" style="margin-top: 10px;">
                            <table onclick="sellerReq()">
                                <tr>
                                    <td style="background-color: blue;">
                                        <h5>S</h5>
                                        <h5>E</h5>
                                        <h5>II</h5>
                                        <h5>E</h5>
                                        <h5>R</h5>
                                    </td>
                                    <td class="w-100">
                                        <h2 class="rounded-left">
                                            <div class="d-inline-block align-center rounded-circle" style="width: 50px; height: 50px;background-color:white"><img src="../my_images/my_logo.png" width="40" height="40" class="d-inline-block align-center" alt=""></div> Welcome you
                                        </h2>
                                        <h6 class="rounded-left"><a href="../my_php_code/login.php"> Login</a></h6>
                                        <h6 class="rounded-left"><a href="../my_php_code/sign_up.php">Creat Account</a></h6>
                                        <h6 class="rounded-left"><a href="">Forgate password</a></h6>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>

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

</body>

<script>
    function userReq() {

        var ajex = new XMLHttpRequest();
        ajex.open("POST", "set_session_data.php", true);
        ajex.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajex.send("name=userReq");
    }

    function sellerReq() {

        var ajex = new XMLHttpRequest();
        ajex.open("POST", "set_session_data.php", true);
        ajex.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajex.send("name=sellerReq");
    }
</script>

</html>