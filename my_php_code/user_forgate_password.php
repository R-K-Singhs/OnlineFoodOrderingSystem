 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="../my_css_code/welcome.css">
     <title>Document</title>
 </head>

 <?php
    require "./db_manager.php";

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
    } else if (
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

    if ($_SESSION["postpage"] == "userLogin") {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $mobile = $_POST["mobile"];
            $dob = $_POST["dob"];
            $email = $_POST["email"];
            $db = new DbManager();

            $query = "SELECT * FROM users WHERE dob='$dob' && mobile='$mobile'&& email='$email'";
            if ($db->connDatabase()) {
                $data = $db->getData($query);
            }
            if ($data->num_rows == 1) {
                $_SESSION["status"] = "Your are logied successfuly";
                $row = $data->fetch_assoc();

                $_SESSION["uname"] = $row["name"];
                $_SESSION["uid"] = $row["id"];
                $_SESSION["umobile"] = $row["mobile"];
                $_SESSION["uemail"] = $row["email"];
                $_SESSION["upassword"] = $row["password"];
                $_SESSION["uaddress"] = $row["address"];
                $_SESSION["udob"] = $row["dob"];
                $_SESSION["uprofileimg"] = $row["profile"];
                $_SESSION["loginstatus"] = "user";

                header("Location:userHomePage.php");
            } else {
                echo "<script> alert('Your entered data is not correct so try again')</script>";
            }
        }
    } else if ($_SESSION["postpage"] == "sellerLogin") {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $mobile = $_POST["mobile"];
            $dob = $_POST["dob"];
            $email = $_POST["email"];
            $db = new DbManager();

            $query = "SELECT * FROM seller WHERE dob='$dob' && mobile='$mobile'&& email='$email'";
            if ($db->connDatabase()) {
                $data = $db->getData($query);
            }
            if ($data->num_rows == 1) {
                $_SESSION["status"] = "Your are logied successfuly";
                $row = $data->fetch_assoc();

                $_SESSION["sname"] = $row["name"];
                $_SESSION["sid"] = $row["id"];
                $_SESSION["smobile"] = $row["mobile"];
                $_SESSION["semail"] = $row["email"];
                $_SESSION["spassword"] = $row["password"];
                $_SESSION["saddress"] = $row["address"];
                $_SESSION["sdob"] = $row["dob"];
                $_SESSION["sprofileimg"] = $row["profile"];
                $_SESSION["shopname"] = $row["shopName"];
                $_SESSION["shopnum"] = $row["shopNum"];
                $_SESSION["adharcard"] = $row["adharcard"];
                $_SESSION["pancard"] = $row["pancard"];
                $_SESSION["pincode"] = $row["pincode"];
                $_SESSION["sot"] = $row["sot"];
                $_SESSION["sct"] = $row["sct"];
                $_SESSION["status"] = "";
                $_SESSION["loginstatus"] = "seller";
                header("Location:sellerHomePage.php");
            } else {
                echo "<script> alert('Your entered data is not correct so try again')</script>";
            }
        }
    } else {
        $seterror = "<h1>your request is no accepted</h1>";
    }
    ?>

 <body>

     <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">

         <div class="d-flex justify-content-between text-center p-0 m-0 w-100" style="background-color: rgb(22, 65, 22);">
             <img src="../my_images/my_logo.png" alt="Avatar" class="avatar" width="150px" height="100px">
             <span class="tittle d-inline" style="font-size: 20px;"><b>Forgate Password</b></span>
             <span onclick="location.href='./Welcome.php'" class="close" title="Close Modal">&times;</span>
         </div>

         <div class="container">

             <label for="mobile"><b>Enter registered mobile number</b></label>
             <input type="text" placeholder="Enter Resistered Mobile no." name="mobile" required>

             <label for="dob"><b>Choose registered Date of Birth</b></label>
             <input type="date" placeholder="Enter Password" name="dob" required>

             <label for="email"><b>Enter registered email ID</b></label>
             <input type="text" placeholder="Enter Resistered email" name="email" required>

         </div>

         <div class="d-flex justify-content-between">
             <button type="button" onclick="location.href='./Welcome.php'" class=" btn btn-danger btn-sm">Cancel</button>
             <button type="submit" id="subbtn" class="btn btn-success btn-sm">submit</button>

         </div>
     </form>

 </body>

 </html>