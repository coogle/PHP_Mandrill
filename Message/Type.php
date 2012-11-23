<?php 

class Mandrill_Message_Type 
{
	protected $_params = array();
	
	public function setApiKey($key) {
		$this->_params['key'] = (string)$key;
		return $this;
	}
	
	public function setHtmlContent($html) {
		$this->_params['html'] = $html;
		return $this;
	}
	
	public function setTextContent($text) {
		$this->_params['text'] = $text;
		return $this;
	}
	
	public function setSubject($subject) {
		$this->_params['subject'] = $subject;
		return $this;
	}
	
	public function setFrom($email, $name = "Nobody") {
		$this->_params['from_email'] = $email;
		$this->_params['from_name'] = $name;
		return $this;
	}
	
	public function addTo($email, $name = "") {
		if(!isset($this->_params['to'])) {
			$this->_params['to'] = array();
		}
		
		$this->_params['to'][] = array(
			'email' => $email,
			'name' => $name
		);

		return $this;
	}
	
	public function addHeader($name, $val) {
		if(!isset($this->_params['headers'])) {
			$this->_params['headers'] = array();
		}
		
		$this->_params['headers'][] = array(
			$name => $val		
		);
		
		return $this;
	}
	
	public function setOpenTracking($bool) {
		$this->_params['track_opens'] = (boolean)$bool;
		
		return $this;
	}
	
	public function setClickTracking($bool) {
		$this->_params['track_clicks'] = (boolean)$bool;
		
		return $this;
	}
	
	public function setAutoText($bool) {
		$this->_params['auto_text'] = (boolean)$bool;
		
		return $this;
	}
	
	public function setUrlStripQs($bool) {
		$this->_params['url_strip_qs'] = (boolean)$bool;
		
		return $this;
	}
	
	public function setPreserveRecipients($bool) {
		$this->_params['preserve_recipients'] = (boolean)$bool;
		
		return $this;
	}
	
	public function setBccAddress($email) {
		$this->_params['bcc_address'] = $email;
		
		return $this;
	}
	
	public function setMerge($bool) {
		$this->_params['merge'] = (boolean)$bool;
		return $this;
	}
	
	public function setGlobalMergeVars(array $vars) {
		$this->setMerge(true);
		if(!isset($this->_params['global_merge_vars'])) {
			$this->_params['global_merge_vars'] = array();
		}
		
		foreach($vars as $key => $val) {
			$this->_params['global_merge_vars'][] = array(
				'name' => $key,
				'content' => $val		
			);
		}
		
		return $this;
	}
	
	public function addGlobalMergeVar($key, $val) {
		$this->setMerge(true);
		if(!isset($this->_params['global_merge_vars'])) {
			$this->_params['global_merge_vars'] = array();
		}

		$this->_params['global_merge_vars'][] = array(
			'name' => $key,
			'val' => $val		
		);
		
		return $this;
	}
	
	public function setTags(array $tags) {
		if(!isset($this->_params['tags'])) {
			$this->_params['tags'] = array();
		}
		
		foreach($tags as $tag) {
			$this->_params['tags'][] = (string)$tag;
		}
		
		return $this;
	}
	
	public function addTag($tag) {
		if(!isset($this->_params['tags'])) {
			$this->_params['tags'] = array();
		}
		
		$this->_params['tags'][] = (string)$tag;
		
		return $this;
	}
	
	public function setGoogleAnalyticsDomains(array $domains) {
		if(!isset($this->_params['google_analytics_domains'])) {
			$this->_params['google_analytics_domains'] = array();
		}
		
		foreach($domains as $domain) {
			$this->_params['google_analytics_domains'][] = (string)$domain;
		}
		
		return $this;
	}
	
	public function addGoogleAnalyticsDomain($domain) {
		if(!isset($this->_params['google_analytics_domains'])) {
			$this->_params['google_analytics_domains'] = array();
		}
		
		$this->_params['google_analytics_domains'][] = (string)$domain;
		
		return $this;
	}
	
	public function setGoogleAnalyticsCampaign($campaign) {
		$this->_params['google_analytics_campaign'] = $campaign;
		
		return $this;
	}
	
	public function setMetadata(array $data) {
		if(!isset($this->_params['metadata'])) {
			$this->_params['metadata'] = array();
		}
		
		foreach($data as $metadata) {
			$this->_params['metadata'][] = (string)$metadata;
		}
		
		return $this;
	}
	
	public function addMetadata($metadata) {
		if(!isset($this->_params['metadata'])) {
			$this->_params['metadata'] = array();
		}
		
		$this->_params['metadata'][] = (string)$metadata;
		
		return $this;		
	}
	
	public function addMergeData($recipient, $name, $data) {
		if(!isset($this->_params['merge_vars'])) {
			$this->_params['merge_vars'] = array();
		}
	
		
		$found = false;
		foreach($this->_params['merge_vars'] as &$merge_data) {
			if($merge_data['rcpt'] == $recipient) {
				
				$found = true;
	
				if(!isset($merge_data['vars'])) {
					$merge_data['vars'] = array();
				}
	
				$merge_data['vars'][] = array(
						'name' => (string)$name,
						'content' => (string)$data
				);
				break;
			}
		}
	
		if(!$found) {
			$this->_params['merge_vars'][] = array(
					'rcpt' => $recipient,
					'vars' => array(
								array(
									'name' => (string)$name,
									'content' => (string)$data
								)		
					)
			);
		}
	
		return $this;
	}
	
	public function addRecipientMetadata($recipient, $data) {
		if(!isset($this->_params['recipient_metadata'])) {
			$this->_params['recipient_metadata'] = array();
		}
		
		$found = false;
		foreach($this->_params['recipient_metadata'] as &$metadata) {
			if($metadata['rcpt'] == $recipient) {
				$found = true;
				
				if(!isset($metadata['values'])) {
					$metadata['values'] = array();	
				}
				
				$metadata['values'][] = (string)$data;
				break;
			}
		}
		
		if(!$found) {
			$this->_params['recipient_metadata'][] = array(
				'rcpt' => $recipient,
				'values' => array((string)$data)		
			);
		}
		
		return $this;
	}
	
	public function addAttachment($content_type, $filename, $data) {
		if(!isset($this->_params['attachments'])) {
			$this->_params['attachments'] = array();
		}
		
		$this->params['attachments'][] = array(
			'type' => (string)$content_type,
			'name' => (string)$filename,
			'content' => (string)$data		
		);
		
		return $this;
	}
	
	public function toJson() {
		return json_encode($this->_params);
	}
	
	public function toArray() {
		return $this->_params;
	}
}