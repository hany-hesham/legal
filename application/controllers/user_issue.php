<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class user_issue extends CI_Controller {
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
            $this->load->model('issue_model'); 
            $issues = $this->issue_model->get_user_issue($this->data['user_id']);  
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