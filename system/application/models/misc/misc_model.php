<?php
class Misc_model extends Model{
	
	public function __construct(){
		parent::Model();
	}
	
	function get_campaigndata($id_campaign, $field=''){
		$this->db->where('id_campaign', $id_campaign);
		$qObj = $this->db->get('tb_campaign');
	 if($qObj->num_rows() > 0){
	 	if($field == ''){
		  return $qObj->row_array();
		 } else {
		 	$result = $qObj->row_array();
		 	return $result[$field];
		 }
	 } else {
	 	return array();
	 }
	}
	
	function get_productdata($id_product, $field=''){
		$this->db->where('id_product', $id_product);
		$qObj = $this->db->get('tb_product');
		
		if($qObj->num_rows() > 0){
	 	if($field == ''){
		  return $qObj->row_array();
		 } else {
		 	$result = $qObj->row_array();
		 	return $result[$field];
		 }
	 } else {
	 	return array();
	 }
	}
	
	function get_producttype($type){
		$product_type = array('', 'Reguler', 'PreApprove', 'TopUp', 'Umrah');
		$type_name = @$product_type[$type];
		if(!$type_name){
			return 'Unknown';
		} else{
		 return $type_name;
	 }
	}
	
	function get_campaignStatus($id_campaign){
		$this->db->where('id_campaign', $id_campaign);
		$qObj = $this->db->get('tb_campaign');
		if($qObj->num_rows() > 0){
		$qArr = $qObj->row_array();
		if($qArr['published'] == '1'){
			 ## Check EndDate
			 $SQL = "SELECT '".$qArr['enddate']."' < CURDATE() AS is_expired";
			 $qObj_2 = $this->db->query($SQL);
			 $qArr_2 = $qObj_2->row_array();
			 $is_expired = $qArr_2['is_expired'];
			 if($is_expired == '1'){
			 	return 'Expired';
			 } else {
			 	return 'Active';
			 }
		} else {
			return 'Unpublished';
		}
	} else {
		return 'Not Found';
	}
	}
	
	function get_tableDataById($table, $id, $key, $field=''){
		$this->db->where($key, $id);
		$qObj = $this->db->get($table);
		if($qObj->num_rows() > 0){
			if($field == ''){
		  return $qObj->row_array();
		 } else {
		 	$result = $qObj->row_array();
		 	return $result[$field];
		 }
		} else {
			return '-';
			
		}
	}
	
	function get_count_statustrack($id_prospect){
		
		$sql = "SELECT count(*) as xcount FROM tb_statustrack where id_prospect = '$id_prospect' AND update_type='FU' ";
		//echo($sql);
		//die($sql);
    $query = $this->db->query($sql);
		$data = $query->row_array();
		return @$data["xcount"];
	}
	
	function get_parentcallcode($id_callcode){
		if($id_callcode != '0'){
			$this->db->where('id_callcode', $id_callcode);
			$this->db->select('parent_id_callcode');
			$qObj = $this->db->get('tb_callcode');
			$qArr = $qObj->row_array();
			
			return $qArr['parent_id_callcode'];
	 }
	}
	
	function get_prioritysource($type=""){
		if($type != ""){
			$priority_source = array('Unknown', 'ATM', 'Inbound');
			$source = $priority_source[$type];
			if(!$source){
				return 'Unknown';
			} else {
				return $source;
			}
		} else {
			return 'Unknown';
		}
	}
	
	function get_userchild($id_leader, $is_monitor=0){
		if($id_leader != ''){
			$this->db->where('id_leader', $id_leader);
			$this->db->where('blocked', 0);
			if($is_monitor == 1) {
				$this->db->order_by('user_status', 'DESC');
				$this->db->order_by('last_call', 'DESC');
			} else {
			 $this->db->order_by('fullname', 'ASC');
			}
			$qObj = $this->db->get('tb_users');
			$qArr = array();
			if($qObj->num_rows() > 0){
				$qArr = $qObj->result_array();
			}
			return $qArr;
		} else {
			return '';
		}
	}
	
	function get_fixedlastdial($last_datetime){
		$this->db->select("TIME_TO_SEC(TIMEDIFF(NOW(), '$last_datetime')) AS SEC_DIFF", FALSE);
		$qObj = $this->db->get();
		$qArr = $qObj->row_array();
		!empty($qArr['SEC_DIFF']) ? $SEC_DIFF = $qArr['SEC_DIFF'] : $SEC_DIFF = '';
		 //var_dump($SEC_DIFF);
		return $this->humanize_time($SEC_DIFF);
	}
	
	function humanize_time($secs){
		if($secs > 0 && $secs < 60){
			return $secs.' sec ago';
		} else if($secs >= 60 && $secs < 3600) {
			$minute = FLOOR($secs/60);
			return $minute.' min ago';
		} else if($secs >= 3600 && $secs < 86400){
			$hour = ROUND($secs/3600);
			return $hour.' hour ago';
		} else if($secs > 86400) {
			return '24+ hour ago';
		} else {
			return 'NODATA';
		}
	}
	
	function sec_to_time($secs){
		$SQL = "SELECT SEC_TO_TIME($secs) AS xtime";
		$qObj = $this->db->query($SQL);
		$qArr = $qObj->row_array();
		return $qArr['xtime'];
	}
	
	function format_phone($input){
		if(strlen($input > 4)){
			$len = strlen($input);
			$area_code = substr($input, 0, 4);
			$string_chunk = str_split($input);
			if(substr($area_code, 0, 3) == '021' || substr($area_code, 0, 3) == '022'){
				$fixed_str = "(";
				$fixed_str .= substr($area_code, 0, 3);
				$fixed_str .= ")";
				$fixed_str .= substr($input, 3);
				return $fixed_str;
			} else {
				$fixed_str = "";
				$idx = 1;
				foreach($string_chunk as $char){
					$fixed_str .= $char;
					if($idx % 4 == 0 && $idx != $len){ $fixed_str .= "-"; }
					$idx++;
				}
				return $fixed_str;
			}
		} else {
			return $input;
		}
	}

}
?>