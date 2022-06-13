<?php
class Hdr_setup_filter_cont extends Controller{

	public function __construct(){
		parent::Controller();
		if(@$_SESSION['blevel']!='spv'){
			redirect('login');
		}
		$this->load->model('admin/hdr_setup_model', 'setup_model');
		$this->load->model('hdr_debtor/hdr_debtor_model', 'debtor_model');
		$this->load->model('admin/hdr_user_model','user_model');
		$this->load->model('spv/hdr_report_spv_model','report_model');
	}
	public function index(){
		//die("dooor");
		$this->list_user_filter_cont();
	}
	public function list_user_filter_cont(){
		$data['title'] = 'List Of User And FIltering';

		$id_user = @$_SESSION['bid_user_s'];
		$data['list_user'] = $this->user_model->all_user($user_cond="hdu.id_level =3 and hdu.id_leader=$id_user");
		//die("tes");
		$this->load->view('spv/hdr_header_spv',$data);
	 $this->load->view('spv/hdr_list_filter_view',$data);
		$this->load->view('spv/hdr_footer');
	}
	public function list_details_user(){
		$this->load->model('spv/hdr_report_spv_model', 'report_model');
		$begin_uri = $this->uri->segment(4);
		$end_uri = $this->uri->segment(5);

		$begindate = $begin_uri==""?$begindate=date('Y-m-01'):$begindate=$begin_uri;
		$enddate = $begin_uri==""?$enddate=date('Y-m-31'):$enddate=$end_uri;
		//die($enddate);
		$data['begindate'] = $begindate;
		$data['enddate'] =$enddate;
		$id_user = @$_SESSION['bid_user_s'];
	//die($id_user);
		$data['list_user'] = $this->user_model->all_user($user_cond="hdu.id_level =3 and hdu.id_leader=$id_user");
		//var_dump($data['list_user']);
		//die();
		//die("aa");
		$this->load->view('spv/hdr_list_detfilter_view',$data);
	}

	public function user_set_filter($id_user){
		$this->load->model('hdr/hdr_filter_model','filter_model');
		$data = $this->filter_model->view_filter();
		$data['get_user'] = $this->user_model->get_user($id_user);

		$regions = $this->report_model->getall_regions();
		//var_dump($regions);
		//die();
		$data['regions'] = $regions;
		$this->load->view('spv/hdr_filter_view2',$data);
	}

	public function view_debtor($filter_for){
		//die("aas");
		$data['pop_title'] = 'Detail Cases';
		$this->load->helper('flexigrid');
		$this->load->model('hdr/hdr_load_ajax_model','load_ajax');
		$data['text'] = "History Call Track";
		$data = $this->load_ajax->view_debtor($filter_for);
		$this->load->view('spv/hdr_pop_up_view',$data);
	}

	public function export_debtor($filter_for){
		$data['pop_title'] = 'Export Detail';
		//$this->load->helper('flexigrid');
		$this->load->model('hdr_debtor/hdr_debtor_model','debtor_model');
		//$data['text'] = "History Call Track";
		$data = $this->debtor_model->view_export($filter_for);
		//$this->load->view('spv/hdr_pop_up_view',$data);
	}

	public function proceed_filter(){

		echo '<script>loadListUser();</script>';

		$this->load->model('hdr/hdr_filter_model','filter');

		//$string_data = $this->filter->data_filter();

		//die($string_data);
		$id_user = $this->input->post('id_user',FALSE);
		//die("jhkjhjkh" . $id_user);

		$product = $this->input->post('product');
		$priority = $this->input->post("priority") != "null" ? $this->input->post("priority") : "";
		$over_days = $this->input->post("over_days") != "null" ? $this->input->post("over_days") : "";

		$region = $this->input->post("region");
		$branch = $this->input->post("branch");
		$exmode = $this->input->post("exmode");

		$fin_type = $this->input->post("fin_type") != "null" ? $this->input->post("fin_type") : "";

		$product_flag = $this->input->post("product_flag")!="null" ? $this->input->post("product_flag") : "";
		$bucket_coll = $this->input->post("bucket_coll")!="null" ? $this->input->post("bucket_coll") : "";
		$bucket_od = $this->input->post("bucket_od")!="null" ? $this->input->post("bucket_od") : "";

		//var_dump($fin_type);
		//die();

		//var_dump($exmode);
		//die();

		//$data['filter_debtor'] = $string_data;

		$data['id_user'] = $id_user;
		$data['product'] = $product;
		$data['priority'] = $priority;
		$data['over_days'] = $over_days;

		$data['region'] = $region;
		$data['branch'] = $branch;
		$data['exmode'] = $exmode;

		$data['fin_type'] = $fin_type;
		$data['product_flag'] = $product_flag;
		$data['bucket_coll'] = $bucket_coll;
		$data['bucket_od'] = $bucket_od;

//var_dump($over_days);die();
		if(count($data['over_days']) > 1){
			$firstSelect = $data['over_days'][0];
			if($firstSelect == ''){
				$data['over_days'] = array(''); //make sure when selecting all, other option are ignored
			}
		}

		if($data['region'] == ''){
			$data['branch'] = array('');
		}
//var_dump($data);
//die();

		$this->user_model->edit_user_prop($data);

		//remark 4 agust 2016
/*		
		$this->load->model('spv/hdr_report_spv_model','spv_model');
		$sql = "select * from hdr_user where id_level=3 AND id_user=$id_user";
   	$q = $this->db->query($sql);

  	foreach($q->result_array() as $row)
  	{
  		$user_id = $row['id_user'];
  		$today = date('Y-m-d');
  		$assign_total = $this->spv_model->count_assign_debtor_tc($user_id);
  		if($assign_total == ' "No Debtor" ') $assign_total = 0;

  		$data_input = array(
				"assign_total" => $assign_total
  		);
  		$where = array(
  			"user_id" => $user_id,
  			"created" => $today
  		);
  		//die($sql);
			//var_dump($where);
			//die();
  		$this->db->update("hdr_report_filter", $data_input, $where);
  		//$a = $this->db->last_query();
  		//die($a);

  	}
*/
		//die();

		//syncronize 4 agust 2016		
		$sql = "update hdr_debtor_main hdm, hdr_calltrack hc
			set hdm.last_call_code=hc.code_call_track,
			hdm.last_id_handling_code=hc.id_handling_code,
			hdm.in_use=0
			where hdm.primary_1=hc.primary_1 and month(hc.call_date)=month(now()) and year(hc.call_date)=year(now()) 
			and hdm.valdo_cc='01' and (hdm.is_paid IS NULL or hdm.is_paid = 0) and hdm.skip = 0";
		$this->db->query($sql);
		
		//reschedule
		$sql = "update hdr_debtor_main set seq_no=1 where last_call_code='OCAA' and last_id_handling_code=15 and valdo_cc='01' and (is_paid IS NULL or is_paid = 0) and skip = 0";
		$this->db->query($sql);

		//titip pesan
		$sql = "update hdr_debtor_main set seq_no=2 where last_call_code='OCAA' and last_id_handling_code=1 and valdo_cc='01' and (is_paid IS NULL or is_paid = 0) and skip = 0";
		$this->db->query($sql);

		//unit hilang
		$sql = "update hdr_debtor_main set seq_no=3 where last_call_code='OCAA' and last_id_handling_code=7 and valdo_cc='01' and (is_paid IS NULL or is_paid = 0) and skip = 0";
		$this->db->query($sql);

		//Noan
		$sql = "update hdr_debtor_main set seq_no=4 where last_call_code='OCNA' and last_id_handling_code=4 and valdo_cc='01' and (is_paid IS NULL or is_paid = 0) and skip = 0";
		$this->db->query($sql);

		//line busy
		$sql = "update hdr_debtor_main set seq_no=5 where last_call_code='OCLB' and last_id_handling_code=4 and valdo_cc='01' and (is_paid IS NULL or is_paid = 0) and skip = 0";
		$this->db->query($sql);

		//invalid number
		$sql = "update hdr_debtor_main set seq_no=6 where last_call_code='OCIN' and last_id_handling_code='05' and valdo_cc='01' and (is_paid IS NULL or is_paid = 0) and skip = 0";
		$this->db->query($sql);
		
		//ptp_expired
		if($priority == 'PTP_Expired')
		{
			$sql = "update hdr_debtor_main hdm, hdr_calltrack hc
				set hdm.ptp_date_expired=hc.ptp_date, hdm.id_user=hc.id_user
				where hdm.primary_1=hc.primary_1
				and month(hc.ptp_date)=month(now()) and year(hc.ptp_date)=year(now())
				and hc.ptp_date < date(now()) and hc.ptp_date is not null 
				and hdm.valdo_cc='01'";
			$this->db->query($sql);
		}
		
		echo '<script>jQuery.unblockUI();</script>';
		echo "New Filter Has Been Set";
	}

	public function reset_filter(){
		//
	}

	public function user(){
		$data['title'] = 'User title';
		$this->load->view('spv/hdr_header_admin',$data);
		$this->load->view('spv/hdr_user_set_view',$data);
		$this->load->view('spv/hdr_footer',$data);

	}

	public function user_filtering(){
		$data['title'] = 'List Of User And FIltering';
		//$data['list_user'] = $this->user_model->all_user($user_cond='hdu.id_level =3');
		$this->load->view('spv/hdr_header_admin',$data);
		$this->load->view('spv/user_filter_view',$data);
		$this->load->view('spv/hdr_footer');

	}

	function database_tracking(){
		$data['title'] = '- Database Tracking -';

		$sql = "SELECT
		( CASE WHEN valdo_cc = '01' THEN 'JKT' WHEN valdo_cc = '02' THEN 'SBY' ELSE CONCAT('NONE-',valdo_cc) END ) AS DATA_SEGMENT,
		( CASE WHEN object_group_code = '001' THEN 'MTR' WHEN object_group_code = '002' THEN 'MBL' ELSE CONCAT('ELSE-', object_group_code) END ) AS OBJ_GRP,
		( CASE WHEN fin_type = '1' THEN 'REGULER' WHEN fin_type = '2' THEN 'SYARIAH' ELSE CONCAT('UNKNOWN-', fin_type) END ) AS FINTYPE,
		COUNT(primary_1) AS TTL_DATA,
		COUNT( CASE WHEN called = 1 THEN primary_1 END ) AS TTL_DATA_CALLED,
		COUNT( CASE WHEN is_new = 0 THEN primary_1 END ) AS NON_CATEGORIZE,
		COUNT( CASE WHEN (is_new = 0 AND called = 1) THEN primary_1 END ) AS NON_CATEGORIZE_CALLED,
		COUNT( CASE WHEN last_handling_date='0000-00-00' and skip=0 and (is_paid IS NULL or is_paid = 0) and valdo_cc = '01' THEN primary_1 END ) AS UNTOUCH,
		COUNT( CASE WHEN (is_new = 1 AND called = 1 and last_handling_date='0000-00-00' and skip=0 and (is_paid IS NULL or is_paid = 0) and valdo_cc = '01')  THEN primary_1 END ) AS UNTOUCH_CALLED,
		COUNT( CASE WHEN is_new = 2 THEN primary_1 END ) AS RETOUCH,
		COUNT( CASE WHEN (is_new = 2 AND called = 1) THEN primary_1 END ) AS RETOUCH_CALLED,
		COUNT( CASE WHEN (skip = 1 OR is_paid = 1 OR paid = 1) THEN primary_1 END ) AS SKIPPED,
		COUNT( CASE WHEN (in_use <> 0 AND skip = 0) THEN primary_1 END ) AS LOCKED
		FROM hdr_debtor_main
		GROUP BY valdo_cc, object_group_code, fin_type";

		$qObj = $this->db->query($sql);
		$qArr = $qObj->result_array();

		$data['data_array'] = $qArr;

		$this->load->view('spv/hdr_header_spv', $data);
	 $this->load->view('spv/database_tracking', $data);
		$this->load->view('spv/hdr_footer');
	}

}
?>