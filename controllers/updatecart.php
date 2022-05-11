<?php
session_start();
$index = $_POST["s_index"];
$food_index = $_POST["menu_index"];
$requests = $_POST["requests".$index];
$quantity = $_POST["quantity".$index];
$sess_string = "{" . $food_index . ",[" . str_replace(";", "-", str_replace(",", "-", $requests)) . "]," . $quantity . "}";
$_SESSION['cart'][$index] = $sess_string;
header("Location: ../cart.php");
?>