<?php
/*
This script software package is NOT FREE And is Copyright 2010 (C) Valdo all rights reserved.
we do supply help or support or further modification to this script by Contact
Haidar Mar'ie 
e-mail = coder5@ymail.com
*/
class Hdr_download_model extends Model {
    public function __construct() {
        parent::Model();
    }

    public function download_payment($begindate,$enddate) {
        //$group_bys = 'hdm.primary_1';
        $this->load->helper('csv');
        if($begindate!=""  ) {
            $bg = "WHERE hp.posting_date>='$begindate ' ";
        }else {
            $bg = " ";
        }
        if($enddate!="" ) {
            $ed = " AND hp.posting_date<='$enddate' ";
        }else {
            $ed = " ";
        }
        $sql = "SELECT primary_1 AS 'ACCOUNT NUMBER', trx_date AS 'TRX DATE', posting_date AS 'POSTING DATE', amount AS 'AMOUNT', description AS 'DESKRIPSI'
					FROM hdr_payment hp $bg $ed ORDER by hp.posting_date DESC";
        $query = $this->db->query($sql);
        //echo $sql;
        //echo  query_to_csv($query);
        $fileName = 'payment_'.date('Y_m_d_h_i_s').'.csv';
        query_to_csv($query, TRUE, $fileName);
    }
    public function download_call_track($begindate,$enddate) {
        //$group_bys = 'hdm.primary_1';
        $this->load->helper('csv');
        if($begindate!=""  ) {
            $bg = " hdc.call_date>='$begindate ' ";
        }else {
            $bg = " ";
        }
        if($enddate!="" ) {
            $ed = " AND hdc.call_date<='$enddate' ";
        }else {
            $ed = " ";
        }
        $file_now = date('Ymd-H_i_s').'.txt';
        $sql = "SELECT 'order_no','nama_cust', 'Korlap',  'Kolektor' ,
            'Risk Code' ,  'Bertemu',  'Lokasi',  'Action Code',
            'Action Date', 'Action Time', 'Reason Code',  'Next Action Code','PTP Date', 'PTP amount',	'New_phone_no', 'New_office_phone',
             'New_emergency_phone',  'New_HP', 'New_Address','New Pos code',
             'Memo'
		UNION
                    SELECT
              hdc.primary_1       AS 'order_no',
              hdc.cname           AS 'nama_cust',
              hdu.username        AS Korlap,
              hdc.username        AS Kolektor,
              IFNULL(hdc.id_risk_code,'') AS 'Risk Code',
              IFNULL(hdc.id_contact_code,'') AS 'Bertemu',
              IFNULL(hdc.id_location_code,'') AS 'Lokasi',
              hdc.code_call_track AS 'Action Code',
              DATE_FORMAT(hdc.call_date, '%Y%m%d') AS 'Action Date',
              DATE_FORMAT(hdc.call_time, '%H%i') AS 'Action Time',
              ''   AS 'Reason Code',
              ''   AS 'Next Action Code',
              IFNULL(DATE_FORMAT(hdc.ptp_date, '%Y%m%d'),'') AS 'PTP Date',
              IFNULL(hdc.ptp_amount,'') AS 'PTP amount',
              IFNULL(hdc.new_phone_number,'') AS 'New_phone_no',
              IFNULL(hdc.new_phone_number,'') AS 'New_office_phone',
              IFNULL(hdc.new_emergency_phone,'') AS 'New_emergency_phone',
              IFNULL(hdc.new_hp,'') AS 'New_HP',
              IFNULL(hdc.new_address,'') AS 'New_Address',
              IFNULL(hdc.new_pos_code,'')    'New Pos code',
              IFNULL(hdc.remarks,'') AS 'Memo'
            FROM hdr_calltrack AS hdc
              INNER JOIN hdr_user AS hdu
                ON hdc.id_spv = hdu.id_user
            WHERE
                $bg $ed
            INTO OUTFILE '/tmp/$file_now'
            FIELDS TERMINATED BY '|' LINES TERMINATED BY '\\r\\n' ; ";

        $query = $this->db->query($sql);
        //die($sql);
        $this->load->helper('download');
        $file_path = '/tmp/'.$file_now;
        $files_real = file_get_contents($file_path);
        force_download($file_now, $files_real);
        //return $query;
        //echo  query_to_csv($query);
//        $fileName = 'calltrack_'.date('Y_m_d_h_i_s').'.csv';
//        query_to_csv($query, TRUE, $fileName);
    }
    public function download_monitor_agen($type,$begindate,$enddate) {
        //$group_bys = 'hdm.primary_1';
        $this->load->helper('csv');
        if($type =='tgl_input') {
            $filter_by = 'date_in';
        }elseif($type =='visit_date') {
            $filter_by = 'visit_date';
        }
        if($begindate!=""  ) {
            $bg = "WHERE ham.$filter_by >='$begindate ' ";
        }else {
            $bg = " ";
        }
        if($enddate!="" ) {
            $ed = " AND ham.$filter_by <='$enddate' ";
        }else {
            $ed = " ";
        }
        $sql = "SELECT primary_1 AS 'ACCOUNT NUMBER', date_in AS 'TANGGAL INPUT', TIME AS 'TIME', visit_date AS 'TANGGAL VISIT', action_code AS 'ACTION CODE', ptp_date AS 'TANGGAL PTP', ptp_amount AS 'AMOUNT PTP', remark AS 'REMARK', username AS 'USER', agency AS 'AGENCY', coll_agency AS 'COLL AGENCY', id_user AS 'ID_USER' FROM hdr_agen_monitor ham $bg $ed ORDER by ham.date_in DESC";
        $query = $this->db->query($sql);
        //echo $sql;
        //echo  query_to_csv($query);
        $fileName = 'monitor_agen_'.date('Y_m_d_h_i_s').'.csv';
        query_to_csv($query, TRUE, $fileName);
    }
    public function download_visit_mg($begindate,$enddate) {
        //$group_bys = 'hdm.primary_1';
        $this->load->helper('csv');
        if($begindate!=""  ) {
            $bg = "WHERE ham.visit_date>='$begindate ' ";
        }else {
            $bg = " ";
        }
        if($enddate!="" ) {
            $ed = " AND ham.visit_date<='$enddate' ";
        }else {
            $ed = " ";
        }
        $sql = "SELECT primary_1 AS 'ACCOUNT NUMBER', date_in AS 'TANGGAL INPUT', TIME AS 'TIME', visit_date AS 'TANGGAL VISIT', action_code AS 'ACTION CODE', ptp_date AS 'TANGGAL PTP', ptp_amount AS 'AMOUNT PTP', remark AS 'REMARK', username AS 'USER', agency AS 'AGENCY', coll_agency AS 'COLL AGENCY', id_user AS 'ID_USER' FROM hdr_agen_monitor ham $bg $ed ORDER by ham.date_in DESC";
        $query = $this->db->query($sql);
        //echo $sql;
        //echo  query_to_csv($query);
        $fileName = 'monitor_agen_byvisit_'.date('Y_m_d_h_i_s').'.csv';
        query_to_csv($query, TRUE, $fileName);
    }
    public function download_active_agency($type,$begindate,$enddate) {
        //$group_bys = 'hdm.primary_1';
        $this->load->helper('csv');
        if($type =='tgl_serah') {
            $filter_by = 'date_in';
        }elseif($type =='tgl_tarik') {
            $filter_by = 'date_over';
        }elseif($type =='all') {
            $filter_by = 'date_over';
        }
        if($begindate!="" && $type !='all') {
            $bg = "WHERE haa.$filter_by>='$begindate ' ";
        }else {
            $bg = " ";
        }
        if($enddate!="" && $type !='all') {
            $ed = " AND haa.$filter_by<='$enddate' ";
        }else {
            $ed = " ";
        }
        $sql = "SELECT primary_1 AS 'ACCOUNT NUMBER', cycle AS 'CYCLE', bucket AS 'BUCKET SERAH', amount AS 'BALANCE SERAH', agency AS 'AGENCY', coll_agen AS 'COLL AGEN', date_in AS 'TGL SERAH', date_over AS 'TGL BERAKHIR', activated AS 'ACTIVATED' FROM hdr_active_agency haa $bg $ed ORDER by haa.date_in DESC";
        $query = $this->db->query($sql);
        //echo $sql;
        //echo  query_to_csv($query);
        $fileName = 'active_agency_'.date('Y_m_d_h_i_s').'.csv';
        query_to_csv($query, TRUE, $fileName);
    }

    public function download_reschedule() {
        //$group_bys = 'hdm.primary_1';
        $this->load->helper('csv');
        $sql = "SELECT primary_1 AS 'ACCOUNT NUMBER', resc_date AS 'TGL RESC', resc_bucket AS 'BUCKET RESC', resc_balance AS 'BALANCE RESC', dp AS 'DP', pv AS 'PV', tenor AS 'TENOR', interest AS 'BUNGA', cicilan AS 'CICILAN', payment_date AS 'TGL BAYAR', description AS 'KETERANGAN' FROM hdr_reschedule hr ORDER by hr.resc_date DESC";
        $query = $this->db->query($sql);
        //echo $sql;
        //echo  query_to_csv($query);
        $fileName = 'reschedule_'.date('Y_m_d_h_i_s').'.csv';
        query_to_csv($query, TRUE, $fileName);
    }

}
?>