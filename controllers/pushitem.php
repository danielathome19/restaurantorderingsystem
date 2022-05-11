<?php
$name = $_POST["name"];
$price = $_POST["price"];
$image = $_POST["imageb64"];
$description = $_POST["description"];
$ingredients = $_POST["ingredients"];
$preparation_time = $_POST["preparation_time"];

$servername = "localhost";
$dbname = "restaurantsystem";
$dbusername = "restaurant";
$dbpassword = "compsci776";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
$sql = mysqli_query($conn, "INSERT INTO items (name, price, description, image, ingredients, preparation_time) VALUES ('$name', '$price', '$description', '$image', '$ingredients', '$preparation_time')");

if ($sql) {
    echo "New record created successfully. Redirecting in 3 seconds..";
    $conn->close();
    header('refresh:3; url=../admin.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>