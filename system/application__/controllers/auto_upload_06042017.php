<?php
//script for crontab use <- Martin [31 Dec 2011]
class Auto_upload extends Controller {

    public function __construct() {
      parent::Controller();
      $this->load->model('hdr_debtor/hdr_debtor_model', 'debtor_model');
      $this->load->model('user/hdr_call_track_model', 'call_track_model');
      $this->load->model('spv/hdr_report_spv_model', 'spv_report_model');
      $this->load->model('admin/hdr_upload_model', 'upload_model');
      
    }

    public function index()
    {
      //$this->read_dataMaster();
    }

    public function read_dataMaster()
    {
    	$file = array();
    	$url = "/home/adira/data/adira to valdo";
    	//$url = "C:/Users/martin/Documents/adira";
    	$is_dir = is_dir($url);
    	$today = date('Y_m_d');
    	if($is_dir == 1){
    		$dir = opendir($url);
    		while (($read = readdir($dir))!== false) {
    			if($read != ".." && $read != ".") { 	
						
						//add by nudi
						$ext = pathinfo($url.'/'.$read, PATHINFO_EXTENSION);
					
							if($ext == 'txt')
    						$file[] = $read; //available file

    			} else {$read = "";}
    		}
    	
    } else { die("Not a Dir"); }

//var_dump($file);
//die("dorrr");

  		//file name DC = Data Customer <- Validation
    	foreach($file as $cfile){
    		if(substr($cfile,0,2) == "DC") { $master_arr[] = $cfile;}
    	} 
   		
   		//upload only today file <- Validation
   		$is_success = 0;
   		$is_executed = 0;
   		$file_size = 0;
   		
   		foreach (@$master_arr as $master){
   		if(substr($master,2,10) == $today){
   			$file_size = filesize($url."/".$master);
   			$is_locked = $this->checkLock();
   			
   			if($is_locked == 1){
   				echo "Last upload process not completed yet";
   				die();
   			}
   			
   			$lock_id = $this->createPraLog($master);
   			
   			$number_try = $this->checkToday_upload($type = 'master');
   			
			   			if($number_try == 0) {
			   				
			   					$this->upload_model->empty_table($table = "hdr_debtor_main_temp");
					   			$this->upload_model->empty_table($table = "hdr_tmp_log_temp");
									$this->upload_model->empty_table($table = "hdr_debtor_main");
									$this->upload_model->empty_table($table = "hdr_tmp_log");
									
					   			$this->upload_model->regular_upload($url."/".$master);
					   			$master_file = $master;
					   			$countsql = "SELECT count(id_debtor) as num FROM hdr_debtor_main";
					   			$result = $this->db->query($countsql);
					   			$resultcount_arr = $result->row();
					   			$resultcount = $resultcount_arr->num;
   			   			
   								$is_success = 1 ;
   								echo "Master Success On First Try";
   								$subject = "AutoUpload Automatic Email";
   								$content = "Auto Upload MasterData Done On First Try At ".date("d-m-Y H:i:s")." Total Data :".$resultcount;
   								$this->emailThis($subject,$content);
			   			} else if ($number_try > 0) {
			  				$file_size_old = $this->checkToday_filesize($type = 'master');
			  				if(intval($file_size_old) == 0){
			  					echo "Running ".($number_try+1)." Try";
			  					$this->upload_model->empty_table($table = "hdr_debtor_main_temp");
					   			$this->upload_model->empty_table($table = "hdr_tmp_log_temp");
									$this->upload_model->empty_table($table = "hdr_debtor_main");
									$this->upload_model->empty_table($table = "hdr_tmp_log");
									
					   			$this->upload_model->regular_upload($url."/".$master);
					   			$master_file = $master;
					   			$countsql = "SELECT count(id_debtor) as num FROM hdr_debtor_main";
					   			$result = $this->db->query($countsql);
					   			$resultcount_arr = $result->row();
					   			$resultcount = $resultcount_arr->num;
					   			
					   			$is_success = 1 ;
					   			$subject = "AutoUpload Automatic Email";
					   			$content = "Auto Upload MasterData Done On ".($number_try+1)." Try At ".date("d-m-Y H:i:s")." Total Data :".$resultcount;
					   			$this->emailThis($subject,$content);
			  				} else if($file_size_old != 0 && $file_size > $file_size_old ){
			  						echo "Running ".($number_try+1)." Try Because Data Modified";
			  						$this->upload_model->empty_table($table = "hdr_debtor_main_temp");
					   				$this->upload_model->empty_table($table = "hdr_tmp_log_temp");
										$this->upload_model->empty_table($table = "hdr_debtor_main");
										$this->upload_model->empty_table($table = "hdr_tmp_log");
										
						   			$this->upload_model->regular_upload($url."/".$master);
						   			$master_file = $master;
						   			$countsql = "SELECT count(id_debtor) as num FROM hdr_debtor_main";
						   			$result = $this->db->query($countsql);
						   			$resultcount_arr = $result->row();
						   			$resultcount = $resultcount_arr->num;
						   			$is_success = 1 ;
						   			$subject = "AutoUpload Automatic Email";
					   				$content = "ReRuning Auto Upload (Data Modified) MasterData Done On ".($number_try+1)." Try At ".date("d-m-Y H:i:s")." Total Data :".$resultcount;
					   				$this->emailThis($subject,$content);
			  				} else{
			  					$is_success = 2;
			  				}
			   			}
   			}
   		}
   		
   		$this->clearLock($lock_id);
   		
   		## Create Log File ##
   		if($is_success == 1){
   			$sql = "insert into auto_upload_log(upload_type,filename,datacount,file_size) values ('master','$master_file','$resultcount',$file_size)";
   			$this->db->simple_query($sql);
   		}
   		else if($is_success == 2){
   			echo "Nothing Executed, Data is UpToDate";
   		}
   		else { 
   			$sql = "insert into auto_upload_log(upload_type,filename,datacount,file_size) values ('master','No Valid Master File Found','0',$file_size)";
   			$this->db->simple_query($sql);
   			$subject = "AutoUpload Automatic Email";
				$content = "Auto Upload MasterData Failed On ".($number_try+1)." Try At ".date("d-m-Y H:i:s")." NoData Found On Server";
				$this->emailThis($subject,$content);
   		}
   		## End Log File ##
		
		}

		
		//batch 1 payment
		public function read_payment1()
    {
    	$file = array();
    	$url = "/home/adira/data/adira to valdo";
    	$is_dir = is_dir($url);
    	$today = date('Y_m_d');
    	if($is_dir == 1){
    		$dir = opendir($url);
    		while (($read = readdir($dir))!== false) {
    			if($read != ".." && $read != ".") { 	
    			$file[] = $read; //available file
    			} else {$read = "";}
    		}
    	
    } else {die("read dir failed");}

  		//file name HP = Payment <- Validation
    	foreach($file as $cfile){
    		if(substr($cfile,0,2) == "HP") { $payment_arr[] = $cfile;}
    		}
   		//upload only today file <- Validation
   		$is_success = 0;
   		foreach($payment_arr as $payment){
   		if(substr($payment,2,13) == $today."_07"){
   			$payment1_file = $payment;
   			##start upload
   			$this->upload_model->payment_upload($url."/".$payment);
   			
   			$day = date('Y-m-d');
   			$countsql = "SELECT count(id_payment) as num FROM hdr_payment where create_date LIKE '$day 07%'";
   			$result = $this->db->query($countsql);
   			$resultcount_arr = $result->row();
   			$resultcount = $resultcount_arr->num;
   			
   			$is_success = 1;
   			} 
   		}
   		
   		## Create Log File ##
   		if($is_success == 1){
	   			$sql = "insert into auto_upload_log(upload_type,filename,datacount) values ('payment','$payment1_file','$resultcount')";
	   			$this->db->simple_query($sql);
   			} else {
   				$sql = "insert into auto_upload_log(upload_type,filename,datacount) values ('payment','No Valid Payment[1] File Found','0')";
	   			$this->db->simple_query($sql);
   			}
   		## End Log File ##
   		
		}
		
		
		//batch 2 payment
		public function read_payment2()
    {
    	$file = array();
    	$url = "/home/adira/data/adira to valdo";
    	$is_dir = is_dir($url);
    	$today = date('Y_m_d');
    	if($is_dir == 1){
    		$dir = opendir($url);
    		while (($read = readdir($dir))!== false) {
    			if($read != ".." && $read != ".") { 	
    			$file[] = $read; //available file
    			} else {$read = "";}
    		}
    	
    } else {die("read dir failed");}

  		//file name HP = Payment <- Validation
    	foreach($file as $cfile){
    		if(substr($cfile,0,2) == "HP") { $payment_arr[] = $cfile;} // get payment file
    		}
   		//upload only today file <- Validation
   		$is_success = 0;
   		foreach($payment_arr as $payment){
   		if(substr($payment,2,13) == $today."_12"){
   			$payment2_file = $payment;
   			##start upload
   			$this->upload_model->payment_upload($url."/".$payment);
   			
   			$day = date('Y-m-d');
   			$countsql = "SELECT count(id_payment) as num FROM hdr_payment where create_date LIKE '$day 12%'";
   			$result = $this->db->query($countsql);
   			$resultcount_arr = $result->row();
   			$resultcount = $resultcount_arr->num;
   			$is_success = 1; 			
   			
   			} 
   		}
   		  		
   		## Create Log File ##
   		if($is_success == 1){
	   			$sql = "insert into auto_upload_log(upload_type,filename,datacount) values ('payment','$payment2_file','$resultcount')";
	   			$this->db->simple_query($sql);
   			} else {
   				$sql = "insert into auto_upload_log(upload_type,filename,datacount) values ('payment','No Valid Payment[2] File Found','0')";
	   			$this->db->simple_query($sql);
   			}
  		## End Log File ##
		}
		
		//final report to adira sftp server
		function final_report()
		{
			//echo phpinfo();
			$this->load->library('sftp');
			//var_dump($a) ;
			$localurl = "/home/adira/data/valdo to adira/";
			$to_url = "/Deskcoll/in/";
			$fileprefix = "RH".date("Y_m_d").".txt";
			$localprefix = $localurl.$fileprefix;
			$to_prefix = $to_url.$fileprefix;
			$sftp_config['hostname'] = '10.96.99.20';
			$sftp_config['username'] = 'valdo-sftp';
			$sftp_config['password'] = '!Us3rV@ldo';
			$sftp_config['debug'] = FALSE;
			$file_size = 0;
			$file_size = @filesize($localprefix);
			$number_try = $this->checkToday_upload($type = 'finalReport');
		  $success = 0;
		  $is_connect = 0;
			//try connect
			@$is_connect = @$this->sftp->connect($sftp_config);
			//echo $is_connect;
			//die();
		  
		  //begin uploading to server
		 	if($number_try == 0 && $file_size != 0){
		 		//first try
		  	$success = $this->sftp->upload($localprefix,$to_prefix);
			}
			else if($number_try > 0 && $file_size != 0 ){
				$old_file_size = $this->checkToday_filesize($type = 'finalReport');
				
					if(intval($old_file_size) == 0){
						//another try
						$success = $this->sftp->upload($localprefix,$to_prefix);
					} else if( intval($old_file_size) != 0 && (intval($file_size) > intval($old_file_size)) ) {
						//modified try
						$success = $this->sftp->upload($localprefix,$to_prefix);
					}
					else {
						$success = 2;	
					}
			}
			
			
		  if($success == 1 || $success == "1") 
		  {
		  		$sql = "insert into auto_upload_log(upload_type,filename,datacount,file_size) values ('finalReport','$fileprefix',1,$file_size)";
		  		$this->db->simple_query($sql);
		  		$subject = "AutoUpload Automatic Email";
		  		$content = "Auto Upload FinalReport Done On ".($number_try+1)." Try At ".date("d-m-Y H:i:s")."";
		  		$this->emailThis($subject,$content);
		  		
		  }else if( intval($success) == 2){
		  		echo "Nothing Updated";
		  }else {
			  	$sql = "insert into auto_upload_log(upload_type,filename,datacount,file_size) values ('finalReport','FinalReport File Not Found',0,0)";
			  	$this->db->simple_query($sql);
			  	$reason = "System unable to determine the error";
			  	if($file_size == 0){ $reason = "No file found on local server"; } 
			  	else if($file_size != 0 && $is_connect != 1){ $reason = "Unable to connect to Remote SFTP";}
			  	$subject = "AutoUpload Automatic Email";
			  	$content = "Auto Upload FinalReport Failed On ".($number_try+1)." Try At ".date("d-m-Y H:i:s")."Error :". $reason;
			  	$this->emailThis($subject,$content);
		  }
		}
		
		function checkToday_upload($type){
			
			if($type == 'master'){
				$sql = "SELECT id_upload FROM auto_upload_log WHERE upload_type = '$type' AND
								DATE(create_date) = curdate()";
			}
			else if($type == 'finalReport'){
				$sql = "SELECT id_upload FROM auto_upload_log WHERE upload_type = '$type' AND
								DATE(create_date) = curdate()";
				
			}
			$query = $this->db->query($sql);
			
			if(!$query) { $return = 0 ;} else { $return = $query->num_rows(); }
			
			return $return;
		}
		
		function checkToday_filesize($type){
			if($type == 'master'){
				$sql = "SELECT file_size FROM auto_upload_log WHERE upload_type = '$type' AND
								DATE(create_date) = curdate() ORDER BY id_upload DESC LIMIT 1";
			}
			else if($type == 'finalReport'){
				$sql = "SELECT file_size FROM auto_upload_log WHERE upload_type = '$type' AND
								DATE(create_date) = curdate() ORDER BY id_upload DESC LIMIT 1";
			}
			
			$query = $this->db->query($sql);
			if(!$query) { $return = 0 ;} 
			else { 
				$res_arr = $query->row_array(); 
				$return = intval($res_arr['file_size']);
			}
			return $return;
		}
		
		function emailThis($subject = 'Unsubjected',$content = 'Invalid Content'){
			//die('hehe');
			
   			//$this->load->library('email');
   			
   			$config['protocol'] = 'smtp';
   			$config['smtp_host'] = 'tcp://172.25.117.11';
   			$config['smtp_port'] = '25';
   			$config['smtp_user'] = 'danus.saputra@valdo-intl.com';
   			$config['smtp_pass'] = 'Pa$$word';
   			$config['_smtp_auth'] = FALSE;
   			$config['send_multipart'] = FALSE;
   			//var_dump($config['smtp_pass']);
   			//die();
   			$config['mailtype'] = 'text';
   			$config['validate'] = TRUE;
   			$config['smtp_timeout'] = 5;
   			$config['crlf'] = "\r\n";
				$config['newline'] = "\r\n"; 
   			$this->load->library('email', $config);
   			//$this->email->initialize($config);

 				$this->email->from('danus.saputra@valdo-intl.com', 'Danus');
 				$this->email->to('danus.saputra@valdo-intl.com');  
 				$this->email->cc('martin.indrawan@valdo-intl.com');
 

 				$this->email->subject($subject);
 				$this->email->message($content); 

 				$this->email->send();
 				echo $this->email->print_debugger();
		}
		
		function createPraLog($filename){
			
			$insertData = array(
				'filename'=> $filename,
				'upload_type'=> 'lock',
				'datacount'=> 0,
				'file_size'=> 0
			);
			
			$this->db->insert('auto_upload_log',$insertData);
			$return = $this->db->insert_id();
			//var_dump($insertData);
			
			return $return;
		}
		
		function checkLock(){
			$this->db->where('upload_type', 'lock');
			$this->db->where('DATE(create_date) = CURDATE()');
			$qryObj = $this->db->get('auto_upload_log');
			
			$num_rows = $qryObj->num_rows();
			//echo $this->db->last_query();
			if($num_rows > 0){
				return 1;	
			} else {
				return 0;
			}
		}
		
		function clearLock($lock_id){
			
			$this->db->where('id_upload', $lock_id);	
			$this->db->delete('auto_upload_log');
			
		}
		
		function update_accountUsed(){
			
			$tanggal = DATE('d');
			if($tanggal == '01'){
				$sql = "TRUNCATE TABLE account_used_bag";
				$this->db->simple_query($sql);
			}
			
			$dstart = DATE("Y-m-01");
			
			## Optimizing calltrack;
			$sql = "OPTIMIZE TABLE hdr_calltrack";
			$this->db->simple_query($sql);
			
			## Optimizing account used bag;
			$sql = "OPTIMIZE TABLE account_used_bag";
			$this->db->simple_query($sql);
			
			##updating used bag;
			//remark tgl20may2016
			/*
			$sql = "INSERT IGNORE INTO account_used_bag(`primary_1`, `type`)
								SELECT primary_1, '1' FROM hdr_calltrack 
								WHERE call_date BETWEEN '$dstart' AND CURDATE()
								AND primary_1 <> ''
								GROUP BY primary_1
			";
			$this->db->simple_query($sql);			
			*/
			
			##deleting last 7 day data
			$sql = "DELETE FROM account_used_bag WHERE type = '2'";
			$this->db->simple_query($sql);
			
			##inserting new last 7 day data;
			$sql = "INSERT IGNORE INTO account_used_bag (`primary_1`, `type`)
    					SELECT primary_1, '2' FROM hdr_calltrack
    					WHERE call_date BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 DAY) AND CURDATE() 
    					AND id_handling_code = '02'
    					AND primary_1 <> ''
    					GROUP BY primary_1";
    	$this->db->simple_query($sql);
			
		}
		
		function update_retouchBag(){
			## Truncate data retouch
			$sql = "TRUNCATE TABLE retouch_bag";
			$this->db->simple_query($sql);
			
			## Optimizing calltrack;
			$sql = "OPTIMIZE TABLE hdr_calltrack";
			$this->db->simple_query($sql);
			
			## Insert to retouch_bag
			$bdate = date("Y-m-01");
			
			$sql = "INSERT IGNORE INTO retouch_bag (`primary_1`)
							SELECT DISTINCT primary_1 FROM
									(
									  SELECT * FROM
										(
											SELECT 
											primary_1,call_date, createdate, id_handling_code
											FROM hdr_calltrack
											WHERE call_date BETWEEN '$bdate' AND CURDATE()
											AND primary_1 <> '' 
											ORDER BY createdate DESC
										) un 
									  GROUP BY primary_1
									) grp
							WHERE
								id_handling_code NOT IN ('05', '02')	
			";
			$this->db->simple_query($sql);
			
		}
		
		function info(){
			echo phpinfo();
		}
		function link_report1(){
			//die('haha');
			$file_now = "DPD1.txt";
			$sql = "SELECT @no:=@no+1 no, primary_1 AS no_kontrak, LOWER( NAME ) AS nama, IF( cell_phone1 =0, phone_1, cell_phone1 ) AS New_phone, angsuran_ke AS angsuran, substring_index( lower( product ) , '/', 1 ) AS jenis, substring_index( lower( product ) , '/', -1 ) AS merk, police_no AS nopol, due_date AS jatuh_tempo,shift AS minimum, debt_amount AS tagihan, kode_cabang
                FROM hdr_debtor_main, (SELECT @no:= 0) AS NO
                WHERE dpd = '1' and skip='1' and (cell_phone1 != '-' or phone_1 != '-') and (cell_phone1 != '' or phone_1 != '') and (cell_phone1 != 'TIDAK ADA' or phone_1 != 'TIDAK ADA') and (substr(cell_phone1, 1, 2) != '00' or substr(phone_1, 1, 2) != '00') and substr(cell_phone1, 1, 2) != '+6' and substr(cell_phone1, 1, 2) != '62' and (cell_phone1 != '0' or phone_1 != '0')
                ";
			//and cell_phone1 != '-' and phone_1 != '-' and cell_phone1 != '' and phone_1 != '' and cell_phone1 != 'TIDAK ADA' and phone_1 != 'TIDAK ADA' and substr(cell_phone1, 1, 2) != '00' and substr(cell_phone1, 1, 2) != '+6' and substr(cell_phone1, 1, 2) != '62' and substr(phone_1, 1, 2) != '00' and cell_phone1 != '0' and phone_1 != '0' 
			//and cell_phone1 = '-' or phone_1 != '-' or cell_phone1 != '' or phone_1 != '' or cell_phone1 = 'TIDAK ADA' or phone_1 != 'TIDAK ADA' or substr(cell_phone1, 1, 2) != '00' or substr(cell_phone1, 1, 2) != '+6' or substr(cell_phone1, 1, 2) != '62' or substr(phone_1, 1, 2) != '00' or cell_phone1 != '0' or phone_1 != '0'
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
		function link_report2(){
			$file_now = "DPD-3.txt";
			$sql = "SELECT @no:=@no+1 No, primary_1 AS no_kontrak, LOWER( NAME ) AS nama, IF( cell_phone1 =0, phone_1, cell_phone1 ) AS New_phone, angsuran_ke AS angsuran, substring_index( lower( product ) , '/', 1 ) AS jenis, substring_index( lower( product ) , '/', -1 ) AS merk, police_no AS nopol, due_date AS jatuh_tempo,shift AS minimum, debt_amount AS tagihan, kode_cabang
				FROM `hdr_debtor_main`, (SELECT @no:= 0) AS NO WHERE dpd ='-3' and skip='1' and (cell_phone1 != '-' or phone_1 != '-') and (cell_phone1 != '' or phone_1 != '') and (cell_phone1 != 'TIDAK ADA' or phone_1 != 'TIDAK ADA') and (substr(cell_phone1, 1, 2) != '00' or substr(phone_1, 1, 2) != '00') and substr(cell_phone1, 1, 2) != '+6' and substr(cell_phone1, 1, 2) != '62' and (cell_phone1 != '0' or phone_1 != '0')";
			$q = $this->db->query($sql);
			
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


			function link_report3(){
			//die('haha');
			$file_now = "DPD-2.txt";
			$sql = "SELECT @no:=@no+1 No, primary_1 AS no_kontrak, LOWER( NAME ) AS nama, IF( cell_phone1 =0, phone_1, cell_phone1 ) AS New_phone, angsuran_ke AS angsuran, substring_index( lower( product ) , '/', 1 ) AS jenis, substring_index( lower( product ) , '/', -1 ) AS merk, police_no AS nopol, due_date AS jatuh_tempo,shift AS minimum, debt_amount AS tagihan, kode_cabang
                	FROM hdr_debtor_main, (SELECT @no:= 0) AS NO
                	WHERE dpd = '-2' and skip='1' and (cell_phone1 != '-' or phone_1 != '-') and (cell_phone1 != '' or phone_1 != '') and (cell_phone1 != 'TIDAK ADA' or phone_1 != 'TIDAK ADA') and (substr(cell_phone1, 1, 2) != '00' or substr(phone_1, 1, 2) != '00') and substr(cell_phone1, 1, 2) != '+6' and substr(cell_phone1, 1, 2) != '62' and (cell_phone1 != '0' or phone_1 != '0') 
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

		function link_report4(){
			//die('haha');
			$file_now = "DPD0.txt";
			$sql = "SELECT @no:=@no+1 No, primary_1 AS no_kontrak, LOWER( NAME ) AS nama, IF( cell_phone1 =0, phone_1, cell_phone1 ) AS New_phone, angsuran_ke AS angsuran, substring_index( lower( product ) , '/', 1 ) AS jenis, substring_index( lower( product ) , '/', -1 ) AS merk, police_no AS nopol, due_date AS jatuh_tempo,shift AS minimum, debt_amount AS tagihan, kode_cabang
                	FROM hdr_debtor_main, (SELECT @no:= 0) AS NO
                	WHERE dpd = '0' and skip='1' and (cell_phone1 != '-' or phone_1 != '-') and (cell_phone1 != '' or phone_1 != '') and (cell_phone1 != 'TIDAK ADA' or phone_1 != 'TIDAK ADA') and (substr(cell_phone1, 1, 2) != '00' or substr(phone_1, 1, 2) != '00') and substr(cell_phone1, 1, 2) != '+6' and substr(cell_phone1, 1, 2) != '62' and (cell_phone1 != '0' or phone_1 != '0') 
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

		
}
?>
