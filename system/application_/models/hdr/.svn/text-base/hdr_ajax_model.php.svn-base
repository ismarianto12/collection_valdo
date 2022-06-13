<?php
class Hdr_ajax_model extends Model{
	public function __construct(){
		parent::Model();
	}

	public function get_name($name){
			$this->db->select('name');
			//$this->db->where('fiedl3',1);
			$this->db->like('name',$name);
			$this->db->order_by('name','asc');
			$this->db->limit(50, 0);
			return $this->db->get('hdr_debtor_main');
			//$this->db->last_query();
			//echo $this->db->last_query();
	}
	public function get_primary_1($primary_1){

			$this->db->select('primary_1');
			$this->db->order_by('primary_1','asc');
			$this->db->limit(50, 0);
			$this->db->like('primary_1',$primary_1);
			return $this->db->get('hdr_debtor_main');

/*
				$id_user = @$_SESSION['bid_user_s'];
				$where = array(
					"id_user" => $id_user
				);
				$q = $this->db->get_where("hdr_user", $where);
				$row = $q->row_array();

				$product = $row['product'];
				$priority = $row['priority'];
				$branch_area = $row['branch_area'];
				$over_days = $row['over_days'];

				$where =  " where id_debtor > 0 ";
				$where .= " and not_ptp = '0' ";
				$where .= " and called = '0' ";
				$where .= $branch_area != "" ? " and substring(trim(branch),1,3) in ($branch_area) " : "";

				$arr_temp = null;
				if($product != "ALL")
				{
					$where .= " and (";
					$arrdata = explode(",", $product);
					for($i=0;$i<count($arrdata);$i++)
					{
						$arr_temp[] .= " product = ('".$arrdata[$i]."') ";
					}
					$where .= implode("or",$arr_temp) . ")";
				}

				if($over_days != "")
				{
					$arr_temp = "";
					$where .= " and (";
					$arrdata = explode(",", $over_days);
					for($i=0;$i<count($arrdata);$i++)
					{
						$arr_temp[] .= " datediff(now(),due_date) = ('".$arrdata[$i]."') ";
					}
					$where .= implode("or",$arr_temp) . ")";
				}

				if($priority != "")
				{
					$arrdata_prod = explode(",", $priority);
					for($i=0;$i<count($arrdata_prod);$i++)
					{
						switch($arrdata_prod[$i])
						{
							case "PTP":
							break;

							case "NOTOVERDUE":
								//$where .= " and datediff(now(),due_date) < 0 ";
							break;

							case "ANGSKE1":
								$where .= " and angsuran_ke=1 ";
							break;
						}
					}
				}

				if($primary_1 != "")
				{
					$where .= " and primary_1 = '$primary_1' ";
				}

				//die($where);
				if($branch_area != '' && $branch_area != 'null')
				{
					$sql = "select * from hdr_debtor_main " .
						" $where limit 1";
					//die($sql);
					$q = $this->db->query($sql);
					$get_last = $q;
					$q->free_result();
				}
				else
					$get_last = null;

		return $get_last;
*/

	}

	public function get_card_no($card_no){
			$this->db->select('card_no');
			$this->db->order_by('card_no','asc');
			$this->db->limit(50, 0);
			$this->db->like('card_no',$card_no);
			return $this->db->get('hdr_debtor_main');
	}
	public function get_remark($remark_code){
			$this->db->select('code_call_track');
			$this->db->order_by('code_call_track','asc');
			$this->db->like('code_call_track',$remark_code);
			return $this->db->get('hdr_action_call_track');
	}

	public function get_correct_name($name){
			$this->db->limit(1, 0);
			return $query = $this->db->get_where('hdr_debtor_main', array('name'=>$name));
	}
	public function get_correct_card_no($card_no){
			$this->db->limit(1, 0);
			return $query = $this->db->get_where('hdr_debtor_main', array('card_no'=>$card_no));
	}
	public function get_correct_primary_1($primary_1){
			$this->db->limit(1, 0);
			return $query = $this->db->get_where('hdr_debtor_main', array('primary_1'=>$primary_1));
	}

}
?>