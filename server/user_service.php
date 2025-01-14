<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/server/database_access.php");

class UserService {
    public static function register($details) {
        $success = true;
        $dba = new DatabaseAccess();

        $hashedPassword = password_hash($details["password"], PASSWORD_DEFAULT);
        
        try {
            $dba->preUpdate(
                "INSERT INTO users (username, email, password, is_publisher) VALUES (?, ?, ?, ?)",
                "sssi",
                $details["username"], $details["email"], $hashedPassword, intval(false)
            );
        } catch (Exception $e) {
            $success = false;
        }

        $dba->close();
        return $success;
    }
    public static function login($credentials) {
        $dba = new DatabaseAccess();

        $result = $dba->preQuery(
            "SELECT id, password, is_publisher FROM users WHERE username=?",
            "ss",
            $credentials["username"]
        );

        if (count($result) == 0) return false;
        if (!password_verify($credentials["password"], $result["password"])) return false;

        session_start();
        $_SESSION["user_id"] = $result[0]["id"];
        $_SESSION["is_logged_in"] = true;

        $dba->close();

        $role = $result[0]["is_publisher"] == 1 ? "publisher" : "client";
        return $role;
    }
    public static function isLoggedIn() {
        session_start();
        return $_SESSION["is_logged_in"];
    }
    public static function updateInfo($details) {
        $dba = new DatabaseAccess();

        if ($details["username"] != "") {
            $dba->preUpdate(
                "UPDATE users SET username=? WHERE id=?",
                "si",
                $details["username"], $_SESSION["user_id"]
            );
        }
        if ($details["email"] != "") {
            $dba->preUpdate(
                "UPDATE users SET email=? WHERE id=?",
                "si",
                $details["email"], $_SESSION["user_id"]
            );
        }

        $dba->close();
    }
    public static function changePassword($passwordInfo) {
        $dba = new DatabaseAccess();

        $oldPass = $dba->preQuery(
            "SELECT password FROM users WHERE id=?",
            "i",
            $_SESSION["user_id"]
        )[0]["password"];

        if (!password_verify($passwordInfo["currentPass"], $oldPass)) return false;

        $newPass = password_hash($passwordInfo["newPass"], PASSWORD_DEFAULT);

        $results = $dba->preUpdate(
            "UPDATE users SET password=? WHERE id=?",
            "sis",
            $newPass, $_SESSION["user_id"]
        );

        $dba->close();
        return $results > 0;
    }
    public static function logout() {
        session_start();
        $_SESSION["is_logged_in"] = false;
        session_destroy();
    }
}