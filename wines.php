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

$result = $db->conn->query("SELECT * FROM COS221_Wines ORDER BY Name;");

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (isset($_POST["sort"])){
        $query = "SELECT * FROM COS221_Wines ORDER BY ".$_POST["sort"].";";
        $result = $db->conn->query($query);
    }
}

?>

<!doctype html>
<html>
    <head>
        <title>Wines</title>
    </head>

    <style>
    body{
        background-color: lightblue;
    }
    </style>


    <body>


    <nav class="Navbar">
        <div class="sidenav">
          <ul>
            <li><h1>Wine Sublime</h1></li>
            <li><h2>Wines</h2></li>
            <li><h2>Wineries</h2></li>
            <li><h2>Logout</h2></li> 
          </ul>
      </div>
      </nav>

    
    <form action="./wines.php" method="POST">
        <label for="sortOption">
        <select id="sortOption" name="sort">
            <option value="Price">Price</option>
            <option value="Name">Name</option>
            <option value="Vinification">Vinification</option>
            <option value="Appellation">Appellation</option>
            <option value="Vintage">Vintage</option>
        </select>
        <button id="SortPrice" type="submit" class="sort">Sort</button>
    </form>
    <main>
        <table>
            <tr>
            <th>WineID</th>
            <th>Name</th>
            <th>Vinification</th>
            <th>Appellation</th>
            <th>Vintage</th>
            <th>Price</th>
            <th>WineryID</th>
</tr>
        
        <?php 
            if ($result){
                while ($row = $result->fetch_row()){
                    // echo var_dump($row);
                    echo "<tr><td>" . $row[0] ."</td><td>". $row[1] ."</td><td>". $row[2] ."</td><td>". $row[3] ."</td><td>". $row[4] ."</td><td>". $row[5] ."</td><td>". $row[6]."</td></tr>";
                }
            } else {
                echo "<p>No results found</p>";
            }
        ?>
        </table>
    </main>
    </body>

</html>