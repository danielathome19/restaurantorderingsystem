<?php
function pullAccountDetails($accusername) {
    $servername = "localhost";
    $dbname = "restaurantsystem";
    $dbusername = "restaurant";
    $dbpassword = "compsci776";

    $accdetails = array();

    $sql = "SELECT * FROM `accounts` WHERE `username` = '" . $accusername . "'";
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $accdetails[0] = $row["first_name"];
            $accdetails[1] = $row["last_name"];
            $accdetails[2] = $row["username"];
            $accdetails[3] = $row["phone"];
            $accdetails[4] = $row["email"];
            $accdetails[5] = $row["role"];
            $accdetails[6] = $row["address"];
            $accdetails[7] = $row["billing_address"];
            $accdetails[8] = $row["purchase_history"];
            $accdetails[9] = $row["saved_card_info"];

        }
    }
    
    $conn->close();
    return $accdetails;
}

?>