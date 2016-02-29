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
                                $returnValues=$this->getPeopleAtTimeDateTime($iterator,$iterator);
                        $result['devices']=$returnValues;
                        // $result['time']=$iterator->getTimeStamp();
                        $result['time']=$i;
                        $result['count']=count($result['devices']);
			            $toReturn[]=$result;
                        $iterator->add(new DateInterval('PT1H'));
            }
            return($toReturn);
        }

        private function getPeopleAtTimeDateTime($startTime,$endTime)
        {
                $startTime->add(new DateInterval('PT4H30M'));
                $startTime = date_format($startTime, 'Y-m-d H:i:s');
                $endTime->add(new DateInterval('PT4H30M'));
                $endTime = date_format($endTime, 'Y-m-d H:i:s');
                $query = $this->db->query('select name,userMacId,userLoginTime,userLogoutTime from log,loggerUsers where log.userMacId = loggerUsers.macId and not ((\''.$startTime.'\' < userLoginTime and \''.$endTime.'\' < userLogoutTime) || (\''.$startTime.'\' > userLoginTime and \''.$endTime.'\' > userLogoutTime)) || userLogoutTime=\'0000-00-00 00:00:00\'');
                // header('Content-Type: application/json');
                return $query->result();
        
        }
}
