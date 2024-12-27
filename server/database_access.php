<?php
$config = include("./config.local.php");

class DatabaseAccess {
    private $conn;

    public function __construct() {
        global $config;

        $conn = new mysqli($config["DB_HOST"], $config["DB_USER"], $config["DB_PASSWORD"], $config["DB_NAME"]);
        if ($conn->connect_error) {
            die("Invalid Access to the Database");
        }
    }
    public function execute($sql, $types, ...$inputs) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($types, $inputs);
    }
    public function close() {
        $this->conn->close();
    }
}