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

    <link rel="stylesheet" href="../my_css_code/welcome.css">

</head>

<?php

include "./db_manager.php";

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($_SESSION["postpage"] != "editprofile") {
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
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


$db = new DbManager();
$db->connDatabase();
$_SESSION["dbstatus"] = "";
$is_done = "no";

if ($_SESSION["postpage"] == "editprofile") {
    if (!isset($_SESSION["loginstatus"])) {
        header("Location:Welcome.php");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $img_name = $_FILES["profileimage"]["name"];
        $img_tempname = $_FILES["profileimage"]["tmp_name"];

        $userdir = "../sellers_data/seller" . $_SESSION['smobile'];
        $profileimagedir = $userdir . "/profileimage";
        $imgURL = "";

        if (is_dir($profileimagedir)) {
            move_uploaded_file($img_tempname, $profileimagedir . "/" . $img_name);
            $imgURL = $profileimagedir . "/" . $img_name;
            // echo  "<br>" . $profileimagedir . "/ " . $img_name . "<br>";
        } else {
            if (mkdir($userdir, 0777, true)) {
                if (mkdir($profileimagedir, 0777, true)) {
                    move_uploaded_file($img_tempname, $profileimagedir . "/" . $img_name);
                    $imgURL = $profileimagedir . "/" . $img_name;
                    //  echo "<br>" . $profileimagedir . "/ " . $img_name . "<br>";
                } else {
                    $_SESSION["error"] = "your profile image is not updated ";
                }
            } else {
                if (mkdir($profileimagedir, 0777, true)) {
                    move_uploaded_file($img_tempname, $profileimagedir . "/" . $img_name);
                    $imgURL = $profileimagedir . "/" . $img_name;
                    // echo "<br>" . $profileimagedir . "/ " . $img_name . "<br>";
                } else {
                    $_SESSION["error"] = "your profile image is not updated ";
                }
            }
        }
        $name = $_POST["name"];
        $pass = $_POST["pass"];
        // $mobile = $_POST["mobile"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $dob = $_POST["dob"];
        $shopname = $_POST["sname"];
        $shopnum = $_POST["snum"];
        $adharnum = $_POST["anum"];
        $pancardnum = $_POST["pnum"];
        $pincode = $_POST["pcode"];
        $sot = $_POST["sotime"];
        $sct = $_POST["sctime"];

        if ($db->connDatabase()) {

            $umobile = $_SESSION['smobile'];

            $query = "UPDATE seller SET name='$name',email='$email',address='$address',password='$pass',profile='$imgURL',dob='$dob',shopName='$shopname',shopNum='$shopnum',adharcard='$adharnum', pancard='$pancardnum',pincode='$pincode',sot='$sot',sct='$sct' WHERE mobile='$umobile'";

            if ($db->insertData($query)) {

                $query = "SELECT * FROM seller WHERE password='$pass' && mobile='$umobile'";
                $data = $db->getData($query);

                if ($data->num_rows == 1) {
                    $_SESSION["dbstatus"] = "<h3>Your Pofile is updated successfuly </h3>";
                    $row = $data->fetch_assoc();
                    $_SESSION["sname"] = $row["name"];
                    $_SESSION["sid"] = $row["id"];
                    // $_SESSION["umobile"] = $row["mobile"];
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
                    $_SESSION["postpage"] != "";
                    $is_done = "yes";
                } else {
                    // $_SESSION["dberror"] = "<h3>Your profile is not Updated </h3> <br>";
                }
            } else {
                //$_SESSION["dberror"] = "<h3>Your pprofile is not Updated </h3> <br>";
            }
        } else {
            $_SESSION["dberror"] = "<h3>Data base is not connected</h3>";
            $_SESSION["error"] = "";
        }
    }
} else {
    if (!isset($_SESSION["loginstatus"])) {
        header("Location:Welcome.php");
    }
    // echo "else part excuted now";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = $_POST["name"];
        $pass = $_POST["pass"];
        $mobile = $_POST["mobile"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $dob = $_POST["dob"];
        $shopname = $_POST["sname"];
        $shopnum = $_POST["snum"];
        $adharnum = $_POST["anum"];
        $pancardnum = $_POST["pnum"];
        $pincode = $_POST["pcode"];
        $sot = $_POST["sotime"];
        $sct = $_POST["sctime"];

        $img_name = $_FILES["profileimage"]["name"];
        $img_tempname = $_FILES["profileimage"]["tmp_name"];

        $userdir = "../sellers_data/seller" . $mobile;
        $profileimagedir = $userdir . "/profileimage";
        $imgURL = "";

        if (is_dir($profileimagedir)) {
            move_uploaded_file($img_tempname, $profileimagedir . "/" . $img_name);
            $imgURL = $profileimagedir . "/" . $img_name;
        } else {
            if (mkdir($userdir, 0777, true)) {
                if (mkdir($profileimagedir, 0777, true)) {
                    move_uploaded_file($img_tempname, $profileimagedir . "/" . $img_name);
                    $imgURL = $profileimagedir . "/" . $img_name;
                    //echo $profileimagedir . "/" . $img_name;
                } else {
                    $_SESSION["error"] = "your profile image is not updated" . "<br> ";
                }
            } else {
                if (mkdir($profileimagedir, 0777, true)) {
                    move_uploaded_file($img_tempname, $profileimagedir . "/" . $img_name);
                    $imgURL = $profileimagedir . "/" . $img_name;
                    //echo $profileimagedir . "/" . $img_name;
                } else {
                    $_SESSION["error"] = "your profile image is not updated " . "<br> ";
                }
            }
        }

        if ($db->connDatabase()) {

            $query = "INSERT INTO seller ( name, mobile, email,password,address,profile,dob,shopName,shopNum,adharcard,pancard,pincode,sot,sct) VALUES ('$name', '$mobile','$email','$pass','$address','$imgURL','$dob','$shopname','$shopnum','$adharnum','$pancardnum','$pincode','$sot','$sct')";

            if ($db->insertData($query)) {

                $query = "SELECT * FROM seller WHERE password='$pass' && mobile='$mobile'";
                $data = $db->getData($query);
                if ($data->num_rows == 1) {
                    $_SESSION["dbstatus"] = "<h3>Your Account created successfuly</h3>" . "<br> ";

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

                    $is_done = "yess";
                } else {
                    $_SESSION["dberror"] = "<h3>Your Account isn't created </h3>" . "<br> ";
                }
            } else {
                $_SESSION["dbstatus"] = "<h3>Your Account isn't created </h3>" . "<br> ";
            }
        } else {
            $_SESSION["dberror"] = "<h3>Data base is not connected</h3>";
            $_SESSION["error"] = "";
        }
    }
}

if ($is_done === "yess") {
    $_SESSION["postpage"] = "sellerLogin";
}
?>

<script>
    if ("<?php echo $is_done; ?>" == "yes") {
        if (confirm("Your profile is Updated successfuly. Are you sure to continue with HomePage")) {
            location.href = "sellerHomePage.php";
        }
    } else if ("<?php echo $is_done; ?>" == "yess") {
        if (confirm("Your Account is created successfuly. Are you sure to continue with HomePage")) {
            location.href = "sellerHomePage.php";
        } else {
            location.href = "login.php";
        }
    }
</script>

<body>
    <div id="id02">
        <form class="modal-content animate" id="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit=" return submitt()" enctype="multipart/form-data">

            <!-- <h1 id="status">hello world</h1> -->
            <div class="imgcontainer">
                <img src="../my_images/my_logo.png" alt="Avatar" class="avatar" width="150px" height="100px" style="margin-top: 5px;">
                <p class="tittle" style="font-size: 1.5rem;"><b> Sigh Up </b></p>
                <span onclick="location.href='./Welcome.php'" class="close" title="Close Modal">&times;</span>
            </div>
            <div class="alert alert-success m-1">
                <h6 style="margin: 0px; text-align: center; color: red;"><i>
                        <?php echo $_SESSION["dberror"]  . $_SESSION["error"] . $_SESSION["dbstatus"] . $_SESSION["status"] ?>
                    </i>
                </h6>
            </div>
            <div class="container">

                <div class="d-flex justify-content-between">
                    <div class="d-inline">
                        <label for="profileimage"><b>Profile Image </b></label><br><br>
                        <input type="file" onchange="setImage(this)" name="profileimage" required><br><br>
                    </div>

                    <div class="d-inline">
                        <div class="d-inline-block align-center rounded-circle" style="width: 100px; height: 100px; text-align:center;">
                            <a href="<?php echo $_SESSION["sprofileimg"]; ?>"><img id="myimage" src="" width="100" height="100" class="d-inline-block align-center border border-success" alt="UPLOAD IMAGE"></a>
                        </div>
                    </div>
                </div>

                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="name" required>

                <label for="dob"><b>Date Of Birth</b></label><br>
                <input type="date" placeholder="Enter DOB" name="dob" required><br>
                <hr>

                <label for="pass"><b>Password</b></label>
                <input oninput="isEqual()" type="password" placeholder="Enter Password" name="pass" required>

                <label for="repass"><b>Re_Password</b></label>
                <input oninput="isEqual()" type="password" placeholder="Enter Re_Password" name="repass" required>

                <div id="passErr" class="text-danger text-md-left" style="font-family: cursive; color: red;">
                </div>
                <hr>

                <div id="noEdit">
                    <label for="mobile"><b>Mobile number</b></label>
                    <input oninput="isMobile()" type="number" placeholder="Enter Mobile No." name="mobile">

                    <label for="remobile"><b>Re Mobile number</b></label>
                    <input oninput="isMobile()" type="number" placeholder="Enter Re_Mobile No." name="remobile">

                    <div id="mobileErr" class="text-danger text-md-left " style=" font-family: cursive; color: red;">
                    </div>
                    <hr>
                </div>

                <label for="email"><b>Email Id</b></label>
                <input oninput="isEmail()" type="text" placeholder="Enter Email_Id" name="email" required>

                <div id="emailErr" class="text-danger text-md-left" style=" color: red; font-family: cursive;">
                </div>
                <hr>

                <label for="sname"><b>Shop name</b></label>
                <input type="text" placeholder="Enter Shop name" name="sname" required>

                <label for="snum"><b>Shop No.</b></label>
                <input type="text" placeholder="Enter Shop No." name="snum" required>
                <hr>

                <label for="anum"><b>Adharcard No.</b></label>
                <input oninput="isAdharcard()" type="text" placeholder="Enter Adharcard No." name="anum" required>
                <div id="anumerror" class="text-danger text-md-left" style=" color: red; font-family: cursive;">
                </div>
                <hr>

                <label for="pnum"><b>Pancard No.</b></label>
                <input oninput="isPancard()" type="text" placeholder="Enter Pancard No." name="pnum" required>
                <div id="pnumerror" class="text-danger text-md-left" style=" color: red; font-family: cursive;">
                </div>
                <hr>

                <label for="pcode"><b>PIN Code </b></label>
                <input oninput="isPincode()" type="text" placeholder="Enter PIN Code" name="pcode" required>
                <div id="pcodeerror" class="text-danger text-md-left" style=" color: red; font-family: cursive;">
                </div>
                <hr>

                <div class="border border-secondary text-center p-2">
                    <label for="sotime"><b>Shop Opening Time </b></label>
                    <input type="time" placeholder="Enter Shop Opening Time" name="sotime" required>

                    <label for="sctime"><b>Shop Closing Time </b></label>
                    <input type="time" placeholder="Enter Shop Closing Time" name="sctime" required>
                </div>
                <hr>

                <label for="address"><b>Address</b></label>
                <textarea name="address" cols="30" rows="3" style="width: 100%; margin-right: 30px; margin-top: 10px;" placeholder="Enter Address" required>
                    </textarea>

                <label>
                    <input type="checkbox" name="remember" required> Remember me
                </label>

                <div class="d-flex justify-content-between">
                    <button type="button" onclick="location.href='./Welcome.php'" class=" btn btn-danger btn-sm">Cancel</button>
                    <button type="submit" id="subbtn" class="btn btn-success btn-sm">Sign Up</button>

                </div>
            </div>
        </form>
    </div>

</body>

<script>
    document.write("yes");

    function setImage(input) {
        let file = input.files[0];
        let read = new FileReader();
        read.readAsDataURL(file);
        read.onload = function() {
            document.getElementById("myimage").src = event.target.result;
        }
    }

    var valiedpass = false;
    var valiedmobile = false;
    var valiedemail = false;
    var valiedadharcard = false;
    var valiedpancard = false;
    var valiedpincode = false;


    function submitt() {

        var mobile = document.getElementsByName("mobile")[0].value;

        if ("<?php echo $_SESSION["postpage"]; ?>" == "editprofile") {

            if (valiedpass) {
                if (valiedemail) {
                    if (valiedadharcard) {
                        if (valiedpancard) {
                            if (valiedpincode) {
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            if (mobile == "") {
                document.getElementById("mobileErr").innerHTML = "Please Enter Your Mobile No.";
                return false;
            } else {
                if (valiedpass) {
                    if (valiedemail) {
                        if (valiedmobile) {
                            if (valiedadharcard) {
                                if (valiedpancard) {
                                    if (valiedpincode) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                } else {
                                    return false;
                                }
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }

                } else {
                    return false;
                }
            }
        }

    }

    if ("<?php echo $_SESSION["postpage"]; ?>" == "editprofile") {
        valiedpass = true;
        valiedemail = true;
        valiedadharcard = true;
        valiedpancard = true;
        valiedpincode = true;
    }

    function isPincode() {
        var anum = document.getElementsByName("pcode")[0].value;
        if (anum.length != 6) {
            document.getElementById("pcodeerror").innerHTML = "Please enter valied PINCODE number!";
            valiedpincode = false;
        } else {
            document.getElementById("pcodeerror").innerHTML = "";
            valiedpincode = true;
        }
    }

    function isPancard() {
        var anum = document.getElementsByName("pnum")[0].value;
        if (anum.length != 10) {
            document.getElementById("pnumerror").innerHTML = "Please enter valied Pancard number!";
            valiedpancard = false;
        } else {
            document.getElementById("pnumerror").innerHTML = "";
            valiedpancard = true;
        }
    }

    function isAdharcard() {
        var anum = document.getElementsByName("anum")[0].value;
        if (anum.length != 12) {
            document.getElementById("anumerror").innerHTML = "Please enter valied Adharcard number!";
            valiedadharcard = false;
        } else {
            document.getElementById("anumerror").innerHTML = "";
            valiedadharcard = true;
        }
    }


    function isEqual() {
        var pass = document.getElementsByName("pass")[0].value;
        var repass = document.getElementsByName("repass")[0].value;
        if (pass != repass) {
            document.getElementById("passErr").innerHTML = "Both password should be same !";
            valiedpass = false;
        } else {
            document.getElementById("passErr").innerHTML = "";
            valiedpass = true;
        }

    }

    function isMobile() {
        var mobile = document.getElementsByName("mobile")[0].value;
        var remobile = document.getElementsByName("remobile")[0].value;
        if (mobile == "") {
            document.getElementById("mobileErr").innerHTML = "Please Enter Your Mobile No.";
            return false;
        } else {
            if (mobile != remobile) {
                document.getElementById("mobileErr").innerHTML = "Both mobile number should be same !";
                valiedmobile = false;
            } else {
                if (remobile.length != 10 || mobile.length != 10) {
                    document.getElementById("mobileErr").innerHTML = "Mobile Number should have 10 char !";
                    valiedmobile = false;
                } else {
                    document.getElementById("mobileErr").innerHTML = "";
                    valiedmobile = true;
                }

            }
        }

    }

    function isEmail() {
        var email = document.getElementsByName("email")[0].value;

        if ((email.length - 10) != email.lastIndexOf("@gmail.com") || email.length < 11) {
            document.getElementById("emailErr").innerHTML = "Please enter email in Correct Formate ! ";
            valiedemail = false;
        } else {
            document.getElementById("emailErr").innerHTML = "";
            valiedemail = true;
        }

    }



    if ("<?php echo $_SESSION["postpage"]; ?>" == "editprofile") {

        document.getElementById("noEdit").style.display = "none";
        document.getElementsByClassName("tittle")[0].innerHTML = "Edit Profile";
        document.getElementById("subbtn").innerHTML = "save";

        document.getElementById('myimage').src = "<?php echo $_SESSION["sprofileimg"]; ?>";
        document.getElementsByName("name")[0].defaultValue = "<?php echo $_SESSION["sname"]; ?>";
        document.getElementsByName("pass")[0].defaultValue = "<?php echo $_SESSION["spassword"]; ?>";
        document.getElementsByName("repass")[0].defaultValue = "<?php echo $_SESSION["spassword"]; ?>";
        document.getElementsByName("dob")[0].defaultValue = "<?php echo $_SESSION["sdob"]; ?>";
        document.getElementsByName("email")[0].defaultValue = "<?php echo $_SESSION["semail"]; ?>";
        document.getElementsByName("address")[0].defaultValue = "<?php echo $_SESSION["saddress"]; ?>";

        document.getElementsByName("sname")[0].defaultValue = "<?php echo $_SESSION["shopname"]; ?>";
        document.getElementsByName("snum")[0].defaultValue = "<?php echo $_SESSION["shopnum"]; ?>";
        document.getElementsByName("anum")[0].defaultValue = "<?php echo $_SESSION["adharcard"]; ?>";
        document.getElementsByName("pnum")[0].defaultValue = "<?php echo $_SESSION["pancard"]; ?>";
        document.getElementsByName("pcode")[0].defaultValue = "<?php echo $_SESSION["pincode"]; ?>";
        document.getElementsByName("sotime")[0].defaultValue = "<?php echo $_SESSION["sot"]; ?>";
        document.getElementsByName("sctime")[0].defaultValue = "<?php echo $_SESSION["sct"]; ?>";

    }
</script>

</html>