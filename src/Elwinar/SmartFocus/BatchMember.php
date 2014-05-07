<?php namespace Elwinar\SmartFocus;

use Elwinar\SmartFocus\Services\Connect as ConnectService;
use Elwinar\SmartFocus\Services\BatchMember as BatchMemberService;
use SimpleXMLElement;

/**
 * @brief The SmartFocus BatchMember API
 */
class BatchMember extends Api {

	/**
	 * @brief Initialize a new instance of the api.
	 * @param[in] server the name of the server which hosts the api
	 */
	public function __construct($server) {
		parent::__construct('https://'.$server.'/apibatchmember/');
		$this->services['connect'] = new ConnectService($this, 'connect');
		$this->services['batchmember'] = new BatchMemberService($this, 'batchmemberservice');
	}
	
}

?>