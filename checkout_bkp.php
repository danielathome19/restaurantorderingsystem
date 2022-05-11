<!DOCTYPE html>
<html language="en">
<head>
	<title>Restaurant Ordering System - Register</title>
	<link rel="shortcut icon" href="images/favicon.png" type="image/icon">
    <link rel="icon" href="images/favicon.png" type="image/icon">
    <link rel="stylesheet" href="style.css?v=<?php echo rand(); /* Prevent caching */?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Restaurant Ordering System">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="scripts/source.js"></script>
</head>
<style>
.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}


input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}


input[type=email] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

input[type=tel] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

input[type=number] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #04AA6D;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>
<script>
    function resetRefresh() {
        document.getElementById('selector').options[0].selected = 'pickup';
        document.getElementById("sameadr").disabled = true;
        document.getElementById("sameadr").checked = false;
        document.getElementById("deliveryform").style.display="none";
        document.getElementById("deliveryfee").value = 0;
        document.getElementById("subtotal").innerHTML = parseFloat(document.getElementById("actualsubtotal").value).toFixed(2);
    }
</script>
<body onLoad="resetRefresh();">
    
	<?php include 'controllers/putheader.php'; putHeader(); ?>
    <?php if ($_SESSION['carttotal'] == 0 || $_SESSION['cartpreptime'] == 0 || !isset($_SESSION['carttotal']) || !isset($_SESSION['cartpreptime'])) { header("Location: cart.php"); } ?>
    

	<div class="cardholder" style="min-height: 50%;">
        <div class="card">
            <!-- We'll need some sort of form for first/last name, email, and phone if they aren't logged in -->
            <!-- Prompt for delivery or carryout -->
            <!-- Enter card info or used save card, and/or save card info after entering -->
            <!-- Calculate subtotal and add tax (use a variable but preset as default to 0.05) -->
            <!-- Verify card using Luhn algorithm, test transaction success using any of these cards: https://screenthumb.com/credit-card-numbers-for-testing-ecommerce-checkout/ -->
            
            <!-- if logged in (if $_SESSION['username'] is not empty), pull from accounts table, else post this using php-->
            <?php
            $firstname = "";
            $lastname = "";
            $fullname = "";
            $email = "";
            $phone = "";
            $address = "";
            $addrparts = array();
            $fulladdryn = false;

            if (isset($_SESSION['user_id'])) {
                include 'controllers/pullaccountdetails.php';
                $accountdetails = pullAccountDetails($_SESSION['user_id']);
                $firstname = $accountdetails[0];
                $lastname = $accountdetails[1];
                $email = $accountdetails[4];
                $phone = $accountdetails[3];
                $fullname = $firstname . " " . $lastname;
                $address = $accountdetails[6];
                $addrparts = explode(",", $address);
                if (count($addrparts) >= 4) $fulladdryn = true;
            } //else echo "not logged in";
            ?>

            <div class="col-75" style="margin: 15px;">
                <div class="container">
                <form action="controllers/pushtransaction.php" method="POST" id="checkoutform">

                    <div class="row">
                        <div class="col-50">
                            <h3>Billing Address</h3>
                            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                            <input type="text" id="fullname" name="fullname" placeholder="John M. Doe" <?php if (strlen($fullname) > 0) echo 'value="'.$fullname.'"'; ?> required>
                            <label for="email"><i class="fa fa-envelope"></i> Email</label>
                            <input type="email" id="email" name="email" placeholder="john@example.com" <?php if (strlen($email) > 0) echo 'value="'.$email.'"'; ?> required>
                            
                            <label for="phone"><i class="fa fa-phone"></i> Phone</label>
                            <input type="tel" id="phone" name="phone" placeholder="(123) 456 - 7890" <?php if (strlen($phone) > 0) echo 'value="'.$phone.'"'; ?> required>

                            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                            <input type="text" id="adr" name="address" placeholder="542 W. 15th Street" <?php if ($fulladdryn) echo 'value="'.$addrparts[0].'"'; ?> required>
                            <label for="city"><i class="fa fa-institution"></i> City</label>
                            <input type="text" id="city" name="city" placeholder="New York" <?php if ($fulladdryn) echo 'value="'.$addrparts[1].'"'; ?> required>

                            <div class="row">
                            <div class="col-50">
                                <label for="state">State</label>
                                <input type="text" id="state" name="state" placeholder="NY" <?php if ($fulladdryn) echo 'value="'.$addrparts[2].'"'; ?> required>
                            </div>
                            <div class="col-50">
                                <label for="zip">Zip</label>
                                <input type="text" id="zip" name="zip" placeholder="10001" <?php if ($fulladdryn) echo 'value="'.$addrparts[3].'"'; ?> required>
                            </div>
                        </div>
                    </div>

                    <div class="col-50">
                        <h3>Payment</h3>
                        <label for="fname">Accepted Cards</label>
                        <div class="icon-container">
                            <i class="fa fa-cc-visa" style="color:navy;"></i>
                            <i class="fa fa-cc-amex" style="color:blue;"></i>
                            <i class="fa fa-cc-mastercard" style="color:red;"></i>
                            <i class="fa fa-cc-discover" style="color:orange;"></i>
                        </div>
                        <label for="cardname">Name on Card</label>
                        <input type="text" id="cardname" name="cardname" placeholder="John More Doe" required>
                        <label for="cardnumber">Credit card number</label><br/><span style="color:red;" id="carderr"></span>
                        <input type="text" id="cardnumber" name="cardnumber" placeholder="1111-2222-3333-4444" required>
                        <label for="expmonth">Exp Month</label>
                        <input type="number" id="expmonth" name="expmonth" min="1" max="12" placeholder="10" required>

                        <div class="row">
                            <div class="col-50">
                                <label for="expyear">Exp Year</label>
                                <input type="number" id="expyear" name="expyear" <?php echo 'placeholder="'.date("Y").'" min="'.date("Y").'"'; ?> max="9999" required>
                            </div>
                            <div class="col-50">
                                <label for="cvv">CVV</label>
                                <input type="number" id="cvv" name="cvv" placeholder="352" min="0" max="9999" required>
                            </div>
                            <?php 
                            if (!empty($_SESSION["role"]) && strcmp($_SESSION["role"], "admin") == 0) echo '<button type="button" class="btn" onclick="fillTestCard();">Fill test card</button>';
                            ?>
                        </div>
                    </div>


                    <!-- Add selection for cards saved to account if logged in -->

                    </div>
                    <select id="selector" name="selector" onChange="isDelivery()" form="checkoutform" required>
                        <option value="pickup" selected>Pickup</option>
                        <option value="delivery">Delivery ($3.00)</option>
                    </select>
                    <label>
                        <input type="checkbox" name="sameadr" id="sameadr" disabled> Delivery address same as billing
                    </label>

                    <!-- Validate month and year of card expiration -->

                    <!-- TODO: VERIFY DELIVERY ADDRESS WITHIN RANGE (maybe use a button), maybe add a disabled input that shows the estimated delivery time so it can be added to $_POST -->
                    <div class="row" id="deliveryform" style="display: none;">
                        <div class="col-50">
                            <br/><br/>
                            <h3>Delivery Address</h3>
                            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                            <input type="text" id="deladr" name="deladr" placeholder="542 W. 15th Street">
                            <label for="city"><i class="fa fa-institution"></i> City</label>
                            <input type="text" id="delcity" name="delcity" placeholder="New York">

                            <div class="row">
                            <div class="col-50">
                                <label for="state">State</label>
                                <input type="text" id="delstate" name="delstate" placeholder="NY">
                            </div>
                            <div class="col-50">
                                <label for="zip">Zip</label>
                                <input type="text" id="delzip" name="delzip" placeholder="10001">
                            </div>
                            
                            <br/><span style="color:red;" id="addresserr"></span>
                            <input type="hidden" id="deliverytime" name="deliverytime" value="0">
                            <button type="button" class="btn" onclick="verifyAddress();" id="verifyaddress">Verify Address</button>
                        </div>
                    </div>
                    </div>

                    

                    <br/>

                    <input type="hidden" id="deliveryfee" name="deliveryfee" value="0">

                    <?php
                    echo '
                    <br/>
                    <input type="hidden" id="actualsubtotal" name="actualsubtotal" value="'.(float)($_SESSION['carttotal']).'">
                    <h3><span style="font-weight: bolder;">Subtotal (after tax): $</span><span id="subtotal">'.number_format((float)($_SESSION['carttotal']), 2, '.', '').'</span></h3>
                    '
                    ?>

                    <input type="submit" value="Checkout" id="checkoutbtn" class="btn">
                </form>
                </div>
            </div>

            
		</div>
	</div>
    
    <?php

    /*
    	Allow user to update account details (address, billing address, phone, first/last names, etc.) (OPTIONAL)
    	Save credit/debit card to account or remove card (OPTIONAL)
    	Pay with [Toast, Cake, Square, PayPal etc.] – enter delivery/pickup details, perform transaction, push transaction to transaction and admin tables
        •	Use Luhn Algorithm to verify if card numbers are valid (in real-time) 
        •	If successful, add transaction to transaction table and sale price to commission table (incoming_amount) and run commission script (check if
            incoming_amount equals threshold, if so, set outgoing_amount = incoming_amount, reset incoming_amount, and subtract percentage of sale from 
            outgoing_amount to pay developer, pay the rest to restaurant – otherwise pay all to restaurant), send to Receipt page
            o	Show option to print, delivery/pickup ETA [using sum of preparation time of each item + distance travel time for delivery], pickup/delivery 
                information, add to user’s purchase history if logged in. Otherwise, return user to cart if the transaction is unsuccessful
    */

    ?>

	
    <?php include 'controllers/putfooter.php'; putFooter(); ?>
</body>
<script>
    function verifyAddress() {
        //Make sure address is real and is within 15 miles or something, also update delivery time
        


        document.getElementById("deliverytime").value = 0; //In minutes
        document.getElementById("checkoutbtn").disabled = false;
    }




    function isDelivery() {
        var x = document.getElementById("selector").value;
        var counter = 0;
        if (x == "delivery") {
            document.getElementById("sameadr").disabled = false;
            document.getElementById("deliveryform").style.display="block";
            document.getElementById("deliveryfee").value = 3;
            document.getElementById("deliverytime").value = 0;
            counter += parseFloat(document.getElementById("actualsubtotal").value) + 3;
            document.getElementById("subtotal").innerHTML = counter.toFixed(2);
            document.getElementById("checkoutbtn").disabled = true;
        } else { 
            document.getElementById("sameadr").disabled = true;
            document.getElementById("deliveryform").style.display="none";
            document.getElementById("deliveryfee").value = 0;
            document.getElementById("deliverytime").value = 0;
            document.getElementById("subtotal").innerHTML = parseFloat(document.getElementById("actualsubtotal").value).toFixed(2);
        }
    }
    
    const checkbox = document.getElementById('sameadr')

    checkbox.addEventListener('change', (event) => {
        if (event.currentTarget.checked) {
            document.getElementById("deladr").value = document.getElementById("adr").value;
            document.getElementById("delcity").value = document.getElementById("city").value;
            document.getElementById("delstate").value = document.getElementById("state").value;
            document.getElementById("delzip").value = document.getElementById("zip").value;
        } else {
            document.getElementById("deladr").value = "";
            document.getElementById("delcity").value = "";
            document.getElementById("delstate").value = "";
            document.getElementById("delzip").value = "";
        }
    })

    function fillTestCard() {
        document.getElementById("cardname").value = document.getElementById("fullname").value;
        document.getElementById("cardnumber").value = "6011 0000 0000 0012";
        document.getElementById("expmonth").value = 12;
        document.getElementById("expyear").value = 2023;
        document.getElementById("cvv").value = 999;
        document.getElementById("checkoutbtn").disabled = false;
        document.getElementById("carderr").style.display="none";
    }
    
    function isBlank(str) {
        return (!str || str.length === 0);
    }
    
    document.getElementById("cardnumber").addEventListener("input", function (e) {
        var cardstr = this.value;
        cardstr = cardstr.replace(/-|\s/g,"").trim();
        if (isBlank(cardstr)) {
            document.getElementById("checkoutbtn").disabled = true;
            document.getElementById("carderr").innerHTML = "Card number cannot be blank";
        } else {
            var success = luhn(cardstr);
            if (success) {
                document.getElementById("checkoutbtn").disabled = false;
                document.getElementById("carderr").innerHTML = "";
            } else {
                document.getElementById("carderr").innerHTML = "Invalid card number";
                document.getElementById("checkoutbtn").disabled = true;
            }
        }
    });

    var luhn = function(a,b,c,d,e) {
        for(d = +a[b = a.length-1], e=0; b--;)
            c = +a[b], d += ++e % 2 ? 2 * c % 10 + (c > 4) : c;
        return !(d%10)
    };

    /*
    //McGraw coordinates
    var restaurantlat = 42.836514;
    var restaurantlon = -88.742790;
    
    //START OF LOCATION
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else //x.innerHTML = "Geolocation is not supported by this browser.";
    }

    function showPosition(position) {
        var curloclat = position.coords.latitude;
        var curloclon =  position.coords.longitude;
        var dist = (calcCrow(restaurantlat,restaurantlon,curloclat,curloclon));
        return dist <= 15;
    }
        
    //START OF DISTANCE CALC
    function calcCrow(lat1, lon1, lat2, lon2) {
        var R = 6371; // km
        var dLat = toRad(lat2-lat1);
        var dLon = toRad(lon2-lon1);
        var lat1 = toRad(lat1);
        var lat2 = toRad(lat2);

        var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        var d = R * c;
        return (d / 1.609344);
    }
        
    function toRad(Value) {
        return Value * Math.PI / 180;
    }
    */
</script>
</html>