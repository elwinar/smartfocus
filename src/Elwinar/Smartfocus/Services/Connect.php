<?php namespace Elwinar\Smartfocus;

/**
 * @brief The connect service handle the connection to the SmartFocus APIs and the resulting token to pass to calls.
 */
class ConnectService extends Service {

	protected $token = null;
	
	/**
	 * @brief Open a connection to the SmartFocus REST API.
	 * @param[in] login the login of the customer account
	 * @param[in] password the password of the customer account
	 * @param[in] key the api key of the customer account
	 * @return true if the connection is opened, the error code if not
	 */
	public function open($login, $password, $key) {
		if($this->token !== null) {
			$this->close();
		}
		$response = $this->api->client->get($this->base.'/open/'.$login.'/'.$password.'/'.$key);
		if($response['responseStatus'] == 'success') {
			$this->token = $response->result;
			return true;
		}
		$this->token = null;
		return $response->status;
	}
	
	public function token() {
		return $this->token;
	}
	
	/**
	 * @brief Close the connection to the SmartFocus REST API.
	 * @return true if the connection is closed, the error code if not
	 */
	public function close() {
		if($this->token === null) {
			return true;
		}
		$response = $this->client->get($this->base.'/close/'.$this->token);
		if($response['responseStatus'] == 'success') {
			$this->token = null;
			return true;
		}
		return $response->status;
	}
}

?>