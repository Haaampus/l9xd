<?php 

namespace App\Controller;
use App\Library\Redirect\Redirect;

/**
 * Controller principal
 */
class Controller {

	/**
	 * Instance de l'objet Redirect, permet d'effectuer des redirections dans les controllers
	 * @var Redirect instance
	 */
	protected $redirect;

	/**
	 * Création de l'instance redirect pour les controllers
	 */
	public function __construct() {
		$this->redirect = new Redirect();
	}

	/**
	 * Retourne la vue correspondante
	 * @param  string
	 * @param  array variables à passer à la vue
	 * @return null
	 */
	public function view($name, $data = []) {
		// Remplace l'appel des variables de $data['donnee'] à $donnee
		extract($data);

		$name = str_replace('.', '/', $name) . ".php";
		
		if (!file_exists("app/Views/$name")) {
			throw new ControllerException('No views with this name');
		} 
		
		require_once("app/Views/$name");
	}

}