<?php 

namespace App\Repository;
use App\Database;

/**
 * Classe globale pour gérer des données de la
 * base de données
 */
abstract class Repository {

	/**
	 * Toutes les instances
	 * @var array instances
	 */
	protected static $instances = [];

	/**
	 * Instance de l'objet PDO, permet d'effecuter des requêtes en base grâce
	 * à une classe Database
	 * @var Database instance
	 */
	protected static $pdo;

	/**
	 * Table de la base de données
	 * @var string table
	 */
	protected $table;

	abstract protected function __construct();

	/**
	 * Création de l'instance et on retourne l'instance pour
	 * enchainer les méthodes des classes enfants
	 * @return ClassRepository
	 */
	public static function getInstance() {
		self::$pdo = new Database();
		$class = get_called_class();
        if (! array_key_exists($class, self::$instances)) {
            self::$instances[$class] = new $class();
        }
        return self::$instances[$class];
	}

}