<?php

namespace App\Library\FormBuilder;

/**
 * Classe qui va définir les bases d'un champ
 */
abstract class FormInput {

	/**
	 * Message du label 
	 * @var string
	 */
	public $field_label_value = "";

	/**
	 * Est-ce que le champ doit avoir un label
	 * @var boolean
	 */
	public $field_label = false;

	/**
	 * Paramètres du champ
	 * @var array
	 */
	public $attributs = [];

	/**
	 * Création du champ
	 * @param string $field_name        nom du champ (text, select, ...)
	 * @param boolean $field_label       utilisation d'un label ?
	 * @param string $field_label_value valeur du label 
	 * @param array $field_attributs   paramètres du champ
	 */
	public function __construct($field_name, $field_label, $field_label_value, $field_attributs) {
		$this->attributs['name'] = $field_name;
		if ($field_label) {
			$this->field_label = true;
			$this->attributs['id'] = $field_name;
		}
		if (!empty($field_label_value)) {
			$this->field_label_value = $field_label_value;
		}

		// Si l'attribut existe déjà, on le remplace
		// ou, si l'attribut est la classe, on ajoute la classe
		if (sizeof(array_intersect_key($field_attributs, $this->attributs)) != 0) {
			foreach ($field_attributs as $k => $v) {
				if ($k == $this->attributs[$k]) {
					if ($k == "class") {
						$this->attributs[$k] .= " " . $v;
					} else {
						$this->attributs[$k] = $v;
					}
				}
			}
		} else {
			foreach ($field_attributs as $k => $v) {
				$this->attributs[$k] = $v;
			}
		}
	}

	/**
	 * Crée le champ
	 * @return html retourne le champ en HTML
	 */
	public function render() {
		if ($this->field_label) {
			return $this->createLabelInput();
		} else {
			return $this->createInput();
		}
	}

	/**
	 * Permet d'ajouter une classe à un input
	 * @param string $class_name nom de classe
	 */
	public function addClass($class_name) {
		if (!empty($this->attributs['class'])) {
			$this->attributs['class'] = " " . $class_name;
		} else {
			$this->attributs['class'] = $class_name;
		}
	}

	/**
	 * Crée un champ avec un label
	 * @return html le champ en HTML
	 */
	private function createLabelInput() {
		$input = "<label>$this->field_label_value</label>";
		$input .= "<input ";

		foreach ($this->attributs as $k => $v) {
			$input .= $this->renderAttribute($k, $v);
		}
		$input .= ' />';
		return $input;
	}

	/**
	 * Crée un champ sans label
	 * @return html le champ en HTML
	 */
	private function createInput() {
		$input = "<input ";

		foreach ($this->attributs as $k => $v) {
			$input .= $this->renderAttribute($k, $v);
		}
		$input .= ' />';
		return $input;
	}

	/**
	 * Renvoie les attributs sous forme HTML
	 * @param string $key   clé de l'attribut
	 * @param string $value valeur de la clé
	 */
	protected function renderAttribute($key, $value) {
		return $key . '="' . $value . '" ';
	}

}