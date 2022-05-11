<?php
function pullAccountRoles() {
    $servername = "localhost";
    $dbname = "restaurantsystem";
    $dbusername = "restaurant";
    $dbpassword = "compsci776";

    $sql = "SELECT * FROM `accounts` ORDER BY `index` ASC";
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if (strcmp(strtolower($row["last_name"]), "admin") == 0) continue;  // Prevent editing system admin account
            if (strcmp(strtolower($row["first_name"]), "restaurant") == 0 && strcmp(strtolower($row["last_name"]), "owner") == 0) continue;  // Prevent editing owner account -- unless admin?
            echo "
                <tr>
                    <td><p id=\"role".$row["index"]."\">".$row["role"]."</p></td>
                    <td>".$row["first_name"]." ".$row["last_name"]."</td>
                    <td><button id=\"edit".$row["index"]."\" class=\"cartbutton\" type=\"button\" onclick=editRole(".$row["index"].")>Edit</button></td>
                </tr>";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}

?>