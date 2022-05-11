<!DOCTYPE html>
<html language="en">
<head>
	<title>Restaurant Ordering System - Cart</title>
	<link rel="shortcut icon" href="images/favicon.png" type="image/icon">
    <link rel="icon" href="images/favicon.png" type="image/icon">
    <link rel="stylesheet" href="style.css?v=<?php echo rand(); /* Prevent caching */?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Restaurant Ordering System">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="scripts/source.js"></script>
</head>
<style>
    th {
        text-align: center !important;
    }

    td {
        vertical-align: middle !important;
    }
</style>
<body>
	<?php include 'controllers/putheader.php'; putHeader(); ?>

    <?php
        function clearCart() { $_SESSION['cart'] = array(); }
        function removeItem($index) { \array_splice($_SESSION['cart'], $index, 1); }
        if (isset($_GET['clearcart'])) {
            clearCart();
            header("Location: cart.php");
        }
        if (isset($_GET['removeitem'])) {
            removeItem($_GET['removeitem']);
            header("Location: cart.php");
        }
    ?>


    <div class="cardholder" style="min-height: 50%;">
        <div class="card">
			<h1>Your Order</h1>
            <div class="overflowtable" style="overflow-y: auto; height: 100%;">
                <table style="width: 100%;">
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Item</th>
                        <th scope="col">Requests</th>
                        <th scope="col">Price (Each)</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Edit</th>
                    </tr>
                <?php include 'controllers/pullcart.php'; pullCart(); ?>
                </table>
            </div>  
            <br/>
            <button onclick="window.location.href = 'cart.php?clearcart=true'; /*alert('Cleared cart');*/">Clear Cart</button>
            <button onclick="window.location.href = 'checkout.php'; " <?php if (count($_SESSION['cart']) == 0) echo "disabled" ?>>Continue to checkout</button>
		</div>
	</div>    
    <?php include 'controllers/putfooter.php'; putFooter(); ?>
</body>
<script src="scripts/cart.js"></script>
</html>