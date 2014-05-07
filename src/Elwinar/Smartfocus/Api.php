<?php namespace Elwinar\Smartfocus;

use PestXML;

/**
 * @brief Elwinar\Smartfocus\Api is a generic interface for SmartFocus REST APIs, providing common methods available for each API.
 */
abstract class Api {

	protected $client;
	protected $services = [];
	
	/**
	 * @brief Initialize a new SmartFocus REST API with the given url as base url
	 * @param[in] url the base url of the api
	 */
	public function __construct($url = null) {
		$this->client = new PestXML($url);
		$this->client->throw_exceptions = false;
	}
	
	public function __get($name) {
		return $this->services[$name];
	}
}

?>