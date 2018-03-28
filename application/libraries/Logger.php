<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logger

{

	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->library('session');
		$this->ci->load->database();
		$this->ci->load->model('logs_model');
	}


	function log_event($user_id, $action, $target, $target_id, $data, $comments)
	{
		$log_data = array(
					'user_id' => $user_id,
					'action' => $action,
					'target' => $target,
					'target_id' => $target_id,
					'data' => $data,
					'comments' => $comments
			);

		$this->ci->logs_model->create($log_data);
	}
}