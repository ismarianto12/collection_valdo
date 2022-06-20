<?php
class Hdr_view_debtor_cont extends Controller{
	public function __construct(){
		parent::Controller();
		if(@$_SESSION['blevel']=='spv' || @$_SESSION['blevel']=='admin'){
			//
		} else{
			redirect('login');	
		}
		$this->load->model('admin/hdr_setup_model', 'setup_model');
		$this->load->model('hdr_debtor/hdr_debtor_model', 'debtor_model');
		$this->load->helper('flexigrid');
		$this->id_user = @$_SESSION["id_user"];
		$this->role = @$_SESSION["role"];
	}
	
	public function index(){
		$this->view();
	}
	
	public function  view(){
		//$this->output->enable_profiler("TRUE");
		$data_t['title'] = 'Load Debtor';
		unset($_SESSION['filter_debtor_tmp']);
		$this->load->model('hdr/hdr_filter_model','filter');
		$data_filter = $this->filter->view_filter();
		$this->load->view('admin/hdr_header_admin',$data_t);
		$this->load->view('hdr/hdr_filter_view',$data_filter);
		$this->load->view('admin/hdr_debtor/hdr_debtor_view');
		$this->load->view('admin/hdr_footer');
	}
	
	public function debtor_view(){
		$this->load->model('hdr/hdr_load_ajax_model','load_ajax');
		$filter_for = 'view_all';
		$data = $this->load_ajax->view_debtor($filter_for);
		$this->load->view('admin/hdr_debtor/hdr_debtor_only_view',$data);
	}
	public function proceed_filter_view_only(){
		$this->load->model('hdr/hdr_filter_model','filter');
		$string_data = $this->filter->data_filter();
		$_SESSION['filter_debtor_tmp'] = $string_data;
		//echo $string_data;
		echo "New Filter Has Been Set";
		echo "<script>jQuery('#flex1').flexReload();</script>";
	}
	public function reset_filter(){
		unset($_SESSION['filter_debtor_tmp']);
		echo "session =".$_SESSION['fitler_debtor_tmp']." New Filter Has Been Reset";
		echo "<script>jQuery('#flex1').flexReload();</script>";
	}
	
	public function hdr_edit_up($primary_1){
		$data["primary_1"] = $primary_1;
		$id_field_name = 1;
		$data['name_of_field'] = $this->debtor_model->get_field_name($id_field_name);
		$data['get_debtor'] = $this->debtor_model->debtor_details($primary_1);
		$this->load->view('admin/hdr_debtor/hdr_edit_up',$data);
	}
	
	
}
