<?php

namespace App\Repository;
use App\Config;

/**
 * Manage boosters 
 */
class BoosterRepository extends Repository {

	protected function __construct(){}

	public function seeCoachOrder() {
	    $stmt = self::$pdo->fetch('SELECT coach FROM boosters WHERE users_id = ?', [$_SESSION['user']['id']]);
	    return $stmt['coach'];
    }

	/**
	 * Get available orders
	 * @return array             available orders
	 */
	public function getAvailableOrders() {
	    $servers_played = $this->getServers();

	    if (is_array($servers_played) && !empty($servers_played) && !$this->seeCoachOrder()) {
            $query = "SELECT orders.users_id, id, type, server, queue, duo, price, currency, created_at 
				FROM orders
				JOIN users_details ON users_details.users_id = orders.users_id
				WHERE status = 0
				AND (";

            $count = 0;
            foreach ($servers_played as $server_played) {
                if ($count === 0) {
                    $query .= "server = ?";
                } else {
                    $query .= " OR server = ?";
                }

                $count++;
            }

            $query .= ")
            AND type NOT LIKE '%Coaching%'
            ORDER BY orders.created_at DESC";

            $newServersPlayed = [];
            foreach ($servers_played as $key => $value) {
                foreach ($value as $k => $v) {
                    $newServersPlayed[] = $v;
                }
            }

            return self::$pdo->fetchAll($query, $newServersPlayed);
        } else if (is_array($servers_played) && !empty($servers_played) && $this->seeCoachOrder()) {
            $query = "SELECT orders.users_id, id, type, server, queue, duo, price, currency, created_at 
				FROM orders
				JOIN users_details ON users_details.users_id = orders.users_id
				WHERE status = 0
				AND (";

            $count = 0;
            foreach ($servers_played as $server_played) {
                if ($count === 0) {
                    $query .= "server = ?";
                } else {
                    $query .= " OR server = ?";
                }

                $count++;
            }

            $query .= ")
            ORDER BY orders.created_at DESC";

            $newServersPlayed = [];
            foreach ($servers_played as $key => $value) {
                foreach ($value as $k => $v) {
                    $newServersPlayed[] = $v;
                }
            }

            return self::$pdo->fetchAll($query, $newServersPlayed);
        } else if (is_array($servers_played) && empty($servers_played) && !$this->seeCoachOrder()) {
            return self::$pdo->fetchAll("SELECT orders.users_id, id, type, server, queue, duo, price, currency, created_at 
				FROM orders
				JOIN users_details ON users_details.users_id = orders.users_id
				WHERE status = 0
				AND type NOT LIKE '%Coaching%'
				ORDER BY orders.created_at DESC");
        } else {
            return self::$pdo->fetchAll("SELECT orders.users_id, id, type, server, queue, duo, price, currency, created_at 
				FROM orders
				JOIN users_details ON users_details.users_id = orders.users_id
				WHERE status = 0
				ORDER BY orders.created_at DESC");
        }
	}

	public function getServers() {
	    return self::$pdo->fetchAll("SELECT server FROM boosters_has_servers 
                WHERE boosters_users_id = ?", [$_SESSION['user']['id']]);
    }

    public function totalBalance(int $booster_id) {
	    $totalBalance = self::$pdo->fetch("SELECT 
                IFNULL(SUM(booster_price),0) AS total_balance 
                FROM orders 
                WHERE boosters_users_id = ?
                AND status = 3
                GROUP BY status", [$booster_id]);
	    return $totalBalance['total_balance'];
    }

	public function playOnServer($server, int $booster_id = null) {
        if (!empty($server) && $booster_id === NULL) {
            try {
                if (self::$pdo->rowCount("SELECT server FROM boosters_has_servers WHERE boosters_users_id = ? AND server = ?", [$_SESSION['user']['id'], $server])) {
                    return true;
                }
                return false;
            } catch (\Exception $e) {
                return false;
            }
        } else {
            try {
                if (self::$pdo->rowCount("SELECT server FROM boosters_has_servers WHERE boosters_users_id = ? AND server = ?", [$booster_id, $server])) {
                    return true;
                }
                return false;
            } catch (\Exception $e) {
                return false;
            }
        }
        return false;
    }

	public function getFinishedOrders() {
		return self::$pdo->fetchAll("SELECT id, type, queue, duo, price, currency, finished_at, status 
			FROM orders 
			WHERE (status = 2 
			OR status = 3)
			AND boosters_users_id = ?
		    ORDER BY status DESC", [$_SESSION['user']['id']]);
	}	

	/**
	 * Get running orders for the current booster
	 * @return array running orders
	 */
	public function getOrders() {
		return self::$pdo->fetchAll("SELECT id, type, server, queue, duo, price, currency, created_at 
				FROM orders
				JOIN users_details ON users_details.users_id = orders.users_id
				WHERE status = 1 
				AND boosters_users_id = ?", [$_SESSION['user']['id']]);
	}

	/**
	 * Get the percentage of the booster
	 * @param  id $booster_id id of the user (booster)
	 * @return int             percentage
	 */
	public function getPercentage($booster_id) {
		$req = self::$pdo->fetch("SELECT percentage FROM boosters WHERE users_id = ?", [$booster_id]);
		return $req['percentage'];
	}

	public function getOrderDetails($order_id) {
		return self::$pdo->fetch("SELECT id, orders.users_id, type, server, account_name, account_password, queue, duo, 
				price, currency, created_at, summoner_name, notes_to_booster
				FROM orders
				JOIN users_details ON users_details.users_id = orders.users_id
				WHERE orders.id = ?", [$order_id]);
	}

	public function getPreferedPositions($user_id) {
		return self::$pdo->fetchAll('SELECT position_name FROM orders_prefered_positions WHERE users_id = ?', [$user_id]);
	}

	public function getPreferedChampions($user_id) {
		return self::$pdo->fetchAll('SELECT champion_name FROM orders_prefered_champions WHERE users_id = ?', [$user_id]);
	}

}