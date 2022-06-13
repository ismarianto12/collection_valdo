<?php
/*
  This script software package is NOT FREE And is Copyright 2010 (C) Valdo-intl all rights reserved.
  we do supply help or support or further modification to this script by Contact
  Haidar Mar'ie
  e-mail = haidar.m@valdo-intl.com
  e-mail = coder5@ymail.com
 */
class Hdr_spv_report_ctrl extends Controller {

    public function __construct() {
        parent::Controller();
        
        if (@$_SESSION['blevel'] != ('spv' || 'admin')) {
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

        $data_t['title'] = 'Report Debtor';
        $data['text'] = 'Report';
        $data['total_to_call'] = $this->report_model->total_to_call();

        $id_user = $_SESSION['bid_user_s'];
        $user_cond = "id_leader='" . $id_user . "'";

        //$data['report'] = $this->report_model->
        //$data['list_user'] = $this->user_model->get_list_user($user_cond);
        $this->load->view('spv/hdr_header_spv', $data_t);
        $this->load->view('spv/hdr_report_spv_view', $data);
        $this->load->view('spv/hdr_footer', $data);

    }

    public function sum_report() {
        //$this->output->enable_profiler(TRUE);
        //die();
        echo '<script>notif.hide();</script>';
        $this->load->model('admin/hdr_user_model', 'user_model');
        $begin_uri = $this->uri->segment(4);
        $end_uri = $this->uri->segment(5);
        $begindate = $begin_uri == "" ? $begindate = date('Y-m-d') : $begindate = $begin_uri;
        $enddate = $begin_uri == "" ? $enddate = date('Y-m-d') : $enddate = $end_uri;
        $data['begindate'] = $begindate;
        $data['enddate'] = $enddate;
        $data['text'] = 'Report';
        //die();
        
        $id_user = $_SESSION['bid_user_s'];
        //echo $id_user;
        $user_cond = $id_user != '22' ? "id_leader='" . $id_user . "'" : 'id_level="3" ';
       // $data['list_user'] = $this->user_model->get_list_user($user_cond);
        //die();
      	$this->report_model->before_call($user="",$id_user="",$status="",$begindate,$enddate);
        $data['all_report'] = $this->report_model->status_call($user="",$id_user="",$status="",$begindate,$enddate);
        
        //die();
        $this->load->view('spv/hdr_sum_report_view', $data);
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
    
    public function detail_status_all($id_user, $status, $begindate, $enddate, $report) {
        //$this->output->enable_profiler(TRUE);
        $data['pop_title'] = 'Detail Cases';
        //$user = 'tc';
        $this->load->helper('flexigrid');
        $this->load->model('admin/hdr_user_model', 'user_model');
        $this->load->model('hdr/hdr_load_ajax_model', 'load_ajax');
        $data = $this->load_ajax->get_status_track_all($id_user, $status, $begindate, $enddate, $report);
        $data['text'] = "History Call Track";
        $data['user'] = $id_user;
        $data['id_user'] = $id_user;
        $data['status'] = $status;
        $data['begindate'] = $begindate;
        $data['enddate'] = $enddate;
        $data['report'] = $report;
        $this->load->view('spv/hdr_pop_up_report_view', $data);
    }
    
    public function detail_status_all_spv($id_user, $status, $begindate, $enddate, $report) {
        //$this->output->enable_profiler(TRUE);
        $data['pop_title'] = 'Detail Cases';
        //$user = 'tc';
        $this->load->helper('flexigrid');
        $this->load->model('admin/hdr_user_model', 'user_model');
        $this->load->model('hdr/hdr_load_ajax_model', 'load_ajax');
        $data = $this->load_ajax->get_status_track_all_spv($id_user, $status, $begindate, $enddate, $report);
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
    
     public function report_to_csv_spv($id_user, $status, $begindate, $enddate, $report) {
        //$this->output->enable_profiler("TRUE");
        if ($status == 'AC') {
            $this->report_model->report_to_csv($id_user);
        } elseif ($status == 'untc') {
            $this->report_model->report_to_untcsv($id_user);
        } else {
            $this->report_model->report_status_to_csv_spv($id_user, $status, $begindate, $enddate, $report);
        }
    }
    
    public function report_to_csv_adm($id_user, $status, $begindate, $enddate, $report) {
        //$this->output->enable_profiler("TRUE");
        if ($status == 'AC') {
            $this->report_model->report_to_csv($id_user);
        } elseif ($status == 'untc') {
            $this->report_model->report_to_untcsv($id_user);
        } else {
            $this->report_model->report_status_to_csv_adm($id_user, $status, $begindate, $enddate, $report);
        }
    }
    public function attend($month){
        $this->report_model->attendance_report($month);
    }
    
    /* Report Harian Valdo to Adira */
    public function get_full_report(){
    	$file_now = "RH".date("Y_m_d_Gis").".txt";
    	$today = date("Y-m-d");
    	$today_fname = date("Y_m_d");
    	//die($filenow);
	//$file_now = "RH2012_02_04_195007.txt";
	//$today = '2012-02-04';
	//$today_fname = '2012_02_04';
    	
    	## Get Data from Branch Databases ##
    	
    	$truncate = 	 "TRUNCATE TABLE hdr_calltrack_sby";
    	$this->db->simple_query($truncate);
    	
	//$DBsby = $this->load->database('sby',TRUE);

    	$command = "INSERT INTO hdr_calltrack_sby(id_contact_code,id_ptp,id_location_code,id_risk_code,id_handling_debt,id_handling_code,deliquency_code,TYPE,ptp_status,primary_1,cname,debtor_name,spv_name,location_code,contact_code,risk_code,next_action_code,id_call_cat,id_action_call_track,code_call_track,id_user,id_spv,username,surveyor,angsuran_ke,remarks,no_contacted,new_phone_number,new_office_number,new_emergency_phone,new_hp,new_address,new_pos_code,memo,date_in,dpd,call_date,call_month,call_time,createdate,total_call_time,ptp_date,ptp_amount,due_date,due_time,call_attempt,incomming,is_current,in_use,sta,cycling,ptp_fu,fu,broken_date,os_ar_amount,kode_cabang)
									SELECT
									id_contact_code,id_ptp,id_location_code,id_risk_code,id_handling_debt,id_handling_code,deliquency_code,TYPE,ptp_status,primary_1,cname,debtor_name,spv_name,location_code,contact_code,risk_code,next_action_code,id_call_cat,id_action_call_track,code_call_track,id_user,id_spv,username,surveyor,angsuran_ke,remarks,no_contacted,new_phone_number,new_office_number,new_emergency_phone,new_hp,new_address,new_pos_code,memo,date_in,dpd,call_date,call_month,call_time,createdate,total_call_time,ptp_date,ptp_amount,due_date,due_time,call_attempt,incomming,is_current,in_use,sta,cycling,ptp_fu,fu,broken_date,os_ar_amount,kode_cabang
									FROM adira_collection_sby.hdr_calltrack WHERE DATE(createdate) = '$today'
    							";
    	$this->db->query($command);
    	
    	$sql_clear = "UPDATE hdr_calltrack_sby SET ptp_date = NULL where ptp_date = '0000-00-00'";
    	$this->db->simple_query($sql_clear);
    	
    	## End Get Branch Data ## 	
    	
    	$sql = "
    	SELECT 'BRANCH_ID','BRANCH_NAME','CONTRACT_NO','CUSTOMER_NAME','PROMMISED','ACTION','HANDLING_DEBITUR','RESULT_HANDLING','DELIQUENCY','STATUS_UNIT', 'STATUS_DEBITUR', 'KETERANGAN', 'PIC_HANDLING', 'TANGGAL_RESULT','OVERDUE_NUMBER','INST','TM_HANDLING'
    	UNION SELECT
    	      IFNULL(hdm.kode_cabang,'') 	AS 'BRANCH_ID',
              IFNULL(hdm.branch,'') AS 'BRANCH_NAME',
              IFNULL(hdm.primary_1,'') AS 'CONTRACT_NO',
              IFNULL(hdm.name,'') AS 'CUSTOMER_NAME',     
              IFNULL(IFNULL(hdc.ptp_date,hdcsby.ptp_date),'') AS 'PROMMISED',
              IFNULL(IFNULL(hdc.id_contact_code,hdcsby.id_contact_code),'') AS 'ACTION',
              IFNULL(IFNULL(hdc.id_handling_debt,hdcsby.id_handling_debt),'') AS 'HANDLING_DEBITUR',
              IFNULL(IFNULL(hdc.id_handling_code,hdcsby.id_handling_code),'') AS 'RESULT_HANDLING', 
              IFNULL(IFNULL(hdc.deliquency_code,hdcsby.deliquency_code),'') AS 'DELIQUENCY',
              IFNULL(hda.unit_code,'') AS 'STATUS_UNIT', 
              IFNULL(hda.debitur_code,'') AS 'STATUS_DEBITUR',
              IFNULL(IFNULL(REPLACE(REPLACE(hdc.remarks,'\\r\\n',''), '\\n',''),REPLACE(REPLACE(hdcsby.remarks,'\\r\\n',''),'\\n','')),'') AS 'KETERANGAN',  
              IFNULL(IFNULL(hdc.id_user,hdcsby.id_user),'') AS 'PIC_HANDLING',
              IFNULL(IFNULL(hdc.call_date,hdcsby.call_date),'') AS 'TANGGAL_RESULT', 
              IFNULL(hdm.dpd,'') AS 'OVERDUE_NUMBER',
	      IFNULL(hdm.angsuran_ke,'') AS 'INST',
	      IFNULL(IFNULL(hdc.call_time,hdcsby.call_time),'') AS 'TM_HANDLING'
				FROM hdr_debtor_main hdm
				LEFT JOIN hdr_calltrack hdc
					ON hdc.primary_1 = hdm.primary_1 and hdc.call_date = '$today'
				LEFT JOIN hdr_calltrack_sby hdcsby
					ON hdm.primary_1 = hdcsby.primary_1
				LEFT JOIN hdr_action_call_track hda
					ON IFNULL(hdc.id_action_call_track,hdcsby.id_action_call_track) = hda.id_action_call_track
					WHERE LENGTH(hdm.kode_cabang) < 5
					ORDER BY tanggal_result desc					
					INTO OUTFILE '/tmp/$file_now' FIELDS TERMINATED BY '|' LINES TERMINATED BY '\\r\\n';    	
    	";
    	//die($sql);
    	
    	$query = $this->db->query($sql);
    	
    	$this->load->helper('download');
        $file_path = '/tmp/' . $file_now;
    	$fixed_fname = 'RH'.$today_fname.'.txt';
      $files_real = file_get_contents($file_path);
      force_download($fixed_fname, $files_real);
    }
    
    /* Data Work Harian dari Cabang */
    public function get_branchwork(){
    	
    	## create CSV LAYOUT ##
    	$csv_layout = $this->report_model->generate_dailyBranch();
    	
    	## create ZIPPED CSV FILE ##
    	$this->report_model->zip_dailyBranch($csv_layout);
    	
    }

	/* Data Yang diskip system*/
    public function get_dataskip($flag){
    	$file_now = "DSH".date("Y_m_d_Gis").".txt";

//flag skip
    	/*
    		1 -> nomor 0 autopun kosong
    		2 -> tlp dengan alphabet
    		3 -> tlp kurang dari 5 digit
    	*/

			//syncronize

			$sql = "update hdr_debtor_main set cell_phone1=trim(cell_phone1);"; $this->db->query($sql);
			$sql = "update hdr_debtor_main set phone_1=trim(phone_1);";$this->db->query($sql);
			$sql = "update hdr_debtor_main set phone_2=trim(phone_2);";$this->db->query($sql);
			$sql = "update hdr_debtor_main set phone_3=trim(phone_3);";$this->db->query($sql);

			$sql = "update hdr_debtor_main set cell_phone1='' where cell_phone1='.';";$this->db->query($sql);
			$sql = "update hdr_debtor_main set phone_1='' where phone_1='.';";$this->db->query($sql);
			$sql = "update hdr_debtor_main set phone_2='' where phone_2='.';";$this->db->query($sql);
			$sql = "update hdr_debtor_main set phone_3='' where phone_3='.';";$this->db->query($sql);

			$sql = "update hdr_debtor_main set cell_phone1='' where cell_phone1='-';";$this->db->query($sql);
			$sql = "update hdr_debtor_main set phone_1='' where phone_1='-';";$this->db->query($sql);
			$sql = "update hdr_debtor_main set phone_2='' where phone_2='-';";$this->db->query($sql);
			$sql = "update hdr_debtor_main set phone_3='' where phone_3='-';";$this->db->query($sql);

			$sql = "update hdr_debtor_main set cell_phone1='' where cell_phone1 = '0' or cell_phone1 = '00' or cell_phone1 = '000' or cell_phone1 = '0000' or cell_phone1='00000000' or cell_phone1='0000000000' or cell_phone1='000000000' or cell_phone1='000000000000';";$this->db->query($sql);
			$sql = "update hdr_debtor_main set phone_1='' where phone_1 = '0' or phone_1 = '00' or phone_1 = '000' or phone_1 = '0000' or phone_1='00000000' or phone_1='0000000000' or phone_1='000000000' or phone_1='000000000000';";$this->db->query($sql);
			$sql = "update hdr_debtor_main set phone_2='' where phone_2 = '0' or phone_2 = '00' or phone_2 = '000' or phone_2 = '0000' or phone_2='00000000' or phone_2='0000000000' or phone_2='000000000' or phone_2='000000000000';";$this->db->query($sql);
			$sql = "update hdr_debtor_main set phone_3='' where phone_3 = '0' or phone_3 = '00' or phone_3 = '000' or phone_3 = '0000' or phone_3='00000000' or phone_3='0000000000' or phone_3='000000000' or phone_3='000000000000';";$this->db->query($sql);
			//var_dump($flag);die();
			//$flag='';
			$where = "";
			if($flag == 1)
			{
				$where .= " and (cell_phone1='' and phone_1='' and phone_2='' and phone_3='') ";
			}

			if($flag == 2)
			{				
				$where .= " and (cell_phone1 REGEXP '^[a-z]+$' and cell_phone1<>'')
					or (phone_1 REGEXP '^[a-z]+$' and phone_1<>'')
					or (phone_2 REGEXP '^[a-z]+$' and phone_2<>'')
					or (phone_3 REGEXP '^[a-z]+$' and phone_3<>'') ";
			}

			if($flag == 3)
			{
				$where .= " and (cell_phone1 <> '' and length(cell_phone1) < 5)
					and (phone_1 <> '' and length(phone_1) < 5)
					and (phone_2 <> '' and length(phone_2) < 5)
					and (phone_3 <> '' and length(phone_3) < 5) ";			
			}

			if($flag == 4)
			{
					$where .= " and (cell_phone1 <> '' and length(cell_phone1) > 12)
					and (phone_1 <> '' and length(phone_1) > 12)
					and (phone_2 <> '' and length(phone_2) > 12)
					and (phone_3 <> '' and length(phone_3) > 12) ";
			}
			
			if($flag == 5)
			{
					$where .= " and (cell_phone1 <> '' and left(cell_phone1,2) not in (08))
					and (phone_1 <> '' and left(phone_1,2) not in (08))
					and (phone_2 <> '' and left(phone_2,2) not in (08))
					and (phone_3 <> '' and left(phone_3,2) not in (08))";
			}
			
			if($flag == '0')
			{
				$where .= " and skip=1 ";
			}

    	$sql = "SELECT 'Cabang','Contract No','Name','HP','Phone_1','Phone_2','Phone_3','Paid_Status','Data Status'
    		UNION
    		SELECT  branch, primary_1, NAME, cell_phone1, phone_1, phone_2, phone_3,
    		(CASE WHEN is_paid = 1 THEN 'Paid' ELSE 'Queued' END) AS 'Paid Status',
    		(CASE WHEN called = 1 THEN 'Called' ELSE 'Skipped' END) AS 'Data Status'
    		FROM hdr_debtor_main WHERE primary_1 <> ''
    		$where
    		ORDER BY Name
    		INTO OUTFILE '/tmp/$file_now' FIELDS TERMINATED BY '|' LINES TERMINATED BY '\\r\\n';
    	";
    	//die($sql);
    	$this->db->query($sql);

/*
    	$sql = "SELECT 'Cabang','Contract No','Name','HP','Phone_1','Phone_2','Phone_3','Paid_Status','Data Status' UNION SELECT  branch, primary_1, NAME, cell_phone1, phone_1, phone_2, phone_3, (CASE WHEN is_paid = 1 THEN 'Paid' ELSE 'Queued' END) AS 'Paid Status', (CASE WHEN called = 1 THEN 'Called' ELSE 'Skipped' END) AS 'Data Status' FROM hdr_debtor_main WHERE skip = 1 OR is_paid = 1 ORDER BY Name
    					INTO OUTFILE '/tmp/$file_now' FIELDS TERMINATED BY '|' LINES TERMINATED BY '\\r\\n';    	
    	";
    	$this->db->query($sql);
*/
    	
    	$this->load->helper('download');
      $file_path = '/tmp/' . $file_now;
      $files_real = file_get_contents($file_path);
      force_download($file_now, $files_real);
    }

	/* Total Data Yang Dikerjakan per SPV harian */
	    public function get_spvDialyWork(){
    	$file_now = "SPVDW".date("Y_m_d_Gis").".txt";
    	$sql = "
    	SELECT UPPER(b.username) as 'USERNAME',
	(CASE a.object_group WHEN '001' THEN 'MOTOR' WHEN '002' THEN 'MOBIL' ELSE 'OTHER' END) AS 'OBJECT_GROUP',
	IFNULL(COUNT(primary_1),0) AS 'WORK',
	IFNULL(COUNT(CASE id_call_cat WHEN 1 THEN primary_1 END),0) AS 'CONTACT',
	IFNULL(ROUND(SUM(CASE id_call_cat WHEN 1 THEN os_ar_amount END),0),0) AS 'CONTACT_AMO',
	IFNULL(COUNT(CASE id_call_cat WHEN 2 THEN primary_1 END),0) AS 'UNCONTACT',
	IFNULL(ROUND(SUM(CASE id_call_cat WHEN 2 THEN os_ar_amount END),0),0) AS 'UNCONTACT_AMO',
	IFNULL(COUNT(CASE WHEN id_ptp = 1 AND id_call_cat = 1 THEN primary_1 END),0) AS 'PTP',
	IFNULL(ROUND(SUM(CASE WHEN id_ptp = 1 AND id_call_cat = 1 THEN os_ar_amount END),0),0) AS 'PTP_AMO',
	IFNULL(COUNT(CASE WHEN id_ptp = 1 AND id_call_cat = 1 AND ptp_status = 0 THEN primary_1 END),0) AS 'ACTIVE_PTP',
	IFNULL(ROUND(SUM(CASE WHEN id_ptp = 1 AND id_call_cat = 1 AND ptp_status = 0 THEN os_ar_amount END),0),0) AS 'ACTIVE_PTP_AMO',
	IFNULL(COUNT(CASE WHEN id_ptp = 1 AND id_call_cat = 1 AND ptp_status = 2 THEN primary_1 END),0) AS 'KEEP_PTP',
	IFNULL(ROUND(SUM(CASE WHEN id_ptp = 1 AND id_call_cat = 1 AND ptp_status = 2 THEN os_ar_amount END),0),0) AS 'KEEP_AMO',
	IFNULL(COUNT(CASE WHEN id_ptp = 1 AND id_call_cat = 1 AND ptp_status = 1 THEN primary_1 END),0) AS 'BROKEN_PTP',
	IFNULL(ROUND(SUM(CASE WHEN id_ptp = 1 AND id_call_cat = 1 AND ptp_status = 1 THEN os_ar_amount END),0),0) AS 'BROKEN_AMO'
	FROM hdr_calltrack a
	LEFT JOIN hdr_user b
	ON a.id_spv = b.id_user
	WHERE call_date = CURDATE()
	AND primary_1 <> '' AND a.createdate = (SELECT MAX(createdate) FROM hdr_calltrack c WHERE c.primary_1 = a.primary_1 LIMIT 1)
	GROUP BY b.username,a.object_group
    	";
    	
	$this->load->dbutil();
    	$this->load->helper('download');
    	
    	$delimiter = "|";
 	$newline = "\r\n";
    	
    	$query = $this->db->query($sql);
    	
    	$csv_layout = $this->dbutil->csv_from_result($query,$delimiter,$newline);
    	$query->free_result();
    	$csv_layout = preg_replace('!(")!','',$csv_layout);
    	
    	force_download($file_now,$csv_layout);
    	
    }
	
	public function report_adira(){
			$data['title'] = "Daily Report";
			/*$post['fromdate'] = $this->input->post('fromdate') ? $this->input->post('fromdate') : date("Y-m-d");;
			$fromdate = $post['fromdate'];
			$post['enddate'] = $this->input->post('enddate') ? $this->input->post('enddate') : date("Y-m-d");;
			$enddate = $post['enddate'];
			$this->load->model('spv/hdr_report_spv_model', 'report_model');
			
			$post['isSearch'] = $this->input->post('isAssign',TRUE);
			
			if($post['isSearch'] == '1'){
				//die($fromdate." to ".$enddate);
				$data['daily_report'] = $this->report_model->daily_report($fromdate,$enddate);
			} else {
				//die($fromdate." to ".$enddate);
				$data['daily_report'] = $this->report_model->daily_report($fromdate,$enddate);
			}*/
			//$data['daily_report_daily'] = $this->report_model->daily_report_daily();
			
			
			
			$this->load->view('spv/hdr_header_spv', $data);
			$this->load->view('spv/hdr_report_daily_adira', $data);
			$this->load->view('spv/hdr_footer', $data);
		}
		
		public function report_adira_view(){
			$bulan			= $this->uri->segment(4);
			$tahun 			= $this->uri->segment(5);
			$area 			= $this->uri->segment(6);
			
			$month 			= $bulan == "undefined" ? $month = date('m') : $month = $bulan;
			$year 			= $tahun == "undefined" ? $year = date('Y') : $year = $tahun;
			$location 		= $area == "01" ? $location = '01' : $location = '02';
			$data['month'] 	= $month;
			$data['year'] 	= $year;
			$data['location'] 	= $location;
			//die($month." - ".$year." - ".$location);
			$data['row_daily1'] = $this->report_model->daily_report1($month,$year,$location);
			$data['row_daily2'] = $this->report_model->daily_report1($month,$year,$location);
			$data['row_daily3'] = $this->report_model->daily_report3($month,$year,$location);
			$data['row_daily4'] = $this->report_model->daily_report4($month,$year,$location);
			$data['row_daily5'] = $this->report_model->daily_report5($month,$year,$location);
			//$data['row_daily5'] = $this->report_model->daily_report5($month,$year,$location);
			
			$data['row_daily6'] = $this->report_model->daily_report6($month,$year,$location);
			$data['row_daily7'] = $this->report_model->daily_report7($month,$year,$location);
			$data['row_daily8'] = $this->report_model->daily_report8($month,$year,$location);
			$data['row_daily9'] = $this->report_model->daily_report9($month,$year,$location);
			$data['row_daily10'] = $this->report_model->daily_report10($month,$year,$location);
			
			$data['row_daily11'] = $this->report_model->daily_report11($month,$year,$location);
			$data['row_daily12'] = $this->report_model->daily_report12($month,$year,$location);
			$data['row_daily13'] = $this->report_model->daily_report13($month,$year,$location);
			$data['row_daily14'] = $this->report_model->daily_report14($month,$year,$location);
			$data['row_daily15'] = $this->report_model->daily_report15($month,$year,$location);
			
			$data['row_daily16'] = $this->report_model->daily_report16($month,$year,$location);
			
			
			$export = @$_POST['export'];
			if($export){
				$month = @$_POST['bulan'];
				$year = @$_POST['tahun'];
				$location = @$_POST['area'];
				
				$data['month'] 	= $month;
				$data['year'] 	= $year;
				$data['location'] 	= $location;
				//die($month." - ".$year." - ".$location);
				
				$data['row_daily1'] = $this->report_model->daily_report1($month,$year,$location);
				$data['row_daily2'] = $this->report_model->daily_report1($month,$year,$location);
				$data['row_daily3'] = $this->report_model->daily_report3($month,$year,$location);
				$data['row_daily4'] = $this->report_model->daily_report4($month,$year,$location);
				$data['row_daily5'] = $this->report_model->daily_report5($month,$year,$location);
				//$data['row_daily5'] = $this->report_model->daily_report5($month,$year,$location);
				
				$data['row_daily6'] = $this->report_model->daily_report6($month,$year,$location);
				$data['row_daily7'] = $this->report_model->daily_report7($month,$year,$location);
				$data['row_daily8'] = $this->report_model->daily_report8($month,$year,$location);
				$data['row_daily9'] = $this->report_model->daily_report9($month,$year,$location);
				$data['row_daily10'] = $this->report_model->daily_report10($month,$year,$location);
				
				$data['row_daily11'] = $this->report_model->daily_report11($month,$year,$location);
				$data['row_daily12'] = $this->report_model->daily_report12($month,$year,$location);
				$data['row_daily13'] = $this->report_model->daily_report13($month,$year,$location);
				$data['row_daily14'] = $this->report_model->daily_report14($month,$year,$location);
				$data['row_daily15'] = $this->report_model->daily_report15($month,$year,$location);
				
				$data['row_daily16'] = $this->report_model->daily_report16($month,$year,$location);
				
				$date = date("Y-m-d");
				$this->load->view('spv/print_dailyreport', $data);
				$filename = "Daily_Report_".$month."_".$year.".xls";
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private", false);
				header("Content-Type: application/vnd.ms-excel");
				header("Content-Disposition: attachment; filename=" . $filename );
				header("Content-Transfer-Encoding: binary");
				echo $html;
			}
			
			$this->load->view('spv/hdr_report_daily_adira_view', $data);
		}
		
		public function report_adira_call_total(){
			$data['title'] = "Daily Report";
			$post['fromdate'] = $this->input->post('fromdate') ? $this->input->post('fromdate') : date("Y-m-d");;
			$fromdate = $post['fromdate'];
			$post['enddate'] = $this->input->post('enddate') ? $this->input->post('enddate') : date("Y-m-d");;
			$enddate = $post['enddate'];
			$this->load->model('spv/hdr_report_spv_model', 'report_model');
			
			$post['isSearch'] = $this->input->post('isAssign',TRUE);
			
			if($post['isSearch'] == '1'){
				//die($fromdate." to ".$enddate);
				$data['call_total_report'] = $this->report_model->call_total_report($fromdate,$enddate);
			} else {
				//die($fromdate." to ".$enddate);
				$data['call_total_report'] = $this->report_model->call_total_report($fromdate,$enddate);
			}
			//$data['daily_report_daily'] = $this->report_model->daily_report_daily();
			
			$this->load->view('spv/hdr_header_spv', $data);
			$this->load->view('spv/hdr_report_call_total_adira', $data);
			$this->load->view('spv/hdr_footer', $data);
		}
		public function report_adira_call_untouch(){
			$data['title'] = "Daily Report";
			$post['fromdate'] = $this->input->post('fromdate') ? $this->input->post('fromdate') : date("Y-m-d");;
			$fromdate = $post['fromdate'];
			$post['enddate'] = $this->input->post('enddate') ? $this->input->post('enddate') : date("Y-m-d");;
			$enddate = $post['enddate'];
			$this->load->model('spv/hdr_report_spv_model', 'report_model');
			
			$post['isSearch'] = $this->input->post('isAssign',TRUE);
			
			if($post['isSearch'] == '1'){
				//die($fromdate." to ".$enddate);
				$data['call_untouch_report'] = $this->report_model->call_untouch_report($fromdate,$enddate);
			} else {
				//die($fromdate." to ".$enddate);
				$data['call_untouch_report'] = $this->report_model->call_untouch_report($fromdate,$enddate);
			}
			//$data['daily_report_daily'] = $this->report_model->daily_report_daily();
			
			$this->load->view('spv/hdr_header_spv', $data);
			$this->load->view('spv/hdr_report_call_untouch_adira', $data);
			$this->load->view('spv/hdr_footer', $data);
		}
		public function report_adira_average(){
			$data['title'] = "Daily Report";
			$post['fromdate'] = $this->input->post('fromdate') ? $this->input->post('fromdate') : date("Y-m-d");;
			$fromdate = $post['fromdate'];
			$post['enddate'] = $this->input->post('enddate') ? $this->input->post('enddate') : date("Y-m-d");;
			$enddate = $post['enddate'];
			$this->load->model('spv/hdr_report_spv_model', 'report_model');
			
			$post['isSearch'] = $this->input->post('isAssign',TRUE);
			
			if($post['isSearch'] == '1'){
				//die($fromdate." to ".$enddate);
				$data['call_average_report'] = $this->report_model->call_average_report($fromdate,$enddate);
			} else {
				//die($fromdate." to ".$enddate);
				$data['call_average_report'] = $this->report_model->call_average_report($fromdate,$enddate);
			}
			//$data['daily_report_daily'] = $this->report_model->daily_report_daily();
			
			$this->load->view('spv/hdr_header_spv', $data);
			$this->load->view('spv/hdr_report_call_average_adira', $data);
			$this->load->view('spv/hdr_footer', $data);
		}

}

?>
