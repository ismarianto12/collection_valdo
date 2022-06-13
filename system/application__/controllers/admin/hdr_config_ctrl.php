<?php
class Hdr_config_ctrl extends Controller{
	
	public function __construct(){
		parent::Controller();
		if(@$_SESSION['blevel']!='admin'){
			redirect('login');	
		}
		$this->load->model('admin/hdr_user_model','user_model');
		//$this->load->model();
	}
	
	public function index(){
		$this->config();
	}
	
	public function config(){
		//$this-
	}
	

}
?>