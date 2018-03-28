<?php

	class client_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function create_client($data) {
			$this->load->database();
			$this->db->insert('client', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function getall_client(){
	    	$this->load->database();
			$this->db->select('client.*, users.fullname as user_name');
			$this->db->join('users', 'client.user_id = users.id','left');
			$query = $this->db->get('client');
			return $query->result_array();
  		}

  		function get_client($clnt_id){
	    	$this->load->database();
			$this->db->select('client.*, users.fullname as user_name');
			$this->db->join('users', 'client.user_id = users.id','left');
			$this->db->where('client.id', $clnt_id);
			$query = $this->db->get('client');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

	}
?>