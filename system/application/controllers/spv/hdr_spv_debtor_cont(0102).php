<?php

class Hdr_spv_debtor_cont extends Controller {

    public function __construct() {
        parent::Controller();
        if ( @$_SESSION['blevel'] == 'spv' || @$_SESSION['blevel'] == 'admin'  || @$_SESSION['blevel'] == 'manager') {
            //
        } else {
            redirect('login');
        }
        $this->load->model('hdr_debtor/hdr_debtor_model', 'debtor_model');
        $this->load->model('spv/hdr_spv_debtor_model');

        $this->load->model('spv/hdr_report_spv_model', 'report_model');

        $this->load->model('user/hdr_call_track_model', 'call_track_model');

        $this->output->enable_profiler(FALSE);

        $this->load->helper('flexigrid');
        $this->id_user = @$_SESSION["id_user"];
        $this->role = @$_SESSION["role"];
    }

    public function index() {
        $this->debtor();
    }

    public function debtor()
    {
	    $is_approved = $this->input->post('is_approved');
			$data['is_approved'] = $is_approved;

			//echo("ddd" . $is_approved);
			$this->load->view('spv/hdr_header_spv');
	    $this->load->view('spv/hdr_debtor/hdr_list_debtor_view',$data);
	    $this->load->view('spv/hdr_footer');
    }

		/*
    public function memo_bdo()
    {
	    $is_approved = $this->input->post('is_approved') ? $this->input->post('is_approved') : '99';
			$data['is_approved'] = $is_approved;

			//echo("ddd" . $is_approved);
			$this->load->view('spv/hdr_header_spv');
	    $this->load->view('spv/hdr_debtor/hdr_list_debtor_bdo_view',$data);
	    $this->load->view('spv/hdr_footer');
    }
    */

  	public function list_details_debtor($is_approved ='-', $begindate="", $enddate='')
  	{
	    $this->load->model('spv/hdr_spv_debtor_model');
			$data['list_debtor'] = $this->hdr_spv_debtor_model->all_debtor($is_approved, $begindate, $enddate);
			$this->load->view('spv/hdr_debtor/hdr_list_detdebtor_view',$data);
		}

  	public function list_details_debtor_memo($is_approved ='-', $begindate="", $enddate='')
  	{
	    $this->load->model('spv/hdr_spv_debtor_model');
			$data['list_debtor'] = $this->hdr_spv_debtor_model->all_debtor_memo($is_approved, $begindate, $enddate);
   		$this->load->view('spv/hdr_debtor/hdr_list_detdebtor_bdo_view',$data);
		}
    public function search_debtor_memo($is_approved ='-', $begindate="", $enddate='')
  	{
	    $this->load->model('spv/hdr_spv_debtor_model');
			$data['list_debtor'] = $this->hdr_spv_debtor_model->search_debtor_memo($is_approved, $begindate, $enddate);
   		$this->load->view('spv/hdr_debtor/hdr_list_detdebtor_bdo_view',$data);
		}

		public function edit_debtor($id_phone )
		{
			$data['txt_title'] = 'Edit This Debtor';
			$data['list_debtor'] = $this->hdr_spv_debtor_model->get_list_debtor();
			$data['get_debtor'] = $this->hdr_spv_debtor_model->get_debtor($id_phone);
			$this->load->view('spv/hdr_header_spv',$data);
			$this->load->view('spv/hdr_debtor/hdr_edit_debtor',$data);
			$this->load->view('spv/hdr_footer',$data);
		}

		public function edit_debtor_ajax()
		{
			$data['id_phone'] = $this->input->post('id_phone', TRUE);
			$data['username'] = $this->input->post('username', TRUE);
			$data['phone_type'] = $this->input->post('phone_type', TRUE);
			$data['phone_no'] = $this->input->post('phone_no', TRUE);
			$data['createdate'] = $this->input->post('createdate', TRUE);
			$data['is_approved'] = $this->input->post('is_approved', TRUE);
			$this->hdr_spv_debtor_model->edit_debtor($data);

		  echo '<h1>'.$data['username'].' has been updated!</h1>';
			echo '<script>location.href="'.site_url().'spv/hdr_spv_debtor_cont"</script>';
		}

		public function edit_debtor_bdo($id)
		{
			$data['txt_title'] = 'Edit This Memo';
			$data['list_debtor'] = $this->hdr_spv_debtor_model->get_list_debtor();
			$data['get_debtor'] = $this->hdr_spv_debtor_model->get_debtor_bdo($id);
			$this->load->view('spv/hdr_header_spv',$data);
			$this->load->view('spv/hdr_debtor/hdr_edit_debtor_bdo',$data);
			$this->load->view('spv/hdr_footer',$data);
		}

		public function edit_debtor_bdo_ajax()
		{
			$data['id'] = $this->input->post('id', TRUE);
			$data['username'] = $this->input->post('username', TRUE);
			$data['usulan'] = $this->input->post('usulan', TRUE);
			$data['amt_discount'] = $this->input->post('amt_discount', TRUE);
			$data['percent_discount'] = $this->input->post('percent_discount', TRUE);
			$data['remarks'] = $this->input->post('remarks', TRUE);
			$data['is_approved'] = $this->input->post('is_approved', TRUE);
			$this->hdr_spv_debtor_model->edit_debtor_bdo($data);

		  echo '<h1>'.$data['username'].' has been updated!</h1>';
			echo '<script>location.href="'.site_url().'spv/hdr_spv_debtor_cont/memo_bdo"</script>';
		}

    public function download_debtor_bdo($id, $type)
    {
    	/*
				type 1: Manager Regional
				type 2: Dep Head
				type 3: Group Head
    	*/

			$bdo = $this->hdr_spv_debtor_model->get_debtor_bdo($id);
		//	var_dump($bdo);
		//	die();

			$primary_1 = $bdo->primary_1;
			$username = $bdo->username;
			$usulan = $bdo->usulan;
			$amt_discount = $bdo->amt_discount;

			$percent_discount = $bdo->percent_discount;
			$remarks = $bdo->remarks;

			$created = $bdo->createdate;
			$nomer_kartu = $bdo->card_no;
			$nama_nasabah = $bdo->card_holder_name;
			$total_outstanding = $bdo->balance;
			$total_outstanding_current = $bdo->current_balance;

			$month_wo = $bdo->monthwo;
			$last_payment = $bdo->last_paid_amount;
			$last_payment_date = $bdo->last_paid_date;

			$kategory = $bdo->potential_risk;
			$recovery_score = $bdo->recov_score;
			$area = $bdo->city;
			$desk_coll = $bdo->fullname;

			$bunga = $bdo->bunga;
			$denda = $bdo->denda;
			$pokok = $bdo->pokok;

			switch($type)
			{
				case 1:
				$file_path = 'contohmemoBDO_mr.xls';
				$file_out = 'memo_bdo_manager_regional.xls';
				break;
				case 2:
				$file_path = 'contohmemoBDO_dh.xls';
				$file_out = 'memo_bdo_departement_head.xls';
				break;
				case 3:
				$file_path = 'contohmemoBDO_gh.xls';
				$file_out = 'memo_bdo_regional_head.xls';
				break;
			}




  		##Load PHPExcel Plugin
  		$this->load->library("PHPExcel");
  		##################################

			$template_file = "./assets/download/$file_path";
  		$objPHPExcel = PHPExcel_IOFactory::load($template_file);

			$objWorksheet = $objPHPExcel->getActiveSheet();

			//name -> C13
			//nomer -> C14
			//total oustanding -> C15
			//month write off -> C16


			$objWorksheet->getCell('C13')->setValue($nama_nasabah);
			$objWorksheet->getCell('C14')->setValue("'".$nomer_kartu);
			$objWorksheet->getCell('C15')->setValue($total_outstanding);
			$objWorksheet->getCell('C16')->setValue($month_wo);
			$objWorksheet->getCell('C17')->setValue($last_payment);

			$objWorksheet->getCell('F13')->setValue($kategory);
			$objWorksheet->getCell('F14')->setValue($recovery_score);
			$objWorksheet->getCell('F15')->setValue($area);
			$objWorksheet->getCell('F17')->setValue($desk_coll);

			$objWorksheet->getCell('C22')->setValue($total_outstanding_current);
			$objWorksheet->getCell('C23')->setValue($bunga);
			$objWorksheet->getCell('C24')->setValue($denda);
			$objWorksheet->getCell('C25')->setValue($pokok);

			$objWorksheet->getCell('D22')->setValue($total_outstanding);
			$objWorksheet->getCell('D23')->setValue($bunga);
			$objWorksheet->getCell('D24')->setValue($denda);
			$objWorksheet->getCell('D25')->setValue($pokok);

			$st_temp = @price_format($amt_discount) . ' atau ' . $percent_discount;

			$objWorksheet->getCell('C27')->setValue($st_temp);


			$objWorksheet->getCell('C32')->setValue($remarks);



			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="' . $file_out . '"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');


			$objPHPExcel->disconnectWorksheets();

			unset($objPHPExcel);
			die('Done');
    }

		/**
		 * Reassign nasabah
		 */
    public function reassign()
    {
    	$data = array();
    	$debtor = array();

			$cmd = $this->input->post("cmd") ? $this->input->post("cmd") : '';
			$user_id = $this->input->post("user_id") ? $this->input->post("user_id") : "";

			if($cmd == 'pilih')
			{
				$sql = "select * from hdr_assignment ha, hdr_debtor_main hdm
					where ha.primary_1=hdm.primary_1
					and ha.id_user=$user_id";
				$q = $this->db->query($sql);

				foreach($q->result_array() as $row)
				{
					$debtor[] = $row;
				}

			}

    	$sql = "select ha.id_user, hu.username, count(*) as total
				from hdr_assignment ha, hdr_user hu
				where ha.id_user=hu.id_user
				and hu.id_leader=2
				group by ha.id_user
				";
			$q = $this->db->query($sql);

			$assign = array();
			if($q->num_rows() > 0)
			{
				foreach($q->result_array() as $row)
				{
					$assign[] = $row;
				}
			}
			$q->free_result();

			$data['assign'] = $assign;
			$data['user_id'] = $user_id;
			$data['debtor'] = $debtor;

			$this->load->view('spv/hdr_header_spv');
	    $this->load->view('spv/hdr_list_debtor_reassign_view',$data);
	    $this->load->view('spv/hdr_footer');
    }

    public function payment()
    {

  		$data = array();
    	$spv_id = $_SESSION["bid_user_s"];
    	$data['users'] = $this->hdr_spv_debtor_model->get_users($spv_id);
	    $this->load->model('spv/hdr_spv_debtor_model');

			//form request
			$trx_date = $this->input->post("trx_date") ? $this->input->post("trx_date") : '';
			$start_date = $this->input->post("start_date") ? $this->input->post("start_date") : '';
			$finish_date = $this->input->post("finish_date") ? $this->input->post("finish_date") : '';

	   	$rst = $this->hdr_spv_debtor_model->all_debtor_payment($trx_date, $start_date, $finish_date);

			//var_dump($rst['data']);
			//die();

	   	$data['list_payment'] = $rst;

			$data['trx_date'] = $trx_date;

	   	//$data['list_payment'] = $this->hdr_spv_debtor_model->search_debtor_payment($id_user, $begindate, $enddate, $card_no);
	  	$this->load->view('spv/hdr_header_spv');
   		$this->load->view('spv/hdr_debtor/hdr_list_debtor_payment_view',$data);
   		$this->load->view('spv/hdr_footer');
    }

    public function list_details_debtor_payment($id_user = '-', $begindate="-", $enddate='-', $card_no='-')
  	{
  	  $data = array();
    	$spv_id = $_SESSION["bid_user_s"];
    	$data['users'] = $this->hdr_spv_debtor_model->get_users($spv_id);
	    $this->load->model('spv/hdr_spv_debtor_model');
	   	$data['list_payment'] = $this->hdr_spv_debtor_model->all_debtor_payment();
	   	$data['list_payment'] = $this->hdr_spv_debtor_model->search_debtor_payment($id_user, $begindate, $enddate, $card_no);
	  	$this->load->view('spv/hdr_header_spv');
   		$this->load->view('spv/hdr_debtor/hdr_list_debtor_payment_view',$data);
   		$this->load->view('spv/hdr_footer');

   	}
   	public function approved(){
    	$arr_user_id = $this->input->post("chk",TRUE);


			if(count($arr_user_id) > 0 ){
				$arr_transData = array_keys($arr_user_id);

				foreach($arr_transData as $data){
				 $bucket = explode("/",$data);
				 $this->hdr_spv_debtor_model->approvephone($bucket);
				}
			}
			 //redirect('./hdr_assignment_cont');
			redirect('spv/hdr_spv_debtor_cont/debtor');
			//var_dump($transDest);
    }
	public function rejected(){
    	$arr_user_id = $this->input->post("chk",TRUE);


			if(count($arr_user_id) > 0 ){
				$arr_transData = array_keys($arr_user_id);

				foreach($arr_transData as $data){
				 $bucket = explode("/",$data);
				 $this->hdr_spv_debtor_model->rejectedphone($bucket);
				}
			}
			 //redirect('./hdr_assignment_cont');
			redirect('spv/hdr_spv_debtor_cont/debtor');
			//var_dump($transDest);
    }
    public function pending(){
    	$arr_user_id = $this->input->post("chk",TRUE);


			if(count($arr_user_id) > 0 ){
				$arr_transData = array_keys($arr_user_id);

				foreach($arr_transData as $data){
				 $bucket = explode("/",$data);
				 $this->hdr_spv_debtor_model->pendingphone($bucket);
				}
			}
			 //redirect('./hdr_assignment_cont');
			redirect('spv/hdr_spv_debtor_cont/debtor');
			//var_dump($transDest);
    }
}

?>