<?php 

namespace App\Library\FormBuilder;
use App\Router\Router;
use App\Library\Session\Flash;

/**
 * Création de formulaires HTML
 * Le formulaire utilise par défaut la méthode POST
 * Possibilité de changer les valeurs avec les méthodes :
 * setMethod('POST/GET')
 * setEnctype()
 */
class FormBuilder {

	/**
	 * Url de la route (même url par défaut)
	 * @var string url route
	 */
	private $route_name = "";

	/**
	 * Paramètres de la route
	 * @var array paramètres
	 */
	private $route_name_params = [];

	/**
	 * Contient les attributs du formulaire (url, method, enctype)
	 * @var array attributs
	 */
	protected $attributs = [];

	/**
	 * Les champs du formulaire
	 * @var array champs
	 */
	protected $fields = [];

	/**
	 * Erreurs du formulaire (envoyé grâce à la classe Validator)
	 * @var array erreurs
	 */
	protected $errors = [];

	/**
	 * @param string nom de la route
	 * @param array paramètres de la route
	 */
	public function __construct($route_name = "", $route_name_params = [])
	{
		$this->setRouteName($route_name, $route_name_params);
		$this->attributs['method'] = 'POST';
		$this->errors = Flash::get('errors');
	}

	/**
	 * Ajouter un champ au formulaire
	 * @param string  $field_type        type du champ (text, select etc...)
	 * @param string  $field_name        nom du champ, id aussi si label = true
	 * @param boolean $field_label       utiliser un label ?
	 * @param string  $field_label_value message du label
	 * @param array   $field_attributs   paramètres du champ
	 */
	public function add($field_type, $field_name, $field_label = false, $field_label_value = "", $field_attributs = []) {
		$input = "App\\Library\\FormBuilder\\Inputs\\" . ucfirst($field_type);
		$field = new $input($field_name, $field_label, $field_label_value, $field_attributs);
		$this->fields[] = $field;
		return $this;
	}

	/**
	 * Permet de garder dans l'input la valeur qui a été envoyé par l'utilisateur
	 * Utilisation : $form->add()->keepValue();
	 * @return this
	 */
	public function keepValue() {
		$input = $this->getLastField();
		if (isset($_SESSION['flash']['POST'][$input->attributs['name']]) && !empty($_SESSION['flash']['POST'][$input->attributs['name']])) {
			$input->attributs['value'] = $_SESSION['flash']['POST'][$input->attributs['name']];
		}
		return $this;
	}

	/**
	 * Permet de rendre le champ requis
	 * @return this
	 */
	public function required() {
		$input = $this->getLastField();
		$input->attributs['required'] = null;
		return $this;
	}

	/**
	 * Permet de rendre le champ "autocompletable" par le navigateur
	 * @return this
	 */
	public function autocomplete() {
		$input = $this->getLastField();
		$input->attributs['autocomplete'] = "on";
		return $this;
	}

	/**
	 * Permet de donner un pattern au champ
	 * @param  string $regex expression régulière
	 * @return this
	 */
	public function pattern($regex) {
		$input = $this->getLastField();
		$input->attributs['pattern'] = $regex;
		return $this;
	}

	/**
	 * Permet de donner un minimum au champ
	 * @param  int $length minimum
	 * @return this
	 */
	public function min($length) {
		$input = $this->getLastField();
		$input->attributs['min'] = $length;
		return $this;
	}

	/**
	 * Permet de donner un maximum au champ
	 * @param  int $length maximum
	 * @return this
	 */
	public function max($length) {
		$input = $this->getLastField();
		$input->attributs['max'] = $length;
		return $this;
	}

	/**
	 * Permet d'automatiquement focus le champ lorsque la page est chargé
	 * @return this
	 */
	public function autofocus() {
		$input = $this->getLastField();
		$input->attributs['autofocus'] = null;
		return $this;
	}

	public function options($options) {
		$input = $this->getLastField();
		$class_name = substr(get_class($input), strrpos(get_class($input), '\\') + 1);
		
		if ($class_name != "Select") {
			throw new FormException("You can't set options on another input than select.");
		}
		$input->options = $options;
		return $this;
	}

	/**
	 * Renvoie le dernier élément du tableau fields
	 * @return this
	 */
	private function getLastField() {
		return end($this->fields);
	}

	/**
	 * Ajouter un bouton submit
	 * @param  string $message   message du bouton
	 * @param  array  $attributs attributs du bouton
	 */
	public function submit($message, $attributs = []) {
		$this->fields[] = $this->createSubmitButton($message, $attributs);
	}

	/**
	 * Crée le bouton de type submit
	 * @param  string $message   message du bouton
	 * @param  array $attributs attributs du bouton
	 * @return html           bouton en HTML
	 */
	private function createSubmitButton($message, $attributs) {
		$button = "<button type=\"submit\" ";

		foreach ($attributs as $k => $v) {
			$button .= $k . '="' . $v . '" ';
		}
		$button .= ">";
		$button .= $message;
		$button .= "</button>";

		return $button;
	}

	/**
	 * Crée le formulaire, remplis les attributs du formulaire
	 * et affiche les champs
	 */
	public function createForm() {
		$form = '<form ';

		// Attributs du formulaire
		foreach ($this->attributs as $k => $v) {
			$form .= $k . '="' . $v . '" ';
		}

		$form .= '>';

		// Champs du formulaire
		foreach ($this->fields as $input) {
			if (is_object($input)) {
				$form .= $input->render();
			} else {
				$form .= $input;
			}
		}

		$form .= '</form>';

		echo $form;

		// On supprime la session flash POST (pour keepValue())
		if (isset($_SESSION['flash']['POST']) && !empty($_SESSION['flash']['POST'])) {
			Flash::clear('POST');
		}
	}

	/**
	 * Stocker l'url de la route donnée
	 * @param string nom de la route
	 * @param array paramètres de la route
	 */
	private function setRouteName($route_name, $route_name_params) {
		$this->attributs['action'] = Router::url($route_name, $route_name_params);
		return $this;
	}

	/**
	 * Modifier la méthode du formulaire (GET, POST, ...)
	 * @param string methode
	 */
	public function setMethod($method) {
		$this->attributs['method'] = $method;
		return $this;
	}

	/**
	 * Modifier si le formulaire a besoin d'un enctype
	 */
	public function setEnctype() {
		$this->attributs['enctype'] = "multipart/form-data";
		return $this;
	}

}