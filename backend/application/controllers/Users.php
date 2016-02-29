<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller {
       public function index()
        {
                // $this->load->view('pages/manualPicker');
		$data['chart_data'] = json_decode('[{"year":1,"time":10},{"year":2,"time":20},{"year":3,"time":30},{"year":4,"time":40}]',True);
                $data['chart_data']=$this->getData();
                $this->load->view('pages/chart',$data);
        }

        private function getData()
        {
    	$hours = 5;
	        $now=new DateTime();
            $now->add(new DateInterval('PT4H30M'));
            $from=new DateTime();
            $from->add(new DateInterval('PT4H30M'));
            $from->sub(new DateInterval('PT'.$hours.'H'));
            $iterator=$from;
            for($i=0; $i<=$hours;$i++)
            {
                                $returnValues=$this->getPeople();
                        $result['devices']=$returnValues;
                        // $result['time']=$i;
                        $result['time']=$iterator->getTimeStamp();
                        $result['count']=count($result['devices']);
			            $toReturn[]=$result;
                        $iterator->add(new DateInterval('PT1H'));
            }
            return($toReturn);
        }

        private function getPeople($from=24)
        {
                $query = $this->db->query('select name,userMacId,userLoginTime, REPLACE(userLogoutTime,"0000-00-00 00:00:00",NOW()) from log,loggerUsers where log.userMacId = loggerUsers.macId');
                // header('Content-Type: application/json');
                return $query->result();
        
        }
}
