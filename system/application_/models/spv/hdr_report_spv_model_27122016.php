<?php

  /*
    This script software package is NOT FREE And is Copyright 2010 (C) Valdo-intl all rights reserved.
    we do supply help or support or further modification to this script by Contact
    Haidar Mar'ie
    e-mail = haidar.m@valdo-intl.com
    e-mail = coder5@ymail.com
   */

  class Hdr_report_spv_model extends Model {

      private $hdr_calltrack;
      private $hdr_mytask;

      public function __construct() {
          parent::Model();

          $this->CI = & get_instance();
          $this->hdr_calltrack = 'hdr_calltrack';
          $this->hdr_mytask = 'tb_mytask';
          $this->hdr_debtor_main = 'hdr_debtor_main';

      }

      //Count total DPD 1 to 4
      public function total_all_dpd1_4() {
          $sql = "SELECT COUNT(hdm.primary_1) as totals FROM hdr_debtor_main AS hdm WHERE hdm.primary_1 !='0' AND hdm.call_status ='1' AND hdm.in_use ='0' AND hdm.primary_1 NOT IN(SELECT primary_1 FROM hdr_calltrack )";
          $query = $this->db->query($sql);
          $totals = $query->row();
          return $totals->totals;
      }

      //Count total need to call
      public function total_to_call() {
          $sql = "SELECT COUNT(hdm.primary_1) as totals FROM hdr_debtor_main AS hdm WHERE hdm.primary_1 !='0'
            AND hdm.call_status ='1' AND hdm.in_use ='0' AND hdm.primary_1 NOT IN(SELECT primary_1 FROM hdr_calltrack ) ";
          $query = $this->db->query($sql);

          $totals = 0;
          if($query)
          {
          	$totals = $query->row();
          	$totals->totals;
          }

          return $totals;
      }

      // Count All Status in Report View Except Keep And Broken
      /*
        SELECT
        tu.username,
        '2009-08-09',
        COUNT(DISTINCT id_calltrack) as total_call,
        COUNT(DISTINCT hc.primary_1,hc.call_date) as Acct_work,
        COUNT( CASE WHEN hc.id_call_cat = '1' THEN hc.primary_1  END ) AS 'Contact',
        COUNT( CASE WHEN hc.id_call_cat = '2' THEN hc.primary_1  END ) AS 'No Contact',
        COUNT( CASE WHEN hc.id_action_call_track = '28' THEN hc.primary_1 END ) AS 'PTP',
        COUNT( CASE WHEN hc.ptp_status = '2' THEN hc.primary_1 END ) AS 'KEEP',
        COUNT( CASE WHEN hc.ptp_status = '1' THEN hc.primary_1 END ) AS 'Broken',
        SUM(if(hc.ptp_status = '2',hc.os_ar_amount,'bad')) AS 'Amount Collected'
        FROM hdr_calltrack hc
        INNER JOIN hdr_user tu
        ON tu.id_user = hc.id_user
        WHERE tu.id_level ='3' AND hc.call_date >='2010-08-01' AND hc.call_date <='2010-08-26'
        GROUP BY hc.id_user
        ORDER BY tu.username;
       */


      public function status_call($user, $id_user, $status, $begindate, $enddate) {
          $group_bys = 'hdc.id_calltrack';
          $id_spv = $_SESSION['bid_user_s'];
          $spv = $id_spv != '22' ? "id_spv='" . $id_spv . "'" : 'id_level="3" ';
          //die($id_spv);
          if ($begindate != "") {
              $bg = " AND hdc.call_date>='$begindate' ";
          } else {
              $bg = " ";
          }
          if ($enddate != "") {
              $ed = " AND hdc.call_date<='$enddate' ";
          } else {
              $ed = " ";
          }

          ## get active day ##
					$active_day = $this->get_activeDay($begindate, $enddate);
					$total_days = $active_day->active_days;
		  ## end get active day ##
          $xtarget = 300;
          $xtarget_cnt = 210;
          $xtarget_ptp = 135;
          $xtarget_keep = 80;

// target call dari 0.7 ke 

          $sql = " SELECT
                      hc.username,hc.id_user,hu.shift,hu.id_leader,hu.region_area,hu.branch_area,
                      '$begindate' as 'begindate',
                      '$enddate' as 'enddate',
                      
                      ($xtarget*$total_days) AS target_work,
                      
                      COUNT(DISTINCT hc.id_calltrack) as acct_work,
                      
                      ROUND((COUNT(DISTINCT hc.id_calltrack)/($total_days*$xtarget)*2.5),'2') AS 'arch_work',
                      
                      ROUND((0.7*($total_days*$xtarget_cnt))) AS 'target_contact',
                      
                      COUNT(DISTINCT CASE WHEN (hc.id_call_cat='1')	THEN  hc.id_calltrack  END ) AS 'contact',
                      	
                      ROUND(((COUNT(DISTINCT CASE WHEN (hc.id_call_cat='1') THEN hc.id_calltrack END ))/(($total_days*$xtarget_cnt))*25),'2') AS 'arch_contact',
                      
                      COUNT(DISTINCT CASE WHEN (hc.id_call_cat='2')	THEN hc.id_calltrack  END ) AS 'no_contact',
                      	
                      ROUND((0.8*((0.7*($total_days*$xtarget_ptp))))) AS 'target_ptp',
                      
                      COUNT(DISTINCT CASE WHEN hc.id_handling_code = '02' AND ptp_date IS NOT NULL and ptp_date != '0000-00-00' THEN hc.id_calltrack END ) AS 'ptp',
                      
                      ROUND(((COUNT(DISTINCT CASE WHEN hc.id_handling_code = '02' AND ptp_date IS NOT NULL AND ptp_date != '0000-00-00' THEN hc.id_calltrack END ))/(ROUND((((($total_days*$xtarget_ptp))))))*12.5),'2') AS 'arch_ptp',
                      
                      ROUND((0.8*(ROUND((0.8*((0.7*($total_days*$xtarget_keep)))))))) AS 'target_keep',
                      
                      COUNT(DISTINCT CASE WHEN hc.ptp_status = '2' AND hc.id_handling_code = '02' THEN hc.primary_1 END ) AS 'keep',
                      
                      ROUND((COUNT(DISTINCT CASE WHEN hc.ptp_status = '2' AND hc.id_handling_code = '02' THEN hc.primary_1 END ))/(ROUND((ROUND((((($total_days*$xtarget_keep))))))))*60,'2') AS 'arch_keep',
                      
                      COUNT(DISTINCT CASE WHEN hc.ptp_status = '1' AND hc.id_handling_code = '02' THEN hc.primary_1 END ) AS 'broken',
                      
                      COUNT(DISTINCT CASE WHEN hc.ptp_status = '0' AND hc.id_handling_code = '02' THEN hc.primary_1 END ) AS 'na',
                      
                      jj.sum_ptp_amount AS 'amount_collected',
                      
  										jk.sum_os_ar_amount AS 'os_ar'
  										
                      FROM hdr_calltrack hc
                      LEFT JOIN hdr_user hu ON hu.id_user = hc.id_user
                      LEFT JOIN
                      (SELECT sum(assign_total) AS assign_total, user_id
                       FROM hdr_report_filter
                       WHERE created >='$begindate' AND created <='$enddate'
                      ) hh on hh.user_id=hc.id_user
                      LEFT JOIN (SELECT sum(ptp_amount) AS sum_ptp_amount, id_user FROM hdr_calltrack
             						 WHERE call_date BETWEEN '$begindate' AND '$enddate'
             						 AND ptp_status = '2' AND id_action_call_track ='11'
             						 GROUP BY id_user
              				) jj
  									ON jj.id_user=hc.id_user
  									LEFT JOIN (SELECT sum(os_ar_amount) AS sum_os_ar_amount , id_user FROM hdr_calltrack
             						 WHERE call_date BETWEEN '$begindate' AND '$enddate'
              					 AND ptp_status = '2' AND id_action_call_track ='11'
             						 GROUP BY id_user
             				 ) jk
  									ON jk.id_user=hc.id_user
                      WHERE $spv AND hc.call_date >='$begindate' AND hc.call_date <='$enddate'
                      GROUP BY hc.id_user
                      ORDER BY region_area ASC, keep DESC";
          //die($sql);
          /* $sql_old = " SELECT COUNT( $group_bys) AS total_call
            FROM hdr_calltrack	  AS hdc
            $status_call
            $bg $ed
            $user "; */
          //echo $sql.'</br>';
          //die($sql);
          //echo $status;
          $query = $this->db->query($sql);

          return $query;

      }

      ## Martin-> Get Active Day ##
      function get_activeDay($begin,$end) {
      	$sql = "
      		SELECT COUNT(DISTINCT call_date) as active_days FROM hdr_calltrack
      		WHERE call_date BETWEEN '$begin' AND '$end' AND DATE_FORMAT(call_date,'%a') != 'sat'
      	";
      	$result = $this->db->query($sql);

      	return $result->row();
      }


      #############################
  /*
public function before_call($user, $id_user, $status, $begindate, $enddate) {
          $group_bys = 'hdc.id_calltrack';
          $id_spv = $_SESSION['bid_user_s'];
          $spv = $id_spv != '22' ? "id_spv='" . $id_spv . "'" : 'id_level="3" ';

          if ($begindate != "") {
              $bg = " AND hdc.call_date>='$begindate' ";
          } else {
              $bg = " ";
          }
          if ($enddate != "") {
              $ed = " AND hdc.call_date<='$enddate' ";
          } else {
              $ed = " ";
          }

				 //keep
$sql = " update hdr_calltrack hdc, hdr_payment hdp,
(
  select max(id_payment) as idx
  from hdr_payment
  where date(trx_date) between '$begindate' and '$enddate'
  group by primary_1
) b
set hdc.ptp_status=2
where hdp.id_payment=b.idx
and hdc.primary_1=hdp.primary_1
and hdc.id_contact_code = '02'
AND hdc.ptp_date >= hdp.trx_date
and hdp.trx_date >= hdc.call_date
AND hdc.call_date >= '$begindate'
AND hdc.call_date <= '$enddate' ";

$query = $this->db->query($sql);
//echo "a";



//broken
$sql = "update hdr_calltrack hdc, hdr_payment hdp,
(
  select max(id_payment) as idx
  from hdr_payment
  where date(trx_date) between '$begindate' and '$enddate'
  group by primary_1
) b
set hdc.ptp_status=1
where hdp.id_payment=b.idx
and hdc.primary_1=hdp.primary_1
and hdc.id_contact_code = '02'
AND hdc.ptp_date < hdp.trx_date
and hdp.trx_date >= hdc.call_date
AND hdc.call_date >= '$begindate'
AND hdc.call_date <= '$enddate'
 ";
$query = $this->db->query($sql);
//die();


return $query;


      }
      */

      ### Patch by Martin ###
		public function before_call($user, $id_user, $status, $begindate, $enddate)
		{
			//set default to broken
			$sql = "UPDATE hdr_calltrack SET ptp_status = '1' WHERE call_date BETWEEN '$begindate' AND '$enddate' AND id_handling_code = '02'";
			$this->db->simple_query($sql);

			//update KEEP when there is a payment in ptp and calldate range
			$sql = "UPDATE hdr_calltrack a, hdr_payment b SET a.ptp_status = '2' WHERE a.call_date BETWEEN '$begindate' AND '$enddate' AND a.primary_1 = b.primary_1 AND b.trx_date = (SELECT c.trx_date FROM hdr_payment c WHERE c.primary_1 = a.primary_1 AND c.trx_date BETWEEN a.call_date AND a.ptp_date LIMIT 1) AND a.id_handling_code = '02' AND a.ptp_status = '1'";
			$this->db->simple_query($sql);

				//update NA when ptpdate not expire yet
			$sql = "UPDATE hdr_calltrack SET ptp_status = '0' WHERE call_date BETWEEN '$begindate' AND '$enddate' AND ptp_date >= DATE(NOW()) AND id_handling_code = '02' AND ptp_status = '1'";
			$this->db->simple_query($sql);

		}

      public function status_call2($user, $id_user, $status, $begindate, $enddate) {
          $group_bys = 'hdc.id_calltrack';
         // $id_spv = $_SESSION['bid_user_s'];
          //$spv = $id_spv != '22' ? "id_spv='" . $id_spv . "'" : 'id_level="3" ';
          if ($begindate != "") {
              $bg = " AND hdc.call_date>='$begindate' ";
          } else {
              $bg = " ";
          }
          if ($enddate != "") {
              $ed = " AND hdc.call_date<='$enddate' ";
          } else {
              $ed = " ";
          }


          $sql = " SELECT
                      hc.username,hc.id_user,hu.shift,hu.id_leader,hu.region_area,hu.branch_area,hu.product,
                      '$begindate' as 'begindate',
                      '$enddate' as 'enddate',
                      hh.assign_total AS target_work,
                      COUNT(DISTINCT hc.id_calltrack) as acct_work,
                      COUNT(DISTINCT CASE WHEN (hc.code_call_track='OCAA' OR hc.code_call_track ='OCAB' or hc.code_call_track='OCBA' OR hc.code_call_track='OCBB' OR hc.code_call_track='OCBE')
                      	THEN  hc.id_calltrack  END ) AS 'contact',
                      COUNT(DISTINCT CASE WHEN (hc.code_call_track!='OCAA' AND hc.code_call_track !='OCAB' AND hc.code_call_track!='OCBA' AND hc.code_call_track!='OCBB' AND hc.code_call_track!='OCBE')
                      	THEN hc.id_calltrack  END ) AS 'no_contact',
                      COUNT(DISTINCT CASE WHEN hc.id_action_call_track = '11' AND ptp_date IS NOT NULL and ptp_date != '0000-00-00' THEN hc.id_calltrack END ) AS 'ptp',
                      COUNT(DISTINCT CASE WHEN hc.ptp_status = '2' AND hc.id_action_call_track ='11' THEN hc.primary_1 END ) AS 'keep',
                      COUNT(DISTINCT CASE WHEN hc.ptp_status = '1' AND hc.id_action_call_track ='11' THEN hc.primary_1 END ) AS 'broken',
                      COUNT(DISTINCT CASE WHEN hc.ptp_status = '0' AND hc.id_action_call_track ='11' THEN hc.primary_1 END ) AS 'na',
                      jj.sum_ptp_amount AS 'amount_collected',
  										jk.sum_os_ar_amount AS 'os_ar'
                      FROM hdr_calltrack hc
                      LEFT JOIN hdr_user hu ON hu.id_user = hc.id_user
                      LEFT JOIN
                      (SELECT sum(assign_total) as assign_total, user_id
                       FROM hdr_report_filter
                       WHERE created >='$begindate' AND created <='$enddate'
                       GROUP BY user_id
                      ) hh on hh.user_id=hc.id_user
                      LEFT JOIN (SELECT sum(ptp_amount) AS sum_ptp_amount, id_user FROM hdr_calltrack
             						 WHERE call_date BETWEEN '$begindate' AND '$enddate'
             						 AND ptp_status = '2' AND id_action_call_track ='11'
             						 GROUP BY id_user
              				) jj
  									ON jj.id_user=hc.id_user
  									LEFT JOIN (SELECT sum(os_ar_amount) AS sum_os_ar_amount , id_user FROM hdr_calltrack
             						 WHERE call_date BETWEEN '$begindate' AND '$enddate'
              					 AND ptp_status = '2' AND id_action_call_track ='11'
             						 GROUP BY id_user
             				 ) jk
  									ON jk.id_user=hc.id_user
                      WHERE hc.call_date >='$begindate' AND hc.call_date <='$enddate'
                      GROUP BY hc.id_user
                      ORDER BY region_area ASC, keep DESC ";

          //die($sql);
          /* $sql_old = " SELECT COUNT( $group_bys) AS total_call
            FROM hdr_calltrack	  AS hdc
            $status_call
            $bg $ed
            $user "; */
          //echo $sql.'</br>';
          //die($sql);
          //echo $status;
          $query = $this->db->query($sql);

          return $query;

      }

      // Count for Keep and Broken Status in Report View

      public function status_call_ptp($user, $id_user, $status, $begindate, $enddate) {
          $group_bys = 'DISTINCT hdc.primary_1';

          if ($user == 'tc') {
              $user = "AND hdc.id_user   = '$id_user'";
          }
          $cond = $status == "keep" ? "  AND  hdc.ptp_status ='2'  AND MONTH(hdp.trx_date) >= MONTH(hdc.call_date)  " : " AND hdc.ptp_status ='1'";

          if ($begindate != "") {
              $bg = " AND hdc.call_date>='$begindate '  ";
          } else {
              $bg = " ";
          }
          if ($enddate != "") {
              $ed = " AND hdc.call_date<='$enddate' ";
          } else {
              $ed = " ";
          }
          $sql = " SELECT COUNT( $group_bys) AS total_call
					FROM hdr_calltrack	  AS hdc INNER  JOIN hdr_payment AS hdp
			ON hdc.primary_1 = hdp.primary_1
					WHERE hdc.id_action_call_track ='11'
                $bg $ed $cond
                $user ";

          if ($status == 'keep') {
              //echo $sql.'</br>';
          }
          if ($status == 'broken') {
              //echo $sql.'</br>';
          }
          //die($sql);
          //echo $status;
          $query = $this->db->query($sql);
          $data = $query->row();
          return $count = $data->total_call;
      }

      //For Amount Collected In Report View
      public function amount_collected($user, $id_user, $begindate, $enddate) {
          $group_bys = '';
          $query_ptp = "";

          if ($begindate != "") {
              $bg = " AND hdc.call_date>='$begindate' ";
          } else {
              $bg = " ";
          }
          if ($enddate != "") {
              $ed = " AND hdc.call_date<='$enddate' ";
          } else {
              $ed = " ";
          }
          if ($user == 'tc') {
              $user = "AND hdc.id_user   = '$id_user'";
          }

          $sql = " SELECT SUM(DISTINCT hdp.amount) AS total_amount
		      FROM hdr_payment hdp  INNER  JOIN  hdr_calltrack hdc
		      ON hdc.primary_1 = hdp.primary_1 WHERE hdc.id_action_call_track ='11' AND  hdc.ptp_status ='2'
                      AND MONTH(hdp.trx_date) >= MONTH(hdc.call_date)
                $bg $ed
                $user ";

          //echo $sql.'</br>';
          //die($sql);
          //echo $status;
          $query = $this->db->query($sql);
          $data = $query->row();
          return $count = $data->total_amount;
      }

      //Flexigrid View ALL Status except KP and BP

      public function list_report_flexi_status($id_user, $status, $begindate,$enddate, $report) {
      //die("duar");
      $group_bys = 'hdc.id_calltrack';
      $where_filter = $id_user == '' ? TRUE : FALSE;
      $sq = "SELECT id_leader
      FROM hdr_user WHERE id_user ='$id_user'"; $result = mysql_query($sq);
      $fetch = mysql_fetch_array($result); $val = $fetch['id_leader'];

          if ($begindate != "" && $status != 'AC') {
              $bg = " AND hdc.call_date>='$begindate ' ";
          } else {
              $bg = " ";
          }
          if ($enddate != "" && $status != 'AC') {
              $ed = " AND hdc.call_date<='$enddate' AND id_spv='$val'";
          } else {
              $ed = " ";
          }
         $user_s = $id_user != 'all' ? "AND hdc.id_user   = '$id_user'" : '';
          if ($id_user == 'all') {
              $user_s = "";
          }
          if ($status == "ptp") {

              $status_r = " hdc.id_handling_code ='02' AND hdc.ptp_date IS NOT NULL AND hdc.ptp_date != '0000-00-00' ";
          } elseif ($status == "acc") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = " hdc.call_date !=''";
          } elseif ($status == '1') {
              $status_r = "  (hdc.id_call_cat='1')";
          } elseif ($status == '2') {
              $status_r = "  (hdc.id_call_cat='2')";
          } elseif ($status == 'all') {
              $status_r = " hdc.primary_1 !='' ";
          }
          $querys['main_query'] = " SELECT hdc.*,CASE hdc.ptp_status    WHEN '0' THEN 'N/A' WHEN '1' THEN 'Broken' WHEN '2' THEN 'KEEP' END as 'ptp_stat',
                MAX(hdp.trx_date) as max_date, MAX(hdp.amount_pay) as max_amount, hdm.dpd as mdpd, hdc.ptp_date as cptp_date, hdc.primary_1 as en_primary_1, hdc.code_call_track as hdctrack
		FROM hdr_calltrack  AS hdc
                LEFT JOIN hdr_payment hdp ON hdc.primary_1 = hdp.primary_1
                LEFT JOIN hdr_debtor_main hdm  ON hdc.primary_1 = hdm.primary_1
		WHERE $status_r
                $bg $ed
                $user_s {SEARCH_STR} GROUP by $group_bys ";

          $querys['count_query'] = "SELECT COUNT(DISTINCT $group_bys) AS record_count
		FROM hdr_calltrack  AS hdc
		WHERE $status_r
                $bg $ed
                $user_s {SEARCH_STR}";
         //echo $querys['count_query'];
//die($querys['main_query']);

          $build_querys = $this->CI->flexigrid->build_querys($querys, $where_filter);
          $return['records'] = $this->db->query($build_querys['main_query']);
          $str = $this->db->last_query();
          //die($str);
          $get_record_count = $this->db->query($build_querys['count_query']);

          //$get_spv_id = $this->db->query();
          $row = $get_record_count->row();
          $return['record_count'] = $row->record_count;
          return $return;
      }

      public function list_report_flexi_status_adm($id_user, $status, $begindate,
      $enddate, $report) {          $group_bys = 'hdc.id_calltrack';
      $where_filter = $id_user == '' ? TRUE : FALSE;
      $sq = "SELECT id_leader
      FROM hdr_user WHERE id_user ='$id_user'"; $result = mysql_query($sq);
      $fetch = mysql_fetch_array($result); $val = $fetch['id_leader'];
         //die('aaa');
          if ($begindate != "" && $status != 'AC') {
              $bg = " AND hdc.call_date>='$begindate ' ";
          } else {
              $bg = " ";
          }
          if ($enddate != "" && $status != 'AC') {
              $ed = " AND hdc.call_date<='$enddate'";
          } else {
              $ed = " ";
          }
         $user_s = $id_user != 'all' ? "" : '';
          if ($id_user == 'all') {
              $user_s = "";
          }
          if ($status == "ptp") {

              $status_r = " hdc.id_handling_code ='02' AND hdc.ptp_date IS NOT NULL AND hdc.ptp_date != '0000-00-00'";
          } elseif ($status == "acc") {
              $group_bys = 'hdc.primary_1,hdc.call_date';
              $status_r = " hdc.primary_1 !=''";
          } elseif ($status == '1') {
              $status_r = " (hdc.id_call_cat='1')";
          } elseif ($status == '2') {
              $status_r = " (hdc.id_call_cat='2')";
          } elseif ($status == 'all') {
              $status_r = " hdc.primary_1 !='' ";
          }
          $querys['main_query'] = " SELECT hdc.*,CASE hdc.ptp_status    WHEN '0' THEN 'N/A' WHEN '1' THEN 'Broken' WHEN '2' THEN 'KEEP' END as 'ptp_stat',
                MAX(hdp.trx_date) as max_date, MAX(hdp.amount) as max_amount, hdm.dpd as mdpd, hdc.ptp_date as cptp_date,hdc.no_contacted as no_contacted, hdc.primary_1 as en_primary_1, hdc.code_call_track as hdctrack
		FROM hdr_calltrack  AS hdc
                LEFT JOIN hdr_payment hdp ON hdc.primary_1 = hdp.primary_1
                LEFT JOIN hdr_debtor_main hdm  ON hdc.primary_1 = hdm.primary_1

		WHERE $status_r
                $bg $ed
                $user_s {SEARCH_STR} GROUP by $group_bys ";

          $querys['count_query'] = "SELECT COUNT(DISTINCT $group_bys) AS record_count
		FROM hdr_calltrack  AS hdc
		WHERE $status_r
                $bg $ed
                $user_s {SEARCH_STR}";
         //echo $querys['count_query'];

//die($querys['main_query']);
          $build_querys = $this->CI->flexigrid->build_querys($querys, $where_filter);
          $return['records'] = $this->db->query($build_querys['main_query']);
          $get_record_count = $this->db->query($build_querys['count_query']);
          //die("aaaa");

          //$get_spv_id = $this->db->query();
          $row = $get_record_count->row();
          $return['record_count'] = $row->record_count;
          return $return;
      }

      public function list_report_flexi_status_spv($id_user, $status, $begindate,
      $enddate, $report) {          $group_bys = 'hdc.id_calltrack';
      $where_filter = $id_user == '' ? TRUE : FALSE;
      $sq = "SELECT id_leader
      FROM hdr_user WHERE id_user ='$id_user'"; $result = mysql_query($sq);
      $fetch = mysql_fetch_array($result); $val = $fetch['id_leader'];
       $id_spv = $_SESSION['bid_user_s'];
         //die($sq);
          if ($begindate != "" && $status != 'AC') {
              $bg = " AND hdc.call_date>='$begindate ' ";
          } else {
              $bg = " ";
          }
          if ($enddate != "" && $status != 'AC') {
              $ed = " AND hdc.call_date<='$enddate' AND id_spv='$id_spv'";
          } else {
              $ed = " ";
          }
         $user_s = $id_user != 'all' ? "" : '';
          if ($id_user == 'all') {
              $user_s = "";
          }
          if ($status == "ptp") {
              $status_r = " hdc.id_handling_code ='02' AND hdc.ptp_date IS NOT NULL AND hdc.ptp_date != '0000-00-00'";
          } elseif ($status == "acc") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = " hdc.primary_1 !=''";
          } elseif ($status == '1') {
              $status_r = " (hdc.id_call_cat='1')";
          } elseif ($status == '2') {
              $status_r = " (hdc.id_call_cat='2')";
          } elseif ($status == 'all') {
              $status_r = " hdc.primary_1 !='' ";
          }
          $querys['main_query'] = " SELECT hdc.*,CASE hdc.ptp_status    WHEN '0' THEN 'N/A' WHEN '1' THEN 'Broken' WHEN '2' THEN 'KEEP' END as 'ptp_stat',
                MAX(hdp.trx_date) as max_date, MAX(hdp.amount_pay) as max_amount, hdm.dpd as mdpd, hdc.ptp_date as cptp_date,hdc.no_contacted as no_contacted, hdc.primary_1 as en_primary_1, hdc.code_call_track as hdctrack
		FROM hdr_calltrack  AS hdc
                LEFT JOIN hdr_payment hdp ON hdc.primary_1 = hdp.primary_1
                LEFT JOIN hdr_debtor_main hdm  ON hdc.primary_1 = hdm.primary_1

		WHERE $status_r
                $bg $ed
                $user_s {SEARCH_STR} GROUP by $group_bys ";

          $querys['count_query'] = "SELECT COUNT(DISTINCT $group_bys) AS record_count
		FROM hdr_calltrack  AS hdc
		WHERE $status_r
                $bg $ed
                $user_s {SEARCH_STR}";
         //echo $querys['count_query'];

//die($querys['main_query']);
          $build_querys = $this->CI->flexigrid->build_querys($querys, $where_filter);
          $return['records'] = $this->db->query($build_querys['main_query']);
          $str = $this->db->last_query();
          //die($str);
          $get_record_count = $this->db->query($build_querys['count_query']);
          //die("aaaa");

          //$get_spv_id = $this->db->query();
          $row = $get_record_count->row();
          $return['record_count'] = $row->record_count;
          return $return;
      }

      //Flexigrid View  KP and BP Status

      public function list_ptp_flexi_status($id_user, $status, $begindate, $enddate, $report) {
          $group_bys = 'hdc.primary_1';
          $status_r = "";
          $where_filter = $id_user == '' ? TRUE : FALSE;
          $sq = "SELECT id_leader
      FROM hdr_user WHERE id_user ='$id_user'"; $result = mysql_query($sq);
      $fetch = mysql_fetch_array($result); $val = $fetch['id_leader'];
          $query_ptp = '';
          if ($begindate != "") {
              $bg = "AND hdc.call_date >='$begindate'";
          } else {
              $bg = " ";
          }
          if ($enddate != "") {
              $ed = " AND hdc.call_date<='$enddate' AND hdc.ptp_date IS NOT NULL AND id_spv='$val'";
          } else {
              $ed = " ";
          }
          $user_s = $id_user != 'all' ? "AND hdc.id_user   = '$id_user'" : '';

          if ($status == "keep") {
              $query_ptp = " hdc.id_handling_code ='02' AND hdc.ptp_status='2'";
          } elseif ($status == "broken") {
              $query_ptp = " hdc.id_handling_code ='02'  AND hdc.ptp_status='1'";
          } elseif ($status == "na") {
              $query_ptp = " hdc.id_handling_code ='02'  AND hdc.ptp_status='0'";
          }
          //echo $status;
          $querys['main_query'] = " SELECT  hdp.*,CASE hdc.ptp_status    WHEN '0' THEN 'N/A' WHEN '1' THEN 'Broken' WHEN '2' THEN 'KEEP' END as 'ptp_stat', MAX(hdp.trx_date) as max_date , hdm.dpd as mdpd, MAX(hdp.amount_pay) as max_amount, hdc.id_calltrack AS total, hdc.*,  hdc.ptp_date as cptp_date,hdc.no_contacted as no_contacted, hdc.primary_1 as en_primary_1,hda.description as cdescrip,hda.code_call_track as hdctrack
		FROM hdr_calltrack AS hdc
                LEFT  JOIN hdr_payment AS hdp ON hdc.primary_1 = hdp.primary_1
                INNER JOIN  hdr_action_call_track AS hda ON hdc.id_action_call_track = hda.id_action_call_track
                LEFT JOIN hdr_debtor_main as hdm ON hdc.primary_1= hdm.primary_1
		WHERE " . $query_ptp . "
                $bg $ed
                $user_s {SEARCH_STR} GROUP by $group_bys ";
          //echo $querys['main_query'];
          $querys['count_query'] = " SELECT COUNT(DISTINCT $group_bys) AS record_count
		FROM hdr_calltrack AS hdc
		WHERE  " . $query_ptp . "
                $bg $ed
                $user_s {SEARCH_STR}";
          $build_querys = $this->CI->flexigrid->build_querys($querys, $where_filter);
          //echo $querys['count_query'];
          //die("aaaa".$build_querys['main_query']);
          $return['records'] = $this->db->query($build_querys['main_query']);
          $get_record_count = $this->db->query($build_querys['count_query']);
          $row = $get_record_count->row();
          $return['record_count'] = $row->record_count;
          return $return;
     }

      public function list_ptp_flexi_status_adm($id_user, $status, $begindate, $enddate, $report) {
          $group_bys = 'hdc.primary_1';
          $status_r = "";
          $where_filter = $id_user == '' ? TRUE : FALSE;
          $sq = "SELECT id_leader
      FROM hdr_user WHERE id_user ='$id_user'"; $result = mysql_query($sq);
      $fetch = mysql_fetch_array($result); $val = $fetch['id_leader'];
          $query_ptp = '';
          if ($begindate != "") {
              $bg = "AND hdc.call_date >='$begindate'";
          } else {
              $bg = " ";
          }
          if ($enddate != "") {
              $ed = " AND hdc.call_date<='$enddate' AND hdc.ptp_date IS NOT NULL";
          } else {
              $ed = " ";
          }
          $user_s = $id_user != 'all' ? "" : '';

          if ($status == "keep") {
              $query_ptp = " hdc.id_action_call_track ='11' AND hdc.ptp_status='2'";
          } elseif ($status == "broken") {
              $query_ptp = " hdc.id_action_call_track ='11'  AND hdc.ptp_status='1'";
          } elseif ($status == "na") {
              $query_ptp = " hdc.id_action_call_track ='11'  AND hdc.ptp_status='0'";
          }
          //echo $status;
          $querys['main_query'] = " SELECT  hdp.*,CASE hdc.ptp_status    WHEN '0' THEN 'N/A' WHEN '1' THEN 'Broken' WHEN '2' THEN 'KEEP' END as 'ptp_stat', MAX(hdp.trx_date) as max_date , hdm.dpd as mdpd, MAX(hdp.amount_pay) as max_amount, hdc.id_calltrack AS total, hdc.*,  hdc.ptp_date as cptp_date,hdc.no_contacted as no_contacted, hdc.primary_1 as en_primary_1,hda.description as cdescrip,hda.code_call_track as hdctrack
		FROM hdr_calltrack AS hdc
                LEFT  JOIN hdr_payment AS hdp ON hdc.primary_1 = hdp.primary_1
                INNER JOIN  hdr_action_call_track AS hda ON hdc.id_action_call_track = hda.id_action_call_track
                LEFT JOIN hdr_debtor_main as hdm ON hdc.primary_1= hdm.primary_1
		WHERE " . $query_ptp . "
                $bg $ed
                $user_s {SEARCH_STR} GROUP by $group_bys ";
          //echo $querys['main_query'];
          $querys['count_query'] = " SELECT COUNT(DISTINCT $group_bys) AS record_count
		FROM hdr_calltrack AS hdc
		WHERE  " . $query_ptp . "
                $bg $ed
                $user_s {SEARCH_STR}";
          $build_querys = $this->CI->flexigrid->build_querys($querys, $where_filter);
          //echo $querys['count_query'];
          //die("aaaa".$build_querys['main_query']);
          $return['records'] = $this->db->query($build_querys['main_query']);
          $get_record_count = $this->db->query($build_querys['count_query']);
          $row = $get_record_count->row();
          $return['record_count'] = $row->record_count;
          return $return;
      }

      public function list_ptp_flexi_status_spv($id_user, $status, $begindate, $enddate, $report) {
          $group_bys = 'hdc.primary_1';
          $status_r = "";
          $where_filter = $id_user == '' ? TRUE : FALSE;
          $sq = "SELECT id_leader
      FROM hdr_user WHERE id_user ='$id_user'"; $result = mysql_query($sq);
      $fetch = mysql_fetch_array($result); $val = $fetch['id_leader'];
      $id_spv = $_SESSION['bid_user_s'];
          $query_ptp = '';
          if ($begindate != "") {
              $bg = "AND hdc.call_date >='$begindate'";
          } else {
              $bg = " ";
          }
          if ($enddate != "") {
              $ed = " AND hdc.call_date<='$enddate' AND hdc.ptp_date IS NOT NULL AND id_spv='$id_spv' ";
          } else {
              $ed = " ";
          }
          $user_s = $id_user != 'all' ? "" : '';

          if ($status == "keep") {
              $query_ptp = " hdc.id_handling_code ='02' AND hdc.ptp_status='2'";
          } elseif ($status == "broken") {
              $query_ptp = " hdc.id_handling_code ='02'  AND hdc.ptp_status='1'";
          } elseif ($status == "na") {
              $query_ptp = " hdc.id_handling_code ='02'  AND hdc.ptp_status='0'";
          }
          //echo $status;
          $querys['main_query'] = " SELECT  hdp.*,CASE hdc.ptp_status    WHEN '0' THEN 'N/A' WHEN '1' THEN 'Broken' WHEN '2' THEN 'KEEP' END as 'ptp_stat', MAX(hdp.trx_date) as max_date , hdm.dpd as mdpd, MAX(hdp.amount_pay) as max_amount, hdc.id_calltrack AS total, hdc.*,  hdc.ptp_date as cptp_date,hdc.no_contacted as no_contacted, hdc.primary_1 as en_primary_1,hda.description as cdescrip,hda.code_call_track as hdctrack
		FROM hdr_calltrack AS hdc
                LEFT  JOIN hdr_payment AS hdp ON hdc.primary_1 = hdp.primary_1
                INNER JOIN  hdr_action_call_track AS hda ON hdc.id_action_call_track = hda.id_action_call_track
                LEFT JOIN hdr_debtor_main as hdm ON hdc.primary_1= hdm.primary_1
		WHERE " . $query_ptp . "
                $bg $ed
                $user_s {SEARCH_STR} GROUP by $group_bys ";
         // die($querys['main_query']);
          $querys['count_query'] = " SELECT COUNT(DISTINCT $group_bys) AS record_count
		FROM hdr_calltrack AS hdc
		WHERE  " . $query_ptp . "
                $bg $ed
                $user_s {SEARCH_STR}";
          $build_querys = $this->CI->flexigrid->build_querys($querys, $where_filter);
          //echo $querys['count_query'];
          //die("aaaa".$build_querys['main_query']);
          $return['records'] = $this->db->query($build_querys['main_query']);
          $get_record_count = $this->db->query($build_querys['count_query']);
          $row = $get_record_count->row();
          $return['record_count'] = $row->record_count;
          return $return;
      }


/*
      //Report All Status to TXT with pipe delimeted
      public function report_status_to_csv($id_user, $status, $begindate, $enddate, $report) {
          //$this->load->helper('csv');
          $group_bys = 'hdc.primary_1';
          if ($begindate != "" && $status != 'AC' && $status != 'untc') {
              $bg = " AND hdc.call_date>='$begindate '";
          } else {
              $bg = " ";
          }
          if ($enddate != "" && $status != 'AC' && $status != 'untc') {
              $ed = " AND hdc.call_date<='$enddate' ";
          } else {
              $ed = " ";
          }
          $user_s = $_SESSION['bid_user_s'] != '1' ? "WHERE hdc.id_spv   = '" . $_SESSION['bid_user_s'] . "'  " : 'WHERE hdc.primary_1 !="" ';

          $user_id = $id_user != 'all' ? ' AND hdc.id_user ="' . $id_user . '"' : '';
          if ($status == "ptp") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND hdc.id_action_call_track ='11' AND hdc.ptp_date IS NOT NULL and hdc.ptp_date != '0000-00-00'";
              //$bg = " AND hdc.ptp_date>='$begindate ' ";
              //$ed = " AND hdc.ptp_date<='$enddate' ";
          } elseif ($status == "all") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND hdc.id_action_call_track !='0' ";
          } elseif ($status == "acc") {
              $group_bys = 'hdc.primary_1,hdc.call_date';
              $status_r = "   ";
          } elseif ($status == "1") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND (hdc.code_call_track='OCAA' OR hdc.code_call_track ='OCAB' or hdc.code_call_track='OCBA' OR hdc.code_call_track='OCBB' OR hdc.code_call_track='OCBE')";
          } elseif ($status == "2") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND (hdc.code_call_track!='OCAA' AND hdc.code_call_track !='OCAB' AND hdc.code_call_track!='OCBA' AND hdc.code_call_track!='OCBB' AND hdc.code_call_track!='OCBE')";
          } elseif ($status == 'AC') {
              $status_r = " ";
              $group_bys = 'hdp.primary_1';
          } elseif ($status == 'untc') {
              $status_r = " ";
              $group_bys = 'hdp.primary_1';
          } elseif ($status == 'keep') {
              $group_bys = 'hdc.primary_1';
              $status_r = "AND hdc.id_action_call_track ='11' AND  hdc.ptp_status ='2'
                 AND MONTH(hdp.trx_date) >= MONTH(hdc.call_date) ";
          } elseif ($status == 'broken') {
              $group_bys = 'hdc.primary_1';
              $status_r = "AND hdc.id_action_call_track ='11' AND  hdc.ptp_status ='1'   ";
          }elseif ($status == 'na') {
              $group_bys = 'hdc.primary_1';
              $status_r = "AND hdc.id_action_call_track ='11' AND  hdc.ptp_status ='0'   ";
          }
          //echo $status;
          $ptp_status1 = $status == 'ptp' ? "'PTP Status'," : "";
          $ptp_status2 = $status == 'ptp' ? "CASE ptp_status WHEN '1' THEN 'BROKEN' WHEN '2' THEN 'KEEP' END  as ptp_status," : "";

          $file_now = 'calltrack_' . $_SESSION['bsname_s'] . '_' . date('Ymd-H_i_s') . '.txt';
          $sql = "SELECT  'order_no','nama_cust','USER','Product','Risk Code','Bertemu','Lokasi','Action Code','no_contacted','PTP Status', 'Description', 'Action Date', 'Action Time', 'Reason Code','New_Phone_no','PTP amount','Amount Collected', 'PTP Date','Last Paid Date','Kode Cabang','due_date','DPD','OS AR AMOUNT','Surveyor','Cabang'
        UNION
        SELECT
              hdc.primary_1       AS 'order_no',
              hdc.cname           AS 'nama_cust',
              hdc.username        AS 'USER',
              hu.product          AS 'Product',
              hdc.risk_code       AS 'Risk Code',
              hdc.contact_code    AS 'Bertemu',
              hdc.location_code   AS 'Lokasi',
              hdc.code_call_track AS 'Action Code',
              hdc.no_contacted    AS  'no_contacted',
              CASE ptp_status WHEN '1' THEN 'BROKEN' WHEN '2' THEN 'KEEP' ELSE 'NA' END  as ptp_status,
              hda.description     AS 'Description',
              hdc.call_date       AS 'Action Date',
              hdc.call_time       AS 'Action Time',
              hdc.remarks         AS 'Reason Code',
              hdc.no_contacted    AS 'New_Phone_no',
              hdc.ptp_amount      AS 'PTP amount',
              hdp.amount_pay          AS 'Amount Collected',
              hdc.ptp_date        AS 'PTP Date',
              MAX(hdp.trx_date)    AS 'Last Paid Date',
              hdc.kode_cabang     AS 'Kode Cabang',
              hdm.due_date				AS 'due_date',
              hdc.dpd     AS 'DPD',
              hdc.os_ar_amount     AS 'OS AR AMOUNT',
              hdc.surveyor     AS 'Surveyor',
              hdc.kode_cabang AS 'Cabang'
            FROM hdr_calltrack AS hdc
              INNER JOIN hdr_action_call_track hda ON hdc.id_action_call_track = hda.id_action_call_track
              LEFT  JOIN hdr_payment AS hdp
                ON hdp.primary_1 = hdc.primary_1
              LEFT JOIN hdr_user AS hu ON hdc.id_user = hu.id_user
              LEFT JOIN hdr_debtor_main hdm ON hdc.primary_1=hdm.primary_1
             $user_s  $user_id  $status_r $bg $ed   GROUP by $group_bys
            INTO OUTFILE '/tmp/$file_now' FIELDS TERMINATED BY '|' LINES TERMINATED BY '\\r\\n';";
          //die($sql);
          //echo $sql;
          $query = $this->db->query($sql);

          ## debug query report_status_to_csv ##
          //$a = $this->db->last_query();
          //die($a);

          //echo  query_to_csv($query);
          $this->load->helper('download');
          $file_path = '/tmp/' . $file_now;
          $files_real = file_get_contents($file_path);
          force_download($file_now, $files_real);
          //return $query;
      }
*/

      public function report_status_to_csv($id_user, $status, $begindate, $enddate, $report) {
          //$this->load->helper('csv');
          $group_bys = 'hdc.primary_1';
          if ($begindate != "" && $status != 'AC' && $status != 'untc') {
              $bg = " AND hdc.call_date>='$begindate '";
          } else {
              $bg = " ";
          }
          if ($enddate != "" && $status != 'AC' && $status != 'untc') {
              $ed = " AND hdc.call_date<='$enddate' ";
          } else {
              $ed = " ";
          }
          $user_s = $_SESSION['bid_user_s'] != '1' ? "WHERE hdc.id_spv   = '" . $_SESSION['bid_user_s'] . "'  " : 'WHERE hdc.primary_1 !="" ';

          $user_id = $id_user != 'all' ? ' AND hdc.id_user ="' . $id_user . '"' : '';
          if ($status == "ptp") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND hdc.id_handling_code ='02' AND hdc.ptp_date IS NOT NULL and hdc.ptp_date != '0000-00-00'";
              //$bg = " AND hdc.ptp_date>='$begindate ' ";
              //$ed = " AND hdc.ptp_date<='$enddate' ";
          } elseif ($status == "all") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND hdc.id_action_call_track !='0' ";
          } elseif ($status == "acc") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "   ";
          } elseif ($status == "1") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND (hdc.id_call_cat='1')";
          } elseif ($status == "2") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND (hdc.id_call_cat='2')";
          } elseif ($status == 'AC') {
              $status_r = " ";
              $group_bys = 'hdp.primary_1';
          } elseif ($status == 'untc') {
              $status_r = " ";
              $group_bys = 'hdp.primary_1';
          } elseif ($status == 'keep') {
              $group_bys = 'hdc.primary_1';
              $status_r = "AND hdc.id_handling_code ='02' AND  hdc.ptp_status ='2'
                 AND MONTH(hdp.trx_date) >= MONTH(hdc.call_date) ";
          } elseif ($status == 'broken') {
              $group_bys = 'hdc.primary_1';
              $status_r = "AND hdc.id_handling_code ='02' AND  hdc.ptp_status ='1'   ";
          }elseif ($status == 'na') {
              $group_bys = 'hdc.primary_1';
              $status_r = "AND hdc.id_handling_code ='02' AND  hdc.ptp_status ='0'   ";
          }
          //echo $status;
          $ptp_status1 = $status == 'ptp' ? "'PTP Status'," : "";
          $ptp_status2 = $status == 'ptp' ? "CASE ptp_status WHEN '1' THEN 'BROKEN' WHEN '2' THEN 'KEEP' END  as ptp_status," : "";

          $file_now = 'calltrack_' . $_SESSION['bsname_s'] . '_' . date('Ymd-H_i_s') . '.txt';
          $sql = "SELECT 'branch_id','branch_name','contract_no','customer_name','overdue','installment','promised','action','handphone','action_description','handling_debitur','result_handling','ptp_status','status unit', 'status_debitur', 'PIC_Handling', 'tanggal_result', 'keterangan'
        UNION
        SELECT
              hdc.kode_cabang 		AS 'branch_id',
              hdm.region AS 'branch_name',
              hdc.primary_1 AS 'contract_no',
              hdc.cname AS 'customer_name',
              hdc.dpd AS 'overdue',
              hdc.angsuran_ke AS 'installment',
              hdc.ptp_date AS 'promised',
              hdc.id_handling_code AS 'action',
		hdc.no_contacted AS 'handphone',
              hda.description AS 'action_description',
              hdc.id_handling_debt AS 'handling_debitur',
              hdc.id_contact_code AS 'result_handling',
              CASE ptp_status WHEN '1' THEN 'BROKEN' WHEN '2' THEN 'KEEP' ELSE 'NA' END  as ptp_status,
              hda.unit_code AS 'status_unit',
              hda.debitur_code AS 'status_debitur',
              hdc.username AS 'PIC_Handling',
              hdc.call_date AS 'tanggal_result',
              hdc.remarks AS 'keterangan'
            FROM hdr_calltrack AS hdc
              INNER JOIN hdr_action_call_track hda ON hdc.id_action_call_track = hda.id_action_call_track
              LEFT  JOIN hdr_payment AS hdp
                ON hdp.primary_1 = hdc.primary_1
              LEFT JOIN hdr_user AS hu ON hdc.id_user = hu.id_user
              LEFT JOIN hdr_debtor_main hdm ON hdc.primary_1=hdm.primary_1
             $user_s  $user_id  $status_r $bg $ed   GROUP by $group_bys
            INTO OUTFILE '/tmp/$file_now' FIELDS TERMINATED BY '|' LINES TERMINATED BY '\\r\\n';";
          //die($sql);
          //echo $sql;
          $query = $this->db->query($sql);

          ## debug query report_status_to_csv ##
          //$a = $this->db->last_query();
          //die($a);

          //echo  query_to_csv($query);
          $this->load->helper('download');
          $file_path = '/tmp/' . $file_now;
          $files_real = file_get_contents($file_path);
          force_download($file_now, $files_real);
          //return $query;
      }

       public function report_status_to_csv_spv($id_user, $status, $begindate, $enddate, $report) {
          //$this->load->helper('csv');
          $group_bys = 'hdc.primary_1';
          if ($begindate != "" && $status != 'AC' && $status != 'untc') {
              $bg = " AND hdc.call_date>='$begindate '";
          } else {
              $bg = " ";
          }
          if ($enddate != "" && $status != 'AC' && $status != 'untc') {
              $ed = " AND hdc.call_date<='$enddate' ";
          } else {
              $ed = " ";
          }
          $user_s = $_SESSION['bid_user_s'] != '1' ? "WHERE hdc.id_spv   = '" . $_SESSION['bid_user_s'] . "'  " : 'WHERE hdc.primary_1 !="" ';

          $user_id = $id_user != 'all' ? '' : '';
          if ($status == "ptp") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND hdc.id_handling_code ='02' AND hdc.ptp_date IS NOT NULL and hdc.ptp_date != '0000-00-00'";
              //$bg = " AND hdc.ptp_date>='$begindate ' ";
              //$ed = " AND hdc.ptp_date<='$enddate' ";
          } elseif ($status == "all") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND hdc.id_action_call_track !='0' ";
          } elseif ($status == "acc") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "   ";
          } elseif ($status == "1") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND (hdc.id_cat_call = '1')";
          } elseif ($status == "2") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND (hdc.id_cat_call = '2')";
          } elseif ($status == 'AC') {
              $status_r = " ";
              $group_bys = 'hdp.primary_1';
          } elseif ($status == 'untc') {
              $status_r = " ";
              $group_bys = 'hdp.primary_1';
          } elseif ($status == 'keep') {
              $group_bys = 'hdc.primary_1';
              $status_r = "AND hdc.id_action_call_track ='11' AND  hdc.ptp_status ='2'
                 AND MONTH(hdp.trx_date) >= MONTH(hdc.call_date) ";
          } elseif ($status == 'broken') {
              $group_bys = 'hdc.primary_1';
              $status_r = "AND hdc.id_action_call_track ='11' AND  hdc.ptp_status ='1'   ";
          }elseif ($status == 'na') {
              $group_bys = 'hdc.primary_1';
              $status_r = "AND hdc.id_action_call_track ='11' AND  hdc.ptp_status ='0'   ";
          }
          //echo $status;
          $ptp_status1 = $status == 'ptp' ? "'PTP Status'," : "";
          $ptp_status2 = $status == 'ptp' ? "CASE ptp_status WHEN '1' THEN 'BROKEN' WHEN '2' THEN 'KEEP' END  as ptp_status," : "";

          $file_now = 'calltrack_' . $_SESSION['bsname_s'] . '_' . date('Ymd-H_i_s') . '.txt';
          $sql = "SELECT 'branch_id','branch_name','contract_no','customer_name','overdue','installment','promised','action','action_description','handling_debitur','result_handling','ptp_status','status unit', 'status_debitur', 'PIC_Handling', 'tanggal_result', 'keterangan'
        UNION
        SELECT
              hdc.kode_cabang 		AS 'branch_id',
              hdm.region AS 'branch_name',
              hdc.primary_1 AS 'contract_no',
              hdc.cname AS 'customer_name',
              hdc.dpd AS 'overdue',
              hdc.angsuran_ke AS 'installment',
              hdc.ptp_date AS 'promised',
              hdc.id_handling_code AS 'action',
              hda.description AS 'action_description',
              hdc.id_handling_debt AS 'handling_debitur',
              hdc.id_contact_code AS 'result_handling',
              CASE ptp_status WHEN '1' THEN 'BROKEN' WHEN '2' THEN 'KEEP' ELSE 'NA' END  as ptp_status,
              hda.unit_code AS 'status_unit',
              hda.debitur_code AS 'status_debitur',
              hdc.username AS 'PIC_Handling',
              hdc.call_date AS 'tanggal_result',
              hdc.remarks AS 'keterangan'
            FROM hdr_calltrack AS hdc
              INNER JOIN hdr_action_call_track hda ON hdc.id_action_call_track = hda.id_action_call_track
              LEFT  JOIN hdr_payment AS hdp
                ON hdp.primary_1 = hdc.primary_1
              LEFT JOIN hdr_user AS hu ON hdc.id_user = hu.id_user
              LEFT JOIN hdr_debtor_main hdm ON hdc.primary_1=hdm.primary_1
             $user_s  $user_id  $status_r $bg $ed   GROUP by $group_bys
            INTO OUTFILE '/tmp/$file_now' FIELDS TERMINATED BY '|' LINES TERMINATED BY '\\r\\n';";
          //die($sql);
          //echo $sql;
          $query = $this->db->query($sql);

          //echo  query_to_csv($query);
          $this->load->helper('download');
          $file_path = '/tmp/' . $file_now;
          $files_real = file_get_contents($file_path);

          //$str = $this-db->last_query();
       	  //die($str);
          force_download($file_now, $files_real);
          //return $query;
      }

      public function report_status_to_csv_adm($id_user, $status, $begindate, $enddate, $report) {
          //$this->load->helper('csv');
          $group_bys = 'hdc.primary_1';
          if ($begindate != "" && $status != 'AC' && $status != 'untc') {
              $bg = " AND hdc.call_date>='$begindate '";
          } else {
              $bg = " ";
          }
          if ($enddate != "" && $status != 'AC' && $status != 'untc') {
              $ed = " AND hdc.call_date<='$enddate' ";
          } else {
              $ed = " ";
          }
          $user_s = $_SESSION['bid_user_s'] != '1' ? "WHERE hdc.id_spv   != ''  " : 'WHERE hdc.primary_1 !="" ';

          $user_id = $id_user != 'all' ? '' : '';
          if ($status == "ptp") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND hdc.id_handling_code ='02' AND hdc.ptp_date IS NOT NULL and hdc.ptp_date != '0000-00-00'";
              //$bg = " AND hdc.ptp_date>='$begindate ' ";
              //$ed = " AND hdc.ptp_date<='$enddate' ";
          } elseif ($status == "all") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND hdc.id_action_call_track !='0' ";
          } elseif ($status == "acc") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "   ";
          } elseif ($status == "1") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND (hdc.id_cat_call = '1')";
          } elseif ($status == "2") {
              $group_bys = 'hdc.id_calltrack';
              $status_r = "AND (hdc.id_cat_call = '2')";
          } elseif ($status == 'AC') {
              $status_r = " ";
              $group_bys = 'hdp.primary_1';
          } elseif ($status == 'untc') {
              $status_r = " ";
              $group_bys = 'hdp.primary_1';
          } elseif ($status == 'keep') {
              $group_bys = 'hdc.primary_1';
              $status_r = "AND hdc.id_handling_code='02' AND  hdc.ptp_status ='2'
                 AND MONTH(hdp.trx_date) >= MONTH(hdc.call_date) ";
          } elseif ($status == 'broken') {
              $group_bys = 'hdc.primary_1';
              $status_r = "AND hdc.id_handling_code ='02' AND  hdc.ptp_status ='1'   ";
          }elseif ($status == 'na') {
              $group_bys = 'hdc.primary_1';
              $status_r = "AND hdc.id_handling_code ='02' AND  hdc.ptp_status ='0'   ";
          }
          //echo $status;
          $ptp_status1 = $status == 'ptp' ? "'PTP Status'," : "";
          $ptp_status2 = $status == 'ptp' ? "CASE ptp_status WHEN '1' THEN 'BROKEN' WHEN '2' THEN 'KEEP' END  as ptp_status," : "";

          $file_now = 'calltrack_' . $_SESSION['bsname_s'] . '_' . date('Ymd-H_i_s') . '.txt';
          $sql = "SELECT  'order_no','nama_cust','USER','Product','Risk Code','Bertemu','Lokasi','Action Code','no_contacted','PTP Status', 'Description', 'Action Date', 'Action Time', 'Reason Code','New_Phone_no','PTP amount','Amount Collected', 'PTP Date','Last Paid Date','Kode Cabang','due_date','DPD','OS AR AMOUNT','Surveyor','Cabang'
        UNION
        SELECT
              hdc.primary_1       AS 'order_no',
              hdc.cname           AS 'nama_cust',
              hdc.username        AS 'USER',
              hu.product          AS 'Product',
              hdc.risk_code       AS 'Risk Code',
              hdc.contact_code    AS 'Bertemu',
              hdc.location_code   AS 'Lokasi',
              hdc.code_call_track AS 'Action Code',
              hdc.no_contacted    AS  'no_contacted',
              CASE ptp_status WHEN '1' THEN 'BROKEN' WHEN '2' THEN 'KEEP' ELSE 'NA' END  as ptp_status,
              hda.description     AS 'Description',
              hdc.call_date       AS 'Action Date',
              hdc.call_time       AS 'Action Time',
              hdc.remarks         AS 'Reason Code',
              hdc.no_contacted    AS 'New_Phone_no',
              hdc.ptp_amount      AS 'PTP amount',
              hdp.amount_pay          AS 'Amount Collected',
              hdc.ptp_date        AS 'PTP Date',
              MAX(hdp.trx_date)    AS 'Last Paid Date',
              hdc.kode_cabang     AS 'Kode Cabang',
              hdm.due_date				AS 'due_date',
              hdc.dpd     AS 'DPD',
              hdc.os_ar_amount     AS 'OS AR AMOUNT',
              hdc.surveyor     AS 'Surveyor',
              hdc.kode_cabang AS 'Cabang'
            FROM hdr_calltrack AS hdc
              INNER JOIN hdr_action_call_track hda ON hdc.id_action_call_track = hda.id_action_call_track
              LEFT  JOIN hdr_payment AS hdp
                ON hdp.primary_1 = hdc.primary_1
              LEFT JOIN hdr_user AS hu ON hdc.id_user = hu.id_user
              LEFT JOIN hdr_debtor_main hdm ON hdc.primary_1=hdm.primary_1
             $user_s  $user_id  $status_r $bg $ed   GROUP by $group_bys
            INTO OUTFILE '/tmp/$file_now' FIELDS TERMINATED BY '|' LINES TERMINATED BY '\\r\\n';";
          //die($sql);
          //echo $sql;
          $query = $this->db->query($sql);

          //echo  query_to_csv($query);
          $this->load->helper('download');
          $file_path = '/tmp/' . $file_now;
          $files_real = file_get_contents($file_path);
          force_download($file_now, $files_real);
          //return $query;
      }

      // Report Attendance

      public function attendance_report($month) {
          $get_days = cal_days_in_month(CAL_GREGORIAN, $month, 2010);
          $header = '(SELECT "NAMA LENGKAP","0" as "username","0" as "shift",  ';
          for ($i = 1; $i <= $get_days; $i++) {
              $comma = $i == $get_days ? ' ' : ',';
              $from_today = date('Y-' . $month . '-d');
              $get_month = $sum = date("M", strtotime("$from_today"));
              $header .= "'" . $i . $get_month . "'" . $comma;
          }
          $sql = $header . ")  UNION (select  hu.fullname as NAME,  hu.username,shift,";
          $day = date('d');
          //$header .='';
          for ($i = 1; $i <= $get_days; $i++) {
              $comma = $i == $get_days ? ' ' : ',';

              $time = time();
              $file_now = 'Absensi' . $month . '-' . $time . '.txt';
              $sql .= "IFNULL( MAX(case day when " . $i . " then CONCAT(DATE_FORMAT(login_time,' %H:%i') , ' out ', DATE_FORMAT(logout_time,' %H:%i' ))  END), 'absen') as day" . $i . $comma . "";
          }

          $sql .= "INTO OUTFILE '/tmp/$file_now' FIELDS TERMINATED BY '|' LINES TERMINATED BY '\\r\\n'";
          $sql .= " FROM hdr_user_attend hua
            INNER JOIN hdr_user hu ON hu.id_user = hua.id_user
            WHERE month ='$month' GROUP BY hua.id_user  ) ORDER BY shift,username ASC ";
          $query = $this->db->query($sql);
          //die($sql);
          $this->load->helper('download');
          $file_path = '/tmp/' . $file_now;
          $files_real = file_get_contents($file_path);
          force_download($file_now, $files_real);
      }

      //Not Use Function Below

      public function get_next_call($id_user) {
          $sql = "SELECT filter_debtor FROM hdr_user WHERE id_user = '$id_user' ORDER BY id_user DESC LIMIT 1";
          //echo $sql;
          $query = $this->db->query($sql);
          $data = $query->row();
          if ($query->num_rows() >= 1 && $data->filter_debtor != '') {

              return $data->filter_debtor;
          } else {
              return 'WHERE primary_1 != "0"';
          }
      }

      public function count_assign_debtor_tc($id_user) {

          /*
          if ($_SESSION['filter_debtor'] == '') {
              return 'Not Filtered';
          } else {
              $sql = " SELECT COUNT(DISTINCT hdm.primary_1) AS total_debtor  FROM " . $this->hdr_debtor_main . " AS hdm " . $this->get_next_call($id_user) . "  ";
              //die($this->get_next_call($id_user));
              //echo $sql;
              //echo $id_tc;
              $query = $this->db->query($sql);
              $data = $query->row();
              if ($query->num_rows() < 1) {
                  $bad = ' "No Debtor" ';
                  return $bad;
              } else {
                  return $data->total_debtor;
              }
          }
          */
					$where = array(
						"id_user" => $id_user
					);
					$q = $this->db->get_where("hdr_user", $where);
					$row = $q->row_array();

					$product = $row['product'];
					$priority = $row['priority'];
					$branch_area = $row['branch_area'];
					$over_days = $row['over_days'];
					$fin_type = $row['fin_type'];
					$bucket_od = $row['bucket_od'];
					$bucket_coll = $row['bucket_coll'];

					## escaping value branch ##
					if($branch_area != ''){
						$tmp_arr = explode(",",$branch_area);
						$index = 0;
						foreach($tmp_arr as $row) {
							$tmp_arr[$index] = $this->db->escape($row);
							$index++;
						}
						$branch_area = implode(",",$tmp_arr);

					}

					//var_dump($branch_area);
					//die();
					$where = " where id_debtor > 0 and skip = 0 and (is_paid IS NULL or is_paid = 0) and valdo_cc = '01'";
					$where .= $branch_area != "" ? " and kode_cabang IN ($branch_area) " : "";

					switch($bucket_coll)
					{
						case "1":
						//$where .= " and kode_cabang IN ('0641','0216','0104','0628','0109','0118','0110','0125','0101','0656','0607','0622','0657','0680','0604','0624','0681','0220','0128','0602','0648','0122','0512','0510','0105','0430') ";
						break;
						default:
						//$where .= " and kode_cabang not in ('0641','0216','0104','0628','0109','0118','0110','0125','0101','0656','0607','0622','0657','0680','0604','0624','0681','0220','0128','0602','0648','0122','0512','0510','0105','0430') ";
						break;
					}

					$arr_temp = null;
					if($product != "ALL")
					{
						$where .= " and (";
						$arrdata = explode(",", $product);
						for($i=0;$i<count($arrdata);$i++)
						{
							$arr_temp[] .= " object_group_code = (".$arrdata[$i].") ";
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
							$stovd = $arrdata[$i];
							switch($stovd)
							{
								case "15plus":
									$arr_temp[] .= " dpd > 15 ";
									break;
								default:
									$arr_temp[] .= " dpd = '$stovd' ";
									break;
							}
							/*							
							if($arrdata[$i] != '10plus'){
								$arr_temp[] .= " datediff(now(),due_date) = ('".$arrdata[$i]."') ";
							} else {
								$arr_temp[] .= " datediff(now(),due_date) >= ('10') ";
							}
							*/
						}
						$where .= implode("or",$arr_temp) . ")";
					}
					else
					{
						$where .= " and dpd >= -3 ";
						//$where .= "and (datediff(now(),due_date) >= -6)";
					}

					if($priority != "")
					{
						$arrdata_prod = explode(",", $priority);
						//var_dump($arrdata_prod);
						//die($arrdata);
						for($i=0;$i<count($arrdata_prod);$i++)
						{
							switch($arrdata_prod[$i])
							{
								case "PTP":
								$a = "UPDATE hdr_debtor_main a
											LEFT JOIN hdr_calltrack b
												ON a.primary_1 = b.primary_1 AND b.ptp_date >= CURDATE() AND b.id_calltrack = (SELECT MAX(id_calltrack) FROM hdr_calltrack zz WHERE zz.primary_1 = a.primary_1 AND zz.ptp_date >= CURDATE())
												SET a.ptp_date = b.ptp_date, a.id_user = b.id_user
												WHERE
												b.ptp_date IS NOT NULL
												AND b.ptp_date <> '0000-00-00'";
								$b = "UPDATE hdr_debtor_main SET not_ptp = 1 WHERE ptp_date >= CURDATE()";
								$this->db->simple_query($a);
								$this->db->simple_query($b);
								$where .= " and ptp_date is not null AND id_user = '$id_user' AND month(ptp_date)=month(now()) and year(ptp_date)=year(now())";
								break;

								case "UNTOUCH":
									$where .= " and is_new = 1 ";
									$where .= " and last_handling_date='0000-00-00' ";
								break;

								case "RETOUCH":
									$where .= " and is_new = 2 ";
								break;
							}
						}
					}

				if($bucket_od != "")
				{
					//od 1-7
					if($bucket_od == 1)
					{
						$where .= "and (datediff(now(),due_date) between 1 and 7)";
					}

					//od 8-14
					if($bucket_od == 2)
					{
						$where .= "and (datediff(now(),due_date) between 8 and 14)";
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

					//die($where);


						$sql = "select primary_1, due_date from hdr_debtor_main " .
							" $where ";

						##martin debug##
						//echo $sql;
						//die($sql);
						$q = $this->db->query($sql);
						//echo $this->db->last_query();
						//die();
						//$sql2 = "update hdr_debtor_main set called='0', id_user=0, in_use=0 $where";
						//$this->db->query($sql2);

						//$sql2 = "update hdr_debtor_main set called='0' $where";

					if($q->num_rows() > 0){
						return $q->num_rows();
					}
					else {
						return ' "No Debtor" ';
					}
          //die();

      }


      public function getall_regions()
      {
				$sql = "select branch_name, region_id,region_name
					from hdr_branches
					where area_code not in ('0641','0216','0104','0628','0109','0118','0110','0125','0101','0656','0607','0622','0657','0680','0604','0624','0681','0220','0128','0602','0648','0122','0512','0510','0105','0430')
					group by region_id";
				$q = $this->db->query($sql);
				$data = array();

				if($q->num_rows() > 0)
				{
					foreach($q->result_array() as $row)
					{
						$data[] = $row;
					}
				}
				$q->free_result();

				return $data;
      }


      	/**
			 * Dijalanin sebulan sekali
			 */
      public function report_filter()
      {
      	$sql = "select * from hdr_user where id_level=3";
      	$q = $this->db->query($sql);

      	foreach($q->result_array() as $row)
      	{
      		$user_id = $row['id_user'];
      		$today = date('Y-m-d');
      		$assign_total = $this->count_assign_debtor_tc($user_id);
      		if($assign_total == ' "No Debtor" ') $assign_total = 0;

      		$data = array(
						"user_id" => $user_id,
						"assign_total" => $assign_total,
						"created" => $today
      		);

      		$this->db->insert("hdr_report_filter", $data);

      	}
      }

      ## Martin[30 Dec 2011]-> count available
       public function countDebtor(){
       	$sql = "SELECT count(id_debtor) as num FROM hdr_debtor_main";
       	$query = $this->db->query($sql);
       	return $query->row();
       }

       public function dataCount(){
       	$id_user = $_SESSION['bid_user_s'];

        $sql_lock = "LOCK TABLE hdr_debtor_main AS lock".$id_user." WRITE";
        $sql_unlock = "UNLOCK TABLES";

        ##-- All Data --##
        $sql_1 = "SELECT COUNT(id_debtor) AS totalData,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL THEN id_debtor END) AS availableData,
										COUNT(CASE WHEN called = 0 AND (skip = 1 OR is_paid IS NOT NULL) THEN id_debtor END) AS lockedData,
										COUNT(CASE WHEN called = 1 THEN id_debtor END) AS touchedData
										FROM hdr_debtor_main AS lock".$id_user."
											WHERE createdate >= CURDATE();
										";

				##-- Available Segmentation --##
			  $sql_2 = "SELECT COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL THEN id_debtor END) AS availableData,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND is_new = 1 AND valdo_cc = '01' THEN id_debtor END) AS newDataJkt,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND is_new = 2 AND valdo_cc = '01' THEN id_debtor END) AS retouchDataJkt,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND is_new = 0 AND valdo_cc = '01' THEN id_debtor END) AS unprioritizeDataJkt,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND is_new = 1 AND valdo_cc = '02' THEN id_debtor END) AS newDataSby,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND is_new = 2 AND valdo_cc = '02' THEN id_debtor END) AS retouchDataSby,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND is_new = 0 AND valdo_cc = '02' THEN id_debtor END) AS unprioritizeDataSby,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND is_new = 1 AND ( valdo_cc NOT IN ('01','02') OR valdo_cc IS NULL ) THEN id_debtor END) AS newDataOther,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND is_new = 2 AND ( valdo_cc NOT IN ('01','02') OR valdo_cc IS NULL ) THEN id_debtor END) AS retouchDataOther,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND is_new = 0 AND ( valdo_cc NOT IN ('01','02') OR valdo_cc IS NULL ) THEN id_debtor END) AS unprioritizeDataOther
										FROM hdr_debtor_main AS lock".$id_user."
											WHERE createdate >= CURDATE();
										";

				##-- Available Segmentation 2 --##
        $sql_3 = "SELECT COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL THEN id_debtor END) AS availableData,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND valdo_cc = '01' AND fin_type = '1' THEN id_debtor END) AS jktRegularData,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND valdo_cc = '01' AND fin_type = '2' THEN id_debtor END) AS jktSyariahData,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND valdo_cc = '01' AND (fin_type NOT IN ('1','2') OR fin_type IS NULL) THEN id_debtor END) AS jktOtherData,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND valdo_cc = '02' AND fin_type = '1' THEN id_debtor END) AS sbyRegularData,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND valdo_cc = '02' AND fin_type = '2' THEN id_debtor END) AS sbySyariahData,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND valdo_cc = '02' AND (fin_type NOT IN ('1','2') OR fin_type IS NULL) THEN id_debtor END) AS sbyOtherData,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND is_paid IS NULL AND ( valdo_cc NOT IN ('01','02') OR valdo_cc IS NULL) THEN id_debtor END) AS otherData
										FROM hdr_debtor_main AS lock".$id_user."
											WHERE createdate >=  CURDATE();
										";

				##-- Locked Segmentation --##
				$sql_4 = "SELECT COUNT(CASE WHEN called = 0 AND (skip = 1 OR is_paid IS NOT NULL) THEN id_debtor END) AS lockedData,
										COUNT(CASE WHEN called = 0 AND skip = 0 AND (is_paid = 1) THEN id_debtor END) AS Paid,
										COUNT(CASE WHEN called = 0 AND skip = 1 AND (is_paid IS NULL OR is_paid = 0) THEN id_debtor END) AS Skip,
										COUNT(CASE WHEN called = 0 AND skip = 1 AND (is_paid = 1) THEN id_debtor END) AS PaidNSkip
										FROM hdr_debtor_main AS lock".$id_user."
											WHERE createdate >= CURDATE();
										";

				$this->db->simple_query($sql_lock); //start locking table

				$query_1 = $this->db->query($sql_1);
				$query_2 = $this->db->query($sql_2);
				$query_3 = $this->db->query($sql_3);
				$query_4 = $this->db->query($sql_4);

			  $this->db->simple_query($sql_unlock); //unlocking table

				$array_1 = $query_1->row_array();
				$array_2 = $query_2->row_array();
				$array_3 = $query_3->row_array();
				$array_4 = $query_4->row_array();

				$returnArr = array(
					"all_data" => $array_1,
					"isnew_seg"=> $array_2,
					"fintype_seg"=> $array_3,
					"locked_seg"=> $array_4
				);

				return $returnArr;
       }
	   public function daily_report1($month,$year,$location) {
			//die($fromdate." to ".$enddate);


		/*$sql = "SELECT
					COUNT(DISTINCT hc.primary_1) AS mentah,
					COUNT(DISTINCT hc.primary_1) AS total,
					COUNT(DISTINCT hc.primary_1) - COUNT(DISTINCT hc.primary_1) AS selisih,
					COUNT(CASE hdm.last_handling_date WHEN '0000-00-00' THEN hc.primary_1 END) AS untouch,
					COUNT(CASE hdm.skip WHEN '1' THEN hc.primary_1 END) AS skip,
					COUNT(CASE hdm.not_ptp WHEN '1' THEN hc.primary_1 END) AS active_on,
					COUNT(DISTINCT hc.primary_1) - COUNT(CASE hdm.skip WHEN '1' THEN hc.primary_1 END) - COUNT(CASE hdm.not_ptp WHEN '1' THEN hc.primary_1 END) AS data_work,
					COUNT(CASE hdm.last_handling_date WHEN '0000-00-00' THEN hc.primary_1 END) / COUNT(DISTINCT hc.primary_1) AS untouch_persen,
					COUNT(CASE hdm.skip WHEN '1' THEN hc.primary_1 END) / COUNT(DISTINCT hc.primary_1) AS skip_persen,
					(COUNT(DISTINCT hc.primary_1) - COUNT(CASE hdm.skip WHEN '1' THEN hc.primary_1 END) - COUNT(CASE hdm.not_ptp WHEN '1' THEN hc.primary_1 END)) / COUNT(DISTINCT hc.primary_1) AS data_work_persen
					FROM `hdr_calltrack` hc
					INNER JOIN hdr_debtor_main_inventory hdm ON hdm.primary_1 = hc.primary_1
					INNER JOIN hdr_action_call_track hac ON hac.id_action_call_track = hc.id_action_call_track
					WHERE hc.call_date BETWEEN '$fromdate' AND '$enddate' ";*/

		$sql = "select
					COUNT(CASE DAY(hdm.data_date) WHEN '1' THEN hdm.primary_1 END) AS total_data_1,
					COUNT(CASE DAY(hdm.data_date) WHEN '2' THEN hdm.primary_1 END) AS total_data_2,
					COUNT(CASE DAY(hdm.data_date) WHEN '3' THEN hdm.primary_1 END) AS total_data_3,
					COUNT(CASE DAY(hdm.data_date) WHEN '4' THEN hdm.primary_1 END) AS total_data_4,
					COUNT(CASE DAY(hdm.data_date) WHEN '5' THEN hdm.primary_1 END) AS total_data_5,
					COUNT(CASE DAY(hdm.data_date) WHEN '6' THEN hdm.primary_1 END) AS total_data_6,
					COUNT(CASE DAY(hdm.data_date) WHEN '7' THEN hdm.primary_1 END) AS total_data_7,
					COUNT(CASE DAY(hdm.data_date) WHEN '8' THEN hdm.primary_1 END) AS total_data_8,
					COUNT(CASE DAY(hdm.data_date) WHEN '9' THEN hdm.primary_1 END) AS total_data_9,
					COUNT(CASE DAY(hdm.data_date) WHEN '10' THEN hdm.primary_1 END) AS total_data_10,
					COUNT(CASE DAY(hdm.data_date) WHEN '11' THEN hdm.primary_1 END) AS total_data_11,
					COUNT(CASE DAY(hdm.data_date) WHEN '12' THEN hdm.primary_1 END) AS total_data_12,
					COUNT(CASE DAY(hdm.data_date) WHEN '13' THEN hdm.primary_1 END) AS total_data_13,
					COUNT(CASE DAY(hdm.data_date) WHEN '14' THEN hdm.primary_1 END) AS total_data_14,
					COUNT(case day(hdm.data_date) when '15' then hdm.primary_1 end)as total_data_15,
					COUNT(CASE DAY(hdm.data_date) WHEN '16' THEN hdm.primary_1 END) AS total_data_16,
					COUNT(CASE DAY(hdm.data_date) WHEN '17' THEN hdm.primary_1 END) AS total_data_17,
					COUNT(CASE DAY(hdm.data_date) WHEN '18' THEN hdm.primary_1 END) AS total_data_18,
					COUNT(CASE DAY(hdm.data_date) WHEN '19' THEN hdm.primary_1 END) AS total_data_19,
					COUNT(CASE DAY(hdm.data_date) WHEN '20' THEN hdm.primary_1 END) AS total_data_20,
					COUNT(CASE DAY(hdm.data_date) WHEN '21' THEN hdm.primary_1 END) AS total_data_21,
					COUNT(CASE DAY(hdm.data_date) WHEN '22' THEN hdm.primary_1 END) AS total_data_22,
					COUNT(CASE DAY(hdm.data_date) WHEN '23' THEN hdm.primary_1 END) AS total_data_23,
					COUNT(CASE DAY(hdm.data_date) WHEN '24' THEN hdm.primary_1 END) AS total_data_24,
					COUNT(CASE DAY(hdm.data_date) WHEN '25' THEN hdm.primary_1 END) AS total_data_25,
					COUNT(CASE DAY(hdm.data_date) WHEN '26' THEN hdm.primary_1 END) AS total_data_26,
					COUNT(CASE DAY(hdm.data_date) WHEN '27' THEN hdm.primary_1 END) AS total_data_27,
					COUNT(CASE DAY(hdm.data_date) WHEN '28' THEN hdm.primary_1 END) AS total_data_28,
					COUNT(CASE DAY(hdm.data_date) WHEN '29' THEN hdm.primary_1 END) AS total_data_29,
					COUNT(CASE DAY(hdm.data_date) WHEN '30' THEN hdm.primary_1 END) AS total_data_30,
					COUNT(CASE DAY(hdm.data_date) WHEN '31' THEN hdm.primary_1 END) AS total_data_31
					from hdr_debtor_main_inventory hdm
					where MONTH(hdm.data_date) = '$month' AND YEAR(hdm.data_date) = '$year' and hdm.valdo_cc = '$location'";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		/*$sql	= $this->db->query("");
			if($sql){
				$result = $sql->result_array();
			}

			return $data = $result;
		*/
		}
		public function daily_report3($month,$year,$location) {

		$sql = "select
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '1' THEN hdm.primary_1 END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '2' THEN hdm.primary_1 END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '3' THEN hdm.primary_1 END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '4' THEN hdm.primary_1 END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '5' THEN hdm.primary_1 END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '6' THEN hdm.primary_1 END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '7' THEN hdm.primary_1 END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '8' THEN hdm.primary_1 END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '9' THEN hdm.primary_1 END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '10' THEN hdm.primary_1 END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '11' THEN hdm.primary_1 END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '12' THEN hdm.primary_1 END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '13' THEN hdm.primary_1 END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '14' THEN hdm.primary_1 END)) AS total_data_14,
					COUNT(distinct (case day(hdm.data_date) when '15' then hdm.primary_1 end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '16' THEN hdm.primary_1 END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '17' THEN hdm.primary_1 END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '18' THEN hdm.primary_1 END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '19' THEN hdm.primary_1 END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '20' THEN hdm.primary_1 END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '21' THEN hdm.primary_1 END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '22' THEN hdm.primary_1 END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '23' THEN hdm.primary_1 END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '24' THEN hdm.primary_1 END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '25' THEN hdm.primary_1 END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '26' THEN hdm.primary_1 END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '27' THEN hdm.primary_1 END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '28' THEN hdm.primary_1 END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '29' THEN hdm.primary_1 END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '30' THEN hdm.primary_1 END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '31' THEN hdm.primary_1 END)) AS total_data_31
					from hdr_debtor_main_inventory hdm
					WHERE hdm.is_new = '1' and hdm.last_handling_date = '0000-00-00' and month(hdm.data_date) = '$month' and year(hdm.data_date) = '$year' and hdm.valdo_cc = '$location' ";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function daily_report4($month,$year,$location) {

		$sql = "select
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '1' THEN hdm.primary_1 END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '2' THEN hdm.primary_1 END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '3' THEN hdm.primary_1 END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '4' THEN hdm.primary_1 END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '5' THEN hdm.primary_1 END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '6' THEN hdm.primary_1 END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '7' THEN hdm.primary_1 END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '8' THEN hdm.primary_1 END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '9' THEN hdm.primary_1 END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '10' THEN hdm.primary_1 END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '11' THEN hdm.primary_1 END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '12' THEN hdm.primary_1 END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '13' THEN hdm.primary_1 END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '14' THEN hdm.primary_1 END)) AS total_data_14,
					COUNT(distinct (case day(hdm.data_date) when '15' then hdm.primary_1 end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '16' THEN hdm.primary_1 END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '17' THEN hdm.primary_1 END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '18' THEN hdm.primary_1 END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '19' THEN hdm.primary_1 END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '20' THEN hdm.primary_1 END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '21' THEN hdm.primary_1 END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '22' THEN hdm.primary_1 END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '23' THEN hdm.primary_1 END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '24' THEN hdm.primary_1 END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '25' THEN hdm.primary_1 END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '26' THEN hdm.primary_1 END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '27' THEN hdm.primary_1 END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '28' THEN hdm.primary_1 END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '29' THEN hdm.primary_1 END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '30' THEN hdm.primary_1 END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '31' THEN hdm.primary_1 END)) AS total_data_31
					from hdr_debtor_main_inventory hdm
					WHERE hdm.skip = '1' and month(hdm.data_date) = '$month' and year(hdm.data_date) = '$year'  and hdm.valdo_cc = '$location' ";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function daily_report5($month,$year,$location) {

		$sql = "select
					COUNT(CASE DAY(hdm.data_date) WHEN '1' THEN hdm.primary_1 END) AS total_data_1,
					COUNT(CASE DAY(hdm.data_date) WHEN '2' THEN hdm.primary_1 END) AS total_data_2,
					COUNT(CASE DAY(hdm.data_date) WHEN '3' THEN hdm.primary_1 END) AS total_data_3,
					COUNT(CASE DAY(hdm.data_date) WHEN '4' THEN hdm.primary_1 END) AS total_data_4,
					COUNT(CASE DAY(hdm.data_date) WHEN '5' THEN hdm.primary_1 END) AS total_data_5,
					COUNT(CASE DAY(hdm.data_date) WHEN '6' THEN hdm.primary_1 END) AS total_data_6,
					COUNT(CASE DAY(hdm.data_date) WHEN '7' THEN hdm.primary_1 END) AS total_data_7,
					COUNT(CASE DAY(hdm.data_date) WHEN '8' THEN hdm.primary_1 END) AS total_data_8,
					COUNT(CASE DAY(hdm.data_date) WHEN '9' THEN hdm.primary_1 END) AS total_data_9,
					COUNT(CASE DAY(hdm.data_date) WHEN '10' THEN hdm.primary_1 END) AS total_data_10,
					COUNT(CASE DAY(hdm.data_date) WHEN '11' THEN hdm.primary_1 END) AS total_data_11,
					COUNT(CASE DAY(hdm.data_date) WHEN '12' THEN hdm.primary_1 END) AS total_data_12,
					COUNT(CASE DAY(hdm.data_date) WHEN '13' THEN hdm.primary_1 END) AS total_data_13,
					COUNT(CASE DAY(hdm.data_date) WHEN '14' THEN hdm.primary_1 END) AS total_data_14,
					COUNT(case day(hdm.data_date) when '15' then hdm.primary_1 end) as total_data_15,
					COUNT(CASE DAY(hdm.data_date) WHEN '16' THEN hdm.primary_1 END) AS total_data_16,
					COUNT(CASE DAY(hdm.data_date) WHEN '17' THEN hdm.primary_1 END) AS total_data_17,
					COUNT(CASE DAY(hdm.data_date) WHEN '18' THEN hdm.primary_1 END) AS total_data_18,
					COUNT(CASE DAY(hdm.data_date) WHEN '19' THEN hdm.primary_1 END) AS total_data_19,
					COUNT(CASE DAY(hdm.data_date) WHEN '20' THEN hdm.primary_1 END) AS total_data_20,
					COUNT(CASE DAY(hdm.data_date) WHEN '21' THEN hdm.primary_1 END) AS total_data_21,
					COUNT(CASE DAY(hdm.data_date) WHEN '22' THEN hdm.primary_1 END) AS total_data_22,
					COUNT(CASE DAY(hdm.data_date) WHEN '23' THEN hdm.primary_1 END) AS total_data_23,
					COUNT(CASE DAY(hdm.data_date) WHEN '24' THEN hdm.primary_1 END) AS total_data_24,
					COUNT(CASE DAY(hdm.data_date) WHEN '25' THEN hdm.primary_1 END) AS total_data_25,
					COUNT(CASE DAY(hdm.data_date) WHEN '26' THEN hdm.primary_1 END) AS total_data_26,
					COUNT(CASE DAY(hdm.data_date) WHEN '27' THEN hdm.primary_1 END) AS total_data_27,
					COUNT(CASE DAY(hdm.data_date) WHEN '28' THEN hdm.primary_1 END) AS total_data_28,
					COUNT(CASE DAY(hdm.data_date) WHEN '29' THEN hdm.primary_1 END) AS total_data_29,
					COUNT(CASE DAY(hdm.data_date) WHEN '30' THEN hdm.primary_1 END) AS total_data_30,
					COUNT(CASE DAY(hdm.data_date) WHEN '31' THEN hdm.primary_1 END) AS total_data_31
					from hdr_debtor_main_inventory hdm
					where MONTH(hdm.data_date) = '$month' AND YEAR(hdm.data_date) = '$year' AND hdm.valdo_cc = '$location'
					and hdm.last_handling_date != '0000-00-00' and hdm.ptp_date is not null";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}

		public function daily_report6($month,$year,$location,$leader,$branch,$dc) {

		if($leader == 'All'){
			$where = "";
		} else {
			$where = "and hu.id_leader = '$leader'";
		}

		if($branch == 'All'){
			$where2 = "";
		} else {
			$where2 = "and hdm.kode_cabang = '$branch'";
		}

		if($dc == 'All'){
			$where3 = "";
		} else {
			$where3 = "and hc.id_user = '$dc'";
		}

		$sql = "select
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '1' THEN hc.id_calltrack END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '2' THEN hc.id_calltrack END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '3' THEN hc.id_calltrack END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '4' THEN hc.id_calltrack END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '5' THEN hc.id_calltrack END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '6' THEN hc.id_calltrack END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '7' THEN hc.id_calltrack END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '8' THEN hc.id_calltrack END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '9' THEN hc.id_calltrack END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '10' THEN hc.id_calltrack END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '11' THEN hc.id_calltrack END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '12' THEN hc.id_calltrack END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '13' THEN hc.id_calltrack END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '14' THEN hc.id_calltrack END)) AS total_data_14,
					COUNT(distinct (case day(hc.call_date) when '15' then hc.id_calltrack end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '16' THEN hc.id_calltrack END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '17' THEN hc.id_calltrack END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '18' THEN hc.id_calltrack END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '19' THEN hc.id_calltrack END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '20' THEN hc.id_calltrack END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '21' THEN hc.id_calltrack END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '22' THEN hc.id_calltrack END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '23' THEN hc.id_calltrack END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '24' THEN hc.id_calltrack END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '25' THEN hc.id_calltrack END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '26' THEN hc.id_calltrack END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '27' THEN hc.id_calltrack END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '28' THEN hc.id_calltrack END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '29' THEN hc.id_calltrack END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '30' THEN hc.id_calltrack END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '31' THEN hc.id_calltrack END)) AS total_data_31
					from hdr_calltrack hc
					inner join hdr_debtor_main_inventory hdm on hdm.primary_1 = hc.primary_1 and MONTH(hdm.data_date) = '$month' AND YEAR(hdm.data_date) = '$year'
					and hdm.valdo_cc = '$location' $where2
					INNER JOIN hdr_user hu ON hu.id_user = hc.id_user $where
					where MONTH(hc.call_date) = '$month' AND YEAR(hc.call_date) = '$year' $where3 ";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function daily_report7($month,$year,$location,$leader,$branch,$dc) {

		if($leader == 'All'){
			$where = "";
		} else {
			$where = "and hu.id_leader = '$leader'";
		}

		if($branch == 'All'){
			$where2 = "";
		} else {
			$where2 = "and hdm.kode_cabang = '$branch'";
		}

		if($dc == 'All'){
			$where3 = "";
		} else {
			$where3 = "and hc.id_user = '$dc'";
		}

		$sql = "select
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '1' THEN hc.id_calltrack END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '2' THEN hc.id_calltrack END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '3' THEN hc.id_calltrack END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '4' THEN hc.id_calltrack END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '5' THEN hc.id_calltrack END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '6' THEN hc.id_calltrack END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '7' THEN hc.id_calltrack END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '8' THEN hc.id_calltrack END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '9' THEN hc.id_calltrack END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '10' THEN hc.id_calltrack END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '11' THEN hc.id_calltrack END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '12' THEN hc.id_calltrack END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '13' THEN hc.id_calltrack END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '14' THEN hc.id_calltrack END)) AS total_data_14,
					COUNT(distinct (case day(hc.call_date) when '15' then hc.id_calltrack end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '16' THEN hc.id_calltrack END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '17' THEN hc.id_calltrack END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '18' THEN hc.id_calltrack END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '19' THEN hc.id_calltrack END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '20' THEN hc.id_calltrack END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '21' THEN hc.id_calltrack END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '22' THEN hc.id_calltrack END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '23' THEN hc.id_calltrack END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '24' THEN hc.id_calltrack END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '25' THEN hc.id_calltrack END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '26' THEN hc.id_calltrack END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '27' THEN hc.id_calltrack END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '28' THEN hc.id_calltrack END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '29' THEN hc.id_calltrack END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '30' THEN hc.id_calltrack END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '31' THEN hc.id_calltrack END)) AS total_data_31
					from hdr_calltrack hc
					inner join hdr_debtor_main_inventory hdm on hdm.primary_1 = hc.primary_1 and MONTH(hdm.data_date) = '$month' AND YEAR(hdm.data_date) = '$year'
					and hdm.valdo_cc = '$location' $where2
					inner join hdr_user hu on hu.id_user = hc.id_user $where
					where MONTH(hc.call_date) = '$month' AND YEAR(hc.call_date) = '$year' AND hc.id_call_cat='1' $where3 ";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function daily_report8($month,$year,$location,$leader,$branch,$dc) {

		if($leader == 'All'){
			$where = "";
		} else {
			$where = "and hu.id_leader = '$leader'";
		}

		if($branch == 'All'){
			$where2 = "";
		} else {
			$where2 = "and hdm.kode_cabang = '$branch'";
		}

		if($dc == 'All'){
			$where3 = "";
		} else {
			$where3 = "and hc.id_user = '$dc'";
		}

		$sql = "select
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '1' THEN hc.id_calltrack END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '2' THEN hc.id_calltrack END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '3' THEN hc.id_calltrack END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '4' THEN hc.id_calltrack END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '5' THEN hc.id_calltrack END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '6' THEN hc.id_calltrack END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '7' THEN hc.id_calltrack END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '8' THEN hc.id_calltrack END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '9' THEN hc.id_calltrack END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '10' THEN hc.id_calltrack END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '11' THEN hc.id_calltrack END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '12' THEN hc.id_calltrack END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '13' THEN hc.id_calltrack END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '14' THEN hc.id_calltrack END)) AS total_data_14,
					COUNT(distinct (case day(hc.call_date) when '15' then hc.id_calltrack end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '16' THEN hc.id_calltrack END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '17' THEN hc.id_calltrack END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '18' THEN hc.id_calltrack END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '19' THEN hc.id_calltrack END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '20' THEN hc.id_calltrack END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '21' THEN hc.id_calltrack END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '22' THEN hc.id_calltrack END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '23' THEN hc.id_calltrack END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '24' THEN hc.id_calltrack END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '25' THEN hc.id_calltrack END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '26' THEN hc.id_calltrack END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '27' THEN hc.id_calltrack END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '28' THEN hc.id_calltrack END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '29' THEN hc.id_calltrack END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '30' THEN hc.id_calltrack END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '31' THEN hc.id_calltrack END)) AS total_data_31
					from hdr_calltrack hc
					inner join hdr_debtor_main_inventory hdm on hdm.primary_1 = hc.primary_1 and MONTH(hdm.data_date) = '$month' AND YEAR(hdm.data_date) = '$year'
					and hdm.valdo_cc = '$location' $where2
					inner join hdr_user hu on hu.id_user = hc.id_user $where
					where MONTH(hc.call_date) = '$month' AND YEAR(hc.call_date) = '$year' and hc.id_handling_code = '02' AND hc.ptp_date IS NOT NULL AND hc.ptp_date != '0000-00-00' $where3
					";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function daily_report9($month,$year,$location,$leader,$branch,$dc) {

		if($leader == 'All'){
			$where = "";
		} else {
			$where = "and hu.id_leader = '$leader'";
		}

		if($branch == 'All'){
			$where2 = "";
		} else {
			$where2 = "and hdm.kode_cabang = '$branch'";
		}

		if($dc == 'All'){
			$where3 = "";
		} else {
			$where3 = "and hc.id_user = '$dc'";
		}

		$sql = "select
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '1' THEN hc.id_calltrack END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '2' THEN hc.id_calltrack END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '3' THEN hc.id_calltrack END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '4' THEN hc.id_calltrack END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '5' THEN hc.id_calltrack END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '6' THEN hc.id_calltrack END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '7' THEN hc.id_calltrack END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '8' THEN hc.id_calltrack END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '9' THEN hc.id_calltrack END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '10' THEN hc.id_calltrack END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '11' THEN hc.id_calltrack END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '12' THEN hc.id_calltrack END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '13' THEN hc.id_calltrack END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '14' THEN hc.id_calltrack END)) AS total_data_14,
					COUNT(distinct (case day(hc.call_date) when '15' then hc.id_calltrack end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '16' THEN hc.id_calltrack END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '17' THEN hc.id_calltrack END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '18' THEN hc.id_calltrack END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '19' THEN hc.id_calltrack END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '20' THEN hc.id_calltrack END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '21' THEN hc.id_calltrack END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '22' THEN hc.id_calltrack END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '23' THEN hc.id_calltrack END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '24' THEN hc.id_calltrack END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '25' THEN hc.id_calltrack END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '26' THEN hc.id_calltrack END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '27' THEN hc.id_calltrack END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '28' THEN hc.id_calltrack END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '29' THEN hc.id_calltrack END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '30' THEN hc.id_calltrack END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '31' THEN hc.id_calltrack END)) AS total_data_31
					from hdr_calltrack hc
					inner join hdr_debtor_main_inventory hdm on hdm.primary_1 = hc.primary_1 and MONTH(hdm.data_date) = '$month' AND YEAR(hdm.data_date) = '$year'
					and hdm.valdo_cc = '$location' $where2
					inner join hdr_user hu on hu.id_user = hc.id_user $where
					where MONTH(hc.call_date) = '$month' AND YEAR(hc.call_date) = '$year' and hc.ptp_status = '2' AND hc.id_handling_code = '02' $where3 ";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function daily_report10($month,$year,$location,$leader,$branch,$dc) {

		if($leader == 'All'){
			$where = "";
		} else {
			$where = "and hu.id_leader = '$leader'";
		}

		if($branch == 'All'){
			$where2 = "";
		} else {
			$where2 = "and hdm.kode_cabang = '$branch'";
		}

		if($dc == 'All'){
			$where3 = "";
		} else {
			$where3 = "and hc.id_user = '$dc'";
		}

		$sql = "select
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '1' THEN hc.id_calltrack END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '2' THEN hc.id_calltrack END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '3' THEN hc.id_calltrack END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '4' THEN hc.id_calltrack END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '5' THEN hc.id_calltrack END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '6' THEN hc.id_calltrack END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '7' THEN hc.id_calltrack END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '8' THEN hc.id_calltrack END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '9' THEN hc.id_calltrack END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '10' THEN hc.id_calltrack END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '11' THEN hc.id_calltrack END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '12' THEN hc.id_calltrack END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '13' THEN hc.id_calltrack END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '14' THEN hc.id_calltrack END)) AS total_data_14,
					COUNT(distinct (case day(hc.call_date) when '15' then hc.id_calltrack end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '16' THEN hc.id_calltrack END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '17' THEN hc.id_calltrack END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '18' THEN hc.id_calltrack END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '19' THEN hc.id_calltrack END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '20' THEN hc.id_calltrack END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '21' THEN hc.id_calltrack END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '22' THEN hc.id_calltrack END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '23' THEN hc.id_calltrack END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '24' THEN hc.id_calltrack END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '25' THEN hc.id_calltrack END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '26' THEN hc.id_calltrack END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '27' THEN hc.id_calltrack END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '28' THEN hc.id_calltrack END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '29' THEN hc.id_calltrack END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '30' THEN hc.id_calltrack END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '31' THEN hc.id_calltrack END)) AS total_data_31
					from hdr_calltrack hc
					inner join hdr_debtor_main_inventory hdm on hdm.primary_1 = hc.primary_1 and MONTH(hdm.data_date) = '$month' AND YEAR(hdm.data_date) = '$year'
					and hdm.valdo_cc = '$location' $where2
					inner join hdr_user hu on hu.id_user = hc.id_user $where
					where MONTH(hc.call_date) = '$month' AND YEAR(hc.call_date) = '$year' AND hc.id_call_cat='2' $where3";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function daily_report11($month,$year,$location,$leader,$branch,$dc) {

		if($leader == 'All'){
			$where = "";
		} else {
			$where = "and hu.id_leader = '$leader'";
		}

		if($branch == 'All'){
			$where2 = "";
		} else {
			$where2 = "and hdm.kode_cabang = '$branch'";
		}

		if($dc == 'All'){
			$where3 = "";
		} else {
			$where3 = "and hc.id_user = '$dc'";
		}

		$sql = "select hc.call_date,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '1' THEN hc.id_calltrack END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '2' THEN hc.id_calltrack END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '3' THEN hc.id_calltrack END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '4' THEN hc.id_calltrack END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '5' THEN hc.id_calltrack END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '6' THEN hc.id_calltrack END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '7' THEN hc.id_calltrack END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '8' THEN hc.id_calltrack END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '9' THEN hc.id_calltrack END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '10' THEN hc.id_calltrack END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '11' THEN hc.id_calltrack END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '12' THEN hc.id_calltrack END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '13' THEN hc.id_calltrack END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '14' THEN hc.id_calltrack END)) AS total_data_14,
					COUNT(distinct (case day(hdm.data_date) when '15' then hc.id_calltrack end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '16' THEN hc.id_calltrack END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '17' THEN hc.id_calltrack END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '18' THEN hc.id_calltrack END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '19' THEN hc.id_calltrack END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '20' THEN hc.id_calltrack END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '21' THEN hc.id_calltrack END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '22' THEN hc.id_calltrack END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '23' THEN hc.id_calltrack END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '24' THEN hc.id_calltrack END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '25' THEN hc.id_calltrack END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '26' THEN hc.id_calltrack END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '27' THEN hc.id_calltrack END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '28' THEN hc.id_calltrack END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '29' THEN hc.id_calltrack END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '30' THEN hc.id_calltrack END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '31' THEN hc.id_calltrack END)) AS total_data_31
					from hdr_calltrack hc
					inner join hdr_debtor_main_inventory hdm on hdm.primary_1 = hc.primary_1 and month(hdm.data_date) = '$month' and year(hdm.data_date) = '$year'
					$where2
					inner join hdr_user hu on hu.id_user = hc.id_user $where
					WHERE hdm.is_new = '1' and hdm.last_handling_date = '0000-00-00' and hdm.valdo_cc = '$location' and month(hc.call_date) = '$month' and year(hc.call_date) = '$year' $where3";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function daily_report12($month,$year,$location,$leader,$branch,$dc) {

		if($leader == 'All'){
			$where = "";
		} else {
			$where = "and hu.id_leader = '$leader'";
		}

		if($branch == 'All'){
			$where2 = "";
		} else {
			$where2 = "and hdm.kode_cabang = '$branch'";
		}

		if($dc == 'All'){
			$where3 = "";
		} else {
			$where3 = "and hc.id_user = '$dc'";
		}

		$sql = "select hc.call_date,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '1' THEN hc.id_calltrack END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '2' THEN hc.id_calltrack END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '3' THEN hc.id_calltrack END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '4' THEN hc.id_calltrack END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '5' THEN hc.id_calltrack END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '6' THEN hc.id_calltrack END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '7' THEN hc.id_calltrack END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '8' THEN hc.id_calltrack END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '9' THEN hc.id_calltrack END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '10' THEN hc.id_calltrack END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '11' THEN hc.id_calltrack END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '12' THEN hc.id_calltrack END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '13' THEN hc.id_calltrack END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '14' THEN hc.id_calltrack END)) AS total_data_14,
					COUNT(distinct (case day(hdm.data_date) when '15' then hc.id_calltrack end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '16' THEN hc.id_calltrack END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '17' THEN hc.id_calltrack END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '18' THEN hc.id_calltrack END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '19' THEN hc.id_calltrack END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '20' THEN hc.id_calltrack END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '21' THEN hc.id_calltrack END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '22' THEN hc.id_calltrack END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '23' THEN hc.id_calltrack END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '24' THEN hc.id_calltrack END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '25' THEN hc.id_calltrack END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '26' THEN hc.id_calltrack END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '27' THEN hc.id_calltrack END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '28' THEN hc.id_calltrack END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '29' THEN hc.id_calltrack END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '30' THEN hc.id_calltrack END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '31' THEN hc.id_calltrack END)) AS total_data_31
					from hdr_calltrack hc
					inner join hdr_debtor_main_inventory hdm on hdm.primary_1 = hc.primary_1 and month(hdm.data_date) = '$month' and year(hdm.data_date) = '$year'
					$where2
					inner join hdr_user hu on hu.id_user = hc.id_user $where
					WHERE hdm.is_new = '1' and hdm.last_handling_date = '0000-00-00' and hdm.valdo_cc = '$location' AND hc.id_call_cat='1' and month(hc.call_date) = '$month' and year(hc.call_date) = '$year' $where3 ";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function daily_report13($month,$year,$location,$leader,$branch,$dc) {

		if($leader == 'All'){
			$where = "";
		} else {
			$where = "and hu.id_leader = '$leader'";
		}

		if($branch == 'All'){
			$where2 = "";
		} else {
			$where2 = "and hdm.kode_cabang = '$branch'";
		}

		if($dc == 'All'){
			$where3 = "";
		} else {
			$where3 = "and hc.id_user = '$dc'";
		}

		$sql = "select hc.call_date,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '1' THEN hc.id_calltrack END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '2' THEN hc.id_calltrack END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '3' THEN hc.id_calltrack END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '4' THEN hc.id_calltrack END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '5' THEN hc.id_calltrack END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '6' THEN hc.id_calltrack END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '7' THEN hc.id_calltrack END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '8' THEN hc.id_calltrack END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '9' THEN hc.id_calltrack END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '10' THEN hc.id_calltrack END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '11' THEN hc.id_calltrack END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '12' THEN hc.id_calltrack END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '13' THEN hc.id_calltrack END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '14' THEN hc.id_calltrack END)) AS total_data_14,
					COUNT(distinct (case day(hdm.data_date) when '15' then hc.id_calltrack end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '16' THEN hc.id_calltrack END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '17' THEN hc.id_calltrack END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '18' THEN hc.id_calltrack END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '19' THEN hc.id_calltrack END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '20' THEN hc.id_calltrack END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '21' THEN hc.id_calltrack END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '22' THEN hc.id_calltrack END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '23' THEN hc.id_calltrack END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '24' THEN hc.id_calltrack END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '25' THEN hc.id_calltrack END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '26' THEN hc.id_calltrack END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '27' THEN hc.id_calltrack END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '28' THEN hc.id_calltrack END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '29' THEN hc.id_calltrack END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '30' THEN hc.id_calltrack END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '31' THEN hc.id_calltrack END)) AS total_data_31
					from hdr_calltrack hc
					inner join hdr_debtor_main_inventory hdm on hdm.primary_1 = hc.primary_1 and month(hdm.data_date) = '$month' and year(hdm.data_date) = '$year'
					$where2
					inner join hdr_user hu on hu.id_user = hc.id_user $where
					WHERE hdm.is_new = '1' and hdm.last_handling_date = '0000-00-00' and hdm.valdo_cc = '$location' and hc.id_handling_code = '02' AND hc.ptp_date IS NOT NULL AND hc.ptp_date != '0000-00-00' and month(hc.call_date) = '$month' and year(hc.call_date) = '$year' $where3";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function daily_report14($month,$year,$location,$leader,$branch,$dc) {

		if($leader == 'All'){
			$where = "";
		} else {
			$where = "and hu.id_leader = '$leader'";
		}

		if($branch == 'All'){
			$where2 = "";
		} else {
			$where2 = "and hdm.kode_cabang = '$branch'";
		}

		if($dc == 'All'){
			$where3 = "";
		} else {
			$where3 = "and hc.id_user = '$dc'";
		}

		$sql = "select hc.call_date,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '1' THEN hc.id_calltrack END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '2' THEN hc.id_calltrack END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '3' THEN hc.id_calltrack END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '4' THEN hc.id_calltrack END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '5' THEN hc.id_calltrack END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '6' THEN hc.id_calltrack END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '7' THEN hc.id_calltrack END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '8' THEN hc.id_calltrack END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '9' THEN hc.id_calltrack END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '10' THEN hc.id_calltrack END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '11' THEN hc.id_calltrack END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '12' THEN hc.id_calltrack END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '13' THEN hc.id_calltrack END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '14' THEN hc.id_calltrack END)) AS total_data_14,
					COUNT(distinct (case day(hdm.data_date) when '15' then hc.id_calltrack end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '16' THEN hc.id_calltrack END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '17' THEN hc.id_calltrack END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '18' THEN hc.id_calltrack END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '19' THEN hc.id_calltrack END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '20' THEN hc.id_calltrack END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '21' THEN hc.id_calltrack END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '22' THEN hc.id_calltrack END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '23' THEN hc.id_calltrack END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '24' THEN hc.id_calltrack END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '25' THEN hc.id_calltrack END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '26' THEN hc.id_calltrack END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '27' THEN hc.id_calltrack END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '28' THEN hc.id_calltrack END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '29' THEN hc.id_calltrack END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '30' THEN hc.id_calltrack END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '31' THEN hc.id_calltrack END)) AS total_data_31
					from hdr_calltrack hc
					inner join hdr_debtor_main_inventory hdm on hdm.primary_1 = hc.primary_1 and month(hdm.data_date) = '$month' and year(hdm.data_date) = '$year'
					$where2
					inner join hdr_user hu on hu.id_user = hc.id_user $where
					WHERE hdm.is_new = '1' and hdm.last_handling_date = '0000-00-00' and hdm.valdo_cc = '$location' and hc.ptp_status = '2' AND hc.id_handling_code = '02' and month(hc.call_date) = '$month' and year(hc.call_date) = '$year' $where3";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function daily_report15($month,$year,$location,$leader,$branch,$dc) {

		if($leader == 'All'){
			$where = "";
		} else {
			$where = "and hu.id_leader = '$leader'";
		}

		if($branch == 'All'){
			$where2 = "";
		} else {
			$where2 = "and hdm.kode_cabang = '$branch'";
		}

		if($dc == 'All'){
			$where3 = "";
		} else {
			$where3 = "and hc.id_user = '$dc'";
		}

		$sql = "select hc.call_date,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '1' THEN hc.id_calltrack END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '2' THEN hc.id_calltrack END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '3' THEN hc.id_calltrack END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '4' THEN hc.id_calltrack END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '5' THEN hc.id_calltrack END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '6' THEN hc.id_calltrack END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '7' THEN hc.id_calltrack END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '8' THEN hc.id_calltrack END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '9' THEN hc.id_calltrack END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '10' THEN hc.id_calltrack END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '11' THEN hc.id_calltrack END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '12' THEN hc.id_calltrack END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '13' THEN hc.id_calltrack END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '14' THEN hc.id_calltrack END)) AS total_data_14,
					COUNT(distinct (case day(hdm.data_date) when '15' then hc.id_calltrack end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '16' THEN hc.id_calltrack END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '17' THEN hc.id_calltrack END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '18' THEN hc.id_calltrack END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '19' THEN hc.id_calltrack END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '20' THEN hc.id_calltrack END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '21' THEN hc.id_calltrack END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '22' THEN hc.id_calltrack END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '23' THEN hc.id_calltrack END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '24' THEN hc.id_calltrack END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '25' THEN hc.id_calltrack END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '26' THEN hc.id_calltrack END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '27' THEN hc.id_calltrack END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '28' THEN hc.id_calltrack END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '29' THEN hc.id_calltrack END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '30' THEN hc.id_calltrack END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hdm.data_date) WHEN '31' THEN hc.id_calltrack END)) AS total_data_31
					from hdr_calltrack hc
					inner join hdr_debtor_main_inventory hdm on hdm.primary_1 = hc.primary_1 and month(hdm.data_date) = '$month' and year(hdm.data_date) = '$year'
					$where2
					inner join hdr_user hu on hu.id_user = hc.id_user $where
					WHERE hdm.is_new = '1' and hdm.last_handling_date = '0000-00-00' and hdm.valdo_cc = '$location' AND hc.id_call_cat='2' and month(hc.call_date) = '$month' and year(hc.call_date) = '$year' $where3";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function daily_report16($month,$year,$location,$leader,$branch,$dc) {

		if($leader == 'All'){
			$where = "";
		} else {
			$where = "and hu.id_leader = '$leader'";
		}

		if($branch == 'All'){
			$where2 = "";
		} else {
			$where2 = "and hc.kode_cabang = '$branch'";
		}

		if($dc == 'All'){
			$where3 = "";
		} else {
			$where3 = "and hc.id_user = '$dc'";
		}

		$sql = "select
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '1' THEN hc.id_user END)) AS total_data_1,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '2' THEN hc.id_user END)) AS total_data_2,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '3' THEN hc.id_user END)) AS total_data_3,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '4' THEN hc.id_user END)) AS total_data_4,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '5' THEN hc.id_user END)) AS total_data_5,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '6' THEN hc.id_user END)) AS total_data_6,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '7' THEN hc.id_user END)) AS total_data_7,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '8' THEN hc.id_user END)) AS total_data_8,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '9' THEN hc.id_user END)) AS total_data_9,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '10' THEN hc.id_user END)) AS total_data_10,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '11' THEN hc.id_user END)) AS total_data_11,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '12' THEN hc.id_user END)) AS total_data_12,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '13' THEN hc.id_user END)) AS total_data_13,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '14' THEN hc.id_user END)) AS total_data_14,
					COUNT(distinct (case day(hc.call_date) when '15' then hc.id_user end)) as total_data_15,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '16' THEN hc.id_user END)) AS total_data_16,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '17' THEN hc.id_user END)) AS total_data_17,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '18' THEN hc.id_user END)) AS total_data_18,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '19' THEN hc.id_user END)) AS total_data_19,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '20' THEN hc.id_user END)) AS total_data_20,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '21' THEN hc.id_user END)) AS total_data_21,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '22' THEN hc.id_user END)) AS total_data_22,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '23' THEN hc.id_user END)) AS total_data_23,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '24' THEN hc.id_user END)) AS total_data_24,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '25' THEN hc.id_user END)) AS total_data_25,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '26' THEN hc.id_user END)) AS total_data_26,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '27' THEN hc.id_user END)) AS total_data_27,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '28' THEN hc.id_user END)) AS total_data_28,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '29' THEN hc.id_user END)) AS total_data_29,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '30' THEN hc.id_user END)) AS total_data_30,
					COUNT(DISTINCT (CASE DAY(hc.call_date) WHEN '31' THEN hc.id_user END)) AS total_data_31
					from hdr_user hu
					inner join hdr_calltrack hc on hc.id_user = hu.id_user $where2
					where MONTH(hc.call_date) = '$month' AND YEAR(hc.call_date) = '$year' $where $where3";


		$query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;

		}
		public function call_total_report($fromdate,$enddate) {
			//die($fromdate." to ".$enddate);


		$sql = "SELECT
					COUNT(DISTINCT hc.primary_1) AS total,
					COUNT(CASE hac.id_call_cat WHEN '1' THEN hc.primary_1 END) AS contact,
					COUNT(CASE hc.ptp_status WHEN '1' THEN hc.primary_1 END) AS ptp,
					COUNT(CASE hc.ptp_status WHEN '0' THEN hc.primary_1 END) AS pk,
					COUNT(CASE hac.id_call_cat WHEN '2' THEN hc.primary_1 END) AS uncontact,
					COUNT(DISTINCT hc.primary_1) / (COUNT(DISTINCT hc.primary_1) - COUNT(CASE hdm.skip WHEN '1' THEN hc.primary_1 END) - COUNT(CASE hdm.not_ptp WHEN '1' THEN hc.primary_1 END)) AS intensity_datawork,
					COUNT(CASE hac.id_call_cat WHEN '1' THEN hc.primary_1 END) / COUNT(DISTINCT hc.primary_1) AS intensity_contact,
					COUNT(CASE hc.ptp_status WHEN '1' THEN hc.primary_1 END) / COUNT(CASE hac.id_call_cat WHEN '1' THEN hc.primary_1 END) AS intensity_ptp,
					COUNT(CASE hc.ptp_status WHEN '0' THEN hc.primary_1 END) / COUNT(CASE hc.ptp_status WHEN '1' THEN hc.primary_1 END) AS intensity_pk,
					COUNT(CASE hac.id_call_cat WHEN '2' THEN hc.primary_1 END) / COUNT(DISTINCT hc.primary_1) AS intensity_uncontact
					FROM `hdr_calltrack` hc
					INNER JOIN hdr_debtor_main_inventory hdm ON hdm.primary_1 = hc.primary_1
					INNER JOIN hdr_action_call_track hac ON hac.id_action_call_track = hc.id_action_call_track
					LEFT JOIN hdr_payment hp ON hp.primary_1 = hc.primary_1
					WHERE hc.call_date BETWEEN '$fromdate' AND '$enddate' ";


		/*$sql = "SELECT
					5000 as mentah,
					count(DISTINCT primary_1) as total,
					1000 as untouch,
					50 as skip,
					750 as active_on
					FROM `hdr_calltrack`
					WHERE month(call_date) = 10
					and year(call_date) = year(now()) ORDER BY `call_date` DESC  ";*/


        $query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;
		}
		public function call_untouch_report($fromdate,$enddate) {
			//die($fromdate." to ".$enddate);

		$sql = "SELECT
					COUNT(CASE hdm.last_handling_date WHEN '0000-00-00' THEN hc.id_calltrack END) AS total,
					COUNT(CASE hdm.last_handling_date WHEN '0000-00-00' THEN hc.primary_1 END) AS untouch,
					COUNT(CASE hac.id_call_cat WHEN '1' AND hdm.last_handling_date = '0000-00-00' THEN hc.primary_1 END) AS contact,
					COUNT(CASE hc.ptp_status WHEN '1' AND hdm.last_handling_date = '0000-00-00' THEN hc.primary_1 END) AS ptp,
					COUNT(CASE hc.ptp_status WHEN '0' AND hdm.last_handling_date = '0000-00-00' THEN hc.primary_1 END) AS pk,
					COUNT(CASE hac.id_call_cat WHEN '2' AND hdm.last_handling_date = '0000-00-00' THEN hc.primary_1 END) AS uncontact,
					COUNT(CASE hdm.last_handling_date WHEN '0000-00-00' THEN hc.primary_1 END) / COUNT(CASE hdm.last_handling_date WHEN '0000-00-00' THEN hc.primary_1 END) AS intensity_datauntouch,
					COUNT(CASE hdm.last_handling_date WHEN '0000-00-00' THEN hc.primary_1 END) / COUNT(DISTINCT hc.primary_1) AS intensity_datacall,
					COUNT(CASE hdm.last_handling_date WHEN '0000-00-00' THEN hc.primary_1 END) - COUNT(CASE hdm.last_handling_date WHEN '0000-00-00' THEN hc.primary_1 END) AS sisa_data,
					COUNT(CASE hac.id_call_cat WHEN '1' AND hdm.last_handling_date = '0000-00-00' THEN hc.primary_1 END) / COUNT(CASE hdm.last_handling_date WHEN '0000-00-00' THEN hc.primary_1 END) AS intensity_contact,
					COUNT(CASE hc.ptp_status WHEN '1' AND hdm.last_handling_date = '0000-00-00' THEN hc.primary_1 END) / COUNT(CASE hac.id_call_cat WHEN '1' AND hdm.last_handling_date = '0000-00-00' THEN hc.primary_1 END) AS intensity_ptp,
					COUNT(CASE hc.ptp_status WHEN '0' AND hdm.last_handling_date = '0000-00-00' THEN hc.primary_1 END) / COUNT(CASE hc.ptp_status WHEN '1' AND hdm.last_handling_date = '0000-00-00' THEN hc.primary_1 END) AS intensity_pk,
					COUNT(CASE hac.id_call_cat WHEN '2' AND hdm.last_handling_date = '0000-00-00' THEN hc.primary_1 END) / COUNT(CASE hdm.last_handling_date WHEN '0000-00-00' THEN hc.primary_1 END) AS intensity_uncontact
					FROM `hdr_calltrack` hc
					INNER JOIN hdr_debtor_main_inventory hdm ON hdm.primary_1 = hc.primary_1
					INNER JOIN hdr_action_call_track hac ON hac.id_action_call_track = hc.id_action_call_track
					LEFT JOIN hdr_payment hp ON hp.primary_1 = hc.primary_1
					WHERE hc.call_date BETWEEN '$fromdate' AND '$enddate' AND hdm.last_handling_date = '0000-00-00' ";


        $query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;
		}
		public function call_average_report($fromdate,$enddate) {
			//die($fromdate." to ".$enddate);

		$sql = "SELECT
					COUNT(DISTINCT hc.id_user) AS mpp,
					COUNT(DISTINCT hc.primary_1) / COUNT(DISTINCT hc.id_user) AS avg_call,
					COUNT(CASE hac.id_call_cat WHEN '1' THEN hc.primary_1 END) / COUNT(DISTINCT hc.id_user) AS avg_contact,
					COUNT(CASE hc.ptp_status WHEN '1' THEN hc.primary_1 END) / COUNT(DISTINCT hc.id_user) AS avg_ptp,
					COUNT(CASE hc.ptp_status WHEN '0' THEN hc.primary_1 END) / COUNT(DISTINCT hc.id_user) AS avg_pk
					FROM `hdr_calltrack` hc
					INNER JOIN hdr_debtor_main_inventory hdm ON hdm.primary_1 = hc.primary_1
					INNER JOIN hdr_action_call_track hac ON hac.id_action_call_track = hc.id_action_call_track
					WHERE hc.call_date BETWEEN '$fromdate' AND '$enddate' ";


        $query = $this->db->query($sql);
		$wo_total = $query->row_array();
        return $wo_total;
		}

  }

?>
