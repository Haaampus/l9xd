<?php

namespace App\Controller;
use App\Library\Validator\Validator;
use App\Repository\UserRepository;
use App\Repository\AdminRepository;
use App\Repository\BoosterRepository;
use App\Library\PHPMailer\PHPMailer;
use App\Config;
use App\Database;
use App\Mail;
use App\Router\Router;

/**
 * Controller to manage profiles
 */
class ProfileController extends Controller {

	public function show() {
		$type = UserRepository::getInstance()->getType($_SESSION['user']['id']);

		$finished_orders = "";
		$paypal = "";
		$coach = "";
		if ($type === "booster") {
			$finished_orders = BoosterRepository::getInstance()->getFinishedOrders();
			$db = new Database();
            $ppaypal = $db->fetch("SELECT paypal FROM boosters WHERE users_id = ?", [$_SESSION['user']['id']]);
            $paypal = $ppaypal['paypal'];
            $coachh = $db->fetch("SELECT coach FROM boosters WHERE users_id = ?", [$_SESSION['user']['id']]);
            $coach = $coachh['coach'];
		}

		$this->view('boostpanel.profile', [
			'type' => $type,
			'finished_orders' => $finished_orders,
			'paypal' => $paypal,
            'coach' => $coach
		]);
	}

	public function postProfile() {
		try {
			$db = new Database();

			if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['name']))
			{
				$maxSize = 512000; // 50 Ko
				$validesExt = array('jpg', 'jpeg', 'png'); // Only jpg, jpeg or png
				if($_FILES['avatar']['size'] <= $maxSize)
				{
					$extUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1)); // Get extension
					if(in_array($extUpload, $validesExt))
					{
					    $path = $_SERVER['DOCUMENT_ROOT'] . '/boostpanel_assets/img/avatars/' . $_SESSION['user']['id'].'.'.$extUpload;
                        try {
							$dep = move_uploaded_file($_FILES['avatar']['tmp_name'], $path); // move the file to the folder
                            if ($dep) {
                                $db->update('users', $_SESSION['user']['id'], 'id', [
                                    'avatar' => $_SESSION['user']['id'] . '.' . $extUpload
                                ]);
                            }
						} catch (\Exception $e) {
							$status = 'error';
							$message = 'Oops! Something went wrong.';
						}
					}else{
						$status = 'error';
						$message = 'This extension is not valid, only jpg, jpeg or png';
					}
				}else{
					$status = 'error';
					$message = 'Your avatar is too big.';
				}
			}

					if (isset($_POST['email']) && !empty($_POST['email'])) {
						$db->update('users', $_SESSION['user']['id'], 'id', [
							'email' => $_POST['email']
						]);
					}
					if (isset($_POST['password']) && !empty($_POST['password'])) {
						$db->update('users', $_SESSION['user']['id'], 'id', [
							'password' => hash('SHA512', $_POST['password'])
						]);
					}
					if(isset($_POST['paypal']) && !empty($_POST['paypal'])) {
						$db->update('boosters', $_SESSION['user']['id'], 'users_id', [
							'paypal' => $_POST['paypal']
						]);
					}
					if ($_POST['before_coach'] === "1" && !isset($_POST['coach']) && empty($_POST['coach'])) {
                        $db->update('boosters', $_SESSION['user']['id'], 'users_id', [
                            'coach' => 0
                        ]);
                    } else if (isset($_POST['coach']) && !empty($_POST['coach'])) {
                        $db->update('boosters', $_SESSION['user']['id'], 'users_id', [
                            'coach' => 1
                        ]);
                    }

                $servers = Config::SERVERS;
                $tempServers = [];
                if (isset($_POST['servers_played']) && !empty($_POST['servers_played'])) {
                    foreach ($_POST['servers_played'] as $server_played) {
                        $tempServers[] = $server_played;
                        if (!$db->rowCount("SELECT server FROM boosters_has_servers WHERE boosters_users_id = ? AND server = ?", [$_SESSION['user']['id'], $server_played])) {
                            try {
                                $db->insert('boosters_has_servers', [
                                    'boosters_users_id' => $_SESSION['user']['id'],
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
                        if ($db->rowCount("SELECT server FROM boosters_has_servers WHERE boosters_users_id = ? AND server = ?", [$_SESSION['user']['id'], $server_played])) {
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
                $message = "Your profile has been updated.";
            }
		} catch (\Exception $e) {
			$status = 'error';
			$message = 'Oops! something went wrong.';
		}
		return $this->redirect->route('profile')->with($status, $message);
	}

}