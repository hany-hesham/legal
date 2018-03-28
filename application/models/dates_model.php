<?php

	class dates_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function create_date($data) {
			$this->load->database();
			$this->db->insert('issue_dates', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function getall_issue(){
	    	$this->load->database();
			$this->db->select('issue.*');
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function getall_date(){
	    	$this->load->database();
			$this->db->select('issue_dates.*, users.fullname as user_name, issue.number as issue_num');
			$this->db->join('users', 'issue_dates.user_id = users.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_date($date_id){
	    	$this->load->database();
			$this->db->select('issue_dates.*, users.fullname as user_name, issue.number as issue_num');
			$this->db->join('users', 'issue_dates.user_id = users.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.id', $date_id);
			$query = $this->db->get('issue_dates');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function getall_issue_dates(){
	    	$this->load->database();
			$this->db->select('issue.id, issue.number, issue.year, issue_dates.date');
			$this->db->join('issue_dates', 'issue.id = issue_dates.issue_id','left');
       	 	$this->db->where('issue_dates.date ="' . date('Y-m-d', strtotime("+2 DAY")) . '"');
			$this->db->order_by('issue_dates.date', 'DESC');
			$this->db->group_by('issue.id');
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_date($issue_id){
	    	$this->load->database();
			$this->db->select('issue_dates.*, users.fullname as user_name, issue.number as issue_num');
			$this->db->join('users', 'issue_dates.user_id = users.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.issue_id', $issue_id);
			$this->db->order_by('date', 'DESC');
        	$this->db->limit('1');
			$query = $this->db->get('issue_dates');
			return $query->row_array();
  		}

  		function get_all_users(){
	    	$this->load->database();
			$this->db->select('users.email, users.fullname');
			$query = $this->db->get('users');
			return $query->result_array();
  		}
		
	}
?>