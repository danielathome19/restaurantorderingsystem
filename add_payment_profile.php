<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>New Payment Profile</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="css/login.css">

    <style type="text/css">
        #savebutton{
            color:#fff;
            background-color: blue;
        }

        .form-module {
            margin-top: -60px;
        }
    </style>

</head>

<body>
<?php
include("controllers/connect.php"); //INCLUDE CONNECTION
error_reporting(0); // hide undefine index errors
session_start(); // temp sessions

if(empty($_SESSION["user_id"]) || $_SESSION["user_id"] == null || $_SESSION["user_id"] == "") {
    //return to login page if user session is empty (user is not logged in)
    header("Location: login.php");
}
if(isset($_POST['submit']))   // if button is submit
{
    if (empty($_POST['profile_name']) || //fetching and find if its empty
        empty($_POST['cardholdername']) ||
        empty($_POST['cardnumber']) ||
        empty($_POST['validthru']) ||
        empty($_POST['securitycode'])) {
        $message = "Please provide complete card details!";
    } else {
        //checking payment profile name if already present
        $check_profile_name = mysqli_query($db, "SELECT COUNT(1) FROM payment_profile where username = '" . $_SESSION["user_id"] . "' and profile_name= '" . $_POST['profile_name']."' ");
        if (strlen($_POST['securitycode']) < 3)  //cal password length
        {
            $message = "Security Code length must be exactly 3!";
        } elseif (mysqli_fetch_assoc($check_profile_name)["COUNT(1)"] > 0)  //check username
        {
            $message = 'Payment profile name already exists!';
        } else {
            //code to verify the user card information

            //inserting values into db
            $mql = "INSERT INTO payment_profile(username,profile_name,cardholder_name,card_number,valid_thru,security_code) VALUES('" . $_SESSION["user_id"] . "','" . $_POST['profile_name'] . "','" . $_POST['cardholdername'] . "','" . $_POST['cardnumber'] . "','" . $_POST['validthru'] . "','" . $_POST['securitycode'] . "')";
            $result = mysqli_query($db, $mql);
            $success = "Payment profile added successfully!";
        }
    }
}
?>
<div class="pen-title">
</div>
<!-- Form Module-->
<div class="form-module">
    <div class="toggle">

    </div>
    <div class="form">
        <h2 style="color: blue">Payment Profile SetUp</h2>
        <span style="color:red;"><?php echo $message; ?></span>
        <span style="color:green;"><?php echo $success; ?></span>
        <form action="" method="post">
            <input type="text" placeholder="Payment Profile Name"  name="profile_name"/>
            <input type="text" placeholder="Card Holder Name"  name="cardholdername"/>
            <input type="text" placeholder="Card Number" name="cardnumber"/>
            <input type="text" placeholder="Valid Thru"  name="validthru"/>
            <input type="number" placeholder="Security Code" name="securitycode"/>
            <input type="submit" id="savebutton" name="submit" value="Save" title="Add Payment Profile" class="btn btn-success"/>
        </form>
    </div>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body>
</html>