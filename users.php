<?php
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
    <?php require_once("header.php"); ?>

    <style>
        .wineTabs {
            color: black !important;
        }

        .centered-input-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 10px;
        }

        .centered-input {
            max-width: 300px;
        }
        .wineTabs {
            color: black !important;
        }

        .nav-pills .nav-link.active.custom-tab-link {
            background-color: #E49393;
            color: black;
        }
    </style>
</head>
<body>
    <script>	
       	
           const error = localStorage.getItem('ChangeEmailError');	
           const error2 = localStorage.getItem('ChangePasswordError');	
           if (error) {  	
               alert(error);	
               localStorage.removeItem('ChangeEmailError');	
           }	
           if(error2){	
               alert(error2);	
               localStorage.removeItem('ChangePasswordError');	
           }	
   </script>
    <h1 class="mt-4">Wine Sublime</h1>
    <ul class="nav nav-pills mt-4">
    <li class="nav-item">
        <a class="nav-link active custom-tab-link wineTabs" data-toggle="pill" href="#changeEmail">Change UserID</a>
    </li>
    <li class="nav-item">
        <a class="nav-link custom-tab-link wineTabs" data-toggle="pill" href="#changePassword">Change Password</a>
    </li>
    <li class="nav-item">
        <a class="nav-link custom-tab-link wineTabs" data-toggle="pill" href="#deleteAccount">Delete Account</a>
    </li>
</ul>

    <div class="tab-content mt-4">
        <div id="changeEmail" class="tab-pane fade show active">
            <div class="centered-input-container">
                <label for="newEmail">Enter your new UserID:</label>
                <input type="text" id="newEmail" class="form-control mb-2 centered-input" />
                <button onclick="confirmEmailChange()" class="btn btn-primary centered-input">Submit</button>
            </div>
        </div>

        <div id="changePassword" class="tab-pane fade">
            <div class="centered-input-container">
                <label for="password1">New Password:</label>
                <input type="password" id="password1" class="form-control mb-2 centered-input" required>
            </div>
            <div class="centered-input-container">
                <label for="password2">Confirm Password:</label>
                <input type="password" id="password2" class="form-control mb-2 centered-input" required>
                <button onclick="changePassword()" class="btn btn-primary centered-input">Change Password</button>
            </div>

        </div>

        <div id="deleteAccount" class="tab-pane fade">
            <div class = "centered-input-container">
                <button onclick="deleteAccount()" class="btn btn-danger centered-input">Delete Account</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

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






