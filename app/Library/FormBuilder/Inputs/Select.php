<?php

namespace App\Library\FormBuilder\Inputs;
use App\Library\FormBuilder\FormInput;

/**
 * Champ de type select
 */
class Select extends FormInput {

	/**
	 * Les options du select 
	 * clé : Value
	 * value : Message
	 * @var array options
	 */
	public $options;

	/**
	 * Surcharge de la fonction render pour afficher le champ
	 * @return html
	 */
	public function render() {
		if ($this->field_label) {
			return $this->createLabelSelect();
		} else {
			return $this->createSelect();
		}
	}

	/**
	 * Crée un select avec label
	 * @return html select avec label html
	 */
	private function createLabelSelect() {
		$select = "<label>$this->field_label_value</label>";
		$select .= $this->htmlSelect();
		return $select;
	}

	/**
	 * Crée un select sans label
	 * @return html select html
	 */
	private function createSelect() {
		return $this->htmlSelect();
	}

	/**
	 * Renvoie le select en HTML
	 * @return html
	 */
	private function htmlSelect() {
		$select = "<select ";

		foreach ($this->attributs as $k => $v) {
			$select .= $this->renderAttribute($k, $v);
		}
		$select .= '>'; 

		foreach ($this->options as $k => $v) {
			$select .= '<option value="';
			$select .= $k;
			$select .= '">';
			$select .= $v . '</option>';
		}

		$select .= '</select>';

		return $select;
	}

}