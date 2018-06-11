<?php

namespace App\Repository;

/**
 * Manage admin dashboard 
 */
class AdminRepository extends Repository {

	protected function __construct(){}

	/**
	 * Get all the boosters
	 * @return array boosters
	 */
	public function getAllBoosters() {
		return self::$pdo->fetchAll("SELECT users.id, users.username, users.created_at, boosters.percentage FROM users 
						JOIN boosters ON users.id = boosters.users_id");
	}

	public function getBoosterOrderOf($type, int $booster_id) {
	    if ($type === "assigned") {
            return self::$pdo->fetch('SELECT COUNT(*) AS count
                FROM orders
                WHERE status = 1 
                AND boosters_users_id = ?', [$booster_id]);
        } else if ($type === "finished") {
            return self::$pdo->fetch('SELECT COUNT(*) AS count
                FROM orders
                WHERE boosters_users_id = ?
                AND (status = 2 OR status = 3)', [$booster_id]);
        }
    }

	public function getBoosterDetails(int $id) {
	    return self::$pdo->fetch('SELECT users.id, boosters.paypal, boosters.percentage 
            FROM users 
            JOIN boosters ON users.id = boosters.users_id
            WHERE users.`id` = ?', [$id]);
    }

    public function getBoosterServers(int $id) {
	    return self::$pdo->fetchAll('SELECT server
            FROM `boosters_has_servers`
            WHERE `boosters_has_servers`.`boosters_users_id` = ?', [$id]);
    }

	/**
	 * Get pending orders
	 * @return array pending orders
	 */
	public function getPendingOrders() {
		return self::$pdo->fetchAll("SELECT id, type, queue, duo, price, currency, created_at, users_details.server 
FROM orders 
LEFT JOIN users_details ON users_details.users_id = orders.users_id
WHERE status = 0");
	}

	/**
	 * Get running orders
	 * @return array running orders
	 */
	public function getRunningOrders() {
		return self::$pdo->fetchAll("SELECT users.username, orders.booster_price, boosters.percentage,
orders.id, type, queue, duo, price, currency, orders.created_at, users_details.server 
					FROM orders 
					JOIN users ON orders.boosters_users_id = users.id
                    JOIN boosters ON orders.boosters_users_id = boosters.users_id
                    LEFT JOIN users_details ON users_details.users_id = orders.users_id
					WHERE status = 1");
	}

	/**
	 * Get finished orders
	 * @return array finished orders
	 */
	public function getFinishedOrders() {
		return self::$pdo->fetchAll("SELECT orders.id, orders.booster_price, orders.type, users.username, orders.queue, orders.duo, orders.price, orders.status, orders.currency, orders.created_at, 
						boosters.paypal, orders.finished_at, boosters.percentage 
						FROM orders
						JOIN boosters ON orders.boosters_users_id = boosters.users_id
                        JOIN users ON users.id = boosters.users_id
						WHERE orders.status = 2");
	}

	public function getPaidOrders() {
        return self::$pdo->fetchAll("SELECT orders.id, orders.booster_price, orders.type, users.username, orders.queue, orders.duo, orders.price, orders.status, orders.currency, orders.created_at, 
						boosters.paypal, orders.finished_at, boosters.percentage 
						FROM orders
						JOIN boosters ON orders.boosters_users_id = boosters.users_id
                        JOIN users ON users.id = boosters.users_id
						WHERE orders.status = 3");
    }

}