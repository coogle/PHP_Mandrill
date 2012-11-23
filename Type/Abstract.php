<?php

require_once 'Zend/Http/Client.php';

abstract class Mandrill_Type_Abstract
{
	static protected $_httpClient;
	
	static public function setHttpClient(Zend_Http_Client $client) 
	{
		static::$_httpClient = $client;	
	} 
	
	static public  function getHttpClient() {
		if(is_null(static::$_httpClient)) {
			static::$_httpClient = new Zend_Http_Client();
		}
		
		return static::$_httpClient;
	}
}