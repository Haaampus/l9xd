<?php

namespace App\Library\Validator;
use App\Library\Session\Flash;
use App\Database;

/**
 * Permet de valider des données
 */
class Validator {

	/**
	 * Tableau contenant les erreurs indexés par le nom du champ
	 * @var array erreurs
	 */
	public static $errors = [];

	/**
	 * Tableau contenant les données postées du formulaire
	 * @var array données postées
	 */ 
	private static $data;

	/**
	 * Valide le formulaire
	 * @param  array données du formulaire
	 * @param  array conditions du formulaire
	 * @return boolean valider ou non 
	 */
	public static function validate($data, $conditions) {
		if (sizeof(array_intersect_key($data, $conditions)) != sizeof($conditions)) {
			throw new ValidatorException("No matching keys in posted data");
		} 
		self::$data = $data;
		$is_valid = true;

		foreach ($conditions as $input => $conds) {
			$conds = explode('|', $conds);

			foreach ($conds as $condition) {
				if (strpos($condition, ':')) {
					$cond = explode(':', $condition);

					if (strpos($cond[1], ',')) {
						$action = $cond[0];

						$variables = explode(',', $cond[1]);
						
						if (!self::$action($input, $data[$input], $variables[0], $variables[1])) {
							$is_valid = false;
						}
					} else {
						$action = $cond[0];

						if (!self::$action($input, $data[$input], $cond[1])) {
							$is_valid = false;
						}
					}
				} else {
					if (!self::$condition($input, $data[$input])) {
						$is_valid = false;
					}
				}
			}
		}

		// Renvoyer le tableau d'erreurs
		if (!$is_valid) {
			new Flash('errors', self::$errors);
		}

		return $is_valid;
	}

	/**
	 * Création d'une erreur
	 * @param  string message de l'erreur
	 * @param  string nom du champ
	 */
	private static function createError($message, $input) {
		if (!array_key_exists($input, self::$errors)) {
			self::$errors[$input] = $message;
		}
	}

	/**
	 * Valide si le champ a été remplis
	 * @param  string nom du champ
	 * @param  string contenu du champ
	 * @return boolean valide ou pas ?
	 */
	private static function required($input, $input_content) {
		if (empty($input_content)) {
			self::createError("Le champ $input est requis.", $input);
			return false;
		}
		return true;
	}

	/**
	 * Valide si le champ a bien le minimum de caractère indiqués
	 * @param  string nom du champ
	 * @param  string contenu du champ
	 * @param  int longueur
	 * @return boolean valide ou pas ?
	 */
	private static function min($input, $input_content, $length) {
		// Number
		if (is_numeric($input_content)) {
			if ((int)$input_content < $length) {
				self::createError("Le champ $input doit être au minimum de $length.", $input);
				return false;
			}
			return true;
		}

		// String
		$len = strlen($input_content);
		if ($len < $length) {
			self::createError("Le champ $input doit faire minimum $length caractères", $input);
			return false;
		}
		return true;
	}

	/**
	 * Valide si le champ ne dépasse pas le nombre de caractère indiqués
	 * @param  string nom du champ
	 * @param  string contenu du champ
	 * @param  int longueur
	 * @return boolean valide ou pas ?
	 */
	private static function max($input, $input_content, $length) {
		// Number
		if (is_numeric($input_content)) {
			if ((int)$input_content > $length) {
				self::createError("Le champ $input doit être au maximum de $length.", $input);
				return false;
			}
			return true;
		}

		// String
		$len = strlen($input_content);
		if ($len > $length) {
			self::createError("Le champ $input doit faire maximum $length caractères", $input);
			return false;
		}
		return true;
	}

	/**
	 * Valide si le contenu du champ n'existe pas déjà dans la base de données
	 * @param  string $input         nom du champ
	 * @param  string $input_content contenu du champ
	 * @param  string $table         la table
	 * @param  string $column        la colonne de la table
	 * @return boolean               valide ou pas ?
	 */
	private static function unique($input, $input_content, $table, $column) {
		if (!empty($input_content)) {
			$db = new Database();
			if ($db->rowCount("SELECT $column FROM $table WHERE $column = ?", [$input_content])) {
				self::createError("Cette $input est déjà pris.", $input);
				return false;
			}
		}
		return true;
	}

	/**
	 * Valide si le champ ne contient que des lettres
	 * @param  string nom du champ
	 * @param  string contenu du champ
	 * @return boolean valide ou pas ?
	 */
	private static function alpha($input, $input_content) {
		if (empty($input_content)) {
			return true;
		}
		if (!preg_match("/^[A-z]+$/", $input_content)) {
			self::createError("Le champ $input doit contenir seulement des lettres.", $input);
			return false;
		}
		return true;
	}

	/**
	 * Valide si le champ ne contient que des chiffres
	 * @param  string nom du champ
	 * @param  string contenu du champ
	 * @return boolean valide ou pas ?
	 */
	private static function alpha_num($input, $input_content) {
		if (empty($input_content)) {
			return true;
		}
		if (!preg_match("/^[0-9]+$/", $input_content)) {
			self::createError("Le champ $input doit contenir seulement des chiffres.", $input);
			return false;
		}
		return true;
	}

	/**
	 * Valide si le champ correspond à un autre champ
	 * @param  string nom du champ
	 * @param  string contenu du champ
	 * @param  int longueur
	 * @return boolean valide ou pas ?
	 */
	private static function confirmed($input, $input_content, $input_confirmation) {
		if ($input_content != self::$data[$input_confirmation]) {
			self::createError("Le champ $input ne correspond pas au champ $input_confirmation.", $input);
			return false;
		}
		return true;
	}

	/**
	 * Valide si le champ est de type email
	 * @param  string nom du champ
	 * @param  string contenu du champ
	 * @return boolean valide ou pas ?
	 */
	private static function email($input, $input_content) {
		if (!filter_var($input_content, FILTER_VALIDATE_EMAIL)) {
			self::createError("Le champ $input doit être au format email.", $input);
			return false;
		}
		return true;
	}

	/**
	 * Valide si le champ respecte l'expression régulière donnée
	 * @param  string nom du champ
	 * @param  string contenu du champ
	 * @param  int longueur
	 * @return boolean valide ou pas ?
	 */
	private static function regex($input, $input_content, $pattern) {
		if (!preg_match("/$pattern/", $input_content)) {
			self::createError("Le champ $input ne respecte pas le pattern.", $input);
			return false;
		}
		return true;
	}

}