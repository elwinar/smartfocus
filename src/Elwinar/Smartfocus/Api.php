<?php namespace Elwinar\Smartfocus;

use PestXML;

/**
 * @brief EmailVision\Rest\Api is a generic interface for EmailVision Rest APIs, providing common methods available for each API. End-user shouldn't use this directly, but use and extended class instead.
 */
class Api {

	protected $client;
	protected $token = null;
	
	/**
	 * @brief Initialize a new EmailVision Rest API with the given url as base url
	 * @param[in] url the base url of the api
	 */
	public function __construct($url) {
		$this->client = new PestXML($url);
		$this->client->throw_exceptions = false;
	}
	
	/**
	 * @brief Open a connection to the EmailVision Rest API.
	 * @param[in] login the login of the customer account
	 * @param[in] password the password of the customer account
	 * @param[in] key the api key of the customer account
	 * @return true if the connection is opened, the error code if not
	 */
	public function open($login, $password, $key) {
		if($this->token !== null) {
			return 'LIB_ALREADY_CONNECTED';
		}
		$response = $this->client->get("/connect/open/{$login}/{$password}/{$key}");
		if($response['responseStatus'] == 'success') {
			$this->token = $response->result;
			return true;
		}
		$this->token = null;
		return $response->status;
	}
	
	/**
	 * @brief Close the connection to the EmailVision Rest API.
	 * @return true if the connection is closed, the error code if not
	 */
	public function close() {
		if($this->token === null) {
			return true;
		}
		$response = $this->client->get("/connect/close/{$this->token}");
		if($response['responseStatus'] == 'success') {
			$this->token = null;
			return true;
		}
		return $response->status;
	}
}

?>