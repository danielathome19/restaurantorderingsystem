<?php
$index = $_POST["index"];
$role = $_POST["role".$index];

$servername = "localhost";
$dbname = "restaurantsystem";
$dbusername = "restaurant";
$dbpassword = "compsci776";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
$sql = mysqli_query($conn, "UPDATE accounts SET role = '$role' WHERE accounts.index = $index");

if ($sql) {
    echo "Record updated successfully. Redirecting in 3 seconds..";
    $conn->close();
    header('refresh:3; url=../admin.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>