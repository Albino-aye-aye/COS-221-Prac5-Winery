<?php
require_once("config.php");
session_start();

$error = ""; // Variable to store error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inputed username and password
    $email = $_POST['email'];
    $password = $_POST['password'];
    echo $email;

    // Retrieval of salt and password from the database
    // Salt
    $stmt = $conn->prepare('SELECT salt FROM COS221_User WHERE UserID = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($salt);
    $stmt->fetch();
    $stmt->close();

    // Password
    $stmt = $conn->prepare('SELECT password FROM COS221_User WHERE UserID = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($dbPassword);
    $stmt->fetch();
    $stmt->close();

    $options2 = [
        'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
        'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
        'threads' => PASSWORD_ARGON2_DEFAULT_THREADS,
    ];

    if (password_verify($password . $salt, $dbPassword)) {
        // Password is correct
        $current_page = $_SERVER['PHP_SELF'];
        
        // Check if winery is set
        $stmt = $conn->prepare('SELECT WineryID FROM COS221_User WHERE UserID = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $WineryID;
        $stmt->bind_result($WineryID);
        $stmt->fetch();
        $stmt->close();
        
        setcookie('UserID', $email, time() + (86400 * 30), '/'); // Set cookie for 30 days
        echo "<script>";
        echo "localStorage.setItem('WineryID', '" . addslashes($WineryID) . "');";
        echo " window.location.href = 'wines.php';";
        echo "</script>";
        // header('Location: Compare.php?from=' . urlencode($current_page));
        // exit();
    } else {
        $error = "Incorrect password  or email. Please try again."; // Set error message
        echo "<script>";
        echo "localStorage.setItem('LoginError', '" . addslashes($error) . "');";
        echo " window.location.href = 'login.html';";
        echo "</script>";
    }
}
?>
