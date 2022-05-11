<!DOCTYPE html>
<html language="en">
<head>
	<title>Restaurant Ordering System - Home</title>
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

</style>
<body>
	<?php include 'controllers/putheader.php'; putHeader(); ?>

	<!-- Remove "height: 50% after adding details -->
    <div class="cardholder">
        <div class="card">
			<img src="images/restaurant logo.png">
			<h1><strong>Welcome to Generic Restaurant!</strong></h1>
			<p>Thank you so much for dining at Generic Restaurant! We opened our doors in (year) and have enjoyed serving (community) since. Keep supporting local businesses!</p>
		</div>
	</div>


    <div class="cardholder">
        <div class="card" id='ownerm'>
            <h2><strong>Messages from the owner:</strong></h2>
			<?php include 'controllers/pullmotd.php'; pullMotd(); ?>
			
			<?php 
        		// If account_type == admin
				if (!empty($_SESSION["role"]) && strcmp($_SESSION["role"], "admin") == 0) {
					include 'controllers/puthomeadmin.php'; 
					putHomeAdmin(); 
				}
			?>
		</div>
	</div>

	<?php 

	/*
		Display restaurant info (type of products, photos, etc.), contact info (bottom of page), direct user to correct page, promos/deals, advertising
	*/
	
	?>
	

    <?php include 'controllers/putfooter.php'; putFooter(); ?>
</body>
</html>