<?php
class Hdr_setup_filter_cont extends Controller{
	
	public function __construct(){
		parent::Controller();
		if(@$_SESSION['blevel']!='admin'){
			redirect('login');	
		}
		$this->load->model('admin/hdr_setup_model', 'setup_model');
		$this->load->model('hdr_debtor/hdr_debtor_model', 'debtor_model');
		$this->load->model('admin/hdr_user_model','user_model');
	}
	public function index(){
		$this->list_user_filter_cont();
	}
	public function list_user_filter_cont(){
		$data['title'] = 'List Of User And FIltering';
		$data['list_user'] = $this->user_model->all_user($user_cond='hdu.id_level =3');
		$this->load->view('admin/hdr_header_admin',$data);
		$this->load->view('admin/hdr_user_filter/hdr_list_filter_view',$data);
		$this->load->view('admin/hdr_footer');
	}
	public function list_details_user(){
		$this->load->model('spv/hdr_report_spv_model', 'report_model');
		$begin_uri = $this->uri->segment(4);
		$end_uri = $this->uri->segment(5);
		$begindate = $begin_uri==""?$begindate=date('Y-m-01'):$begindate=$begin_uri;
		$enddate = $begin_uri==""?$enddate=date('Y-m-31'):$enddate=$end_uri;
		$data['begindate'] = $begindate;
		$data['enddate'] =$enddate;
		$data['list_user'] = $this->user_model->all_user($user_cond='hdu.id_level =3');
		$this->load->view('admin/hdr_user_filter/hdr_list_detfilter_view',$data);
	}
	
	public function user_set_filter($id_user){
		$this->load->model('hdr/hdr_filter_model','filter_model');
		$data = $this->filter_model->view_filter();
		$data['get_user'] = $this->user_model->get_user($id_user);
		$this->load->view('admin/hdr_user_filter/hdr_filter_view',$data);
	}
	public function view_debtor($filter_for){
		$data['pop_title'] = 'Detail Cases';
		$this->load->helper('flexigrid');
		$this->load->model('hdr/hdr_load_ajax_model','load_ajax');
		$data['text'] = "History Call Track";
		$data = $this->load_ajax->view_debtor($filter_for);
		$this->load->view('hdr/hdr_pop_up_view',$data);
	}
	public function proceed_filter(){
		echo '<script>loadListUser();</script>';
		$this->load->model('hdr/hdr_filter_model','filter');
		$string_data = $this->filter->data_filter();
		$id_user = $this->input->post('id_user',FALSE);
		$data['filter_debtor'] = $string_data;
		$data['id_user'] = $id_user;
		$this->user_model->edit_user($data);
		echo '<script>jQuery.unblockUI();</script>';
		echo "New Filter Has Been Set";
	}
	
	public function reset_filter(){
		//
	}
	
	public function user(){
		$data['title'] = 'User title'; 
		$this->load->view('admin/hdr_header_admin',$data);
		$this->load->view('admin/hdr_user_filter/hdr_user_set_view',$data);
		$this->load->view('admin/hdr_footer',$data);
	
	}

}
?>