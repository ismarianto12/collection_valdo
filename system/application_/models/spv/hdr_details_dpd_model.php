<?php

  /*
    This script software package is NOT FREE And is Copyright 2010 (C) Valdo all rights reserved.
    we do supply help or support or further modification to this script by Contact
    Haidar Mar'ie
    e-mail = haidar.m@valdo-intl.com
    e-mail = coder5@ymail.com
   */

  class Hdr_details_dpd_model extends Model {

      public function __construct() {
          parent::Model();
          $this->CI = & get_instance();
      }

      public function dpd_all($dpd) {
          $sql = "SELECT COUNT(*) AS total_dpd1all FROM hdr_debtor_main WHERE dpd ='$dpd' ";
          $query = $this->db->query($sql);
          $dpd1all = $query->row();
          return $dpd1all->total_dpd1all;
      }

      public function dpd_list() {
          $sql = "SELECT dpd,COUNT(dpd) list ,
                      COUNT(DISTINCT CASE WHEN not_ptp = '0' AND dpd BETWEEN -4 AND 4  AND dpd !=0 THEN primary_1 END ) AS 'dpd_call',
                      COUNT(DISTINCT CASE WHEN not_ptp = '1' THEN primary_1 END ) AS 'dpd_out',
                      COUNT(DISTINCT CASE WHEN called = '1' THEN primary_1 END ) AS 'dpd_called',
                      COUNT(DISTINCT CASE WHEN called = '0' AND not_ptp = '0'  AND dpd BETWEEN 1 AND 4 THEN primary_1 END ) AS 'remaining',
                      COUNT(DISTINCT CASE WHEN called = '0' AND not_ptp = '0' AND shift = '1' THEN primary_1 END ) AS 'remaining_shift1',
                      COUNT(DISTINCT CASE WHEN called = '0' AND not_ptp = '0' AND shift = '2' THEN primary_1 END ) AS 'remaining_shift2',
                      COUNT(DISTINCT CASE WHEN shift = '1' THEN primary_1 END ) AS 'shift1',
                      COUNT(DISTINCT CASE WHEN shift = '2' THEN primary_1 END ) AS 'shift2'
            FROM hdr_debtor_main
            GROUP BY dpd ORDER BY dpd ASC";
          $this->db->cache_on();
          $query = $this->db->query($sql);
          $data = $query->result();
          return $data;
      }

      public function set_shift($shift, $dpd, $limit) {
          //die();
          $check_shift = "SELECT set_shift FROM hdr_set_shift WHERE dpd ='$dpd' AND date ='" . date_now() . "' and shift='$shift' ";
          //echo $check_shift;
          //echo 'dpd ke'. $dpd;
          $query_check = $this->db->query($check_shift);
          //$is_shfit = $query_check->set_shift;
          if ($query_check->num_rows() > 0) {
              $done = 'done!';
              return $done;
          } else {
              //die();
              $sql = "UPDATE hdr_debtor_main
                    SET shift ='$shift' WHERE  dpd ='$dpd' AND shift ='0' AND not_ptp='0'
                    LIMIT $limit";
              //echo $sql;
              $query = $this->db->query($sql);
              $this->set_db_shift($dpd, $shift);
              return $query;
          }
      }

      public function keep_promise() {
          $sql = "UPDATE hdr_calltrack  hdc
                  INNER JOIN hdr_debtor_main hdm ON hdm.primary_1 = hdc.primary_1
                  SET hdc.ptp_status = '2'
                  WHERE  hdc.ptp_status != '2' AND  hdc.id_action_call_track = '28' AND hdm.dpd=0
                  AND hdm.last_paid_date <= DATE_ADD( hdc.ptp_date, INTERVAL 1 DAY ) AND hdm.last_paid_date >= hdc.call_date;";
          $query = $this->db->query($sql);
          return $query;
      }

      public function set_shift2($dpd, $limit) {
          $sql = "UPDATE hdr_debtor_main
                SET shift ='2' WHERE  dpd ='$dpd'  AND shift ='0'  AND not_ptp='0'
                LIMIT $limit";
          $query = $this->db->query($sql);
          return $query;
      }

      public function set_db_shift($dpd, $shift) {
          $sql = "INSERT INTO hdr_set_shift  (dpd,set_shift,shift,date) VALUES ('" . $dpd . "','1','" . $shift . "','" . date_now() . "' )";
          $query = $this->db->query($sql);
          return $query;
      }

      public function dpd_call($dpd) {
          $sql = "SELECT COUNT(*) AS total_dpd_1call FROM hdr_debtor_main WHERE dpd ='$dpd'
            AND not_ptp ='0' ";
          $query = $this->db->query($sql);
          $dpd_1_call = $query->row();
          return $dpd_1_call->total_dpd_1call;
      }

      public function dpd_out($dpd) {
          $sql = "SELECT COUNT(*) AS total_dpd_out FROM hdr_debtor_main WHERE dpd ='$dpd'
            AND  not_ptp ='1'  ";
          $query = $this->db->query($sql);
          $dpd_1_call = $query->row();
          return $dpd_1_call->total_dpd_out;
      }

      public function total_all() {
          $sql = "SELECT COUNT(*) AS total_all FROM hdr_debtor_main WHERE call_status ='1'  ";
          $query = $this->db->query($sql);
          $dpd_1_call = $query->row();
          return $dpd_1_call->total_all;
      }

      public function total_call() {
          $sql = "SELECT COUNT(*) AS total_call FROM hdr_debtor_main WHERE call_status ='1'
           AND not_ptp='0' ";
          $query = $this->db->query($sql);
          $dpd_1_call = $query->row();
          return $dpd_1_call->total_call;
      }

      public function total_out() {
          $sql = "SELECT COUNT(*) AS total_out FROM hdr_debtor_main WHERE call_status ='1'
            AND not_ptp='1' ";
          $query = $this->db->query($sql);
          $dpd_1_call = $query->row();
          return $dpd_1_call->total_out;
      }

      public function repair_call() {
          $date_now = date('Y-m-d');
          $sql = "UPDATE hdr_debtor_main hdm
                    INNER JOIN hdr_calltrack hdc
                    ON hdm.primary_1 = hdc.primary_1
                    SET hdm.not_ptp = '1'
                    WHERE hdc.ptp_date >= '" . $date_now . "' AND hdc.id_action_call_track ='28'";
          $query = $this->db->query($sql);
          //echo $sql;
          $this->repair_call2();
          return $query;
      }

      public function repair_call2() {
          $date_now = date('Y-m-d');
          $sql = "UPDATE hdr_debtor_main hdm
                    INNER JOIN hdr_calltrack hdc
                    ON hdm.primary_1 = hdc.primary_1
                    SET hdm.not_ptp = '1'
                    WHERE hdc.call_date = '" . $date_now . "' ";
          $query = $this->db->query($sql);
          //echo $sql;
          return $query;
      }

      public function reset_uncall() {
	  /*
          $sql = "UPDATE hdr_debtor_main hdm
			SET hdm.in_use = '0', hdm.id_user='0'
			WHERE hdm.called='0'   ";
          $query = $this->db->query($sql);
	  */

      	  $sql = "update hdr_debtor_main set call_date=null where call_date is not null and valdo_cc='01'";
      	  $query = $this->db->query($sql);

      	  $sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.call_date=hc.call_date
			where hdm.valdo_cc='01' and hc.call_date=date(INTERVAL 0 DAY + now())
			and hdm.dpd in (-3,0)
			and hdm.primary_1=hc.primary_1
      	  ";
          $query = $this->db->query($sql);
          
          //reset
          $sql = "update hdr_debtor_main 
			set in_use=0,called=0,id_user=0
			where valdo_cc='01' and skip=0 and is_paid is null and call_date is null
			and hdm.dpd in (-3,0)		
          ";
          $query = $this->db->query($sql);

          return $query;
      }

  }

?>