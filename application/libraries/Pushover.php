<?php
/**
 * 	Pushover Class
 */

class pushover {

	var $app_key = NULL;
	var $api_url = 'https://api.pushover.net/1/messages.json';

	function __construct($module) {
	
		$this->ci =& get_instance();

		$this->ci->load->config('pushover', TRUE);
	}

	public function set_key($module) {
		$this->app_key = $this->ci->config->item($module, 'pushover');
	}
	

	
	public function send($array,$user_key) {

		if ($this->app_key == NULL)
			return false;

		/*
			Limit to 512 chars as per pushover limit.
		*/
		$remove = 0;
		if (isset($array['title'])) {
			$remove = (int) strlen($array['title']);
		}
		
		if (isset($array['message'])) {
			$array['message']	= substr($array['message'], 0, 512 - $remove);
		}

		curl_setopt_array($ch = curl_init(), array(
		  CURLOPT_URL => $this->api_url,
		  CURLOPT_RETURNTRANSFER => 1,
		  CURLOPT_POSTFIELDS => array(
		  	"html" =>1,
		    "token" => $this->app_key,
		    "user" => $user_key,
		    "message" => $array['message'],
		    "title" => $array['title'],
		  ),
		  CURLOPT_SAFE_UPLOAD => true,
		));
		$result = curl_exec($ch);
		curl_close($ch);
						
		if ($result) {
			$return_data = json_decode($result, true);

			if ($return_data['status'] == 1) {
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}

		return false;

	}
	
	
}

?>