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
        if($filter_for =='view_all') {
            $filter = isset($_SESSION['filter_debtor_tmp'])?$_SESSION['filter_debtor_tmp']:'WHERE primary_1!="0"';
            $where_filter =  $filter==''?TRUE:FALSE;
        } else {
            $filter = $filter_for !=''?$this->get_next_call($filter_for):'WHERE primary_1!="0"';
            $where_filter =  $filter==''?TRUE:FALSE;
        }
        $querys['main_query'] =  " SELECT hdm.*, hdm.primary_1 AS en_primary1 FROM ".$this->hdr_debtor_main." AS hdm ".$filter ."  {SEARCH_STR}  GROUP BY primary_1 ";
        $querys['count_query'] =  " SELECT COUNT(DISTINCT primary_1) as record_count FROM ".$this->hdr_debtor_main." AS hdm  ".$filter ." {SEARCH_STR}  ";
        //echo $querys['main_query'] ;
        $build_querys = $this->CI->flexigrid->build_querys($querys,$where_filter);
        $return['records'] = $this->db->query($build_querys['main_query']);
        $get_record_count = $this->db->query($build_querys['count_query']);
        $row = $get_record_count->row();
        $return['record_count'] = $row->record_count;
        return $return ;
    }
    public function all_debtor_hist_payment_flexi($primary_1) {
        $querys['main_query'] =  " SELECT *, primary_1 AS en_primary1 FROM ".$this->hdr_payment ." WHERE primary_1 = '$primary_1'   {SEARCH_STR}  ";
        $querys['count_query'] =  " SELECT COUNT(DISTINCT primary_1) as record_count FROM ".$this->hdr_payment." WHERE primary_1 = '$primary_1'  {SEARCH_STR}  ";
        $build_querys = $this->CI->flexigrid->build_querys($querys,TRUE);
        $return['records'] = $this->db->query($build_querys['main_query']);
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
        $where_filter =  $id_action_call_track==''?TRUE:FALSE;
        $ptp_status = $id_action_call_track=='ptp'?"AND hdc.id_action_call_track='28'":'';
        $get_name = $id_action =='52'?'hdm.name AS name':'';
        $join_hdm = $id_action =='52'?"INNER JOIN hdr_debtor_main AS hdm ON hdc.primary_1 = hdm.primary_1":'';
        $all_debt = $primary_1=='all'?'':$primary_1;
        $prim =  $all_debt !=''?" hdc.primary_1 = '$all_debt'":'hdc.primary_1 !=""';
        $querys['main_query'] =  " SELECT hdc.*, hdc.primary_1 AS en_primary1, hdc.code_call_track AS hcall_code  FROM ".$this->hdr_calltrack ." AS hdc
													 WHERE $prim $ptp_status {SEARCH_STR}   ";
        //$querys['count_query'] =  " SELECT 100  AS record_count";
        /*SELECT (SELECT COUNT(primary_1)  FROM hdr_calltrack WHERE  primary_1 = '010307135915') +
     (SELECT COUNT(primary_1) FROM hdr_calltrack_old WHERE  primary_1 = '010307135915')   */
        $querys['count_query'] =  "SELECT COUNT(primary_1)    AS record_count  FROM hdr_calltrack WHERE  primary_1 = '$primary_1' {SEARCH_STR} ";
        //echo $querys['main_query'];
        $build_querys = $this->CI->flexigrid->build_querys($querys,$where_filter);
        $return['records'] = $this->db->query($build_querys['main_query']);
        $get_record_count = $this->db->query($build_querys['count_query']);
        $row = $get_record_count->row();
        //$query_out = str_replace('{SEARCH_STR}','',$querys['main_query']);
        //$query_reg = $this->db->query($query_out);
        $return['record_count'] = /*$query_reg->num_rows();*/$row->record_count;
        return $return ;
    }
    public function all_debtor_hist_calltrack_rem_flexi($primary_1,$id_action_call_track,$id_user) {

        $where_filter =  $id_action_call_track==''?TRUE:FALSE;
        $rem_status = $id_action_call_track=='rem'?"AND hdc.id_action_call_track='52'":'';
        //$user = $id_action =='4'?" AND hdc.id_user ='$id_user'":'';	$act $ptp_call
        $id_user = $_SESSION['bid_user_s'];
        $all_debt = $primary_1=='all'?'':$primary_1;
        $prim =  $all_debt !=''?" hdc.primary_1 = '$all_debt'":'hdc.primary_1 !=""';
        $querys['main_query'] =  " SELECT hdc.*, hdc.primary_1 AS en_primary1, hdc.cname AS name FROM ".$this->hdr_calltrack ." AS hdc
													
													 WHERE $prim  $rem_status  AND hdc.id_user = '$id_user' {SEARCH_STR}   ";
        //$querys['count_query'] =  " SELECT 100  AS record_count";
        $querys['count_query'] =  " SELECT COUNT(DISTINCT hdc.id_calltrack) as record_count FROM ".$this->hdr_calltrack."  AS hdc
												 WHERE $prim $rem_status  AND hdc.id_user = '$id_user' {SEARCH_STR}  ";
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

        } elseif($id_action_call_track =='ptp') {
            $status_r = "AND hdc.id_action_call_track ='28' ";

        } elseif($id_action_call_track =='no_ptp') {
            $status_r = "AND hac.id_call_cat ='1' AND hdc.id_action_call_track NOT IN ('52','28')  ";

        } elseif($id_action_call_track =='AC') {
            $status_r = " ";

        } elseif($id_action_call_track =='no_contact') {
            $status_r = "AND hac.id_call_cat = '2' AND hdc.id_action_call_track !='4' ";

        }  elseif($id_action_call_track =='acct_worked') {
            $status_r = "AND hdc.is_current = '1' AND hdc.id_action_call_track !='4' ";

        }
        if($id_action_call_track == "ptp") {
            $select_ptp = ",hdc.ptp_date, hdc.ptp_amount";

        } elseif($id_action_call_track == "acc") {
            $select_ptp = ",hdc.ptp_date, hdc.ptp_amount";

        } elseif($id_action_call_track == "all") {
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
                $bg = " AND hdp.trx_date>='$begindate ' ";
            }else {
                $bg = " ";
            }
            if($enddate!="") {
                $ed = " AND hdp.trx_date<='$enddate' ";
            }else {
                $ed = " ";
            }
        }elseif($id_action_call_track =='broken') {
            $status_r = "hdc.ptp_status = '1'  ";
            if($begindate!= ""  ) {
                $bg = " AND hdc.broken_date>='$begindate ' ";
            }else {
                $bg = " ";
            }
            if($enddate!="") {
                $ed = " AND hdc.broken_date<='$enddate ' ";
            }else {
                $ed = " ";
            }
        }
        $where_filter =  $id_action_call_track==''?TRUE:FALSE;
        $querys['main_query'] =  " SELECT hdc.*, hdc.primary_1 AS en_primary1, hdc.code_call_track AS hcall_code, hdc.cname AS name, hdp.trx_date AS trx_date, hdp.amount AS amount,  hdc.code_call_track AS haccall_track,hdc.ptp_date, hdc.ptp_amount
                                                    FROM ".$this->hdr_calltrack ." AS hdc
                                                    LEFT JOIN hdr_payment AS hdp ON hdc.primary_1 = hdp.primary_1
                                                    WHERE  $user AND  $status_r AND id_action_call_track ='28' AND hdc.call_date>='$begindate' AND hdc.call_date<='$enddate'  $bg $ed GROUP BY hdc.primary_1
                                                    {SEARCH_STR}  ";
        $querys['count_query'] =  " SELECT COUNT(DISTINCT hdc.primary_1) as record_count
                                                        FROM ".$this->hdr_calltrack."  AS hdc
							LEFT JOIN hdr_payment AS hdp ON hdc.primary_1 = hdp.primary_1
                                                        WHERE  $user  AND $status_r AND id_action_call_track ='28' AND hdc.call_date>='$begindate' AND hdc.call_date<='$enddate'   $bg $ed  {SEARCH_STR} ";
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
    public function debtor_details($primary_1) {
        $sql = "SELECT  value as en_value FROM ".$this->hdr_debtor_details." WHERE primary_1 = '$primary_1'";
        $query = $this->db->query($sql);
        if($query->num_rows() < 1) {
            $bad = 'no_debtor';
            return $bad;
        } else {
            return $query->row();
        }
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
    public function get_main_info($primary_1) {
        $query = $this->db->get_where('hdr_debtor_main',array('primary_1'=>$primary_1));
        return $query->row();
    }


}
?>