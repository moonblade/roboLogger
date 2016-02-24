<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logger extends CI_Controller {

        public function index()
        {
                print("Logger Api");
        }

        public function updateData()
        {
        	$macList=array_diff(json_decode(file_get_contents("php://input"))->macList,array("DU:MM:YA:DD:RE:SS"));
        	$this->db->select_max('logTime');
    		$maxTime=$this->db->get('rawTimeData')->row_array()['logTime'];
    		$lastMacList=$this->db->get_where('rawTimeData',array('logTime'=>$maxTime))->row_array();
    		$this->db->insert('rawTimeData',array('macList'=>json_encode($macList)));
    		foreach ($macList as $macId) {
    			if(!$this->db->get_where('loggerUsers',array('macId'=>$macId))->row_array())
    				$this->db->insert('loggerUsers',array('macId'=>$macId));
    		}
    		if($lastMacList)
    		{
				$lastMacList=json_decode(json_encode(json_decode($lastMacList['macList'])),True);    			
	        	$macsLeft = array_diff($lastMacList, $macList);
    			$macsAdded = array_diff($macList, $lastMacList);
    		}
    		else
    		{
    			$macsAdded = $macList;
    		}
    		if($macsAdded)
    		{
	    		foreach ($macsAdded as $macAdded) {
	    			$this->db->insert('log',array('userMacId'=>$macAdded));
	    		}
    		}
                $now=new DateTime();
    		$now->add(new DateInterval('PT4H30M'));
    		$now = date_format($now, 'Y-m-d H:i:s');
    		if(isset($macsLeft))
    		{
	    		foreach ($macsLeft as $macLeft) {
		        	$this->db->select_max('userLoginTime');
		    		$userLoginTime=$this->db->get_where('log',array('userMacId'=>$macLeft))->row_array()['userLoginTime'];
		    		$toChange=array('userLogoutTime'=>$now);
		    		$toSearch=array('userMacId'=>$macLeft,'userLoginTime'=>$userLoginTime);
		    		$this->db->update('log',$toChange,$toSearch);
	    		}
    		}
        }

        public function getPeopleAtTime($start=0,$end=0)
        {
		$startTime=new DateTime("@$start");
                $startTime->add(new DateInterval('PT4H30M'));
                $startTime = date_format($startTime, 'Y-m-d H:i:s');
		$endTime=new DateTime("@$end");
                $endTime->add(new DateInterval('PT4H30M'));
                $endTime = date_format($endTime, 'Y-m-d H:i:s');
                $query = $this->db->query('select name,userMacId,userLoginTime,userLogoutTime from log,loggerUsers where log.userMacId = loggerUsers.macId and not ((\''.$startTime.'\' < userLoginTime and \''.$endTime.'\' < userLogoutTime) || (\''.$startTime.'\' > userLoginTime and \''.$endTime.'\' > userLogoutTime))');
                print json_encode($query->result());
        }
}
