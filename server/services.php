<?php
require_once("./database_access.php");

class UserService {
    public static $dba;
    public static function register() {
        $dba = new DatabaseAccess();
    }
}

UserService::register();
UserService::$dba->close();