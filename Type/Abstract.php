<?php

require_once 'Zend/Http/Client.php';

abstract class Mandrill_Type_Abstract
{
	const BASE_API_URL = "https://mandrillapp.com/api/1.0";
	
	static protected $_httpClient;
	
	protected $_apiKey;
	protected $_async;
	
	function __construct($apiKey, $async = true) {
		$this->_apiKey = $apiKey;
		$this->_async = (boolean)$async;
	}
	
	public function getApiKey() {
		return $this->_apiKey;
	} 

	public function isAsync() {
		return (boolean)$this->_async;
	}
	
	static public function setHttpClient(Zend_Http_Client $client) 
	{
		static::$_httpClient = $client;	
	} 
	
	/**
	 * Return an instance of the Zend_Http_Client
	 * 
	 * @return Zend_Http_Client
	 */
	static public  function getHttpClient() {
		if(is_null(static::$_httpClient)) {
			static::$_httpClient = new Zend_Http_Client();
			static::$_httpClient->setMethod('POST');
		}
		
		return static::$_httpClient;
	}
	
	protected function _request($path, array $request) {
		
		$requestUri = static::BASE_API_URL . "$path";
		
		$client = static::getHttpClient();
		
		$client->setUri($requestUri);
		
		
		$requestDataJson = json_encode($request);
		
		$client->setHeaders("Content-Type", "application/json");
		
		$client->setRawData($requestDataJson);
		
		$response = $client->request();
		
		$answer = json_decode($response->getBody(), true);
		if($response->getStatus() != 200) {
			throw new \Exception("Request Failed: {$answer['message']}");
		}
		
		return true;
	}
}