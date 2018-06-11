<?php

namespace App\Library\Template;

/**
 * Moteur de template en PHP
 */
class Template {

	/**
	 * Répertoire où sont les vues
	 * @var string chemin au vues
	 */
	private $viewsFolder = 'app/Views/';

	/**
	 * Le template utilisé
	 * @var string chemin au template
	 */
	private $template;

	/**
	 * Les variables du template
	 * @var array variables
	 */
	private $fields = [];

	/**
	 * Instanciation du template
	 * @param string $template chemin du template
	 * @param array  $fields   variables du template à saisir ici (par ex: titre etc...)
	 */
	public function __construct($template, $fields = []) {
		$this->setTemplate($template);

		if (!empty($fields)) {
			foreach ($fields as $name => $value) {
				$this->$name = $value;
			}
		}
	}

	/**
	 * On crée le template
	 * @param string $template chemin du template
	 */
	private function setTemplate($template) {
		$template = $this->viewsFolder . str_replace('.', '/', $template) . ".php";
		if (!is_file($template) || !is_readable($template)) {
			throw new TemplateException("The template $template is invalid.");
		}
		$this->template = $template;
	}

	/**
	 * Récupérer le chemin du template
	 * @return string chemin du template
	 */
	private function getTemplate() {
		return $this->template;
	}

	public function __set($name, $value) {
		$this->fields[$name] = $value;
	}

	public function __get($name) {
		if (!isset($this->fields[$name])) {
			throw new TemplateException("Unable to get the field" . $this->fields[$name]); 
		}
		$field = $this->fields[$name];
		return $field instanceof Closure ? $field($this) : $field;
	}

	public function __isset($name) {
		return isset($this->fields[$name]);
	}

	public function __unset($name) {
		if (!isset($this->fields[$name])) {
			throw new TemplateException("Unable to unset the field" . $this->fields[$name]);
		}
		unset($this->fields[$name]);
	}

	public function render() {
		extract($this->fields);
		ob_start();
		require_once($this->getTemplate());
		return ob_get_clean();
	}

	/**
	 * Commencer l'enregistrement des prochaines ligne de code
	 * pour la variable de template $field
	 * @param  string $field variable à changer
	 */
	public function start($field) {
		$this->fields[$field] = null;
		ob_start();
	}

	/**
	 * On stop l'enregistrement et on change la variable de template
	 * saisis dans start par ce que l'on a enregistrer
	 */
	public function stop() {
		end($this->fields);
		$field = key($this->fields);

		$output = ob_get_contents();
		$this->fields[$field] = $output;
		ob_end_clean();
	}

}