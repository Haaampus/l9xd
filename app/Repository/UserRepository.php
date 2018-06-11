<?php

namespace App\Repository;

/**
 * Manage users 
 */
class UserRepository extends Repository {

	/**
	 * Table of the repository
	 */
	protected function __construct(){ $this->table = 'users'; }

	/**
	 * Return 1 if the credential (username, password) are ok, 0 if there are false
	 * @param  string $username username of the user
	 * @param  string $password password of the user
	 * @return boolean          exist or not
	 */
	public function exist($username, $password) {
		return self::$pdo->rowCount("SELECT username, password FROM $this->table WHERE username = ? AND password = ?", [$username, $password]);
	}

	public function getAvatar() {
		try {
			$req = self::$pdo->fetch("SELECT avatar FROM users WHERE id = ?", [$_SESSION['user']['id']]);
			return $req['avatar'];
		} catch (\Exception $e) {
			return 'default.png';
		}
	}

	/**
	 * Get the ID of an user with his username
	 * @param  string $username username of the user
	 * @return int           id of the user
	 */
	public function getID($username) {
		return self::$pdo->fetch("SELECT id FROM $this->table WHERE username = ?", [$username]);
	}

	/**
	 * Get the type of the user (member, admin etc...) with his id
	 * @param  int $id id of the user
	 * @return string  type of the user
	 */
	public function getType($id) {
		$stmt = self::$pdo->fetch("SELECT users_type.type FROM $this->table 
								JOIN users_type ON $this->table.users_type_id = users_type.id
								WHERE $this->table.id = ?", [$id]);
		return $stmt['type'];
	}

	/**
	 * Get the username of the user with his id
	 * @param  int $id id of the user
	 * @return string     username of the user
	 */
	public function getUsername($id) {
		$stmt = self::$pdo->fetch("SELECT username FROM $this->table WHERE id = ?", [$id]);
		return $stmt['username'];
	}

	/**
	 * Get the created date of the user with his is
	 * @param  int $id id of the user
	 * @return string     date format : "Month, Year"
	 */
	public function getCreatedDate($id) {
		$stmt = self::$pdo->fetch("SELECT created_at FROM $this->table WHERE id = ?", [$id]);
		return date('F, Y', strtotime($stmt['created_at']));
	}

	/**
	 * Add details of user, account_name, summoner_name, password, server, notes to booster
	 * prefered positions, prefered champions
	 * @param int $id      id of the user
	 * @param array  $details Posted data
	 * @return string 'error' or 'success'
	 */
	public function addUserDetails($id, $details = []) {
		if (isset($details) && !empty($details) && $id != null) {
			$row_count = self::$pdo->rowCount("SELECT users_id FROM users_details WHERE users_id = ?", [$id]);

			foreach ($details as $key => $value) {
				if (empty($value)) {
					$$key = null;
				} else {
					$$key = $value;
				}
			}

			if (!$row_count) {
				try {
					self::$pdo->insert('users_details', [
						'users_id' => $id,
						'account_name' => $account_name,
						'account_password' => $password,
						'summoner_name' => $summoner_name,
						'server' => $server,
						'notes_to_booster' => $notes_to_booster
					]);
				} catch (\Exception $e) {
					return 'error';
				}
			} else {
				try {
					self::$pdo->update('users_details', $id, 'users_id', [
						'account_name' => $account_name,
						'account_password' => $password,
						'summoner_name' => $summoner_name,
						'server' => $server,
						'notes_to_booster' => $notes_to_booster
					]);
				} catch (\Exception $e) {
					return 'error';
				}
			}
		} 

		// Prefered positions
		$positions = [
			'top',
			'jungle',
			'bot',
			'support',
			'mid'
		];
		$tempPos = [];
		if (isset($_POST['prefered_positions']) && !empty($_POST['prefered_positions'])) {
			foreach ($_POST['prefered_positions'] as $position_name => $value) {
				$tempPos[] = $position_name;
				if (!self::$pdo->rowCount("SELECT position_name FROM orders_prefered_positions WHERE users_id = ? AND position_name = ?", [$id, $position_name])) {
					try {
						self::$pdo->insert('orders_prefered_positions', [
							'users_id' => $id,
							'position_name' => $position_name
						]);
					} catch (\Exception $e) {
						return 'error';
					}
				}
			}
		}

		$diffPos = array_diff($positions, $tempPos);
		if (isset($diffPos) && !empty($diffPos)) {
			foreach ($diffPos as $position_name) {
				try {
					if (self::$pdo->rowCount("SELECT position_name FROM orders_prefered_positions WHERE users_id = ? AND position_name = ?", [$id, $position_name])) {
						self::$pdo->delete('orders_prefered_positions', 'position_name', $position_name);
					}
				} catch (\Exception $e) {
					return 'error';
				}
			}
		}

		// Prefered Champions
		$champions = getAllChampions();
		$tempChamps = [];

		if (isset($_POST['prefered_champions']) && !empty($_POST['prefered_champions'])) {
			foreach ($_POST['prefered_champions'] as $prefered_champion) {
				$tempChamps[] = $prefered_champion;
				if (!self::$pdo->rowCount("SELECT champion_name FROM orders_prefered_champions WHERE users_id = ? AND champion_name = ?", [$id, $prefered_champion])) {
					try {
						self::$pdo->insert('orders_prefered_champions', [
							'users_id' => $id,
							'champion_name' => $prefered_champion
						]);
					} catch(\Exception $e) {
						return 'error';
					}
				}
			}
		}

		$diffChamps = array_diff($champions, $tempChamps);
		if (isset($diffChamps) && !empty($diffChamps)) {
			foreach ($diffChamps as $champion) {
				try {
					if (self::$pdo->rowCount("SELECT champion_name FROM orders_prefered_champions WHERE users_id = ? AND champion_name = ?", [$id, $champion])) {
						self::$pdo->delete('orders_prefered_champions', 'champion_name', $champion);
					}
				} catch (\Exception $e) {
					return 'error';
				}
			}
		}

		return 'success';
	}

	/**
	 * Return the value of a column for an user and a column in the table users_details
	 * @param  int $id     id of the user
	 * @param  string $column column_name
	 * @return string|null         
	 */
	public function getUserDetail($id, $column = "") {
		if (!empty($column) && is_int($id) && !empty($id)) {
			try {
				$req = self::$pdo->fetch("SELECT $column FROM users_details WHERE users_id = ?", [$id]);
				return $req[$column];
			} catch (\Exception $e) {
				return null;
			}
		}
	}

	/**
	 * To know if the user have this position in his "favorite"
	 * @param  int  $id       id of the user
	 * @param  string  $position position (top, mid, jungle, ..)
	 * @return boolean           
	 */
	public function isPreferedPosition($id, $position = "") {
		if (!empty($position) && is_int($id) && !empty($id)) {
			try {
				if (self::$pdo->rowCount("SELECT position_name FROM orders_prefered_positions WHERE users_id = ? AND position_name = ?", [$id, $position])) {
					return true;
				} 
				return false;
			} catch (\Exception $e) {
				return false;
			}
		}
	}

	public function isPreferedChampion($id, $champion = "") {
		if (!empty($champion) && is_string($champion) && !empty($id)) {
			try {
				if (self::$pdo->rowCount("SELECT champion_name FROM orders_prefered_champions WHERE users_id = ? AND champion_name = ?", [$id, $champion])) {
					return true;
				}
				return false;
			} catch (\Exception $e) {
				return false;
			}
		}
	}

	/**
	 * Get the current order id, and the status of an order of the user 
	 * @param  int $id id of the user
	 * @return array     values or empty
	 */
	public function getCurrentOrder($id) {
		if (is_int($id) && !empty($id)) {
			try {
				$req = self::$pdo->fetch("SELECT id, status, type, queue, created_at FROM orders WHERE users_id = ? AND (status = 1 OR status = 0) AND type NOT LIKE '%Coaching%' ORDER BY created_at LIMIT 1", [$id]);
				if ($req) {
					return $req;
				}
			} catch (\Exception $e) {
			    return [];
				//die('Error getting the current order, contact the webmaster if this is not a server problem.');
			}
		}
	}

	public function getCurrentCoachOrder($order_id) {
            try {
                $req = self::$pdo->fetch("SELECT id, status, type, queue, created_at FROM orders WHERE users_id = ? AND (status = 1 OR status = 0) AND id = ? ORDER BY created_at LIMIT 1", [$_SESSION['user']['id'], $order_id]);
                if ($req) {
                    return $req;
                }
            } catch (\Exception $e) {
                return [];
                //die('Error getting the current order, contact the webmaster if this is not a server problem.');
            }
    }

	public function getCoachOrder() {
        try {
            return self::$pdo->fetch("SELECT id, status, type, queue, created_at 
                FROM orders 
                WHERE users_id = ?
                AND (status = 2 OR status = 1 OR status = 0) 
                AND type LIKE '%Coaching%'
                ORDER BY created_at DESC LIMIT 1", [$_SESSION['user']['id']]);
        } catch (\Exception $e) {
            die(var_dump($e->getMessage()));
        }
    }

	/**
	 * Return username of each users who aren't booster or admin
	 * @return array 
	 */
	public function getUserWhoCanBeBooster() {
		return self::$pdo->fetchAll("SELECT id, username FROM users WHERE users_type_id <> 2 AND users_type_id <> 3");
	}

}