<?php

require 'config.php'

if (isset($_POST['wineryID'])) {

  $wineryID = $_POST['wineryID'];
  setcookie('wineryID', $wineryID, time() + (86400 * 30), '/');
}





$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['wineryID']) && isset($_COOKIE['wineryID'])) {
    $wineryID = $_COOKIE['wineryID'];
    $stmt = $conn->prepare("SELECT WineID, name FROM COS221_Wines WHERE WineryID = ?");
    $stmt->bind_param('i', $wineryID);
    $stmt->execute();
    $result = $stmt->get_result();

    $wines = array();
    while ($row = $result->fetch_assoc()) {
      $wines[] = $row;
    }

    echo json_encode($wines);
    $stmt->close();

    
  }

  if (isset($_POST['addWineName']) && isset($_COOKIE['wineryID'])) {
    $wineryID = $_COOKIE['wineryID'];
    $addWineName = $_POST['addWineName'];
    $addVinification = $_POST['addVinification'];
    $addAppellation = $_POST['addAppellation'];
    $addVintage = $_POST['addVintage'];
    $addPrice = $_POST['addPrice'];

    $stmt = $conn->prepare("INSERT INTO COS221_Wines (name, Vinification, Appellation, Vintage, Price, WineryID) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssidi',  $addWineName, $addVinification, $addAppellation, $addVintage, $addPrice, $wineryID);
    $stmt->execute();

    header('Location: manage_wines.html?message=' . urlencode('Wine added successfully!'));
    exit();

    $stmt->close();
  }

  if (isset($_POST['removeWineName']) && $_POST['removeWineName'] !== "" && isset($_COOKIE['wineryID'])) {
    $removeWineID = $_POST['removeWineName'];
    $wineryID = $_COOKIE['wineryID'];
    $stmt = $conn->prepare("DELETE FROM COS221_Wines WHERE WineID = ? AND WineryID = ?");
    $stmt->bind_param('ii', $removeWineID, $wineryID);
    $stmt->execute();

    header('Location: manage_wines.html?message=' . urlencode('Wine removed successfully!'));
    exit();


    $stmt->close();
  } 
}



$conn->close();
?>