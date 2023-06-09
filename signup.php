<?php
    require_once 'config.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the input values from the form
        $isWinery = false;
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);


        // Check if the email already exists in the database
        $stmt = $conn->prepare('SELECT COUNT(*) FROM COS221_User WHERE UserID = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            echo "Email already exists";
            exit;
        }
 
        if(isset($_POST['name']) && isset($_POST['country']) && isset($_POST['region']) && !empty($_POST['name']) || !empty($_POST['country']) || !empty($_POST['region'])){
            $name = trim($_POST['name']);
            $country = trim($_POST['country']);
            $region = trim($_POST['region']);
            
            if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
                echo "Invalid name";
                exit;
            }
            if (!preg_match('/^[a-zA-Z\s]+$/', $country)) {
                echo "Invalid country";
                exit;
            }
            if (!preg_match('/^[a-zA-Z\s]+$/', $region)) {
                echo "Invalid region";
                exit;
            }
            $isWinery = true;
        }

        //the industry standard regex for email as found on http://www.ex-parrot.com/~pdw/Mail-RFC822-Address.html
        if (!preg_match('/^(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\]/', $email)) {
            echo "Invalid email";
            exit;
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@!%*?&])[A-Za-z\d$@!%*?&]{8,}$/', $password)) {
            echo "Invalid password";
            exit;
        }   
        // Salt and hash the password
        $options2 = [
            'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
            'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
            'threads' => PASSWORD_ARGON2_DEFAULT_THREADS,
        ];
        
        $salt = bin2hex(random_bytes(32));
        $hashedPassword = password_hash($password . $salt, PASSWORD_ARGON2ID, $options2);
        // Create the user in the database
        if (!$isWinery) {
            $stmt = $conn->prepare('INSERT INTO COS221_User (UserID, password, salt, WineryID) VALUES (?, ?, ?, ?)');
            $wineryID = NULL; // Assign NULL to a variable
            $stmt->bind_param('sssi', $email, $hashedPassword, $salt, $wineryID); // Pass the variable as an argument
            $stmt->execute();
            $stmt->close();
        }  else {
            $stmt = $conn->prepare('INSERT INTO COS221_Winery (Country, Region, Name) VALUES (?, ?, ?)');
            $stmt->bind_param('sss', $country, $region, $name);
            $stmt->execute();
            $stmt->close();
            $stmt = $conn->prepare('SELECT MAX(WineryID) FROM COS221_Winery WHERE Name = ?');
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $wineryID;
            $stmt->bind_result($wineryID);
            $stmt->fetch();
            $stmt->close();
            $stmt = $conn->prepare('INSERT INTO COS221_User (UserID, password, salt, WineryID) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('sssi', $email, $hashedPassword, $salt, $wineryID);
            $stmt->execute();
            $stmt->close();
        }
        echo "<script>";
        echo " window.location.href = 'login.html';";
        echo "</script>";
        $_SESSION['loggedin'] = true;
    }
?>
