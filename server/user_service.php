<?php
require_once("./database_access.php");

class UserService {
    public static function register($details) {
        $dba = new DatabaseAccess();
        
        $dba->preUpdate(
            "INSERT INTO users (username, email, password, is_publisher) VALUES (?, ?, ?, ?)",
            "sssi",
            $details["username"], $details["email"], $details["password"], intval(false)
        );

        $dba->close();
    }
    public static function login($credentials) {
        $dba = new DatabaseAccess();

        $result = $dba->preQuery(
            "SELECT id FROM users WHERE username=? AND password=?",
            "ss",
            $credentials["username"], $credentials["password"]
        )[0];

        $_SESSION["user_id"] = $result["id"];

        $dba->close();
    }
    public static function updateInfo($details) {
        $dba = new DatabaseAccess();

        $dba->preUpdate(
            "UPDATE users SET username=?, email=? WHERE id=?",
            "ssi",
            $details["username"], $details["email"], $_SESSION["user_id"]
        );

        $dba->close();
    }
    public static function changePassword($passwordInfo) {
        $dba = new DatabaseAccess();

        $dba->preUpdate(
            "UPDATE users SET password=? WHERE id=? AND password=?",
            "sis",
            $passwordInfo["newPass"], $_SESSION["user_id"], $passwordInfo["currentPass"]
        );

        $dba->close();
    }
    public static function logout() {
        unset($_SESSION["user_id"]);
    }
}