<?php
/*
 * WEBBASE APPLIKASI
 *
 * Copyright (c) 2014
 *
 * file 	: sync.php
  */
/*----------------------------------------------------------*/
class Sync extends Controller {

	function __construct()
	{
		parent::Controller();
		//$this->authlib->cekcontr();
		$this->load->model('admin_model','modelku');
		date_default_timezone_set("Asia/Bangkok");
	}
	
	//autostop adira
	function index()
	{
		$daten = date('Y-m-d');
		$this->db = $this->load->database('ems',true);
		$query = $this->db->query("SELECT id,count(*) AS jlh FROM campains AS t1 WHERE t1.status='IDLE' AND DATE(tgl)='".$daten."' AND `company`=0");
		if ($query->num_rows() > 0) {
			$agt = $query->result_array();
			foreach ($agt as $agtrow){
				$jlh = $agtrow['jlh'];
			}
			//echo "status IDLE / NEW ".$jlh."<br>";
			if($jlh == 0){
				//echo "ulang status RUN<br>";
				$query1 = $this->db->query("SELECT id,jl FROM campains AS t1 WHERE `company`=0 AND t1.status='RUN' AND DATE(tgl)='".$daten."' GROUP BY id");
				if ($query1->num_rows() > 0) {
					$rsl = $query1->result_array();
					foreach ($rsl as $rown){
						$id = $rown['id'];
						$jlh1 = $rown['jl'] + 1;
						//if($jlh1 <= 5){
							$this->db->query("UPDATE campains SET `status`='IDLE', jl='".$jlh1."' WHERE `id`='".$id."'");
						//}
					}
				}
			}
		}
		
		$time = date('H:i');
		//echo $time;
		if($time >='20:00'){
			$this->db->query("UPDATE campains SET `status`='RUN' WHERE `company`=0 AND `status`='IDLE' AND DATE(tgl)='".$daten."'");
			$this->db->query("UPDATE campains_sample SET `status`='NEW' WHERE `company`=0 AND DATE(tgl)='".$daten."'");
		}
		if($time < '08:00'){
			$this->db->query("UPDATE campains SET `status`='RUN' WHERE `company`=0 AND `status`='IDLE' AND DATE(tgl)='".$daten."'");
			$this->db->query("UPDATE campains_sample SET `status`='NEW' WHERE `company`=0 AND DATE(tgl)='".$daten."'");
		}
		
		$data['username'] = $this->session->userdata('username');
    	$data['urllist1'] = $this->modelku->getAllDashboardAdira();
		$data['idlegraph'] = $this->modelku->get_data();
    	$this->load->view('adira',$data);

    }
	
	function insert_blast2(){
		
		$this->db = $this->load->database('ems',true);
		$whr = "WHERE `company`=0";
		$sql = $this -> db -> query("SELECT date(tgl) as tglnow,
				COUNT(CASE WHEN `company` = '0' THEN status END) AS totdat,
				COUNT(CASE WHEN `dialer_id` = 'OD30' THEN status END) AS od30,
				COUNT(CASE WHEN `dialer_id` = 'OD1' THEN status END) AS od1,
				COUNT(CASE WHEN `dialer_id` = 'OD0' THEN status END) AS od0,
				COUNT(CASE WHEN `dialer_id` = 'OD-2' THEN status END) AS od_2,
				COUNT(CASE WHEN `dialer_id` = 'OD-3' THEN status END) AS od_3,
				COUNT(CASE WHEN `status` LIKE '%DONE%' THEN status END) AS statdone,
				COUNT(CASE WHEN `status` LIKE '%DONE%' AND `dialer_id` = 'OD30' THEN status END) AS 30done,
				COUNT(CASE WHEN `status` LIKE '%DONE%' AND `dialer_id` = 'OD1' THEN status END) AS 1done,
				COUNT(CASE WHEN `status` LIKE '%DONE%' AND `dialer_id` = 'OD0' THEN status END) AS 0done,
				COUNT(CASE WHEN `status` LIKE '%DONE%' AND `dialer_id` = 'OD-2' THEN status END) AS _2done,
				COUNT(CASE WHEN `status` LIKE '%DONE%' AND `dialer_id` = 'OD-3' THEN status END) AS _3done,
				COUNT(CASE WHEN `status` LIKE '%RUN%' THEN status END) AS statrun,
				COUNT(CASE WHEN `status` LIKE '%RUN%' AND `dialer_id` = 'OD30' THEN status END) AS 30run,
				COUNT(CASE WHEN `status` LIKE '%RUN%' AND `dialer_id` = 'OD1' THEN status END) AS 1run,
				COUNT(CASE WHEN `status` LIKE '%RUN%' AND `dialer_id` = 'OD0' THEN status END) AS 0run,
				COUNT(CASE WHEN `status` LIKE '%RUN%' AND `dialer_id` = 'OD-2' THEN status END) AS _2run,
				COUNT(CASE WHEN `status` LIKE '%RUN%' AND `dialer_id` = 'OD-3' THEN status END) AS _3run,
				(SELECT count(id) from campains_log where company='0' and date(tgl) = curdate()) as invalid
				FROM `campains` AS t1 
				$whr and date(tgl) = curdate() group by tglnow" );
		$q = $sql -> row_array();
		//var_dump($this->db->last_query());
		if($sql->num_rows() > 0){
			//die('hehe');
			echo "<table cellpadding=10 cellspacing=0 border=1>
					<thead>
					<tr>
						<th>TANGGAL</th>
						<th>DATA</th>
						<th>OD30</th>
						<th>OD1</th>
						<th>OD0</th>
						<th>OD-2</th>
						<th>OD-3</th>
					</tr>
					</thead>
						<tr>
							<td align=center>".$q['tglnow']."</td>
							<td align=center>".$q['totdat']."</td>
							<td align=center>".$q['od30']."</td>
							<td align=center>".$q['od1']."</td>
							<td align=center>".$q['od0']."</td>
							<td align=center>".$q['od_2']."</td>
							<td align=center>".$q['od_3']."</td>
						</tr>
					</table><br/><br/>
					<table cellpadding=10 cellspacing=0 border=1>
					<thead>
					<tr>
						<th>CONTACT</th>
						<th>OD30</th>
						<th>OD1</th>
						<th>OD0</th>
						<th>OD-2</th>
						<th>OD-3</th>
						<th>UNCONTACT</th>
						<th>OD30</th>
						<th>OD1</th>
						<th>OD0</th>
						<th>OD-2</th>
						<th>OD-3</th>
						<th>DATA INVALID</th>
					</tr>
					</thead>
						<tr>
							<td align=center>".$q['statdone']."</td>
							<td align=center>".$q['30done']."</td>
							<td align=center>".$q['1done']."</td>
							<td align=center>".$q['0done']."</td>
							<td align=center>".$q['_2done']."</td>
							<td align=center>".$q['_3done']."</td>
							<td align=center>".$q['statrun']."</td>
							<td align=center>".$q['30run']."</td>
							<td align=center>".$q['1run']."</td>
							<td align=center>".$q['0run']."</td>
							<td align=center>".$q['_2run']."</td>
							<td align=center>".$q['_3run']."</td>
							<td align=center>".$q['invalid']."</td>
						</tr>
					</table>";

		}else{
			//die('haha');
			echo "NO DATA";
		} 
	}
	
	function insert_blast(){
		$data['username'] = $this->session->userdata('username');
    	$data['urllist1'] = $this->modelku->getAllDashboardAdira();
		$data['idlegraph'] = $this->modelku->get_data();
    	$this->load->view('adira',$data);
	}
	
	function test(){
		$this->db = $this->load->database('blast',true);
		$sql = $this -> db -> query("select * from hdr_debtor_main limit 10" );
		$q = $sql -> row_array();
		$a = $q['primary_1'];
		die($a);
	}
	
 }

/* End of file */