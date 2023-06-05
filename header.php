<?php 
session_start();
include_once('config.php');
include_once('style.css');
// shits a little fucked delete if u want 
// when u log in theres 2 log out buttons and the name link is plain text for some reason
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="style.css" rel="stylesheet">
    <title>Website</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var wineryID = localStorage.getItem('WineryID');

            if (wineryID && wineryID !== 'null') {
                $('.nav-link[href="login.php"], .nav-link[href="signup.php"]').replaceWith('<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>');
                $('.nav-link[href="manage_wines_html.php"]').show();
            } else {
                $('.nav-link[href="logout.php"]').replaceWith('<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li><li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>');
                $('.nav-link[href="manage_wines_html.php"]').hide();
            }
        });
    </script>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark height">
        <ul class="navbar-nav mx-auto justify-content-center navItemContainer" id="navBar">
            <li class="nav-item"><a class="nav-link" href="wines.php">Wines</a></li>
            <li class="nav-item" style="display: none;"><a class="nav-link" href="manage_wines_html.php">Manage Wines</a></li>
            <li class="nav-item"><a class="nav-link" href="search.php">Find a Wine</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
        </ul>
    </nav>
</body>
</html>