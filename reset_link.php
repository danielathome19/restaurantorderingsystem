<html>
<head>
    <title>Password Reset</title>
    <link rel="stylesheet" href="css/login.css">

    <style type="text/css">
        #submit{
            color:#fff;
            background-color: green;
        }
    </style>
</head>
<body>
<?php
error_reporting(0);
if (isset($_POST['submit_email']) && $_POST['email']) {
    include("controllers/connect.php"); //INCLUDE CONNECTION
    $to = $_POST['email'];
    if(!filter_var($to, FILTER_VALIDATE_EMAIL)) // Validate email address
    {
        $info = "Invalid email address!";
    }
    else {
        $checkemailsql = "SELECT COUNT(1) from accounts WHERE email='$to'";
        $result = mysqli_query($db, $checkemailsql);
        if (mysqli_fetch_assoc($result)["COUNT(1)"] > 0) {
            $subject = "Reset password link - Online Restaurant";
            //$msg = "This is link to reset your password";
            $sender = "onlinerestaurant@gmail.com";

            // To send HTML mail, the Content-type header must be set
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // Create email headers
            $headers .= 'From: ' . $sender . "\r\n" .
                'Reply-To: ' . $sender . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Compose a simple HTML email message
            $message = '<html><body>';
            $message .= '<h2> Below is the password reset link for online restaurant ordering.<br/></h2>';
            $message .= "<a href='restaurantorderingsystem.tk/reset_password.php?email=" . $to . "'>Click here to reset password</a>";
            $message .= '</body></html>';
            // send email
            mail($to, $subject, $message, $headers);
            $success = 'Password reset link sent!';
            header("refresh:1;url=index.php");
        } else {
            $info = "User with given email address does not exist!!";
        }
    } ?>

<?php }
?>

<!-- Form Module-->
<div class="form-module">
    <div class="toggle">

    </div>
    <div class="form">
        <h2 style="color: blue">Password Reset</h2>
        <span style="color:red;"><?php echo $info; ?></span>
        <span style="color:blue;"><?php echo $success; ?></span>
        <form method="post">
            <p>Enter registered email address to send password reset link.</p>
            <input type="text" name="email">
            <input type="submit" id="submit" value="Send Reset Link" name="submit_email">
        </form>
    </div>
</div>
</body>
</html>
