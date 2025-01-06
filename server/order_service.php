<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/server/database_access.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/server/game_service.php");

enum TransactionType {
    case PURCHASE;
    case REFUND;
}

enum PurchaseState {
    case AVAILABLE;
    case IN_CART;
    case OWNED;
}

class CartService {
    public static function getCartGames() {
        $dba = new DatabaseAccess();

        $result = $dba->preQuery(
            "SELECT games.*
                FROM games INNER JOIN cart_items
                ON games.id=cart_items.game_id
                WHERE cart_items.user_id=?",
            "i",
            $_SESSION["user_id"]
        );

        foreach ($result as &$game) {
            $game["cover"] = GameService::getCoverURLByGameId($game["id"]);
        }

        $dba->close();
        return $result;
    }
    public static function addToCart($gameId) {
        $dba = new DatabaseAccess();

        $dba->preUpdate(
            "INSERT INTO cart_items 
                (user_id, game_id) 
                VALUES (?, ?)",
                "ii",
                $_SESSION["user_id"], $gameId
        );

        $dba->close();
    }
    public static function isAdded($gameId) {
        $dba = new DatabaseAccess();

        $cartResult = $dba->preQuery(
            "SELECT * FROM cart_items
                Where user_id=? AND game_id=?",
                "ii",
                $_SESSION["user_id"], $gameId
        );
        $libraryResult = $dba->preQuery(
            "SELECT * FROM library_items
                Where user_id=? AND game_id=?",
                "ii",
                $_SESSION["user_id"], $gameId
        );

        $dba->close();
        if (count($cartResult) > 0) {
            return PurchaseState::IN_CART;
        }
        if (count($libraryResult) > 0) {
            return PurchaseState::OWNED;
        }

        return PurchaseState::AVAILABLE;
    }
    public static function removeFromCart($gameId) {
        $dba = new DatabaseAccess();

        $dba->preUpdate(
            "DELETE FROM cart_items
                WHERE user_id=? AND game_id=?",
                "ii",
                $_SESSION["user_id"], $gameId
        );

        $dba->close();
    }
    public static function checkout() {
        $result = CartService::getCartGames();
        $dba = new DatabaseAccess();

        foreach ($result as $game) {
            $dba->preUpdate(
                "INSERT INTO library_items
                    (user_id, game_id) VALUES (?, ?)",
                    "ii",
                    $_SESSION["user_id"], $game["id"]
            );

            CartService::addTransaction($game["id"], $game["price"], TransactionType::PURCHASE);
        }

        $dba->preUpdate(
            "DELETE FROM cart_items
                WHERE user_id=?",
            "i",
            $_SESSION["user_id"]
        );

        $dba->close();
    }
    public static function refundGame($gameId) {
        $dba = new DatabaseAccess();

        $dba->preUpdate(
            "DELETE FROM library_items
                WHERE user_id=? AND game_id=?",
            "ii",
            $_SESSION["user_id"], $gameId
        );
        $value = CartService::getTransactionByGameId($gameId)["value"];
        CartService::addTransaction($gameId, $value, TransactionType::REFUND);

        $dba->close();
    }
    public static function getUserTransactions() {
        $dba = new DatabaseAccess();

        $result = $dba->preQuery(
            "SELECT * FROM transactions
                WHERE user_id=?
                ORDER BY date DESC",
                "i",
                $_SESSION["user_id"]
        );

        $dba->close();
        return $result;
    }
    public static function getStatisticsByGameId($gameId) {
        $dba = new DatabaseAccess();

        $stats = $dba->preQuery(
            "SELECT 
                COUNT(CASE WHEN is_purchase = 1 THEN 1 END) AS copies_sold,
                COUNT(CASE WHEN is_purchase = 0 THEN 1 END) AS refunds,
                SUM(CASE WHEN is_purchase = 1 THEN value ELSE 0 END) AS revenue_gained,
                SUM(CASE WHEN is_purchase = 0 THEN value ELSE 0 END) AS revenue_lost
                FROM transactions WHERE game_id=?",
            "i",
            $gameId
        );

        $dba->close();
        return [
            'copies_sold' => $stats["copies_sold"],
            'refunds' => $stats["refunds"],
            'net_revenue' => $stats["revenue_gained"] - $stats["revenue_lost"]
        ];
    }
    public static function cancelOrder() {
        $dba = new DatabaseAccess();

        $dba->preUpdate(
            "DELETE FROM cart_items
                WHERE user_id=?",
                "i",
                $_SESSION["user_id"]
        );

        $dba->close();
    }

    private static function addTransaction($gameId, $value,TransactionType $type) {
        $date = date("Y-m-d");
        $transaction = ($type == TransactionType::PURCHASE) ? 1 : 0;

        $dba = new DatabaseAccess();

        $dba->preUpdate(
            "INSERT INTO transactions
                (is_purchase, user_id, game_id, value, date) VALUES (?, ?, ?, ?, ?)",
                "iiids",
                $transaction, $_SESSION["user_id"], $gameId, $value, $date
        );

        $dba->close();
    }
    private static function getTransactionByGameId($gameId) {
        $dba = new DatabaseAccess();

        $result = $dba->preQuery(
            "SELECT value FROM transactions
                WHERE user_id=? AND game_id=?",
            "ii",
            $_SESSION["user_id"], $gameId
        );

        $dba->close();
        return $result[0];
    }
}