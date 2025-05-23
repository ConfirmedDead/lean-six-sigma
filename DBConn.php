
<?php
class DBConn {
    public $conn;
    
    // Open a database connection
    public function open() {
        $host = "10.4.52.67"; // Database host
        $username = "cruser";  // Database username
        $password = "password"; // Database password
        $dbname = "jogablogwen-code-recovery"; // Database name

        // Create connection
        $this->conn = new mysqli($host, $username, $password, $dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Close the database connection
    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

?>