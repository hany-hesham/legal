<?php

	class type_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function create_type($data) {
			$this->load->database();
			$this->db->insert('clnt_types', $data);
			$this->db->insert('opnt_types', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}
		
		function getall_type(){
	    	$this->load->database();
			$this->db->select('clnt_types.*, users.fullname as user_name');
			$this->db->join('users', 'clnt_types.user_id = users.id','left');
			$query = $this->db->get('clnt_types');
			return $query->result_array();
  		}

  		function get_type($typ_id){
	    	$this->load->database();
			$this->db->select('clnt_types.*, users.fullname as user_name');
			$this->db->join('users', 'clnt_types.user_id = users.id','left');
			$this->db->where('clnt_types.id', $typ_id);
			$query = $this->db->get('clnt_types');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

	}
?>