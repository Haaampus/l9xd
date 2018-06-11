<?php 

namespace App\Router;

/**
 * Une route
 */
class Route {

	/**
	 * Chemin de la route
	 * @var string
	 */
	private $path;

	/**
	 * Fonction anonyme
	 * @var function
	 */
	private $callable;

	/**
	 * Correspondances avec une route du router
	 * @var array
	 */
	private $matches = [];

	/**
	 * Paramètres de la route
	 * @var array
	 */
	private $params = [];

	/**
	 * @param string
	 * @param function
	 */
	public function __construct($path, $callable) {
		$this->path = trim($path, '/');
		$this->callable = $callable;
	}

	/**
	 * Permet d'ajouter des conditions à la route
	 * @param  param paramètre où faire la condition
	 * @param  regex expression régulière
	 * @return route
	 */
	public function with($param, $regex) {
		$this->params[$param] = str_replace('(', '(?:', $regex);
		return $this;
	}

	/**
	 * On check si la route match l'url
	 * @param  url
	 * @return boolean
	 */
	public function match($url) {
		$url = trim($url, '/');
		$path = preg_replace_callback('#{([\w]+)}#', [$this, 'paramMatch'], $this->path);
		$regex = "#^$path$#i";

		if (!preg_match($regex, $url, $matches)) {
			return false;
		}

		array_shift($matches);
		$this->matches = $matches;

		return true;
	}

	/**
	 * On teste si le paramètre "match" avec ce qu'on a dans $this->params
	 * @param  match
	 * @return regex
	 */
	private function paramMatch($match) {
		if (isset($this->params[$match[1]])) {
			return '(' . $this->params[$match[1]] . ')';
		}

		return '([^/]+)';
	}

	/**
	 * On appelle la fonction passé en paramètre pour la route (controller ou anonyme)
	 * @return function
	 */
	public function call() {
		if (is_string($this->callable)) {
			$params = explode('@', $this->callable);
			$controller = "App\\Controller\\" . $params[0];

			$controller = new $controller();
			
			return call_user_func_array([$controller, $params[1]], $this->matches);
		} else {
			return call_user_func_array($this->callable, $this->matches);
		}
	}

	/**
	 * Retourne l'URL de la route avec les paramètres donnés
	 * @param  array
	 * @return string
	 */
	public function getUrl($params) {
		$path = $this->path;
		foreach($params as $k => $v) {
			$path = str_replace("{" . $k . "}", $v, $path);
		}

		if (isset($_SERVER['HTTPS'])) {
			return 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $path;
		}
		
		return 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $path;
	} 

}