<?php

require_once 'Mandrill/Message/Type.php';
require_once 'Mandrill/Type/Abstract.php';

class Mandrill_Type_Messages extends Mandrill_Type_Abstract
{
	
	public function sendTemplate($template, Mandrill_Message_Type $message, array $content = array())
	{
		$template_content = array();
		
		foreach($content as $key => $val) {
			$template_content[] = array(
				'name' => (string)$key,
				'content' => (string)$val
			);
		}
		
		$message->setApiKey($this->getApiKey());
		
		$request = array(
			'key' => $this->getApiKey(),
			'template_name' => (string)$template,
			'template_content' => $template_content,
			'async' => $this->isAsync(),
			'message' => $message->toArray()
		);
		return $this->_request("/messages/send-template.json", $request);
	}
	
	public function search()
	{
		
	}
	
	public function parse()
	{
		
	}
	
	public function sendRaw()
	{
		
	}
	
}