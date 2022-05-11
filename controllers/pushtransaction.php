<?php
include("controllers/connect.php"); //INCLUDE CONNECTION
error_reporting(0); // hide undefine index errors
session_start();
$fullname = $_POST["fullname"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$address = "";
if (strcmp($_POST['selector'], "pickup") == 0) {
    $address = "Pickup";
} else {
    $address .= $_POST['deladr'] . ",";
    $address .= $_POST['delcity'] . ",";
    $address .= $_POST['delstate'] . ",";
    $address .= $_POST['delzip'];

}

$revenue = (float)($_SESSION['carttotal']);
$eta = $_SESSION['cartpreptime'];
$eta += $_POST['deliverytime'];
$deliveryfee = $_SESSION['deliveryfee'];
$revenue += $deliveryfee;

$items_sold = "[ ";
foreach ($_SESSION['cart'] as $cartitem) {
    $items_sold .= $cartitem . ";";
}
$items_sold = rtrim($items_sold, ";");
$items_sold .= " ]";

$cardname = $_POST['cardname'];
$cardnumber = $_POST['cardnumber'];
$expmonth = $_POST['expmonth'];
$expyear = $_POST['expyear'];
$cvv =  $_POST['cvv'];

$time = date("H:m:s");

$payment_profile = $_POST['payment_profile'];
if(empty($payment_profile)){
$payment_profile = "";
$cardholder_name = cardname;
$card_number = $cardnumber;
$valid_thru = $expmonth . '/' . $expyear;
$securitycode = $cvv;
}else {
$cardholder_name = '';
$card_number = '';
$valid_thru = '';
$securitycode = 0;

}
//Do transaction using commission script, etc.

$command = escapeshellcmd('python CommissionScript.py');
$output = shell_exec($command);
echo $output;




//Also need to post transaction to commission table





//Simulate a transaction failure with 20% chance
$success = rand(0, 100);
if ($success < 20) {
    echo "Card declined, returning to checkout...";
    header('refresh:3; url=../checkout.php');
} else {
    //Need to post transaction to commission table
    $index = $_POST["index"];
    $motd = $_POST["motd"];
$servername = "localhost";
$dbname = "restaurantsystem";
$dbusername = "restaurant";
$dbpassword = "compsci776";

    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    $outgoing_amt = $revenue * 0.2;
    $sql = mysqli_query($conn, "UPDATE commission SET `outgoing_amount`=$outgoing_amt, `incoming_amount` = `incoming_amount` + $revenue WHERE commission.index = 1");

    if ($sql) {
        //echo "Commission updated successfully.";
        $conn->close();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    $command = "python3 ../CommissionScript.py";
    $output = shell_exec($command." 2>&1; echo $?");
    //echo $output;


    //Post successful transaction

$etaupdated = false;
$sql = "SELECT * FROM `transactions` ORDER BY `index` DESC";
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $MenuMap[$row["index"]] = $row["name"];
            if (!$etaupdated) {
                if ($row["completed"] == 0) {
                    $eta += $row["eta"];
                    $etaupdated = true;
                }
            }
        }
    }
    $conn->close();


$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
$sql = mysqli_query($conn, "INSERT INTO transactions (fullname, email, phone, revenue, items_sold, address, eta, time) VALUES ('$fullname', '$email', '$phone', '$revenue', '$items_sold', '$address', '$eta', '$time')");

if ($sql) {
    $conn->close();
    $_SESSION['cart'] = array();    
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    include 'pulltransactionindex.php';
    $transindex = pullTransactionIndex($time, $email);

    //inserting values into db
    $miql = "INSERT INTO payments (payment_profile,card_holder_name,card_number,valid_thru,security_code, transaction_index) VALUES ('$payment_profile','$cardholder_name','$card_number','$valid_thru','$securitycode','$transindex')";
    $newconn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    $result = mysqli_query($newconn , $miql);
    if ($result) {
        //echo "Payment with card details inserted successfully.";
        $newconn->close();
    }

    echo "Transaction successful. Redirecting..";
    $outurl = '../receipt.php?transactionid='.urlencode($transindex).'&email='.urlencode($email);
    header('refresh:1; url='.$outurl);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
?>