<?php namespace Elwinar\Smartfocus;

use SimpleXMLElement;

/**
 * @brief The SmartFocus BatchMemberApi
 */
class BatchMember extends Service {
	
	/**
	 * @brief Upload a file and merge its content with the current members table
	 * @param[in] file the content of the file in plain text
	 * @param[in] parameters an array containing values to configure the API call
	 * // TODO Complete the parameters description
	 */
	public function mergeUpload($file, $parameters = array()) {
		// TODO Check parameters values before using them
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><mergeUpload></mergeUpload>');
		
		if(isset($parameters['name'])) {
			$xml->addChild('fileName', $parameters['name']);
		}
		
		if(isset($parameters['separator'])) {
			$xml->addChild('separator', $parameters['separator']);
		} else {
			// TODO Could do something fancy here, like automatically guessing the used separator by parsing the first/second lines of the file
			$xml->addChild('separator', ',');
		}
		
		if(isset($parameters['encoding'])) {
			$xml->addChild('fileEncoding', $parameters['encoding']);
		}
		
		if(isset($parameters['skipFirstLine'])) {
			$xml->addChild('skipFirstLine', $parameters['skipFirstLine']);
		}
		
		if(isset($parameters['dateFormat'])) {
			$xml->addChild('dateFormat', $parameters['dateFormat']);
		}
		
		if(isset($parameters['criteria'])) {
			$xml->addChild('criteria', $parameters['criteria']);
		}
		
		$mapping = $xml->addChild('mapping');
		foreach($parameters['columns'] as $c) {
			$column = $mapping->addChild('column');
			$column->addChild('colNum', $c['number']);
			$column->addChild('fieldName', $c['field']);
			if(isset($c['replace'])) {
				$column->addChild('toReplace', $c['replace']);
			}
			if(isset($c['dateFormat'])) {
				$column->addChild('dateFormat', $c['dateFormat']);
			}
			if(isset($c['defaultValue'])) {
				$column->addChild('defaultValue', $c['default']);
			}
		}
		
		$boundary = md5(time());
		$separator = '--'.$boundary;
		$eol = "\r\n";

		$payload = $separator.$eol;
		$payload .= 'Content-Disposition: form-data; name="mergeUpload";'.$eol;
		$payload .= 'Content-Type: text/xml'.$eol.$eol;
		$payload .= $xml->asXML();
		$payload .= $separator.$eol;
		$payload .= 'Content-Disposition: form-data; name="inputStream";'.$eol;
		$payload .= 'filename="'.$parameters['name'].'"'.$eol;
		$payload .= 'Content-Type: application/octet-stream'.$eol;
		$payload .= 'Content-Transfer-Encoding: base64'.$eol.$eol;
		$payload .= base64_encode($file).PHP_EOL;
		$payload .= $separator.$eol;
		
		return new Response($this->client->put($this->base.'/'.$this->api->connect->token().'/batchmember/mergeUpload', $payload, array(
			'Content-Type: multipart/form-data; boundary='.$boundary,
		)));
	}
	
}

?>