<?php
$index = $_POST["index"];
$name = $_POST["name".$index];
$price = $_POST["price".$index];
$image = $_POST["imageb64".$index];
$description = $_POST["description".$index];
$ingredients = $_POST["ingredients".$index];
$preparation_time = $_POST["preparation_time".$index];

$servername = "localhost";
$dbname = "restaurantsystem";
$dbusername = "restaurant";
$dbpassword = "compsci776";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
$sql = mysqli_query($conn, "UPDATE items SET name = '$name', price = '$price', description = '$description', image = '$image', ingredients = '$ingredients', preparation_time = '$preparation_time' WHERE items.index = $index");

if ($sql) {
    echo "Record updated successfully. Redirecting in 3 seconds..";
    $conn->close();
    header('refresh:3; url=../menu.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>