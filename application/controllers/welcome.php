<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class welcome extends CI_Controller
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
        $this->data['managements'] = $this->issue_model->getall_management();  
        $count = $this->issue_model->get_issue_count();
        $this->data['count'] = $this->translatoer($count);
        $issues = $this->issue_model->getall_issue();  
        $count2 = 0;
        $count3 = 0;
        $count4 = 0;
        $count5 = 0;
        $count6 = 0;
        $count7 = 0;
        foreach ($issues as $key => $iss) {
          $issues[$key]['dates'] = $this->issue_model->getall_date($issues[$key]['id']);
                if ($issues[$key]['dates'][0]['state_id'] == 3) {
                   $count2++;
                   $count5 = 5;
                }elseif ($issues[$key]['dates'][0]['state_id'] == 1) {
                   $count3++;
                   $count6 = 1;
                }elseif ($issues[$key]['dates'][0]['state_id'] == 2) {
                   $count4++;
                   $count7 = 2;
                }
          }
              //die(print_r($this->data['issues']));
        $this->data['count2'] = $this->translatoer($count2);
        $this->data['count3'] = $this->translatoer($count3);
        $this->data['count4'] = $this->translatoer($count4);
        $this->data['count5'] = $count5;
        $this->data['count6'] = $count6;
        $this->data['count7'] = $count7;
        /*$form_data = array();
        $this->issue_model->trunc_date();
        foreach ($this->data['dates'] as $date) {
          $form_data = array(
                          'title' => $date['number'],
                          'start' => $date['date'],
                          'end' => $date['date']
                      );
          $this->issue_model->insert_date($form_data);
        }
        $this->data['date'] = $this->issue_model->get_date();
        $this->data['com'] = fopen("assets/global/plugins/fullcalendar/demos/json/events.json", "r") or die("Unable to open file!");
        $txt = json_encode($this->data['date']);
        fwrite($this->data['com'], $txt);
        fclose($this->data['com']);
        $this->notify();*/
      $this->load->view('dashboard', $this->data);
    }

        public function notification() {
            $this->load->model('dates_model');
            $this->data['all_issue'] = $this->dates_model->getall_issue_dates();
            $users = $this->dates_model->get_all_users();
            //$notify = array();
            //die(print_r($this->data['all_issue']));
            /*foreach ($this->data['all_issue'] as $key => $issue) {
                $dissc = $this->dates_model->get_issue_date($this->data['all_issue'][$key]['id']);
                $date = strtotime(date("Y-m-d"));
                $date1 = $dissc['date'].' 00:00:00';
                $date1 = strtotime($date1);
                $date2 = $date1 - 172800;
                if ($date < $date1 && $date >= $date2) {
                	$notify[] = $this->data['all_issue'][$key]['id'];
                }else{
					unset($this->data['all_issue'][$key]);
				}
            }*/
            //die(print_r($this->data['all_issue']));
            foreach ($this->data['all_issue'] as $issue) {
            	foreach ($users as $user){
            		$name = $user['fullname'];
                    $mail = $user['email'];
                    $case = $issue['number'].'/'.$issue['year'];
                    $id = $issue['id'];
                    //die(print_r($user));
                    $this->load->library('email');
                    $this->load->helper('url');
                    $issue_url = base_url().'issue/view/'.$id;
                    $this->email->from('e-signature@sunrise-resorts.com');
                    $this->email->to($mail);
                    $this->email->subject("القضية رقم {$id}");
                    $this->email->message("أ\ {$name},
                    	<br/>
                        <br/>
                        لديك جلسة بخصوص القضية {$case} يوم بعد الغد, الرجاء استخدام الرابط التالي للاطلاع على تفاصيل القضية:
                        <br/>
                        <a href='{$issue_url}' target='_blank'>{$issue_url}</a>
                        <br/>
                    "); 
                    $mail_result = $this->email->send();
            	}
            }
            //die(print_r($users));
        }

        public function translate($data) {
          //$data = explode("-",$word);
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