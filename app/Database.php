<?php

namespace App;
use App\Config;
use \PDO;
use \PDOException;

/**
 * Manage everything for the database (insert, update etc..)
 */
class Database {

	// Modify your connections informations
	private $host = Config::HOST;
	private $user = Config::USER;
	private $password = Config::PASSWORD;
	private $db_name = Config::DB_NAME;

	private $pdo;
	private static $last_insert_id;

	public function __construct() {
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8';
		
		try {
			$this->pdo = new PDO($dsn, $this->user, $this->password);
		} catch(PDOException $e) {
			die($e->getMessage());
		}

		$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		
		// Remove in production
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}

	public function getPDO() {
		return $this->pdo;
	}

	/**
	 * Return one row with the statement (SELECT * FROM table) and args
	 * Example : ->fetch("SELECT * FROM orders WHERE id = ?", ['AA123'])
	 * @param type $statement 
	 * @param type|array $args 
	 * @return type
	 */
	public function fetch($statement, $args = []) {
		if (!empty($args)) {
			$req = $this->getPDO()->prepare($statement);
			$req->execute($args);
		} else {
			$req = $this->getPDO()->query($statement);
		}

		$datas = $req->fetch();

		return $datas;
	}

	/**
	 * Return each rows with the statement (SELECT * FROM table) and args
	 * Example : ->fetchAll("SELECT * FROM orders WHERE status = ?", [1])
	 * @param type $statement 
	 * @param type|array $args 
	 * @return type
	 */
	public function fetchAll($statement, $args = []) {
		if (!empty($args)) {
			$req = $this->getPDO()->prepare($statement);
			$req->execute($args);
		} else {
			$req = $this->getPDO()->query($statement);
		}

		$datas = $req->fetchAll();

		return $datas;
	}

	/**
	 * Return 1 if it exist, 0 if not
	 * Example : ->rowCount("SELECT username, password FROM users WHERE username = ? AND password = ?", ['toto', 'lolo'])
	 * @param type $statement 
	 * @param type|array $args 
	 * @return type
	 */
	public function rowCount($statement, $args = []) {
		if (!empty($args)) {
			$req = $this->getPDO()->prepare($statement);
			$req->execute($args);
		} else {
			$req = $this->getPDO()->query($statement);
		}

		$datas = $req->rowCount();

		return $datas;
	}

	private function backtick($key) {
		return "`".str_replace("`","``",$key)."`";
	}

	private function doubleQuote($key) {
		return '"'.str_replace('"', '""', $key).'"';
	}

	/**
	 * Insert in a table
	 * Example : ->insert('orders', ['id' => 'AA123', 'game' => 'League Of Legends'])
	 * @param type $table 
	 * @param type|array $datas 
	 * @return type
	 */
	public function insert($table, $datas = []) {
		$table = $this->backtick($table);
		$fields = [];
		$placeholders = [];

		foreach($datas as $key => $value) {
			$fields[] = $this->backtick($key);
			$placeholders[] = '?';
		}

		$fields = implode($fields, ',');
		$placeholders = implode($placeholders, ',');
		$req = "INSERT INTO $table ($fields) VALUES ($placeholders)";
		$stmt = $this->getPDO()->prepare($req);
		$stmt->execute(array_values($datas));

		static::$last_insert_id = $this->getPDO()->lastInsertID();
	}

	/**
	 * Update in a table
	 * Example : ->update('orders', 'AA123', 'id', ['status' => 1, 'finished' => 1])
	 * @param type $table 
	 * @param type $id 
	 * @param type $field 
	 * @param type|array $datas 
	 * @return type
	 */
	public function update($table, $id, $field, $datas = []) {
	    $table = $this->backtick($table);
		$fields = [];

		if(!is_int($id)) {
			$id = $this->doubleQuote($id);
		}

		foreach($datas as $key => $value) {
			$fields[] = $key . ' = ?';
		}

		$fields = implode($fields, ', ');
		$req = "UPDATE $table SET $fields WHERE $field = $id";
		$stmt = $this->getPDO()->prepare($req);
		$stmt->execute(array_values($datas));
	}

	/**
	 * Delete row in a table
	 * Example : ->delete('boosters', 'id', 8)
	 * @param type $table 
	 * @param type $field 
	 * @param type $id 
	 * @return type
	 */
	public function delete($table, $field, $id) {
		$table = $this->backtick($table);
		$field = $this->backtick($field);

		if(!is_int($id)) {
			$id = $this->doubleQuote($id);
		}

		$req = "DELETE FROM $table WHERE $field=$id";
		$this->getPDO()->query($req);
	}

	/**
	 * Return the ID of the last insertion in the database (insert)
	 * @return type
	 */
	public function getLastInsertID() {
		return static::$last_insert_id;
	}

}