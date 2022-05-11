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
if ($_GET['email']) {
    $email = $_GET['email'];
}
?>

<!-- Form Module-->
<div class="form-module">
    <div class="toggle">

    </div>
    <div class="form">
        <h2 style="color: blue">Enter New Password</h2>
        <form method="post">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="password" name='password'>
            <input type="submit" id="submit" value="Update Password" name="submit_password">
        </form>
    </div>
</div>
</body>
</html>

<?php
if (isset($_POST['submit_password']) && $_POST['email']) {
    include("controllers/connect.php"); //INCLUDE CONNECTION
    $pass = $_POST['password'];
    $email = $_POST['email'];
    $resetpwdsql = "UPDATE accounts set password=md5('$pass') WHERE email='$email'";
    $result = mysqli_query($db, $resetpwdsql);
    header("refresh:1;url=login.php");
}
?>