<?php 

namespace App\Controller;
use App\Config;
use App\Router\Router;
use App\Database;
use App\Mail;
use App\Library\Redirect\Redirect;

/**
 * Controller to manage PayPal
 */
class PaypalController extends Controller {

    private $mode = "";

    public function __construct()
    {
        if (Config::PRODUCTION) {
            $this->mode = 'live';
        } else {
            $this->mode = 'sandbox';
        }
    }

    // Manage the payment
	public function payment() {

		// Boost Type [0]
		// Boost queue [1]
		// Boost duo (boolean) [2]
		// Boost Price [3]
		// Boost currency [4]
		// Boost Server [5]
		// Start_league [6]
		// Start_division [7]
		// start_league_points [8]
		// desired_league [9]
		// desired_division [10]
		// game_amount [11]
        // Lol username [12]
        // Lol password [13]
        // Lol summonername [14]
        // Prefered positions (separator : ,) [15]
        // Prefered champions (separator : ,) [16]
        // Notes to booster [17]
        // Price (+5) : boolean [18]
		
		$custom = explode('|', $_GET['custom']);

		$name = "";
		if ($custom[0] === "Division Boost") {
			$name = $custom[6] . " " . $custom[7] . " - " . $custom[9] . " " . $custom[10];
		} else if ($custom[0] === "Net Wins" || $custom[0] === "Placement Matches") {
			$name = $custom[6] . " " . $custom[7] . " - " . $custom[11] . " Games";
		} else if (strpos($custom[0], 'Coaching')) {
		    $name = $custom[0];
        }

		$price = $custom[3];
		if ($custom[18] === "true") {
		    $price += 5;
        }

		$apiContext = new \PayPal\Rest\ApiContext(
			new \PayPal\Auth\OAuthTokenCredential(
				Config::CLIENT_ID,
				Config::SECRET
			)
		);
        $apiContext->setConfig(
            [
                'log.LogEnabled' => true,
                'log.FileName' => 'PayPal.log',
                'log.LogLevel' => 'FINE',
                'mode' => $this->mode
            ]
        );

		$list = new \PayPal\Api\ItemList();
		$item = (new \PayPal\Api\Item())
			->setName($name)
			->setPrice($price)
			->setCurrency($custom[4])
			->setQuantity(1);
		$list->addItem($item);

		$amount = (new \PayPal\Api\Amount())
			->setTotal($price)
			->setCurrency($custom[4]);

		$transaction = (new \PayPal\Api\Transaction())
			->setItemList($list)
			->setDescription('Buy from ' . Config::URL)
			->setAmount($amount)
			->setCustom($_GET['custom']);

		$payment = new \PayPal\Api\Payment();
		$payment->setTransactions([$transaction]);
		$payment->setIntent('sale');
		$redirectUrls = (new \PayPal\Api\RedirectUrls())
			->setReturnUrl(Router::url('paypal_pay'))
			->setCancelUrl(Router::url('home'));
		$payment->setRedirectUrls($redirectUrls);
		$payment->setPayer((new \PayPal\Api\Payer())->setPaymentMethod('paypal'));

		try {
			$payment->create($apiContext);
			header('Location:' . $payment->getApprovalLink());
		} catch (\PayPal\Exception\PayPalConnectionException $e) {
			var_dump(json_decode($e->getData()));
		}
	}

	/**
	 * Set everything in database if ok
	 */
	public function pay() {
		$apiContext = new \PayPal\Rest\ApiContext(
			new \PayPal\Auth\OAuthTokenCredential(
				Config::CLIENT_ID,
				Config::SECRET
			)
		);
        $apiContext->setConfig(
            [
                'log.LogEnabled' => true,
                'log.FileName' => 'PayPal.log',
                'log.LogLevel' => 'FINE',
                'mode' => $this->mode
            ]
        );

		$payment = \PayPal\Api\Payment::get($_GET['paymentId'], $apiContext);
			
		$execution = (new \PayPal\Api\PaymentExecution())
			->setPayerId($_GET['PayerID'])
			->setTransactions($payment->getTransactions());

        // Boost Type [0]
        // Boost queue [1]
        // Boost duo (boolean) [2]
        // Boost Price [3]
        // Boost currency [4]
        // Boost Server [5]
        // Start_league [6]
        // Start_division [7]
        // start_league_points [8]
        // desired_league [9]
        // desired_division [10]
        // game_amount [11]
        // Lol username [12]
        // Lol password [13]
        // Lol summonername [14]
        // Prefered positions (separator : ,) [15]
        // Prefered champions (separator : ,) [16]
        // Notes to booster [17]
        // Price (+5) : boolean [18]

		$order_info = explode('|', $payment->getTransactions()[0]->getCustom());

		$price = $order_info[3];
		if ($order_info[18] === "true") {
		    $price += 5;
        }

		try {
			$payment->execute($execution, $apiContext);
			$email = $payment->getPayer()->getPayerInfo()->getEmail();
			$email_exploded = explode('@', $email);
			$username = $email_exploded[0];

			$password = randomPassword();

			if ($payment->state === "approved") {
				$db = new Database();
				try {
					$usernameExist = $db->rowCount("SELECT username FROM users WHERE username = ?", [substr($username, 0, 15)]);
					$emailExist = $db->rowCount("SELECT email FROM users WHERE email = ?", [$email]);

					$db->getPDO()->beginTransaction();

						if($usernameExist === 0 && $emailExist === 0) {
							$db->insert('users', [
								'username'   => substr($username, 0, 15),
								'password'   => hash('SHA512', $password),
								'email'      => $email,
								'created_at' => date('Y').'-'.date('m').'-'.date('d')
							]);
							$user_id = $db->getLastInsertId();
						}

						if (!isset($user_id)) {
							$req = $db->fetch("SELECT id FROM users WHERE email = ?", [$email]);
							$user_id = $req['id'];
						}

						if ($usernameExist === 0 && $emailExist === 0) {
							$db->insert('users_details', [
								'users_id' => $user_id,
								'account_name' => $order_info[12],
								'account_password' => $order_info[13],
								'summoner_name' => $order_info[14],
								'notes_to_booster' => $order_info[17],
								'server'   => $order_info[5]
							]);
						} else {
						    $row = $db->rowCount("SELECT * FROM users_details WHERE users_id = ?", [$user_id]);
						    if ($row) {
                                $db->update('users_details', $user_id, 'users_id', [
                                    'server' => $order_info[5],
                                    'account_name' => $order_info[12],
                                    'account_password' => $order_info[13],
                                    'summoner_name' => $order_info[14],
                                    'notes_to_booster' => $order_info[17],
                                ]);
                            } else {
                                $db->insert('users_details', [
                                    'users_id' => $user_id,
                                    'account_name' => $order_info[12],
                                    'account_password' => $order_info[13],
                                    'summoner_name' => $order_info[14],
                                    'notes_to_booster' => $order_info[17],
                                    'server'   => $order_info[5]
                                ]);
                            }
						}

						$order_id = randomOrderId();

						$db->insert('orders', [
							'id' => $order_id,
							'users_id' => $user_id,
							'type' => $order_info[0],
							'queue' => $order_info[1],
							'duo' => $order_info[2],
							'price' => $price,
							'currency' => $order_info[4],
							'created_at' => date("Y-m-d H:i:s")
						]);

						if ($order_info[0] === "Division Boost") {
							$db->insert('orders_details', [
								'orders_id' => $order_id,
								'start_league' => $order_info[6],
								'start_division' => $order_info[7],
								'start_league_points' => $order_info[8],
								'desired_league' => $order_info[9],
								'desired_division' => $order_info[10]
							]);
						} else if ($order_info[0] === "Net Wins" || $order_info[0] === "Placement Matches") {
							$db->insert('orders_details', [
								'orders_id' => $order_id,
								'start_league' => $order_info[6],
								'start_division' => $order_info[7],
								'start_league_points' => $order_info[8],
								'game_amount' => $order_info[11]
							]);
						} else if (strpos($order_info[0], 'Coaching')) {
						    $db->insert('orders_details', [
						       'orders_id' => $order_id,
                               'start_league' => $order_info[6],
                               'start_division' => $order_info[7]
                            ]);
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
                    if (isset($order_info[15]) && !empty($order_info[15])) {
                        foreach (explode(',', $order_info[15]) as $position_name) {
                            $tempPos[] = $position_name;
                            if (!$db->rowCount("SELECT position_name FROM orders_prefered_positions WHERE users_id = ? AND position_name = ?",
                                [$user_id, $position_name])) {
                                try {
                                    $db->insert('orders_prefered_positions', [
                                        'users_id' => $user_id,
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
                                if ($db->rowCount("SELECT position_name FROM orders_prefered_positions WHERE users_id = ? AND position_name = ?",
                                    [$user_id, $position_name])) {
                                    $db->delete('orders_prefered_positions', 'position_name', $position_name);
                                }
                            } catch (\Exception $e) {
                                return 'error';
                            }
                        }
                    }

                    // Prefered Champions
                    $champions = getAllChampions();
                    $tempChamps = [];

                    if (isset($order_info[16]) && !empty($order_info[16])) {
                        foreach (explode(',', $order_info[16]) as $prefered_champion) {
                            $tempChamps[] = $prefered_champion;
                            if (!$db->rowCount("SELECT champion_name FROM orders_prefered_champions WHERE users_id = ? AND champion_name = ?", [
                                $user_id, $prefered_champion])) {
                                try {
                                    $db->insert('orders_prefered_champions', [
                                        'users_id' => $user_id,
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
                                if ($db->rowCount("SELECT champion_name FROM orders_prefered_champions WHERE users_id = ? AND champion_name = ?", [
                                    $user_id, $champion])) {
                                    $db->delete('orders_prefered_champions', 'champion_name', $champion);
                                }
                            } catch (\Exception $e) {
                                return 'error';
                            }
                        }
                    }

					$db->getPDO()->commit();
                    if (strpos($order_info[0], 'Coaching')) {
                        $msg = "<p>Someone ordered a coaching order.</p>";
                        Mail::send(Config::WEBSITE_NAME . ' - New Coaching Order', Config::YOUR_EMAIL, $msg);
                    }
					if ($usernameExist === 0 && $emailExist === 0) {
						$html_message = "<p>Thanks for your order on our website, here are your credentials :</p><br/>";
						$html_message .= "<ul>";
						$html_message .= "<li>Username : " . substr($username, 0, 15) . "</li>";
						$html_message .= "<li>Password : " . $password . "</li>";
						$html_message .= "</ul><br>";
						$html_message .= 'You can now connect here : <a href="';
						$html_message .= Router::url('login.show');
						$html_message .= '">Connection</a>';

						Mail::send(Config::WEBSITE_NAME . ' - Your logins informations', $email, $html_message);
						$redirect = new Redirect();
						$redirect->route('login.show')->with('success', 'Your order has been received. Check your email for login informations');
					}
                    $redirect = new Redirect();
					$redirect->route('login.show')->with('success', 'Your order has been added to the boosters panel.');
				} catch (\Exception $e) {
					$db->getPDO()->rollBack();
                    $redirect = new Redirect();
					$redirect->route('login.show')->with('error', 'Error inserting the order from PayPal. If the problem persists, contact the webmaster');
				}
			} else {
                $redirect = new Redirect();
				$redirect->route('login.show')->with('error', 'Payment was not accepted. If the problem persists, contact the webmaster');
			}
		} catch (\Paypal\Exception\PayPalConnectionException $e) {
            $redirect = new Redirect();
			$redirect->route('login.show')->with('error', 'Error with PayPal Transaction. If the problem persists, contact the webmaster');
			//var_dump(json_decode($e->getData()));
		}
	}

}