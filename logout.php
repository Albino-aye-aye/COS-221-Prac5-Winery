<?php
    // ALec Watson u22491351
    include_once('header.php');
    include_once('config.php');
    $conn->close();
    setcookie('winerID', '', time() - 3600, '/');
    session_unset();
    session_destroy();

    echo "<script>
            localStorage.removeItem('WineryID');
            window.location.href = 'login.html';
          </script>";
?>