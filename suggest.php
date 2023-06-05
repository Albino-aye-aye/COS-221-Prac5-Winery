<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wineName = $_POST['wine_name'];

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $wineNameWildcard = "%{$wineName}%";

    $sql = "SELECT Name FROM COS221_Wines WHERE Name = ? OR SOUNDEX(Name) = SOUNDEX(?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $wineName, $wineNameWildcard);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>" . $row['Name'] . "</div>";
        }
    } else {
        echo "<div>No suggestions found.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>
