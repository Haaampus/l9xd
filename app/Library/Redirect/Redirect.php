<?php 

namespace App\Library\Redirect;
use App\Router\Router;
use App\Library\Session\Flash;
use App\Library\Validator\Validator;
use App\Repository\UserRepository;
use App\Config;

/**
 * Gérer les redirections dans notre application
 */
class Redirect {

	/**
	 * Url à rediriger
	 * @var string url
	 */
	private $url;

	public function __construct() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST) && !empty($_POST)) {
				if (!isset($_SESSION['flash']['POST'])) {
					new Flash('POST', $_POST);
				} else {
					Flash::clear('POST');
					new Flash('POST', $_POST);
				}
			}
		}
	}
	/**
	 * Permet de rediriger sur une URL de notre application
	 * @param  string url
	 * @return this
	 */
	public function redirect($url = "") {
		if (!empty($url)) {
			$this->url = ltrim($url, '/');
			header("Location: $this->url");
		}
		return $this;
	}

	/**
	 * Permet de rediriger sur l'url d'une route donnée
	 * @param  string nom de la route
	 * @param  array paramètres de la route
	 * @return this
	 */
	public function route($route_name, $route_parameters = []) {
		if (empty($this->url)) {
			$url = Router::url($route_name, $route_parameters);
			header("Location: $url");
		}
		return $this;
	}

	/**
	 * Redirect the user 
	 */
	public function redirectUser() {
		if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
			$type = UserRepository::getInstance()->getType($_SESSION['user']['id']);
			switch ($type) {
				case 'member':
					$url = Router::url(Config::CUSTOMER);
					header("Location: $url");
					break;
				case 'booster':
					$url = Router::url(Config::BOOSTER);
					header("Location: $url");
					break;
				case 'admin':
					$url = Router::url(Config::ADMIN);
					header("Location: $url");
					break;
			}
		} else {
			$loginURL = Router::url('login.show');
			header("Location: $loginURL");
		}
	}

	/**
	 * Crée un message flash pour la prochaine requête
	 * @param  string $name    nom du message
	 * @param  string $message message
	 * @return this
	 */
	public function with($name, $message) {
		new Flash($name, $message);
		return $this;
	}

}