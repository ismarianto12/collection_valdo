<?php
class Hdr_filter_model extends Model{
	public function __construct(){
		parent::Model();
	}

	public function view_filter(){
		//$this->output->enable_profiler('TRUE');
		$check_filter = $this->setup_model->check_filtered();

		/* if($check_filter > 0){
			$this->db->truncate('hdr_filter_name');
			$get_filter_cat = $this->setup_model->get_filter_cat();
			foreach($get_filter_cat->result() as $cat_filter){
					$filtered = $cat_filter->field_value;
					$this->setup_model->insert_filtering($filtered);
			}
		}
		*/
		$data['all_kode_cabang'] = $this->setup_model->filter_type($type="kode_cabang");

		return $data;
	}
	public function data_filter(){
		//$patterns_filter = array("/\./","/\+/", '/&/', '/branch=/','/product=/','/priority=/', '/ovrday=/');
		//$replacements = array('', ' ', '","', '');
		//$ex_post = preg_replace($patterns_filter, $replacements, $_POST);

		$product = $this->input->post("product");
		$branch = $this->input->post("branch");
		$priority = $this->input->post("priority");
		$ovrday = $this->input->post("ovrday");

		switch($priority)
		{
			case "PTP":
				$data[] = ' hdm.ovd ="'.$ovrday.'"';
			break;
			case "OVERDUE":
				$data[] = ' hdm.ovd ="'.$ovrday.'"';
			break;
			case "NOTOVERDUE":
				$data[] = ' hdm.ovd ="'.$ovrday.'"';
			break;
			case "ANGSKE1":
				$data[] = ' hdm.ovd ="'.$ovrday.'"';
			break;
		}

		//$data[] = @$_POST['region']?' hdm.region ="'.@$ex_post['region'].'"':'';
		//$data[] = @$_POST['region']?' hdm.balance >="'.@$ex_post['from_balance'].'"':'';

		$data[] = $ovrday ? ' hdm.ovd ="'.$ovrday.'"':'';

		//$data[] = @$_POST['from_dpd']?' hdm.dpd >="'.@$ex_post['from_dpd'].'"':'';
		//$data[] = @$_POST['to_dpd']?' hdm.dpd <="'.@$ex_post['to_dpd'].'"':'';

		$data[] = $branch ? ' substring(hdm.branch,1,3) IN ("'. $branch . '")':'';

		$post = @$_POST;
		//print_r($_POST);
		$array_data = array_diff($data, array(''));
		$string_data = '';
		if(!empty($array_data)){
			foreach ($array_data as $row_data){
			$i =1;
				$string_data .= ' AND '. $row_data;
			}
			$sub_string_data = substr($string_data, 5);
			//echo $sub_string_data;
			return 'WHERE '.$sub_string_data;
		} else {
			//print_r($array_data);
			return $where="";
		}

	}
	function monitoring_detail($od,$type){
		if($od == 'total'){
			$where = "";
		}else{
			$where = "and datediff(now(),due_date) = '$od'";
		}
		$sql = "select datediff(now(),due_date) as od,
			SUM(os_ar) as total_os,
			count(case when id_debtor>0 then datediff(now(),due_date) end) as total_data,
			count(case when id_debtor>0 and called>0 and id_user>0 then datediff(now(),due_date) end) as total_tounch,
			(count(case when id_debtor>0 then datediff(now(),due_date) end)-count(case when id_debtor>0 and called>0 and id_user>0 then datediff(now(),due_date) end)) as total_sisa,
			count(case when id_debtor>0 and called>0 and id_user>0 then datediff(now(),due_date) end) /
			count(case when id_debtor>0 then datediff(now(),due_date) end) * 100 as percentage
			from hdr_debtor_main
			where valdo_cc='01'
			$where";
		$q = $this->db->query($sql);
		$row = $q->row_array();
		if($type == 'total_cust'){
			return $row['total_data'];
		}else if($type == 'total_os'){
			return $row['total_os'];
		}else if($type == 'pengerjaan'){
			return $row['total_tounch'];
		}else if($type == 'sisa'){
			return $row['total_sisa'];
		}else if($type == 'work'){
			return $row['percentage'];
		}
	}

}
?>