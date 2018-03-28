-<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Backend extends CI_Controller {
		private $crud;

		public function __construct() {
			parent::__construct();
			$this->load->library('Grocery_CRUD');
			$this->load->library('extension_grocery_CRUD');
			$this->crud = new Extension_grocery_CRUD();
			$this->load->library('Tank_auth');
			if (!$this->tank_auth->is_logged_in()) {
				redirect('/auth/login');
			} else {
				$this->data['user_id'] = $this->tank_auth->get_user_id();
		      	$this->data['username'] = $this->tank_auth->get_username();
		      	$this->data['is_admin'] = $this->tank_auth->is_admin();
     		}
		}

		public function index() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('users');
				$this->crud->fields(array('username', 'password', 'email', 'fullname', 'banned', 'admin'));
				$this->crud->display_as('banned', 'deny access');
				$this->crud->columns('username', 'email', 'fullname', 'banned');
				$this->crud->callback_before_insert(array($this,'users_callback'));
				$this->crud->callback_before_update(array($this,'users_callback'));
				$this->crud->change_field_type('password','password');
				$this->crud->callback_edit_field('password',array($this,'edit_password_callback'));
				$this->crud->set_rules('username', 'Username','trim|required|xss_clean|callback_login_check');
				$this->crud->set_rules('email', 'Email','trim|required|xss_clean|callback_login_check');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function callback_login_check($login) {
			$this->load->model('users_model');
			$user_exists = $this->users_model->get_user_by_login($login);
			if (is_null($user_exists)) {
				return TRUE;
			} else {
				$this->form_validation->set_message('username_check', 'The user already exists');
				return FALSE;
			}
		}

		function edit_password_callback() {
			return '<input id="field-password" name="password" type="password" value="" maxlength="255">';
		}

		function users_callback($post_array) {
			$password = $post_array['password'];
			if (strlen($password) > 0 ) {
				$this->load->library('phpass-0.1/PasswordHash');
				$hasher = new PasswordHash();
				$post_array['password'] = $hasher->HashPassword($password);
			} else {
				unset($post_array['password']);
			}
			return $post_array;
		}

		public function issue() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('issue');
				$this->crud->set_subject('Issue');
				$this->crud->columns('id', 'client_id', 'opponent', 'number', 'year');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('client_id','Client');
				$this->crud->display_as('opponent','Opponent');
				$this->crud->display_as('opnt_address','Opponent Address');
				$this->crud->display_as('number','Case Number');
				$this->crud->display_as('year','Year');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('hotel_id','Hotel');
				$this->crud->display_as('type_id','Client Type');
				$this->crud->display_as('case_type_id','Case Type');
				$this->crud->display_as('describtion','Case Describtion');
				$this->crud->display_as('court_id','Court');
				$this->crud->display_as('notes','Notes');
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('client_id', 'client', 'name');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('hotel_id', 'hotels', 'name');
				$this->crud->set_relation('client_type', 'clnt_types', 'type');
				$this->crud->set_relation('opponent_type', 'opnt_types', 'type');
				$this->crud->set_relation('case_type_id', 'case_types', 'type');
				$this->crud->set_relation('court_id', 'courts', 'name');
				$this->crud->add_action('Attachment Files', '', '','ui-icon-image',array($this,'issue_attach'));
				$this->crud->add_action('Issue Dates', '', '','ui-icon-image',array($this,'issue_dat'));
				$this->crud->add_action('Issue Backward', '', '','ui-icon-image',array($this,'issue_back'));
				$this->crud->add_action('Issue Revers', '', '','ui-icon-image',array($this,'issue_rev'));
				$this->crud->add_action('Issue Shout', '', '','ui-icon-image',array($this,'issue_sht'));
				$this->crud->add_action('Comments', '', '','ui-icon-image',array($this,'issue_com'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function issue_attach($pk, $row) {
			return '/backend/issue_attachment/'.$pk;
		}

		public function issue_attachment($iss_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('issue_filles');
				$this->crud->set_subject('File');
				$this->crud->callback_field('iss_id',array($this,'fixed_issue'));
				$this->crud->display_as('iss_id', "Case Number");
				$this->crud->display_as('user_id', "User");
				$this->crud->display_as('name','File');
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('iss_id', 'issue', 'number');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('iss_id', $iss_id);
				$this->crud->callback_before_insert(array($this,'issue_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fixed_issue() {
			return '';
		}

		public function issue_associates($post_array) {
			$iss_id = $this->uri->segment(3);
			$post_array['iss_id'] = $iss_id;
			return $post_array;
		}

		function issue_dat($pk, $row) {
			return '/backend/issue_date/'.$pk;
		}

		public function issue_date($iss_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('issue_dates');
				$this->crud->set_subject('Date');
				$this->crud->callback_field('issue_id',array($this,'fixed_iss'));
				$this->crud->display_as('issue_id', "Case Number");
				$this->crud->display_as('user_id', "User");
				$this->crud->display_as('date', "Date");
				$this->crud->display_as('timestamp','Added Time');
				//$this->crud->field_type('date', 'date');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('state_id', 'state', 'name');
				$this->crud->set_relation('issue_id', 'issue', 'number');
				$this->crud->where('issue_id', $iss_id);
				$this->crud->callback_before_insert(array($this,'iss_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fixed_iss() {
			return '';
		}

		public function iss_associates($post_array) {
			$iss_id = $this->uri->segment(3);
			$post_array['issue_id'] = $iss_id;
			return $post_array;
		}

		function issue_back($pk, $row) {
      return '/backend/issue_backward/'.$pk;
    }

    public function issue_backward($iss_id) {
      try {
        $this->crud->set_theme('datatables');
        $this->crud->set_table('backward');
        $this->crud->set_subject('Backward');
        $this->crud->callback_field('iss_id',array($this,'fixed_back'));
        $this->crud->display_as('id', 'ID#');
        $this->crud->display_as('number','Case Number');
        $this->crud->display_as('year','Year');
        $this->crud->display_as('user_id','User');
        $this->crud->display_as('client_type','Client Type');
        $this->crud->display_as('opponent_type','Opponent Type');
        $this->crud->display_as('case_type_id','Case Type');
        $this->crud->display_as('court_id','Court');
        $this->crud->display_as('area_no','Area');
        $this->crud->display_as('timestamp','Added Time');
        $this->crud->set_relation('user_id', 'users', 'fullname');
        $this->crud->set_relation('client_type', 'clnt_types', 'type');
        $this->crud->set_relation('opponent_type', 'opnt_types', 'type');
        $this->crud->set_relation('case_type_id', 'case_types', 'type');
        $this->crud->set_relation('court_id', 'courts', 'name');
        $this->crud->where('iss_id', $iss_id);
        $this->crud->callback_before_insert(array($this,'back_associates'));
        $output = $this->crud->render();
        $this->load->view('backend', $output);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }

    public function fixed_back() {
      return '';
    }

    public function back_associates($post_array) {
      $iss_id = $this->uri->segment(3);
      $post_array['iss_id'] = $iss_id;
      return $post_array;
    }

    function issue_rev($pk, $row) {
      return '/backend/issue_revers/'.$pk;
    }

    public function issue_revers($iss_id) {
      try {
        $this->crud->set_theme('datatables');
        $this->crud->set_table('revers');
        $this->crud->set_subject('Revers');
        $this->crud->callback_field('iss_id',array($this,'fixed_rev'));
        $this->crud->display_as('id', 'ID#');
        $this->crud->display_as('number','Case Number');
        $this->crud->display_as('year','Year');
        $this->crud->display_as('user_id','User');
        $this->crud->display_as('client_type','Client Type');
        $this->crud->display_as('opponent_type','Opponent Type');
        $this->crud->display_as('case_type_id','Case Type');
        $this->crud->display_as('court_id','Court');
        $this->crud->display_as('area_no','Area');
        $this->crud->display_as('timestamp','Added Time');
        $this->crud->set_relation('user_id', 'users', 'fullname');
        $this->crud->set_relation('client_type', 'clnt_types', 'type');
        $this->crud->set_relation('opponent_type', 'opnt_types', 'type');
        $this->crud->set_relation('case_type_id', 'case_types', 'type');
        $this->crud->set_relation('court_id', 'courts', 'name');
        $this->crud->where('iss_id', $iss_id);
        $this->crud->callback_before_insert(array($this,'rev_associates'));
        $output = $this->crud->render();
        $this->load->view('backend', $output);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }

    public function fixed_rev() {
      return '';
    }

    public function rev_associates($post_array) {
      $iss_id = $this->uri->segment(3);
      $post_array['iss_id'] = $iss_id;
      return $post_array;
    }

    function issue_sht($pk, $row) {
      return '/backend/issue_shout/'.$pk;
    }

    public function issue_shout($iss_id) {
      try {
        $this->crud->set_theme('datatables');
        $this->crud->set_table('shout');
        $this->crud->set_subject('Shout');
        $this->crud->callback_field('iss_id',array($this,'fixed_sht'));
        $this->crud->display_as('id', 'ID#');
        $this->crud->display_as('number','Case Number');
        $this->crud->display_as('year','Year');
        $this->crud->display_as('user_id','User');
        $this->crud->display_as('client_type','Client Type');
        $this->crud->display_as('opponent_type','Opponent Type');
        $this->crud->display_as('case_type_id','Case Type');
        $this->crud->display_as('court_id','Court');
        $this->crud->display_as('area_no','Area');
        $this->crud->display_as('timestamp','Added Time');
        $this->crud->set_relation('user_id', 'users', 'fullname');
        $this->crud->set_relation('client_type', 'clnt_types', 'type');
        $this->crud->set_relation('opponent_type', 'opnt_types', 'type');
        $this->crud->set_relation('case_type_id', 'case_types', 'type');
        $this->crud->set_relation('court_id', 'courts', 'name');
        $this->crud->where('iss_id', $iss_id);
        $this->crud->callback_before_insert(array($this,'sht_associates'));
        $output = $this->crud->render();
        $this->load->view('backend', $output);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }

    public function fixed_sht() {
      return '';
    }

    public function sht_associates($post_array) {
      $iss_id = $this->uri->segment(3);
      $post_array['iss_id'] = $iss_id;
      return $post_array;
    }

		function issue_diss($pk, $row) {
			return '/backend/issue_disscution/'.$pk;
		}

		public function issue_disscution($date_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('disscution');
				$this->crud->set_subject('Disscution');
				$this->crud->callback_field('date_id',array($this,'fixed_issues'));
				$this->crud->display_as('date_id', "Disscution Date");
				$this->crud->display_as('user_id', "User");
				$this->crud->display_as('report', "Report");
				$this->crud->display_as('state_id', "State");
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('date_id', 'issue_dates', 'date');
				$this->crud->set_relation('state_id', 'state', 'name');
				$this->crud->where('date_id', $date_id);
				$this->crud->callback_before_insert(array($this,'issues_associates'));
				$this->crud->add_action('Attachment Files', '', '','ui-icon-image',array($this,'disscution_attach'));
				$this->crud->add_action('Comments', '', '','ui-icon-image',array($this,'disscution_com'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fixed_issues() {
			return '';
		}

		public function issues_associates($post_array) {
			$date_id = $this->uri->segment(3);
			$post_array['date_id'] = $date_id;
			return $post_array;
		}

		function disscution_attach($pk, $row) {
			return '/backend/disscution_attachment/'.$pk;
		}

		public function disscution_attachment($disc_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('disc_filles');
				$this->crud->set_subject('File');
				$this->crud->callback_field('disc_id',array($this,'fixed_disscution'));
				$this->crud->display_as('disc_id', "Disscution Number");
				$this->crud->display_as('user_id', "User");
				$this->crud->display_as('name','File');
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('disc_id', 'disscution', 'id');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('disc_id', $disc_id);
				$this->crud->callback_before_insert(array($this,'disscution_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fixed_disscution() {
			return '';
		}

		public function disscution_associates($post_array) {
			$disc_id = $this->uri->segment(3);
			$post_array['disc_id'] = $disc_id;
			return $post_array;
		}

		function disscution_com($pk, $row) {
			return '/backend/disscution_comment/'.$pk;
		}

		public function disscution_comment($disc_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('disc_comments');
				$this->crud->set_subject('Comment');
				$this->crud->callback_field('disc_id',array($this,'fixed_disc'));
				$this->crud->display_as('disc_id', "Disscution Number");
				$this->crud->display_as('user_id', "User");
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('disc_id', 'disscution', 'id');
				$this->crud->where('disc_id', $disc_id);
				$this->crud->callback_before_insert(array($this,'disc_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fixed_disc() {
			return '';
		}

		public function disc_associates($post_array) {
			$disc_id = $this->uri->segment(3);
			$post_array['disc_id'] = $disc_id;
			return $post_array;
		}

		function issue_com($pk, $row) {
			return '/backend/issue_comment/'.$pk;
		}

		public function issue_comment($iss_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('comments');
				$this->crud->set_subject('Comment');
				$this->crud->callback_field('issue_id',array($this,'fixed_is'));
				$this->crud->display_as('issue_id', "Issue Number");
				$this->crud->display_as('user_id', "User");
				$this->crud->display_as('comment','Comment');
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('issue_id', 'issue', 'number');
				$this->crud->where('issue_id', $iss_id);
				$this->crud->callback_before_insert(array($this,'is_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fixed_is() {
			return '';
		}

		public function is_associates($post_array) {
			$iss_id = $this->uri->segment(3);
			$post_array['issue_id'] = $iss_id;
			return $post_array;
		}

		public function client() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('client');
				$this->crud->set_subject('Client');
				$this->crud->columns('id', 'name', 'company', 'phone');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('name','Client');
				$this->crud->display_as('company','Company');
				$this->crud->display_as('phone','Phone Number');
				$this->crud->display_as('address','Address');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}


		public function case_types() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('case_types');
				$this->crud->set_subject('Case Types');
				$this->crud->columns('id', 'type');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('type','Type');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function clnt_types() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('clnt_types');
				$this->crud->set_subject('Clients Types');
				$this->crud->columns('id', 'type');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('type','Type');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function opnt_types() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('opnt_types');
				$this->crud->set_subject('Opponent Types');
				$this->crud->columns('id', 'type');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('type','Type');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function state() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('state');
				$this->crud->set_subject('State');
				$this->crud->columns('id', 'name');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('name','Name');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function courts() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('courts');
				$this->crud->set_subject('Court');
				$this->crud->columns('id', 'name', 'area', 'type');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('area','Area');
				$this->crud->display_as('type','Court Type');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function hotels() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('hotels');
				$this->crud->set_subject('Hotel');
				$this->crud->columns('id', 'name', 'code');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('name','Name');
				$this->crud->display_as('code','Code');
				$this->crud->display_as('logo','Logo');
				$this->crud->set_field_upload('logo','assets/uploads/logos');
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function management() {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('management');
				$this->crud->set_subject('Opponent Types');
				$this->crud->columns('id', 'Date', 'subject');
				$this->crud->display_as('id', 'ID#');
				$this->crud->display_as('subject','Subject');
				$this->crud->display_as('date','Date');
				$this->crud->display_as('decision','Decision');
				$this->crud->display_as('user_id','User');
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->add_action('Attachment Files', '', '','ui-icon-image',array($this,'management_attach'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		function management_attach($pk, $row) {
			return '/backend/management_attachment/'.$pk;
		}

		public function management_attachment($mang_id) {
			try {
				$this->crud->set_theme('datatables');
				$this->crud->set_table('management_filles');
				$this->crud->set_subject('File');
				$this->crud->callback_field('mang_id',array($this,'fixed_management'));
				$this->crud->display_as('mang_id', "Management Number");
				$this->crud->display_as('user_id', "User");
				$this->crud->display_as('name','File');
				$this->crud->display_as('timestamp','Added Time');
				$this->crud->set_relation('user_id', 'users', 'fullname');
				$this->crud->set_relation('mang_id', 'management', 'id');
				$this->crud->set_field_upload('name','assets/uploads/files');
				$this->crud->where('mang_id', $mang_id);
				$this->crud->callback_before_insert(array($this,'management_associates'));
				$output = $this->crud->render();
				$this->load->view('backend', $output);
			}
			catch( Exception $e) {
				show_error($e->getMessage()." _ ". $e->getTraceAsString());
			}
		}

		public function fixed_management() {
			return '';
		}

		public function management_associates($post_array) {
			$mang_id = $this->uri->segment(3);
			$post_array['mang_id'] = $mang_id;
			return $post_array;
		}

	}
?>