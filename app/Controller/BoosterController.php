<?php 

namespace App\Controller;
use App\Library\Validator\Validator;
use App\Repository\BoosterRepository;
use App\Repository\UserRepository;
use App\Library\PHPMailer\PHPMailer;
use App\Config;
use App\Database;
use App\Mail;
use App\Router\Router;

/**
 * Controller to manage admin
 */
class BoosterController extends Controller {

	/**
	 * Redirect user if he's not "admin"
	 */
	public function __construct() {
		parent::__construct();
		if (UserRepository::getInstance()->getType($_SESSION['user']['id']) != 'admin') {
            if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
                if (UserRepository::getInstance()->getType($_SESSION['user']['id']) != "booster") {
                    $this->redirect->redirectUser();
                }
            } else {
                $this->redirect->redirectUser();
            }
        }
	}

	/**
	 * Display the homepage of booster
	 */
	public function show() {
		$available_orders = BoosterRepository::getInstance()->getAvailableOrders();
		$orders = BoosterRepository::getInstance()->getOrders();

		$this->view('boostpanel.booster.home', [
			'available_orders' => $available_orders, 
			'orders' => $orders
		]);
	}

	/**
	 * Apply to the order ID
	 * @param  int $order_id order id
	 */
	public function applyToOrder($order_id) {
		if (!empty($order_id)) {
			try {
				$db = new Database();

				$percentage = BoosterRepository::getInstance()->getPercentage($_SESSION['user']['id']);

                $order = BoosterRepository::getInstance()->getOrderDetails($order_id);
                $boosterPrice = calcPrice($order['price'], $percentage, true);

				$db->update('orders', $order_id, 'id', [
					'status' => 1,
					'boosters_users_id' => $_SESSION['user']['id'],
                    'booster_price'     => $boosterPrice
				]);

				$status = "success";
				$message = "You successfully applied to this order.";
			} catch (\Exception $e) {
				$status = "error";
				$message = "Oops! Something went wrong.";
			}
		}
		$this->redirect->route(Config::BOOSTER)->with($status, $message);
	}

	/**
	 * Display the page with the details of the order
	 * @param  int $order_id orer id
	 */
	public function showOrder($order_id) {
		$db = new Database();
		if ($db->rowCount("SELECT boosters_users_id FROM orders WHERE boosters_users_id = ? AND id = ?", [$_SESSION['user']['id'], $order_id]) || UserRepository::getInstance()->getType($_SESSION['user']['id']) === 'admin') {
			$order = BoosterRepository::getInstance()->getOrderDetails($order_id);
			$prefered_positions = BoosterRepository::getInstance()->getPreferedPositions($order['users_id']);
			$prefered_champions = BoosterRepository::getInstance()->getPreferedChampions($order['users_id']);

			$this->view('boostpanel.booster.order', [
				'order' => $order,
				'prefered_positions' => $prefered_positions,
				'prefered_champions' => $prefered_champions
			]);
		} else {
			$this->redirect->route(Config::BOOSTER);
		}
	}

	public function finishedOrder($order_id) {
		$db = new Database();
		try {
			$db->update('orders', $order_id, 'id', [
				'status' => 2,
				'finished_at' => date("Y-m-d H:i:s")
			]);
			$this->redirect->route(Config::BOOSTER)->with('success', 'The admin will check the order, and pay you if everything is good.');
		} catch(\Exception $e) {
			$this->redirect->route('order', ['order_id' => $order_id])->with('error', 'Oops! Something went wrong!');
		}
	}

	public function dropOrder($order_id) {
	    $db = new Database();
	    try {
            $db->update('orders', $order_id, 'id', [
                'boosters_users_id' => NULL,
                'status'			=> 0,
                'booster_price'     => NULL
            ]);
            $this->redirect->route('order', ['order_id' => $order_id])->with('success', 'Order have been dropped.');
        } catch (\Exception $e) {
            $this->redirect->route('order', ['order_id' => $order_id])->with('error', 'Oops! Something went wrong!');
        }
    }

}