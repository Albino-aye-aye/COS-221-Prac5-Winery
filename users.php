<?php
require_once("header.php");
require_once("config.php");
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

    if (isset($_COOKIE['UserID'])) {
        $userID = $_COOKIE['UserID'];
        echo "Logged in as: " . $userID;
    } else {
        echo "UserID cookie is not set.";
    }
?>
<!doctype html>
<html>
<head>
    <title>User Update</title>
    <style>
        .tab {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Wine Sublime</h1>
    <ul class="Navbar">
    <li><a class= "userman" href="#" onclick="openTab(event, 'changeEmail')">Change UserID</a></li>
    <li><a class= "userman" href="#" onclick="openTab(event, 'changePassword')">Change Password</a></li>
    <li><a class= "userman" href="#" onclick="openTab(event, 'deleteAccount')">Delete Account</a></li>  
    </ul>


    <div id="changeEmail" class="tab">
    <label for="newEmail">Enter your new UserID:</label>
        <input type="text" id="newEmail" />
        <button onclick="confirmEmailChange()">Submit</button>
    </div>

    <div id="changePassword" class="tab">
    <label for="password1">New Password:</label>
    <input type="password" id="password1" required><br>

    <label for="password2">Confirm Password:</label>
    <input type="password" id="password2" required><br>

    <button onclick="changePassword()">Change Password</button>
    </div>

    <div id="changeWinery" class="tab">
    <label for="winerySelect">Select Winery:</label>
    <select id="winerySelect">
        <?php
        $db = Database::instance();
        $sql = "SELECT Name FROM COS221_Winery";
        $result = $db->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $wineryName = $row["Name"];
                echo "<option value='$wineryName'>$wineryName</option>";
            }
        }
        ?>
    </select>
    <button onclick="confirmWineryChange()">Confirm</button>
</div>

<div id="deleteAccount" class="tab">
    <button onclick="deleteAccount()">Delete Account</button>
</div>

<script>
        function openTab(evt, tabName) {
            var i, tabContent, tabLinks;
            tabContent = document.getElementsByClassName("tab");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }
            tabLinks = document.getElementsByClassName("userman");
            for (i = 0; i < tabLinks.length; i++) {
                tabLinks[i].className = "";
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className = "active";
        }

            function confirmEmailChange() {
            var newEmail = document.getElementById("newEmail").value;
            if (newEmail !== "") {
            if (confirm("Are you sure you want to change your UserID to '" + newEmail + "'?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "usersendpoint.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response);
                }
            };
            xhr.send("newEmail=" + newEmail);
            }
            } else {
            alert("Please enter a valid UserID.");
            }
            
            setTimeout(function() {
            location.reload();
            }, 1500); 

        }

        function changePassword() {
        var password1 = document.getElementById("password1").value;
        var password2 = document.getElementById("password2").value;

        if (password1 === password2) {
        if (password1.length >= 8) {
            if (confirm("Are you sure you want to change your password?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "usersendpoint.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = xhr.responseText;
                        alert(response);
                    }
                };
                xhr.send("password=" + password1);

                setTimeout(function() {
            location.reload();
            }, 1500);
            }
            } else {
            alert("Password should be at least 8 characters long.");
         }
        } else {
        alert("Passwords do not match.");
        }

        
        }

        function deleteAccount() {
            var deletevar = 1;
            if (confirm("Are you sure you want to delete your account? This process cannot be undone.")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "usersendpoint.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response);
                }
            };
            xhr.send("delete="+ deletevar);
            }

            //2.5 seconds after logging out the user is redirected to test.html. 
            //In the actual implementation this redirect to the sign up page made by Alec.
            setTimeout(function() {
            window.location.href = 'signup.html'; //test.php will be changed to the name of the sign up page. 
            //In this example test.php was in the same folder as the current file users.php
            }, 2500);
        }
                    
    </script>
</body>
</html>






