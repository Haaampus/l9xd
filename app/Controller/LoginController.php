<?php 

namespace App\Controller;
use App\Library\Validator\Validator;
use App\Repository\UserRepository;

/**
 * Controller to manage login
 */
class LoginController extends Controller {

	/**
	 * Show the login page
	 */
	public function show() {
		if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
			$this->redirect->redirectUser();
		} else {
			$this->view('boostpanel/login');
		}
	}

	/**
	 * Manage the login form
	 */
	public function post() {
		$is_valid = Validator::validate($_POST, [
			'username' => 'required',
			'password' => 'required'
		]);

		if (!$is_valid) {
			$this->redirect->route('login.show');
		} else {
			if(UserRepository::getInstance()->exist($_POST['username'], hash('SHA512', $_POST['password']))) {
				if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
					unset($_SESSION['user']);
				}
				$_SESSION['user'] = UserRepository::getInstance()->getID($_POST['username']);
				$this->redirect->redirectUser();
			} else {
				$this->redirect->route('login.show')->with('login', 'Incorrect username or password.');
			}
		}
	}

}