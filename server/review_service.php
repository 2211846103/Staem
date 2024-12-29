<?php
include($_SERVER['DOCUMENT_ROOT'] . "/server/database_access.php");

class ReviewService {
    public static function getReviewsByGameId($gameId) {
        $dba = new DatabaseAccess();

        $result = $dba->preQuery(
            "SELECT reviews.*, users.username
                FROM reviews LEFT JOIN users
                ON reviews.user_id=users.id
                WHERE reviews.game_id=?",
            "i",
            $gameId
        );

        $dba->close();
        return $result;
    }
    public static function addReview($data) {
        $date = date("Y-m-d");
        $dba = new DatabaseAccess();

        $dba->preUpdate(
            "INSERT INTO reviews
                (body, rating, author_id, game_id, date) VALUES (?, ?, ?, ?, ?)",
                "sdiis",
                $data["body"], $data["rating"], $_SESSION["user_id"], $data["game_id"], $date
        );

        $dba->close();
    }
}