<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class amenity extends CI_Controller {

  private $data;

  public function __construct() {
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
      $this->data['owning_company'] = $this->tank_auth->is_owning_company();
      $this->data['department_id'] = $this->tank_auth->get_department();
      $this->data['role_id'] = $this->tank_auth->get_role();     
      $this->data['is_corp'] = $this->tank_auth->is_corp();
      $this->data['is_rater'] = $this->tank_auth->is_rater();
      $this->data['is_cairo'] = $this->tank_auth->is_cairo();
      $this->data['is_sky'] = $this->tank_auth->is_sky();
      $this->data['isnt_UK'] = $this->tank_auth->isnt_UK();
      $this->data['isnt_sky'] = $this->tank_auth->isnt_sky();
      $this->data['isnt_Cairo'] = $this->tank_auth->isnt_Cairo(); 
      $this->data['is_UK'] = $this->tank_auth->is_UK();
      $this->data['is_claim'] = $this->tank_auth->is_claim();
      $this->data['is_fc'] = $this->tank_auth->is_fc();
      $this->data['is_cluster'] = $this->tank_auth->is_cluster();
      $this->data['chairman'] = $this->tank_auth->is_chairman();
    }
    $this->data['menu']['active'] = "amenity";
  }

  public function add() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model');  
          $datas = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id')
          );
        
        $amen_id = $this->amenity_model->create_amenity($datas);
        if (!$amen_id) {
            die("ERROR");
        }
        $room = $this->input->post('room');
		$rooms = explode(" ",$room);
		foreach ($rooms as $room) {
			$form_data = array(
	            'room' => $room,
	            'amen_id' => $amen_id
          	);
        	$item_id = $this->amenity_model->create_room($form_data);
	        if (!$item_id) {
	            die("ERROR");
	        }
		}
		//die(print_r($datas));
        redirect('/amenity/submit/'.$amen_id);
        return $this->submit($amen_id);
    }
  }
  try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->load->view('amenity_add',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
}

  public function submit($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
  }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        //$this->form_validation->set_rules('guest','Guest Name','trim|required');
        //$this->form_validation->set_rules('arrival','Arrival Date','trim|required');
        //$this->form_validation->set_rules('departure','Departure Date','trim|required');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model');  
          foreach ($this->input->post('rooms') as $room) {
            $room['amen_id'] = $amen_id;  
              //die(print_r($room));    
            $this->amenity_model->update_room($room, $amen_id, $room['id']);
            }
            $form_data = array(
	            'date_time' => $this->input->post('date_time'),
	            'reason' => $this->input->post('reason'),
	            'location' => $this->input->post('location'),
	            'others' => $this->input->post('others'),
	            'relations' => $this->input->post('relations')
          	);
            $this->amenity_model->update_root($amen_id, $form_data['date_time'], $form_data['reason'], $form_data['location'], $form_data['others'], $form_data['relations']);
          	$signatures = $this->amenity_model->amen_sign();
          foreach ($signatures as $amen_signature) {
            $this->amenity_model->add_signature($amen_id, $amen_signature['role'], $amen_signature['department'], $amen_signature['rank']);
          }
          redirect('/amenity/amenity_stage/'.$amen_id);
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->model('hotels_model');
        $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
        $this->data['items'] = $this->amenity_model->get_items($amen_id);
        foreach ($this->data['items'] as $key => $items) {
          $this->data['items'][$key]['contacts'] = $this->amenity_model->getbyroom($this->data['items'][$key]['room'], $this->data['items'][$key]['hotel_id']);
        }
        //die(print_r($this->data['amenity']['room']));
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['uploads'] = $this->amenity_model->getby_fille($this->data['amenity']['id']);
        $this->load->view('amenity_add_new',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function make_offer($amen_id) {
    $file_name = $this->do_upload("upload");
    if (!$file_name) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("amenity_model");
      $this->amenity_model->add($amen_id, $file_name, $this->data['user_id']);
      // $this->logger->log_event($this->data['user_id'], "Offer", "projects", $amen_id, json_encode(array("offer_name" => $file_name)), "user uploaded an offer");//log
      die("{}");
    }
  }

  public function remove_offer($amen_id, $id) {
    $file_name = $_POST['key'];
    if (!$id) {
      die(json_encode($this->data['error']));
    } else {
      $this->load->model("amenity_model");
      $this->amenity_model->remove($id);
      // $this->logger->log_event($this->data['user_id'], "Offer-Remove", "projects", $amen_id, json_encode(array("offer_id" => $id, "file_name" => $file_name)), "user removed an offer");//log
      die("{}");
    }
  }

  private function do_upload($field) {
    $config['upload_path'] = 'assets/uploads/files/';
    $config['allowed_types'] = '*';
    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload($field))
    {
      $this->data['error'] = array('error' => $this->upload->display_errors());
      return FALSE;
    }
    else
    {
      $file = $this->upload->data();
      return $file['file_name'];
    }
  }

  public function add_exp() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->form_validation->set_rules('hotel_id','Hotel Name','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model');  
          $datas = array(
            'user_id' => $this->data['user_id'],
            'hotel_id' => $this->input->post('hotel_id')
          );
        
        $amen_id = $this->amenity_model->create_amenity($datas);
        if (!$amen_id) {
            die("ERROR");
        }
        $room = $this->input->post('room');
		$rooms = explode(" ",$room);
		foreach ($rooms as $room) {
			$form_data = array(
	            'room' => $room,
	            'amen_id' => $amen_id
          	);
        	$item_id = $this->amenity_model->create_room($form_data);
	        if (!$item_id) {
	            die("ERROR");
	        }
		}
		//die(print_r($datas));
        redirect('/amenity/submit_exp/'.$amen_id);
        return $this->submit_exp($amen_id);
    }
  }
  try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->model('hotels_model');
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->load->view('amenity_add_exp',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function submit_exp($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        redirect('/unknown');
  }else{
      if ($this->input->post('submit')) {
        $this->load->library('form_validation');
        $this->load->library('email');
        //$this->form_validation->set_rules('guest','Guest Name','trim|required');
        //$this->form_validation->set_rules('arrival','Arrival Date','trim|required');
        //$this->form_validation->set_rules('departure','Departure Date','trim|required');
        if ($this->form_validation->run() == FALSE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model');  
          $data = array(
	            'guest' => $this->input->post('guest'),
	            'nationality' => $this->input->post('nationality'),
	            'arrival' => $this->input->post('arrival'),
	            'departure' => $this->input->post('departure')
          	);
          foreach ($this->input->post('rooms') as $room) {
            $room['amen_id'] = $amen_id;  
            $room['guest'] = $data['guest'];  
            $room['nationality'] = $data['nationality'];  
            $room['arrival'] = $data['arrival'];  
            $room['departure'] = $data['departure'];  
              //die(print_r($room));    
            $this->amenity_model->update_room($room, $amen_id, $room['id']);
            }
            $form_data = array(
	            'date_time' => $this->input->post('date_time'),
	            'reason' => $this->input->post('reason'),
	            'location' => $this->input->post('location'),
	            'others' => $this->input->post('others'),
	            'relations' => $this->input->post('relations')
          	);
            $this->amenity_model->update_root($amen_id, $form_data['date_time'], $form_data['reason'], $form_data['location'], $form_data['others'], $form_data['relations']);
            $datas = array(
              'amen_id' => $amen_id,
              'user_id' => $this->data['user_id'],
              'type' => '5'
            ); 
          $this->amenity_model->create_reason($datas);
          	$signatures = $this->amenity_model->amen_sign();
          foreach ($signatures as $amen_signature) {
            $this->amenity_model->add_signature($amen_id, $amen_signature['role'], $amen_signature['department'], $amen_signature['rank']);
          }
          redirect('/amenity/amenity_stage/'.$amen_id);
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->model('hotels_model');
        $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
        $this->data['items'] = $this->amenity_model->get_items($amen_id);
        //die(print_r($this->data['amenity']['room']));
        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        $this->data['uploads'] = $this->amenity_model->getby_fille($this->data['amenity']['id']);
        $this->load->view('amenity_add_new_exp',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  	public function move($item_id) {
    	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        	redirect('/unknown');
  		}else{
        	$this->load->model('amenity_model');
        	$this->data['item'] = $this->amenity_model->get_item($item_id);
        	$this->data['amenity'] = $this->amenity_model->get_amenity($this->data['item']['amen_id']);
        //die(print_r($this->data['amenity'] ));
      		if ($this->input->post('submit')) {
        		$this->load->library('form_validation');
        		$this->load->library('email');
        		$this->load->model('amenity_model');
        //die(print_r($item_id));
        //die(print_r($this->data['items']));
          		if ($this->form_validation->run() == FALSE) {
            		$this->load->model('amenity_model');
            		$this->load->model('users_model');  
            		$formad = array(
              			'room_id' => $item_id,
		              	'amen_id' => $this->data['item']['amen_id'],
		              	'user_new' => $this->data['user_id'],
		              	'room_old' => $this->input->post('room_old'),
		              	'room_new' => $this->input->post('room_new')
		            );
            		$this->amenity_model->create_amenitys($formad);
              //die(print_r($this->data['amenity']));
            		if ($this->data['amenity']['state_id']!='1'){
            //die(print_r($this->data['amenity']));
             			$this->notify($this->data['amenity']['id']);
            		}  
            		redirect('/amenity/view/'.$this->data['item']['amen_id']);
          		}
        	} 
      		try {
		        $this->load->helper('form');
		        $this->load->model('amenity_model');
		        $this->load->model('hotels_model');
		        $this->data['item'] = $this->amenity_model->get_item($item_id);
          		$this->data['amenit'] = $this->amenity_model->get_amen($this->data['item']['id']);
        		$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        		$this->load->view('amenity_move',$this->data);
      		}
      		catch( Exception $e) {
        		show_error($e->getMessage()." _ ". $e->getTraceAsString());
      		}
    	}
  	}

  public function view($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('amenity_model');
      $this->load->model('hotels_model');   
      $this->data['hotels'] = $this->hotels_model->getall();
      $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
      $this->data['items'] = $this->amenity_model->get_items($amen_id);
      foreach ($this->data['items'] as $key => $item) {
        $this->data['items'][$key]['amenit'] = $this->amenity_model->get_amen($this->data['items'][$key]['id']);
      } 
      $this->data['amenitys_edit'] = $this->amenity_model->get_amenitys_edit($amen_id);
      //die(print_r($this->data['amenitys_edit']));
      $this->data['amenity_edit'] = $this->amenity_model->get_amenity_edit($amen_id);
      $this->data['items_edit'] = $this->amenity_model->get_item_edit($this->data['amenity_edit']['id']);
      $this->data['items_edits'] = $this->amenity_model->get_items_edit($amen_id);
      $this->data['count'] = $this->amenity_model->get_items_edit_count($amen_id);
      //die(print_r($this->data['amenity_edit']));
      $this->data['amenitys'] = $this->amenity_model->get_amenitys($amen_id);
      //die(print_r($this->data['items']));
      $this->data['uploads'] = $this->amenity_model->getby_fille($amen_id);
      $this->data['GetComment'] = $this->amenity_model->GetComment($amen_id);
      $this->data['reason'] = $this->amenity_model->get_reason($amen_id);
      $this->data['signature_path'] = '/assets/uploads/signatures/';
      $this->data['signers'] = $this->get_signers($this->data['amenity']['id'], $this->data['amenity']['hotel_id']);
      $editor = FALSE;
      $unsign_enable = FALSE;
      $first = TRUE;
      $force_edit = FALSE;
      foreach ($this->data['signers'] as $signer) {
        if (isset($signer['queue'])) {
          foreach ($signer['queue'] as $uid => $dummy) {
            if ( $uid == $this->data['user_id'] ) {
              $editor = TRUE;
              break;
            }
          }
        } elseif (isset($signer['sign'])) {
          $unsign_enable = FALSE;
          $force_edit = FALSE;
          if ($signer['sign']['id'] == $this->data['user_id']) {
            if ($first) {
              $force_edit = TRUE;
              $unsign_enable = TRUE;
            } else {
              $force_edit = FALSE;
              $unsign_enable = TRUE;
            }
          }
        }
        $first = FALSE;
      }
      if (isset($this->data['user_id'])) {

        if ( $this->data['amenity']['user_id'] == $this->data['user_id'] &&  $this->data['amenity']['state_id'] == 1) {
          $editor = TRUE;
        }
      }
      $this->data['unsign_enable'] = (($unsign_enable) || $this->data['is_admin'])? TRUE : FALSE;
      $this->data['is_editor'] = ( (($this->data['unsign_enable'] || $editor)) || ($force_edit) )? TRUE : FALSE;
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->data['id'] = $amen_id;
      $this->load->view('amenity_view', $this->data);
    }
  }

  	public function edit($amen_id) {
    	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        	redirect('/unknown');
  		}else{
      		if ($this->input->post('submit')) {
        		$this->load->library('form_validation');
        		$this->load->library('email');
        		if ($this->form_validation->run() == FALSE) {
          			$this->load->model('amenity_model');
          			$this->load->model('users_model');  
		          	$form_data = array(
		            	'amen_id' => $amen_id,
		            	'user_id' => $this->data['user_id'],
			            'hotel_id' => $this->input->post('hotel_id'),
			            'date_time' => $this->input->post('date_time'),
			            'reason' => $this->input->post('reason'),
			            'location' => $this->input->post('location'),
			            'others' => $this->input->post('others'),
			            'relations' => $this->input->post('relations')
		          	);
            		$edit_id = $this->amenity_model->create_amenity_edit($form_data);
	        		if (!$edit_id) {
	            		die("ERROR");
	        		}
	        		foreach ($this->input->post('rooms') as $room) {
			    		$room['amen_id'] = $amen_id;  
			    		$room['edit_id'] = $edit_id;  
        				$item_id = $this->amenity_model->create_room_edit($room);
	        			if (!$item_id) {
	            			die("ERROR");
	        			}
					}            
                  $this->notify($amen_id);
           			redirect('/amenity/view/'.$amen_id);
        		}   
      		}
      		try {
        		$this->load->helper('form');
        		$this->load->model('amenity_model');
        		$this->load->model('hotels_model');
        		$this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
        		$this->data['items'] = $this->amenity_model->get_items($amen_id);
        		$this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
        		$this->data['uploads'] = $this->amenity_model->getby_fille($this->data['amenity']['id']);
        		$this->load->view('amenity_edit',$this->data);
      		}
      		catch( Exception $e) {
        		show_error($e->getMessage()." _ ". $e->getTraceAsString());
      		}
    	}
  	}

  	public function edit_exp($amen_id) {
    	if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
        	redirect('/unknown');
  		}else{
      		if ($this->input->post('submit')) {
        		$this->load->library('form_validation');
        		$this->load->library('email');
        		if ($this->form_validation->run() == FALSE) {
          			$this->load->model('amenity_model');
          			$this->load->model('users_model');  
          			$form_data = array(
		            	'amen_id' => $amen_id,
				        'user_id' => $this->data['user_id'],
					    'hotel_id' => $this->input->post('hotel_id'),
			            'date_time' => $this->input->post('date_time'),
			            'reason' => $this->input->post('reason'),
			            'location' => $this->input->post('location'),
			            'others' => $this->input->post('others'),
			            'relations' => $this->input->post('relations')
          			);
            		$edit_id = $this->amenity_model->create_amenity_edit($form_data);
	        		if (!$edit_id) {
	            		die("ERROR");
	        		}
          			$data = array(
			            'guest' => $this->input->post('guest'),
			            'nationality' => $this->input->post('nationality'),
			            'arrival' => $this->input->post('arrival'),
			            'departure' => $this->input->post('departure')
          			);
          			foreach ($this->input->post('rooms') as $room) {
            			$room['amen_id'] = $amen_id;  
			    		$room['edit_id'] = $edit_id;  
			            $room['guest'] = $data['guest'];  
			            $room['nationality'] = $data['nationality'];  
			            $room['arrival'] = $data['arrival'];  
			            $room['departure'] = $data['departure'];  
        				$item_id = $this->amenity_model->create_room_edit($room);
	        			if (!$item_id) {
	            			die("ERROR");
	        			}    
	        		}
                  $this->notify($amen_id);
           			redirect('/amenity/view/'.$amen_id);
        		}   
      		}
      		try {
        		$this->load->helper('form');
       			$this->load->model('amenity_model');
		        $this->load->model('hotels_model');
		        $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
		        $this->data['items'] = $this->amenity_model->get_items($amen_id);
		        $this->data['hotels'] = $this->hotels_model->getby_user($this->tank_auth->get_user_id());
		        $this->data['uploads'] = $this->amenity_model->getby_fille($this->data['amenity']['id']);
        		$this->load->view('amenity_edit_exp',$this->data);
      		}
      		catch( Exception $e) {
        		show_error($e->getMessage()." _ ". $e->getTraceAsString());
      		}
    	}
  	}

  private function get_signers($amen_id, $hotel_id) {
    $this->load->model('amenity_model');
    $signatures = $this->amenity_model->getby_verbal($amen_id);
    return $this->roll_signers($signatures, $hotel_id, $amen_id);
  }

  private function roll_signers($signatures, $hotel_id, $amen_id) {
    $amenity = $this->amenity_model->get_amenity($amen_id);
    $signers = array();
    $this->load->model('users_model');
    foreach ($signatures as $signature) {
      $signers[$signature['id']] = array();
      $signers[$signature['id']]['role'] = $signature['role'];
      $signers[$signature['id']]['role_id'] = $signature['role_id'];
      $signers[$signature['id']]['department'] = $signature['department'];
      $signers[$signature['id']]['department_id'] = $signature['department_id'];
      if ($signature['user_id']) {
         if ($signature['rank'] == 1 && $amenity['state_id'] == 1){
            $this->amenity_model->update_state($amen_id, 4);
          }elseif ($signature['rank'] == 2 && $amenity['state_id'] == 4){
            $this->amenity_model->update_state($amen_id, 5);
          }elseif ($signature['rank'] == 3 && $amenity['state_id'] == 5){
            $this->amenity_model->update_state($amen_id, 6);
          }elseif ($signature['rank'] == 4 && $amenity['state_id'] == 6){
            $this->amenity_model->update_state($amen_id, 7);
          }elseif ($signature['rank'] == 5 && $amenity['state_id'] == 7){
            $this->amenity_model->update_state($amen_id, 2);
          }
        $signers[$signature['id']]['sign'] = array();
        $signers[$signature['id']]['sign']['id'] = $signature['user_id'];
        if ($signature['reject'] == 1) {
          $signers[$signature['id']]['sign']['reject'] = "reject";
          $this->amenity_model->update_state($amen_id, 3);
        } 
        $user = $this->users_model->get_user_by_id($signature['user_id'], TRUE);
        $signers[$signature['id']]['sign']['name'] = $user->fullname;
        $signers[$signature['id']]['sign']['mail'] = $user->email;
        $signers[$signature['id']]['sign']['sign'] = $user->signature;
        $signers[$signature['id']]['sign']['timestamp'] = $signature['timestamp'];
      } else {
        $signers[$signature['id']]['queue'] = array();
        $users = $this->users_model->getby_criteria($signature['role_id'], $hotel_id, $signature['department_id']);
        foreach ($users as $use) {
          $signers[$signature['id']]['queue'][$use['id']] = array();
          $signers[$signature['id']]['queue'][$use['id']]['name'] = $use['fullname'];
          $signers[$signature['id']]['queue'][$use['id']]['mail'] = $use['email'];
        }
      }
    }
    return $signers;
  }

  public function index() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('amenity_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }  
      $this->data['amenity'] = $this->amenity_model->view($hotels);
      foreach ($this->data['amenity'] as $ke => $amen) {
        $this->data['amenity'][$ke]['items'] = $this->amenity_model->get_items($this->data['amenity'][$ke]['id']);
      }  
      foreach ($this->data['amenity'] as $kes => $amen) {
        $this->data['amenity'][$kes]['reason'] = $this->amenity_model->get_reason($this->data['amenity'][$kes]['id']);
      }
      foreach ($this->data['amenity'] as $key => $amen) {
        $this->data['amenity'][$key]['approvals'] = $this->get_signers($this->data['amenity'][$key]['id'], $this->data['amenity'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('amenity_index', $this->data);
    }
  }

  public function index_app() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('amenity_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['amenity'] = $this->amenity_model->view($hotels);
      foreach ($this->data['amenity'] as $ke => $amen) {
        $this->data['amenity'][$ke]['items'] = $this->amenity_model->get_items($this->data['amenity'][$ke]['id']);
      } 
      foreach ($this->data['amenity'] as $kes => $amen) {
        $this->data['amenity'][$kes]['reason'] = $this->amenity_model->get_reason($this->data['amenity'][$kes]['id']);
      } 
      foreach ($this->data['amenity'] as $key => $amen) {
        $this->data['amenity'][$key]['approvals'] = $this->get_signers($this->data['amenity'][$key]['id'], $this->data['amenity'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('amenity_index_app', $this->data);
    }
  }

  public function index_wat() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
        $this->data['state'] = $this->input->post('state');
      }
      $this->load->model('hotels_model');
      $this->load->model('amenity_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['amenity'] = $this->amenity_model->view($hotels);
      foreach ($this->data['amenity'] as $ke => $amen) {
        $this->data['amenity'][$ke]['items'] = $this->amenity_model->get_items($this->data['amenity'][$ke]['id']);
      } 
      foreach ($this->data['amenity'] as $kes => $amen) {
        $this->data['amenity'][$kes]['reason'] = $this->amenity_model->get_reason($this->data['amenity'][$kes]['id']);
      }
      foreach ($this->data['amenity'] as $key => $amen) {
        $this->data['amenity'][$key]['approvals'] = $this->get_signers($this->data['amenity'][$key]['id'], $this->data['amenity'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('amenity_index_wat', $this->data);
    }
  }

  public function index_rej() {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
          redirect('/unknown');
    }else{
      $this->load->model('hotels_model');
      $this->load->model('amenity_model');
      $user_hotels = $this->hotels_model->getby_user($this->data['user_id']);
      $hotels = array();
      foreach ($user_hotels as $hotel) {
        $hotels[] = $hotel['id'];
      }    
      $this->data['amenity'] = $this->amenity_model->view($hotels);
      foreach ($this->data['amenity'] as $ke => $amen) {
        $this->data['amenity'][$ke]['items'] = $this->amenity_model->get_items($this->data['amenity'][$ke]['id']);
      } 
      foreach ($this->data['amenity'] as $kes => $amen) {
        $this->data['amenity'][$kes]['reason'] = $this->amenity_model->get_reason($this->data['amenity'][$kes]['id']);
      }
      foreach ($this->data['amenity'] as $key => $amen) {
        $this->data['amenity'][$key]['approvals'] = $this->get_signers($this->data['amenity'][$key]['id'], $this->data['amenity'][$key]['hotel_id']);
      }
      $this->data['hotels'] = $this->hotels_model->getall();
      $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
      $this->load->view('amenity_index_rej', $this->data);
    }
  }




  public function sign($signature_id, $reject = FALSE) {
    $this->load->model('amenity_model');
    $signature_identity = $this->amenity_model->get_signature_identity($signature_id);
    $signrs = $this->get_signers($signature_identity['amen_id'], $signature_identity['hotel_id']);
    $this->data['amenity'] = $this->amenity_model->get_amenity($signature_identity['amen_id']);
    if (array_key_exists($this->data['user_id'], $signrs[$signature_id]['queue'])) {
      if ($reject) {
        $this->amenity_model->reject($signature_id, $this->data['user_id']);
        redirect('/amenity/amenity_stage/'.$this->data['amenity']['id']);  
      } else {
        $this->amenity_model->sign($signature_id, $this->data['user_id']);
        redirect('/amenity/amenity_stage/'.$signature_identity['amen_id']);  

      }
    }
    redirect('/amenity/view/'.$signature_identity['amen_id']);
  }

  public function amenity_stage($amen_id) {
    $this->load->model('amenity_model');
    $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
    //die(print_r($this->data['amenit']));
    if ($this->data['amenity']['state_id'] == 0) {
      $this->self_sign($amen_id);
      $this->amenity_model->update_state($amen_id, 1);
        redirect('/amenity/amenity_stage/'.$amen_id);
    } elseif ($this->data['amenity']['state_id'] != 0 && $this->data['amenity']['state_id'] != 2 && $this->data['amenity']['state_id'] != 3) {
      $queue = $this->notify_signers($amen_id, $this->data['amenity']['hotel_id']);
     
    }elseif ($this->data['amenity']['state_id'] == 2){
      $this->notify_done($amen_id);
      //$user = $this->users_model->get_user_by_id($this->data['amenity']['user_id'], TRUE);
      //$queue = $this->approvel_mail($user->fullname, $user->email, $amen_id);
    }elseif ($this->data['amenity']['state_id'] == 3){
      $user = $this->users_model->get_user_by_id($this->data['amenity']['user_id'], TRUE);
      $queue = $this->reject_mail($user->fullname, $user->email, $amen_id);
    }
    redirect('/amenity/view/'.$amen_id);
  }

  private function notify_signers($amen_id) {
    $notified = FALSE;
    $signers = $this->get_signers($amen_id, $this->data['amenity']['hotel_id']);
    foreach ($signers as $signer) {
      if (isset($signer['queue'])) {
        $notified = TRUE;
          foreach ($signer['queue'] as $uid => $user) {
            $this->signatures_mail($signer['role'], $signer['department'], $user['name'], $user['mail'], $amen_id);
        }
        break;
      }
    }
    return $notified;
  }

  private function signatures_mail($role, $department, $name, $mail, $amen_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $amen_url = base_url().'amenity/view/'.$amen_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($mail);
    $this->email->subject("Guest Amenity Request {$amen_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Guest Amenity Request {$amen_id} requires your signature, Please use the link below:<br/>
              <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  public function unsign($signature_id) {
    $this->load->model('amenity_model');
    $this->load->model('users_model');
    $signature_identity = $this->amenity_model->get_signature_identity($signature_id);
    $this->amenity_model->unsign($signature_id);
    $amenity = $this->amenity_model->get_amenity($signature_identity['amen_id']);
    redirect('/amenity/view/'.$signature_identity['amen_id']);
  }

  private function reject_mail($name, $email, $amen_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $amen_url = base_url().'amenity/view/'.$amen_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Guest Amenity Request {$amen_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Guest Amenity Request {$amen_id} has been rejected, Please use the link below:<br/>
              <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  private function approvel_mail($name, $email, $amen_id) {
    $this->load->library('email');
    $this->load->helper('url');
    $amen_url = base_url().'amenity/view/'.$amen_id;
    $this->email->from('e-signature@sunrise-resorts.com');
    $this->email->to($email);
    $this->email->subject("Guest Amenity Request {$amen_id}");
    $this->email->message("Dear {$name},<br/>
              <br/>
              Guest Amenity Request {$amen_id} has been approved, Please use the link below:<br/>
              <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
              "); 
    $mail_result = $this->email->send();
  }

  public function mailto($amen_id) {
    if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('message','message is required','trim|required');
      $this->form_validation->set_rules('mail','mail is required','trim|required');
      if ($this->form_validation->run() == TRUE) {
        $message = $this->input->post('message');
        $email = $this->input->post('mail');
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->library('email');
        $this->load->helper('url');
        $amen_url = base_url().'amenity/view/'.$amen_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($email);
        $this->email->subject("A message from {$user->fullname}, Guest Amenity Request No.{$amen_id}");
        $this->email->message("{$user->fullname} sent you a private message regarding Guest Amenity Request {$amen_id}:<br/>
                  {$message}<br />
                  <br />
                  Please use the link below to view the Guest Amenity Request:
                  <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
      }
    }
    redirect('amenity/view/'.$amen_id);
  }

   private function self_sign($amen_id) {
    $this->load->model('amenity_model');
    $this->amenity_model->self_sign($amen_id, $this->data['user_id']);
  }

  public function Comment($amen_id){
      if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('comment','Comment','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $comment = $this->input->post('comment'); 
          $this->load->model('amenity_model');
          $comment_data = array(
            'user_id' => $this->data['user_id'],
            'amen_id' => $amen_id,
            'comment' => $comment
          );
        $this->amenity_model->InsertComment($comment_data);
      }
      redirect('/amenity/view/'.$amen_id);
    }
  }

  public function mailme($amen_id) {
        $user = $this->users_model->get_user_by_id($this->data['user_id'], TRUE);
        $this->load->library('email');
        $this->load->helper('url');
        $amen_url = base_url().'amenity/view/'.$amen_id;
        $this->email->from('e-signature@sunrise-resorts.com');
        $this->email->to($user->email);
        $this->email->subject("Guest Amenity Request NO.#{$amen_id}");
        $this->email->message("Guest Amenity Request NO.#{$amen_id}:<br/>
                  Please use the link below to view the Guest Amenity Request:
                  <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
                "); 
        $mail_result = $this->email->send();
        redirect('amenity/view/'.$amen_id);
  }

  public function notify($amen_id) {
    $this->load->model('amenity_model');
    $this->load->model('users_model');
    $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
    $signes = $this->amenity_model->getby_verbal($amen_id);
    $users = array();
    foreach ($signes as $signe){
          //die(print_r($signe['role_id']));
      if ($signe['user_id']) {
        $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          //die(print_r($user));
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $amen_url = base_url().'amenity/view/'.$amen_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Guest Amenity Request NO.#{$amen_id}");
          $this->email->message("Dear {$name},<br/>
            <br/>
            Guest Amenity Request NO.#{$amen_id} has been Edited, Please use the link below:<br/>
            <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
          "); 
          $mail_result = $this->email->send();
      }
    }
    redirect('amenity/view/'.$amen_id);
  }

  public function notify_done($amen_id) {
    $this->load->model('amenity_model');
    $this->load->model('users_model');
    $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
    $signes = $this->amenity_model->getby_verbal($amen_id);
    $users = array();
    foreach ($signes as $signe){
          //die(print_r($signe['role_id']));
      if ($signe['user_id']) {
        $user = $this->users_model->get_user_by_id($signe['user_id'], TRUE);
          //die(print_r($user));
          $name = $user->fullname;
          $mail = $user->email;
          $this->load->library('email');
          $this->load->helper('url');
          $amen_url = base_url().'amenity/view/'.$amen_id;
          $this->email->from('e-signature@sunrise-resorts.com');
          $this->email->to($mail);
          $this->email->subject("Guest Amenity Request NO.#{$amen_id}");
          $this->email->message("Dear {$name},<br/>
            <br/>
            Guest Amenity Request NO.#{$amen_id} has been approved, Please use the link below:<br/>
            <a href='{$amen_url}' target='_blank'>{$amen_url}</a><br/>
          "); 
          $mail_result = $this->email->send();
      }
    }
    redirect('amenity/view/'.$amen_id);
  }
   
  public function retoure($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
      redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('reason','You Need To Enter a Reason','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model'); 
          $data = array(
              'amen_id' => $amen_id,
              'user_id' => $this->data['user_id'],
              'reason' => $this->input->post('reason'),
              'type' => '1'
            ); 
          $this->amenity_model->create_reason($data);
          $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
          if ($this->data['amenity']['state_id']!='1'){
            //die(print_r($this->data['amenity']));
            $this->notify($this->data['amenity']['id']);
          }
          redirect('/amenity');
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->view('amenity_add_reason',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function cancel($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
      redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('reason','You Need To Enter a Reason','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model'); 
          $data = array(
              'amen_id' => $amen_id,
              'user_id' => $this->data['user_id'],
              'reason' => $this->input->post('reason'),
              'type' => '2'
            ); 
          $this->amenity_model->create_reason($data);
          $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
          if ($this->data['amenity']['state_id']!='1'){
            //die(print_r($this->data['amenity']));
            $this->notify($this->data['amenity']['id']);
          }
          redirect('/amenity');
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->view('amenity_add_reason',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

    public function show($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
      redirect('/unknown');
    }else{
      if ($this->input->post('submit')) {
          $this->load->library('form_validation');
          $this->load->library('email');
          $this->form_validation->set_rules('reason','You Need To Enter a Reason','trim|required');
        if ($this->form_validation->run() == TRUE) {
          $this->load->model('amenity_model');
          $this->load->model('users_model'); 
          $data = array(
              'amen_id' => $amen_id,
              'user_id' => $this->data['user_id'],
              'reason' => $this->input->post('reason'),
              'type' => '3'
            ); 
          $this->amenity_model->create_reason($data);
          $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
          if ($this->data['amenity']['state_id']!='1'){
            //die(print_r($this->data['amenity']));
            $this->notify($this->data['amenity']['id']);
          }
          redirect('/amenity');
        }   
      }
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
        $this->load->view('amenity_add_reason',$this->data);
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function deliver($amen_id) {
    if ((isset($this->data['is_cairo']) && $this->data['is_cairo']) || (isset($this->data['is_sky']) && $this->data['is_sky']) || (isset($this->data['is_UK']) && $this->data['is_UK'])) {
      redirect('/unknown');
    }else{
          $this->load->model('amenity_model');
          $this->load->model('users_model'); 
          	$data = array(
              'amen_id' => $amen_id,
              'user_id' => $this->data['user_id'],
              'type' => '4'
            ); 
          $this->amenity_model->create_reason($data);
          $this->data['amenity'] = $this->amenity_model->get_amenity($amen_id);
          if ($this->data['amenity']['state_id']!='1'){
            //die(print_r($this->data['amenity']));
            $this->notify($this->data['amenity']['id']);
          }else{
          redirect('/amenity/view/'.$amen_id);
      }
      try {
        $this->load->helper('form');
        $this->load->model('amenity_model');
      }
      catch( Exception $e) {
        show_error($e->getMessage()." _ ". $e->getTraceAsString());
      }
    }
  }

  public function type($amen_id) {
    $this->load->model('amenity_model');
    if ($this->input->post('submit')) {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('type','You Need To Chose a Type','trim|required');
      if ($this->form_validation->run() == TRUE) {
        $type = $this->input->post('type');
        if ($type == '1') {
          redirect('/amenity/retoure/'.$amen_id);
        }elseif ($type == '2') {
          redirect('/amenity/cancel/'.$amen_id);
        }elseif ($type == '3') {
          redirect('/amenity/show/'.$amen_id);
        }elseif ($type == '4') {
          redirect('/amenity/deliver/'.$amen_id);
        }
      }
    }
  }

}