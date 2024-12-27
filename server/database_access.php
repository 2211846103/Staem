<?php
class DBHandler {
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "Aq12wsaq1--11";
    private static $conn;

    public static function init() {
        $conn = new mysqli(DBHandler::$servername, DBHandler::$username, DBHandler::$password);
        if ($conn->connect_error) {
            die("Invalid Access to the Database");
        }
    }
    public static function execute($sql, $types, ...$inputs) {
        $stmt = DBHandler::$conn->prepare($sql);
        $stmt->execute($types, $inputs);
    }
    public static function close() {
        DBHandler::$conn->close();
    }
}