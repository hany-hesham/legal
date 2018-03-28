<?php

	class court_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function create_court($data) {
			$this->load->database();
			$this->db->insert('courts', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function getall_court(){
	    	$this->load->database();
			$this->db->select('courts.*, users.fullname as user_name');
			$this->db->join('users', 'courts.user_id = users.id','left');
			$query = $this->db->get('courts');
			return $query->result_array();
  		}

  		function get_court($cort_id){
	    	$this->load->database();
			$this->db->select('courts.*, users.fullname as user_name');
			$this->db->join('users', 'courts.user_id = users.id','left');
			$this->db->where('courts.id', $cort_id);
			$query = $this->db->get('courts');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}
		
	}
?>