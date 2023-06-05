<?php
require_once("config.php");
Class Database{
    public $conn;
    public static function instance() {
        static $instance = null;
        global $db_host, $db_user, $db_pass, $db_name;
        if($instance === null)
            $instance = new Database($db_host, $db_user, $db_pass, $db_name);
        return $instance; 
    }

    private function __construct($db_host, $db_user, $db_pass, $db_name) {
        $this->conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($this->conn->connect_error){
            die("Database Connection Failed: ". $this->conn->connect_error);
        }
    }
    public function __destruct() {
        $this->conn->close();
    }
}

$db = Database::instance();

$result = $db->conn->query("SELECT * FROM COS221_Wines ORDER BY Name;");

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (isset($_POST["sort"])){
        if ($_POST["sort"] != "") {
            $query = "SELECT * FROM COS221_Wines ORDER BY ".$_POST["sort"].";";
            $result = $db->conn->query($query);
        }
    }
}

?>

<!doctype html>
<html>


<head>
    <title>Wines</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <?php require_once("header.php"); ?>
    
    <div class="container">
        <form action="./wines.php" method="POST" class="my-4" id="sortForm">
            <div class="form-group row">
                <label for="sortOption" class="col-sm-2 col-form-label">Sort By:</label>
                <div class="col-sm-10 col-12"> <!-- Modified this line -->
                    <div class="d-flex">
                        <select id="sortOption" name="sort" class="form-control">
                            <option value="">Select an Option</option>
                            <option value="Price">Price</option>
                            <option value="Name">Name</option>
                            <option value="Vinification">Vinification</option>
                            <option value="Appellation">Appellation</option>
                            <option value="Vintage">Vintage</option>
                        </select>
                        <button id="SortPrice" type="submit" class="btn btn-primary ml-2">Sort</button>
                    </div>
                </div>
            </div>
        </form>

        <main>
            <h1 class="mb-4">Available Wines</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>WineID</th>
                        <th>Name</th>
                        <th>Vinification</th>
                        <th>Appellation</th>
                        <th>Vintage</th>
                        <th>Price</th>
                        <th>WineryID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if ($result) {
                            while ($row = $result->fetch_row()) {
                                echo "<tr><td>" . $row[0] ."</td><td>". $row[1] ."</td><td>". $row[2] ."</td><td>". $row[3] ."</td><td>". $row[4] ."</td><td>". $row[5] ."</td><td>". $row[6] ."</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'><p>No results found</p></td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </main>
    </div>

    <script>
        window.onload = function() {
            document.getElementById("SortPrice").addEventListener("click", function(event) {
                if (document.getElementById("sortOption").value === "") {
                    event.preventDefault();
                }
            });
        };
    </script>

</body>

</html>
