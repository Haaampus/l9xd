<?php 

namespace App\Controller;
use App\Library\Validator\Validator;
use App\Repository\UserRepository;
use App\Repository\AdminRepository;
use App\Library\PHPMailer\PHPMailer;
use App\Config;
use App\Database;
use App\Mail;
use App\Router\Router;

/**
 * Controller to manage admin
 */
class AdminController extends Controller {

	/**
	 * Redirect user if he's not "admin"
	 */
	public function __construct() {
		parent::__construct();
		if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
			if (UserRepository::getInstance()->getType($_SESSION['user']['id']) != "admin") {
				$this->redirect->redirectUser();
			}
		} else {
			$this->redirect->redirectUser();
		}
	}

	public function showEditBooster(int $booster_id) {
	    $booster_details = AdminRepository::getInstance()->getBoosterDetails($booster_id);
	    $booster_servers = AdminRepository::getInstance()->getBoosterServers($booster_id);

        $this->view('boostpanel.admin.editbooster', [
            'booster_details' => $booster_details,
            'booster_servers' => $booster_servers
        ]);
    }

	public function editBooster(int $booster_id) {
	    try {
	        $db = new Database();

	        if (isset($_POST['paypal']) && !empty($_POST['paypal'])) {
	            $db->update('boosters', $booster_id, 'users_id', [
	                'paypal' => $_POST['paypal']
                ]);
            }

            if (isset($_POST['percentage']) && !empty($_POST['percentage'])) {
                $db->update('boosters', $booster_id, 'users_id', [
                    'percentage' => $_POST['percentage']
                ]);
            }

            $servers = Config::SERVERS;
            $tempServers = [];
            if (isset($_POST['servers_played']) && !empty($_POST['servers_played'])) {
                foreach ($_POST['servers_played'] as $server_played) {
                    $tempServers[] = $server_played;
                    if (!$db->rowCount("SELECT server FROM boosters_has_servers WHERE boosters_users_id = ? AND server = ?", [$booster_id, $server_played])) {
                        try {
                            $db->insert('boosters_has_servers', [
                                'boosters_users_id' => $booster_id,
                                'server' => $server_played
                            ]);
                        } catch(\Exception $e) {
                            $status = 'error';
                            $message = 'Oops! Something went wrong.';
                        }
                    }
                }
            }

            $diffServers = array_diff($servers, $tempServers);
            if (isset($diffServers) && !empty($diffServers)) {
                foreach ($diffServers as $server_played) {
                    try {
                        if ($db->rowCount("SELECT server FROM boosters_has_servers WHERE boosters_users_id = ? AND server = ?", [$booster_id, $server_played])) {
                            $db->delete('boosters_has_servers', 'server', $server_played);
                        }
                    } catch (\Exception $e) {
                        $status = 'error';
                        $message = 'Oops! Something went wrong.';
                    }
                }
            }

            if (!isset($status) && !isset($message)) {
                $status = "success";
                $message = "The booster have been updated.";
            }
        } catch (\Exception $e) {
            $status = "error";
            $message = "Oops! Something went wrong.";
        }
        return $this->redirect->route(Config::ADMIN)->with($status, $message);
    }

	public function paidOrder($order_id) {
		try {
			$db = new Database();
			$db->update('orders', $order_id, 'id', [
				'status' => 3
			]);
			$status = "success";
			$message = "Booster have been notified.";
		} catch (\Exception $e) {
			$status = "error";
			$message = "Oops! Something went wrong.";
		}
		return $this->redirect->route(Config::ADMIN)->with($status, $message);
	}

	/**
	 * Display the "homepage" of the admin
	 */
	public function show() {
		$boosters = AdminRepository::getInstance()->getAllBoosters();
		$running_orders = AdminRepository::getInstance()->getRunningOrders();
		$pending_orders = AdminRepository::getInstance()->getPendingOrders();
		$finished_orders = AdminRepository::getInstance()->getFinishedOrders();
		$paid_orders = AdminRepository::getInstance()->getPaidOrders();

		$this->view('boostpanel/admin/home', [
			'boosters' => $boosters,
			'pending_orders' => $pending_orders,
			'running_orders' => $running_orders,
			'finished_orders' => $finished_orders,
            'paid_orders' => $paid_orders
		]);
	}

	/**
	 * Display the page to add a booster
	 */
	public function getAddBooster() {
		// Get all the users who are not a booster and an admin
		$users = UserRepository::getInstance()->getUserWhoCanBeBooster();

		$this->view('boostpanel/admin/addBooster', [
			'users' => $users
		]);
	}

	/**
	 * Add an user (for the page add a booster)
	 */
	public function postAddUser() {
		$is_valid = Validator::validate($_POST, [
			'username' => 'required|max:15|unique:users,username',
			'email'	   => 'required|max:80|email|unique:users,email',
			'password' => 'required'
		]);

		if (!$is_valid) {
			$this->redirect->route('show_add_booster');
		} else {
			$db = new Database();
			
			try {
				$db->insert('users', [
					'username'   => $_POST['username'],
					'email'      => $_POST['email'],
					'password'   => hash('SHA512', $_POST['password']),
					'created_at' =>	date('Y').'-'.date('m').'-'.date('d')
				]);

				try {
					$html_message = "<p>You have been added as a user, here are your credentials :</p><br/>";
					$html_message .= "<ul>";
					$html_message .= "<li>Username : " . $_POST['username'] . "</li>";
					$html_message .= "<li>Password : " . $_POST['password'] . "</li>";
					$html_message .= "</ul><br>";
					$html_message .= 'You can now connect here : <a href="';
					$html_message .= Router::url('login.show');
					$html_message .= '">Connection</a>';

					Mail::send(Config::WEBSITE_NAME . ' - New User', $_POST['email'], $html_message);
				} catch (\Exception $e) {
					die(var_dump($e->getMessage()));
					$status = 'error';
					$message = 'Email has not been sent.';
				}

				if (empty($status)) {
					$status = 'success';
					$message = 'User have been added.';
				}
			} catch (\Exception $e) {
				$status = 'error';
				$message = 'Oops! Something went wrong.';
			}
			$this->redirect->route('show_add_booster')->with($status, $message);
		}
	}

	/**
	 * Add an user (for the page add an order)
	 */
	public function postAddUserOrder() {
		$is_valid = Validator::validate($_POST, [
			'username' => 'required|max:15|unique:users,username',
			'email'	   => 'required|max:80|email|unique:users,email',
			'password' => 'required'
		]);

		if (!$is_valid) {
			$this->redirect->route('show_add_order');
		} else {
			$db = new Database();
			
			try {
				$db->insert('users', [
					'username'   => $_POST['username'],
					'email'      => $_POST['email'],
					'password'   => hash('SHA512', $_POST['password']),
					'created_at' =>	date('Y').'-'.date('m').'-'.date('d')
				]);

				try {
					$html_message = "<p>You have been added as a user, here are your credentials :</p><br/>";
					$html_message .= "<ul>";
					$html_message .= "<li>Username : " . $_POST['username'] . "</li>";
					$html_message .= "<li>Password : " . $_POST['password'] . "</li>";
					$html_message .= "</ul><br>";
					$html_message .= 'You can now connect here : <a href="';
					$html_message .= Router::url('login.show');
					$html_message .= '">Connection</a>';

					Mail::send(Config::WEBSITE_NAME . ' - New User', $_POST['email'], $html_message);
				} catch (\Exception $e) {
					$status = 'error';
					$message = 'Email has not been sent.';
				}

				if (empty($status)) {
					$status = 'success';
					$message = 'User have been added.';
				}
			} catch (\Exception $e) {
				$status = 'error';
				$message = 'Oops! Something went wrong.';
			}
			$this->redirect->route('show_add_order')->with($status, $message);
		}
	}

	/**
	 * Add a booster
	 */
	public function postAddBooster() {
		if (isset($_POST['add_to_booster']) && !empty($_POST['add_to_booster'])) {
			$db = new Database();
			foreach ($_POST['add_to_booster'] as $username) {
				try {
					$userId = $db->fetch('SELECT id FROM users WHERE username = ?', [$username]);
					$db->update('users', $username, 'username', ['users_type_id' => 2]);
					$db->insert('boosters', ['users_id' => $userId['id']]);

					$status = 'success';
					$message = 'Booster(s) have been added.';
				} catch (\Exception $e) {
					die($e->getMessage());
					$status = 'error';
					$message = 'Oops! Something went wrong.';
				}
			}
			$this->redirect->route(Config::ADMIN)->with($status, $message);
		} else {
			$this->redirect->route('show_add_booster');
		}
	}
	/**
	 * Change percentage
	 */
	public function changePercentage() {
		if (isset($_POST) && !empty($_POST)) {
			if ($_POST['percentage'] >= 0 && $_POST['percentage'] <= 100) {
				$db = new Database();
				$db->update('boosters', $_POST['id'], 'users_id', ['percentage' => $_POST['percentage']]);
			}
		}
	}

	/**
	 * Delete a booster with his id
	 */
	public function deleteBooster($id) {
		if (!empty($id)) {
			$db = new Database();
			if ($db->rowCount("SELECT id FROM users WHERE id = ?", [$id]) && $db->rowCount("SELECT users_id FROM boosters WHERE users_id = ?", [$id])) {
				try {
					$orders = $db->fetchAll("SELECT id FROM orders WHERE boosters_users_id = ?", [$id]);

					if (isset($orders) && !empty($orders)) {
						foreach ($orders as $order) {
							$db->update('orders', $order['id'], 'id', [
								'boosters_users_id' => NULL,
								'status' 			=> 0
							]);
						}
					}

					$db->delete('users', 'id', $id);
					$db->delete('boosters', 'users_id', $id);
					$status = "success";
					$message = "Booster have been deleted.";
				} catch (\Exception $e) {
					$status = "error";
					$message = "Oops! Something went wrong.";
				}
			}
		}
		$this->redirect->route(Config::ADMIN)->with($status, $message);
	}

	/**
	 * Show the page for adding an order
	 */
	public function showAddOrder() {
		// Get all the users who are not a booster and an admin
		$users = UserRepository::getInstance()->getUserWhoCanBeBooster();

		$this->view('boostpanel.admin.addOrder', [
			'users' => $users
		]);
	}

	/**
	 * Add an order
	 */
	public function postAddOrder() {
		if (isset($_POST) && !empty($_POST)) {
			$duo = 0;
			if ($_POST['order_duo'] === "Solo Boost") {
				$duo = 0;
			} else {
				$duo = 1;
			}
			$db = new Database();
			try {
				$db->getPDO()->beginTransaction();
					$order_id = randomOrderId();
					$db->insert('orders', [
						'id' => $order_id,
						'users_id' => $_POST['order_selected_user'],
						'type' => $_POST['order_type'],
						'queue' => $_POST['order_queue'],
						'duo'   => $duo,
						'price' => $_POST['order_price'],
						'currency' => $_POST['order_currency'],
						'created_at' => date("Y-m-d H:i:s")
					]);

					if ($_POST['order_type'] === "Division Boost") {
						$db->insert('orders_details', [
							'orders_id' => $order_id,
							'start_league' => $_POST['order_details_start_league'],
							'start_division' => $_POST['order_details_start_division'],
							'start_league_points' => $_POST['order_details_start_league_points'],
							'desired_league' => $_POST['order_details_desired_league'],
							'desired_division' => $_POST['order_details_desired_division']
						]);
					} else if ($_POST['order_type'] === "Net Wins") {
						$db->insert('orders_details', [
							'orders_id' => $order_id,
							'start_league' => $_POST['order_details_net_wins_start_league'],
							'start_division' => $_POST['order_details_net_wins_start_division'],
							'start_league_points' => $_POST['order_details_net_wins_start_league_points'],
							'game_amount' => $_POST['order_details_net_wins_amount_of_games']
						]);
					} else if ($_POST['order_type'] === "Placement Matches") {
						$db->insert('orders_details', [
							'orders_id' => $order_id,
							'game_amount' => $_POST['order_details_placement_amount_of_games']
						]);
					}

				$db->getPDO()->commit();
				$status = "success";
				$message = "Order have been added.";
			} catch (\Exception $e) {
				$db->getPDO()->rollBack();
				$status = "error";
				$message = "Oops! Something went wrong.";
			}

			if ($status === "success") {
				$this->redirect->route(Config::ADMIN)->with($status, $message);
			} else {
				$this->redirect->route('show_add_order')->with($status, $message);
			}
		}
	}

	/**
	 * Assign an order to a booster
	 */
	public function assignOrder() {
		if (isset($_POST) && !empty($_POST)) {
			$db = new Database();
			try {
				$db->update('orders', $_POST['order_id'], 'id', [
					'boosters_users_id' => $_POST['order_booster'],
					'status' => 1
				]);
				$status = "success";
				$message = "Order " . $_POST['order_id'] . " have been assigned.";
			} catch (\Exception $e) {
				$status = "error";
				$message = "Oops! Something went wrong.";
			}
			$this->redirect->route(Config::ADMIN)->with($status, $message);
		}
		$this->redirect->route(Config::ADMIN);
	}

	/**
	 * Drop an order
	 */
	public function dropOrder($order_id) {
		if (isset($order_id) && !empty($order_id)) {
			$db = new Database();
			try {
				$db->update('orders', $order_id, 'id', [
					'boosters_users_id' => NULL,
					'status'			=> 0
				]);
				$status = "success";
				$message = "Order have been dropped.";
			} catch (\Exception $e) {
				$status = "error";
				$message = "Oops! Something went wrong.";
			}
			$this->redirect->route(Config::ADMIN)->with($status, $message);
		}
		$this->redirect->route(Config::ADMIN);
	}

}