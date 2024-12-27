<?php
require_once("./database_access.php");

class UserService {
    public static function register() {
        $dba = new DatabaseAccess();
    }
}