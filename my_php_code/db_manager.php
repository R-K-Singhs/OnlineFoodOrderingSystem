<?php
session_start();
?>
<?php
$_SESSION["dbstatus"] = "";
$_SESSION["dberror"] = "";
$_SESSION["error"] = "";
$_SESSION["status"] = "";

class DbManager
{
    private $conn;

    function connDatabase()
    {
        $servername = "localhost";
        $username = "root";
        $password = "Alka@15121998";

        $this->conn = new mysqli($servername, $username, $password, "food_management_system");
        if ($this->conn->connect_error) {
            $_SESSION["dbstatus"] = "Connection Faild" . "<br> ";
            //echo "connection faild";
            $_SESSION["dberror"] = $this->conn->connect_error . "<br> ";
            return false;
        } else {
            $_SESSION["dbstatus"] = "Database connected successfully" . "<br> ";
            // echo "connected";
            $_SESSION["dberror"] = "";
            return true;
        }
    }

    function closeDatabase()
    {
        $this->conn->close();
    }

    function insertData($query)
    {
        if ($this->conn->query($query)) {
            $_SESSION["dbstatus"] = "<h3>your data saved successfuly</h3>" . "<br> ";
            //echo "your data insertion done";
            $_SESSION["dberror"] = "";
            return true;
        } else {
            $_SESSION["dberror"] = $this->conn->error . "<br> ";
            // echo "data is not inserted";
            $_SESSION["dbstatus"] = "<h3>Your Data is not saved</h3>" . "<br> ";
            return false;
        }
    }

    function getData($query)
    {
        $result = $this->conn->query($query);

        if ($result) {
            $_SESSION["dbstatus"] = "Data Fetching successfuly" . "<br> ";
            $_SESSION["dberror"] = "";
            return $result;
        } else {
            $_SESSION["dberror"] = $this->conn->error . "<br> ";
            $_SESSION["dbstatus"] = "Data Fetching faild" . "<br> ";
            return null;
        }
    }

    function deleteData($query)
    {
        if ($this->conn->query($query)) {
            return true;
        } else {
            $_SESSION["dberror"] = $this->conn->error;
            return false;
        }
    }
}
