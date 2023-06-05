<?php

Class Database{
    public $conn;
    public static function instance() {
        $servername = "wheatley.cs.up.ac.za";
        $username = "u21455903";
        $password = "LYHPPX352F3ITTO3DHBWIGRCPEJHCGGJ";
        $database = "u21455903";
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
    body{
        background-color: lightgreen;
    }
    </style>


    <body>

    <h2>Search Wineries by Country</h2>
    
    <form action="./search.php" method="POST">
        <label for="sortOption">
        <select id="sortOption" name="sort">
            <option value="none" selected disabled hidden>Select a Country</option>
            <?php 
                if ($res){
                    while ($r = $res->fetch_row()){
                        // echo var_dump($row);
                        echo "<option value =". $r[1] .">". $r[1] ."</option>";
                    }
                } else {
                    echo "<p>No results found</p>";
                }
            ?>
        </select>
        <button id="SortPrice" type="submit" class="sort">Search</button>
    </form>
    <main>
        <table>
            <tr>
                <th>WineryID</th>
                <th>Name</th>
                <th>Country</th>
                <th>Region</th>
            </tr>
        
        <?php 
            if ($result){
                while ($row = $result->fetch_row()){
                    // echo var_dump($row);
                    echo "<tr><td>" . $row[0] ."</td><td>". $row[3] ."</td><td>". $row[1] ."</td><td>". $row[2] ."</td></tr>";
                }
            } else {
                echo "<p>No results found</p>";
            }
        ?>
        </table>
    </main>
    </body>

</html>