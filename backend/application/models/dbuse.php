<?php
	class dbuse extends CI_Model{

		function __construct(){
			parent::__construct();
		}

		function get(){
			$query=$this->db->query('select * from student');

			if($query->num_rows() > 0)
			{
				return $query->result();

			}
			else
				return NULL;
		}
	}