<?php
function pullCart() {
    $servername = "localhost";
    $dbname = "restaurantsystem";
    $dbusername = "restaurant";
    $dbpassword = "compsci776";
    //session_start();

    $MenuMap = array();
    $ImageMap = array();
    $PriceMap = array();
    $TimeMap = array();

    $sql = "SELECT * FROM `items` ORDER BY `index` ASC";
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $MenuMap[$row["index"]] = $row["name"];
            $ImageMap[$row["index"]] = $row["image"];
            $PriceMap[$row["index"]] = $row["price"];
            $TimeMap[$row["index"]] = $row["preparation_time"];
        }
    }
    $conn->close();

    $carttotal = 0.00;
    $cartpreptime = 0;
    $index = 0;

    foreach ($_SESSION['cart'] as $cartitem) {
        $all_item = explode(",",$cartitem);
        $all_item[0] = ltrim($all_item[0], "{");  // Index
        $all_item[1] = ltrim($all_item[1], "[");  // Request text
        $all_item[1] = rtrim($all_item[1], "]");  // "       "
        $all_item[2] = rtrim($all_item[2], "}");  // Quantity

        echo "
        <tr style=\"text-align: center;\">
            <td><img style=\"width: 100px; height: 100px;\" src=\"".$ImageMap[$all_item[0]]."\"/></td>
            <td><p id=\"name".$index."\">".$MenuMap[$all_item[0]]."</p></td>
            <td><p id=\"requests".$index."\">".str_replace("- ", ", ", $all_item[1])."</p></td>
            <td><p>$".number_format((float)$PriceMap[$all_item[0]], 2, '.', '')."</p></td>
            <td><p id=\"quantity".$index."\">".$all_item[2]."</p></td>
            <td><p>$".number_format((float)($PriceMap[$all_item[0]]*$all_item[2]), 2, '.', '')."</p><td>
            <button id=\"edit".$index."\" class=\"cartbutton\" type=\"button\" onclick=editItem(".$index.")>Edit</button>
            <button id=\"remove".$index."\" class=\"cartbutton\" type=\"button\" onclick=removeItem(".$index.")>Delete</button>
            <p id=\"food_index".$index."\" style=\"display: none; visibility: hidden;\">".$all_item[0]."</p>
            </td>
        </tr>
        ";
        $carttotal += ($PriceMap[$all_item[0]] * $all_item[2]);
        $cartpreptime += $TimeMap[$all_item[0]] * $all_item[2];
        $index += 1;
    }

    $_SESSION['carttotal'] = $carttotal * 1.05; //Hard-coded tax rate for now
    $_SESSION['cartpreptime'] = $cartpreptime;

    echo "
    <tr style=\"text-align: center;\">
        <td colspan=\"5\" style=\"text-align: right; font-weight: bolder;\">Subtotal:</td>
        <td colspan=\"2\" style=\"font-weight: normal; text-decoration: underline;\">$".number_format($carttotal, 2, '.', '')."</td>
    </tr>
    ";
}
?>