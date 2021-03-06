<?php
/*
  This script software package is NOT FREE And is Copyright 2010 (C) Valdo-intl all rights reserved.
  we do supply help or support or further modification to this script by Contact
  Haidar Mar'ie
  e-mail = haidar.m@valdo-intl.com
  e-mail = coder5@ymail.com
 */
class Hdr_adm_report_ctrl extends Controller {

    public function __construct() {
        parent::Controller();
        if (@$_SESSION['blevel'] != 'admin') {
            redirect('login');
        }
        $this->load->model('hdr_debtor/hdr_debtor_model', 'debtor_model');
        $this->load->model('spv/hdr_report_spv_model', 'report_model');
        $this->load->model('user/hdr_call_track_model', 'call_track_model');
        $this->load->helper('flexigrid');
        $this->id_user = @$_SESSION["id_user"];
        $this->role = @$_SESSION["role"];
    }

    public function index() {

        $this->report();
    }

    public function report() {
        //$this->output->enable_profiler(TRUE);
        $this->load->model('admin/hdr_user_model', 'user_model');

        $data_t['title'] = 'Report Admin';
        //$data['text'] = 'Report';
       // $data['total_to_call'] = $this->report_model->total_to_call();

       // $id_user = $_SESSION['bid_user_s'];
       // $user_cond = "id_leader='" . $id_user . "'";

        //$data['report'] = $this->report_model->
        //$data['list_user'] = $this->user_model->get_list_user($user_cond);
        $this->load->view('admin/hdr_header_admin', $data_t);
        $this->load->view('admin/hdr_report_adm_view');
        $this->load->view('admin/hdr_footer');

    }

    public function sum_report() {
        //$this->output->enable_profiler(TRUE);
        echo '<script>notif.hide();</script>';
        $this->load->model('admin/hdr_user_model', 'user_model');
        $begin_uri = $this->uri->segment(4);
        $end_uri = $this->uri->segment(5);
        $begindate = $begin_uri == "" ? $begindate = date('Y-m-d') : $begindate = $begin_uri;
        $enddate = $begin_uri == "" ? $enddate = date('Y-m-d') : $enddate = $end_uri;
        $data['begindate'] = $begindate;
        $data['enddate'] = $enddate;
        $data['text'] = 'Report';
        $id_user = $_SESSION['bid_user_s'];
        $user_cond = $id_user != '22' ? "id_leader='" . $id_user . "'" : 'id_level="3" ';
       // $data['list_user'] = $this->user_model->get_list_user($user_cond);       
        $data['all_report'] = $this->report_model->status_call2($user="",$id_user="",$status="",$begindate,$enddate);        
        //$data['all_report2'] = $this->report_model->status_call_new($user="",$id_user="",$status="",$begindate,$enddate);
        //$data['all_report3'] = $this->report_model->status_call_new3($user="",$id_user="",$status="",$begindate,$enddate);
        $this->load->view('admin/hdr_sum_report_view', $data);
    }

    public function summary_details_dpd() {
        //hdr_details_dpd
        $this->load->model('spv/hdr_details_dpd_model', 'details_dpd');
        $id_user = $_SESSION['bid_user_s'];
        $begindate = date('Y-m-d');
        $beginmonth = date('Y-m-01');
        $enddate = date('Y-m-d');
        $endmonth = date('Y-m-31');
        $data['dpd_list'] = $this->details_dpd->dpd_list();
        //die("dorr");
        $this->load->view('spv/details/details_dpd_view', $data);
    }

    public function repair() {
        $this->load->model('spv/hdr_details_dpd_model', 'details_dpd');
        $this->details_dpd->repair_call();
        $this->details_dpd->reset_uncall();
        echo '<script>notif.hide();</script>';
        echo 'Database System has been repaired';
    }

    public function detial_dpd($id_action_call_track, $begindate, $enddate) {
        $data['pop_title'] = 'History Call Track';
        $this->load->helper('flexigrid');
        $id_user = $_SESSION['bid_user_s'];
        //$id_action_call_track ='All';
        //echo 'ctrl'.$begindate;
        $this->load->model('hdr/hdr_load_ajax_model', 'load_ajax');
        //echo $id_action_call_track.$id_user.$begindate.$enddate;
        $data = $this->load_ajax->get_history_user_call_track($id_action_call_track, $id_user, $begindate, $enddate);
        $data['text'] = "History Calltrack";
        $this->load->view('hdr/hdr_pop_up_view', $data);
    }

    public function detail_status($id_user, $status, $begindate, $enddate, $report) {
        //$this->output->enable_profiler(TRUE);
        $data['pop_title'] = 'Detail Cases';
        //$user = 'tc';
        $this->load->helper('flexigrid');
        $this->load->model('admin/hdr_user_model', 'user_model');
        $this->load->model('hdr/hdr_load_ajax_model', 'load_ajax');
        $data = $this->load_ajax->get_status_track($id_user, $status, $begindate, $enddate, $report);
        $data['text'] = "History Call Track";
        $data['user'] = $id_user;
        $data['id_user'] = $id_user;
        $data['status'] = $status;
        $data['begindate'] = $begindate;
        $data['enddate'] = $enddate;
        $data['report'] = $report;
        $this->load->view('spv/hdr_pop_up_report_view', $data);
    }

    public function report_to_csv($id_user, $status, $begindate, $enddate, $report) {
        //$this->output->enable_profiler("TRUE");
        if ($status == 'AC') {
            $this->report_model->report_to_csv($id_user);
        } elseif ($status == 'untc') {
            $this->report_model->report_to_untcsv($id_user);
        } else {
            $this->report_model->report_status_to_csv($id_user, $status, $begindate, $enddate, $report);
        }
    }
    public function attend($month){
        $this->report_model->attendance_report($month);
    }

}

?>