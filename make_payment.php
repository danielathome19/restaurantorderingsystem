<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>Make Payment</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="css/login.css">

    <style type="text/css">
        #makepaymentbutton{
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
$payment_profiles = array();
//getting all available payment profiles for current logged in user or empty for guest user
$get_user_payment_profiles = mysqli_query($db, "SELECT profile_name, card_number FROM payment_profile where username = '" . $_SESSION["user_id"]."' ");
if($get_user_payment_profiles)
{
    $payment_profiles = mysqli_fetch_all($get_user_payment_profiles, MYSQLI_ASSOC);
}
if(isset($_POST['submit']))   // if button is submit
{
    if(!empty($_POST['payment_profile'])){
        //getting card details for selected profile
        $get_card_details = mysqli_query($db, "SELECT cardholder_name, card_number, valid_thru, security_code FROM payment_profile where profile_name = '" .$_POST['payment_profile']."' ");
        if($get_card_details)
        {
            $card_details = mysqli_fetch_assoc($get_card_details);
        }
        $cardholder_name = $card_details["cardholder_name"];
        $card_number = $card_details["card_number"];
        $valid_thru = $card_details["valid_thru"];
        $securitycode = $card_details["security_code"];
    }else {
        if ( //fetching and find if its empty
            empty($_POST['cardholdername']) ||
            empty($_POST['cardnumber']) ||
            empty($_POST['validthru']) ||
            empty($_POST['securitycode'])) {
            $message = "Please select payment profile or provide complete card details!";
        }
        else { //if no payment profile selected and card details field are not empty
            $cardholder_name = $_POST["cardholdername"];
            $card_number = $_POST["cardnumber"];
            $valid_thru = $_POST["validthru"];
            $securitycode = $_POST["securitycode"];
            //code to verify the user card information
        }
    }

    //code to run commission script
    /*$command = escapeshellcmd('python CommissionScript.py');
    $output = shell_exec($command);*/

    //making payment
    $success = "Payment successful!";
}
?>

<script type="text/javascript">
    function onPaymentProfileChange(event){
        let profile = event.value
        document.getElementById("cardholdername").removeAttribute('disabled');
        document.getElementById("cardnumber").removeAttribute('disabled');
        document.getElementById("validthru").removeAttribute('disabled');
        document.getElementById("securitycode").removeAttribute('disabled');
        if(profile !== ""){
            document.getElementById("cardholdername").setAttribute('disabled', '');
            document.getElementById("cardnumber").setAttribute('disabled', '');
            document.getElementById("validthru").setAttribute('disabled', '');
            document.getElementById("securitycode").setAttribute('disabled', '');
        }
    }
</script>

<div class="pen-title">
</div>
<!-- Form Module-->
<div class="form-module">
    <div class="toggle">

    </div>
    <div class="form">
        <h2 style="color: blue">Make Payment</h2>
        <span style="color:red;"><?php echo $message; ?></span>
        <span style="color:green;"><?php echo $success; ?></span>
        <form action="" method="post">
            <div style="font-size: medium">Select available payment profile:</div>
            <select style="margin: 10px; height: 30px; width: 250px;" name="payment_profile" onchange="onPaymentProfileChange(this)">
                <option value="" selected>Select payment profile</option>
                <?php
                // Iterating through the product array
                for ($i=0; $i < count($payment_profiles); $i++) {
                    $profile =  $payment_profiles[$i]["profile_name"];
                    $card_number =  $payment_profiles[$i]["card_number"];
                    echo "<option value='$profile'>$profile-$card_number</option>";
                }
                ?>
            </select>
            <hr/>
            <p style="font-size: medium; margin: 12px;">Or enter card details manually:</p>
            <input type="text" placeholder="Card Holder Name" id="cardholdername" name="cardholdername"/>
            <input type="text" placeholder="Card Number" id="cardnumber" name="cardnumber"/>
            <input type="text" placeholder="Valid Thru" id="validthru" name="validthru"/>
            <input type="number" placeholder="Security Code" id="securitycode" name="securitycode"/>
            <input type="submit" id="makepaymentbutton" name="submit" value="Pay" title="Make payment" class="btn btn-success"/>
        </form>
    </div>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body>
</html>