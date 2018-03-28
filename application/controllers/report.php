<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class report extends CI_Controller {
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

        public function hotel_menu() {
            $this->load->model('users_model');
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('hotel_select', $this->data);
        }

        public function report_hotel() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            if ($this->input->post('submit')) {
                $hotel = $this->input->post('hotel_id');
                $issues = $this->issue_model->get_issue_hotel($hotel);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['hotel'] = $this->issue_model->get_hotel($hotel);
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_hotel', $this->data);
        }

        public function report_hotel_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            if ($this->input->post('submit')) {
                $hotel = $this->input->post('hotel_id');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $issu = $this->issue_model->get_issue_date_hotel($date, $date1, $hotel);
                $iss =  array();
                foreach ($issu as $is) {
                  $iss[] = $is['issue_id'];
                }
                $issus = array_count_values($iss); 
                $issues = array();
                $i = 0;
                foreach ($issus as $key => $value) {
                  $issues[$i] = $this->issue_model->get_issue($key);
                  $i++;
                }
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
                $this->data['hotel'] = $this->issue_model->get_hotel($hotel);
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_hotel_selected', $this->data);
        }

        public function report_num() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $isses = $this->issue_model->getall_issue(); 
            $iss =  array();
            foreach ($isses as $is) {
              $iss[] = $is['number'];
            }
            $issus = array_count_values($iss); 
            $this->data['isses'] =  array();
            $i=0;
            foreach ($issus as $key => $value) {
                $this->data['iss']['numbers'] = $this->translatoer($key);
                $this->data['iss']['number'] = $key;
                $this->data['isses'][$i] = $this->data['iss'];
                $i++;
            }
            if ($this->input->post('submit')) {
                $num = $this->input->post('number');
                $issues = $this->issue_model->get_issue_num($num);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['num'] = $this->translatoer($num);
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_num', $this->data);
        }

        public function year_menu() {
            $this->load->model('users_model');
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('year_select', $this->data);
        }

        public function report_year_all() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $isses = $this->issue_model->getall_issue(); 
            $iss =  array();
            foreach ($isses as $is) {
              $iss[] = $is['year'];
            }
            $issus = array_count_values($iss); 
            $this->data['isses'] =  array();
            $i=0;
            foreach ($issus as $key => $value) {
                $this->data['iss']['year'] = $this->translatoer($key);
                $this->data['iss']['years'] = $key;
                $this->data['isses'][$i] = $this->data['iss'];
                $i++;
            }
            if ($this->input->post('submit')) {
                $year = $this->input->post('year');
                $issues = $this->issue_model->get_issue_year($year);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['year'] = $this->translatoer($year);
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_year', $this->data);
        }

        public function report_year() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $isses = $this->issue_model->getall_issue(); 
            $iss =  array();
            foreach ($isses as $is) {
              $iss[] = $is['year'];
            }
            $issus = array_count_values($iss); 
            $this->data['isses'] =  array();
            $i=0;
            foreach ($issus as $key => $value) {
                $this->data['iss']['year'] = $this->translatoer($key);
                $this->data['iss']['years'] = $key;
                $this->data['isses'][$i] = $this->data['iss'];
                $i++;
            }
            if ($this->input->post('submit')) {
                $hotel = $this->input->post('hotel_id');
                $year = $this->input->post('year');
                $issues = $this->issue_model->get_issue_year_hotel($year, $hotel);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['year'] = $this->translatoer($year);
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_year_hotel', $this->data);
        }

        public function report_year_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $isses = $this->issue_model->getall_issue(); 
            $iss =  array();
            foreach ($isses as $is) {
              $iss[] = $is['year'];
            }
            $issus = array_count_values($iss); 
            $this->data['isses'] =  array();
            $i=0;
            foreach ($issus as $key => $value) {
                $this->data['iss']['year'] = $this->translatoer($key);
                $this->data['iss']['years'] = $key;
                $this->data['isses'][$i] = $this->data['iss'];
                $i++;
            }
            if ($this->input->post('submit')) {
                $year = $this->input->post('year');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $issu = $this->issue_model->get_issue_date_year($date, $date1, $year);
                //die(print_r($issu));
                $iss =  array();
                foreach ($issu as $is) {
                  $iss[] = $is['issue_id'];
                }
                $issus = array_count_values($iss); 
                $issues = array();
                $i = 0;
                foreach ($issus as $key => $value) {
                  $issues[$i] = $this->issue_model->get_issue($key);
                  $i++;
                }
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
                $this->data['year'] = $year;
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_year_selected', $this->data);
        }

        public function report_year_hotel_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $isses = $this->issue_model->getall_issue(); 
            $iss =  array();
            foreach ($isses as $is) {
              $iss[] = $is['year'];
            }
            $issus = array_count_values($iss); 
            $this->data['isses'] =  array();
            $i=0;
            foreach ($issus as $key => $value) {
                $this->data['iss']['year'] = $this->translatoer($key);
                $this->data['iss']['years'] = $key;
                $this->data['isses'][$i] = $this->data['iss'];
                $i++;
            }
            if ($this->input->post('submit')) {
                $year = $this->input->post('year');
                $hotel = $this->input->post('hotel_id');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $issu = $this->issue_model->get_issue_date_hotel_year($date, $date1, $year, $hotel);
                //die(print_r($issu));
                $iss =  array();
                foreach ($issu as $is) {
                  $iss[] = $is['issue_id'];
                }
                $issus = array_count_values($iss); 
                $issues = array();
                $i = 0;
                foreach ($issus as $key => $value) {
                  $issues[$i] = $this->issue_model->get_issue($key);
                  $i++;
                }
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
                $this->data['year'] = $year;
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_year_hotel_selected', $this->data);
        }



        public function clnt_menu() {
            $this->load->model('users_model');
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('clnt_select', $this->data);
        }

        public function report_clnt_all() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['clients'] = $this->issue_model->getall_client();
            if ($this->input->post('submit')) {
                $clnt = $this->input->post('client_id');
                $issues = $this->issue_model->get_issue_clnt($clnt);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['clnt'] = $this->issue_model->get_clnt($clnt);
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_clnt', $this->data);
        }

        public function report_clnt() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['clients'] = $this->issue_model->getall_client();
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            if ($this->input->post('submit')) {
                $clnt = $this->input->post('client_id');
                $hotel = $this->input->post('hotel_id');
                $issues = $this->issue_model->get_issue_hotel_clnt($clnt, $hotel);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['clnt'] = $this->issue_model->get_clnt($clnt);
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_clnt_hotel', $this->data);
        }

        public function report_clnt_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['clients'] = $this->issue_model->getall_client();
            if ($this->input->post('submit')) {
                $clnt = $this->input->post('client_id');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $issu = $this->issue_model->get_issue_date_clnt($date, $date1, $clnt);
                //die(print_r($issu));
                $iss =  array();
                foreach ($issu as $is) {
                  $iss[] = $is['issue_id'];
                }
                $issus = array_count_values($iss); 
                $issues = array();
                $i = 0;
                foreach ($issus as $key => $value) {
                  $issues[$i] = $this->issue_model->get_issue($key);
                  $i++;
                }
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
                $this->data['clnt'] = $this->issue_model->get_clnt($clnt);
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->data['users'] = $this->issue_model->getall_users();
            $this->load->view('report_clnt_selected', $this->data);
        }

        public function report_clnt_hotel_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['clients'] = $this->issue_model->getall_client();
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            if ($this->input->post('submit')) {
                $clnt = $this->input->post('client_id');
                $hotel = $this->input->post('hotel_id');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $issu = $this->issue_model->get_issue_date_hotel_clnt($date, $date1, $clnt, $hotel);
                //die(print_r($issu));
                $iss =  array();
                foreach ($issu as $is) {
                  $iss[] = $is['issue_id'];
                }
                $issus = array_count_values($iss); 
                $issues = array();
                $i = 0;
                foreach ($issus as $key => $value) {
                  $issues[$i] = $this->issue_model->get_issue($key);
                  $i++;
                }
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
                $this->data['clnt'] = $this->issue_model->get_clnt($clnt);
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->data['users'] = $this->issue_model->getall_users();
            $this->load->view('report_hotel_clnt_selected', $this->data);
        }

        public function opnt_menu() {
            $this->load->model('users_model');
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('opnt_select', $this->data);
        }

        public function report_opnt_all() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            if ($this->input->post('submit')) {
                $opnt = $this->input->post('opponent');
                $issues = $this->issue_model->get_issue_opnt($opnt);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['opnt'] = $opnt;
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);  
            $this->load->view('report_opnt', $this->data);
        }

        public function report_opnt() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            if ($this->input->post('submit')) {
                $opnt = $this->input->post('opponent');
                $hotel = $this->input->post('hotel_id');
                $issues = $this->issue_model->get_issue_opnt_hotel($opnt, $hotel);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['opnt'] = $opnt;
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);  
            $this->load->view('report_opnt_hotel', $this->data);
        }

        public function report_opnt_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            if ($this->input->post('submit')) {
                $opnt = $this->input->post('opponent');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $issu = $this->issue_model->get_issue_date_opnt($date, $date1, $opnt);
                //die(print_r($issu));
                $iss =  array();
                foreach ($issu as $is) {
                  $iss[] = $is['issue_id'];
                }
                $issus = array_count_values($iss); 
                $issues = array();
                $i = 0;
                foreach ($issus as $key => $value) {
                  $issues[$i] = $this->issue_model->get_issue($key);
                  $i++;
                }
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
                $this->data['opnt'] = $opnt;
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->data['users'] = $this->issue_model->getall_users();
            $this->load->view('report_opnt_selected', $this->data);
        }

        public function report_opnt_hotel_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            if ($this->input->post('submit')) {
                $opnt = $this->input->post('opponent');
                $hotel = $this->input->post('hotel_id');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $issu = $this->issue_model->get_issue_date_hotel_opnt($date, $date1, $opnt, $hotel);
                //die(print_r($issu));
                $iss =  array();
                foreach ($issu as $is) {
                  $iss[] = $is['issue_id'];
                }
                $issus = array_count_values($iss); 
                $issues = array();
                $i = 0;
                foreach ($issus as $key => $value) {
                  $issues[$i] = $this->issue_model->get_issue($key);
                  $i++;
                }
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
                $this->data['opnt'] = $opnt;
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->data['users'] = $this->issue_model->getall_users();
            $this->load->view('report_hotel_opnt_selected', $this->data);
        }

        public function report_date() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            if ($this->input->post('submit')) {
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $issu = $this->issue_model->get_issue_date($date, $date1);
                $iss =  array();
            foreach ($issu as $is) {
              $iss[] = $is['issue_id'];
            }
            $issus = array_count_values($iss); 
        $issues = array();
        $i = 0;
        foreach ($issus as $key => $value) {
          $issues[$i] = $this->issue_model->get_issue($key);
          $i++;
        }
        foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_date', $this->data);
        }

        public function type_menu() {
            $this->load->model('users_model');
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('type_select', $this->data);
        }

        public function report_type_all() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['case_types'] = $this->issue_model->getall_case_type();
            if ($this->input->post('submit')) {
                $type = $this->input->post('type');
                $issues = $this->issue_model->get_issue_type($type);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['type'] = $this->issue_model->get_type($type);
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_type', $this->data);
        }

        public function report_type() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['case_types'] = $this->issue_model->getall_case_type();
            if ($this->input->post('submit')) {
                $type = $this->input->post('type');
                $hotel = $this->input->post('hotel_id');
                $issues = $this->issue_model->get_issue_type_hotel($type, $hotel);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['type'] = $this->issue_model->get_type($type);
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_type_hotel', $this->data);
        }

        public function report_type_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['case_types'] = $this->issue_model->getall_case_type();
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            if ($this->input->post('submit')) {
                $type = $this->input->post('type');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $issu = $this->issue_model->get_issue_date_type($date, $date1, $type);
                //die(print_r($issu));
                $iss =  array();
                foreach ($issu as $is) {
                  $iss[] = $is['issue_id'];
                }
                $issus = array_count_values($iss); 
                $issues = array();
                $i = 0;
                foreach ($issus as $key => $value) {
                  $issues[$i] = $this->issue_model->get_issue($key);
                  $i++;
                }
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
                $this->data['type'] = $this->issue_model->get_type($type);
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->data['users'] = $this->issue_model->getall_users();
            $this->load->view('report_type_selected', $this->data);
        }

        public function report_type_hotel_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['case_types'] = $this->issue_model->getall_case_type();
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            if ($this->input->post('submit')) {
                $type = $this->input->post('type');
                $hotel = $this->input->post('hotel_id');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $issu = $this->issue_model->get_issue_date_hotel_type($date, $date1, $type, $hotel);
                //die(print_r($issu));
                $iss =  array();
                foreach ($issu as $is) {
                  $iss[] = $is['issue_id'];
                }
                $issus = array_count_values($iss); 
                $issues = array();
                $i = 0;
                foreach ($issus as $key => $value) {
                  $issues[$i] = $this->issue_model->get_issue($key);
                  $i++;
                }
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
                $this->data['type'] = $this->issue_model->get_type($type);
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->data['users'] = $this->issue_model->getall_users();
            $this->load->view('report_hotel_type_selected', $this->data);
        }

        public function cort_menu() {
            $this->load->model('users_model');
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('cort_select', $this->data);
        }

        public function report_cort_all() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['courts'] = $this->issue_model->getall_court();
            if ($this->input->post('submit')) {
                $cort = $this->input->post('cort');
                $issues = $this->issue_model->get_issue_cort($cort);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['cort'] = $this->issue_model->get_cort($cort);
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_cort', $this->data);
        }

        public function report_cort() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['courts'] = $this->issue_model->getall_court();
            if ($this->input->post('submit')) {
                $hotel = $this->input->post('hotel_id');
                $cort = $this->input->post('cort');
                $issues = $this->issue_model->get_issue_cort_hotel($cort, $hotel);
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['cort'] = $this->issue_model->get_cort($cort);
            }
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['users'] = $this->issue_model->getall_users();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_cort_hotel', $this->data);
        }

        public function report_cort_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['courts'] = $this->issue_model->getall_court();
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            if ($this->input->post('submit')) {
                $cort = $this->input->post('cort');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $issu = $this->issue_model->get_issue_date_cort($date, $date1, $cort);
                //die(print_r($issu));
                $iss =  array();
                foreach ($issu as $is) {
                  $iss[] = $is['issue_id'];
                }
                $issus = array_count_values($iss); 
                $issues = array();
                $i = 0;
                foreach ($issus as $key => $value) {
                  $issues[$i] = $this->issue_model->get_issue($key);
                  $i++;
                }
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
                $this->data['cort'] = $this->issue_model->get_cort($cort);
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->data['users'] = $this->issue_model->getall_users();
            $this->load->view('report_cort_selected', $this->data);
        }

        public function report_cort_hotel_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['courts'] = $this->issue_model->getall_court();
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            if ($this->input->post('submit')) {
                $cort = $this->input->post('cort');
                $hotel = $this->input->post('hotel_id');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $issu = $this->issue_model->get_issue_date_hotel_cort($date, $date1, $cort, $hotel);
                //die(print_r($issu));
                $iss =  array();
                foreach ($issu as $is) {
                  $iss[] = $is['issue_id'];
                }
                $issus = array_count_values($iss); 
                $issues = array();
                $i = 0;
                foreach ($issus as $key => $value) {
                  $issues[$i] = $this->issue_model->get_issue($key);
                  $i++;
                }
                foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
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
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
                $this->data['cort'] = $this->issue_model->get_cort($cort);
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->data['users'] = $this->issue_model->getall_users();
            $this->load->view('report_hotel_cort_selected', $this->data);
        }

        public function state_menu() {
            $this->load->model('users_model');
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('state_select', $this->data);
        }

        public function report_monthly() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            if ($this->input->post('submit')) {
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $hotels = $this->issue_model->getall_hotel();
                $this->data['issues_hotel'] = array();
                $x = 0;
                foreach ($hotels as $hotel) {
                    $this->data['issues_hotel'][$x]['hotel_name']= $hotel['name'];
                    $issu = $this->issue_model->get_issue_monthly($date, $date1, $hotel['id']);
                    $iss =  array();
                    foreach ($issu as $is) {
                        $iss[] = $is['issue_id'];
                    }
                    $issus = array_count_values($iss); 
                    $issues = array();
                    $d = 0;
                    foreach ($issus as $key => $value) {
                        $issues[$d] = $this->issue_model->get_issue($key);
                        $d++;
                    }
                    foreach ($issues as $key => $iss) {
                    $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                    $issues[$key]['backward'] = $this->issue_model->get_backward($issues[$key]['id']);
                    $issues[$key]['revers'] = $this->issue_model->get_revers($issues[$key]['id']);
                    $issues[$key]['shout'] = $this->issue_model->get_shout($issues[$key]['id']);
                }
                $this->data['issues'] = array();
                $i=0;
                $this->data['issue'] = array();
                $this->data['dates'] = array();
                $this->data['backward'] = array();
                $this->data['revers'] = array();
                $this->data['shout'] = array();
                $c=0;
                foreach ($issues as $issue) {
                    $c++;
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
                    $this->data['issues_hotel'][$x]['issues'] = $this->data['issues'];
                    $this->data['issues_hotel'][$x]['count'] = $this->translatoer($c);
                    $x++;
                }
                $this->data['date'] = $this->date_translatore($date);
                $this->data['date1'] = $this->date_translatore($date1);
            }
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_monthly', $this->data);
        }

        public function report_state() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['states'] = $this->issue_model->getall_state();  
            if ($this->input->post('submit')) {
                $state = $this->input->post('state');
                $this->data['state'] =  $this->issue_model->get_state($state);
                //die(print_r($this->data['state']));
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
                    
                    $this->data['issues'][$x] = $this->data['issue'];
                    $x++;
                }
        	}
            //die(print_r($this->data['issues']));
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_state', $this->data);
        }

        public function report_state_hotel() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['states'] = $this->issue_model->getall_state();  
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            if ($this->input->post('submit')) {
                $state = $this->input->post('state');
                $hotel = $this->input->post('hotel_id');
                $this->data['state'] =  $this->issue_model->get_state($state);
                //die(print_r($this->data['state']));
            	$issues = $this->issue_model->getall_issue_hotel($hotel);  
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
                    
                    $this->data['issues'][$x] = $this->data['issue'];
                    $x++;
                }
            }
            //die(print_r($this->data['issues']));
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_state_hotel', $this->data);
        }

        public function report_state_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['states'] = $this->issue_model->getall_state();  
            if ($this->input->post('submit')) {
                $state = $this->input->post('state');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $this->data['state'] =  $this->issue_model->get_state($state);
                $issu = $this->issue_model->get_issue_date($date, $date1);
                $iss =  array();
	            foreach ($issu as $is) {
	              $iss[] = $is['issue_id'];
	            }
	            $issus = array_count_values($iss); 
		        $issues = array();
		        $i = 0;
		        foreach ($issus as $key => $value) {
		          $issues[$i] = $this->issue_model->get_issue($key);
		          $i++;
		        }
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
                    
                    $this->data['issues'][$x] = $this->data['issue'];
                    $x++;
                }
        	}
            //die(print_r($this->data['issues']));
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_state_selected', $this->data);
        }

        public function report_state_hotel_selected() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
            $this->data['states'] = $this->issue_model->getall_state();  
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            if ($this->input->post('submit')) {
                $state = $this->input->post('state');
                $hotel = $this->input->post('hotel_id');
                $date = $this->input->post('date');
                $date1 = $this->input->post('date1');
                $this->data['state'] =  $this->issue_model->get_state($state);
                $issu = $this->issue_model->get_issue_date_hotel($date, $date1, $hotel);
                $iss =  array();
	            foreach ($issu as $is) {
	              $iss[] = $is['issue_id'];
	            }
	            $issus = array_count_values($iss); 
		        $issues = array();
		        $i = 0;
		        foreach ($issus as $key => $value) {
		          $issues[$i] = $this->issue_model->get_issue($key);
		          $i++;
		        }
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
                    
                    $this->data['issues'][$x] = $this->data['issue'];
                    $x++;
                }
        	}
            //die(print_r($this->data['issues']));
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('report_state_hotel_selected', $this->data);
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