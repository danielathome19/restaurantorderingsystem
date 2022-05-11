<?php
function pullTransactionIndex($time, $email) {
    $servername = "localhost";
    $dbname = "restaurantsystem";
    $dbusername = "restaurant";
    $dbpassword = "compsci776";

    $transindex = -1;
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    $sql = "SELECT * FROM `transactions` WHERE `email` = '" . $email . "' AND `time` = '" . $time . "'";
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $transindex = $row["index"];
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
    return $transindex;
}
?>