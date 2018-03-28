<?php

	class management_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function create_management($data) {
			$this->load->database();
			$this->db->insert('management', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function getall_management(){
	    	$this->load->database();
			$this->db->select('management.*, users.fullname as user_name');
			$this->db->join('users', 'management.user_id = users.id','left');
			$query = $this->db->get('management');
			return $query->result_array();
  		}

  		function get_management($mang_id){
	    	$this->load->database();
			$this->db->select('management.*, users.fullname as user_name');
			$this->db->join('users', 'management.user_id = users.id','left');
			$this->db->where('management.id', $mang_id);
			$query = $this->db->get('management');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function update_files($assumed_id, $mang_id) {
  			$this->load->database();
  			$this->db->query('UPDATE management_filles SET mang_id = "'.$mang_id.'" WHERE mang_id = "'.$assumed_id.'"');
  		}

  		function getby_fille($mang_id){
	    	$this->load->database();
			$this->db->where('mang_id', $mang_id);
			$query = $this->db->get('management_filles');
			return $query->result_array();
  		}

  		function add($mang_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO management_filles(mang_id, name, user_id) VALUES("'.$mang_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM management_filles WHERE id = '.$id);
	    }

	}
?>