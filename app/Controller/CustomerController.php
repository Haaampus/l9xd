<?php 

namespace App\Controller;
use App\Library\Validator\Validator;
use App\Repository\UserRepository;
use App\Config;
use App\Library\RiotAPI\RiotAPI;
use App\Library\RiotAPI\Definitions\Region;
use App\Database;

/**
 * Controller to manage customer
 */
class CustomerController extends Controller {

	private $servers = [
		'na'   => 'NORTH_AMERICA',
		'euw'  => 'EUROPE_WEST',
		'eune' => 'EUROPE_EAST',
		'las'  => 'LAMERICA_SOUTH',
		'lan'  => 'LAMERICA_NORTH',
		'br'   => 'BRASIL',
		'ru'   => 'RUSSIA',
		'tr'   => 'TURKEY',
		'oce'  => 'OCEANIA',
		'kr'   => 'KOREA',
		'jp'   => 'JAPAN'
	];

	private $queues = [
		'Solo/Duo' => 'RANKED_SOLO_5x5',
		'Flex (5v5)' => 'RANKED_FLEX_SR',
		'Flex (3v3)' => 'RANKED_FLEX_TT'
	];

	/**
	 * Redirect user if he's not "member"
	 */
	public function __construct() {
		parent::__construct();
		if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
			if (UserRepository::getInstance()->getType($_SESSION['user']['id']) != "member") {
				$this->redirect->redirectUser();
			}
		} else {
			$this->redirect->redirectUser();
		}
	}

	/**
	 * Display the "homepage" of the customer
	 */
	public function show() {
		$order = UserRepository::getInstance()->getCurrentOrder($_SESSION['user']['id']);
		$api = "";
		$region = "";

		// Insert current ranked data of the customer
		if (!empty(UserRepository::getInstance()->getUserDetail($_SESSION['user']['id'], 'summoner_name')) && !empty(UserRepository::getInstance()->getUserDetail($_SESSION['user']['id'], 'server')) && isset($order) && !empty($order)) {
			foreach ($this->servers as $abreviation => $full) {
				if (UserRepository::getInstance()->getUserDetail($_SESSION['user']['id'], 'server') === strtoupper($abreviation)) {
					$region = $full;
				}
			}

			foreach ($this->queues as $abreviation => $full) {
				if (strtolower($order['queue']) === strtolower($abreviation)) {
					$queue = $full;
				}
			}

			// Api connexion
			if (!empty($region)) {
				try {
					$api = new RiotAPI([
						RiotAPI::SET_KEY 			 => Config::API_KEY,
						RiotAPI::SET_CACHE_RATELIMIT => true,
						RiotAPI::SET_CACHE_CALLS	 => true,
						RiotAPI::SET_REGION 		 => Region::getRegion($region),
					]);
				} catch (\Exception $e) {
					//die($e->getMessage());
				}
			}

			if ($api) {
				// Insert current rank etc...
				try {
					try {
						$summoner = $api->getSummonerByName(UserRepository::getInstance()->getUserDetail($_SESSION['user']['id'], 'summoner_name'));
					} catch (\Exception $e) {
						$summoner = null;
					}
					
					if ($summoner) {
						$leagues = $api->getLeaguePositionsForSummoner($summoner->id);

						// Get current ranked datas for the order queue (summoner is ranked)
						if (isset($leagues) && !empty($leagues)) {
							foreach ($leagues as $league) {
								if ($league->queueType === $queue) {
									$db = new Database();
									$db->update('orders_details', $order['id'], 'orders_id', [
										'current_league'   		=> ucfirst(strtolower($league->tier)),
										'current_division' 		=> $league->rank,
										'current_league_points' => $league->leaguePoints
									]);
								}
							}
						} else {
							// Unranked
							$db = new Database();
							$db->update('orders_details', $order['id'], 'orders_id', [
								'current_league'   		=> "Unranked",
								'current_division' 		=> null,
								'current_league_points' => null
							]);
						}

					} else {
						// No summoner, set to unranked
						$db = new Database();
						$db->update('orders_details', $order['id'], 'orders_id', [
							'current_league'   		=> "Unranked",
							'current_division' 		=> null,
							'current_league_points' => null
						]);
					}

				} catch (\Exception $e) {
					//die($e->getMessage());
				}
			}
		}

		$this->view('boostpanel/customer/home', [
			'order'  => $order,
			'api'    => $api
		]);
	}

	/**
	 * Post account & order details
	 */
	public function account_order() {
		$add = UserRepository::getInstance()->addUserDetails($_SESSION['user']['id'], $_POST);
		if ($add === 'success') {
			$message = "The changes have been made.";
		} else if ($add === 'error') {
			$message = "Oops! Something went wrong.";
		}
		$this->redirect->route(Config::CUSTOMER)->with($add, $message);
	}

	public function showCoachOrder($coach_order_id) {
	    $order = UserRepository::getInstance()->getCurrentCoachOrder($coach_order_id);

	    $this->view('boostpanel/customer/coach', [
	        'order' => $order
        ]);
    }

}