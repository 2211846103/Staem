<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/server/database_access.php");

class GameService {
    public static function getGameDetails($gameId) {
        $dba = new DatabaseAccess();

        $result = $dba->preQuery(
            "SELECT games.*, users.username, AVG(reviews.rating) AS rating
                FROM games LEFT JOIN users
                ON games.publisher_id=users.id
                LEFT JOIN reviews
                ON games.id=reviews.game_id
                WHERE games.id=?",
            "i",
            $gameId
        )[0];

        $result["screenshots"] = GameService::getScreenshotsURLByGameId($gameId);
        $result["hero"] = GameService::getHeroURLByGameId($gameId);
        $result["genres"] = GameService::getGameGenres($gameId);
        
        $dba->close();
        return $result;
    }
    public static function getTopGames() {
        $dba = new DatabaseAccess();

        $result = $dba->query(
            "SELECT games.*, COUNT(library_items.user_id) AS copies_sold, AVG(reviews.rating) AS rating 
                FROM games LEFT JOIN library_items 
                ON games.id=library_items.game_id
                LEFT JOIN reviews
                ON games.id=reviews.game_id
                GROUP BY games.id 
                ORDER BY copies_sold DESC 
                LIMIT 21"
        );

        foreach ($result as &$game) {
            $game["cover"] = GameService::getCoverURLByGameId($game["id"]);
            $game["hero"] = GameService::getHeroURLByGameId($game["id"]);
            $game["rating"] = $game["rating"] == NULL ? "5" : $game["rating"];
        }

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

        foreach ($result as &$game) {
            $game["cover"] = GameService::getCoverURLByGameId($game["id"]);
        }

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

        foreach ($result as &$game) {
            $game["cover"] = GameService::getCoverURLByGameId($game["id"]);
        }

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

        foreach ($result as &$game) {
            $game["cover"] = GameService::getCoverURLByGameId($game["id"]);
        }

        $dba->close();
        return $result;
    }
    public static function getGamesByPublisher() {
        $dba = new DatabaseAccess();

        $result = $dba->preQuery(
            "SELECT * FROM games WHERE publisher_id=?",
            "i",
            $_SESSION["user_id"]
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

        foreach ($result as &$game) {
            $game["cover"] = GameService::getCoverURLByGameId($game["id"]);
        }

        $dba->close();
        return $result;
    }

    public static function getCoverURLByGameId($gameId) {
        $dir = '../data/'. $gameId .'/';

        $files = glob($dir."cover.*");
        if (empty($files)) return null;

        $cover = basename($files[0]);
        return $dir.$cover;
    }
    public static function getHeroURLByGameId($gameId) {
        $dir = '../data/'. $gameId .'/';

        $files = glob($dir."hero.*");
        if (empty($files)) return null;

        $hero = basename($files[0]);
        return $dir.$hero;
    }
    private static function getScreenshotsURLByGameId($gameId) {
        $dir = '../data/'. $gameId .'/screenshots/';

        $files = glob($dir."*");
        if (empty($files)) return null;

        $urls = [];
        foreach ($files as $file) {
            $screenshot = $dir . basename($file);
            array_push($urls, $screenshot);
        }

        return $urls;
    }
    private static function getGameGenres($gameId) {
        $dba = new DatabaseAccess();

        $result = $dba->preQuery(
            "SELECT name FROM genres
                WHERE game_id=?",
            "i",
            $gameId
        );

        $dba->close();
        return $result;
    }
}