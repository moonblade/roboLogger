<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller {
       public function index()
        {
                // $this->load->view('pages/manualPicker');
		$data['chart_data'] = json_decode('[{"year":1,"time":10},{"year":2,"time":20},{"year":3,"time":30},{"year":4,"time":40}]',True);
                $data['chart_data']=$this->getPeople();
                $data['users']=$this->getMacs();
                $this->load->view('pages/chart',$data);
        }

        public function changeName()
        {
                $name = $this->input->get('name');
        	$macId = $this->input->get('macId');
        	$this->db->update('loggerUsers',array('name'=>$name),array('macId'=>$macId));
                // header('Location: http://robologger.robocet.com/');
                $this->index();
        }

        private function getPeople()
        {
                $query = $this->db->query('select REPLACE(name,"Anonymous",userMacId) as name,UNIX_TIMESTAMP(userLoginTime) as userLoginTime, UNIX_TIMESTAMP(REPLACE(userLogoutTime,"0000-00-00 00:00:00",NOW())) as userLogoutTime from log,loggerUsers where log.userMacId = loggerUsers.macId
');
                // header('Content-Type: application/json');
                return $query->result();
        
        }

        private function getMacs()
        {
        	return $this->db->query("select * from loggerUsers")->result();
        }
}
