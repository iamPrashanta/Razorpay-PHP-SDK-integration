<?php
class Database
{

    private $host = "localhost";
    private $db_name = "DB_NAME";
    private $username = "USERNAME";
    private $password = "PASSWORD";
    public $conn;

    public function dbConnection()
    {

        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

$DB_HOST = 'localhost';
$DB_USER = 'USERNAME';
$DB_PASS = 'PASSWORD';
$DB_NAME = 'DB_NAME';

try {
    $DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}", $DB_USER, $DB_PASS);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$connection = mysqli_connect($DB_HOST, $DB_NAME, $DB_PASS, $DB_USER);
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
