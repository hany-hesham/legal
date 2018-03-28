<?php

	class issue_model extends CI_Model{

  		function __contruct(){
			parent::__construct;
		}

		function create_issue($data) {
			$this->load->database();
			$this->db->insert('issue', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function delete_data($id){
        	$this->load->database();
			$this->db->where('issue.id', $id);		
			$this->db->delete('issue');
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
    	}

    	function delete_date($id){
        	$this->load->database();
			$this->db->where('issue_dates.issue_id', $id);		
			$this->db->delete('issue_dates');
			return ($this->db->affected_rows() >= 1)? $this->db->insert_id() : FALSE;
    	}

    	function delete_file($id){
        	$this->load->database();
			$this->db->where('issue_filles.iss_id', $id);		
			$this->db->delete('issue_filles');
			return ($this->db->affected_rows() >= 1)? $this->db->insert_id() : FALSE;
    	}

    	function get_likes($id, $number, $year){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.id !=', $id);
			$this->db->like('issue.number', $number);
			$this->db->like('issue.year', $year);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

		function update_issue($data, $iss_id) {
			$this->load->database();
			$this->db->where('issue.id', $iss_id);	
			$this->db->update('issue', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_backward($data) {
			$this->load->database();
			$this->db->insert('backward', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_backward($data, $iss_id) {
			$this->load->database();
			$this->db->where('backward.iss_id', $iss_id);	
			$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit('1');
			$this->db->update('backward', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_revers($data) {
			$this->load->database();
			$this->db->insert('revers', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_revers($data, $iss_id) {
			$this->load->database();
			$this->db->where('revers.iss_id', $iss_id);	
			$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit('1');
			$this->db->update('revers', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_shout($data) {
			$this->load->database();
			$this->db->insert('shout', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function update_shout($data, $iss_id) {
			$this->load->database();
			$this->db->where('shout.iss_id', $iss_id);	
			$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit('1');
			$this->db->update('shout', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function create_date($data) {
			$this->load->database();
			$this->db->insert('issue_dates', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function getall_client(){
	    	$this->load->database();
			$query = $this->db->get('client');
			return $query->result_array();
  		}

  		function getall_hotel(){
	    	$this->load->database();
			$query = $this->db->get('hotels');
			return $query->result_array();
  		}

  		function getall_users(){
	    	$this->load->database();
	    	$this->db->select('users.*');
			$form_data = array("12", "1", "2", "3");
          	$this->db->where_not_in('users.id', $form_data);
			$this->db->order_by('users.fullname');
			$query = $this->db->get('users');
			return $query->result_array();
  		}

  		function getall_ctype(){
	    	$this->load->database();
			$query = $this->db->get('clnt_types');
			return $query->result_array();
  		}

  		function getall_otype(){
	    	$this->load->database();
			$query = $this->db->get('opnt_types');
			return $query->result_array();
  		}

  		function getall_case_type(){
	    	$this->load->database();
			$query = $this->db->get('case_types');
			return $query->result_array();
  		}

  		function getall_court(){
	    	$this->load->database();
			$query = $this->db->get('courts');
			return $query->result_array();
  		}

  		function getall_issue(){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_user_issue($user){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.user_id', $user);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function getall_issue_hotel($hotel){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.hotel_id', $hotel);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function getall_management(){
	    	$this->load->database();
			$this->db->select('management.*, users.fullname as user_name');
			$this->db->join('users', 'management.user_id = users.id','left');
			$query = $this->db->get('management');
			return $query->result_array();
  		}

  		function getall_issue_comments(){
	    	$this->load->database();
			$this->db->select('issue.*, comments.user_id as userid, comments.issue_id, comments.comment, comments.timestamp as time, users.fullname as user_name');
			$this->db->join('issue', 'comments.issue_id = issue.id','left');
			$this->db->join('users', 'comments.user_id = users.id','left');
			$query = $this->db->get('comments');
			return $query->result_array();
  		}

  		function get_issue_count(){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$query = $this->db->get('issue');
			return $query->num_rows();
  		}

  		function get_issue($iss_id){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.id', $iss_id);
			$query = $this->db->get('issue');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function get_backward($iss_id){
	    	$this->load->database();
			$this->db->select('backward.*, users.fullname as user_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type');
			$this->db->join('users', 'backward.user_id = users.id','left');
			$this->db->join('clnt_types', 'backward.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'backward.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'backward.court_id = courts.id','left');
			$this->db->join('case_types', 'backward.case_type_id = case_types.id','left');
			$this->db->where('backward.iss_id', $iss_id);
			$query = $this->db->get('backward');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function get_revers($iss_id){
	    	$this->load->database();
			$this->db->select('revers.*, users.fullname as user_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type');
			$this->db->join('users', 'revers.user_id = users.id','left');
			$this->db->join('clnt_types', 'revers.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'revers.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'revers.court_id = courts.id','left');
			$this->db->join('case_types', 'revers.case_type_id = case_types.id','left');
			$this->db->where('revers.iss_id', $iss_id);
			$query = $this->db->get('revers');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function get_shout($iss_id){
	    	$this->load->database();
			$this->db->select('shout.*, users.fullname as user_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type');
			$this->db->join('users', 'shout.user_id = users.id','left');
			$this->db->join('clnt_types', 'shout.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'shout.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'shout.court_id = courts.id','left');
			$this->db->join('case_types', 'shout.case_type_id = case_types.id','left');
			$this->db->where('shout.iss_id', $iss_id);
			$query = $this->db->get('shout');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function get_issue_member($iss_id){
	    	$this->load->database();
			$this->db->select('issue_members.*, users.fullname as user_name');
			$this->db->join('users', 'issue_members.stuff_id = users.id','left');
			$this->db->where('issue_members.issue_id', $iss_id);
			$query = $this->db->get('issue_members');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
  		}

  		function get_issue_hotel($hotel){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.hotel_id', $hotel);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_num($num){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.number', $num);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_year($year){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.year', $year);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_year_hotel($year, $hotel){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.year', $year);
			$this->db->where('issue.hotel_id', $hotel);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_clnt($clnt){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.client_id', $clnt);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_hotel_clnt($clnt, $hotel){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.client_id', $clnt);
			$this->db->where('issue.hotel_id', $hotel);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_date_clnt($date, $date1, $clnt){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state, issue.client_id');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->where('issue.client_id', $clnt);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_issue_date_hotel_clnt($date, $date1, $clnt, $hotel){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state, issue.client_id, issue.hotel_id');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->where('issue.client_id', $clnt);
			$this->db->where('issue.hotel_id', $hotel);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_clnt($clnt){
	    	$this->load->database();
			$this->db->select('client.name as client_name');
			$this->db->where('client.id', $clnt);
			$query = $this->db->get('client');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function get_issue_opnt($opnt){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->like('issue.opponent', $opnt);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_opnt_hotel($opnt, $hotel){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->like('issue.opponent', $opnt);
			$this->db->where('issue.hotel_id', $hotel);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_date_opnt($date, $date1, $opnt){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state, issue.opponent');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->like('issue.opponent', $opnt);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_issue_date_hotel_opnt($date, $date1, $opnt, $hotel){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state, issue.opponent, issue.hotel_id');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->where('issue.hotel_id', $hotel);
			$this->db->like('issue.opponent', $opnt);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_issue_date_hotel($date, $date1, $hotel){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state, issue.hotel_id');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->where('issue.hotel_id', $hotel);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_issue_date_year($date, $date1, $year){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state, issue.year');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->where('issue.year', $year);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_issue_date_hotel_year($date, $date1, $year, $hotel){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state, issue.year, issue.hotel_id');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->where('issue.year', $year);
			$this->db->where('issue.hotel_id', $hotel);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}


  		function get_issue_date($date, $date1){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_issue_monthly($date, $date1, $hotel){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state, issue.hotel_id');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->where('issue.hotel_id', $hotel);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_issue_dates($date){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->like('issue_dates.date', $date);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_runing_issue($state_id){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			if ($state_id == 5) {
				$this->db->where('state_id !=', 1, 2);
			}else{
				$this->db->where('issue_dates.state_id', $state_id);
			}
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_issue_type($type){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.case_type_id', $type);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_type_hotel($type, $hotel){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.case_type_id', $type);
			$this->db->where('issue.hotel_id', $hotel);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_date_type($date, $date1, $type){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state, issue.case_type_id');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->like('issue.case_type_id', $type);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_issue_date_hotel_type($date, $date1, $type, $hotel){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state, issue.case_type_id, issue.hotel_id');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->where('issue.hotel_id', $hotel);
			$this->db->like('issue.case_type_id', $type);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_type($type){
	    	$this->load->database();
			$this->db->select('case_types.type as type');
			$this->db->where('case_types.id', $type);
			$query = $this->db->get('case_types');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function get_issue_cort($cort){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.court_id', $cort);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_cort_hotel($cort, $hotel){
	    	$this->load->database();
			$this->db->select('issue.*, users.fullname as user_name, client.name as client_name, clnt_types.type as clnt_type, opnt_types.type as opnt_type, courts.name as court, case_types.type as case_type, hotels.name as hotel_name, hotels.logo As logo');
			$this->db->join('hotels', 'issue.hotel_id = hotels.id','left');
			$this->db->join('users', 'issue.user_id = users.id','left');
			$this->db->join('client', 'issue.client_id = client.id','left');
			$this->db->join('clnt_types', 'issue.client_type = clnt_types.id','left');
			$this->db->join('opnt_types', 'issue.opponent_type = opnt_types.id','left');
			$this->db->join('courts', 'issue.court_id = courts.id','left');
			$this->db->join('case_types', 'issue.case_type_id = case_types.id','left');
			$this->db->where('issue.court_id', $cort);
			$this->db->where('issue.hotel_id', $hotel);
			$query = $this->db->get('issue');
			return $query->result_array();
  		}

  		function get_issue_date_cort($date, $date1, $cort){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state, issue.court_id');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->like('issue.court_id', $cort);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_issue_date_hotel_cort($date, $date1, $cort, $hotel){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state, issue.court_id, issue.hotel_id');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.date >=', $date);
			$this->db->where('issue_dates.date <=', $date1);
			$this->db->where('issue.hotel_id', $hotel);
			$this->db->like('issue.court_id', $cort);
			$this->db->order_by('issue_dates.date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function get_cort($cort){
	    	$this->load->database();
			$this->db->select('courts.name as cort');
			$this->db->where('courts.id', $cort);
			$query = $this->db->get('courts');
			return ($query->num_rows() > 0 )? $query->row_array() : FALSE;
  		}

  		function get_comment($iss_id){
			$query = $this->db->query("
				SELECT users.fullname, comments.*	FROM comments
				JOIN users on comments.user_id = users.id
				WHERE comments.issue_id =".$iss_id);
			return $query->result_array();
  		}

  		function insert_comment($data){
			$this->db->insert('comments', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

		function get_hotel($hotel){
	    	$this->load->database();
			$this->db->select('hotels.*');
			$this->db->where('hotels.id', $hotel);
			$query = $this->db->get('hotels');
			return $query->row_array();
  		}

  		function trunc_date(){
			$this->db->truncate('calendar');
			return ($this->db->affected_rows() > 0)? TRUE : FALSE;
		}

  		function insert_date($data){
			$this->db->insert('calendar', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

  		function get_date(){
	    	$this->load->database();
			$this->db->select('calendar.*');
			$query = $this->db->get('calendar');
			return $query->result_array();
  		}

  		function get_dates(){
	    	$this->load->database();
			$this->db->select('issue_dates.*, issue.number');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function getall_state(){
	    	$this->load->database();
			$query = $this->db->get('state');
			return $query->result_array();
  		}

  		function get_state($state){
	    	$this->load->database();
			$this->db->select('state.*');
			$this->db->where('state.id', $state);
			$query = $this->db->get('state');
			return $query->row_array();
  		}

  		function get_disscution($disc_id){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->where('issue_dates.id', $disc_id);
			$query = $this->db->get('issue_dates');
			return $query->row_array();
  		}

  		function update_disscution($data, $disc_id) {
			$this->load->database();
			$this->db->where('issue_dates.id', $disc_id);	
			$this->db->update('issue_dates', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}

  		function getall_date($iss_id){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.issue_id', $iss_id);
			$this->db->order_by('date', 'DESC');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function getall_date_count($iss_id){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.issue_id', $iss_id);
			$this->db->order_by('date', 'DESC');
			$query = $this->db->get('issue_dates');
			return $query->num_rows();
  		}

  		function getall_datese($iss_id){
	    	$this->load->database();
			$this->db->select('issue_dates.*, state.name as case_state');
			$this->db->join('state', 'issue_dates.state_id = state.id','left');
			$this->db->join('issue', 'issue_dates.issue_id = issue.id','left');
			$this->db->where('issue_dates.issue_id', $iss_id);
			$this->db->order_by('date');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function getall_dat($iss_id){
	    	$this->load->database();
			$this->db->select('issue_dates.*');
			$this->db->where('issue_dates.issue_id', $iss_id);
			$this->db->order_by('timestamp', 'DESC');
        	$this->db->limit('2');
			$query = $this->db->get('issue_dates');
			return $query->result_array();
  		}

  		function update_files($assumed_id, $iss_id) {
  			$this->load->database();
  			$this->db->query('UPDATE issue_filles SET iss_id = "'.$iss_id.'" WHERE iss_id = "'.$assumed_id.'"');
  		}

  		function getby_fille($iss_id){
	    	$this->load->database();
			$this->db->where('iss_id', $iss_id);
			$query = $this->db->get('issue_filles');
			return $query->result_array();
  		}

  		function add($iss_id, $name, $user_id) {
	  		$this->load->database();
	  		$this->db->query('INSERT INTO issue_filles(iss_id, name, user_id) VALUES("'.$iss_id.'","'.$name.'","'.$user_id.'")');
	  	}

	  	function remove($id) {
	      $this->load->database();
	      $this->db->query('DELETE FROM issue_filles WHERE id = '.$id);
	    }

	}
?>