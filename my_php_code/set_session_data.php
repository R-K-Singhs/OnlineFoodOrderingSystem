<?php
require "./db_manager.php";
$db = new DbManager();
$db->connDatabase();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["name"])) {
        $_SESSION["loginstatus"] = "";
        if ($_POST["name"] === "userReq") {
            $_SESSION["postpage"] = "userLogin";
            echo "done";
        } else if ($_POST["name"] === "sellerReq") {
            $_SESSION["postpage"] = "sellerLogin";
            echo "done";
        } else {
            echo "faild";
        }
    } else {
        echo "faild";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET["id"])) {
        $_SESSION["productId"] = $_GET["id"];
        $_SESSION["orderall"] = "";
        echo "yes";
    } else if (isset($_GET["foodtype"])) {

        $foodtype = $_GET["foodtype"];
        if ($_GET["foodtype"] == "All") {
            $query = "SELECT * FROM fooddetails";
        } else {
            $query = "SELECT * FROM fooddetails WHERE type= '$foodtype'";
        }
        $result = $db->getData($query);
        if ($result->num_rows > 0) {
            $AllProducts = json_encode($result->fetch_all(MYSQLI_ASSOC));
            $db->closeDatabase();
            echo $AllProducts;
        } else {
            $db->closeDatabase();
            echo 'empty';
        }
    } else if (isset($_GET["productid"])) {
        $productid = $_GET["productid"];
        $uid = $_SESSION["uid"];

        $query = "SELECT * FROM usercart WHERE productId= '$productid' AND userid='$uid' ";
        $result = $db->getData($query);
        if ($result->num_rows > 0) {
            $db->closeDatabase();
            echo "exist";
        } else {
            $query = "INSERT INTO usercart (userId,productId) VALUES ('$uid','$productid')";
            if ($db->insertData($query)) {
                $query = "SELECT * FROM usercart WHERE userid='$uid'";
                $result = $db->getData($query);
                if ($result->num_rows > 0) {
                    $db->closeDatabase();
                    echo $result->num_rows;
                }
            } else {
                echo 'faield';
            }
        }
    } else if (isset($_GET["removeCartId"])) {
        $query = "DELETE FROM usercart WHERE userId=" . $_SESSION["uid"] . " AND productId=" . $_GET["removeCartId"];
        if ($db->deleteData($query)) {
            echo "done";
        } else {
            echo "faild";
        }
    } else if (isset($_GET["orderall"])) {
        $_SESSION["orderall"] = $_GET["orderall"];
        $_SESSION["productId"] = "";
        echo "yes";
    } else if (isset($_GET["orderitem"])) {

        $items = json_decode($_GET["orderitem"]);
        $data = "";
        $count1 = 1;
        foreach ($items as $x => $y) {
            $count2 = 1;
            if ($count1 != 1) {
                $data .= ",";
            }
            $data .= "(";
            foreach ($y as $a => $b) {
                if ($count2 != 1) {
                    $data .= ",";
                }
                if ($count2 < 8) {
                    $data .= "" . $b . "";
                } else {
                    $data .= "'" . $b . "'";
                }
                $count2++;
            }
            $data .= ")";
            $count1++;
        }
        // echo json_encode($data);
        $query = "INSERT INTO userorder(productId,userId,sellerId,quantity,totalprice,productprice,placed,productname,productimage) VALUES " . $data . ";";
        if ($db->insertData($query) == true) {
            $db->closeDatabase();
            echo "done";
        } else {
            echo $_SESSION["dberror"];
            $db->closeDatabase();
        }
    } else if (isset($_GET["showseller"])) {

        $query = "SELECT * FROM seller WHERE id=" . $_GET["showseller"];
        $result = $db->getData($query);
        if ($result->num_rows == 1) {
            echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        } else {
            echo "faield";
        }
    } else if (isset($_GET["showuser"])) {

        $query = "SELECT * FROM users WHERE id=" . $_GET["showuser"];
        $result = $db->getData($query);
        if ($result->num_rows == 1) {
            echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        } else {
            echo "faield";
        }
    } else if (isset($_GET["receivedorder"])) {
        $query = "UPDATE userorder SET delivered=true WHERE id=" . $_GET["receivedorder"];
        if ($db->insertData($query)) {
            $db->closeDatabase();
            echo "done";
        } else {
            echo $_SESSION["dberror"];
            $db->closeDatabase();
        }
        // $query = "SELECT deliveryrequest FROM userorder WHERE id=" . $_GET["receivedorder"] . ";";
        // $result = $db->getData($query);
        // if ($result->num_rows > 0) {
        //     $data = $result->fetch_all(MYSQLI_ASSOC);
        //     if ($data[0]["deliveryrequest"] === 1) {

        //     } else {
        //         echo "noreq";
        //     }
        // } else {
        //     echo $_SESSION["dberror"];
        // }
    } else if (isset($_GET["cancelorder"])) {

        $query = "DELETE FROM userorder WHERE id=" . $_GET["cancelorder"];
        if ($db->deleteData($query)) {
            $db->closeDatabase();
            echo "done";
        } else {
            echo $_SESSION["dberror"];
            $db->closeDatabase();
        }
    } else if (isset($_GET["deleteselleritem"])) {

        $query = "DELETE FROM fooddetails WHERE id=" . $_GET["deleteselleritem"];
        if ($db->deleteData($query)) {
            $query = "DELETE FROM usercart WHERE productId=" . $_GET["deleteselleritem"];
            if ($db->deleteData($query)) {
                $db->closeDatabase();
                echo "done";
            } else {
                echo $_SESSION["dberror"];
                $db->closeDatabase();
            }
        } else {
            echo $_SESSION["dberror"];
            $db->closeDatabase();
        }
    } else if (isset($_GET["setconfirmorderId"])) {
        $query = "UPDATE userorder SET confirm=true WHERE id=" . $_GET["setconfirmorderId"];
        if ($db->insertData($query)) {
            $db->closeDatabase();
            echo "done";
        } else {
            echo $_SESSION["dberror"];
            $db->closeDatabase();
        }
    } else if (isset($_GET["setdispatchorderId"])) {
        $query = "UPDATE userorder SET dispatch=true WHERE id=" . $_GET["setdispatchorderId"];
        if ($db->insertData($query)) {
            $db->closeDatabase();
            echo "done";
        } else {
            echo $_SESSION["dberror"];
            $db->closeDatabase();
        }
    } else if (isset($_GET["setpackedorderId"])) {
        $query = "UPDATE userorder SET packed=true WHERE id=" . $_GET["setpackedorderId"];
        if ($db->insertData($query)) {
            $db->closeDatabase();
            echo "done";
        } else {
            echo $_SESSION["dberror"];
            $db->closeDatabase();
        }
    } else if (isset($_GET["setdeliveryreqId"])) {
        $query = "UPDATE userorder SET deliveryrequest=true WHERE id=" . $_GET["setdeliveryreqId"];
        if ($db->insertData($query)) {
            $db->closeDatabase();
            echo "done";
        } else {
            echo $_SESSION["dberror"];
            $db->closeDatabase();
        }
    } else {
        $_SESSION["productId"] = "";
        echo "faild";
    }
}
