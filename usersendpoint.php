<?php
Class Database{
    public $conn;
    public static function instance() {
        $servername = "wheatley.cs.up.ac.za";
        $username = "u22570285";
        $password = "O274QLGXCRJUQ73NVGWHPHPSO3CV3NDV";
        $database = "u22570285";
        static $instance = null;
        if($instance === null)
            $instance = new Database($servername, $username, $password, $database);
        return $instance; 
    }

    private function __construct($servername, $username, $password, $database) {
        $this->conn = new mysqli($servername, $username, $password, $database);
        if ($this->conn->connect_error){
            die("Database Connection Failed: ". $this->conn->connect_error);
        }
    }
    public function __destruct() {
        $this->conn->close();
    }
}


$db = Database::instance();


if (isset($_COOKIE["UserID"])) {
    $userID = $_COOKIE["UserID"];

    //Update the email
    if (isset($_POST["newEmail"])) {
        $newEmail = $_POST["newEmail"];
        error_log($newEmail);
        
        $sql = "UPDATE COS221_User SET UserID = ? WHERE UserID = ?";
        
        $stmt = $db->conn->prepare($sql);
        $stmt->bind_param("ss", $newEmail, $userID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "UserID updated successfully!";
            setcookie("UserID", $newEmail, time() + (86400 * 30), "/");
        } else {
            echo "Failed to update UserID.";
        } 

        $stmt->close();
    }

    //Update the password
    if (isset($_POST["password"])) {
        $newPassword = $_POST["password"];

        $db = Database::instance();

        $sql = "UPDATE COS221_User SET Password = ? WHERE UserID = ?";

        $stmt = $db->conn->prepare($sql);
        $stmt->bind_param("ss", $newPassword, $userID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Password updated successfully!";
        } else {
            echo "Failed to update password.";
        }

        $stmt->close();
    }

    //Update the Winery
    if (isset($_POST["winery"])) {
        $newWinery = $_POST["winery"];
    
        $db = Database::instance();
    
        $sql = "SELECT WineryID FROM COS221_Winery WHERE Name = ?";
        $stmt = $db->conn->prepare($sql);
        $stmt->bind_param("s", $newWinery);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $wineryID = $row["WineryID"];
    
            $sql = "UPDATE COS221_User SET WineryID = ? WHERE UserID = ?";
            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("ss", $wineryID, $userID);
            $stmt->execute();
    
            if ($stmt->affected_rows > 0) {
                echo "Winery updated successfully!";
            } else {
                echo "Failed to update winery.";
            }
        } else {
            echo "Invalid winery selected.";
        }
    
        $stmt->close();
    }
    
    //Delete User
    if (isset($_POST["delete"])) {
    
        $db = Database::instance();
    
        $sql = "DELETE FROM COS221_User WHERE UserID = ?";

        $stmt = $db->conn->prepare($sql);
        $stmt->bind_param('s', $userID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Account deleted. You will now be logged out.";
             
            setcookie('UserID', '', time() - 3600, '/');
            unset($_COOKIE['UserID']);

        } else {
            echo "Failed to delete account.";
        }

        $stmt->close();
    }
    
}


?>
