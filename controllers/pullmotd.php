<?php
function pullMotd() {
    $servername = "localhost";
    $dbname = "restaurantsystem";
    $dbusername = "restaurant";
    $dbpassword = "compsci776";

    $sql = "SELECT * FROM `homepage` ORDER BY `index` ASC";
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "
                <pre id=\"homemotd\">".$row["motd"]."</pre>";
        }
    }
    
    $conn->close();
}
?>