<?php

namespace App\Library\FormBuilder\Inputs;
use App\Library\FormBuilder\FormInput;

/**
 * Champ de type textarea
 */
class Textarea extends FormInput {

	/**
	 * Surcharge de la fonction render pour afficher le champ
	 * @return html
	 */
	public function render() {
		if ($this->field_label) {
			return $this->createLabelTextarea();
		} else {
			return $this->createTextarea();
		}
	}

	/**
	 * Crée un textarea avec label
	 * @return html textarea avec label html
	 */
	private function createLabelTextarea() {
		$textarea = "<label>$this->field_label_value</label>";
		$textarea .= $this->htmlTextarea();
		return $textarea;
	}

	/**
	 * Crée un textarea sans label
	 * @return html textarea html
	 */
	private function createTextarea() {
		return $this->htmlTextarea();
	}

	/**
	 * Renvoie le textarea en HTML
	 * @return html
	 */
	private function htmlTextarea() {
		$textarea = "<textarea ";

		foreach ($this->attributs as $k => $v) {
			$textarea .= $this->renderAttribute($k, $v);
		}
		$textarea .= '></textarea>';

		return $textarea;
	}

}