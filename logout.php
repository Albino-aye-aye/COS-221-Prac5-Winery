<?php
    //seems to work as needed
    include_once('header.php');
    include_once('config.php');
    $conn->close();
    setcookie('wineryID', '', time() - 3600, '/');
    setcookie('UserID', '', time() - 3600, '/');
    session_unset();
    session_destroy();

    echo "<script>
            localStorage.removeItem('WineryID');
            window.location.href = 'login.html';
          </script>";
?>