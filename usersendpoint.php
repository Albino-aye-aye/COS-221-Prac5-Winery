<?php
require "config.php";
Class Database{
    public static function instance() {
        static $instance = null;
        if ($instance === null) {
            global $db_host, $db_user, $db_pass, $db_name;
            $instance = new Database($db_host, $db_user, $db_pass, $db_name);
        }
        return $instance;
    }

    private function __construct($db_host, $db_user, $db_pass, $db_name) {
        $this->conn =  $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
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
