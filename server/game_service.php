<?php
include($_SERVER['DOCUMENT_ROOT'] . "/server/database_access.php");

class GameService {
    public static function getGameDetails($gameId) {
        $dba = new DatabaseAccess();

        $result = $dba->preQuery(
            "SELECT games.*, users.username
                FROM games LEFT JOIN users
                ON games.publisher_id=users.id
                WHERE games.id=?",
            "i",
            $gameId
        )[0];
        
        $dba->close();
        return $result;
    }
    public static function getTopGames() {
        $dba = new DatabaseAccess();

        $result = $dba->query(
            "SELECT games.*, COUNT(library_items.user_id) AS copies_sold 
                FROM games LEFT JOIN library_items 
                ON games.id=library_items.game_id
                GROUP BY games.id 
                ORDER BY copies_sold DESC 
                LIMIT 21"
        );

        $dba->close();
        return $result;
    }
    public static function getGamesByTitle($title) {
        $dba = new DatabaseAccess();

        $pattern = "%".$title."%";

        $result = $dba->preQuery(
            "SELECT games.*, COUNT(library_items.user_id) AS copies_sold 
                FROM games LEFT JOIN library_items 
                ON games.id=library_items.game_id
                WHERE games.title LIKE ? 
                GROUP BY games.id 
                ORDER BY copies_sold DESC",
            "s",
            $pattern
        );

        $dba->close();
        return $result;
    }
    public static function getGamesByGenre($genre) {
        $dba = new DatabaseAccess();

        $pattern = "%".$genre."%";

        $result = $dba->preQuery(
            "SELECT games.*, COUNT(library_items.user_id), genres.name AS copies_sold 
                FROM games LEFT JOIN library_items 
                ON games.id=library_items.game_id
                LEFT JOIN genres
                ON games.id=genres.game_id
                WHERE genres.name LIKE ? 
                GROUP BY games.id 
                ORDER BY copies_sold DESC",
            "s",
            $pattern
        );

        $dba->close();
        return $result;
    }
    public static function getGamesByDesc($desc) {
        $dba = new DatabaseAccess();

        $pattern = "%".$desc."%";

        $result = $dba->preQuery(
            "SELECT games.*, COUNT(library_items.user_id) AS copies_sold 
                FROM games LEFT JOIN library_items 
                ON games.id=library_items.game_id
                WHERE games.description LIKE ? 
                GROUP BY games.id 
                ORDER BY copies_sold DESC",
            "s",
            $pattern
        );

        $dba->close();
        return $result;
    }
    public static function getGamesByPublisher($publisherId) {
        $dba = new DatabaseAccess();

        $result = $dba->preQuery(
            "SELECT * FROM games WHERE publisher_id=?",
            "i",
            $publisherId
        );

        $dba->close();
        return $result;
    }
    public static function getLibrary() {
        $dba = new DatabaseAccess();

        $result = $dba->preQuery(
            "SELECT games.*
                FROM games INNER JOIN library_items
                ON games.id=library_items.game_id
                WHERE library_items.user_id=?",
            "i",
            $_SESSION["user_id"]
        );

        $dba->close();
        return $result;
    }
}