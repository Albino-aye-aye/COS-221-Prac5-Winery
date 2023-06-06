<?php
require "config.php";
class Database
{
    public static function instance()
    {
        static $instance = null;
        if ($instance === null) {
            global $db_host, $db_user, $db_pass, $db_name;
            $instance = new Database($db_host, $db_user, $db_pass, $db_name);
        }
        return $instance;
    }

    private function __construct($db_host, $db_user, $db_pass, $db_name)
    {
        $this->conn =  $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($this->conn->connect_error) {
            die("Database Connection Failed: " . $this->conn->connect_error);
        }
    }
    public function __destruct()
    {
        $this->conn->close();
    }
}


$db = Database::instance();


if (isset($_COOKIE["UserID"])) {
    $userID = $_COOKIE["UserID"];

    //Update the email
    if (isset($_POST["newEmail"])) {
        $validemail = true;
        $newEmail = $_POST["newEmail"];
        $error = "Invalid email address. Please try again.";
        //the industry standard regex for email as found on http://www.ex-parrot.com/~pdw/Mail-RFC822-Address.html
        if (!preg_match('/^(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\]/', $newEmail)) {
            error_log($newEmail);
            $error = "Email address already exists. Please choose a different email.";
            echo $error;
            $validemail = false;
        }
        if ($validemail == true) {
            // Check if the new email already exists
            $sql = "SELECT COUNT(*) FROM COS221_User WHERE UserID = ?";
            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("s", $newEmail);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            $Nodup = true;
            if ($count > 0) {
                $error = "Email address already exists. Please choose a different email.";
                $Nodup = false;
            }
            if ($Nodup == true) {
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
        }
    }

    //Update the password
    if (isset($_POST["password"])) {
        $newPassword = $_POST["password"];
        $error = "Password must be at least 8 characters long and contain at least one number, one uppercase letter, and one lowercase letter.";
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@!%*?&])[A-Za-z\d$@!%*?&]{8,}$/', $newPassword)) {
            echo "<script>";
            echo "localStorage.setItem('ChangePasswordError', '" . addslashes($error) . "');";
            echo " window.location.href = 'users.php';";
            echo "</script>";
            exit();
        }
        $db = Database::instance();

        // Salt and hash the password
        $options2 = [
            'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
            'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
            'threads' => PASSWORD_ARGON2_DEFAULT_THREADS,
        ];

        $salt = bin2hex(random_bytes(32));
        $hashedPassword = password_hash($newPassword . $salt, PASSWORD_ARGON2ID, $options2);

        $sql = "UPDATE COS221_User SET Password = ? WHERE UserID = ?";

        $stmt = $db->conn->prepare($sql);
        $stmt->bind_param("ss", $hashedPassword, $userID);
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
