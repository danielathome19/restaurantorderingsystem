<?php
function updateTransactionComplete($index) {
$servername = "localhost";
$dbname = "restaurantsystem";
$dbusername = "restaurant";
$dbpassword = "compsci776";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
$sql = mysqli_query($conn, "UPDATE transactions SET completed = '1' WHERE transactions.index = $index");

if ($sql) {
    //echo "Record updated successfully. Redirecting in 3 seconds..";
    $conn->close();
    header("Location: admin.php");
    //header('refresh:3; url=../admin.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}
?>