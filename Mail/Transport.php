<?php

require_once 'Mandrill/Mandrill.php';
require_once 'Mandrill/Message/Type.php';
require_once 'Zend/Mail/Transport/Abstract.php';

class Mandril_Mail_Transport extends \Zend_Mail_Transport_Abstract
{
	protected $_message = null;
	protected $_apiKey = null;

	protected function _sendMail()
	{
		// ...
	}
	
	public function send(Zend_Mail $mail) 
	{
		$mandrill = new \Mandrill($this->getApiKey());
		return $mandrill->messages()->sendTemplate($this->getTemplate(), $this->getMessage());
	}
	
	public function setApiKey($key)
	{
		$this->_apiKey = $key;
		return $this;
	}
	
	public function getApiKey()
	{
		return $this->_apiKey;
	}
	
	public function setTemplate($template) {
		$this->_template = $template;
	}
	
	public function getTemplate() {
		return $this->_template;
	}
	
	public function setMessage(\Mandrill_Message_Type $message) 
	{
		$this->_message = $message;
	}
	
	public function getMessage()
	{
		return $this->_message;
	}
}

