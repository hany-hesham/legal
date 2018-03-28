<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class agenda extends CI_Controller
{
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
		 $this->load->model('users_model');
        $this->load->model('issue_model'); 
        $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
       	$data = date("D");
       	$date = date("Y-m-d");
       	$dats = date("d-m-Y");
       	$this->data['da'] = $this->translate($data);
       	$this->data['das'] = $this->dates_translatore($dats);
       	//die(print_r($data));
        $issu = $this->issue_model->get_issue_dates($date);
        $issues = array();
        $i = 0;
        foreach ($issu as $iss) {
          $issues[$i] = $this->issue_model->get_issue($iss['issue_id']);
          $i++;
        }
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
        //die(print_r($this->data['issues']));
    	$this->load->view('agenda_view', $this->data);
	}

  public function month() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
                $month = date("m");
                $year = date("Y");
                $date = date("Y-m");
                $date1 = date("Y-m");
                $date2 = $date."-01";
                if ($month == "02" && ($year %4 == 0)) {
                  $date3 = $date1."-29";
                }elseif ($month == "02" && ($year %4 != 0)) {
                  $date3 = $date1."-28";
                }elseif ($month == "01" || $month == "03" || $month == "05" || $month == "07" || $month == "08" || $month == "10" || $month == "12") {
                  $date3 = $date1."-31";
                }elseif ($month == "04" || $month == "06" || $month == "09" || $month == "11") {
                  $date3 = $date1."-30";
                }
                //die(print_r($years));
                $issu = $this->issue_model->get_issue_date($date2, $date3);
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
                $this->data['month'] = $this->translate($month);
                $this->data['date'] = $this->date_translatore($date2);
                $this->data['date1'] = $this->date_translatore($date3);
            //die(print_r( $this->data['issues']));
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('agenda_month_view', $this->data);
        }

        public function week() {
            $this->load->model('users_model');  
            $this->load->model('issue_model'); 
                $day = date("D");
                $days = date("d");
                $month = date("m");
                $year = date("Y");
                $date = date("Y");
                $date1 = date("Y-m");
                $date2 = $date."-01";
                  if ($day == "Fri") {
                    $now = $days - 6;
                    if ($now < 0) {
                      if ($month == "03" && ($year %4 == 0)) {
                        $nows = 29 + $now;
                        $months = $month -1;
                      }elseif ($month == "03" && ($year %4 != 0)) {
                        $nows = 28 + $now;
                        $months = $month -1;
                      }elseif ($month == "02" || $month == "04" || $month == "06" || $month == "09" || $month == "11" || $month == "01") {
                        if ($month != "01") {
                          $nows = 31 + $now;
                          $months = $month -1;
                        }elseif ($month == "01") {
                          $nows = 31 + $now;
                          $months = $month +11;
                        }
                      }elseif ($month == "05" || $month == "07" || $month == "08" || $month == "10" || $month == "12") {
                        $nows = 30 + $now;
                        $months = $month -1;
                      }
                    }else{
                      $nows = $now;
                      $months = $month;
                    }
                    if($nows < 10){
                      $nows = $nows + 1;
                      $nows = $nows - 1;
                      $nowess = "0".$nows;
                    }else{
                      $nowess = $nows;
                    }
                    if($months < 10){
                      $months = $months + 1;
                      $months = $months - 1;
                      $months = "0".$months;
                    }else{
                      $months = $months;
                    }
                    $date6 = $date."-".$months."-".$nowess;
                    $date9 = date("Y-m-d");
                  }elseif($day == "Sat") {
                    $now = $days + 6;
                    if ($month == "02" && ($year %4 == 0)) {
                      if ($now > 29) {
                        $nows = $now - 29;
                        $months = $month +1;
                      }elseif ($now <= 29) {
                        $nows = $now;
                        $months = $month;
                      }
                    }elseif ($month == "02" && ($year %4 != 0)) {
                      if ($now > 28) {
                        $nows = $now - 28;
                        $months = $month +1;
                      }elseif ($now <= 28) {
                        $nows = $now;
                        $months = $month;
                      }
                    }elseif ($month == "01" || $month == "03" || $month == "05" || $month == "07" || $month == "08" || $month == "10" || $month == "12") {
                      if ($now > 31 && $month != "12") {
                        $nows = $now - 31;
                        $months = $month +1;
                      }elseif ($now > 31 && $month == "12") {
                        $nows = $now - 31;
                        $months = $month -11;
                      }elseif ($now <= 31) {
                        $nows = $now;
                        $months = $month;
                      }
                    }elseif ($month == "04" || $month == "06" || $month == "09" || $month == "11") {
                      if ($now > 30) {
                        $nows = $now - 30;
                        $months = $month +1;
                      }elseif ($now <= 30) {
                        $nows = $now;
                        $months = $month;
                      }
                    }
                    if($nows < 10){
                      $nows = $nows + 1;
                      $nows = $nows - 1;
                      $nowess = "0".$nows;
                    }else{
                      $nowess = $nows;
                    }
                    if($months < 10){
                      $months = $months + 1;
                      $months = $months - 1;
                      $months = "0".$months;
                    }else{
                      $months = $months;
                    }
                    $date9 = $date."-".$months."-".$nowess;
                    $date6 = date("Y-m-d");
                  }elseif($day == "Sun") {
                    $now = $days + 5;
                    $nowes = $days - 1;
                    if ($month == "02" && ($year %4 == 0)) {
                      if ($now >= 29 && $nowes <= 29 && $nowes > 0) {
                        $nows = $now - 29;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 29 && $nowes <= 29 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 29 && $nowes <= 29 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "02" && ($year %4 != 0)) {
                      if ($now >= 28 && $nowes <= 28 && $nowes > 0) {
                        $nows = $now - 28;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 28 && $nowes <= 28 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 28 && $nowes <= 28 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "03" && ($year %4 == 0)) {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 29 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "03" && ($year %4 != 0)) {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 28 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "08") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "01") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month +11;
                      }
                    }elseif ($month == "05" || $month == "07" || $month == "10" || $month == "12") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 30 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "04" || $month == "06" || $month == "09" || $month == "11") {
                      if ($now >= 30 && $nowes <= 30 && $nowes > 0) {
                        $nows = $now - 30;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 30 && $nowes <= 30 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 30 && $nowes <= 30 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }
                    if($nows < 10){
                      $nows = $nows + 1;
                      $nows = $nows - 1;
                      $nowess = "0".$nows;
                    }else{
                      $nowess = $nows;
                    }
                    if($months < 10){
                      $months = $months + 1;
                      $months = $months - 1;
                      $months = "0".$months;
                    }else{
                      $months = $months;
                    }
                    if($nowss < 10){
                      $nowss = $nowss + 1;
                      $nowss = $nowss - 1;
                      $nowesss = "0".$nowss;
                    }else{
                      $nowesss = $nowss;
                    }
                    if($monthss < 10){
                      $monthss = $monthss + 1;
                      $monthss = $monthss - 1;
                      $monthss = "0".$monthss;
                    }else{
                      $monthss = $monthss;
                    }
                    $date9 = $date."-".$months."-".$nowess;
                    $date6 = $date."-".$monthss."-".$nowesss;
                  }elseif($day == "Mon") {
                    $now = $days + 4;
                    $nowes = $days - 2;
                    if ($month == "02" && ($year %4 == 0)) {
                      if ($now >= 29 && $nowes <= 29 && $nowes > 0) {
                        $nows = $now - 29;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 29 && $nowes <= 29 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 29 && $nowes <= 29 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "02" && ($year %4 != 0)) {
                      if ($now >= 28 && $nowes <= 28 && $nowes > 0) {
                        $nows = $now - 28;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 28 && $nowes <= 28 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 28 && $nowes <= 28 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "03" && ($year %4 == 0)) {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 29 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "03" && ($year %4 != 0)) {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 28 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "08") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                      if($monthss < 10){
                      $monthss = "0".$monthss;
                    }else{
                      $monthss = $monthss;
                    }
                    }elseif ($month == "01") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month +11;
                      }
                    }elseif ($month == "05" || $month == "07" || $month == "10" || $month == "12") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 30 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "04" || $month == "06" || $month == "09" || $month == "11") {
                      if ($now >= 30 && $nowes <= 30 && $nowes > 0) {
                        $nows = $now - 30;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 30 && $nowes <= 30 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 30 && $nowes <= 30 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }
                    if($nows < 10){
                      $nows = $nows + 1;
                      $nows = $nows - 1;
                      $nowess = "0".$nows;
                    }else{
                      $nowess = $nows;
                    }
                    if($months < 10){
                      $months = $months + 1;
                      $months = $months - 1;
                      $months = "0".$months;
                    }else{
                      $months = $months;
                    }
                    if($nowss < 10){
                      $nowss = $nowss + 1;
                      $nowss = $nowss - 1;
                      $nowesss = "0".$nowss;
                    }else{
                      $nowesss = $nowss;
                    }
                    if($monthss < 10){
                      $monthss = $monthss + 1;
                      $monthss = $monthss - 1;
                      $monthss = "0".$monthss;
                    }else{
                      $monthss = $monthss;
                    }
                    $date9 = $date."-".$months."-".$nowess;
                    $date6 = $date."-".$monthss."-".$nowesss;
                  }elseif($day == "Tue") {
                    $now = $days + 3;
                    $nowes = $days - 3;
                    if ($month == "02" && ($year %4 == 0)) {
                      if ($now >= 29 && $nowes <= 29 && $nowes > 0) {
                        $nows = $now - 29;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 29 && $nowes <= 29 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 29 && $nowes <= 29 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "02" && ($year %4 != 0)) {
                      if ($now >= 28 && $nowes <= 28 && $nowes > 0) {
                        $nows = $now - 28;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 28 && $nowes <= 28 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 28 && $nowes <= 28 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "03" && ($year %4 == 0)) {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 29 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "03" && ($year %4 != 0)) {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 28 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "08") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "01") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month +11;
                      }
                    }elseif ($month == "05" || $month == "07" || $month == "10" || $month == "12") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 30 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "04" || $month == "06" || $month == "09" || $month == "11") {
                      if ($now >= 30 && $nowes <= 30 && $nowes > 0) {
                        $nows = $now - 30;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 30 && $nowes <= 30 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 30 && $nowes <= 30 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }
                    if($nows < 10){
                      $nows = $nows + 1;
                      $nows = $nows - 1;
                      $nowess = "0".$nows;
                    }else{
                      $nowess = $nows;
                    }
                    if($months < 10){
                      $months = $months + 1;
                      $months = $months - 1;
                      $months = "0".$months;
                    }else{
                      $months = $months;
                    }
                    if($nowss < 10){
                      $nowss = $nowss + 1;
                      $nowss = $nowss - 1;
                      $nowesss = "0".$nowss;
                    }else{
                      $nowesss = $nowss;
                    }
                    if($monthss < 10){
                      $monthss = $monthss + 1;
                      $monthss = $monthss - 1;
                      $monthss = "0".$monthss;
                    }else{
                      $monthss = $monthss;
                    }
                    $date9 = $date."-".$months."-".$nowess;
                    $date6 = $date."-".$monthss."-".$nowesss;
                  }elseif($day == "Wed") {
                    $now = $days + 2;
                    $nowes = $days - 4;
                    if ($month == "02" && ($year %4 == 0)) {
                      if ($now >= 29 && $nowes <= 29 && $nowes > 0) {
                        $nows = $now - 29;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 29 && $nowes <= 29 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 29 && $nowes <= 29 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "02" && ($year %4 != 0)) {
                      if ($now >= 28 && $nowes <= 28 && $nowes > 0) {
                        $nows = $now - 28;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 28 && $nowes <= 28 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 28 && $nowes <= 28 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "03" && ($year %4 == 0)) {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 29 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "03" && ($year %4 != 0)) {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 28 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "08") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "01") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month +11;
                      }
                    }elseif ($month == "05" || $month == "07" || $month == "10" || $month == "12") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 30 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "04" || $month == "06" || $month == "09" || $month == "11") {
                      if ($now >= 30 && $nowes <= 30 && $nowes > 0) {
                        $nows = $now - 30;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 30 && $nowes <= 30 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 30 && $nowes <= 30 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }
                    if($nows < 10){
                      $nows = $nows + 1;
                      $nows = $nows - 1;
                      $nowess = "0".$nows;
                    }else{
                      $nowess = $nows;
                    }
                    if($months < 10){
                      $months = $months + 1;
                      $months = $months - 1;
                      $months = "0".$months;
                    }else{
                      $months = $months;
                    }
                    if($nowss < 10){
                      $nowss = $nowss + 1;
                      $nowss = $nowss - 1;
                      $nowesss = "0".$nowss;
                    }else{
                      $nowesss = $nowss;
                    }
                    if($monthss < 10){
                      $monthss = $monthss + 1;
                      $monthss = $monthss - 1;
                      $monthss = "0".$monthss;
                    }else{
                      $monthss = $monthss;
                    }
                    $date9 = $date."-".$months."-".$nowess;
                    $date6 = $date."-".$monthss."-".$nowesss;
                  }elseif($day == "Thu") {
                    $now = $days + 2;
                    $nowes = $days - 4;
                    if ($month == "02" && ($year %4 == 0)) {
                      if ($now >= 29 && $nowes <= 29 && $nowes > 0) {
                        $nows = $now - 29;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 29 && $nowes <= 29 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 29 && $nowes <= 29 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "02" && ($year %4 != 0)) {
                      if ($now >= 28 && $nowes <= 28 && $nowes > 0) {
                        $nows = $now - 28;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 28 && $nowes <= 28 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 28 && $nowes <= 28 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "03" && ($year %4 == 0)) {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 29 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "03" && ($year %4 != 0)) {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 28 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "08") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "01") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month +11;
                      }
                    }elseif ($month == "05" || $month == "07" || $month == "10" || $month == "12") {
                      if ($now >= 31 && $nowes <= 31 && $nowes > 0) {
                        $nows = $now - 31;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 31 && $nowes <= 31 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 30 + $nowes;
                        $monthss = $month -1;
                      }
                    }elseif ($month == "04" || $month == "06" || $month == "09" || $month == "11") {
                      if ($now >= 30 && $nowes <= 30 && $nowes > 0) {
                        $nows = $now - 30;
                        $months = $month +1;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 30 && $nowes <= 30 && $nowes > 0 ) {
                        $nows = $now;
                        $months = $month;
                        $nowss = $nowes;
                        $monthss = $month;
                      }elseif ($now <= 30 && $nowes <= 30 && $nowes < 0) {
                        $nows = $now;
                        $months = $month;
                        $nowss = 31 + $nowes;
                        $monthss = $month -1;
                      }
                    }
                    if($nows < 10){
                      $nows = $nows + 1;
                      $nows = $nows - 1;
                      $nowess = "0".$nows;
                    }else{
                      $nowess = $nows;
                    }
                    if($months < 10){
                      $months = $months + 1;
                      $months = $months - 1;
                      $months = "0".$months;
                    }else{
                      $months = $months;
                    }
                    if($nowss < 10){
                      $nowss = $nowss + 1;
                      $nowss = $nowss - 1;
                      $nowesss = "0".$nowss;
                    }else{
                      $nowesss = $nowss;
                    }
                    if($monthss < 10){
                      $monthss = $monthss + 1;
                      $monthss = $monthss - 1;
                      $monthss = "0".$monthss;
                    }else{
                      $monthss = $monthss;
                    }
                    $date9 = $date."-".$months."-".$nowess;
                    $date6 = $date."-".$monthss."-".$nowesss;
                  }
                //die(print_r($date6.$date9));
                $issu = $this->issue_model->get_issue_date($date6, $date9);
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
                $this->data['start'] = $this->translate("Sat");
                $this->data['end'] = $this->translate("Fri");
                $this->data['date'] = $this->date_translatore($date6);
                $this->data['date1'] = $this->date_translatore($date9);
            //die(print_r( $this->data['issues']));
            $this->data['hotels'] = $this->issue_model->getall_hotel();
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('agenda_week_view', $this->data);
        }

	public function translate($data) {
          //$data = explode("-",$word);
          if ($data == "su") {
            $word ="الأحد";
          }elseif ($data == "Su") {
            $word ="الأحد";
          }elseif ($data == "SU") {
            $word ="الأحد";
          }elseif ($data == "sun") {
            $word ="الأحد";
          }elseif ($data == "Sun") {
            $word ="الأحد";
          }elseif ($data == "SUN") {
            $word ="الأحد";
          }elseif ($data == "mo") {
            $word ="الأثنين";
          }elseif ($data == "Mo") {
            $word ="الأثنين";
          }elseif ($data == "MO") {
            $word ="الأثنين";
          }elseif ($data == "mon") {
            $word ="الأثنين";
          }elseif ($data == "Mon") {
            $word ="الأثنين";
          }elseif ($data == "MON") {
            $word ="الأثنين";
          }elseif ($data == "tu") {
            $word ="الثلاثاء";
          }elseif ($data == "Tu") {
            $word ="الثلاثاء";
          }elseif ($data == "TU") {
            $word ="الثلاثاء";
          }elseif ($data == "tue") {
            $word ="الثلاثاء";
          }elseif ($data == "Tue") {
            $word ="الثلاثاء";
          }elseif ($data == "TUE") {
            $word ="الثلاثاء";
          }elseif ($data == "we") {
            $word ="الأربعاء";
          }elseif ($data == "We") {
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
            $word ="الخميس";
          }elseif ($data == "Th") {
            $word ="الخميس";
          }elseif ($data == "TH") {
            $word ="الخميس";
          }elseif ($data == "thu") {
            $word ="الخميس";
          }elseif ($data == "Thu") {
            $word ="الخميس";
          }elseif ($data == "THU") {
            $word ="الخميس";
          }elseif ($data == "fr") {
            $word ="الجمعة";
          }elseif ($data == "Fr") {
            $word ="الجمعة";
          }elseif ($data == "FR") {
            $word ="الجمعة";
          }elseif ($data == "fri") {
            $word ="الجمعة";
          }elseif ($data == "Fri") {
            $word ="الجمعة";
          }elseif ($data == "FRI") {
            $word ="الجمعة";
          }elseif ($data == "sa") {
            $word ="السبت";
          }elseif ($data == "Sa") {
            $word ="السبت";
          }elseif ($data == "SA") {
            $word ="السبت";
          }elseif ($data == "sat") {
            $word ="السبت";
          }elseif ($data == "Sat") {
            $word ="السبت";
          }elseif ($data == "SAT") {
            $word ="السبت";
          }elseif ($data == "01") {
            $word ="يناير";
          }elseif ($data == "02") {
            $word ="فبراير";
          }elseif ($data == "03") {
            $word ="مارس";
          }elseif ($data == "04") {
            $word ="ابريل";
          }elseif ($data == "05") {
            $word ="مايو";
          }elseif ($data == "06") {
            $word ="يونيو";
          }elseif ($data == "07") {
            $word ="يوليو";
          }elseif ($data == "08") {
            $word ="اغسطس";
          }elseif ($data == "09") {
            $word ="سبتمبر";
          }elseif ($data == "10") {
            $word ="اكتوبر";
          }elseif ($data == "11") {
            $word ="نوفمبر";
          }elseif ($data == "12") {
            $word ="ديسمبر";
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

        public function dates_translatore($datas) {
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
            $wordes = array_reverse($word);
            $words = implode("/",$wordes);
            return $words;
        }

     
  }