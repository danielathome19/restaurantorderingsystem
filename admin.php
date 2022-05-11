<!DOCTYPE html>
<html language="en">
<head>
	<title>Restaurant Ordering System - Admin</title>
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
td {
    text-align: center !important;
}

pre {
    text-align: left !important;
}
</style>
<body>
	<?php include 'controllers/putheader.php'; putHeader(); ?>

    <?php
        if (isset($_GET['completeitem'])) {
            include 'controllers/updatetransactioncomplete.php';
            updateTransactionComplete($_GET['completeitem']);
        }
    ?>
    
    <div class="cardholder">
        <div class="card">
            <h2><strong>Transactions</strong></h2>
            <div class="overflowtable" style="overflow-y: auto; max-height: 500px;">
                <table style="width: 100%; vertical-align: top;">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: center;">ID</th>
                            <th scope="col" style="text-align: center;">Full Name</th>
                            <th scope="col" style="text-align: center;">Email</th>
                            <th scope="col" style="text-align: center;">Phone</th>
                            <th scope="col" style="text-align: center;">Revenue</th>
                            <th scope="col" style="text-align: center;">Items Sold</th>
                            <th scope="col" style="text-align: center;">Address</th>
                            <th scope="col" style="text-align: center;">ETA</th>
                            <th scope="col" style="text-align: center;">Date</th>
                            <th scope="col" style="text-align: center;">Time</th>
                            <th scope="col" style="text-align: center;">Completed?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include 'controllers/pulltransactions.php'; pullTransactions(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="cardholder">
        <div class="card">
            <h2><strong>Add Menu Item</strong></h2>
            <form action="controllers/pushitem.php" method="POST">
                <table style="width: 100%; vertical-align: top;">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: center;">Item Name</th>
                            <th scope="col" style="text-align: center;">Price ($)</th>
                            <th scope="col" style="text-align: center;">Image</th>
                            <th scope="col" style="text-align: center;">Description</th>
                            <th scope="col" style="text-align: center;">Ingredients (Separated by ",")</th>
                            <th scope="col" style="text-align: center;">Preparation Time (Minutes)</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <tr>
                            <td><input type="text" name="name" placeholder="Cheeseburger" required></td>
                            <td><input type="number" name="price" min="0" max="10000" step="any" placeholder="3.14" required></td>
                            <td>
                                <input type='file' id="image" required/><br/><br/>
                                <img id="img" src="" style="width: 100px; height: 100px;"/>
                                <textarea name="imageb64" id="base" class="humans" required></textarea>
                            </td>
                            <td><textarea name="description" rows="4" cols="50" maxlength=1024 placeholder="..." required></textarea></td>
                            <td><textarea name="ingredients" rows="4" cols="50" maxlength=1024 placeholder="red onion, pickle, tomato, BBQ sauce, ..." required></textarea></td>
                            <td><input type="number" name="preparation_time" min="0" max="10000" step="any" placeholder="5" required></td>
                        </tr>
                    </tbody>
                </table>
                <input type="submit" style="margin: 5px; padding: 5px;">
            </form>
        </div>
    </div>


    <div class="cardholder">
        <div class="card">
            <h2><strong>Modify User Roles</strong></h2>
            <div class="overflowtable" style="overflow-y: auto; max-height: 400px;">
                <table style="width: 100%; vertical-align: top;">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: center;">Role</th>
                            <th scope="col" style="text-align: center;">Full Name</th>
                            <th scope="col" style="text-align: center;">Edit Item</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include 'controllers/pullaccountroles.php'; pullAccountRoles(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="cardholder">
        <div class="card">
            <h2><strong>Client Software</strong></h2>
            <p>The owner client program can be downloaded <a href="clientprogram/restaurant/restaurantclient.jar">here</a>.</p>
        </div>
    </div>


    <?php

    /*
    	[X] (FOR ADMIN ROLE ONLY) View transaction history [X], profit [X], [X] modify user roles, [X] modify home page (display promos/deals, add advertisements, etc.)
    	[/] OPTIONAL - Add ability to view transactions within range or from specified date
    */

    ?>
	

    <script>
        function editRole(index) {
            irole = document.getElementById("role" + index);
            ieditbtn = document.getElementById("edit" + index);

            irole.style.display = "none";
            roletext = irole.innerHTML;
            roleinput = document.createElement("select");
            option1 = document.createElement("option");
            option2 = document.createElement("option");
            option1.value = "customer";
            option2.value = "admin";
            option1.text = "customer";
            option2.text = "admin";
            roleinput.add(option1);
            roleinput.add(option2);
            if (roletext.localeCompare("admin") == 0) roleinput.selectedIndex = 1;
            else roleinput.selectedIndex = 0;
            roleinput.setAttribute("name", "role" + index);
            roleinput.setAttribute("form", "form" + index);
            irole.parentNode.insertBefore(roleinput, irole);

            forminput = document.createElement("form");
            forminput.setAttribute("action", "controllers/updaterole.php");
            forminput.setAttribute("method", "POST");
            forminput.setAttribute("name", "form" + index);
            forminput.setAttribute("id", "form" + index);
            irole.parentNode.parentNode.insertBefore(forminput, irole.parentNode);
            indexinput = document.createElement("input");
            indexinput.style.display = "none";
            indexinput.type = "number";
            indexinput.setAttribute("name", "index");
            indexinput.setAttribute("form", "form" + index);
            indexinput.value = index;
            forminput.appendChild(indexinput);

            ieditbtn.style.display = "none";
            editinput = document.createElement("input");
            editinput.type = "submit";
            editinput.setAttribute("form", "form" + index);
            editinput.setAttribute("class", "cartbutton");
            editinput.value = "Save";
            ieditbtn.parentNode.insertBefore(editinput, ieditbtn);
            ieditbtn.remove();
            irole.remove();
        }

        function readImage(input) {
            if (input.files && input.files[0]) {
                var FR= new FileReader();
                FR.onload = function(e) {
                    $('#img').attr( "src", e.target.result );
                    $('#base').text( e.target.result );
                };       
                FR.readAsDataURL( input.files[0] );
            }
        }

        $("#image").change(function(){
            readImage( this );
        });
    </script>


    <?php include 'controllers/putfooter.php'; putFooter(); ?>
</body>
</html>