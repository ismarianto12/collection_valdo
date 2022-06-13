<?php
/*
This script software package is NOT FREE And is Copyright 2010 (C) Valdo all rights reserved.
we do supply help or support or further modification to this script by Contact
Haidar Mar'ie 
e-mail = coder5@ymail.com
*/
class Hdr_download_ctrl extends Controller{
	public function __construct(){
		parent::Controller();
		if(@$_SESSION['blevel']!='admin'){
			redirect('login');	
		}
		$this->load->model('admin/hdr_download_model', 'download_model');
		$this->load->model('hdr_debtor/hdr_debtor_model', 'debtor_model');
		//$this->load->helper('flexigrid');
		$this->id_user = @$_SESSION["id_user"];
		$this->role = @$_SESSION["role"];
	}
	public function index(){
		$this->download_payment();
	}
	public function download_payment($begindate,$enddate){
        $this->download_model->download_payment($begindate,$enddate);   
	}
	public function download_call_track($begindate,$enddate){
        $this->download_model->download_call_track($begindate,$enddate);   
	}
	public function download_monitor_agen($type,$begindate,$enddate){
        $this->download_model->download_monitor_agen($type,$begindate,$enddate);   
	}
	public function download_active_agency($type,$begindate,$enddate){
        $this->download_model->download_active_agency($type,$begindate,$enddate);   
	}
	public function download_reschedule(){
        $this->download_model->download_reschedule();   
	}
	
	
}
?>
