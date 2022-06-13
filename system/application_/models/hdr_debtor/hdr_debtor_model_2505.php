<?php
/*
Release Date: March, 2010
Copyright (c) 2010  Valdo
This script software package is NOT FREE And is Copyright 2010 (C) Haidar Mar'ie (Valdo) all rights reserved. Is NOT for distribution OR meant for the public Domain and remains exclusively the property of Valdo all rights reserved, if you have purchased this Copy of this program you may use it on one website only unless Other arrangements have been made with you Any alterations to this script should be authorised by Valdo and Bumiputera all rights reserved with full information on the alterations Made, Modifications should not be made other than in any Set-up parts of this program and software, this software is scheduled to become part of our Valdo Software.
we do supply help or support or further modification to this script by Contact
Haidar Mar'ie
e-mail = coder5@ymail.com
*/

class Hdr_debtor_model extends Model {
    private $hdr_debtor_main;
    private $tb_debtor_details;
    private $hdr_debtor_field_name;
    private $hdr_payment;
    private $hdr_calltrack;
    private $hdr_action_call_track;
    private $hdr_reschedule;
    private $hdr_agen_monitor;

    public function __construct() {
        parent::Model();
        $this->CI =& get_instance();
        $this->hdr_debtor_main = 'hdr_debtor_main';
        $this->hdr_payment = 'hdr_payment';
        $this->hdr_calltrack = 'hdr_calltrack';
        $this->hdr_action_call_track = 'hdr_action_call_track';
        $this->hdr_debtor_details = 'hdr_tmp_log';
        $this->hdr_debtor_field_name = 'hdr_debtor_field_name';
        $this->hdr_reschedule = 'hdr_reschedule';
        $this->hdr_agen_monitor = 'hdr_agen_monitor';

    }
    public function all_debtor_flexi_view($filter_for) {
    	//die("aa");
        if($filter_for =='view_all') {
            $filter = isset($_SESSION['filter_debtor_tmp'])?$_SESSION['filter_debtor_tmp']:'WHERE primary_1!="0"';
            $where_filter =  $filter==''?TRUE:FALSE;

        } else {

            //$filter = $filter_for !=''?$this->get_next_call($filter_for):'WHERE primary_1!="0"';
            //$where_filter =  $filter==''?TRUE:FALSE;
        		//die($filter);

					$where_filter = "";
					$where = array(
						"id_user" => $filter_for
					);
					$q = $this->db->get_where("hdr_user", $where);
					$row = $q->row_array();

					$product = $row['product'];
					$priority = $row['priority'];
					$branch_area = $row['branch_area'];
					$over_days = $row['over_days'];
					$fin_type = $row['fin_type'];

				### Martin-> escaping value branch ###
				if($branch_area != ''){
					$tmp_arr = explode(",",$branch_area);
					$index = 0;
					foreach($tmp_arr as $row) {
						$tmp_arr[$index] = $this->db->escape($row);
						$index++;
					}

					$branch_area = implode(",",$tmp_arr);
				}
				### end escaping value branch ###


					$where = " where id_debtor > 0";
					$where .= $branch_area != "" ? " and kode_cabang in ($branch_area) " : "";

					$arr_temp = null;
					if($product != "ALL")
					{
						$where .= " and (";
						$arrdata = explode(",", $product);
						for($i=0;$i<count($arrdata);$i++)
						{
							$arr_temp[] .= " object_group_code = ('".$arrdata[$i]."') ";
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
							if($arrdata[$i] != '10plus'
								&& $arrdata[$i] != '180plus'
								&& $arrdata[$i] != '120plus'){
								$arr_temp[] .= " datediff(now(),due_date) = ('".$arrdata[$i]."') ";
							} elseif ($arrdata[$i] == '120plus'){
								$arr_temp[] .= " dpd > 120 ";
							} elseif ($arrdata[$i] == '180plus'){
								$arr_temp[] .= " dpd > 180 ";
							} else {
								$arr_temp[] .= " datediff(now(),due_date) >= ('10') ";
							}
						}
						$where .= implode("or",$arr_temp) . ")";
					}
					else
					{

						$where .= "and (datediff(now(),due_date) >= 0)";
					}

					if($priority != "")
					{
						$arrdata_prod = explode(",", $priority);
						for($i=0;$i<count($arrdata_prod);$i++)
						{
							switch($arrdata_prod[$i])
							{
								case "PTP":
								$where .= " and ptp_date is not null and id_user = '$filter_for' and month(ptp_date)=month(now()) and year(ptp_date)=year(now())";
								break;

								case "UNTOUCH":
									$where .= " and (is_new = 1) ";
								break;

								case "RETOUCH":
									$where .= " and is_new = 2 ";
								break;
							}
						}
					}

			  ### Data Type ###

					$find_me = ",";
					$pos_flag = strpos($fin_type,$find_me); //IF FALSE THEN THERE IS ONLY 1 OPTION SELECTED



					if(!$pos_flag){
						$fin_type_arr = $fin_type;
						if($fin_type_arr != '0'){
							$where .= "AND ( fin_type IN (";
							$where .= $fin_type_arr;
							$where .= "))";
						} else {
							$where .= "";
						}
					}
					else{
						$fin_type_arr = explode($find_me,$fin_type);
						$where .= "AND ( fin_type IN(";
						foreach($fin_type_arr as $fin_type_row){
								$where .= $fin_type_row.",";
						}
						$where = substr_replace($where,"",-1,1);
						$where .= "))";
					}

				#################


						$sql = "select hdm.*, hdm.primary_1 AS en_primary1 from hdr_debtor_main hdm " .
							" $where ";

						$sql_count = "select count(distinct primary_1) as record_count from hdr_debtor_main " .
							" $where ";

        }

        //$querys['main_query'] =  " SELECT hdm.*, hdm.primary_1 AS en_primary1 FROM ".$this->hdr_debtor_main." AS hdm ".$filter ."  {SEARCH_STR}  GROUP BY primary_1 ";
        //$querys['count_query'] =  " SELECT COUNT(DISTINCT primary_1) as record_count FROM ".$this->hdr_debtor_main." AS hdm  ".$filter ." {SEARCH_STR}  ";

        $querys['main_query'] = $sql;
        $querys['count_query'] = $sql_count;

        //die($querys['count_query']);

        //$build_querys = $this->CI->flexigrid->build_querys($querys,$where_filter);

        //die(var_dump($querys));

        $build_querys['main_query'] = $querys['main_query'];
        $build_querys['count_query'] = $querys['count_query'];

        $return['records'] = $this->db->query($build_querys['main_query']);

				//$str = $this->db->last_query();
				//die($str);
        //var_dump($return['records']);
        //die();

        $get_record_count = $this->db->query($build_querys['count_query']);

        $row = $get_record_count->row();
        $return['record_count'] = $row->record_count;

        return $return ;
    }
    public function all_debtor_hist_payment_flexi($primary_1) {
        $querys['main_query'] =  " SELECT *  FROM ".$this->hdr_payment ."   WHERE primary_1 = '$primary_1'   {SEARCH_STR}  ";
        $querys['count_query'] =  " SELECT COUNT( primary_1) as record_count FROM ".$this->hdr_payment." WHERE primary_1 = '$primary_1'  {SEARCH_STR}  ";
        $build_querys = $this->CI->flexigrid->build_querys($querys,TRUE);
        $return['records'] = $this->db->query($build_querys['main_query']);
        //$str = $this->db->last_query();
        //die($str);
        $get_record_count = $this->db->query($build_querys['count_query']);
        $row = $get_record_count->row();
        $return['record_count'] = $row->record_count;
        return $return ;
    }
    public function all_debtor_hist_calltrack_flexi($primary_1,$id_action_call_track,$id_user) {
        if($id_action_call_track=='ptp') {
            $id_action ='28';
        }elseif($id_action_call_track=='rem') {
            $id_action ='52';
        }else {
            $id_action = $id_action_call_track;
        }
        //die("bbb");
        $where_filter =  $id_action_call_track==''?TRUE:FALSE;
        $ptp_status = $id_action_call_track=='ptp'?"AND hdc.id_ptp='1'":'';
        $get_name = $id_action =='52'?'hdm.name AS name':'';
        $join_hdm = $id_action =='52'?"INNER JOIN hdr_debtor_main AS hdm ON hdc.primary_1 = hdm.primary_1":'';
        $all_debt = $primary_1=='all'?'':$primary_1;
        $prim =  $all_debt !=''?" hdc.primary_1 = '$all_debt'":'hdc.primary_1 !=""';
        $querys['main_query'] =  " SELECT hdc.*, hdc.primary_1 AS en_primary1, hdc.code_call_track AS hcall_code  FROM ".$this->hdr_calltrack ." AS hdc
													 WHERE $prim $ptp_status {SEARCH_STR}   ";
        //$querys['count_query'] =  " SELECT 100  AS record_count";
        /*SELECT (SELECT COUNT(primary_1)  FROM hdr_calltrack WHERE  primary_1 = '010307135915') +
     (SELECT COUNT(primary_1) FROM hdr_calltrack_old WHERE  primary_1 = '010307135915')   */
        $querys['count_query'] =  "SELECT COUNT(primary_1)    AS record_count  FROM hdr_calltrack WHERE  primary_1 = '$primary_1' $ptp_status {SEARCH_STR} ";
        //echo $querys['main_query'];
        $build_querys = $this->CI->flexigrid->build_querys($querys,$where_filter);
        $return['records'] = $this->db->query($build_querys['main_query']);
        $get_record_count = $this->db->query($build_querys['count_query']);
        //$str = $this->db->last_query();
        //die($str);
       	if($get_record_count === true){
        $row = $get_record_count->row();
        $return['record_count'] = $row->record_count;
        $return['records'] = $row;
      	}else {
      		$return['record_count'] = 0;
      	}
        //var_dump($return);
        //die();
        //$query_out = str_replace('{SEARCH_STR}','',$querys['main_query']);
        //$query_reg = $this->db->query($query_out);

        return $return ;
    }
    public function all_debtor_hist_calltrack_rem_flexi($primary_1,$id_action_call_track,$id_user) {

        $where_filter =  $id_action_call_track==''?TRUE:FALSE;
        $rem_status = $id_action_call_track=='rem'?" hdc.id_action_call_track='52'":'';
        //$user = $id_action =='4'?" AND hdc.id_user ='$id_user'":'';	$act $ptp_call
        $id_user = $_SESSION['bid_user_s'];
        $all_debt = $primary_1=='all'?'':$primary_1;
        $prim =  $all_debt !=''?" hdc.primary_1 = '$all_debt'":'hdc.primary_1 !=""';
        $querys['main_query'] =  " SELECT hdc.*, hdc.primary_1 AS en_primary1, hdc.cname AS name FROM ".$this->hdr_calltrack ." AS hdc

													 WHERE   $rem_status   AND hdc.id_user = '$id_user' {SEARCH_STR}   ";
        //$querys['count_query'] =  " SELECT 100  AS record_count";
        $querys['count_query'] =  " SELECT COUNT(DISTINCT hdc.id_calltrack) as record_count FROM ".$this->hdr_calltrack."  AS hdc
												 WHERE  $rem_status   AND hdc.id_user = '$id_user' {SEARCH_STR}  ";
        //die($querys['main_query']);
        $build_querys = $this->CI->flexigrid->build_querys($querys,$where_filter);
        $return['records'] = $this->db->query($build_querys['main_query']);
        $get_record_count = $this->db->query($build_querys['count_query']);
        $row = $get_record_count->row();
        $return['record_count'] = $row->record_count;
        return $return ;
    }
    public function get_next_call($id_user) {
        $sql = "SELECT filter_debtor FROM hdr_user WHERE id_user = '$id_user' ORDER BY id_user DESC LIMIT 1";
        //echo $sql;
        $query = $this->db->query($sql);
        $data = $query->row();
        if($query->num_rows() >= 1 && $data->filter_debtor !='') {

            return $data->filter_debtor;
        } else {
            return 'WHERE primary_1 != "0"';
        }
    }
    public function all_debtor_hist_user_calltrack_flexi($id_action_call_track,$id_user,$begindate,$enddate) {

        $status ='';
        $user = " hdc.id_user ='$id_user'";


            $groupbys = '';
        $query_ptp = "";
        $select_ptp = "";
        if($id_action_call_track =='all') {
        $groupbys ='hdc.id_calltrack';
            $status_r = " AND hdc.id_action_call_track !='52'  ";

        }elseif($id_action_call_track =='contact') {
        $groupbys ='';
            $status_r = "AND hdc.id_call_cat = '1' AND hdc.id_action_call_track !='52'  ";

        } elseif($id_action_call_track =='ptp') {
        $groupbys ='';
            $status_r = "AND hdc.id_ptp ='1' ";

        } elseif($id_action_call_track =='no_ptp') {
            $status_r = "AND hdc.id_call_cat ='1' AND hdc.id_action_call_track NOT IN ('52','28')  ";

        } elseif($id_action_call_track =='AC') {
            $status_r = " ";

        } elseif($id_action_call_track =='no_contact') {
            $status_r = "AND hdc.id_call_cat = '2' ";

        }  elseif($id_action_call_track =='acct_worked') {
            $groupbys = 'hdc.primary_1,hdc.call_date';
            $status_r = "AND hdc.is_current = '1'  ";

        }
        if($id_action_call_track == "ptp") {
            $select_ptp = ",hdc.ptp_date, hdc.ptp_amount";

        } elseif($id_action_call_track == "acc") {
            $select_ptp = ",hdc.ptp_date, hdc.ptp_amount";

        } elseif($id_action_call_track == "all") {
        }
        $group_by = $groupbys!=""?"GROUP BY ".$groupbys:"";
        $where_filter =  $id_action_call_track==''?TRUE:FALSE;
        $distinct =  $groupbys!=""?"DISTINCT $groupbys ":"primary_1";
        $querys['main_query'] =  " SELECT hdc.*, hdc.primary_1 AS en_primary1, hdc.code_call_track AS hcall_code  FROM ".$this->hdr_calltrack ." AS hdc

                                     WHERE  $user AND hdc.call_date ='".date_now()."'   $status_r
                                    {SEARCH_STR}  $group_by";
        $querys['count_query'] =  " SELECT COUNT($distinct) as record_count FROM ".$this->hdr_calltrack."  AS hdc
                                     WHERE  $user AND hdc.call_date ='".date_now()."'   $status_r  {SEARCH_STR}  ";
        //echo $querys['main_query'];
        $build_querys = $this->CI->flexigrid->build_querys($querys,$where_filter);
        $return['records'] = $this->db->query($build_querys['main_query']);
        $get_record_count = $this->db->query($build_querys['count_query']);
        $row = $get_record_count->row();
        $return['record_count'] = $row->record_count;
        return $return ;
    }
    public function all_debtor_hist_user_keep_broken_flexi($id_action_call_track,$id_user,$begindate,$enddate) {

        $begindate = date('Y-m-01');
        $enddate = date('Y-m-31');

        $status ='';
        $user = " hdc.id_user ='$id_user'";

        $query_ptp = "";
        $select_ptp = "";
        if($id_action_call_track =='keep') {
            $status_r = "hdc.ptp_status = '2'  ";
            if($begindate!=""  ) {
                $bg = "   AND MONTH(hdp.trx_date) >= MONTH(hdc.call_date)  ";
            }else {
                $bg = "'";
            }
            if($enddate!="") {
                $ed = " ";
            }else {
                $ed = " ";
            }
        }elseif($id_action_call_track =='broken') {
            $status_r = "hdc.ptp_status = '1'  ";
            if($begindate!= ""  ) {
                $bg = "";
            }else {
                $bg = " ";
            }
            if($enddate!="") {
                $ed = "  ";
            }else {
                $ed = " ";
            }
        }
        $where_filter =  $id_action_call_track==''?TRUE:FALSE;
        $querys['main_query'] =  " SELECT hdc.*, hdc.primary_1 AS en_primary1, hdc.code_call_track AS hcall_code, hdc.cname AS name, hdp.trx_date AS trx_date, hdp.amount AS amount,  hdc.code_call_track AS haccall_track,hdc.ptp_date, hdc.ptp_amount
                                                    FROM ".$this->hdr_calltrack ." AS hdc
                                                    LEFT JOIN hdr_payment AS hdp ON hdc.primary_1 = hdp.primary_1
                                                    WHERE  $user AND  $status_r AND id_action_call_track ='28' AND hdc.call_month =MONTH('$begindate')  GROUP BY hdc.primary_1
                                                    {SEARCH_STR}  ";
        $querys['count_query'] =  " SELECT COUNT(DISTINCT hdc.primary_1) as record_count
                                                        FROM ".$this->hdr_calltrack."  AS hdc
							LEFT JOIN hdr_payment AS hdp ON hdc.primary_1 = hdp.primary_1
                                                        WHERE  $user  AND $status_r AND id_action_call_track ='28' AND hdc.call_month =MONTH('$begindate')  {SEARCH_STR} ";
        //echo $querys['main_query'];
        $build_querys = $this->CI->flexigrid->build_querys($querys,$where_filter);
        $return['records'] = $this->db->query($build_querys['main_query']);
        $get_record_count = $this->db->query($build_querys['count_query']);
        $row = $get_record_count->row();
        $return['record_count'] = $row->record_count;
        return $return ;
    }
    public function debtor_status_ptp($id_action_call_track,$id_user,$begindate,$enddate) {

        $status ='';
        $user = " hdc.id_user ='$id_user'";
        if($begindate!=""  ) {
            $bg = " AND hdc.call_date>='$begindate ' ";
        }else {
            $bg = " ";
        }
        if($enddate!="" ) {
            $ed = " AND hdc.call_date<='$enddate' ";
        }else {
            $ed = " ";
        }
        $query_ptp = "";
        $select_ptp = "";
        if($id_action_call_track =='all') {
            $status_r = " AND hdc.id_action_call_track !='52'  ";

        }elseif($id_action_call_track =='contact') {
            $status_r = "AND hac.id_call_cat = '1' AND hdc.id_action_call_track !='52'  ";

        }

        $where_filter =  $id_action_call_track==''?TRUE:FALSE;
        $querys['main_query'] =  " SELECT hdc.*, hdc.primary_1 AS en_primary1, hdc.code_call_track AS hcall_code, hac.*, hdm.name AS name, hac.code_call_track AS haccall_track FROM ".$this->hdr_calltrack ." AS hdc
													INNER JOIN hdr_debtor_main AS hdm ON hdc.primary_1 = hdm.primary_1
													 LEFT JOIN ".$this->hdr_action_call_track ." AS hac ON hdc.id_action_call_track = hac.id_action_call_track WHERE  $user $bg $ed  AND (hdc.remarks !='' $status_r)
													{SEARCH_STR}  ";
        $querys['count_query'] =  " SELECT COUNT(DISTINCT hdc.id_calltrack) as record_count FROM ".$this->hdr_calltrack."  AS hdc
													INNER JOIN hdr_debtor_main AS hdm ON hdc.primary_1 = hdm.primary_1
													LEFT JOIN ".$this->hdr_action_call_track ."  AS hac ON hdc.id_action_call_track = hac.id_action_call_track  WHERE  $user $bg $ed  AND (hdc.remarks !=''$status_r)  {SEARCH_STR}  ";
        //echo $querys['main_query'];
        $build_querys = $this->CI->flexigrid->build_querys($querys,$where_filter);
        $return['records'] = $this->db->query($build_querys['main_query']);
        $get_record_count = $this->db->query($build_querys['count_query']);
        $row = $get_record_count->row();
        $return['record_count'] = $row->record_count;
        return $return ;
    }
    public function all_debtor_hist_reschedule_flexi($primary_1) {
        $querys['main_query'] =  " SELECT *, primary_1 AS en_primary1 FROM ".$this->hdr_reschedule ." WHERE primary_1 = '$primary_1'   {SEARCH_STR}  GROUP BY id_reschedule ";
        $querys['count_query'] =  " SELECT COUNT(DISTINCT id_reschedule) as record_count FROM ".$this->hdr_reschedule." WHERE primary_1 = '$primary_1'  {SEARCH_STR}  ";
        $build_querys = $this->CI->flexigrid->build_querys($querys,TRUE);
        $return['records'] = $this->db->query($build_querys['main_query']);
        $get_record_count = $this->db->query($build_querys['count_query']);
        $row = $get_record_count->row();
        $return['record_count'] = $row->record_count;
        return $return ;
    }
    public function all_debtor_hist_agen_track_flexi($primary_1) {
        $querys['main_query'] =  " SELECT *, primary_1 AS en_primary1 FROM ".$this->hdr_agen_monitor ." WHERE primary_1 = '$primary_1'   {SEARCH_STR}  GROUP BY id_agen_monitor ";
        $querys['count_query'] =  " SELECT COUNT(DISTINCT id_agen_monitor) as record_count FROM ".$this->hdr_agen_monitor." WHERE primary_1 = '$primary_1'  {SEARCH_STR}  ";
        $build_querys = $this->CI->flexigrid->build_querys($querys,TRUE);
        $return['records'] = $this->db->query($build_querys['main_query']);
        $get_record_count = $this->db->query($build_querys['count_query']);
        $row = $get_record_count->row();
        $return['record_count'] = $row->record_count;
        return $return ;
    }

    public function get_primary_1($card_no) {
        $this->db->select('primary_1');
        $query = $this->db->get_where('hdr_debtor_main', array('card_no'=>$card_no));
        $data = $query->row();
        return $data->primary_1;
    }
    public function get_primary_name($name_debt) {
        $this->db->select('primary_1');
        $query = $this->db->get_where('hdr_debtor_main', array('name'=>$name_debt));
        $data = $query->row();
        return $data->primary_1;
    }
    public function get_field_name($id_field_name) {
        $query = $this->db->get_where('hdr_debtor_field_name',array('id_file_field'=>$id_field_name));
        return $query->row();
    }

     public function view_export($filter_for) {

     	$file_now = 'Filter_Report-' . date("j-n-Y") . '-' . date("His") . '.txt';
     	//die($file_now);

        if($filter_for =='view_all') {
            $filter = isset($_SESSION['filter_debtor_tmp'])?$_SESSION['filter_debtor_tmp']:'WHERE primary_1!="0"';
            $where_filter =  $filter==''?TRUE:FALSE;
        } else {

            //$filter = $filter_for !=''?$this->get_next_call($filter_for):'WHERE primary_1!="0"';
            //$where_filter =  $filter==''?TRUE:FALSE;
        		//die($filter);

					$where_filter = "";
					$where = array(
						"id_user" => $filter_for
					);
					$q = $this->db->get_where("hdr_user", $where);
					$row = $q->row_array();

					$product = $row['product'];
					$priority = $row['priority'];
					$branch_area = $row['branch_area'];
					$over_days = $row['over_days'];

					$where = " where id_debtor > 0";
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
					else
					{

						$where .= "and (datediff(now(),due_date) >= 0 and month(due_date)=month(now()) and year(due_date)=year(now()))";
					}

					if($priority != "")
					{
						$arrdata_prod = explode(",", $priority);
						for($i=0;$i<count($arrdata_prod);$i++)
						{
							switch($arrdata_prod[$i])
							{
								case "PTP":
								$where .= " and ptp_date is not null and month(ptp_date)=month(now()) and year(ptp_date)=year(now())";
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

					//die($where);
					if($branch_area != '' && $branch_area != 'null')
					{
						$sql = "SELECT 'id_debtor','primary_1','due_date','angsuran_ke','region','dpd','branch',
										'shift','name','balance','amount_due','ptp_date','ptp_amount','last_paid_date','last_paid_amount','home_address1',
										'city','email','company','cell_phone1','home_phone1','office_phone1','dob',
										'date_in','createdate','product',
										'category','is_paid','en_primary1'
									UNION SELECT
									hdm.id_debtor 		AS 'id_debtor',
									hdm.primary_1 		AS 'primary_1',
									hdm.due_date 			AS 'due_date',
									hdm.angsuran_ke 	AS 'angsuran_ke',
									hdm.region				AS 'region',
									hdm.dpd						AS 'dpd',
									hdm.branch				AS 'branch',
									hdm.shift					AS 'shift',
									hdm.name					AS 'name',
									hdm.balance				AS 'balance',
									hdm.amount_due		AS 'amount_due',
									hdm.ptp_date			AS 'ptp_date',
									hdm.ptp_amount		AS 'ptp_amount',
									max(hdp.trx_date) AS 'last_paid_date',
									hdp.amount				AS 'last_paid_amount',
									hdm.home_address1	AS 'home_address1',
									hdm.city					AS 'city',
									hdm.email					AS 'email',
									hdm.company_name	AS 'company',
									hdm.cell_phone1		AS 'cell_phone1',
									hdm.home_phone1		AS 'home_phone1',
									hdm.office_phone1	AS 'office_phone1',
									hdm.dob						AS 'dob',
									hdm.date_in				AS 'date_in',
									hdm.createdate		AS 'createdate',
									hdm.product				AS 'product',
									hdm.category			AS 'category',
									hdm.is_paid				AS 'is_paid',
									hdm.primary_1 AS en_primary1
									from hdr_debtor_main hdm
									LEFT JOIN hdr_payment hdp
										ON hdm.primary_1=hdp.primary_1" .
							" $where GROUP BY hdm.primary_1 INTO OUTFILE '/tmp/$file_now' FIELDS TERMINATED BY '|' LINES TERMINATED BY '\\r\\n'";

						//die($sql);

						//echo $sql;
						//die($sql);
						//$q = $this->db->query($sql);
						//return $q->num_rows();
					}

        }

        //$querys['main_query'] =  " SELECT hdm.*, hdm.primary_1 AS en_primary1 FROM ".$this->hdr_debtor_main." AS hdm ".$filter ."  {SEARCH_STR}  GROUP BY primary_1 ";
        //$querys['count_query'] =  " SELECT COUNT(DISTINCT primary_1) as record_count FROM ".$this->hdr_debtor_main." AS hdm  ".$filter ." {SEARCH_STR}  ";

        $querys['main_query'] = $sql;




        //$build_querys = $this->CI->flexigrid->build_querys($querys,$where_filter);

        //die(var_dump($querys));

        $build_querys['main_query'] = $querys['main_query'];


        $return['records'] = $this->db->query($build_querys['main_query']);

        $this->load->helper('download');
          $file_path = '/tmp/' . $file_now;
          $files_real = file_get_contents($file_path);
          force_download($file_now, $files_real);

        //var_dump($return['records']);



        return $return ;
    }

}
?>