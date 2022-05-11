<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>User Login</title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="css/login.css">

	  <style type="text/css">
	  #loginbutton{
		  color:#fff;
		  background-color: blue;
	  }
	  </style>
  
</head>

<body>
<?php
include("controllers/connect.php"); //INCLUDE CONNECTION
error_reporting(0); // hide undefine index errors
if (session_status() === PHP_SESSION_NONE) { session_start(); } // temp sessions
if(isset($_POST['submit']))   // if button is submit
{
	$username = $_POST['username'];  //fetch records from login form
	$password = $_POST['password'];
	
	if(!empty($_POST["submit"]))   // if records were not empty
     {
		$loginquery ="SELECT username, role FROM accounts WHERE username='$username' && password='".md5($password)."'"; //selecting matching records
		$result=mysqli_query($db, $loginquery); //executing
		$row=mysqli_fetch_assoc($result);
		if($result->num_rows > 0)  // if matching records in the array & if everything is right
			{
					$_SESSION["user_id"] = $row['username']; // put user id into temp session
					$_SESSION["role"] = $row["role"];
					$success = "Login successful!";
					header("refresh:1;url=index.php"); // redirect to home.php page
			}
		else
			{
					$message = "Invalid username or password!"; // throw error
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
    <h2 style="color: blue">User Login</h2>
	  <span style="color:red;"><?php echo $message; ?></span> 
   <span style="color:green;"><?php echo $success; ?></span>
    <form action="" method="post">
      <input type="text" placeholder="Username"  name="username"/>
      <input type="password" placeholder="Password" name="password"/>
      <input type="submit" id="loginbutton" name="submit" value="Login" title="Login" class="btn btn-success"/>
    </form>
	<div><a href="reset_link.php" style="color:blue;"> Reset your password</a></div>
  </div>
  
  <div class="cta">Not registered?<a href="registration.php" style="color:blue;"> Create an account</a></div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body>

</html>
