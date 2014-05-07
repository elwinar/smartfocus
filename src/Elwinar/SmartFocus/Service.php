<?php namespace Elwinar\SmartFocus;

/**
 * @brief Elwinar\SmartFocus\Service is a generic interface for SmartFocus REST Services, providing common methods available for each Service.
 */
abstract class Service {
	
	protected $api = null;
	protected $base = '';

	/**
	 * @brief Initialize a new SmartFocus REST Service.
	 * @param[in] api the api for which the service is initialized.
	 */
	public function __construct(&$api, $base) {
		$this->api = $api;
		$this->base = 'services/rest/'.$base;
	}
}

?>