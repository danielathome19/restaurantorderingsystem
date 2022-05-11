<!DOCTYPE html>
<html lang="en">
<?php

session_start(); //temp session
error_reporting(0); // hide undefine index
include("controllers/connect.php"); // connection

if(isset($_POST['submit'] )) //if submit btn is pressed
{
     if(empty($_POST['firstname']) ||  //fetching and find if its empty
   	    empty($_POST['lastname'])|| 
         empty($_POST['email']) ||  
         empty($_POST['phone'])||
         empty($_POST['password'])||
         empty($_POST['cpassword']) ||
         empty($_POST['address']) ||
		   empty($_POST['username']))
		{
			$message = "All fields are required!";
		}
	else
	{

		//cheching username & email if already present
        $check_username=mysqli_query($db, "SELECT COUNT(1) FROM accounts where username = '".$_POST['username']."' ");
	$check_email = mysqli_query($db, "SELECT COUNT(1) FROM accounts where email = '".$_POST['email']."' ");
        if($_POST['password'] != $_POST['cpassword']){  //matching passwords
               $message = "Passwords do not match!";
        }
        elseif(strlen($_POST['password']) < 6)  //cal password length
        {
            $message = "Password length must be at least 6!";
        }
        elseif(strlen($_POST['phone']) < 10)  //cal phone length
        {
            $message = "Invalid phone number!";
        }

        elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // Validate email address
        {
               $message = "Invalid email address!";
        }
        elseif(mysqli_fetch_assoc($check_username)["COUNT(1)"] > 0)  //check username
         {
            $message = 'Username already exists!';
         }
        elseif(mysqli_fetch_assoc($check_email)["COUNT(1)"] > 0) //check email
         {
            $message = 'Email already exists!';
         }
	else{
       
	 //inserting values into db
	$mql = "INSERT INTO accounts(username,first_name,last_name,email,phone,password,address) VALUES('".$_POST['username']."','".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['email']."','".$_POST['phone']."','".md5($_POST['password'])."','".$_POST['address']."')";
	$result = mysqli_query($db, $mql);
    /*if($result){
        echo "success";
    }else {
        echo "Error: " . $mql . "<br>" . mysqli_error($db);
    }*/
		$success = "Account Created successfully! <p>You will be redirected in <span id='counter'>5</span> second(s).</p>
														<script type='text/javascript'>
														function countdown() {
															var i = document.getElementById('counter');
															if (parseInt(i.innerHTML)<=0) {
																location.href = 'index.php';
															}
															i.innerHTML = parseInt(i.innerHTML)-1;
														}
														setInterval(function(){ countdown(); },1000);
														</script>'";
		
		
		
		
		 header("refresh:5;url=index.php"); // redireted once inserted success
    }
	}

}


?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>User Registration</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet"> </head>
<body>
         <div class="page-wrapper">
            <div class="breadcrumb">
               <div class="container">
                  <ul>
                     <li><a href="#" class="active">
					  <span style="color:red;"><?php echo $message; ?></span>
					   <span style="color:green;">
								<?php echo $success; ?>
										</span>
					   
					</a></li>
                    
                  </ul>
               </div>
            </div>
            <section class="contact-page inner-page">
               <div class="container">
                  <div class="row">
                     <!-- REGISTER -->
                     <div class="col-md-8">
                        <div class="widget">
                           <div class="widget-body">
                              
							  <form action="" method="post">
                                 <div class="row">
								  <div class="form-group col-sm-12">
                                       <label for="exampleInputEmail1">Username</label>
                                       <input class="form-control" type="text" name="username" id="example-text-input" placeholder="Username" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="exampleInputEmail1">First Name</label>
                                       <input class="form-control" type="text" name="firstname" id="example-text-input" placeholder="First Name" required> 
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="exampleInputEmail1">Last Name</label>
                                       <input class="form-control" type="text" name="lastname" id="example-text-input-2" placeholder="Last Name" required> 
                                    </div>
                                     <div class="form-group col-sm-12">
                                         <label for="exampleTextarea">Address</label>
                                         <textarea class="form-control" id="exampleTextarea"  name="address" rows="3" placeholder="123 Main Street, Janesville, WI, 53545" required></textarea>
                                     </div>
                                    <div class="form-group col-sm-6">
                                       <label for="exampleInputEmail1">Email</label>
                                       <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="exampleInputEmail1">Phone</label>
                                       <input class="form-control" type="tel" name="phone" id="example-tel-input-3" placeholder="Phone" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="exampleInputPassword1">Password</label>
                                       <input type="password" class="form-control" name="password" minlength="6" id="exampleInputPassword1" placeholder="Password" required> 
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="exampleInputPassword1">Confirm password</label>
                                       <input type="password" class="form-control" name="cpassword" minlength="6" id="exampleInputPassword2" placeholder="Confirm Password" required>
                                    </div>
                                 </div>
                                
                                 <div class="row">
                                    <div class="col-sm-4">
                                       <p> <input type="submit" value="Register" name="submit" title="Register new user" class="btn btn-success"> </p>
                                    </div>
                                 </div>
                              </form>
                           
						   </div>
                           <!-- end: Widget -->
                        </div>
                        <!-- /REGISTER -->
                     </div>
                     <!-- WHY? -->
                     <div class="col-md-4">
                        <h4>New user registration is fast, easy, and free.</h4>
                        <p>All your personal detail are safe, we'll never share your details with anyone else.</p>
                        <hr>
                     </div>
                     <!-- /WHY? -->
                  </div>
               </div>
            </section>
         </div>
         <!-- end:page wrapper -->
      
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <!--<script src="js/foodpicky.min.js"></script>-->
</body>

</html>
