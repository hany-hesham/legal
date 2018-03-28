<?php

    class Cron1 extends CI_Controller{

        public function index(){
		    $config = Array(
    		    'protocol' => 'smtp',
    		    'smtp_host' => 'smtp.office365.com',
    		    'smtp_port' => 587,
    		    'smtp_user' => 'e-signature@sunrise-resorts.com', // change it to yours
    		    'smtp_pass' => 'Abc$123', // change it to yours
    		    'mailtype' => 'html',
    		    'smtp_crypto' => 'tls',
    		);
		    $this->load->library('email', $config);
            $this->load->helper('url');
            $this->load->model('dates_model');
            $all_issue = $this->dates_model->getall_issue_dates();
            $users = $this->dates_model->get_all_users();
            //foreach ($all_issue as $all_issue[0]) {
                //foreach ($users as $user){
                //$name = $user['fullname'];
                //$mail = $user['email'];
                $case = $all_issue[0]['number'].'/'.$all_issue[0]['year'];
                $id = $all_issue[0]['id'];         
                $issue_url = base_url().'issue/view/'.$id;
                $this->email->from('e-signature@sunrise-resorts.com');
                $this->email->to('hany.hisham@sunrise-resorts.com, mohamed.hisham@sunrise-resorts.com, godzila1091@yahoo.com');
                //$this->email->bcc('hany.hisham@sunrise-resorts.com, mohamed.hisham@sunrise-resorts.com, abbas.elshabasy@sunrise-resorts.com');
                $this->email->subject("القضية رقم {$id}");
                $this->email->message("Test,
                    <br/>
                    <br/>
                    لديك جلسة بخصوص القضية {$case} يوم بعد الغد, الرجاء استخدام الرابط التالي للاطلاع على تفاصيل القضية:
                    <br/>
                    <a href='{$issue_url}' target='_blank'>{$issue_url}</a>
                    <br/>
                "); 
                $mail_result = $this->email->send();
            //}			                  
            //}
   	    }
    }

?>
