<?php
function pullMenu() {
    $servername = "localhost";
    $dbname = "restaurantsystem";
    $dbusername = "restaurant";
    $dbpassword = "compsci776";
    //session_start();

    $sql = "SELECT * FROM `items` ORDER BY `index` ASC";
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "
                <tr style=\"text-align: center;\">
                    <td><p id=\"name".$row["index"]."\">".$row["name"]."</p></td>
                    <td><p id=\"price".$row["index"]."\">$".number_format((float)$row["price"], 2, '.', '')."</p></td>
                    <td><img id=\"image".$row["index"]."\" style=\"width: 100px; height: 100px;\" src=\"".$row['image']."\"/></td>
                    <td><p id=\"description".$row["index"]."\">".$row["description"]."</p></td>
                    <td><p id=\"ingredients".$row["index"]."\">".$row["ingredients"]."</p></td>
                    <td><input type=\"number\" name=\"quantity".$row["index"]."\" id=\"quantity".$row["index"]."\" min=\"1\" max=\"10000\" step=\"1\" placeholder=\"1\" required></td>
                    <td><textarea id=\"requests".$row["index"]."\" name=\"requests".$row["index"]."\" rows=\"4\" cols=\"20\" style=\"resize: none;\" maxlength=256 placeholder=\"No pickles, add ketchup, ...\"></textarea></td>
                    
                    <!-- Change to icon using <i> later, add functionality -->
                    <td><button id=\"cartbtn".$row["index"]."\" class=\"cartbutton\" type=\"button\" onclick=addToCart(".$row["index"].")>+</button></td> 
                    ";
            if (!empty($_SESSION["role"]) && strcmp($_SESSION["role"], "admin") == 0) {
                echo "    
                    <td><p id=\"preparation_time".$row["index"]."\">".$row["preparation_time"]."</p></td>
                    <td>
                        <button id=\"edit".$row["index"]."\" class=\"cartbutton\" type=\"button\" onclick=editItem(".$row["index"].")>Edit</button>
                        <button id=\"remove".$row["index"]."\" class=\"cartbutton\" type=\"button\" onclick=removeItem(".$row["index"].")>Delete</button>
                    </td>
                ";
            }
            echo "
                </tr>";
        }
    } else {
        echo "No rows retrieved";
    }
    
    $conn->close();
}
?>