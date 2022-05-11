<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$oldcart = array();
if (count($_SESSION['cart']) > 0) $oldcart = $_SESSION['cart'];
session_destroy();
session_start();
$_SESSION['cart'] = $oldcart;
$url = "index.php";
header('location: ' . $url);
?>
