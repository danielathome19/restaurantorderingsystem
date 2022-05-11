<?php
function pullSingleTransaction($transindex, $email) {
    $servername = "localhost";
    $dbname = "restaurantsystem";
    $dbusername = "restaurant";
    $dbpassword = "compsci776";

    $MenuMap = array();
    $PriceMap = array();
    $sql = "SELECT * FROM `items` ORDER BY `index` ASC";
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) { 
        while ($row = $result->fetch_assoc()) { 
            $MenuMap[$row["index"]] = $row["name"]; 
            $PriceMap[$row["index"]] = $row["price"]; 
        }
    }
    $conn->close();

    $sql = "SELECT * FROM `transactions` WHERE `index` = '" . $transindex . "'";
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $sold = "[\n";
            $items_sold = $row["items_sold"];
            $items_sold = rtrim($items_sold, " ]");
            $items_sold = ltrim($items_sold, "[ ");
            $all_item = explode(";",$items_sold);
            
            foreach ($all_item as $cartitem) {
                $cartitem = explode(",",$cartitem);
                $cartitem[0] = ltrim($cartitem[0], "{");  // Index
                $cartitem[1] = ltrim($cartitem[1], "[");  // Request text
                $cartitem[1] = rtrim($cartitem[1], "]");  // "       "
                $cartitem[2] = rtrim($cartitem[2], "}");  // Quantity
                
                $itemname = $MenuMap[$cartitem[0]];
                $itemprice = $PriceMap[$cartitem[0]];

                $sold .= "Item: " . $itemname . "\n";
                $sold .= "Quantity: " . $cartitem[2] . "\n";
                $sold .= "Price/per: " . $itemprice . "\n";
                $sold .= "Requests: \"" . str_replace("- ", ", ", $cartitem[1]) . "\"\n";
                $sold .= "------------------------\n";
            }

            $sold .= "]";

            if (strcmp($row["email"], $email) == 0 || $row["email"] == $email) {
                echo "
                <tr>
                    <td>".$row["index"]."</td>
                    <td>".'$'.number_format((float)$row["revenue"], 2, '.', '')."</td>
                    <td><pre>".$sold."</pre></td>
                    <td>".$row["fullname"]."</td>
                    <td>".$row["address"]."</td>
                    <td>".$row["eta"]." minutes</td>
                    <td>".$row["date"]."</td>
                    <td>".$row["time"]."</td>
                    <td>".($row["completed"] == 1 ? 'Yes' : 'No')."</td>
                </tr>";
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}

?>