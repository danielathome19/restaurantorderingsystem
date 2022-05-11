<!DOCTYPE html>
<html language="en">
<head>
	<title>Restaurant Ordering System - Menu</title>
	<link rel="shortcut icon" href="images/favicon.png" type="image/icon">
    <link rel="icon" href="images/favicon.png" type="image/icon">
    <link rel="stylesheet" href="style.css?v=<?php echo rand(); /* Prevent caching */?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Restaurant Ordering System">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="scripts/source.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<style>

</style>
<body>
	<?php include 'controllers/putheader.php'; putHeader(); ?>

    
    <div class="cardholder" style="height: 100%; display: table;">
        <div class="card">
            <h2><strong>Menu Items</strong></h2>
            <div class="overflowtable" style="overflow-y: auto; height: 100%;">
                <table style="width: 100%; vertical-align: top;">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: center;">Item</th>
                            <th scope="col" style="text-align: center;">Price</th>
                            <th scope="col" style="text-align: center;">Image</th>
                            <th scope="col" style="text-align: center;">Description</th>
                            <th scope="col" style="text-align: center;">Ingredients</th>
                            <th scope="col" style="text-align: center;">Quantity</th>
                            <th scope="col" style="text-align: center;">Special Requests</th>
                            <th scope="col" style="text-align: center;">Add to Cart</th>

                            <?php
                            // If account_type == admin
                            if (!empty($_SESSION["role"]) && strcmp($_SESSION["role"], "admin") == 0) {
                            echo'
                            <th scope="col" style="text-align: center;">Preparation Time</th>
                            <th scope="col" style="text-align: center;">Edit Item</th>
                            ';
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include 'controllers/pullmenu.php'; pullMenu(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php        
    /*
    	[/] OPTIONAL - EatStreet-like item hierarchy? Sandwiches, drinks, desserts, etc. -- Would have to add "category" column; too much work. Owner can edit items to be in order
    	[WIP] Allow users to add items to cart – OPTIONAL modify ingredients of item (no X, extra Y, etc.)
    	[X] Admin Content Management System (CMS) – edit items (pencil click to edit item name, description, price, ingredients, update preparation time, etc.)
        •	[/] OPTIONAL – display “slash price” alongside normal price for items on sale (ability to add coupons/deals) -- Would need another SQL column; too much work
    */
    ?> 

    <script>
        function addToCart(index) {
            iquantity = document.getElementById("quantity" + index);
            quantity = iquantity.value;

            if (quantity == null || quantity == "" || quantity <= 0 || quantity.match(/[a-zA-Z]/g || quantity.toString().includes(".") || isNaN(quantity) || quantity.toString().indexOf('.') != -1)) {
                alert("You must choose a valid quantity first!");
            } else if (quantity.match(/[0-9]/g) && quantity.toString().indexOf('.') == -1) {
                irequests = document.getElementById("requests" + index);
                requests = irequests.value;
		        //var result = "<php addItemToCart(index, quantity, requests); ?>";
		        //alert(result);
                //alert(<php echo $_SESSION["cart"]; ?>);

                $.ajax({
                    url: 'menu.php',
                    type: 'post',
                    data: { "addtocart": "1", "index": index, "quantity": quantity, "requests": requests},
                    success: function(response) { 
                        //alert("Added item with index " + index + " to cart with quantity " + quantity + " and requests: " + requests + "!"); 
                        alert("Added to cart!");
                    }
                });

                
            } else {
                alert("You must choose a valid quantity first!");
            }
            
        }
        
        <?php
            // If account_type == admin
            if (!empty($_SESSION["role"]) && strcmp($_SESSION["role"], "admin") == 0) {
                include 'controllers/putmenuadmin.php';
                putMenuAdmin();
            }

            if (isset($_POST['addtocart'])) addItemToCart($_POST['index'], $_POST['quantity'], $_POST['requests']);
	        function addItemToCart($index, $quantity, $requests) {
		        //{ Item index, [Requests text], qty}
                //session_start();
                //$_SESSION["cart"] = array();
                if (empty($_SESSION["cart"])) $_SESSION["cart"] = array();
                array_push($_SESSION["cart"], "{".$index.",[".str_replace(";", "-", str_replace(",", "-", $requests))."],".$quantity."}");
                //echo $_SESSION["cart"][0];
                return 0;
	        }
        ?>
    </script>
    

	
    <?php include 'controllers/putfooter.php'; putFooter(); ?>
</body>
</html>
