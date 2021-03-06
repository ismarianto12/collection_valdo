<?php

/*
  This script software package is NOT FREE And is Copyright 2010 (C) Valdo all rights reserved.
  we do supply help or support or further modification to this script by Contact
  Haidar Mar'ie
  e-mail = coder5@ymail.com
*/

class Hdr_load_ajax_model extends Model {

    private $username;
    private $primary_1;
    private $id_table;

    public function __construct() {
        parent::Model();
        $this->username = '70';
        $this->primary_1 = '85';
        $this->id_table = '35';
    }

     public function view_debtor($filter_for) {
        $colModel['primary_1'] = array('Account No', 75, TRUE, 'left', 1);
        $colModel['name'] = array('Name', 175, TRUE, 'left', 1);
        $colModel['debt_amount'] = array('Debt Amount', 80, TRUE, 'left', 1);
        $colModel['dpd'] = array('DPD', 80, TRUE, 'left', 1);
        $colModel['last_paid_date'] = array('Last Paid Date', 70, TRUE, 'left', 1);
        $colModel['last_paid_amount'] = array('Last Paid Amount', 70, TRUE, 'left', 1);
        $colModel['od_due_date'] = array('Due Date', 65, TRUE, 'left', 1);
        $colModel['home_address1'] = array('Home Address1', 350, TRUE, 'left', 1);
        $colModel['kode_cabang'] = array('Cabang', 100, TRUE, 'left', 1);
        $colModel['zip_code'] = array('Zip Code', 50, TRUE, 'left', 1, TRUE);
        $colModel['area'] = array('Area', 115, TRUE, 'left', 1, TRUE);
        $colModel['office_address1'] = array('Office Address1', 350, TRUE, 'left', 1, TRUE);
        $colModel['company_name'] = array('Company Name', 170, TRUE, 'left', 1, TRUE);
        $colModel['billing_address'] = array('Billing Address', 350, TRUE, 'left', 1, TRUE);
        $colModel['email'] = array('Email', 100, TRUE, 'left', 1, TRUE);
        $colModel['home_phone1'] = array('Home Phone1', 100, TRUE, 'left', 1, TRUE);
        $colModel['date_in'] = array('Date In', 60, TRUE, 'left', 1);
        $gridParams = array(
                'width' => '900',
                'height' => 400,
                'rp' => 40,
                'rpOptions' => '[10,15,20,25,40,50,100]',
                'pagestat' => 'Displaying: {from} to {to} of {total} Debtor',
                'nomsg' => 'No Debtor Found',
                //'blockOpacity' => 0.5,
                'singleSelect' => true,
                'showToggleBtn' => true,
                //'nowrap'=> false,
                'usepager' => true,
                'useRp' => true,
                'resizable' => FALSE, //resizable table
                'title' => '&nbsp;&nbsp;',
                'errormsg' => 'Connection Error',
                'showTableToggleBtn' => false
        );


        $post = @$_POST["post2"];
        $grid_js = build_grid_js('flex1', site_url("hdr/hdr_ajax/get_data/" . $filter_for), $colModel, 'od_due_date', 'asc', $gridParams);
        $data['js_grid'] = $grid_js;
        $data["txt_title"] = "View Debtor";
        return $data;
    }

    public function get_history_payment($primary_1, $name) {
        $colModel['id_payment'] = array('No', 30, TRUE, 'center', 0);
        //$colModel['primary_1'] = array('Account No',85, TRUE, 'left',1);
        $colModel['trx_date'] = array('TRX Date', 80, TRUE, 'left', 1);
        $colModel['update_date'] = array('Date Update', 100, TRUE, 'left', 1);
        $colModel['amount'] = array('Amount', 100, TRUE, 'left', 1);
        $colModel['angsuran_ke'] = array('Angsuran Ke', 100, TRUE, 'left', 1);
        $colModel['description'] = array('Description', 350, TRUE, 'left', 1);
        //$buttons[] = array('Contact','contact','test');
        $gridParams = array(
                'width' => '804',
                'height' => 300,
                'rp' => 25,
                'rpOptions' => '[10,15,20,25,40,50,100]',
                'pagestat' => 'Displaying: {from} to {to} of {total} Cases',
                'nomsg' => 'No Debtor Found',
                'blockOpacity' => 0.5,
                'singleSelect' => true,
                //'nowrap'=> false,
                'usepager' => true,
                'useRp' => true,
                'resizable' => FALSE, //resizable table
                'title' => '&nbsp;&nbsp;History Payment' . '&nbsp;&nbsp;' . base64_decode($name),
                'showTableToggleBtn' => FALSE
        );
        $buttons[] = array('Export', 'export_csv_tc', 'test');
        $grid_js = build_grid_js('flex1', site_url("hdr/hdr_ajax/get_hist_payment/" . $primary_1), $colModel, 'id_payment', 'asc', $gridParams, $buttons);
        $data['js_grid'] = $grid_js;
        return $data;
    }

    public function get_history_call_track($primary_1, $id_action_call_track, $name) {
        if ($id_action_call_track == 'ptp') {
            $title = 'History PTP &nbsp;&nbsp;' . base64_decode($name);
        } elseif ($id_action_call_track == 'rem') {
            $title = 'History All Reminder Debtor';
        } else {
            $title = 'History Call Track  &nbsp;&nbsp;' . base64_decode($name);
        }

        //echo 'model'.$id_action_call_track;
        $colModel['id_calltrack'] = array('No', 30, TRUE, 'center', 0);
        //$colModel['primary_1'] = array('Account No',85, TRUE, 'left',0);
        $names = $id_action_call_track == 'rem' ? $colModel['name'] = array('Name', 200, TRUE, 'left', 0) : $colModel['username'] = array('User Name', $this->username, TRUE, 'left', 1);
        $colModel['call_date'] = array('Call Date', 55, TRUE, 'left', 1);
        $colModel['call_time'] = array('Call Time', 55, TRUE, 'left', 1);
        $colModel['code_call_track'] = array('Code Call Track', 80, TRUE, 'left', 1);
        $colModel['remarks'] = array('Call Remarks', 350, TRUE, 'left', 1);
        $due_date = $id_action_call_track == 'rem' ? $colModel['due_date'] = array('Due Date', 60, TRUE, 'left', 0) : $colModel['ptp_date'] = array('PTP date', 60, TRUE, 'right', 1);
        $due_time = $id_action_call_track == 'rem' ? $colModel['due_time'] = array('Due Time', 60, TRUE, 'left', 0) : $colModel['ptp_amount'] = array('PTP Amount', 60, TRUE, 'right', 1);
        $buttons[] = array('Export', 'export_csv_tc', 'test');
        $gridParams = array(
                'width' => '804',
                'height' => 300,
                'rp' => 25,
                'rpOptions' => '[10,15,20,25,40,50,100]',
                'pagestat' => 'Displaying: {from} to {to} of {total} Cases',
                'nomsg' => 'No Debtor Found',
                'blockOpacity' => 0.5,
                'singleSelect' => true,
                'nowrap' => false,
                'usepager' => true,
                'hideOnSubmit' => true,
                'autoload' => true,
                'showToggleBtn' => true,
                'useRp' => true,
                'resizable' => true, //resizable table
                'title' => '&nbsp;&nbsp;' . $title,
                'showTableToggleBtn' => FALSE
        );
        $grid_js = build_grid_js('flex1', site_url("hdr/hdr_ajax/get_call_track/" . $primary_1 . '/' . $id_action_call_track), $colModel, 'call_date', 'desc', $gridParams, $buttons);
        $data['js_grid'] = $grid_js;
        return $data;
    }

    public function get_history_user_call_track($id_action_call_track, $id_user, $begindate, $enddate) {
        //echo 'load'.$begindate;
        $id_user = $_SESSION['bid_user_s'];
        $username = $_SESSION['bsname_s'];
        $title = 'History Call Track &nbsp;&nbsp;' . $username;
        $colModel['id_calltrack'] = array('No', 30, TRUE, 'center', 0);
        $colModel['hdc.primary_1'] = array('Account No', 85, TRUE, 'left', 1);
        $colModel['hdc.cname'] = array('Name', 200, TRUE, 'left', 1);
        $colModel['hac.code_call_track'] = array('Code Call Track', 120, TRUE, 'left', 1);
        $colModel['call_remarks'] = array('Call Remarks', 350, TRUE, 'left', 1);
        $colModel['username'] = array('User Name', 100, TRUE, 'left', 1);
        $colModel['call_date'] = array('Call Date', 80, TRUE, 'left', 1);
        $colModel['call_time'] = array('Call Time', 85, TRUE, 'left', 1);

        $due_date = $id_action_call_track == '52' ? $colModel['due_date'] = array('Due Date', 200, TRUE, 'left', 0) : $colModel['ptp_date'] = array('PTP date', 85, TRUE, 'right', 1);
        $due_time = $id_action_call_track == '52' ? $colModel['due_time'] = array('Due Time', 200, TRUE, 'left', 0) : $colModel['ptp_amount'] = array('PTP Amount', 85, TRUE, 'right', 1);

        if ($id_action_call_track == 'keep' || $id_action_call_track == 'broken') {
            $colModel['trx_date'] = array('Last Paid date', 85, TRUE, 'right', 1);
            $colModel['amount'] = array('Last Paid Amount', 85, TRUE, 'right', 1);
        }
        //$buttons[] = array('Contact','contact','test');
        $gridParams = array(
                'width' => '804',
                'height' => 300,
                'rp' => 25,
                'rpOptions' => '[10,15,20,25,40,50,100]',
                'pagestat' => 'Displaying: {from} to {to} of {total} Cases',
                'nomsg' => 'No Debtor Found',
                'blockOpacity' => 0.5,
                'singleSelect' => true,
                'nowrap' => false,
                'usepager' => true,
                'hideOnSubmit' => true,
                'autoload' => true,
                'onSuccess' => false,
                'onError' => false,
                'showToggleBtn' => true,
                'errormsg' => 'Connection Error',
                'useRp' => true,
                'resizable' => true, //resizable table
                'title' => '&nbsp;&nbsp;' . $title,
                'showTableToggleBtn' => FALSE
        );
        if ($id_action_call_track == 'keep' || $id_action_call_track == 'broken') {
            $grid_js = build_grid_js('flex1', site_url("hdr/hdr_ajax/get_user_call_track/" . $id_action_call_track . '/' . $id_user . '/' . $begindate . '/' . $enddate), $colModel, 'id_calltrack', 'desc', $gridParams);
        } else {
            $grid_js = build_grid_js('flex1', site_url("hdr/hdr_ajax/get_user_call_track/" . $id_action_call_track . '/' . $id_user . '/' . $begindate . '/' . $enddate), $colModel, 'id_calltrack', 'desc', $gridParams);
        }
        $data['js_grid'] = $grid_js;
        return $data;
    }

    public function get_history_agen_track($primary_1, $name) {
        $colModel['id_agen_monitor'] = array('No', 30, TRUE, 'center', 0);
        //$colModel['primary_1'] = array('Account No',85, TRUE, 'left',1);
        $colModel['username'] = array('Username', 70, TRUE, 'right', 1);
        $colModel['date_in'] = array('Input Date', 90, TRUE, 'left', 1);
        $colModel['time'] = array('Time', 65, TRUE, 'left', 1);
        $colModel['visit_date'] = array('Visit Date', 80, TRUE, 'left', 1);
        $colModel['action_code'] = array('Action Code', 70, TRUE, 'left', 1);
        $colModel['remark'] = array('Remark', 185, TRUE, 'left', 1);
        $colModel['ptp_date'] = array('PTP Date', 70, TRUE, 'left', 1);
        $colModel['ptp_amount'] = array('PTP amount', 85, TRUE, 'right', 1);
        $colModel['agency'] = array('Agency', 75, TRUE, 'right', 1);
        $colModel['coll_agency'] = array('Coll Agency', 75, TRUE, 'right', 1);
        //$buttons[] = array('Contact','contact','test');
        $gridParams = array(
                'width' => '804',
                'height' => 300,
                'rp' => 25,
                'rpOptions' => '[10,15,20,25,40,50,100]',
                'pagestat' => 'Displaying: {from} to {to} of {total} Cases',
                'nomsg' => 'No Debtor Found',
                'blockOpacity' => 0.5,
                'singleSelect' => true,
                'nowrap' => false,
                'usepager' => true,
                'useRp' => true,
                'resizable' => FALSE, //resizable table
                'title' => '&nbsp;&nbsp;History Agen Call Track &nbsp;&nbsp;' . base64_decode($name),
                'showTableToggleBtn' => FALSE
        );
        $buttons[] = array('Export', 'export_csv_tc', 'test');
        $grid_js = build_grid_js('flex1', site_url("hdr/hdr_ajax/get_agen_track/" . $primary_1), $colModel, 'id_payment', 'asc', $gridParams, $buttons);
        $data['js_grid'] = $grid_js;
        return $data;
    }

    //Flexi View for SPV Report

    public function get_status_track($id_user, $status, $begindate, $enddate, $report) {
				
        $colModel['id_calltrack'] = array('No', 30, TRUE, 'center', 0);
        $colModel['hdc.primary_1'] = array('Account No', 80, TRUE, 'left', 1);
        $colModel['hdc.cname'] = array('Name', 160, TRUE, 'left', 1);
        $colModel['hdc.kode_cabang'] = array('Branch', 100, TRUE, 'left', 1);
        $colModel['hdc.code_call_track'] = array('Code', 30, TRUE, 'left', 1);
        $colModel['hdc.no_contacted'] = array('no_contacted', 160, TRUE, 'left', 1);
        $colModel['hdc.remarks'] = array('Call Remarks', 350, TRUE, 'left', 1);
        $user_all = $id_user == 'all' ? $colModel['hdc.username'] = array('User Name', 70, TRUE, 'left', 1) : $colModel['hdc.username'] = array('', 0, FALSE, 'left', 0);
        $colModel['hdc.call_date'] = array('Call Date', 50, TRUE, 'left', 1);
        $colModel['hdc.call_time'] = array('Call Time', 50, TRUE, 'left', 1);
        $colModel['cptp_date'] = array('PTP date', 50, TRUE, 'right', 1) ;
        $colModel['max_date'] = array('Last Paid ', 50, TRUE, 'right', 1) ;
        $colModel['hdc.ptp_amount'] = array('PTP Amount', 70, TRUE, 'right', 1) ;
        $colModel['max_amount'] = array('Last Paid ', 70, TRUE, 'right', 1) ;
        $colModel['hdc.dpd'] = array('DPD', 50, TRUE, 'right', 1) ;
        $colModel['hdm.dpd'] = array('DPD now', 50, TRUE, 'right', 1) ;
        $colModel['hdc.ptp_status'] = array('PTP Status', 60, TRUE, 'right', 1) ;
        $colModel['hdc.os_ar_amount'] = array('OS AR ', 70, TRUE, 'right', 1) ;

        if ($id_user != 'all') {
            $get_user = $this->user_model->get_list_user(' id_user ="' . $id_user . '"');
            $get_username = $get_user->row();
        }
        $gridParams = array(
                'width' => '804',
                'height' => 300,
                'rp' => 50,
                'rpOptions' => '[10,15,20,25,40,50,100]',
                'pagestat' => 'Displaying: {from} to {to} of {total} Cases',
                'nomsg' => 'No Debtor Found',
                'blockOpacity' => 0.5,
                'singleSelect' => true,
                'nowrap' => false,
                'usepager' => true,
                'useRp' => true,
                'resizable' => FALSE, //resizable table
                'showTableToggleBtn' => FALSE,
                'title' => '&nbsp;&nbsp;History Call Track ' . $usersn = $id_user == 'all' ? 'All User' : $get_username->username
        );
        $buttons[] = array('Export All', 'export_all', 'test');
        
        //die(site_url("hdr/hdr_ajax/get_status_track/" . $id_user . '/' . $status . '/' . $begindate . '/' . $enddate . '/' . $report));
        $grid_js = build_grid_js('flex1', site_url("hdr/hdr_ajax/get_status_track/" . $id_user . '/' . $status . '/' . $begindate . '/' . $enddate . '/' . $report), $colModel, 'createdate', 'desc', $gridParams, $buttons);
        //die($grid_js);
        $data['js_grid'] = $grid_js;
        //die();
        return $data;
    }
    
    public function get_status_track_all($id_user, $status, $begindate, $enddate, $report) {
				 //die();
        $colModel['id_calltrack'] = array('No', 30, TRUE, 'center', 0);
        $colModel['hdc.primary_1'] = array('Account No', 80, TRUE, 'left', 1);
        $colModel['hdc.cname'] = array('Name', 160, TRUE, 'left', 1);
        $colModel['hdc.kode_cabang'] = array('Branch', 100, TRUE, 'left', 1);
        $colModel['hdc.code_call_track'] = array('Code', 30, TRUE, 'left', 1);
        $colModel['hdc.no_contacted'] = array('no_contacted', 160, TRUE, 'left', 1);
        $colModel['hdc.remarks'] = array('Call Remarks', 350, TRUE, 'left', 1);
        $user_all = $id_user == 'all' ? $colModel['hdc.username'] = array('User Name', 70, TRUE, 'left', 1) : $colModel['hdc.username'] = array('', 0, FALSE, 'left', 0);
        $colModel['hdc.call_date'] = array('Call Date', 50, TRUE, 'left', 1);
        $colModel['hdc.call_time'] = array('Call Time', 50, TRUE, 'left', 1);
        $colModel['cptp_date'] = array('PTP date', 50, TRUE, 'right', 1) ;
        $colModel['max_date'] = array('Last Paid ', 50, TRUE, 'right', 1) ;
        $colModel['hdc.ptp_amount'] = array('PTP Amount', 70, TRUE, 'right', 1) ;
        $colModel['max_amount'] = array('Last Paid ', 70, TRUE, 'right', 1) ;
        $colModel['hdc.dpd'] = array('DPD', 50, TRUE, 'right', 1) ;
        $colModel['hdm.dpd'] = array('DPD now', 50, TRUE, 'right', 1) ;
        $colModel['hdc.ptp_status'] = array('PTP Status', 60, TRUE, 'right', 1) ;
        $colModel['hdc.os_ar_amount'] = array('OS AR ', 70, TRUE, 'right', 1) ;

        if ($id_user != 'all') {
            $get_user = $this->user_model->get_list_user(' id_user ="' . $id_user . '"');
            $get_username = $get_user->row();
        }
        $gridParams = array(
                'width' => '804',
                'height' => 300,
                'rp' => 50,
                'rpOptions' => '[10,15,20,25,40,50,100]',
                'pagestat' => 'Displaying: {from} to {to} of {total} Cases',
                'nomsg' => 'No Debtor Found',
                'blockOpacity' => 0.5,
                'singleSelect' => true,
                'nowrap' => false,
                'usepager' => true,
                'useRp' => true,
                'resizable' => FALSE, //resizable table
                'showTableToggleBtn' => FALSE,
                'title' => '&nbsp;&nbsp;History Call Track ' . $usersn = $id_user == 'all' ? 'All User' : $get_username->username
        );
        $buttons[] = array('Export All ADM', 'export_all', 'test');
        
        //die(site_url("hdr/hdr_ajax/get_status_track/" . $id_user . '/' . $status . '/' . $begindate . '/' . $enddate . '/' . $report));
        $grid_js = build_grid_js('flex1', site_url("hdr/hdr_ajax/get_status_track_all/" . $id_user . '/' . $status . '/' . $begindate . '/' . $enddate . '/' . $report), $colModel, 'createdate', 'desc', $gridParams, $buttons);
        //die($grid_js);
        $data['js_grid'] = $grid_js;
        //die();
        return $data;
    }
    
    public function get_status_track_all_spv($id_user, $status, $begindate, $enddate, $report) {
				 //die();
        $colModel['id_calltrack'] = array('No', 30, TRUE, 'center', 0);
        $colModel['hdc.primary_1'] = array('Account No', 80, TRUE, 'left', 1);
        $colModel['hdc.cname'] = array('Name', 160, TRUE, 'left', 1);
        $colModel['hdc.kode_cabang'] = array('Branch', 160, TRUE, 'left', 1);
        $colModel['hdc.code_call_track'] = array('Code', 30, TRUE, 'left', 1);
        $colModel['hdc.no_contacted'] = array('no_contacted', 160, TRUE, 'left', 1);
        $colModel['hdc.remarks'] = array('Call Remarks', 350, TRUE, 'left', 1);
        $user_all = $id_user == 'all' ? $colModel['hdc.username'] = array('User Name', 70, TRUE, 'left', 1) : $colModel['hdc.username'] = array('', 0, FALSE, 'left', 0);
        $colModel['hdc.call_date'] = array('Call Date', 50, TRUE, 'left', 1);
        $colModel['hdc.call_time'] = array('Call Time', 50, TRUE, 'left', 1);
        $colModel['cptp_date'] = array('PTP date', 50, TRUE, 'right', 1) ;
        $colModel['max_date'] = array('Last Paid ', 50, TRUE, 'right', 1) ;
        $colModel['hdc.ptp_amount'] = array('PTP Amount', 70, TRUE, 'right', 1) ;
        $colModel['max_amount'] = array('Last Paid ', 70, TRUE, 'right', 1) ;
        $colModel['hdc.dpd'] = array('DPD', 50, TRUE, 'right', 1) ;
        $colModel['hdm.dpd'] = array('DPD now', 50, TRUE, 'right', 1) ;
        $colModel['hdc.ptp_status'] = array('PTP Status', 60, TRUE, 'right', 1) ;
        $colModel['hdc.os_ar_amount'] = array('OS AR ', 70, TRUE, 'right', 1) ;

        if ($id_user != 'all') {
            $get_user = $this->user_model->get_list_user(' id_user ="' . $id_user . '"');
            $get_username = $get_user->row();
        }
        $gridParams = array(
                'width' => '804',
                'height' => 300,
                'rp' => 50,
                'rpOptions' => '[10,15,20,25,40,50,100]',
                'pagestat' => 'Displaying: {from} to {to} of {total} Cases',
                'nomsg' => 'No Debtor Found',
                'blockOpacity' => 0.5,
                'singleSelect' => true,
                'nowrap' => false,
                'usepager' => true,
                'useRp' => true,
                'resizable' => FALSE, //resizable table
                'showTableToggleBtn' => FALSE,
                'title' => '&nbsp;&nbsp;History Call Track ' . $usersn = $id_user == 'all' ? 'All User' : $get_username->username
        );
        $buttons[] = array('Export All SPV', 'export_all', 'test');
        
        //die(site_url("hdr/hdr_ajax/get_status_track/" . $id_user . '/' . $status . '/' . $begindate . '/' . $enddate . '/' . $report));
        $grid_js = build_grid_js('flex1', site_url("hdr/hdr_ajax/get_status_track_all_spv/" . $id_user . '/' . $status . '/' . $begindate . '/' . $enddate . '/' . $report), $colModel, 'createdate', 'desc', $gridParams, $buttons);
        //die($grid_js);
        $data['js_grid'] = $grid_js;
        //die();
        return $data;
    }

    public function get_sta_track($begindate, $enddate, $report) {
        $colModel['id_agen_monitor'] = array('No', 30, TRUE, 'center', 0);
        $colModel['primary_1'] = array('Account No', 85, TRUE, 'left', 1);
        $colModel['hdm.card_no'] = array('No Card', 115, TRUE, 'left', 1);
        $colModel['hdm.name'] = array('Name', 180, TRUE, 'left', 1);
        $colModel['hdm.cycle'] = array('Cycle', 45, TRUE, 'left', 1);
        $colModel['hdm.bucket_asccend'] = array('Bucket Asccend', 180, TRUE, 'left', 1);
        $colModel['hdm.credit_limit'] = array('Credit Limit', 180, TRUE, 'left', 1);
        $colModel['hdm.balance'] = array('Balance', 180, TRUE, 'left', 1);
        $colModel['hdm.home_address1'] = array('Home Address', 180, TRUE, 'left', 1);
        $colModel['hdm.home_zip_code1'] = array('Home Zip Code', 180, TRUE, 'left', 1);
        $colModel['hdm.company_name'] = array('Company Name', 180, TRUE, 'left', 1);
        $colModel['hdm.office_address1'] = array('Office Address', 180, TRUE, 'left', 1);
        $colModel['hdm.office_zip_code1'] = array('Office Zip Code', 180, TRUE, 'left', 1);
        $colModel['hdm.area'] = array('Area', 180, TRUE, 'left', 1);
        $colModel['hsta.date'] = array('Date', 65, TRUE, 'left', 1);
        //$colModel['ptp_date'] = array('PTP Date',70,TRUE,'left',1);
        //$colModel['ptp_amount'] = array('PTP amount',85, TRUE, 'right',1);
        //$colModel['remark'] = array('Remark',185, TRUE, 'left',1);
        //$buttons[] = array('Contact','contact','test');

        $gridParams = array(
                'width' => '804',
                'height' => 300,
                'rp' => 25,
                'rpOptions' => '[10,15,20,25,40,50,100]',
                'pagestat' => 'Displaying: {from} to {to} of {total} Cases',
                'nomsg' => 'No Debtor Found',
                'blockOpacity' => 0.5,
                'singleSelect' => false,
                'nowrap' => true,
                'usepager' => true,
                'useRp' => true,
                'resizable' => FALSE, //resizable table
                'title' => '&nbsp;&nbsp;Send To Agen ',
                'showTableToggleBtn' => FALSE
        );
        $buttons[] = array('Select All', 'select_all', 'test');
        $buttons[] = array('DeSelect All', 'deselect_all', 'test');
        $buttons[] = array('Reject', 'reject', 'test');
        $buttons[] = array('Export CSV', 'export_all_csv', 'test');
        $grid_js = build_grid_js('flex1', site_url("hdr/hdr_ajax/get_sta_track/" . $begindate . '/' . $enddate . '/' . $report), $colModel, 'id_payment', 'asc', $gridParams, $buttons);
        $data['js_grid'] = $grid_js;
        return $data;
    }

    public function get_sta_rtf() {
        $colModel['id_agen_monitor'] = array('No', 30, TRUE, 'center', 0);
        $colModel['primary_1'] = array('Account No', 85, TRUE, 'left', 1);
        $colModel['hdm.card_no'] = array('No Card', 125, TRUE, 'left', 1);
        $colModel['hdm.name'] = array('Name', 180, TRUE, 'left', 1);
        $colModel['hdm.cycle'] = array('Cycle', 45, TRUE, 'left', 1);
        $colModel['hdm.bucket_serah'] = array('Bucket Asccend', 85, TRUE, 'left', 1);
        $colModel['hsp.balance_serah'] = array('Balance Serah', 85, TRUE, 'left', 1);
        $colModel['hsp.agency'] = array('Agency', 85, TRUE, 'left', 1);
        $colModel['hsp.coll_agen'] = array('Coll_agen', 85, TRUE, 'left', 1);
        $colModel['hsp.tgl_berakhir'] = array('Tgl berakhir', 85, TRUE, 'left', 1);
        $colModel['hsp.activated'] = array('Activated', 85, TRUE, 'left', 1);

        //$colModel['ptp_date'] = array('PTP Date',70,TRUE,'left',1);
        //$colModel['ptp_amount'] = array('PTP amount',85, TRUE, 'right',1);
        //$colModel['remark'] = array('Remark',185, TRUE, 'left',1);
        //$user_all = $id_user =='all'?$colModel['username'] = array('User Name',100,TRUE,'left',1):$colModel['username'] = array('',0,FALSE,'left',0,TRUE);
        //$buttons[] = array('Contact','contact','test');

        $gridParams = array(
                'width' => '804',
                'height' => 300,
                'rp' => 25,
                'rpOptions' => '[10,15,20,25,40,50,100]',
                'pagestat' => 'Displaying: {from} to {to} of {total} Cases',
                'nomsg' => 'No Debtor Found',
                'blockOpacity' => 0.5,
                'singleSelect' => false,
                'nowrap' => true,
                'usepager' => true,
                'useRp' => true,
                'resizable' => FALSE, //resizable table
                'title' => '&nbsp;&nbsp;Send To Agen ',
                'showTableToggleBtn' => FALSE
        );
        $buttons[] = array('Select All', 'select_all', 'test');
        $buttons[] = array('DeSelect All', 'deselect_all', 'test');
        $buttons[] = array('Reject', 'reject', 'test');
        $buttons[] = array('Export RTF', 'export_all_pdf', 'test');
        $grid_js = build_grid_js('flex1', site_url("hdr/hdr_ajax/get_sta_rtf/"), $colModel, 'id_sta_rtf', 'asc', $gridParams, $buttons);
        $data['js_grid'] = $grid_js;
        return $data;
    }

}
?>