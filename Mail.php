<?php

require_once 'Mandrill/Message/Type.php';
require_once 'Mandrill/Mail/Transport.php';
require_once 'Zend/Mail.php';

class Mandrill_Mail extends \Zend_Mail
{
	protected $_apiKey = null;
	protected $_privateVars = array();
	protected $_globalVars = array();
	protected $_template = null;

	protected $_mandrillFrom = null;
	protected $_mandrillTo = array();
	
	public function setFrom($email, $name = null)
	{
		$this->_mandrillFrom = array(
			'email' => $email,
			'name' => $name
		);
		
		return parent::setFrom($email, $name);
	}
	
	public function addTo($email, $name = null)
	{
		$found = false;
		foreach($this->_mandrillTo as $to) {
			if($to['email'] == $email) {
				$found = true;
				break;
			} 
		}
		
		if(!$found) {
			$this->_mandrillTo[] = array(
				'email' => $email,
				'name' => $name
			);
		}
		
		return parent::addTo($email, $name);
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
	
	public function setTemplate($template) 
	{ 
		$this->_template = $template;
		return $this;
	}
	
	public function getTemplate()
	{
		return $this->_template;
	}
	
	protected function unsetPrivateVar($name, $recipient) {
		if(isset($this->_privateVars[$recipient][$name])) {
			unset($this->_privateVars[$recipient][$name]);
		}
	
		if(empty($this->_privateVars[$recipient])) {
			unset($this->_prviateVars[$recipient]);
		}
	}
	
	public function setPrivateVariable($varName, $value, $recipient = null)
	{
		if(is_null($recipient)) {
				
			if(!empty($this->_to) && is_array($this->_to)) {
				foreach($this->_to as $to) {
					if(!isset($this->_privateVars[$to['email']])) {
						$this->_privateVars[$to['email']] = array();
					}
						
					if(is_null($value)) {
						$this->unsetPrivateVar($varName, $to['email']);
					} else {
						$this->_privateVars[$to['email']][$varName] = $value;
					}
				}
			}
				
		} else {
				
			if(!isset($this->_privateVars[$recipient])) {
				$this->_privateVars[$recipient] = array();
			}
				
			if(is_null($value)) {
				$this->unsetPrivateVar($name, $recipient);
			} else {
				$this->_privateVars[$recipient][$varName] = $value;
			}
				
		}
	
		return $this;
	}
	
	public function setGlobalVariable($name, $value)
	{
		if(is_null($value)) {
			if(isset($this->_globalVars[$name])) {
				unset($this->_globalVars[$name]);
			}
				
		} else {
			$this->_globalVars[$name] = $value;
		}
	
		return $this;
	}
	
	public function unsetGlobalVariable($name)
	{
		return $this->setGlobalVariable($name, null);
	}
	
	public function sendTemplate($template = null, $transport = null)
	{
		if(is_null($template) && is_null($this->_template)) {
			throw new \InvalidArgumentException("You must provide a template name");
		}
		
		if(!is_null($template)) {
			$this->setTemplate($template);
		}
		
		if(is_null($this->_apiKey)) {
			throw new \InvalidArgumentException("You must specify an API Key");
		}
		
		$message = new \Mandrill_Message_Type();
		$message->setFrom($this->_mandrillFrom['email'], $this->_mandrillFrom['name']);
		$message->setSubject($this->getSubject());
		$message->setApiKey($this->getApiKey());
		
		foreach($this->_privateVars as $target => $vars) {
			if(is_array($vars)) {
				foreach($vars as $key => $val) {
					$message->addMergeData($target, $key, $val);
				}
			}
		}
		
		foreach($this->_globalVars as $key => $val) {
			$message->addGlobalMergeVar($key, $val);
		}
		
		foreach($this->_mandrillTo as $to) {
			$message->addTo($to['email'], $to['name']);
		}
		
		if(!is_null($transport)) {
			$content = "Template: {$this->_template}\n\n";
			$content .= var_export($message, true);
			$this->setBodyText($content);
		} else {
			$transport = new Mandril_Mail_Transport();
			$transport->setMessage($message);
			$transport->setTemplate($this->getTemplate());
			$transport->setApiKey($this->getApiKey());
		}
		
		return $this->send($transport);
	}
}