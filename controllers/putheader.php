<?php
function putHeader() {
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    echo '
        <div id="head">
            <div id="menu">
                <div style="padding: 20px;text-align: center;">
                    <div id="navbar">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="menu.php">Menu</a></li>

                            <!-- Make icon instead? Use <i class="fa fa-shopping-cart" style="font-size:20px"> -->
                            <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->';
    if (count($_SESSION['cart']) == 0 ) {
        echo                '<li><a href="cart.php">Cart</a></li>';
    } else {
        $cartsize = 0;
        foreach ($_SESSION['cart'] as $cartitem) {
            $all_item = explode(",",$cartitem);
            $all_item[0] = ltrim($all_item[0], "{");  // Index
            $all_item[1] = ltrim($all_item[1], "[");  // Request text
            $all_item[1] = rtrim($all_item[1], "]");  // "       "
            $all_item[2] = rtrim($all_item[2], "}");  // Quantity
            $cartsize += $all_item[2];
        }
        echo                '<li><a href="cart.php">Cart</i> (' . $cartsize . ')</a></li>';
    }

    //Display only if logged in as admin role
    if (!empty($_SESSION["role"]) && strcmp($_SESSION["role"], "admin") == 0) {
        echo                '<li><a href="admin.php">Admin</a></li>';
    }
    if (empty($_SESSION["user_id"])) {
        echo                '<li><a href="login.php">Log In</a></li>';
    } else {
        echo                '<li><a href="add_payment_profile.php">Add Payment Profile</a></li>';
        echo                '<li><a href="logout.php">Log Out</a></li>';
    }
    echo '
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <br/><br/>
		';
}
?>
