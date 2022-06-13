<?php
/*
 * Valdo Inc
 * (C) 20011 Valdo
 * @author Nudi Sanjaya
 */

if(!defined("BASEPATH")) exit("No direct script access allowed");

class Json extends Controller
{
  /**
   * Constructs the controller.
   */
  public function __construct()
  {
  	parent::Controller();
	}

  public function get_allbranch($region_val)
  {
		$arr_ex = array(
			'0641','0216','0104','0628','0109','0118','0110','0125','0101','0656','0607','0622','0657','0680','0604','0624','0681','0220','0128','0602','0648','0122','0512','0510','0105','0430'
		);

		$this->db->where_not_in("area_code",$arr_ex);
		$this->db->where("region_id",$region_val);
		$this->db->orderby("branch_name", "asc");
  	$q = $this->db->get("hdr_branches");
  	//echo($this->db->last_query());
  	//die();

  	if($q->num_rows() > 0)
  	{
  		$st_bag = '{"items":[';
			foreach($q->result_array() as $row)
			{
				//$data["items"][] = $row;
				$st_bag_arr[] = '{"branch_id":"'.$row['area_code'].'","branch_name":"'.trim($row['branch_name']).'"}';
			}
			$st_temp = $st_bag . implode(",",$st_bag_arr) . "]}";

			//var_dump($st_temp);
  	}
  	$q->free_result();

		//var_dump($data);
		echo $st_temp;
		die();
  }

}