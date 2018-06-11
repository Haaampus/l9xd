<?php

namespace App\Library\FormBuilder;
use App\Library\Session\Flash;

/**
 * Formulaire bootstrap, objet qui permet de définir comment les champs
 * seront stylisés avec les normes bootstrap
 * Ce formulaire gère les erreurs renvoyé grâce à Validator
 */
class FormBootstrap extends FormBuilder {

	private $errors_class = [
		'input' 	   => 'is-invalid',
		'help-text'    => '<div class="help-block">'
	];

	/**
	 * Crée le formulaire, remplis les attributs du formulaire
	 * et affiche les champs
	 * avec BOOTSTRAP
	 */
	public function createForm() {
		$this->bootstrapFields();
		$form = '<form ';

		// Attributs du formulaire
		foreach ($this->attributs as $k => $v) {
			$form .= $k . '="' . $v . '" ';
		}

		$form .= '>';

		// Champs du formulaire
		foreach ($this->fields as $input) {
			if (is_object($input)) {
				if (!$this->isValid($input->attributs['name'])) {
					$form .= '<div class="form-group has-error">';
				} else {
					$form .= '<div class="form-group">';
				}
				$form .= $input->render();

				// S'il y a une erreur, on ajoute une classe au champ,
				// et on ajoute une div pour savoir où est l'erreur
				if (!$this->isValid($input->attributs['name'])) {
					$form .= $this->getHelpText($this->errors[$input->attributs['name']]);
				}

				$form .= '</div>';
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
	 * Changer le classe des champs par form-control pour
	 * correspondre à la norme bootstrap
	 */
	private function bootstrapFields() {
		foreach($this->fields as $input) {
			if (is_object($input)) {
				if (isset($input->attributs['class'])) {
					$input->attributs['class'] .= " " . 'form-control';
				} else {
					$input->attributs['class'] = 'form-control';
				}
			}
		}
	}

	private function getHelpText($message) {
		$helptext = $this->errors_class['help-text'];
		$helptext .= $message;
		$helptext .= "</div>";
		return $helptext;
	}

	private function isValid($input_name) {
		if (!empty($this->errors)) {
			foreach ($this->errors as $k => $v) {
				if ($k == $input_name) {
					return false;
				}
			}

			return true;
		} else {
			return true;
		}
	}

}