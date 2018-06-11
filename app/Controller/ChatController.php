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
 * Controller to manage chat
 */
class ChatController extends Controller {

	public function postMessage($id) {
		$db = new Database();

		echo $_POST['message'];

		if (isset($id) && !empty($id)) {
			try {
				$db->insert('livechat', [
					'order_id' => $id,
					'user_id'  => $_SESSION['user']['id'],
					'message'  => $_POST['message']
				]);
			} catch (\Exception $e) {
				// die($e->getMessage());
			}
		}
	}

	public function getMessages($id) {
		$db = new Database();

		if (isset($id) && !empty($id)) {
			$messages = $db->fetchAll("SELECT users.avatar, users.users_type_id, users.username, livechat.message, DATE_FORMAT(livechat.date, '%d/%m %H:%i') AS date 
					FROM livechat 
					INNER JOIN users ON users.id = livechat.user_id
					WHERE livechat.order_id = ?
					ORDER BY livechat.id", [$id]);

			if (isset($messages) && !empty($messages)) {
				foreach ($messages as $message) {
					$avatar = asset('boostpanel_assets/img/avatars/' . $message['avatar']);
					if ($message['users_type_id'] === 1) {
						echo '<div class="direct-chat-msg">
											<div class="direct-chat-info clearfix">
												<span class="direct-chat-name pull-left">'.$message['username'].'</span>
												<span class="direct-chat-timestamp pull-right">'.$message['date'].'</span>
											</div>
											<img class="direct-chat-img" src="' . $avatar . '" alt="Message user Image">
											<div class="direct-chat-text">
												'.$message['message'].'
											</div>
										</div>';
					} else {
                        echo '<div class="direct-chat-msg right">
											<div class="direct-chat-info clearfix">
												<span class="direct-chat-name pull-right">'.$message['username'].'</span>
												<span class="direct-chat-timestamp pull-left">'.$message['date'].'</span>
											</div>
											<img class="direct-chat-img" src="' . $avatar . '" alt="Message user Image">
											<div class="direct-chat-text">
												'.$message['message'].'
											</div>
										</div>';
                    }
				}
			}
		}
	}
	
}