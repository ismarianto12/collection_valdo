<?php

  /*
    This script software package is NOT FREE And is Copyright 2010 (C) Valdo-intl all rights reserved.
    we do supply help or support or further modification to this script by Contact
    Haidar Mar'ie
    e-mail = haidar.m@valdo-intl.com
    e-mail = coder5@ymail.com
   */

  if (!defined('BASEPATH'))
      exit('No direct script access allowed');

  class Hdr_ajax extends Controller {

      function __construct() {
          parent::Controller();
          $this->load->model('hdr_debtor/hdr_debtor_model');
          $this->load->library('flexigrid');
      }

      function index() {
          redirect('admin/hdr_ajax/get_data');
      }

      function get_data($filter_for) {

					die("d");
          //$this->output->enable_profiler(TRUE);

          $valid_fields = array('name', 'dpd', 'kode_cabang', 'debt_amount', 'due_date', 'area', 'id_card', 'dob', 'en_primary1', 'primary_1', 'due_date', 'home_address1', 'city', 'office_address1', 'company_name', 'billing_address', 'home_zip_code1', 'last_paid_date', 'last_paid_amount', 'last_trx_date', 'last_trx_amount', 'last_cast_adv_amount', 'email', 'date_in','category','product','product_flag','bucket_coll');
          $this->flexigrid->validate_post('due_date', 'asc', $valid_fields);
          $records = $this->hdr_debtor_model->all_debtor_flexi_view($filter_for);

          $this->output->set_header($this->config->item('json_header'));
          $i = 1;
          if ($records['records']->num_rows() > 0) {

              foreach ($records['records']->result() as $row) {
                  $record_items[] = array($row->en_primary1,
                      '<a target="_blank" href="' . site_url() . '/user/hdr_contact_cont/contact/call/' . $row->en_primary1 . '" >' . $row->en_primary1 . '</a>',
                      $row->name,
                      price_format($row->debt_amount),
                      $row->dpd,
                      date_formating($row->last_paid_date),
                      price_format($row->last_paid_amount),
                      date_formating($row->due_date),
                      $row->home_address1,
                      $row->branch,
                      $row->home_zip_code1,
                      $row->area,
                      $row->company_name,
                      $row->office_address1,
                      $row->billing_address,
                      $row->email,
                      $row->home_phone1,
                      date_formating($row->date_in),
                      $row->category,
                      $row->product,
					  $row->product_flag,
					  $row->bucket_coll
                  );
              }
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          } else {

              $record_items[] = array();
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          }
      }

      function get_hist_payment() {
          //$this->output->enable_profiler(TRUE);
          $primary_1 = $this->uri->segment(4);
          $valid_fields = array('primary_1',  'amount', 'update_date', 'description', 'trx_date', 'angsuran_ke');
          $this->flexigrid->validate_post('trx_date', 'DESC', $valid_fields);
//die("aa");
          $records = $this->hdr_debtor_model->all_debtor_hist_payment_flexi($primary_1);
          //var_dump($records);
          //die();
          $this->output->set_header($this->config->item('json_header'));
          $i = 1;
          if ($records['records']->num_rows() > 0) {

              foreach ($records['records']->result() as $row) {
                  $record_items[] = array($row->primary_1,
                      $i++,
                      //$row->en_primary1,
                      date_formating($row->trx_date),
                      date_formating2($row->update_date),
                      price_format($row->amount_pay),
                      $row->angsuran_ke,
                      $row->description,
                  );
              }
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          } else {
              $record_items[] = array();
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          }
      }

      function get_call_track($primary_1, $id_action_call_track) {
          //$this->output->enable_profiler(TRUE);
          $valid_fields = array('id_calltrack', 'primary_1', 'en_primary1', 'name', 'name AS name', 'username', 'remarks', 'call_date', 'call_time', 'code_call_track', 'ptp_date', 'ptp_amount', 'due_date', 'due_time');
          $this->flexigrid->validate_post('call_date', 'DESC', $valid_fields);
          //echo 'ajax'.$id_action_call_track;
          $id_user = $_SESSION['bid_user_s'];
          if ($id_action_call_track == 'rem') {
              $records = $this->hdr_debtor_model->all_debtor_hist_calltrack_rem_flexi($primary_1, $id_action_call_track, $id_user);
          } else {
              $records = $this->hdr_debtor_model->all_debtor_hist_calltrack_flexi($primary_1, $id_action_call_track, $id_user);
          }
          //$str = $this->db->last_query();
          //die($str);
          $this->output->set_header($this->config->item('json_header'));
          $i = 1;
          if ($records['records']->num_rows() > 0) {

              foreach ($records['records']->result() as $row) {
                  if ($id_action_call_track == 'ptp') {
                      //$call_code = $row->haccall_track==''?$row->hcall_code:$row->haccall_track;
                      $record_items[] = array($row->en_primary1,
                          $i++,
                          //$row->en_primary1,
                          '<a target="_blank" href="' . site_url() . '/user/hdr_contact_cont/contact/call/' . $row->en_primary1 . '" >' . $row->username . '</a>',
                          date_formating($row->call_date),
                          $row->call_time,
                          $row->code_call_track,
                          $row->remarks,
                          date_formating($row->ptp_date),
                          price_format($row->ptp_amount),
                      );
                  } elseif ($id_action_call_track == 'rem') {
                      $record_items[] = array($row->en_primary1,
                          $i++,
                          //$row->en_primary1,
                          '<a target="_blank" href="' . site_url() . '/user/hdr_contact_cont/contact/call/' . $row->en_primary1 . '" >' . $row->name . '</a>',
                          date_formating($row->call_date),
                          $row->call_time,
                          $row->code_call_track,
                          $row->remarks,
                          date_formating($row->due_date),
                          $row->due_time,
                      );
                  } else {
                      //$call_code = $row->haccall_track==''?$row->hcall_code:$row->haccall_track;
                      $record_items[] = array($row->en_primary1,
                          $i++,
                          //$row->en_primary1,
                          $row->username,
                          date_formating($row->call_date),
                          $row->call_time,
                          $row->code_call_track,
                          $row->remarks,
                          date_formating($row->ptp_date),
                          price_format($row->ptp_amount),
                      );
                  }
              }
              $this->output->set_output($this->flexigrid->json_build($records['records']->num_rows(), $record_items));
          } else {
              $record_items[] = array();
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          }
      }

      function get_user_call_track($id_action_call_track, $id_user, $begindate, $enddate) {
// 		$this->output->enable_profiler(TRUE);
          $valid_fields = array('id_calltrack', 'primary_1', 'hdc.primary_1', 'en_primary1', 'hdm.name', 'hdc.cname', 'username', 'remarks', 'call_date', 'call_time', 'hdc.code_call_track AS hcall_code', 'hcall_code', 'cdescrip', 'code_call_track', 'description as cdescrip', 'hac.code_call_track as haccall_track', 'haccall_track', 'ptp_date', 'ptp_amount', 'hdp.trx_date', 'hdp.amount', 'due_date', 'due_time');

          //$id_action_call_track = '';
          $id_user = $_SESSION['bid_user_s'];
          if ($id_action_call_track == 'keep' || $id_action_call_track == 'broken') {
              $this->flexigrid->validate_post('createdate', 'DESC', $valid_fields);
              $records = $this->hdr_debtor_model->all_debtor_hist_user_keep_broken_flexi($id_action_call_track, $id_user, $begindate, $enddate);
          } else {
              $this->flexigrid->validate_post('createdate', 'DESC', $valid_fields);
              $records = $this->hdr_debtor_model->all_debtor_hist_user_calltrack_flexi($id_action_call_track, $id_user, $begindate, $enddate);
          }
          $this->output->set_header($this->config->item('json_header'));
          $i = 1;
          if ($records['records']->num_rows() > 0) {

              foreach ($records['records']->result() as $row) {
                  if ($id_action_call_track == 'ptp') {
                      $call_code = @$row->haccall_track == '' ? $row->hcall_code : $row->haccall_track;
                      $record_items[] = array($row->en_primary1,
                          $i++,
                          '<a target="_blank" href="' . site_url() . '/user/hdr_contact_cont/contact/call/' . $row->en_primary1 . '" >' . $row->en_primary1 . '</a>',
                          $row->cname,
                          $call_code,
                          $row->remarks,
                          $row->username,
                          date_formating($row->call_date),
                          $row->call_time,
                          date_formating($row->ptp_date),
                          price_format($row->ptp_amount),
                      );
                  } elseif ($id_action_call_track == 'keep' || $id_action_call_track == 'broken') {
                      $call_code = $row->haccall_track == '' ? $row->hcall_code : $row->haccall_track;
                      $record_items[] = array($row->en_primary1,
                          $i++,
                          '<a target="_blank" href="' . site_url() . '/user/hdr_contact_cont/contact/call/' . $row->en_primary1 . '" >' . $row->en_primary1 . '</a>',
                          $row->cname,
                          $call_code,
                          $row->remarks,
                          $row->username,
                          date_formating($row->call_date),
                          $row->call_time,
                          date_formating($row->ptp_date),
                          price_format($row->ptp_amount),
                          date_formating($row->trx_date),
                          price_format($row->amount),
                      );
                  } elseif ($id_action_call_track == '52') {
                      $record_items[] = array($row->en_primary1,
                          $i++,
                          '<a target="_blank" href="' . site_url() . '/user/hdr_contact_cont/contact/call/' . $row->en_primary1 . '" >' . $row->en_primary1 . '</a>',
                          $row->cname,
                          $row->haccall_track,
                          $row->remarks,
                          $row->username,
                          date_formating($row->call_date),
                          $row->call_time,
                          date_formating($row->due_date),
                          $row->due_time,
                      );
                  } else {

                      $record_items[] = array($row->en_primary1,
                          $i++,
                          '<a target="_blank" href="' . site_url() . '/user/hdr_contact_cont/contact/call/' . $row->en_primary1 . '" >' . $row->en_primary1 . '</a>',
                          $row->cname,
                          $row->code_call_track,
                          $row->remarks,
                          $row->username,
                          date_formating($row->call_date),
                          $row->call_time,
                          date_formating($row->ptp_date),
                          price_format($row->ptp_amount),
                      );
                  }
              }
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          } else {
              $record_items[] = array();
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          }
      }

      function get_agen_track() {
          //$this->output->enable_profiler(TRUE);
          $primary_1 = $this->uri->segment(4);
          $valid_fields = array('id_agen_monitor', 'primary_1', 'en_primary1', 'date_in', 'time', 'visit_date', 'action_code', 'ptp_date', 'ptp_amount', 'remark', 'username', 'agency', 'coll_agency');
          $this->flexigrid->validate_post('createdate', 'DESC', $valid_fields);

          $records = $this->hdr_debtor_model->all_debtor_hist_agen_track_flexi($primary_1);
          $this->output->set_header($this->config->item('json_header'));
          $i = 1;
          if ($records['records']->num_rows() > 0) {

              foreach ($records['records']->result() as $row) {
                  $record_items[] = array($row->en_primary1,
                      $i++,
                      //$row->en_primary1,
                      $row->username,
                      date_formating($row->date_in),
                      $row->time,
                      date_formating($row->visit_date),
                      $row->action_code,
                      $row->remark,
                      date_formating($row->ptp_date),
                      price_format($row->ptp_amount),
                      $row->agency,
                      $row->coll_agency,
                  );
              }
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          } else {
              $record_items[] = array();
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          }
      }

      function get_reschedule() {
          //$this->output->enable_profiler(TRUE);
          $primary_1 = $this->uri->segment(4);
          $valid_fields = array('id_reschedule', 'primary_1', 'en_primary1', 'resc_date', 'resc_bucket', 'dp', 'pv', 'tenor', 'interest', 'cicilan', 'payment_date', 'description');
          $this->flexigrid->validate_post('id_reschedule', 'DESC', $valid_fields);

          $records = $this->hdr_debtor_model->all_debtor_hist_reschedule_flexi($primary_1);
          $this->output->set_header($this->config->item('json_header'));
          $i = 1;
          if ($records['records']->num_rows() > 0) {
              foreach ($records['records']->result() as $row) {
                  $record_items[] = array($row->en_primary1,
                      $row->id_reschedule,
                      $row->en_primary1,
                      $row->resc_date,
                      $row->resc_bucket,
                      price_format($row->dp),
                      price_format($row->pv),
                      $row->tenor,
                      $row->interest,
                      price_format($row->cicilan),
                      date_formating($row->payment_date),
                      $row->description,
                  );
              }
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          } else {
              $record_items[] = array();
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          }
      }

      function get_status_track($id_user, $status, $begindate, $enddate, $report) {
		//die($status);
          $this->load->model('spv/hdr_report_spv_model', 'report_model');
          $primary_1 = $this->uri->segment(4);
          $valid_fields = array('id_calltrack', 'ptp_stat', 'cptp_date', 'hdc.ptp_status', 'max_date', 'max_amount', 'en_primary1', 'mdpd','hdm.dpd', 'hdc.dpd', 'hdc.primary_1', 'hdc.cname', 'hdp.amount', 'hdp.trx_date', 'hdm.last_trx_amount', 'hdc.username', 'hdc.remarks', 'hdc.call_date', 'hdc.call_time', 'hdc.code_call_track', 'cdescrip', 'description', 'hdc.ptp_date', 'hdc.ptp_amount');

          $val_order = $status == 'untc' || $status == 'AC' ? $this->flexigrid->validate_post('hdc.createdate', 'DESC', $valid_fields) : $this->flexigrid->validate_post('hdc.id_calltrack', 'DESC', $valid_fields);
          $id_action_call_track = '1';
          if (preg_match('/(keep|broken|na)$/i', $status)) {

              $records = $this->report_model->list_ptp_flexi_status($id_user, $status, $begindate, $enddate, $report);
          } elseif ($status == 'untc') {

              $this->flexigrid->validate_post('hdm.date_in', 'DESC', $valid_fields);
              $records = $this->report_model->list_report_flexi_untouch($id_user);
          } elseif ($status == 'not_call') {

              $this->flexigrid->validate_post('hdm.date_in', 'DESC', $valid_fields);
              $records = $this->report_model->list_report_flexi_untouch($id_user);
          } else {
          	//die('aaa');
              $records = $this->report_model->list_report_flexi_status($id_user, $status, $begindate, $enddate, $report);
          }
          $this->output->set_header($this->config->item('json_header'));
          $i = 1;
          if ($records['records']->num_rows() > 0) {
          	//die('aaa');

              foreach ($records['records']->result() as $row) {
                  $record_items[] = array($row->en_primary_1,
                      $i++,
                      '<a target="_blank" href="' . site_url() . '/user/hdr_contact_cont/contact/call/' . $row->en_primary_1 . '" >' . $row->en_primary_1 . '</a>',
                      $row->cname,
                      $row->kode_cabang,
                      $row->hdctrack,
                      $row->no_contacted,
                      $row->remarks,
                      $user_all = $id_user == 'all' ? $row->username : '',
                      date_formating($row->call_date),
                      $row->call_time,
                      date_formating($row->cptp_date),
                      date_formating($row->max_date),
                      price_format($row->ptp_amount),
                      price_format($row->max_amount),
                      $row->dpd,
                      '<b>' . $row->mdpd . '</b>',
                      '<b>' . $row->ptp_stat . '</b>',
                      price_format($row->os_ar_amount)
                  );
              }
          }
          $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
      }


       function get_status_track_all($id_user, $status, $begindate, $enddate, $report) {
          $this->load->model('spv/hdr_report_spv_model', 'report_model');
          $primary_1 = $this->uri->segment(4);
          $valid_fields = array('id_calltrack', 'ptp_stat', 'cptp_date', 'hdc.ptp_status', 'max_date', 'max_amount', 'en_primary1', 'mdpd','hdm.dpd', 'hdc.dpd', 'hdc.primary_1', 'hdc.cname', 'hdp.amount', 'hdp.trx_date', 'hdm.last_trx_amount', 'hdc.username', 'hdc.remarks', 'hdc.call_date', 'hdc.call_time', 'hdc.code_call_track', 'cdescrip', 'description', 'hdc.ptp_date', 'hdc.ptp_amount');

          $val_order = $status == 'untc' || $status == 'AC' ? $this->flexigrid->validate_post('hdc.createdate', 'DESC', $valid_fields) : $this->flexigrid->validate_post('hdc.id_calltrack', 'DESC', $valid_fields);
          $id_action_call_track = '1';
          if (preg_match('/(keep|broken|na)$/i', $status)) {
          	//die('aaa');
              $records = $this->report_model->list_ptp_flexi_status_adm($id_user, $status, $begindate, $enddate, $report);
          } elseif ($status == 'untc') {

              $this->flexigrid->validate_post('hdm.date_in', 'DESC', $valid_fields);
              $records = $this->report_model->list_report_flexi_untouch($id_user);
          } elseif ($status == 'not_call') {

              $this->flexigrid->validate_post('hdm.date_in', 'DESC', $valid_fields);
              $records = $this->report_model->list_report_flexi_untouch($id_user);
          } else {
          	//die('aaa');
              $records = $this->report_model->list_report_flexi_status_adm($id_user, $status, $begindate, $enddate, $report);
          }
          $this->output->set_header($this->config->item('json_header'));
          $i = 1;
          if ($records['records']->num_rows() > 0) {
          	//die('aaa');

              foreach ($records['records']->result() as $row) {
                  $record_items[] = array($row->en_primary_1,
                      $i++,
                      '<a target="_blank" href="' . site_url() . '/user/hdr_contact_cont/contact/call/' . $row->en_primary_1 . '" >' . $row->en_primary_1 . '</a>',
                      $row->cname,
                      $row->kode_cabang,
                      $row->hdctrack,
                      $row->no_contacted,
                      $row->remarks,
                      $user_all = $id_user == 'all' ? $row->username : '',
                      date_formating($row->call_date),
                      $row->call_time,
                      date_formating($row->cptp_date),
                      date_formating($row->max_date),
                      price_format($row->ptp_amount),
                      price_format($row->max_amount),
                      $row->dpd,
                      '<b>' . $row->mdpd . '</b>',
                      '<b>' . $row->ptp_stat . '</b>',
                      price_format($row->os_ar_amount)
                  );
              }
          }
          $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
      }

      function get_status_track_all_spv($id_user, $status, $begindate, $enddate, $report) {
          $this->load->model('spv/hdr_report_spv_model', 'report_model');
          $primary_1 = $this->uri->segment(4);
          $valid_fields = array('id_calltrack', 'ptp_stat', 'cptp_date', 'hdc.ptp_status', 'max_date', 'max_amount', 'en_primary1', 'mdpd','hdm.dpd', 'hdc.dpd', 'hdc.primary_1', 'hdc.cname', 'hdp.amount', 'hdp.trx_date', 'hdm.last_trx_amount', 'hdc.username', 'hdc.remarks', 'hdc.call_date', 'hdc.call_time', 'hdc.code_call_track', 'cdescrip', 'description', 'hdc.ptp_date', 'hdc.ptp_amount');
//die("aa");
          $val_order = $status == 'untc' || $status == 'AC' ? $this->flexigrid->validate_post('hdc.createdate', 'DESC', $valid_fields) : $this->flexigrid->validate_post('hdc.id_calltrack', 'DESC', $valid_fields);
          $id_action_call_track = '1';
          if (preg_match('/(keep|broken|na)$/i', $status)) {
          	//die('aaa');
              $records = $this->report_model->list_ptp_flexi_status_spv($id_user, $status, $begindate, $enddate, $report);
          } elseif ($status == 'untc') {

              $this->flexigrid->validate_post('hdm.date_in', 'DESC', $valid_fields);
              $records = $this->report_model->list_report_flexi_untouch($id_user);
          } elseif ($status == 'not_call') {

              $this->flexigrid->validate_post('hdm.date_in', 'DESC', $valid_fields);
              $records = $this->report_model->list_report_flexi_untouch($id_user);
          } else {
          	//die('aaa');
              $records = $this->report_model->list_report_flexi_status_spv($id_user, $status, $begindate, $enddate, $report);
          }
          $this->output->set_header($this->config->item('json_header'));
          $i = 1;
          if ($records['records']->num_rows() > 0) {
          	//die('aaa');

              foreach ($records['records']->result() as $row) {
                  $record_items[] = array($row->en_primary_1,
                      $i++,
                      '<a target="_blank" href="' . site_url() . '/user/hdr_contact_cont/contact/call/' . $row->en_primary_1 . '" >' . $row->en_primary_1 . '</a>',
                      $row->cname,
                      $row->kode_cabang,
                      $row->hdctrack,
                      $row->no_contacted,
                      $row->remarks,
                      $user_all = $id_user == 'all' ? $row->username : '',
                      date_formating($row->call_date),
                      $row->call_time,
                      date_formating($row->cptp_date),
                      date_formating($row->max_date),
                      price_format($row->ptp_amount),
                      price_format($row->max_amount),
                      $row->dpd,
                      '<b>' . $row->mdpd . '</b>',
                      '<b>' . $row->ptp_stat . '</b>',
                      price_format($row->os_ar_amount)
                  );
              }
          } else {$record_items = "";}
          $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
      }

      function get_sta_track($begindate, $enddate, $report) {
          //$this->output->enable_profiler(TRUE);
          $this->load->model('spv/hdr_sta_model', 'sta_model');
          $primary_1 = $this->uri->segment(4);
          $valid_fields = array('en_primary_1', 'primary_1', 'date', 'username', 'id_user');

          $this->flexigrid->validate_post('hsta.date', 'DESC', $valid_fields);
          $id_action_call_track = '1';
          $records = $this->sta_model->list_sta_flexi($begindate, $enddate, $report);
          $this->output->set_header($this->config->item('json_header'));
          $i = 1;
          if ($records['records']->num_rows() > 0) {

              foreach ($records['records']->result() as $row) {
                  $record_items[] = array($row->en_primary_1,
                      $i++,
                      $row->en_primary_1,
                      $row->name,
                      $row->home_address1,
                      $row->home_zip_code1,
                      $row->company_name,
                      $row->office_address1,
                      $row->office_zip_code1,
                      $row->area,
                      date_formating($row->date),
                          //$ptp_dates = $status=='ptp' ||  $status=='ct' ||  $status=='acc' ?date_formating($row->ptp_date):'',
                          //$ptp_amounts = $status=='ptp' ||  $status=='ct' ||  $status=='acc' ?price_format($row->ptp_amount):''
                  );
              }

              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          } else {
              $record_items[] = array();
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          }
      }

      function get_sta_rtf() {
          //$this->output->enable_profiler(TRUE);
          $this->load->model('spv/hdr_sta_model', 'sta_model');
          $primary_1 = $this->uri->segment(4);
          $valid_fields = array('en_primary_1', 'primary_1', 'date', 'username', 'id_user');

          $this->flexigrid->validate_post('hsr.date_in', 'DESC', $valid_fields);
          $id_action_call_track = '1';
          $records = $this->sta_model->list_sta_rtf_flexi();
          $this->output->set_header($this->config->item('json_header'));
          $i = 1;
          if ($records['records']->num_rows() > 0) {

              foreach ($records['records']->result() as $row) {
                  $record_items[] = array($row->en_primary_1,
                      $i++,
                      $row->en_primary_1,
                      $row->card_no,
                      $row->name,
                      $row->cycle,
                      $row->bucket,
                      $row->amount,
                      $row->agency,
                      $row->coll_agen,
                      $row->date_in,
                      $row->date_over,
                      $row->activated,
                          //$user_all =$id_user=='all'?$row->username:''
                          //$ptp_dates = $status=='ptp' ||  $status=='ct' ||  $status=='acc' ?date_formating($row->ptp_date):'',
                          //$ptp_amounts = $status=='ptp' ||  $status=='ct' ||  $status=='acc' ?price_format($row->ptp_amount):''
                  );
              }

              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          } else {
              $record_items[] = array();
              $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
          }
      }

  }

?>