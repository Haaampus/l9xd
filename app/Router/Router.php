<?php 

namespace App\Router;

/**
 * Gère les routes de notre application
 */
class Router {

	/**
	 * Url passé en paramètre
	 * @var string
	 */
	private static $url;

	/**
	 * Tableau contenant toutes les routes de notre application (GET, POST, ...)
	 * @var array
	 */
	private static $routes = [];

	/**
	 * Routes portant un nom
	 * @var array
	 */
	private static $namedRoutes = [];

	/**
	 * Initialisation de la classe router
	 * @return void
	 */
	public static function init() {
		self::$url = $_GET['url'];
	}

	/**
	 * Renvoie une page en GET
	 * @param  string
	 * @param  function
	 * @return route
	 */
	public static function get($path, $callable, $name = null) {
		return self::add($path, $callable, $name, 'GET');
	}

	/**
	 * Renvoie une page en POST
	 * @param  string
	 * @param  function
	 * @return route
	 */
	public static function post($path, $callable, $name = null) {
		return self::add($path, $callable, $name, 'POST');
	}

	/**
	 * Ajouter une route à notre router
	 * @param string
	 * @param function
	 * @param string 'GET, POST, ...'
	 */
	private static function add($path, $callable, $name, $method) {
		$route = new Route($path, $callable);
		self::$routes[$method][] = $route;

		if ($name) {
			self::$namedRoutes[$name] = $route;
		}

		return $route;
	}

	/**
	 * Lance le routing
	 * @return function
	 */
	public static function run() {
		if (!isset(self::$routes[$_SERVER['REQUEST_METHOD']])) {
			throw new RouterException('REQUEST_METHOD doesn\'t exist');
		}

		foreach(self::$routes[$_SERVER['REQUEST_METHOD']] as $route) {
			if ($route->match(self::$url)) {
				return $route->call();
			}
		}
		throw new RouterException('No matching routes');
	}

	/**
	 * Retourne l'URL d'une route nommée
	 * @param  string
	 * @param  array
	 * @return string
	 */
	public static function url($name, $params = []) {
		if (!isset(self::$namedRoutes[$name])) {
			throw new RouterException("No routes matches this name '$name'.");
		}

		return self::$namedRoutes[$name]->getUrl($params);
	}

}