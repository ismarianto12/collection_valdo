<?php
class hdr_user_model extends Model{

	public function __construct(){
		parent::Model();
	}
	public function add_user($data){
		$data['passwd'] =  md5($data['passwd']);
		$sql = $this->db->insert_string('hdr_user', $data);
		$query = $this->db->query($sql);
		return $this->db->insert_id();
	}

	public function edit_user($data)
	{
		if(!empty($data['passwd'])){
			$data['passwd'] =  md5($data['passwd']);
		}

		$where = "id_user = ".$data['id_user']."";
		$sql = $this->db->update_string('hdr_user', $data, $where);

		return $this->db->query($sql);
	}

	public function edit_user_prop($data)
	{
		$where = array(
			"id_user" => $data['id_user']
		);

		//var_dump($data);
		//die();

		if( count($data['fin_type']) > 1 ) {
			$fin_type = implode(",",$data['fin_type']);
		} else {
			$fin_type = $data['fin_type'][0];
		}

		$toupdate = array(
			"product" => implode(",",$data['product']),
			"priority" => $data['priority'] != "" ? $data['priority'] : "",
			"region_area" => $data['region'],
			"is_excluded" => $data['exmode'],
			"angs_ke" => $data['angs_ke'],
			"branch_area" => implode(",",$data['branch']),
			"over_days" => $data['over_days'] != "" ? implode(",",$data['over_days']) : "",
			"fin_type" => $fin_type,
			"product_flag" => $data['product_flag'] != "" ? implode(",",$data['product_flag']) : "",
			"bucket_coll" => $data['bucket_coll'] != "" ? implode(",",$data['bucket_coll']) : "",
			"score_result" => $data['score_result'],
			"bucket_od" => $data['bucket_od']
		);
/*
		$toupdate = array(
			"product" => implode(",",$data['product']),
			"priority" => $data['priority'] != "" ? $data['priority'] : "",
			"region_area" => $data['region'],
			"is_excluded" => $data['exmode'],
			"branch_area" => implode(",",$data['branch']),
			"over_days" => $data['over_days'] != "" ? implode(",",$data['over_days']) : "",
			"fin_type" => $fin_type
		);
*/

	//var_dump($toupdate);
	//die();

		$this->db->update("hdr_user",$toupdate,$where);

		//var_dump($this->db->last_query());
		//die();
	}

	public function edit_shift($shift,$id_user){
            $sql = "UPDATE hdr_user
                        SET shift = '$shift' WHERE id_user = '$id_user' ";
            $query = $this->db->query($sql);
            return $query;
        }
	public function edit_user_role($user_role,$id_user){
            $sql = "UPDATE hdr_user
                        SET user_role = '$user_role' WHERE id_user = '$id_user' ";
            $query = $this->db->query($sql);
            return $query;
        }
	// take it
	public function get_list_level($cond){
		$tag_condition = $cond?get_tag_condition($cond,'WHERE'):'';
		$query = "SELECT * FROM  hdr_level ".$tag_condition;
		$query = $this->db->query($query);
		return $query;
	}
	public function get_list_user($cond){
		$tag_condition = $cond?get_tag_condition($cond,'WHERE'):'';
		$sql = "SELECT * FROM hdr_user ".$tag_condition." ORDER BY id_user ASC";
		//die($sql);
		return $query = $this->db->query($sql);
	}
	public function all_user($cond){
		$tag_condition = $cond?get_tag_condition($cond,'WHERE'):'';
		$sql = "SELECT hdu.*, hdl.*, hdl.level as level_user
						FROM hdr_user AS hdu
						INNER JOIN hdr_level AS hdl on ( hdu.id_level = hdl.id_level) ".$tag_condition."
						AND blocked = 0
						GROUP by hdu.id_user ORDER BY hdu.id_leader";
		//echo($sql);
		//die();
		return $this->db->query($sql);
	}
	public function get_user($id_user){
		$query = $this->db->get_where('hdr_user',array('id_user'=>$id_user))	;
		return $query->row();
	}
	public function get_leader($id_level,$id_user){
		$sql = "SELECT id_user, id_level, username FROM hdr_user WHERE id_level='$id_level' AND id_user NOT IN ('".$id_user."')";
		//$query = $this->db->get_where('hdr_user', array('id_level'=>'2'))	;
		$query =  $this->db->query($sql);
		return $query->result();
	}
	public function get_spv_leader($id_user){
		$sql = "SELECT id_user, id_level, username FROM hdr_user WHERE id_level='2' AND id_user NOT IN ('".$id_user."')";
		$query = $this->db->get_where('hdr_user', array('id_level'=>'2'))	;
		return $query->result();
	}
	public function check_username($username){
		$sql ="SELECT username FROM hdr_user WHERE username ='$username'";
		$query =$this->db->query($sql);
		return $query->num_rows();
	}
	public function count_user($cond){
		$tag_condition = $cond?get_tag_condition($cond,'WHERE'):'';
		$sql = $this->db->get_where('hdr_user',array($cond));
		return $sql->num_rows();
	}
	public function set_blocked($username,$blocked){
		$record->blocked = $blocked;
		return $this->db->update('hdr_user',$record,array('username'=>$username));
	}

	public function set_active($user){
		$record->blocked = $blocked;
		return $this->db->update('hdr_user',$record,array('username'=>$username));
	}
	public function set_login_failed($username,$login_failed){
		$record->login_failed = $login_failed;
		return $this->db->update('hdr_user',$record,array('username'=>$username));
	}
	public function get_login_failed($username){
		$sql = 'SELECT login_failed from hdr_user WHERE username="'.set_string_content($username).'"';
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return @$data[0]["login_failed"];
	}
	public function delete_user($id_user){
		$this->db->delete('hdr_user',array('id_user'=>$id_user));
	}

}
?>