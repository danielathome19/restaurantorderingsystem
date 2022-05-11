<!DOCTYPE html>
<html language="en">
<head>
	<title>Restaurant Ordering System - Register</title>
	<link rel="shortcut icon" href="images/favicon.png" type="image/icon">
    <link rel="icon" href="images/favicon.png" type="image/icon">
    <link rel="stylesheet" href="style.css?v=<?php echo rand(); /* Prevent caching */?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Restaurant Ordering System">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="60">
    <script src="scripts/source.js"></script>
</head>
<style>
td {
    text-align: center !important;
}

pre {
    text-align: left !important;
}
</style>
<body>
	<?php include 'controllers/putheader.php'; putHeader(); ?>

    <!-- Remove "height: 100% after adding details -->
	<div class="cardholder" style="min-height: 50%;">
        <div class="card">

            <h2><strong>Receipt</strong></h2>
            <div class="overflowtable" style="overflow-y: auto; max-height: 500px;">
                <table style="width: 100%; vertical-align: top;">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: center;">ID</th>
                            <th scope="col" style="text-align: center;">Cost</th>
                            <th scope="col" style="text-align: center;">Items Sold</th>
                            <th scope="col" style="text-align: center;">Name</th>
                            <th scope="col" style="text-align: center;">Delivery Address</th>
                            <th scope="col" style="text-align: center;">ETA</th>
                            <th scope="col" style="text-align: center;">Date</th>
                            <th scope="col" style="text-align: center;">Time</th>
                            <th scope="col" style="text-align: center;">Completed?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            include 'controllers/pullsingletransaction.php';
                            if (isset($_GET['transactionid']) && isset($_GET['email'])) {
                                pullSingleTransaction($_GET['transactionid'], $_GET['email']);
                            } else {
                                echo "Transaction ID: " . $_GET['transactionid'] . "<br/>Email: " . $_GET['email'];
                            }
                        ?>
                    </tbody>
                </table>
                <!-- Display map showing delivery points -->






                
            </div>
		</div>
	</div>
    
    <?php

    /*
    o	Show option to print, delivery/pickup ETA [using sum of preparation time of each item + distance travel time for delivery], pickup/delivery 
        information, add to user’s purchase history if logged in. Otherwise, return user to cart if the transaction is unsuccessful
    */

    ?>

	
    <?php include 'controllers/putfooter.php'; putFooter(); ?>
</body>
</html>