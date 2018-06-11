<?php 

namespace App\Library\Session;

/**
 * Gère les sessions de notre application
 */
class Session {

	/**
	 * Nom de la session
	 * @var string nom
	 */
	protected $name;

	/**
	 * Contenu/Message de la session
	 * @var string contenu/message
	 */
	protected $content;

	/**
	 * Création d'une session
	 * @param string nom
	 * @param string contenu/message
	 */
	public function __construct($name, $content) {
		$this->name = $name;
		$this->content = $content;
		$this->setSession();
	}

	/**
	 * On démarre les sessions
	 */
	public static function start() {
		session_start();
	}

	/**
	 * Permet de crée une session
	 */
	private function setSession($name) {
		if (isset($_SESSION[$this->name])) {
			throw new SessionException("This session already exist.");
		}
		$_SESSION[$name] = $content;
	}

	/**
	 * Récupère le contenu d'une session
	 * @param  nom nom de la session
	 * @return session|null
	 */
	public static function getSession($name) {
		if (isset($_SESSION[$name])) {
			return $_SESSION[$name];
		}

		return null;
	}

	/**
	 * Supprime la session
	 * @param  nom nom de la session
	 */
	public static function remove($name) {
		if (isset($_SESSION[$name])) {
			unset($_SESSION[$name]);
		}
	}

}