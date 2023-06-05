<?php
require_once("header.php");
require_once("config.php");
Class Database{
    public $conn;
    public static function instance() {
        static $instance = null;
        if($instance === null)
        global $db_host, $db_user, $db_pass, $db_name;
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

$result = $db->conn->query("SELECT * FROM COS221_Winery ORDER BY Country;");
$res = $db->conn->query("SELECT * FROM COS221_Winery ORDER BY Country;");

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (isset($_POST["sort"])){
        $query = "SELECT * FROM COS221_Winery WHERE Country LIKE '".$_POST["sort"]."';";
        $result = $db->conn->query($query);
    }
}

?>

<!doctype html>
<html>
    <head>
        <title>Search</title>
    </head>

    <style>
        h1 {
            font-size: 3em;
            padding: 0.2em;
        }
        #results {
            font-size: 2em;
            padding: 0.2em;
        }
    </style>
    <body>

    <?php require_once("header.php"); ?>


    

    <main>
    <h1>Search Wineries by Country</h1>

    <form action="./search.php" method="POST" class="form-inline my-4">
    <div class="form-group">
        <div class="input-group">
        <select id="sortOption" name="sort" class="form-control">
            <option value="none" selected disabled hidden>Select a Country</option>
            <?php 
            if ($res) {
                while ($r = $res->fetch_row()) {
                echo "<option value=". $r[1] .">". $r[1] ."</option>";
                }
            } else {
                echo "<option disabled>No results found</option>";
            }
            ?>
        </select>
        <div class="input-group-append">
            <button id="SortPrice" type="submit" class="btn btn-primary">Search</button>
        </div>
        </div>
    </div>
    </form>
    
    <h1 id = "results">Search Results</h2>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>WineryID</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Region</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if ($result){
                            while ($row = $result->fetch_row()){
                                echo "<tr><td>" . $row[0] ."</td><td>". $row[3] ."</td><td>". $row[1] ."</td><td>". $row[2] ."</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'><p>No results found</p></td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>

</html>
