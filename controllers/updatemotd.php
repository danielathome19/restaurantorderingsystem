<?php
$index = $_POST["index"];
$motd = $_POST["motd"];

$servername = "localhost";
$dbname = "restaurantsystem";
$dbusername = "restaurant";
$dbpassword = "compsci776";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
$sql = mysqli_query($conn, "UPDATE homepage SET motd = '$motd' WHERE homepage.index = $index");

if ($sql) {
    echo "Record updated successfully. Redirecting in 3 seconds..";
    $conn->close();
    header('refresh:3; url=../index.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>