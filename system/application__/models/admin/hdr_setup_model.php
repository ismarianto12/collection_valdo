<?php
/*
This script software package is NOT FREE And is Copyright 2010 (C) Valdo all rights reserved.
we do supply help or support or further modification to this script by Contact
Haidar Mar'ie
e-mail = coder5@ymail.com
*/
class Hdr_setup_model extends Model{

	public function __construct(){
		parent::Model();
	}
	public function check_filtered(){
		return $query = $this->db->count_all('hdr_filter_name');
	}
	public function get_filter_cat(){
		return $query = $this->db->get('hdr_filter_cat');
	}
	public function insert_filtering($filtered){

		$sql = "INSERT INTO hdr_filter_name
					(field_name, id_cat)
					SELECT  GROUP_CONCAT(".$filtered.") AS ".$filtered.", id_cat AS cat
					FROM (SELECT ".$filtered." FROM hdr_debtor_main  WHERE ".$filtered." != '' GROUP BY ".$filtered.") NAME,
					(SELECT id_cat FROM hdr_filter_cat WHERE field_value = '".$filtered."') cati";
		/* INSERT INTO hdr_filter_name
					(field_name, id_cat)
					SELECT  GROUP_CONCAT(kode_cabang) AS kode_cabang, id_cat AS cat
					FROM (SELECT kode_cabang FROM hdr_debtor_main  WHERE kode_cabang!= '' GROUP BY kode_cabang) NAME,
					(SELECT id_cat FROM hdr_filter_cat WHERE field_value = 'kode_cabang') cati */
		//echo $sql;
		return $query = $this->db->query($sql);
	}
	public function filter_type($filter){
		$sql = "SELECT tfn.field_name FROM hdr_filter_name AS tfn INNER JOIN hdr_filter_cat AS tfc ON tfn.id_cat = tfc.id_cat WHERE tfc.field_value = '$filter' ORDER BY id_input DESC LIMIT 1";
		$query = $this->db->query($sql);
		$data = $query->row();
		return $data->field_name;
	}
	public function field_file($id_upload_cat){
		$query = $this->db->get_where('hdr_debtor_field_name',array('id_upload_cat'=>$id_upload_cat));
		return $query->row();
	}

	public function syncronize_product()
	{
		$sql = "select * from hdr_tmp_log";
		$q = $this->db->query($sql);

		foreach($q->result_array() as $row)
		{
			$stval = $row['value'];
			$arrdata = explode("|",$stval);

			$where = array(
				"primary_1" => $row['primary_1']
			);
			$toupdate = array(
				"product" => $arrdata[29]
			);
			$this->db->update("hdr_debtor_main", $toupdate, $where);
		}

		$q->free_result();
	}
	
			 
}
?>