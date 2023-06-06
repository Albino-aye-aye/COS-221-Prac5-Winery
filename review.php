<?php
    require_once 'config.php';


    function getWineID($wineName, $conn) {
        $wineName = strtolower($wineName);
    
        $sql = "SELECT WineID FROM COS221_Wines WHERE LOWER(Name) = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $wineName);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $wineID = $row['WineID'];
            return $wineID;
        } else {
            return null; 
        }

    }
    


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userID = $_COOKIE['UserID'];
        $wineName = $_POST['wine_name'];
        $rating = $_POST['rating'];
        $reviewText = $_POST['review'];

        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO COS221_Reviews (UserID, WineID, Points, ReviewText) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siis", $userID, $wineID, $rating, $reviewText);

        $wineID = getWineID($wineName, $conn);


        if ($wineID === null) {   
            echo "<script> alert('No wine of that name exists') </script>";
            $stmt->close();
            $conn->close(); 
            
        } else {
            $stmt->execute();
        
            $stmt->close();
            $conn->close(); 
            echo "<script> alert('Wine Rated!') </script>";

        }
    }
?>

<!doctype html>
<html>
<head>
    <title>Review Wine</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <?php require_once("header.php"); ?>
</head>
<body>
    

    <div class="container">
        <h1>Review Wine</h2>
        <form action="review.php" method="POST">
            <div class="form-group">
                <label for="wine_name">Wine Name:</label>
                <input type="text" class="form-control" id="wine_name" name="wine_name" autocomplete="off" required>
                <div id="wine-suggestions"></div>
            </div>

            <div class="form-group">
                <label for="rating">Rating (0-100):</label>
                <input type="number" class="form-control" id="rating" name="rating" min="0" max="100" required>
            </div>

            <div class="form-group">
                <label for="review">Review:</label>
                <textarea class="form-control" id="review" name="review" rows="4" cols="50" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script>
        
    $(document).ready(function() {

        $('#submitBtn').click(function(event) 
        {
        event.preventDefault(); 


        var wineName = $('#wine_name').val();
        var rating = $('#rating').val();
        var reviewText = $('#review').val();


        if (wineName.length === 0 || rating.length === 0 || reviewText.length === 0) {
        alert('Please fill in all the fields');
        return;
        }


        $('#wine_name').val('');
        $('#rating').val('');
        $('#review').val('');

        window.location.reload();

        $('#wine_name').focus();
        });



        $('#wine_name').keyup(function() {
            var wineName = $(this).val();
            if (wineName.length >= 1) {
                $.ajax({
                    url: 'suggest.php',
                    method: 'POST',
                    data: { wine_name: wineName },
                    success: function(data) {
                        $('#wine-suggestions').html(data);
                    }
                });
            } else {
                $('#wine-suggestions').html('');
            }
        });
    });
</script>

</body>
</html>
