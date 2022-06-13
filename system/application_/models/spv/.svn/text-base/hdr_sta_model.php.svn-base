<?php
/*
This script software package is NOT FREE And is Copyright 2010 (C) Valdo all rights reserved.
we do supply help or support or further modification to this script by Contact
Haidar Mar'ie 
e-mail = coder5@ymail.com
*/
class Hdr_sta_model extends Model{
	
	public function __construct(){
		parent::Model();
		$this->CI =& get_instance();
	}
    
	public function insert_sta($data){
			$sql = $this->db->insert_string('hdr_send_to_agen', $data);
			$query = $this->db->query($sql);
			$this->insert_sta_call($data);
			return $this->db->insert_id();
	}    
    public function insert_sta_call($data){
			$data['cycling'] = '1';
			$data['sta'] = '1';
			unset($data['date']);
			$sql = $this->db->insert_string('hdr_calltrack', $data);
			$query = $this->db->query($sql);
			return $this->db->insert_id();
	}
    public function count_sta($user,$id_user,$begindate,$enddate){
		$group_bys = 'hdm.primary_1';
		$query_ptp = "";
		
		if($begindate!=""){
			$bg = " AND hsta.date >='$begindate ' ";
		}else{
			$bg = " ";
		}
		if($enddate!=""){
			$ed = " AND hsta.date <='$enddate ' ";
		}else{
			$ed = " ";
		}
		if($user =='tc'){
			$user = "WHERE hsta.id_user = '$id_user'";
		} 
		$sql =" SELECT COUNT(DISTINCT $group_bys) AS total_sta
                    FROM hdr_send_to_agen AS hsta 
					INNER JOIN hdr_debtor_main AS hdm ON hdm.primary_1 = hsta.primary_1
					$user $bg $ed
					";		
		//echo $sql.'</br>';
		$query = $this->db->query($sql);
		$data = $query->row();
		return $count = $data->total_sta;
	}
	public function count_sta_pdf($user,$id_user,$begindate,$enddate){
		$group_bys = 'hdm.primary_1';
		$query_ptp = "";
		
		if($begindate!=""){
			$bg = " AND hsta.date >='$begindate ' ";
		}else{
			$bg = " ";
		}
		if($enddate!=""){
			$ed = " AND hsta.date <='$enddate ' ";
		}else{
			$ed = " ";
		}
		if($user =='tc'){
			$user = "WHERE hsta.id_user = '$id_user'";
		} 
		$sql =" SELECT COUNT(DISTINCT $group_bys) AS total_sta
                    FROM hdr_sta_rtf AS hsr 
					INNER JOIN hdr_debtor_main AS hdm ON hdm.primary_1 = hsr.primary_1
					INNER JOIN hdr_send_to_agen AS hsta ON hdm.primary_1 = hsta.primary_1
					$user $bg $ed
					";		
		//echo $sql.'</br>';
		$query = $this->db->query($sql);
		$data = $query->row();
		return $count = $data->total_sta;
	}
    public function list_sta_flexi($begindate,$enddate,$report){
		$group_bys = 'hdm.primary_1';
		// echo 'user ='.$user.'<br/>';
		// echo 'id_user ='.$id_user.'<br/>';
		// echo 'status ='.$status.'<br/>';
		// echo 'status_r ='.$status_r.'<br/>';
		$where_filter =  $begindate==''?TRUE:FALSE;
		if($begindate!=""  ){
			$bg = " AND hsta.date>='$begindate ' ";
		}else{
			$bg = " ";
		}
		if($enddate!="" ){
			$ed = " AND hsta.date<='$enddate' ";
		}else{
			$ed = " ";
		}
		$query_ptp = "";
		$select_ptp = "";
		
	
		/* $bg = " AND ham.ptp_date>='$begindate' ";
			$ed = "   AND ham.ptp_date<='$enddate' "; */
		//echo $status;
		$querys['main_query'] = " SELECT hdm.*, hsta.*,  hdm.primary_1 as en_primary_1
		FROM hdr_send_to_agen  AS hsta 
		INNER JOIN hdr_debtor_main AS hdm ON hsta.primary_1 = hdm.primary_1
	
		 $bg $ed {SEARCH_STR} GROUP by $group_bys ";
		//echo $querys['main_query'];
		$querys['count_query'] = "SELECT COUNT(DISTINCT $group_bys) AS record_count
		FROM hdr_send_to_agen  AS hsta 
		INNER JOIN hdr_debtor_main AS hdm ON hsta.primary_1 = hdm.primary_1
	
		 $bg $ed 
		{SEARCH_STR}";
		$build_querys = $this->CI->flexigrid->build_querys($querys,$where_filter);
		
		$return['records'] = $this->db->query($build_querys['main_query']);
		$get_record_count = $this->db->query($build_querys['count_query']);
		$row = $get_record_count->row();
		$return['record_count'] = $row->record_count;
		
		return $return;
	}
	public function list_sta_rtf_flexi(){
		$group_bys = 'hdm.primary_1';
	
		$querys['main_query'] = " SELECT hdm.*, hsr.*,  hdm.primary_1 as en_primary_1
		FROM hdr_sta_rtf  AS hsr 
		INNER JOIN hdr_debtor_main AS hdm ON hsr.primary_1 = hdm.primary_1
		{SEARCH_STR} GROUP by $group_bys ";
		$querys['count_query'] = "SELECT COUNT(DISTINCT $group_bys) AS record_count
		FROM hdr_sta_rtf  AS hsr 
		INNER JOIN hdr_debtor_main AS hdm ON hsr.primary_1 = hdm.primary_1
		{SEARCH_STR}";
		$build_querys = $this->CI->flexigrid->build_querys($querys,$where_filter="TRUE");
		
		$return['records'] = $this->db->query($build_querys['main_query']);
		$get_record_count = $this->db->query($build_querys['count_query']);
		$row = $get_record_count->row();
		$return['record_count'] = $row->record_count;
		
		return $return;
	}
	public function reject_debtor_sta($primary_1){
		$this->db->delete('hdr_send_to_agen',array('primary_1'=>$primary_1));
	}
	public function reject_debtor_sta_pdf($primary_1){
		$this->db->delete('hdr_sta_rtf',array('primary_1'=>$primary_1));
	}
    public function sta_to_csv($begindate,$enddate,$report)
    {
        $group_bys = 'hdm.primary_1';
        $this->load->helper('csv');
        
		if($begindate!=""  ){
			$bg = " AND hsta.date>='$begindate ' ";
		}else{
			$bg = " ";
		}
		if($enddate!="" ){
			$ed = " AND hsta.date<='$enddate' ";
		}else{
			$ed = " ";
		}
        
        $sql = "SELECT hsta.primary_1, hdm.card_no, hdm.name, hdm.cycle, hdm.bucket_asccend, hdm.credit_limit, hdm.balance, hdm.home_address1, hdm.home_zip_code1, hdm.company_name, hdm.office_address1, hdm.office_zip_code1, hdm.area, hsta.date  
					FROM hdr_send_to_agen hsta 
					INNER JOIN  hdr_debtor_main hdm ON hdm.primary_1 = hsta.primary_1
					$bg $ed GROUP by $group_bys ";
        
        $query = $this->db->query($sql);	
		//echo  query_to_csv($query);
		$fileName = 'sta_'.date('Y_m_d_h_i_s').'.csv';
		query_to_csv($query, TRUE, $fileName);
    }
	public function sta_to_rtf(){
		$group_bys = 'hsr.primary_1';
		$sql = "SELECT hsr.*, htl.*, htl.value as en_value
					FROM hdr_sta_rtf hsr
					INNER JOIN hdr_tmp_log htl ON hsr.primary_1 = htl.primary_1 GROUP by $group_bys ";
		return $query = $this->db->query($sql);
	}
}