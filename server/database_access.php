<?php
$config = include("./config.local.php");

class DatabaseAccess {
    private mysqli $conn;
    private mysqli_stmt $stmt;
    private mysqli_result $result;

    public function __construct() {
        global $config;

        $this->conn = new mysqli($config["DB_HOST"], $config["DB_USER"], $config["DB_PASSWORD"], "test");
        if ($this->conn->connect_error) {
            die("Invalid Access to the Database");
        }
    }
    public function update($sql, $types = null, ...$inputs) {
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bind_param($types, ...$inputs);
        $this->stmt->execute();
    }
    public function query($sql, $types = null, ...$inputs) {
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bind_param($types, ...$inputs);
        $this->stmt->execute();
        $this->result = $this->stmt->get_result();
        return $this->result->fetch_all(MYSQLI_BOTH);
    }
    public function close() {
        $this->conn->close();
    }
}