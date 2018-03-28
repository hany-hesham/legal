<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class issue extends CI_Controller {
        private $data;
        function __construct() {
            parent::__construct();
            $this->load->library('Tank_auth');
            if (!$this->tank_auth->is_logged_in()) {
                $redirect_path = '/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
                $this->session->set_flashdata('redirect', $redirect_path);
                redirect('/auth/login');
            } else {
                $this->data['user_id'] = $this->tank_auth->get_user_id();
                $this->data['username'] = $this->tank_auth->get_username();
                $this->data['is_admin'] = $this->tank_auth->is_admin();
            }
        }

        public function index() {
            if ($this->input->post('submit')) {
                $this->load->library('form_validation');
                $assumed_id = $this->input->post('assumed_id');                        
                if ($this->form_validation->run() == False) {
                    $this->load->model('users_model');  
                    $this->load->model('issue_model');  
                    $form_data = array(
                        'user_id' => $this->data['user_id'],
                        'hotel_id' => $this->input->post('hotel_id'),
                        'client_id' => $this->input->post('client_id'),
                        'client_type' => $this->input->post('client_type'),
                        'opponent' => $this->input->post('opponent'),
                        'opnt_address' => $this->input->post('opnt_address'),
                        'opponent_type' => $this->input->post('opponent_type'),
                        'case_type_id' => $this->input->post('case_type_id'),
                        'describtion' => $this->input->post('describtion'),
                        'court_id' => $this->input->post('court_id'),
                        'area_no' => $this->input->post('area_no'),
                        'number' => $this->input->post('number'),
                        'year' => $this->input->post('year'),
                        'notes' => $this->input->post('notes')
                    );
                    $iss_id = $this->issue_model->create_issue($form_data);
                    if ($iss_id) {
                        $this->load->model('issue_model');
                        $this->issue_model->update_files($assumed_id,$iss_id);
                    } else {
                        die("ERROR");
                    }
                    $data = array(
                        'user_id' => $this->data['user_id'],
                        'issue_id' => $iss_id,
                        'date' => $this->input->post('date'),
                        'state_id' => $this->input->post('state_id'),
                        'report' => $this->input->post('report'),
                        'appeal' => $this->input->post('appeal')
                    );
                    $date_id = $this->issue_model->create_date($data);
                    if (!$date_id) {
                        die("ERROR");
                    }
                    redirect('/issue/view_search/'.$iss_id);
                }
            }
            try {
                $this->load->helper('form');
                $this->load->model('issue_model');  
                $this->data['hotels'] = $this->issue_model->getall_hotel();
                $this->data['clients'] = $this->issue_model->getall_client();
                $this->data['states'] = $this->issue_model->getall_state();
                $this->data['client_types'] = $this->issue_model->getall_ctype();
                $this->data['opponent_types'] = $this->issue_model->getall_otype();
                $this->data['case_types'] = $this->issue_model->getall_case_type();
                $this->data['courts'] = $this->issue_model->getall_court();
                if ($this->input->post('submit')) {
                    $this->load->model('issue_model');
                    $this->data['assumed_id'] = $this->input->post('assumed_id');
                    $this->data['uploads'] = $this->issue_model->getby_fille($this->data['assumed_id']);
                } else {
                    $this->data['assumed_id'] = strtoupper(str_pad(dechex( mt_rand( 0, 1048575 ) ), 5, '0', STR_PAD_LEFT));
                    $this->data['uploads'] = array();
                }
                $this->load->view('add_new',$this->data);
            }
            catch( Exception $e) {
                show_error($e->getMessage()." _ ". $e->getTraceAsString());
            }
        }

        public function view_search($iss_id) {
            if ($this->input->post('submit')) {
                $this->load->library('form_validation');
                if ($this->form_validation->run() == False) {
                    $this->load->model('issue_model');  
                    $this->issue_model->delete_data($iss_id);
                    $this->issue_model->delete_date($iss_id);
                    $this->issue_model->delete_file($iss_id);
                    redirect('/issue/view_all');
                }
            }
            try {
                $this->load->helper('form');
                $this->load->model('issue_model');  
                $this->data['new'] = $this->issue_model->get_issue($iss_id);
                $issues = $this->issue_model->get_likes($this->data['new']['id'], $this->data['new']['number'],  $this->data['new']['year']);
                $this->data['new']['year'] = $this->translatoer($this->data['new']['year']);
                $this->data['new']['number'] = $this->translatoer($this->data['new']['number']);
                $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
                //die(print_r($issues));
                $this->data['issues'] = array();
                $i=0;
                $this->data['issue'] = array();
                $this->data['dates'] = array();
                $this->data['backward'] = array();
                $this->data['revers'] = array();
                $this->data['shout'] = array();
                foreach ($issues as $issue) {
                    $this->data['issue']['ids'] = $issue['id'];
                    $this->data['issue']['id'] = $this->translatoer($issue['id']);
                    $this->data['issue']['hotel_name'] = $issue['hotel_name'];
                    $this->data['issue']['user_name'] = $issue['user_name'];
                    $this->data['issue']['year'] = $this->translatoer($issue['year']);
                    $this->data['issue']['number'] = $this->translatoer($issue['number']);
                    $this->data['issue']['client_name'] = $issue['client_name'];
                    $this->data['issue']['clnt_type'] = $issue['clnt_type'];
                    $this->data['issue']['opponent'] = $issue['opponent'];
                    $this->data['issue']['opnt_address'] = $issue['opnt_address'];
                    $this->data['issue']['opnt_type'] = $issue['opnt_type'];
                    $this->data['issue']['case_type'] = $issue['case_type'];
                    $this->data['issue']['court'] = $issue['court'];
                    $this->data['issue']['describtion'] = $issue['describtion'];
                    $this->data['backward']['id'] = $issue['backward']['id'];
                    $this->data['backward']['clnt_type'] = $issue['backward']['clnt_type'];
                    $this->data['backward']['opnt_type'] = $issue['backward']['opnt_type'];
                    $this->data['backward']['case_type'] = $issue['backward']['case_type'];
                    $this->data['backward']['court'] = $issue['backward']['court']; 
                    $this->data['backward']['area_no'] = $issue['backward']['area_no'];
                    $this->data['backward']['number'] = $this->translatoer($issue['backward']['number']);
                    $this->data['backward']['year'] = $this->translatoer($issue['backward']['year']);
                    $this->data['issue']['backward'] = $this->data['backward'];
                    $this->data['revers']['id'] = $issue['revers']['id'];
                    $this->data['revers']['clnt_type'] = $issue['revers']['clnt_type'];
                    $this->data['revers']['opnt_type'] = $issue['revers']['opnt_type'];
                    $this->data['revers']['case_type'] = $issue['revers']['case_type'];
                    $this->data['revers']['court'] = $issue['revers']['court']; 
                    $this->data['revers']['area_no'] = $issue['revers']['area_no'];
                    $this->data['revers']['number'] = $this->translatoer($issue['revers']['number']);
                    $this->data['revers']['year'] = $this->translatoer($issue['revers']['year']);
                    $this->data['issue']['revers'] = $this->data['revers'];
                    $this->data['shout']['id'] = $issue['shout']['id'];
                    $this->data['shout']['clnt_type'] = $issue['shout']['clnt_type'];
                    $this->data['shout']['opnt_type'] = $issue['shout']['opnt_type'];
                    $this->data['shout']['case_type'] = $issue['shout']['case_type'];
                    $this->data['shout']['court'] = $issue['shout']['court']; 
                    $this->data['shout']['area_no'] = $issue['shout']['area_no'];
                    $this->data['shout']['number'] = $this->translatoer($issue['shout']['number']);
                    $this->data['shout']['year'] = $this->translatoer($issue['shout']['year']);
                    $this->data['issue']['shout'] = $this->data['shout'];
                    $y = 0;
                    $this->data['issue']['count'] = $this->issue_model->getall_date_count($issue['id']);
                    foreach ($issue['dates'] as $dates) {
                        $this->data['dates']['date'] = $this->date_translatore($dates['date']);
                        $this->data['dates']['report'] = $this->date_translatore($dates['report']);
                        $this->data['issue']['dates'][$y] = $this->data['dates'];                    
                        $y++;
                    }
                    
                    $this->data['issues'][$i] = $this->data['issue'];
                    $i++;
                }
                $this->data['hotels'] = $this->issue_model->getall_hotel();
                $this->data['users'] = $this->issue_model->getall_users();
                $this->load->view('like_new',$this->data);
            }
            catch( Exception $e) {
                show_error($e->getMessage()." _ ". $e->getTraceAsString());
            }
        }

        public function edit($iss_id) {
          if ($this->input->post('submit')) {
            $this->load->library('form_validation');
            $this->load->library('email');
            if ($this->form_validation->run() == FALSE) {
              $this->load->model('users_model');  
              $this->load->model('issue_model'); 
              $this->data['issue'] = $this->issue_model->get_issue($iss_id);
              $form_data = array(
                'user_id' => $this->data['user_id'],
                'hotel_id' => $this->input->post('hotel_id'),
                'client_id' => $this->input->post('client_id'),
                'client_type' => $this->input->post('client_type'),
                'opponent' => $this->input->post('opponent'),
                'opnt_address' => $this->input->post('opnt_address'),
                'opponent_type' => $this->input->post('opponent_type'),
                'case_type_id' => $this->input->post('case_type_id'),
                'describtion' => $this->input->post('describtion'),
                'court_id' => $this->input->post('court_id'),
                'area_no' => $this->input->post('area_no'),
                'number' => $this->input->post('number'),
                'year' => $this->input->post('year'),
                'notes' => $this->input->post('notes')
              );
              $this->issue_model->update_issue($form_data, $iss_id);
              $fdata = array(
                'user_id' => $this->data['user_id'],
                'iss_id' => $iss_id,
                'client_type' => $this->input->post('backward_client_type'),
                'opponent_type' => $this->input->post('backward_opponent_type'),
                'case_type_id' => $this->input->post('backward_case_type_id'),
                'court_id' => $this->input->post('backward_court_id'),
                'area_no' => $this->input->post('backward_area_no'),
                'number' => $this->input->post('backward_number'),
                'year' => $this->input->post('backward_year')
              );
              $this->issue_model->update_backward($fdata, $iss_id);
              $fordata = array(
                'user_id' => $this->data['user_id'],
                'iss_id' => $iss_id,
                'client_type' => $this->input->post('revers_client_type'),
                'opponent_type' => $this->input->post('revers_opponent_type'),
                'case_type_id' => $this->input->post('revers_case_type_id'),
                'court_id' => $this->input->post('revers_court_id'),
                'area_no' => $this->input->post('revers_area_no'),
                'number' => $this->input->post('revers_number'),
                'year' => $this->input->post('revers_year')
              );
              $this->issue_model->update_revers($fordata, $iss_id);
              $formdata = array(
                'user_id' => $this->data['user_id'],
                'iss_id' => $iss_id,
                'client_type' => $this->input->post('shout_client_type'),
                'opponent_type' => $this->input->post('shout_opponent_type'),
                'case_type_id' => $this->input->post('shout_case_type_id'),
                'court_id' => $this->input->post('shout_court_id'),
                'area_no' => $this->input->post('shout_area_no'),
                'number' => $this->input->post('shout_number'),
                'year' => $this->input->post('shout_year')
              );
              $this->issue_model->update_shout($formdata, $iss_id);
              redirect('/issue/view/'.$iss_id);
            }   
          }
          try {
            $this->load->helper('form');
            $this->load->model('users_model');  
            $this->load->model('issue_model');
            $this->data['issue'] = $this->issue_model->get_issue($iss_id);
            $this->data['backward'] = $this->issue_model->get_backward($iss_id);
            $this->data['revers'] = $this->issue_model->get_revers($iss_id);
            $this->data['shout'] = $this->issue_model->get_shout($iss_id);
            $disscutions = $this->issue_model->getall_datese($iss_id);
            $this->data['disscutions'] = array();
            $this->data['disscution'] = array();
            $i=0;
            foreach ($disscutions as $disscution) {
              $this->data['disscution'] = array();
              $this->data['disscution']['appeal'] = $this->date_translatore($disscution['appeal']);
              $this->data['disscution']['id'] = $disscution['id'];
              $this->data['disscution']['case_state'] = $disscution['case_state'];
              $this->data['disscution']['report'] = $disscution['report'];
              $this->data['disscution']['date'] = $this->date_translatore($disscution['date']);
              $this->data['disscutions'][$i] = $this->data['disscution'];
              $i++;
            }
            $comments = $this->issue_model->get_comment($iss_id);
            $this->data['comments'] = array();
            $this->data['comment'] = array();
            $i=0;
            foreach ($comments as $comment) {
              $this->data['comment']['fullname'] = $comment['fullname'];
              $this->data['comment']['comment'] = $comment['comment'];
              $this->data['comment']['timestamp'] = $this->translatoer($comment['timestamp']);
              $this->data['comments'][$i] = $this->data['comment'];
              $i++;
            }
            $this->data['states'] = $this->issue_model->getall_state();
            $this->data['uploads'] = $this->issue_model->getby_fille($iss_id);
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['clients'] = $this->issue_model->getall_client();
            $this->data['client_types'] = $this->issue_model->getall_ctype();
            $this->data['opponent_types'] = $this->issue_model->getall_otype();
            $this->data['case_types'] = $this->issue_model->getall_case_type();
            $this->data['courts'] = $this->issue_model->getall_court();
            $this->load->view('issue_edit',$this->data);
          }
          catch( Exception $e) {
            show_error($e->getMessage()." _ ". $e->getTraceAsString());
          }
        }

        public function backward($iss_id) {
            if ($this->input->post('submit')) {
                $this->load->library('form_validation');
                $this->load->model('issue_model');  
                if ($this->form_validation->run() == False) {
                    $this->load->model('users_model');  
                    $form_data = array(
                        'user_id' => $this->data['user_id'],
                        'iss_id' => $iss_id,
                        'client_type' => $this->input->post('client_type'),
                        'opponent_type' => $this->input->post('opponent_type'),
                        'case_type_id' => $this->input->post('case_type_id'),
                        'court_id' => $this->input->post('court_id'),
                        'area_no' => $this->input->post('area_no'),
                        'number' => $this->input->post('number'),
                        'year' => $this->input->post('year')
                    );
                    $back_id = $this->issue_model->create_backward($form_data);
                    if (!$back_id) {
                        die("ERROR");
                    }
                    $data = array(
                        'user_id' => $this->data['user_id'],
                        'issue_id' => $iss_id,
                        'date' => $this->input->post('date'),
                        'state_id' => $this->input->post('state_id'),
                        'report' => $this->input->post('report'),
                        'appeal' => $this->input->post('appeal')
                    );
                    $date_id = $this->issue_model->create_date($data);
                    if (!$date_id) {
                        die("ERROR");
                    }
                    redirect('/issue/view/'.$iss_id);
                }
            }
            try {
                $this->load->helper('form');
                $this->load->model('issue_model');  
            	$this->data['issue'] = $this->issue_model->get_issue($iss_id);
                $this->data['states'] = $this->issue_model->getall_state();
                $this->data['client_types'] = $this->issue_model->getall_ctype();
                $this->data['opponent_types'] = $this->issue_model->getall_otype();
                $this->data['case_types'] = $this->issue_model->getall_case_type();
                $this->data['courts'] = $this->issue_model->getall_court();
                $this->data['uploads'] = $this->issue_model->getby_fille($iss_id);
                $this->load->view('add_new_backward',$this->data);
            }
            catch( Exception $e) {
                show_error($e->getMessage()." _ ". $e->getTraceAsString());
            }
        }

        public function revers($iss_id) {
            if ($this->input->post('submit')) {
                $this->load->library('form_validation');
                $this->load->model('issue_model');  
                if ($this->form_validation->run() == False) {
                    $this->load->model('users_model');  
                    $form_data = array(
                        'user_id' => $this->data['user_id'],
                        'iss_id' => $iss_id,
                        'client_type' => $this->input->post('client_type'),
                        'opponent_type' => $this->input->post('opponent_type'),
                        'case_type_id' => $this->input->post('case_type_id'),
                        'court_id' => $this->input->post('court_id'),
                        'area_no' => $this->input->post('area_no'),
                        'number' => $this->input->post('number'),
                        'year' => $this->input->post('year')
                    );
                    $rev_id = $this->issue_model->create_revers($form_data);
                    if (!$rev_id) {
                        die("ERROR");
                    }
                    $data = array(
                        'user_id' => $this->data['user_id'],
                        'issue_id' => $iss_id,
                        'date' => $this->input->post('date'),
                        'state_id' => $this->input->post('state_id'),
                        'report' => $this->input->post('report'),
                        'appeal' => $this->input->post('appeal')
                    );
                    $date_id = $this->issue_model->create_date($data);
                    if (!$date_id) {
                        die("ERROR");
                    }
                    redirect('/issue/view/'.$iss_id);
                }
            }
            try {
                $this->load->helper('form');
                $this->load->model('issue_model');  
            	$this->data['issue'] = $this->issue_model->get_issue($iss_id);
                $this->data['states'] = $this->issue_model->getall_state();
                $this->data['client_types'] = $this->issue_model->getall_ctype();
                $this->data['opponent_types'] = $this->issue_model->getall_otype();
                $this->data['case_types'] = $this->issue_model->getall_case_type();
                $this->data['courts'] = $this->issue_model->getall_court();
                $this->data['uploads'] = $this->issue_model->getby_fille($iss_id);
                $this->load->view('add_new_backward',$this->data);
            }
            catch( Exception $e) {
                show_error($e->getMessage()." _ ". $e->getTraceAsString());
            }
        }

        public function shout($iss_id) {
            if ($this->input->post('submit')) {
                $this->load->library('form_validation');
                $this->load->model('issue_model');  
                if ($this->form_validation->run() == False) {
                    $this->load->model('users_model');  
                    $form_data = array(
                        'user_id' => $this->data['user_id'],
                        'iss_id' => $iss_id,
                        'client_type' => $this->input->post('client_type'),
                        'opponent_type' => $this->input->post('opponent_type'),
                        'case_type_id' => $this->input->post('case_type_id'),
                        'court_id' => $this->input->post('court_id'),
                        'area_no' => $this->input->post('area_no'),
                        'number' => $this->input->post('number'),
                        'year' => $this->input->post('year')
                    );
                    $sht_id = $this->issue_model->create_shout($form_data);
                    if (!$sht_id) {
                        die("ERROR");
                    }
                    $data = array(
                        'user_id' => $this->data['user_id'],
                        'issue_id' => $iss_id,
                        'date' => $this->input->post('date'),
                        'state_id' => $this->input->post('state_id'),
                        'report' => $this->input->post('report'),
                        'appeal' => $this->input->post('appeal')
                    );
                    $date_id = $this->issue_model->create_date($data);
                    if (!$date_id) {
                        die("ERROR");
                    }
                    redirect('/issue/view/'.$iss_id);
                }
            }
            try {
                $this->load->helper('form');
                $this->load->model('issue_model');  
            	$this->data['issue'] = $this->issue_model->get_issue($iss_id);
                $this->data['states'] = $this->issue_model->getall_state();
                $this->data['client_types'] = $this->issue_model->getall_ctype();
                $this->data['opponent_types'] = $this->issue_model->getall_otype();
                $this->data['case_types'] = $this->issue_model->getall_case_type();
                $this->data['courts'] = $this->issue_model->getall_court();
                $this->data['uploads'] = $this->issue_model->getby_fille($iss_id);
                $this->load->view('add_new_backward',$this->data);
            }
            catch( Exception $e) {
                show_error($e->getMessage()." _ ". $e->getTraceAsString());
            }
        }

        public function discution($disc_id) {
            if ($this->input->post('submit')) {
                $this->load->library('form_validation');
                if ($this->form_validation->run() == False) {
                    $this->load->model('users_model');  
                    $this->load->model('issue_model');  
                    $discution = $this->issue_model->get_disscution($disc_id);
                    $form_data = array(
                        'date' => $this->input->post('date'),
                        'state_id' => $this->input->post('state_id'),
                        'report' => $this->input->post('report'),
                        'appeal' => $this->input->post('appeal')
                    );
                    $this->issue_model->update_disscution($form_data, $disc_id);
                    redirect('/issue/view/'.$discution['issue_id']);
                }
            }
            try {
                $this->load->helper('form');
                $this->load->model('issue_model');  
                $discution = $this->issue_model->get_disscution($disc_id);
                $this->data['discs'] = $discution;
                $this->load->model('issue_model'); 
            $issue = $this->issue_model->get_issue($discution['issue_id']);
            $this->data['issue'] = array();
            $this->data['issue']['id'] = $this->translatoer($issue['id']);
            $this->data['issue']['ids'] = $issue['id'];
            $this->data['issue']['logo'] = $issue['logo'];
            $this->data['issue']['hotel_name'] = $issue['hotel_name'];
            $this->data['issue']['client_name'] = $issue['client_name'];
            $this->data['issue']['clnt_type'] = $issue['clnt_type'];
            $this->data['issue']['opnt_type'] = $issue['opnt_type'];
            $this->data['issue']['opponent'] = $issue['opponent'];
            $this->data['issue']['opnt_address'] = $issue['opnt_address'];
            $this->data['issue']['case_type'] = $issue['case_type'];
            $this->data['issue']['court'] = $issue['court']; 
            $this->data['issue']['area_no'] = $issue['area_no'];
            $this->data['issue']['describtion'] = $issue['describtion'];
            $this->data['issue']['number'] = $this->translatoer($issue['number']);
            $this->data['issue']['year'] = $this->translatoer($issue['year']);
            $this->data['issue']['notes'] = $issue['notes'];
            $this->data['issue']['user_name'] = $issue['user_name'];
            $this->data['issue']['timestamp'] = $this->translatoer($issue['timestamp']);
            $backward = $this->issue_model->get_backward($discution['issue_id']);
            $this->data['backward'] = array();
            $this->data['backward']['id'] = $this->translatoer($backward['id']);
            $this->data['backward']['ids'] = $backward['id'];
            $this->data['backward']['clnt_type'] = $backward['clnt_type'];
            $this->data['backward']['opnt_type'] = $backward['opnt_type'];
            $this->data['backward']['case_type'] = $backward['case_type'];
            $this->data['backward']['court'] = $backward['court']; 
            $this->data['backward']['area_no'] = $backward['area_no'];
            $this->data['backward']['number'] = $this->translatoer($backward['number']);
            $this->data['backward']['year'] = $this->translatoer($backward['year']);
            $this->data['backward']['user_name'] = $backward['user_name'];
            $this->data['backward']['timestamp'] = $this->translatoer($backward['timestamp']);
            $revers = $this->issue_model->get_revers($discution['issue_id']);
            $this->data['revers'] = array();
            $this->data['revers']['id'] = $this->translatoer($revers['id']);
            $this->data['revers']['ids'] = $revers['id'];
            $this->data['revers']['clnt_type'] = $revers['clnt_type'];
            $this->data['revers']['opnt_type'] = $revers['opnt_type'];
            $this->data['revers']['case_type'] = $revers['case_type'];
            $this->data['revers']['court'] = $revers['court']; 
            $this->data['revers']['area_no'] = $revers['area_no'];
            $this->data['revers']['number'] = $this->translatoer($revers['number']);
            $this->data['revers']['year'] = $this->translatoer($revers['year']);
            $this->data['revers']['user_name'] = $revers['user_name'];
            $this->data['revers']['timestamp'] = $this->translatoer($revers['timestamp']);
            $shout = $this->issue_model->get_shout($discution['issue_id']);
            $this->data['shout'] = array();
            $this->data['shout']['id'] = $this->translatoer($shout['id']);
            $this->data['shout']['ids'] = $shout['id'];
            $this->data['shout']['clnt_type'] = $shout['clnt_type'];
            $this->data['shout']['opnt_type'] = $shout['opnt_type'];
            $this->data['shout']['case_type'] = $shout['case_type'];
            $this->data['shout']['court'] = $shout['court']; 
            $this->data['shout']['area_no'] = $shout['area_no'];
            $this->data['shout']['number'] = $this->translatoer($shout['number']);
            $this->data['shout']['year'] = $this->translatoer($shout['year']);
            $this->data['shout']['user_name'] = $shout['user_name'];
            $this->data['shout']['timestamp'] = $this->translatoer($shout['timestamp']);
            $disscutions = $this->issue_model->getall_datese($discution['issue_id']);
            $this->data['disscutions'] = array();
            $this->data['disscution'] = array();
            $i=0;
            foreach ($disscutions as $disscution) {
                $this->data['disscution'] = array();
                $this->data['disscution']['appeal'] = $this->date_translatore($disscution['appeal']);
                $this->data['disscution']['id'] = $disscution['id'];
                $this->data['disscution']['case_state'] = $disscution['case_state'];
                $this->data['disscution']['report'] = $disscution['report'];
                $this->data['disscution']['date'] = $this->date_translatore($disscution['date']);
                $this->data['disscutions'][$i] = $this->data['disscution'];
               $i++;
            }
            $comments = $this->issue_model->get_comment($discution['issue_id']);
            $this->data['comments'] = array();
            $this->data['comment'] = array();
            $i=0;
            foreach ($comments as $comment) {
               $this->data['comment']['fullname'] = $comment['fullname'];
               $this->data['comment']['comment'] = $comment['comment'];
               $this->data['comment']['timestamp'] = $this->translatoer($comment['timestamp']);
               $this->data['comments'][$i] = $this->data['comment'];
               $i++;
            }
                $this->data['states'] = $this->issue_model->getall_state();
                $this->data['uploads'] = $this->issue_model->getby_fille($discution['issue_id']);
                $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
                $this->load->view('add_new_date',$this->data);
            }
            catch( Exception $e) {
                show_error($e->getMessage()." _ ". $e->getTraceAsString());
            }
        }

        public function new_discution($issue_id) {
            if ($this->input->post('submit')) {
                $this->load->library('form_validation');
                if ($this->form_validation->run() == False) {
                    $this->load->model('users_model');  
                    $this->load->model('issue_model');  
                    $form_data = array(
                        'user_id' => $this->data['user_id'],
                        'issue_id' => $issue_id,
                        'date' => $this->input->post('date'),
                        'state_id' => $this->input->post('state_id'),
                        'report' => $this->input->post('report'),
                        'appeal' => $this->input->post('appeal')
                    );
                    $disc_id = $this->issue_model->create_date($form_data);
                    if (!$disc_id) {
                        die("ERROR");
                    }
                    redirect('/issue/view/'.$issue_id);
                }
            }
            try {
                $this->load->helper('form');
                $this->load->model('issue_model');  
                $this->load->model('issue_model'); 
            $issue = $this->issue_model->get_issue($issue_id);
            $this->data['issue'] = array();
            $this->data['issue']['id'] = $this->translatoer($issue['id']);
            $this->data['issue']['ids'] = $issue['id'];
            $this->data['issue']['logo'] = $issue['logo'];
            $this->data['issue']['hotel_name'] = $issue['hotel_name'];
            $this->data['issue']['client_name'] = $issue['client_name'];
            $this->data['issue']['clnt_type'] = $issue['clnt_type'];
            $this->data['issue']['opnt_type'] = $issue['opnt_type'];
            $this->data['issue']['opponent'] = $issue['opponent'];
            $this->data['issue']['opnt_address'] = $issue['opnt_address'];
            $this->data['issue']['case_type'] = $issue['case_type'];
            $this->data['issue']['court'] = $issue['court']; 
            $this->data['issue']['area_no'] = $issue['area_no'];
            $this->data['issue']['describtion'] = $issue['describtion'];
            $this->data['issue']['number'] = $this->translatoer($issue['number']);
            $this->data['issue']['year'] = $this->translatoer($issue['year']);
            $this->data['issue']['notes'] = $issue['notes'];
            $this->data['issue']['user_name'] = $issue['user_name'];
            $this->data['issue']['timestamp'] = $this->translatoer($issue['timestamp']);
            $backward = $this->issue_model->get_backward($issue_id);
            $this->data['backward'] = array();
            $this->data['backward']['id'] = $this->translatoer($backward['id']);
            $this->data['backward']['ids'] = $backward['id'];
            $this->data['backward']['clnt_type'] = $backward['clnt_type'];
            $this->data['backward']['opnt_type'] = $backward['opnt_type'];
            $this->data['backward']['case_type'] = $backward['case_type'];
            $this->data['backward']['court'] = $backward['court']; 
            $this->data['backward']['area_no'] = $backward['area_no'];
            $this->data['backward']['number'] = $this->translatoer($backward['number']);
            $this->data['backward']['year'] = $this->translatoer($backward['year']);
            $this->data['backward']['user_name'] = $backward['user_name'];
            $this->data['backward']['timestamp'] = $this->translatoer($backward['timestamp']);
            $revers = $this->issue_model->get_revers($issue_id);
            $this->data['revers'] = array();
            $this->data['revers']['id'] = $this->translatoer($revers['id']);
            $this->data['revers']['ids'] = $revers['id'];
            $this->data['revers']['clnt_type'] = $revers['clnt_type'];
            $this->data['revers']['opnt_type'] = $revers['opnt_type'];
            $this->data['revers']['case_type'] = $revers['case_type'];
            $this->data['revers']['court'] = $revers['court']; 
            $this->data['revers']['area_no'] = $revers['area_no'];
            $this->data['revers']['number'] = $this->translatoer($revers['number']);
            $this->data['revers']['year'] = $this->translatoer($revers['year']);
            $this->data['revers']['user_name'] = $revers['user_name'];
            $this->data['revers']['timestamp'] = $this->translatoer($revers['timestamp']);
            $shout = $this->issue_model->get_shout($issue_id);
            $this->data['shout'] = array();
            $this->data['shout']['id'] = $this->translatoer($shout['id']);
            $this->data['shout']['ids'] = $shout['id'];
            $this->data['shout']['clnt_type'] = $shout['clnt_type'];
            $this->data['shout']['opnt_type'] = $shout['opnt_type'];
            $this->data['shout']['case_type'] = $shout['case_type'];
            $this->data['shout']['court'] = $shout['court']; 
            $this->data['shout']['area_no'] = $shout['area_no'];
            $this->data['shout']['number'] = $this->translatoer($shout['number']);
            $this->data['shout']['year'] = $this->translatoer($shout['year']);
            $this->data['shout']['user_name'] = $shout['user_name'];
            $this->data['shout']['timestamp'] = $this->translatoer($shout['timestamp']);
            $disscutions = $this->issue_model->getall_datese($issue_id);
            $this->data['disscutions'] = array();
            $this->data['disscution'] = array();
            $i=0;
            foreach ($disscutions as $disscution) {
                $this->data['disscution'] = array();
                $this->data['disscution']['appeal'] = $this->date_translatore($disscution['appeal']);
                $this->data['disscution']['id'] = $disscution['id'];
                $this->data['disscution']['case_state'] = $disscution['case_state'];
                $this->data['disscution']['report'] = $disscution['report'];
                $this->data['disscution']['date'] = $this->date_translatore($disscution['date']);
                $this->data['disscutions'][$i] = $this->data['disscution'];
               $i++;
            }
            $comments = $this->issue_model->get_comment($issue_id);
            $this->data['comments'] = array();
            $this->data['comment'] = array();
            $i=0;
            foreach ($comments as $comment) {
               $this->data['comment']['fullname'] = $comment['fullname'];
               $this->data['comment']['comment'] = $comment['comment'];
               $this->data['comment']['timestamp'] = $this->translatoer($comment['timestamp']);
               $this->data['comments'][$i] = $this->data['comment'];
               $i++;
            }
                $this->data['states'] = $this->issue_model->getall_state();
                $this->data['uploads'] = $this->issue_model->getby_fille($issue_id);
                $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
                $this->load->view('add_new_disscution',$this->data);
            }
            catch( Exception $e) {
                show_error($e->getMessage()." _ ". $e->getTraceAsString());
            }
        }

        public function make_offer($iss_id) {
            $file_name = $this->do_upload("upload");
            if (!$file_name) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("issue_model");
                $this->issue_model->add($iss_id, $file_name, $this->data['user_id']);
                die("{}");
            }
        }

        public function remove_offer($iss_id, $id) {
            $file_name = $_POST['key'];
            if (!$id) {
                die(json_encode($this->data['error']));
            } else {
                $this->load->model("issue_model");
                $this->issue_model->remove($id);
                die("{}");
            }
        }

        private function do_upload($field) {
            $config['upload_path'] = 'assets/uploads/files/';
            $config['allowed_types'] = '*';
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload($field)) {
                $this->data['error'] = array('error' => $this->upload->display_errors());
                return FALSE;
            } else {
                $file = $this->upload->data();
                return $file['file_name'];
            }
        }

        public function view($iss_id) {
            //die(print_r($iss_id));
            $this->load->model('issue_model'); 
            $issue = $this->issue_model->get_issue($iss_id);
            $this->data['issue'] = array();
            $this->data['issue']['id'] = $this->translatoer($issue['id']);
            $this->data['issue']['ids'] = $issue['id'];
            $this->data['issue']['logo'] = $issue['logo'];
            $this->data['issue']['hotel_name'] = $issue['hotel_name'];
            $this->data['issue']['client_name'] = $issue['client_name'];
            $this->data['issue']['clnt_type'] = $issue['clnt_type'];
            $this->data['issue']['opnt_type'] = $issue['opnt_type'];
            $this->data['issue']['opponent'] = $issue['opponent'];
            $this->data['issue']['opnt_address'] = $issue['opnt_address'];
            $this->data['issue']['case_type'] = $issue['case_type'];
            $this->data['issue']['court'] = $issue['court']; 
            $this->data['issue']['area_no'] = $issue['area_no'];
            $this->data['issue']['describtion'] = $issue['describtion'];
            $this->data['issue']['number'] = $this->translatoer($issue['number']);
            $this->data['issue']['year'] = $this->translatoer($issue['year']);
            $this->data['issue']['notes'] = $issue['notes'];
            $this->data['issue']['user_name'] = $issue['user_name'];
            $this->data['issue']['timestamp'] = $this->translatoer($issue['timestamp']);
            $backward = $this->issue_model->get_backward($iss_id);
            $this->data['backward'] = array();
            $this->data['backward']['id'] = $this->translatoer($backward['id']);
            $this->data['backward']['ids'] = $backward['id'];
            $this->data['backward']['clnt_type'] = $backward['clnt_type'];
            $this->data['backward']['opnt_type'] = $backward['opnt_type'];
            $this->data['backward']['case_type'] = $backward['case_type'];
            $this->data['backward']['court'] = $backward['court']; 
            $this->data['backward']['area_no'] = $backward['area_no'];
            $this->data['backward']['number'] = $this->translatoer($backward['number']);
            $this->data['backward']['year'] = $this->translatoer($backward['year']);
            $this->data['backward']['user_name'] = $backward['user_name'];
            $this->data['backward']['timestamp'] = $this->translatoer($backward['timestamp']);
            $revers = $this->issue_model->get_revers($iss_id);
            $this->data['revers'] = array();
            $this->data['revers']['id'] = $this->translatoer($revers['id']);
            $this->data['revers']['ids'] = $revers['id'];
            $this->data['revers']['clnt_type'] = $revers['clnt_type'];
            $this->data['revers']['opnt_type'] = $revers['opnt_type'];
            $this->data['revers']['case_type'] = $revers['case_type'];
            $this->data['revers']['court'] = $revers['court']; 
            $this->data['revers']['area_no'] = $revers['area_no'];
            $this->data['revers']['number'] = $this->translatoer($revers['number']);
            $this->data['revers']['year'] = $this->translatoer($revers['year']);
            $this->data['revers']['user_name'] = $revers['user_name'];
            $this->data['revers']['timestamp'] = $this->translatoer($revers['timestamp']);
            $shout = $this->issue_model->get_shout($iss_id);
            $this->data['shout'] = array();
            $this->data['shout']['id'] = $this->translatoer($shout['id']);
            $this->data['shout']['ids'] = $shout['id'];
            $this->data['shout']['clnt_type'] = $shout['clnt_type'];
            $this->data['shout']['opnt_type'] = $shout['opnt_type'];
            $this->data['shout']['case_type'] = $shout['case_type'];
            $this->data['shout']['court'] = $shout['court']; 
            $this->data['shout']['area_no'] = $shout['area_no'];
            $this->data['shout']['number'] = $this->translatoer($shout['number']);
            $this->data['shout']['year'] = $this->translatoer($shout['year']);
            $this->data['shout']['user_name'] = $shout['user_name'];
            $this->data['shout']['timestamp'] = $this->translatoer($shout['timestamp']);
            $disscutions = $this->issue_model->getall_datese($iss_id);
            $this->data['disscutions'] = array();
            $this->data['disscution'] = array();
            $i=0;
            foreach ($disscutions as $disscution) {
                $this->data['disscution'] = array();
                $this->data['disscution']['appeal'] = $this->date_translatore($disscution['appeal']);
                $this->data['disscution']['id'] = $disscution['id'];
                $this->data['disscution']['case_state'] = $disscution['case_state'];
                $this->data['disscution']['report'] = $disscution['report'];
                $this->data['disscution']['date'] = $this->date_translatore($disscution['date']);
                $this->data['disscutions'][$i] = $this->data['disscution'];
               $i++;
            }
            $comments = $this->issue_model->get_comment($iss_id);
            $this->data['comments'] = array();
            $this->data['comment'] = array();
            $i=0;
            foreach ($comments as $comment) {
               $this->data['comment']['fullname'] = $comment['fullname'];
               $this->data['comment']['comment'] = $comment['comment'];
               $this->data['comment']['timestamp'] = $this->translatoer($comment['timestamp']);
               $this->data['comments'][$i] = $this->data['comment'];
               $i++;
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->data['uploads'] = $this->issue_model->getby_fille($iss_id);
            $this->load->view('issue_view', $this->data);
        }

        public function view_all() {
            $this->load->model('issue_model'); 
            $issues = $this->issue_model->getall_issue();  
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            foreach ($issues as $key => $iss) {
                $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
            }
            //die(print_r($issues));
            $this->data['issues'] = array();
            $i=0;
            $this->data['issue'] = array();
            $this->data['dates'] = array();
            $this->data['backward'] = array();
            $this->data['revers'] = array();
            $this->data['shout'] = array();
            foreach ($issues as $issue) {
                $this->data['issue']['ids'] = $issue['id'];
                $this->data['issue']['id'] = $this->translatoer($issue['id']);
                $this->data['issue']['hotel_name'] = $issue['hotel_name'];
                $this->data['issue']['user_name'] = $issue['user_name'];
                $this->data['issue']['year'] = $this->translatoer($issue['year']);
                $this->data['issue']['number'] = $this->translatoer($issue['number']);
                $this->data['issue']['client_name'] = $issue['client_name'];
                $this->data['issue']['clnt_type'] = $issue['clnt_type'];
                $this->data['issue']['opponent'] = $issue['opponent'];
                $this->data['issue']['opnt_address'] = $issue['opnt_address'];
                $this->data['issue']['opnt_type'] = $issue['opnt_type'];
                $this->data['issue']['case_type'] = $issue['case_type'];
                $this->data['issue']['court'] = $issue['court'];
                $this->data['issue']['describtion'] = $issue['describtion'];
                $this->data['backward']['id'] = $issue['backward']['id'];
                $this->data['backward']['clnt_type'] = $issue['backward']['clnt_type'];
                $this->data['backward']['opnt_type'] = $issue['backward']['opnt_type'];
                $this->data['backward']['case_type'] = $issue['backward']['case_type'];
                $this->data['backward']['court'] = $issue['backward']['court']; 
                $this->data['backward']['area_no'] = $issue['backward']['area_no'];
                $this->data['backward']['number'] = $this->translatoer($issue['backward']['number']);
                $this->data['backward']['year'] = $this->translatoer($issue['backward']['year']);
                $this->data['issue']['backward'] = $this->data['backward'];
                $this->data['revers']['id'] = $issue['revers']['id'];
                $this->data['revers']['clnt_type'] = $issue['revers']['clnt_type'];
                $this->data['revers']['opnt_type'] = $issue['revers']['opnt_type'];
                $this->data['revers']['case_type'] = $issue['revers']['case_type'];
                $this->data['revers']['court'] = $issue['revers']['court']; 
                $this->data['revers']['area_no'] = $issue['revers']['area_no'];
                $this->data['revers']['number'] = $this->translatoer($issue['revers']['number']);
                $this->data['revers']['year'] = $this->translatoer($issue['revers']['year']);
                $this->data['issue']['revers'] = $this->data['revers'];
                $this->data['shout']['id'] = $issue['shout']['id'];
                $this->data['shout']['clnt_type'] = $issue['shout']['clnt_type'];
                $this->data['shout']['opnt_type'] = $issue['shout']['opnt_type'];
                $this->data['shout']['case_type'] = $issue['shout']['case_type'];
                $this->data['shout']['court'] = $issue['shout']['court']; 
                $this->data['shout']['area_no'] = $issue['shout']['area_no'];
                $this->data['shout']['number'] = $this->translatoer($issue['shout']['number']);
                $this->data['shout']['year'] = $this->translatoer($issue['shout']['year']);
                $this->data['issue']['shout'] = $this->data['shout'];
                $y = 0;
                $this->data['issue']['count'] = $this->issue_model->getall_date_count($issue['id']);
                foreach ($issue['dates'] as $dates) {
                    $this->data['dates']['date'] = $this->date_translatore($dates['date']);
                    $this->data['dates']['report'] = $this->date_translatore($dates['report']);
                    $this->data['issue']['dates'][$y] = $this->data['dates'];                    
                    $y++;
                }
                
                $this->data['issues'][$i] = $this->data['issue'];
                $i++;
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->load->view('issue_all_view', $this->data);
        }

        public function comment($iss_id){
            if ($this->input->post('submit')) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('comment','Comment','trim|required');
                if ($this->form_validation->run() == TRUE) {
                  $comment = $this->input->post('comment'); 
                  $this->load->model('issue_model');
                  $comment_data = array(
                    'user_id' => $this->data['user_id'],
                    'issue_id' => $iss_id,
                    'comment' => $comment
                  );
                  $this->issue_model->insert_comment($comment_data);
                    redirect('/issue/view/'.$iss_id);
                }
            }
        }

        public function running($state) {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['states'] = $this->issue_model->getall_state();  
            $this->data['state'] =  $this->issue_model->get_state($state);
            $issues = $this->issue_model->getall_issue();  
            foreach ($issues as $key => $iss) {
                $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
            }
            $issu =  array();
            $i=0;
            foreach ($issues as $issue) {
                    if($issue['dates'][0]['state_id'] == $state){
                        $issu[$i] = $this->issue_model->get_issue($issue['id']);
                        $issu[$i]['dates'] = $this->issue_model->getall_date($issue['id']);
                        $issu[$i]['backward'] = $this->issue_model->get_backward($issue['id']);
                        $issu[$i]['revers'] = $this->issue_model->get_revers($issue['id']);
                        $issu[$i]['shout'] = $this->issue_model->get_shout($issue['id']);
                        $i++;
                    }
                }
                $this->data['issues'] = array();
                $x=0;
                $this->data['issue'] = array();
                $this->data['dates'] = array();
                $this->data['backward'] = array();
                $this->data['revers'] = array();
                $this->data['shout'] = array();
                foreach ($issu as $iss) {
                    $this->data['issue']['ids'] = $iss['id'];
                    $this->data['issue']['id'] = $this->translatoer($iss['id']);
                    $this->data['issue']['hotel_name'] = $iss['hotel_name'];
                    $this->data['issue']['user_name'] = $iss['user_name'];
                    $this->data['issue']['year'] = $this->translatoer($iss['year']);
                    $this->data['issue']['number'] = $this->translatoer($iss['number']);
                    $this->data['issue']['client_name'] = $iss['client_name'];
                    $this->data['issue']['clnt_type'] = $iss['clnt_type'];
                    $this->data['issue']['opponent'] = $iss['opponent'];
                    $this->data['issue']['opnt_address'] = $iss['opnt_address'];
                    $this->data['issue']['opnt_type'] = $iss['opnt_type'];
                    $this->data['issue']['case_type'] = $iss['case_type'];
                    $this->data['issue']['court'] = $iss['court'];
                    $this->data['issue']['describtion'] = $iss['describtion'];
                    $this->data['backward']['id'] = $iss['backward']['id'];
                    $this->data['backward']['clnt_type'] = $iss['backward']['clnt_type'];
                    $this->data['backward']['opnt_type'] = $iss['backward']['opnt_type'];
                    $this->data['backward']['case_type'] = $iss['backward']['case_type'];
                    $this->data['backward']['court'] = $iss['backward']['court']; 
                    $this->data['backward']['area_no'] = $iss['backward']['area_no'];
                    $this->data['backward']['number'] = $this->translatoer($iss['backward']['number']);
                    $this->data['backward']['year'] = $this->translatoer($iss['backward']['year']);
                    $this->data['issue']['backward'] = $this->data['backward'];
                    $this->data['revers']['id'] = $iss['revers']['id'];
                    $this->data['revers']['clnt_type'] = $iss['revers']['clnt_type'];
                    $this->data['revers']['opnt_type'] = $iss['revers']['opnt_type'];
                    $this->data['revers']['case_type'] = $iss['revers']['case_type'];
                    $this->data['revers']['court'] = $iss['revers']['court']; 
                    $this->data['revers']['area_no'] = $iss['revers']['area_no'];
                    $this->data['revers']['number'] = $this->translatoer($iss['revers']['number']);
                    $this->data['revers']['year'] = $this->translatoer($iss['revers']['year']);
                    $this->data['issue']['revers'] = $this->data['revers'];
                    $this->data['shout']['id'] = $iss['shout']['id'];
                    $this->data['shout']['clnt_type'] = $iss['shout']['clnt_type'];
                    $this->data['shout']['opnt_type'] = $iss['shout']['opnt_type'];
                    $this->data['shout']['case_type'] = $iss['shout']['case_type'];
                    $this->data['shout']['court'] = $iss['shout']['court']; 
                    $this->data['shout']['area_no'] = $iss['shout']['area_no'];
                    $this->data['shout']['number'] = $this->translatoer($iss['shout']['number']);
                    $this->data['shout']['year'] = $this->translatoer($iss['shout']['year']);
                    $this->data['issue']['shout'] = $this->data['shout'];
                $y = 0;
                $this->data['issue']['count'] = $this->issue_model->getall_date_count($iss['id']);
                foreach ($iss['dates'] as $dates) {
                    $this->data['dates']['date'] = $this->date_translatore($dates['date']);
                    $this->data['dates']['report'] = $this->date_translatore($dates['report']);
                    $this->data['issue']['dates'][$y] = $this->data['dates'];                    
                    $y++;
                }
                
                $this->data['issues'][$i] = $this->data['issue'];
                $i++;
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('running_view', $this->data);
        }

        public function translate($data) {
          if ($data == "su") {
            $word ="أح";
          }elseif ($data == "SU") {
            $word ="أح";
          }elseif ($data == "sun") {
            $word ="أح";
          }elseif ($data == "SUN") {
            $word ="أح";
          }elseif ($data == "mo") {
            $word ="إث";
          }elseif ($data == "MO") {
            $word ="إث";
          }elseif ($data == "mon") {
            $word ="إث";
          }elseif ($data == "MON") {
            $word ="إث";
          }elseif ($data == "tu") {
            $word ="ثل";
          }elseif ($data == "TU") {
            $word ="ثل";
          }elseif ($data == "tue") {
            $word ="ثل";
          }elseif ($data == "TUE") {
            $word ="ثل";
          }elseif ($data == "we") {
            $word ="الأربعاء";
          }elseif ($data == "WE") {
            $word ="الأربعاء";
          }elseif ($data == "wed") {
            $word ="الأربعاء";
          }elseif ($data == "Wed") {
            $word ="الأربعاء";
          }elseif ($data == "WED") {
            $word ="الأربعاء";
          }elseif ($data == "th") {
            $word ="خم";
          }elseif ($data == "TH") {
            $word ="خم";
          }elseif ($data == "thu") {
            $word ="خم";
          }elseif ($data == "THU") {
            $word ="خم";
          }elseif ($data == "fr") {
            $word ="جم";
          }elseif ($data == "FR") {
            $word ="جم";
          }elseif ($data == "fri") {
            $word ="جم";
          }elseif ($data == "FRI") {
            $word ="جم";
          }elseif ($data == "sa") {
            $word ="سب";
          }elseif ($data == "SA") {
            $word ="سب";
          }elseif ($data == "sat") {
            $word ="سب";
          }elseif ($data == "SAT") {
            $word ="سب";
          }else{
            $word = $data;
          }
          return $word;
        }

    public function translatoer($datas) {
      $datass = str_split($datas);
       $word = array();
      foreach ($datass as $data) {
        if ($data == "0") {
          $word[] ="٠";
        }elseif ($data == "1") {
          $word[] ="١";
        }elseif ($data == "2") {
          $word[] ="٢";
        }elseif ($data == "3") {
          $word[] ="٣";
        }elseif ($data == "4") {
          $word[] ="٤";
        }elseif ($data == "5") {
          $word[] ="٥";
        }elseif ($data == "6") {
          $word[] ="٦";
        }elseif ($data == "7") {
          $word[] ="٧";
        }elseif ($data == "8") {
          $word[] ="٨";
        }elseif ($data == "9") {
          $word[] ="٩";
        }else{
          $word[] = $data;
        }
      }
        $words = implode("",$word);
      return $words;
    }

      public function date_translatore($datas) {
          $datass = explode("-",$datas);
           $word = array();
          foreach ($datass as $data) {
              if ($data == "0") {
                $word[] ="٠";
              }elseif ($data == "1") {
                $word[] ="١";
              }elseif ($data == "2") {
                $word[] ="٢";
              }elseif ($data == "3") {
                $word[] ="٣";
              }elseif ($data == "4") {
                $word[] ="٤";
              }elseif ($data == "5") {
                $word[] ="٥";
              }elseif ($data == "6") {
                $word[] ="٦";
              }elseif ($data == "7") {
                $word[] ="٧";
              }elseif ($data == "8") {
                $word[] ="٨";
              }elseif ($data == "9") {
                $word[] ="٩";
              }elseif ($data == "10") {
                $word[] ="١٠";
              }elseif ($data == "11") {
                $word[] ="١١";
              }elseif ($data == "12") {
                $word[] ="١٢";
              }elseif ($data == "13") {
                $word[] ="١٣";
              }elseif ($data == "14") {
                $word[] ="١٤";
              }elseif ($data == "15") {
                $word[] ="١٥";
              }elseif ($data == "16") {
                $word[] ="١٦";
              }elseif ($data == "17") {
                $word[] ="١٧";
              }elseif ($data == "18") {
                $word[] ="١٨";
              }elseif ($data == "19") {
                $word[] ="١٩";
              }elseif ($data == "20") {
                $word[] ="٢٠";
              }elseif ($data == "21") {
                $word[] ="٢١";
              }elseif ($data == "22") {
                $word[] ="٢٢";
              }elseif ($data == "23") {
                $word[] ="٢٣";
              }elseif ($data == "24") {
                $word[] ="٢٤";
              }elseif ($data == "25") {
                $word[] ="٢٥";
              }elseif ($data == "26") {
                $word[] ="٢٦";
              }elseif ($data == "27") {
                $word[] ="٢٧";
              }elseif ($data == "28") {
                $word[] ="٢٨";
              }elseif ($data == "29") {
                $word[] ="٢٩";
              }elseif ($data == "30") {
                $word[] ="٣٠";
              }elseif ($data == "31") {
                $word[] ="٣١";
              }elseif ($data == "2011") {
                $word[] ="٢٠١١";
              }elseif ($data == "2012") {
                $word[] ="٢٠١٢";
              }elseif ($data == "2013") {
                $word[] ="٢٠١٣";
              }elseif ($data == "2014") {
                $word[] ="٢٠١٤";
              }elseif ($data == "2015") {
                $word[] ="٢٠١٥";
              }elseif ($data == "2016") {
                $word[] ="٢٠١٦";
              }elseif ($data == "2017") {
                $word[] ="٢٠١٧";
              }elseif ($data == "2018") {
                $word[] ="٢٠١٨";
              }elseif ($data == "2019") {
                $word[] ="٢٠١٩";
              }elseif ($data == "2020") {
                $word[] ="٢٠٢٠";
              }elseif ($data == "2021") {
                $word[] ="٢٠٢١";
              }elseif ($data == "2022") {
                $word[] ="٢٠٢٢";
              }elseif ($data == "2023") {
                $word[] ="٢٠٢٣";
              }elseif ($data == "2024") {
                $word[] ="٢٠٢٤";
              }elseif ($data == "2025") {
                $word[] ="٢٠٢٥";
              }else{
                $word[] = $data;
              }
            }
            $words = implode("/",$word);
            return $words;
        }

    }
?>