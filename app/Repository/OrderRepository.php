<?php

namespace App\Repository;

/**
 * Manage orders 
 */
class OrderRepository extends Repository {

	protected function __construct(){}

	/**
	 * Get details of an order by the id of the order and the type of the order
	 * @param  string $order_id   id of the order
	 * @param  string $boost_type type of the boost
	 * @return array             
	 */
	public function getOrderDetails($order_id = "", $boost_type = "") {
		if(!empty($order_id) && isset($order_id) && !empty($boost_type) && isset($boost_type)) {
			if ($boost_type === "Net Wins" || $boost_type === "Placement Matches") {
				try {
					return self::$pdo->fetch("SELECT start_league, start_division, current_league, current_division, current_league_points, game_amount 
						FROM orders_details 
						WHERE orders_id = ?", [$order_id]);
				} catch (\Exception $e) {
					return [];
				}
			} else if ($boost_type === "Division Boost") {
				try {
					return self::$pdo->fetch("SELECT start_league, start_division, start_league_points, current_league, current_division, current_league_points,
						desired_league, desired_division
						FROM orders_details
						WHERE orders_id = ?", [$order_id]);
				} catch (\Exception $e) {
					return [];
				}
			} else if (strpos($boost_type, 'Coaching')) {
			    try {
                    return self::$pdo->fetch("SELECT start_league, start_division
						FROM orders_details
						WHERE orders_id = ?", [$order_id]);
                } catch (\Exception $e) {
			        return [];
                }
            }
		}
	}

	public function countOrders($servers) {
            if ($servers === "false" && BoosterRepository::getInstance()->seeCoachOrder()) {
                $req = self::$pdo->fetch('
                SELECT COUNT(*) AS order_number
				FROM orders');
                return $req['order_number'];
            } else if ($servers === "false" && !BoosterRepository::getInstance()->seeCoachOrder()) {
                $req = self::$pdo->fetch("
                SELECT COUNT(*) AS order_number
				FROM orders
				WHERE type NOT LIKE '%Coaching%'");
                return $req['order_number'];
            } else if ($servers === "true" && BoosterRepository::getInstance()->seeCoachOrder()) {
                $servers_played = BoosterRepository::getInstance()->getServers();

                if (is_array($servers_played) && !empty($servers_played)) {
                    $query = "SELECT COUNT(*) AS order_number 
				FROM orders
				JOIN users_details ON users_details.users_id = orders.users_id
				WHERE ";

                    $count = 0;
                    foreach ($servers_played as $server_played) {
                        if ($count === 0) {
                            $query .= "server = ?";
                        } else {
                            $query .= " OR server = ?";
                        }

                        $count++;
                    }

                    $newServersPlayed = [];
                    foreach ($servers_played as $key => $value) {
                        foreach ($value as $k => $v) {
                            $newServersPlayed[] = $v;
                        }
                    }

                    $stmt = self::$pdo->fetch($query, $newServersPlayed);
                    return $stmt['order_number'];
                }
            } else if ($servers === "true" && !BoosterRepository::getInstance()->seeCoachOrder()) {
                $servers_played = BoosterRepository::getInstance()->getServers();

                if (is_array($servers_played) && !empty($servers_played)) {
                    $query = "SELECT COUNT(*) AS order_number 
				FROM orders
				JOIN users_details ON users_details.users_id = orders.users_id
				WHERE (";

                    $count = 0;
                    foreach ($servers_played as $server_played) {
                        if ($count === 0) {
                            $query .= "server = ?";
                        } else {
                            $query .= " OR server = ?";
                        }

                        $count++;
                    }
                    $query .= ") AND type NOT LIKE '%Coaching%'";

                    $newServersPlayed = [];
                    foreach ($servers_played as $key => $value) {
                        foreach ($value as $k => $v) {
                            $newServersPlayed[] = $v;
                        }
                    }

                    $stmt = self::$pdo->fetch($query, $newServersPlayed);
                    return $stmt['order_number'];
                }
            }
        }

	public function getCustomerOPGG($id) {
		try {
			$req = self::$pdo->fetch("SELECT users_details.server, users_details.summoner_name 
						FROM orders
						JOIN users ON orders.users_id = users.id
						JOIN users_details ON users_details.users_id = users.id
						WHERE orders.id = ?", [$id]);
			return 'http://' . strtolower($req['server']) . ".op.gg/summoner/userName=" . $req['summoner_name'];
		} catch (\Exception $e) {
			
		}
	}

}