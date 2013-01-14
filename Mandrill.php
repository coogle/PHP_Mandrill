<?php

require_once 'Mandrill/Type/Messages.php';

class Mandrill
{
	protected $_apiKey;
	
	function __construct($apiKey)
	{
		$this->setApiKey($apiKey);
	}
	
	public function messages() {
		return new \Mandrill_Type_Messages($this->getApiKey());
	}
	
	public function setApiKey($key) {
		$this->_apiKey = $key;
		return $this;
	}
	
	public function getApiKey() {
		return $this->_apiKey;
	}
}