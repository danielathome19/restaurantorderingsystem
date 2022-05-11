<?php
function formatPhone($phone) {
    if (preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $phone, $matches)) {
        $result = $matches[1].'-'.$matches[2].'-'.$matches[3];
        return $result;
    } else return $phone;
}

function pullTransactions() {
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

    $profit = 0;

    $sql = "SELECT * FROM `transactions` ORDER BY `index` ASC";
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
            $index = $row["index"];
            echo "
                <tr>
                    <td>".$row["index"]."</td>
                    <td>".$row["fullname"]."</td>
                    <td>".$row["email"]."</td>
                    <td>".formatPhone('+'.strval($row["phone"]))."</td>
                    <td>".'$'.number_format((float)$row["revenue"], 2, '.', '')."</td>
                    <td><pre>".$sold."</pre></td>
                    <td>".$row["address"]."</td>
                    <td>".$row["eta"]." mins</td>
                    <td>".$row["date"]."</td>
                    <td>".$row["time"]."</td>
                    <td><p>".($row["completed"] == 1 ? 'Yes' : 'No')."</p>
                        ".($row["completed"] == 0 ? "<button id=\"complete".$index."\" class=\"cartbutton\" type=\"button\" onclick=\"window.location.href = 'admin.php?completeitem=".$index."'\" style=\"width: 70px;\">Mark Complete</button>" : "")."
                    </td>
                </tr>";
            $profit += $row["revenue"];
        }
    }
    echo "<p>Total Revenue: $".number_format((float)$profit, 2, '.', '')."</p>";
    
    $conn->close();
}

?>