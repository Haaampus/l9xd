<?php 

namespace App\Library\Session;

/**
 * Session Flash, disponible seulement pour la prochaine requête
 */
class Flash extends Session {

	/**
	 * Instanciation de la session flash
	 * @param name nom de la session flash
	 * @param message contenu/texte
	 */
	public function __construct($name, $message) {
		$this->name = $name;
		$this->content = $message;
		$this->setFlash();
	}

	/**
	 * On crée la session flash
	 */
	private function setFlash() {
		if (empty($this->name) || empty($this->content)) {
			throw new SessionException('No name or message.');
		} else if (isset($_SESSION['flash'][$this->name])) {
			throw new SessionException('A session already exist with this name.');
		}
		$_SESSION['flash'][$this->name] = $this->content;
	}

	/**
	 * Permet de récupérer le message de la session flash donnée
	 * Il va "echo" le message, puis supprimer la session flash
	 * @param  name nom de la session flash
	 * @return null
	 */
	public static function get($name) {
		if (isset($_SESSION['flash'])) {
			if (array_key_exists($name, $_SESSION['flash'])) {
				$flash = $_SESSION['flash'][$name];
				self::clear($name);
				return $flash;
			}
		}

		return null;
	}

	/**
	 * Permet de savoir si une session flash existe
	 * @param  string $name nom de la session flash
	 * @return boolean    
	 */
	public static function exist($name) {
		if (isset($_SESSION['flash'])) {
			if (array_key_exists($name, $_SESSION['flash'])) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Supprime la session flash passé en paramètre, et supprime le tableau flash s'il est vide
	 * @param  name nom de la session flash
	 */
	public static function clear($name) {
		if (isset($_SESSION['flash'])) {
			foreach ($_SESSION['flash'] as $k => $v) {
				if ($k == $name) {
					unset($_SESSION['flash'][$k]);
				}
			}

			if (sizeof($_SESSION['flash']) == 0) {
				unset($_SESSION['flash']);
			}
		}
	}

}