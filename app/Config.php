<?php 

namespace App;

/**
 * Classe de configuration, ici seront stockés toutes les constantes de l'application
 */
class Config {

    // Global Config
    const PRODUCTION = true;

	// Paypal Config
	// Create new REST API in PayPal developer, set it to live, and change those constants
	// https://github.com/paypal/PayPal-PHP-SDK/wiki/Going-Live
	const CLIENT_ID = "";
	const SECRET = "";

	// Website Config
	const WEBSITE_NAME = "domain";
	const WEBSITE_EXT  = ".tld";
	const URL          = self::WEBSITE_NAME . self::WEBSITE_EXT;

	// RIOT API
	const API_KEY = "";

	// MAIL SETTINGS
	const SMTP = ""; // Local
	const SMTP_PORT = 465; // Local
	const SMTP_USERNAME = ""; // Local
	const SMTP_PASSWORD = ""; // Local
	const SET_FROM = "noreply@" . self::URL;
	const YOUR_EMAIL = "boosting@gmail.com";

	// URLS
	const CUSTOMER     = "/customer";
	const BOOSTER      = "/booster";
	const ADMIN        = "/admin";

	// Database Config
	const HOST         = "localhost";
	const USER         = "";
	const PASSWORD     = "";
	const DB_NAME      = "";

	// Boost Config
	const SERVERS      = [
        'NA',
	    'EUW',
		'EUNE',
        'OCE',
        'LAN',
        'TR',
        'RUS',
        'LAS',
	];

}