<?php
$index = $_POST["index"];

$servername = "localhost";
$dbname = "restaurantsystem";
$dbusername = "restaurant";
$dbpassword = "compsci776";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
$sql = mysqli_query($conn, "DELETE FROM items WHERE items.index = $index");

if ($sql) {
    echo "Record removed successfully. Redirecting in 3 seconds..";
    $conn->close();
    header('refresh:3; url=../menu.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>