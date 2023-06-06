<?php 
session_start();
include_once('config.php');
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
                $('.nav-link[href="login.php"]').replaceWith('<li class="nav-item"><a class="nav-link" href="users.php">User Management</a></li>');
                $('.nav-link[href="signup.php"]').replaceWith('<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>');
                $('.nav-link[href="review.php"]').parent().hide(); // Hide the list item containing the review.php button
            } else {
                $('.nav-link[href="login.php"]').replaceWith('<li class="nav-item"><a class="nav-link" href="users.php">User Management</a></li>');
                $('.nav-link[href="signup.php"]').replaceWith('<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>');
                $('.nav-link[href="manage_wines_html.php"]').show(); // Show the manage_wines_html.php button
                $('.nav-link[href="review.php"]').parent().show(); // Show the list item containing the review.php button
            }
        });
    </script>
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark height">
        <ul class="navbar-nav mx-auto justify-content-center navItemContainer" id="navBar">
            <li class="nav-item"><a class="nav-link" href="wines.php">Wines</a></li>
            <li class="nav-item"><a class="nav-link" href="manage_wines_html.php">Manage Wines</a></li>
            <li class="nav-item"><a class="nav-link" href="search.php">Find Winery</a></li>
            <li class="nav-item" style="display: none;"><a class="nav-link" href="review.php">Review Wine</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
        </ul>
    </nav>
</body>
</html>
