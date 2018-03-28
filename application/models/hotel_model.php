<?php

	class hotel_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function create_hotel($data) {
			$this->load->database();
			$this->db->insert('hotels', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function getall_hotel(){
	    	$this->load->database();
			$this->db->select('hotels.*, users.fullname as user_name');
			$this->db->join('users', 'hotels.user_id = users.id','left');
			$query = $this->db->get('hotels');
			return $query->result_array();
  		}

  		function get_hotel($hotel_id){
	    	$this->load->database();
			$this->db->select('hotels.*, users.fullname as user_name');
			$this->db->join('users', 'hotels.user_id = users.id','left');
			$this->db->where('hotels.id', $hotel_id);
			$query = $this->db->get('hotels');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}
		
	}
?>