<?php
class Hdr_export_csv_ctrl extends Controller{
	public function __construct(){
		parent::Controller();
		$this->load->model('user/hdr_call_track_model','call_track_model');
		if(@$_SESSION['blevel']!='user'){
			redirect('login');	
		}
	}
	public function index(){
		//$this->
	}
	public function export_call_track($primary_1){
		$this->call_track_model->export_calltrack($primary_1);
	}
	public function export_payment($primary_1){
		$this->call_track_model->export_payment($primary_1);
	}
	public function export_monitor_agen($primary_1){
		$this->call_track_model->export_monitor_agen($primary_1);
	}
	
	
	


}
?>