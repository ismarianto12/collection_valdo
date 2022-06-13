<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Hdr_ajax extends Controller {

	function __construct ()
	{
		parent::Controller();	
		$this->load->model('hdr_debtor/hdr_debtor_model');
		$this->load->library('flexigrid');
	}
	
	function index(){
		redirect('admin/hdr_ajax/get_data');	
	}
	
	function get_data($filter_for)
	{
	
		//$this->output->enable_profiler(TRUE);
		
		$valid_fields = array('name','acct_no','debt_amount','area','card_no','id_card','dob','bucket_asccend','bucket','en_primary1','primary_1','id_debtor','cycle','cardblock','accblock','due_date','home_address1','city','office_address1','company_name','billing_address','home_zip_code1','card_type','last_paid_date','last_paid_amount','last_trx_date','last_trx_amount','last_cash_adv_date','last_cast_adv_amount','last_cash_adv_amount','email','date_in','credit_limit');
		$this->flexigrid->validate_post('id_debtor','asc',$valid_fields);
		
		$records = $this->hdr_debtor_model->all_debtor_flexi_view($filter_for);
		$this->output->set_header($this->config->item('json_header'));
		$i=1;
		if($records['records']->num_rows()>0){
		
		foreach ($records['records']->result() as $row)
		{	
			$record_items[] = array($row->id_debtor,
			$row->en_primary1,
			'<img border=\'0\' src=\''.base_url().'assets/images/edit_t.png\'><a onclick="boxPopup(\'Edit Debtor\',\''.site_url().'/admin/hdr_view_debtor_cont/hdr_edit_up/'.$row->en_primary1.'\')">View</a> ',
			$row->name,
			price_format($row->debt_amount),
			$row->dpd,
			date_formating($row->last_paid_date),
			price_format($row->last_paid_amount),
			date_formating($row->od_due_date),
			$row->home_address1,
			$row->kode_cabang,
			$row->home_zip_code1,
			$row->area,
			$row->company_name,
			$row->office_address1,
			$row->billing_address,
			$row->email,
			$row->home_phone1,
			date_formating($row->date_in),
			$row->kode_cabang,
			);
		}
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}else{
		$record_items[] = array();
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}
	
	}
	
	function get_hist_payment()
	{
		//$this->output->enable_profiler(TRUE);
		$primary_1 = $this->uri->segment(4);
		$valid_fields = array('primary_1','en_primary1','amount','card_no','description','trx_date','posting_date');
		$this->flexigrid->validate_post('"','"',$valid_fields);
		
		$records = $this->hdr_debtor_model->all_debtor_hist_payment_flexi($primary_1);
		$this->output->set_header($this->config->item('json_header'));
		$i=1;
		if($records['records']->num_rows()>0){
		
		foreach ($records['records']->result() as $row)
		{	
			$record_items[] = array($row->en_primary1,
			$i++,
			//$row->en_primary1,
			date_formating($row->trx_date),
			date_formating($row->posting_date),
			price_format($row->amount),
			$row->description,
			);
		}
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}else{
		$record_items[] = array();
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}
	
	}
	
	function get_call_track($primary_1,$id_action_call_track) {
		//$this->output->enable_profiler(TRUE);
		$valid_fields = array('id_calltrack','primary_1','en_primary1','name','name AS name','username','remarks','call_date','call_time','code_call_track' ,'ptp_date','ptp_amount','due_date','due_time');
		$this->flexigrid->validate_post('call_date','DESC',$valid_fields);
		//echo 'ajax'.$id_action_call_track;
		$id_user = $_SESSION['bid_user_s'];
		if($id_action_call_track == 'rem'){
			$records = $this->hdr_debtor_model->all_debtor_hist_calltrack_rem_flexi($primary_1,$id_action_call_track,$id_user);
		}else{
			$records = $this->hdr_debtor_model->all_debtor_hist_calltrack_flexi($primary_1,$id_action_call_track,$id_user);
		}
		$this->output->set_header($this->config->item('json_header'));
		$i=1;
		if($records['records']->num_rows()>0){
		
		foreach ($records['records']->result() as $row)
		{	
			if($id_action_call_track == 'ptp'){
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
			} elseif($id_action_call_track == 'rem'){
					$record_items[] = array($row->en_primary1,
					$i++,
					//$row->en_primary1,
					$row->name,
					date_formating($row->call_date),
					$row->call_time,
					$row->code_call_track,
					$row->remarks,
					date_formating($row->due_date),
					$row->due_time,
					);
			}else {
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
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}else{
		$record_items[] = array();
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}
	}
	
	function get_user_call_track($id_action_call_track,$id_user,$begindate,$enddate) {
// 		$this->output->enable_profiler(TRUE);
		$valid_fields = array('id_calltrack','primary_1','hdc.primary_1','en_primary1','hdm.name','hdc.cname','username','remarks','call_date','call_time','hdc.code_call_track AS hcall_code','hcall_code','cdescrip','code_call_track','description as cdescrip','hac.code_call_track as haccall_track','haccall_track','ptp_date','ptp_amount','hdp.trx_date','hdp.amount','due_date','due_time');
		
		//$id_action_call_track = '';
		$id_user = $_SESSION['bid_user_s'];
		if($id_action_call_track=='keep' ||  $id_action_call_track=='broken'){
		  $this->flexigrid->validate_post('trx_date','DESC',$valid_fields);
		  $records = $this->hdr_debtor_model->all_debtor_hist_user_keep_broken_flexi($id_action_call_track,$id_user,$begindate,$enddate);
		}else{
		  $this->flexigrid->validate_post('createdate','DESC',$valid_fields);
		  $records = $this->hdr_debtor_model->all_debtor_hist_user_calltrack_flexi($id_action_call_track,$id_user,$begindate,$enddate);
		}
		$this->output->set_header($this->config->item('json_header'));
		$i=1;
		if($records['records']->num_rows()>0){
		
		foreach ($records['records']->result() as $row)
		{	
			if($id_action_call_track == '28'){
					$call_code = $row->haccall_track==''?$row->hcall_code:$row->haccall_track;
					$record_items[] = array($row->en_primary1,
					$i++,
					$row->en_primary1,
					$row->name,
					date_formating($row->call_date),
					$row->call_time,
					$call_code,
					$row->remarks,
					$row->username,
					date_formating($row->ptp_date),
					price_format($row->ptp_amount),
					);
			} elseif($id_action_call_track == 'keep' || $id_action_call_track == 'broken' ){
					$call_code = $row->haccall_track==''?$row->hcall_code:$row->haccall_track;
					$record_items[] = array($row->en_primary1,
					$i++,
					$row->en_primary1,
					$row->name,
					date_formating($row->call_date),
					$row->call_time,
					$call_code,
					$row->remarks,
					$row->username,
					date_formating($row->ptp_date),
					price_format($row->ptp_amount),
					date_formating($row->trx_date),
					price_format($row->amount),
					);
			} elseif($id_action_call_track == '52'){
					$record_items[] = array($row->en_primary1,
					$i++,
					$row->en_primary1,
					$row->name,
					date_formating($row->call_date),
					$row->call_time,
					$row->haccall_track,
					$row->remarks,
					$row->username,
					date_formating($row->due_date),
					$row->due_time,
					);
			}else {
					$call_code = $row->haccall_track==''?$row->hcall_code:$row->haccall_track;
					$record_items[] = array($row->en_primary1,
					$i++,
					$row->en_primary1,
					$row->name,
					date_formating($row->call_date),
					$row->call_time,
					$call_code,
					$row->remarks,
					$row->username,
					date_formating($row->ptp_date),
					price_format($row->ptp_amount),
					);
			}
		}
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}else{
		$record_items[] = array();
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}
	}
	
	function get_agen_track() {
		//$this->output->enable_profiler(TRUE);
		$primary_1 = $this->uri->segment(4);
		$valid_fields = array('id_agen_monitor','primary_1','en_primary1','date_in','time','visit_date','action_code','ptp_date','ptp_amount','remark','username','agency','coll_agency');
		$this->flexigrid->validate_post('createdate','DESC',$valid_fields);
		
		$records = $this->hdr_debtor_model->all_debtor_hist_agen_track_flexi($primary_1);
		$this->output->set_header($this->config->item('json_header'));
		$i=1;
		if($records['records']->num_rows()>0){
		
		foreach ($records['records']->result() as $row)
		{	
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
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}else{
		$record_items[] = array();
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}
	}
	
	function get_reschedule() {
		//$this->output->enable_profiler(TRUE);
		$primary_1 = $this->uri->segment(4);
		$valid_fields = array('id_reschedule','primary_1','en_primary1','resc_date','resc_bucket','dp','pv','tenor','interest','cicilan','payment_date','description');
		$this->flexigrid->validate_post('id_reschedule','DESC',$valid_fields);
		
		$records = $this->hdr_debtor_model->all_debtor_hist_reschedule_flexi($primary_1);
		$this->output->set_header($this->config->item('json_header'));
		$i=1;
		if($records['records']->num_rows()>0){
		foreach ($records['records']->result() as $row)
		{	
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
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}else{
		$record_items[] = array();
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}
	}
	
	function get_status_track($user,$id_user,$status,$begindate,$enddate,$report) {
		//$this->output->enable_profiler(TRUE);
		$this->load->model('spv/hdr_report_spv_model','report_model');
		$primary_1 = $this->uri->segment(4);
		$valid_fields = array('id_calltrack','ptp_stat','cptp_date','max_date','max_amount','en_primary1','mdpd','hdc.dpd','hdc.primary_1','hdc.cname','hdp.amount','hdp.trx_date','hdm.last_trx_amount','hdc.username','hdc.remarks','hdc.call_date','hdc.call_time','hdc.code_call_track','cdescrip','description','hdc.ptp_date','hdc.ptp_amount');
		
		$val_order = $status =='untc' || $status =='AC'?$this->flexigrid->validate_post('hdc.createdate','DESC',$valid_fields):$this->flexigrid->validate_post('hdc.id_calltrack','DESC',$valid_fields);
		$id_action_call_track = '1'; 
			if($status =='ct'){
				$status_r = "hdc.id_call_cat = '1'   ";
				$records = $this->report_model->list_report_flexi_status($user,$id_user,$status,$status_r,$begindate,$enddate,$report);
			} elseif($status =='ptp'){
				$status_r = "hdc.id_action_call_track ='28' ";
				$records = $this->report_model->list_report_flexi_status($user,$id_user,$status,$status_r,$begindate,$enddate,$report);
			} elseif($status =='all'){
				$status_r = "hdc.id_action_call_track !='0' ";
				$records = $this->report_model->list_report_flexi_status($user,$id_user,$status,$status_r,$begindate,$enddate,$report);
			} elseif($status =='AC'){
				$status_r = " ";
				$records = $this->report_model->all_debtor_flexi_view($user,$id_user,$status,$status_r,$begindate,$enddate,$report);
			} elseif($status =='noct'){
				$status_r = "hdc.id_call_cat = '2' ";
				$records = $this->report_model->list_report_flexi_status($user,$id_user,$status,$status_r,$begindate,$enddate,$report);
			}  elseif($status =='acc'){
				$status_r = "hdc.is_current = '1'  ";
				$records = $this->report_model->list_report_flexi_status($user,$id_user,$status,$status_r,$begindate,$enddate,$report);
			} elseif($status =='keep'){
				$status_r = "hdc.ptp_status = '2'  ";
				$records = $this->report_model->list_ptp_flexi_status($user,$id_user,$status,$status_r,$begindate,$enddate,$report);
			} elseif($status =='broken'){
				$status_r = "hdc.ptp_status = '1'  ";
				$records = $this->report_model->list_ptp_flexi_status($user,$id_user,$status,$status_r,$begindate,$enddate,$report);
			}elseif($status =='at'){
				$status_r = "hdc.is_current = '1' ";
				$records = $this->report_model->list_report_flexi_status($user,$id_user,$status,$status_r,$begindate,$enddate,$report);
			} elseif($status =='detail_untouch_case'){
				$records = $this->report_model->list_report_flexi_status($user,$id_user,$status,$status_r,$begindate,$enddate,$report);
			} elseif($status =='incom'){
				$this->flexigrid->validate_post('hdm.date_in','DESC',$valid_fields);
				$records = $this->report_model->incomming_flexi($user,$id_user);
			} elseif($status =='untc'){
				$this->flexigrid->validate_post('hdm.date_in','DESC',$valid_fields);
				$records = $this->report_model->list_report_flexi_untouch($user,$id_user);
			}elseif($status =='not_call'){
				$this->flexigrid->validate_post('hdm.date_in','DESC',$valid_fields);
				$records = $this->report_model->list_report_flexi_untouch($user,$id_user);
			}
		$this->output->set_header($this->config->item('json_header'));
		$i=1;
		if($records['records']->num_rows()>0){
		if($status == 'untc' || $status == 'AC'  ){
			foreach ($records['records']->result() as $row)
				{	
				
					$record_items[] = array($row->en_primary_1,
					$i++,
					$row->en_primary_1,
					$row->name,
					$row->card_no,
					date_formating($row->dob),
					$row->bucket,
					$row->cycle,
					$row->cardblock,
					$row->accblock
					);
				}
		}else{
			foreach ($records['records']->result() as $row)
			{	
				$record_items[] = array($row->en_primary_1,
				$i++,
				$row->en_primary_1,
				$row->cname,
				$row->hdctrack,
				$row->remarks,
				$user_all =$id_user=='all'?$row->username:'',
				date_formating($row->call_date),
				$row->call_time,
				date_formating($row->cptp_date),
				date_formating($row->max_date),
				price_format($row->ptp_amount),
				price_format($row->max_amount),
                               $row->dpd,
                                '<b>'.$row->mdpd.'</b>',
                                '<b>'.$row->ptp_stat.'</b>',
                                price_format($row->os_ar_amount)
				);
			}
		}
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}else{
		$record_items[] = array();
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}
	}

	function get_sta_track($begindate,$enddate,$report) {
		//$this->output->enable_profiler(TRUE);
		$this->load->model('spv/hdr_sta_model','sta_model');
		$primary_1 = $this->uri->segment(4);
		$valid_fields = array('en_primary_1','primary_1','date', 'username','id_user');
		
		$this->flexigrid->validate_post('hsta.date','DESC',$valid_fields);
		$id_action_call_track = '1'; 
        $records = $this->sta_model->list_sta_flexi($begindate,$enddate,$report);
		$this->output->set_header($this->config->item('json_header'));
		$i=1;
		if($records['records']->num_rows()>0){
		
			foreach ($records['records']->result() as $row)
			{	
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
            
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}else{
		$record_items[] = array();
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}
	}
	function get_sta_rtf() {
		//$this->output->enable_profiler(TRUE);
		$this->load->model('spv/hdr_sta_model','sta_model');
		$primary_1 = $this->uri->segment(4);
		$valid_fields = array('en_primary_1','primary_1','date', 'username','id_user');
		
		$this->flexigrid->validate_post('hsr.date_in','DESC',$valid_fields);
		$id_action_call_track = '1'; 
        $records = $this->sta_model->list_sta_rtf_flexi();
		$this->output->set_header($this->config->item('json_header'));
		$i=1;
		if($records['records']->num_rows()>0){
		
			foreach ($records['records']->result() as $row)
			{	
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
            
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}else{
		$record_items[] = array();
		$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
		}
	}
}
?>