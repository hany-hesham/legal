<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class case_type extends CI_Controller {
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
                if ($this->form_validation->run() == False) {
                    $this->load->model('users_model');  
                    $this->load->model('case_type_model');  
                    $form_data = array(
                        'user_id' => $this->data['user_id'],
                        'type' => $this->input->post('type')
                    );
                    $typ_id = $this->case_type_model->create_type($form_data);
                    if (!$typ_id) {
                        die("ERROR");
                    }
                    redirect('/case_type/view/'.$typ_id);
                }
            }
            try {
                $this->load->helper('form');
                $this->load->model('case_type_model');  
                $this->load->view('add_new_case_type',$this->data);
            }
            catch( Exception $e) {
                show_error($e->getMessage()." _ ". $e->getTraceAsString());
            }
        }

        public function view_all() {
            $this->load->model('case_type_model'); 
            $types = $this->case_type_model->getall_type(); 
            $this->data['types'] = array();
            $i=0;
            $this->data['type'] = array();
            foreach ($types as $type) {
                $this->data['type']['ids'] = $type['id'];
                $this->data['type']['id'] = $this->translate($type['id']);
                $this->data['type']['type'] = $type['type'];
                $this->data['types'][$i] = $this->data['type'];
                $i++;
            } 
            $this->data['user'] = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
            $this->load->view('case_type_all_view', $this->data);
        }

        public function view($typ_id) {
            //die(print_r($iss_id));
            $this->load->model('case_type_model'); 
            $type = $this->case_type_model->get_type($typ_id);
            $this->data['type'] = array();
            $this->data['type']['id'] = $this->translate($type['id']);
            $this->data['type']['type'] = $type['type'];
            $this->data['type']['user_name'] = $type['user_name'];
            $this->data['type']['timestamp'] = $this->translatoer($type['timestamp']);
            //die(print_r( $this->data['issue']));
            $this->load->view('case_type_view', $this->data);
        }

        public function translate($data) {
          //$data = explode("-",$word);
          if ($data == "0") {
            $word ="٠";
          }elseif ($data == "1") {
            $word ="١";
          }elseif ($data == "2") {
            $word ="٢";
          }elseif ($data == "3") {
            $word ="٣";
          }elseif ($data == "4") {
            $word ="٤";
          }elseif ($data == "5") {
            $word ="٥";
          }elseif ($data == "6") {
            $word ="٦";
          }elseif ($data == "7") {
            $word ="٧";
          }elseif ($data == "8") {
            $word ="٨";
          }elseif ($data == "9") {
            $word ="٩";
          }elseif ($data == "10") {
            $word ="١٠";
          }elseif ($data == "11") {
            $word ="١١";
          }elseif ($data == "12") {
            $word ="١٢";
          }elseif ($data == "13") {
            $word ="١٣";
          }elseif ($data == "14") {
            $word ="١٤";
          }elseif ($data == "15") {
            $word ="١٥";
          }elseif ($data == "16") {
            $word ="١٦";
          }elseif ($data == "17") {
            $word ="١٧";
          }elseif ($data == "18") {
            $word ="١٨";
          }elseif ($data == "19") {
            $word ="١٩";
          }elseif ($data == "20") {
            $word ="٢٠";
          }elseif ($data == "21") {
            $word ="٢١";
          }elseif ($data == "22") {
            $word ="٢٢";
          }elseif ($data == "23") {
            $word ="٢٣";
          }elseif ($data == "24") {
            $word ="٢٤";
          }elseif ($data == "25") {
            $word ="٢٥";
          }elseif ($data == "26") {
            $word ="٢٦";
          }elseif ($data == "27") {
            $word ="٢٧";
          }elseif ($data == "28") {
            $word ="٢٨";
          }elseif ($data == "29") {
            $word ="٢٩";
          }elseif ($data == "30") {
            $word ="٣٠";
          }elseif ($data == "31") {
            $word ="٣١";
          }elseif ($data == "2015") {
            $word ="٢٠١٥";
          }elseif ($data == "2016") {
            $word ="٢٠١٦";
          }elseif ($data == "2017") {
            $word ="٢٠١٧";
          }elseif ($data == "2018") {
            $word ="٢٠١٨";
          }elseif ($data == "2019") {
            $word ="٢٠١٩";
          }elseif ($data == "2020") {
            $word ="٢٠٢٠";
          }elseif ($data == "2021") {
            $word ="٢٠٢١";
          }elseif ($data == "2022") {
            $word ="٢٠٢٢";
          }elseif ($data == "2023") {
            $word ="٢٠٢٣";
          }elseif ($data == "2024") {
            $word ="٢٠٢٤";
          }elseif ($data == "2025") {
            $word ="٢٠٢٥";
          }elseif ($data == "87462") {
            $word ="٨٧٤٦٢";
          }elseif ($data == "su") {
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

        public function translation($datas) {
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
              }elseif ($data == "87462") {
                $word[] ="٨٧٤٦٢";
              }elseif ($data == "su") {
                $word[] ="أح";
              }elseif ($data == "SU") {
                $word[] ="أح";
              }elseif ($data == "sun") {
                $word[] ="أح";
              }elseif ($data == "SUN") {
                $word[] ="أح";
              }elseif ($data == "mo") {
                $word[] ="إث";
              }elseif ($data == "MO") {
                $word[] ="إث";
              }elseif ($data == "mon") {
                $word[] ="إث";
              }elseif ($data == "MON") {
                $word[] ="إث";
              }elseif ($data == "tu") {
                $word[] ="ثل";
              }elseif ($data == "TU") {
                $word[] ="ثل";
              }elseif ($data == "tue") {
                $word[] ="ثل";
              }elseif ($data == "TUE") {
                $word[] ="ثل";
              }elseif ($data == "we") {
                $word[] ="أر";
              }elseif ($data == "WE") {
                $word[] ="أر";
              }elseif ($data == "wed") {
                $word[] ="أر";
              }elseif ($data == "Wed") {
                $word[] ="أر";
              }elseif ($data == "WED") {
                $word[] ="أر";
              }elseif ($data == "th") {
                $word[] ="خم";
              }elseif ($data == "TH") {
                $word[] ="خم";
              }elseif ($data == "thu") {
                $word[] ="خم";
              }elseif ($data == "THU") {
                $word[] ="خم";
              }elseif ($data == "fr") {
                $word[] ="جم";
              }elseif ($data == "FR") {
                $word[] ="جم";
              }elseif ($data == "fri") {
                $word[] ="جم";
              }elseif ($data == "FRI") {
                $word[] ="جم";
              }elseif ($data == "sa") {
                $word[] ="سب";
              }elseif ($data == "SA") {
                $word[] ="سب";
              }elseif ($data == "sat") {
                $word[] ="سب";
              }elseif ($data == "SAT") {
                $word[] ="سب";
              }else{
                $word[] = $data;
              }
            }
            $words = implode("-",$word);
            return $words;
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
        }elseif ($data == "87462") {
          $word[] ="٨٧٤٦٢";
        }elseif ($data == "su") {
          $word[] ="أح";
        }elseif ($data == "SU") {
          $word[] ="أح";
        }elseif ($data == "sun") {
          $word[] ="أح";
        }elseif ($data == "SUN") {
          $word[] ="أح";
        }elseif ($data == "mo") {
          $word[] ="إث";
        }elseif ($data == "MO") {
          $word[] ="إث";
        }elseif ($data == "mon") {
          $word[] ="إث";
        }elseif ($data == "MON") {
          $word[] ="إث";
        }elseif ($data == "tu") {
          $word[] ="ثل";
        }elseif ($data == "TU") {
          $word[] ="ثل";
        }elseif ($data == "tue") {
          $word[] ="ثل";
        }elseif ($data == "TUE") {
          $word[] ="ثل";
        }elseif ($data == "we") {
          $word[] ="أر";
        }elseif ($data == "WE") {
          $word[] ="أر";
        }elseif ($data == "wed") {
          $word[] ="أر";
        }elseif ($data == "Wed") {
          $word[] ="أر";
        }elseif ($data == "WED") {
          $word[] ="أر";
        }elseif ($data == "th") {
          $word[] ="خم";
        }elseif ($data == "TH") {
          $word[] ="خم";
        }elseif ($data == "thu") {
          $word[] ="خم";
        }elseif ($data == "THU") {
          $word[] ="خم";
        }elseif ($data == "fr") {
          $word[] ="جم";
        }elseif ($data == "FR") {
          $word[] ="جم";
        }elseif ($data == "fri") {
          $word[] ="جم";
        }elseif ($data == "FRI") {
          $word[] ="جم";
        }elseif ($data == "sa") {
          $word[] ="سب";
        }elseif ($data == "SA") {
          $word[] ="سب";
        }elseif ($data == "sat") {
          $word[] ="سب";
        }elseif ($data == "SAT") {
          $word[] ="سب";
        }else{
          $word[] = $data;
        }
      }
        $words = implode("",$word);
      return $words;
    }

    }
?>