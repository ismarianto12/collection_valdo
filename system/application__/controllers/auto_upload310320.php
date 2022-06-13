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
		$number_try2 = $this->checkToday_upload($type = 'master');
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
				$content = "Auto Upload MasterData Failed On ".($number_try2+1)." Try At ".date("d-m-Y H:i:s")." NoData Found On Server";
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
			//die('test');
			//echo phpinfo();
			$this->load->library('sftp');
			//var_dump($a) ;
			$localurl = "/home/adira/data/valdo to adira/";
			//$to_url = "/Deskcoll/in/";//folder sebelum nya
			$to_url = "/";//folder sekarang
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
		
		//report voice blast
		function final_report_vb()
		{
			//die('test');
			//echo phpinfo();
			$this->load->library('sftp');
			//var_dump($a) ;
			$localurl = "/home/adira/data/VoiceBlast/IN/";
			$to_url = "/Backup/in/";
			$fileprefix = "RVB".date("22mY").".txt";
			//die($fileprefix);
			$localprefix = $localurl.$fileprefix;
			$to_prefix = $to_url.$fileprefix;
			$sftp_config['hostname'] = '10.96.99.20';
			$sftp_config['username'] = 'admf-deskcoll';
			$sftp_config['password'] = 'AdMF_De5kc0ll';
			$sftp_config['debug'] = FALSE;
			$file_size = 0;
			$file_size = @filesize($localprefix);
			$number_try = $this->checkToday_upload($type = 'VB');
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
				$old_file_size = $this->checkToday_filesize($type = 'VB');
				
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
		  		$sql = "insert into auto_upload_log(upload_type,filename,datacount,file_size) values ('VB','$fileprefix',1,$file_size)";
		  		$this->db->simple_query($sql);
		  		$subject = "AutoUpload Automatic Email";
		  		$content = "Auto Upload VB Done On ".($number_try+1)." Try At ".date("d-m-Y H:i:s")."";
		  		$this->emailThis2($subject,$content);
		  		
		  }else if( intval($success) == 2){
		  		echo "Nothing Updated";
		  }else {
			  	$sql = "insert into auto_upload_log(upload_type,filename,datacount,file_size) values ('VB','VB File Not Found',0,0)";
			  	$this->db->simple_query($sql);
			  	$reason = "System unable to determine the error";
			  	if($file_size == 0){ $reason = "No file found on local server"; } 
			  	else if($file_size != 0 && $is_connect != 1){ $reason = "Unable to connect to Remote SFTP";}
			  	$subject = "AutoUpload Automatic Email";
			  	$content = "Auto Upload VB Failed On ".($number_try+1)." Try At ".date("d-m-Y H:i:s")."Error :". $reason;
			  	$this->emailThis2($subject,$content);
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
				
			}else if($type == 'VB'){
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
			}else if($type == 'VB'){
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
		function emailThis2($subject = 'Unsubjected',$content = 'Invalid Content'){
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
 				$this->email->cc('hery.yulianto@valdo-intl.com');
 

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
              function link_report_dpd2(){
			die('tidak dapat diakses');
			$file_now = "DPD2.txt";
			$sql = "SELECT @no:=@no+1 no, primary_1 AS no_kontrak, LOWER( NAME ) AS nama, IF( cell_phone1 =0, phone_1, cell_phone1 ) AS New_phone, angsuran_ke AS angsuran, substring_index( lower( product ) , '/', 1 ) AS jenis, substring_index( lower( product ) , '/', -1 ) AS merk, police_no AS nopol, due_date AS jatuh_tempo,shift AS minimum, debt_amount AS tagihan, kode_cabang
                FROM hdr_debtor_main, (SELECT @no:= 0) AS NO
                WHERE dpd = '2' and skip='1' and object_group_code in ('001','002') and (cell_phone1 != '-' or phone_1 != '-') and (cell_phone1 != '' or phone_1 != '') and (cell_phone1 != 'TIDAK ADA' or phone_1 != 'TIDAK ADA') and (substr(cell_phone1, 1, 2) != '00' or substr(phone_1, 1, 2) != '00') and substr(cell_phone1, 1, 2) != '+6' and substr(cell_phone1, 1, 2) != '62' and (cell_phone1 != '0' or phone_1 != '0')
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

		function link_report1(){
			die('tidak dapat diakses');
			$file_now = "DPD1.txt";
			$sql = "SELECT @no:=@no+1 no, primary_1 AS no_kontrak, LOWER( NAME ) AS nama, IF( cell_phone1 =0, phone_1, cell_phone1 ) AS New_phone, angsuran_ke AS angsuran, substring_index( lower( product ) , '/', 1 ) AS jenis, substring_index( lower( product ) , '/', -1 ) AS merk, police_no AS nopol, due_date AS jatuh_tempo,shift AS minimum, debt_amount AS tagihan, kode_cabang
                FROM hdr_debtor_main, (SELECT @no:= 0) AS NO
                WHERE dpd = '1' and skip='1' and object_group_code in ('001','002') and (cell_phone1 != '-' or phone_1 != '-') and (cell_phone1 != '' or phone_1 != '') and (cell_phone1 != 'TIDAK ADA' or phone_1 != 'TIDAK ADA') and (substr(cell_phone1, 1, 2) != '00' or substr(phone_1, 1, 2) != '00') and substr(cell_phone1, 1, 2) != '+6' and substr(cell_phone1, 1, 2) != '62' and (cell_phone1 != '0' or phone_1 != '0')
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
			die('tidak dapat diakses');
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
			die('tidak dapat diakses');
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
		
		function dpd8(){
		$sql = "update `hdr_calltrack` a, hdr_debtor_main s 
		set a.ptp_status='1'
		WHERE a.`primary_1` = s.`primary_1` 
		AND s.dpd = '8'
		AND a.ptp_date>=curdate()";
		$this->db->simple_query($sql);

		}
		
		function update_ptp(){
			$sql = "update hdr_debtor_main set ptp_date='2019-08-31' where call_date=curdate() ";
			$this->db->query($sql);

		} 
	function artificial_intelegence_call(){
		$today = date('Y-m-d');
		$awal_bulan = date('Y-m-01');
		$tgl = strtotime($awal_bulan);
		$d = date("d", $tgl);
		$m = date("m", $tgl);
		$y = date("Y", $tgl);
		$awal_bulan_lalu = date("Y-m-01",mktime(0,0,0,date($m),date($d)-1,date($y)));
		$akhir_bulan_lalu = date("Y-m-d",mktime(0,0,0,date($m),date($d)-1,date($y)));
		
		if($today == $awal_bulan){
			$this->db->truncate('hdr_calltrack_month');
			$sql = "insert into hdr_calltrack_month select * from hdr_calltrack where call_date between '$awal_bulan_lalu' AND '$akhir_bulan_lalu' ";
			$this->db->query($sql);
		}
		
		$sql = "update hdr_debtor_main set available_contact_call = null";
		$this->db->query($sql);
		$sql = "update hdr_debtor_main a, (
					SELECT primary_1, code_call_track, call_date, call_time, createdate, HOUR(call_time) AS jam 
					FROM hdr_calltrack_month
					WHERE call_date BETWEEN '$awal_bulan_lalu' AND '$akhir_bulan_lalu'
					AND code_call_track IN ('OCAA','OCAB','OCAC') 
					AND primary_1 != ''
					GROUP BY primary_1 ORDER BY call_time ASC
				) b set a.available_contact_call = b.createdate, a.hour_contact_call = b.jam where a.primary_1 = b.primary_1";
		$this->db->query($sql);
		die('Done');
		//die($awal_bulan_lalu." ".$akhir_bulan_lalu);
	}
	function get_master_from_vb(){
		//die('test');
		$db_vb = $this->load->database("db_vb",true);
		$sql = "SELECT a.id, a.no_kartu, a.nama, a.tgl_lahir, a.nopol, a.overdue, a.tenure, a.jatuh_tempo, 
				a.payment_type, a.angsuran, a.job_title, a.tagihan, a.lc_amount, a.prepaid_amount, a.osar,
				a.branch, a.collection_area, a.jenis, a.telp, a.phone1, a.phone2, a.phone3, a.kode_cabang, a.last_handling,
				a.notes, a.prommised, a.denda, a.mobile_phone, a.last_action, a.last_result, a.objt_group_code, a.valdo_cc, a.fin_type,
				a.product_flag, a.bucket_coll, a.emergency_contact_name, a.emergency_phone_no, a.nama_penjamin, a.telp_penjamin,
				a.alamat_nasabah, a.alamat_office_nasabah, a.score_result
				FROM `campains` a
				INNER JOIN cdr b ON b.no_kartu = a.no_kartu
				WHERE b.disposition IN ('ANSWERED') AND date(b.calldate) = date(now()) AND a.flag = '0' and date(a.upload_date) = date(now())
				GROUP BY a.no_kartu
				ORDER BY a.nama ASC limit 200";
		$q = $db_vb->query($sql);
		if($q->num_rows() > 0){
			$datetime = date('Y-m-d H:i:s');
			$date = date('Y-m-d');
			$this->db->truncate('hdr_debtor_main_temp');
			foreach($q->result_array() as $row){
				$id = $row['id'];
				$primary_1 = $row['no_kartu'];
				$name = $row['nama'];
				$dob = $row['tgl_lahir'];
				$police_no = $row['nopol'];
				$ovd = $row['overdue'];
				$tenor = $row['tenure'];
				$due_date = $row['jatuh_tempo'];
				$payment_type = $row['payment_type'];
				$angsuran_ke = $row['angsuran'];
				$profesi = $row['job_title'];
				$inst = $row['tagihan'];
				$nilai_angsuran = $row['lc_amount'];
				$nilai_denda = $row['prepaid_amount'];
				$os_ar = $row['osar'];
				$branch = $row['branch'];
				$area = $row['collection_area'];
				$brandmode = $row['jenis'];
				$cell_phone2 = $row['telp'];
				$phone_1 = str_replace($row['phone1'],"'","");
				$phone_2 = str_replace($row['phone2'],"'","");
				$phone_3 = str_replace($row['phone3'],"'","");
				$kode_cabang = $row['kode_cabang'];
				$last_handling = $row['last_handling'];
				$notes = $row['notes'];
				$prommised = $row['prommised'];
				$denda = $row['denda'];
				$mobile_phone = str_replace($row['mobile_phone'],"'","");
				$last_action = $row['last_action'];
				$last_result = $row['last_result'];
				$object_group_code = $row['objt_group_code'];
				$valdo_cc = $row['valdo_cc'];
				$fin_type = $row['fin_type'];
				$product_flag = $row['product_flag'];
				$bucket_coll = $row['bucket_coll'];
				$emergency_contact_name = $row['emergency_contact_name'];
				$emergency_phone_no = $row['emergency_phone_no'];
				$nama_penjamin = $row['nama_penjamin'];
				$telp_penjamin = $row['telp_penjamin'];
				$alamat_nasabah = str_replace($row['alamat_nasabah'],"'","");
				$alamat_kantor = str_replace($row['alamat_office_nasabah'],"'","");
				$score_result = $row['score_result'];
				
				$a = "insert into hdr_debtor_main_temp(`kode_cabang`,`branch`,`primary_1`,`name`,`angsuran_ke`,`tenor`,`DPD`,`debt_amount`,`amount_due`,`os_ar`,`police_no`,`phone_1`,
						`phone_2`,`phone_3`,`cell_phone1`,`cell_phone2`,`region`,`product`,`due_date`,`last_handling_date`,`last_remark`,`last_ptp_date`,`last_action`,`last_result`,
						`object_group_code`,`valdo_cc`,`fin_type`,product_flag, bucket_coll, emergency_contact_name, emergency_phone_no, nama_penjamin,no_telp_penjamin,
						alamat_nasabah,alamat_kantor,`score_result`,date_in,createdate) 
						values('$kode_cabang','$branch','$primary_1','$name','$angsuran_ke','$tenor','$ovd','$tagihan','$denda','$os_ar','$nopol','$phone_1',
						'$phone_2','$phone_3','$mobile_phone','$cell_phone2','$collection_area','$jenis','$due_date','$last_handling','$notes','$prommised','$last_action','$last_result',
						'$object_group_code','$valdo_cc','$fin_type','$product_flag','$bucket_coll','$emergency_contact_name','$emergency_phone_no','$nama_penjamin','$no_telp_penjamin',
						'$alamat_nasabah','$alamat_kantor','$score_result','$date','$datetime')";
				$this->db->query($a);
				
				$a = "update campains set flag = '1' where id = '$id'";
				$db_vb->query($a);
			}
			
			$cek_main = "select * from hdr_debtor_main where date(createdate) = date(now())";
			$q_cek_main = $this->db->query($cek_main);
			if($q_cek_main->num_rows() == 0){
				$this->db->truncate('hdr_debtor_main');
			}
			
			$a = "insert into hdr_tmp_log(primary_1,value,is_reminder,createdate)
				select primary_1, concat(`kode_cabang`,'|',`branch`,'|',`primary_1`,'|',`name`,'|',`angsuran_ke`,'|',`tenor`,'|',`DPD`,'|',`debt_amount`,'|',`amount_due`,'|',`os_ar`,'|',`police_no`,'|',`phone_1`,'|',
						`phone_2`,'|',`phone_3`,'|',`cell_phone1`,'|',`region`,'|',`product`,'|',`due_date`,'|',`last_handling_date`,'|',`last_remark`,'|',`last_ptp_date`,'|',`last_action`,'|',`last_result`,'|',
						`object_group_code`,'|',`valdo_cc`,'|',`fin_type`,'|',product_flag,'|', bucket_coll,'|', emergency_contact_name,'|', emergency_phone_no,'|', nama_penjamin,no_telp_penjamin,'|',
						alamat_nasabah,'|',alamat_kantor,'|',`score_result`,'|') as value, '0', createdate
				from hdr_debtor_main_temp";
			//$this->db->query($a);
			
			$a = "insert into hdr_debtor_main(`kode_cabang`,`branch`,`primary_1`,`name`,`angsuran_ke`,`tenor`,`DPD`,`debt_amount`,`amount_due`,`os_ar`,`police_no`,`phone_1`,`phone_2`,`phone_3`,`cell_phone1`,`cell_phone2`,`region`,`product`,`due_date`,`last_handling_date`,`last_remark`,`last_ptp_date`,`last_action`,`last_result`,`object_group_code`,`valdo_cc`,`fin_type`, product_flag, bucket_coll, emergency_contact_name, emergency_phone_no, nama_penjamin, no_telp_penjamin,alamat_nasabah,alamat_kantor,`score_result`,date_in,createdate) 
				select `kode_cabang`,`branch`,`primary_1`,`name`,`angsuran_ke`,`tenor`,`DPD`,`debt_amount`,`amount_due`,`os_ar`,`police_no`,`phone_1`,`phone_2`,`phone_3`,`cell_phone1`,`cell_phone2`,`region`,`product`,`due_date`,`last_handling_date`,`last_remark`,`last_ptp_date`,`last_action`,`last_result`,`object_group_code`,`valdo_cc`,`fin_type`, product_flag, bucket_coll, emergency_contact_name, emergency_phone_no, nama_penjamin, no_telp_penjamin,alamat_nasabah,alamat_kantor,`score_result`,date_in,createdate from hdr_debtor_main_temp";
			$this->db->query($a);
			
		}	
		die('done');
	}
	function reblast_adira(){
		//die('done');
		$sql = "select primary_1 from hdr_debtor_main 
				where called = 0 and date(createdate) = date(now())";
		$q = $this->db->query($sql);
		if($q->num_rows() == 0){
			//die('habis');
			//DATA HABIS DAN REBLAST YG UNCONNECT
			$db_vb = $this->load->database("db_vb",true);
			$sql = "update campains set telp = mobile_phone, status = 'IDLE', flag = '0', attempt = attempt + 1 where date(upload_date) = date(now()) and status = 'RUN' and attempt <= 4 and no_kartu not in (SELECT no_kartu FROM `cdr` WHERE date(calldate) = date(now()) and disposition = 'ANSWERED')";
			$db_vb->query($sql);
		}
	}
	function report_uncontact_blast(){
		//die('test donk, ini belum selesai');
		$date = date('Y-m-d');
		//$date = "2020-02-25";
		$month = date('m');
		$db_vb = $this->load->database("vb_blast",true);
		$sql = "select * from campains where date(upload_date) = '$date' and status in ('RUN','IDLE') and flag=0 group by no_kartu";
		$q = $db_vb->query($sql);
		//$this->db->query($sql);
		//if($q->num_rows() > 0){
        $i=0;
        $selectedTime = "19:30:00";
            
		 foreach ($q->result_array() as $row)
	      {
            $i++;
            /*   
            $time = date('H:i:s');
            $timeplus = strtotime("+1 second", strtotime($time));
            $datetime = $date." ".date('h:i:s', $timeplus);
            */
            $endTime = strtotime("+$i second", strtotime($selectedTime));
            $time =  date('H:i:s', $endTime);
            $datetime = $date." ".$time;
            echo $i.'-'.$datetime.'<br />';
			//$row = $q->row_array();
			//var_dump($this->db->last_query());die();
			$primary_1 = $row['no_kartu'];
			$cname = $row['nama'];
			$angsuran_ke = $row['angsuran'];
			$mobile_phone = $row['mobile_phone'];
			$phone1 = $row['phone1'];
			$phone2 = $row['phone2'];
			$phone3 = $row['phone3'];
			if($mobile_phone == ''){
				if($phone1 == ''){
					if($phone2 == ''){
						if($phone3 == ''){
							$no_contacted = $phone3;
						}else{
							$no_contacted = $phone3;
						}
					}else{
						$no_contacted = $phone2;
					}
				}else{
					$no_contacted = $phone1;
				}
			}else{
				$no_contacted = $mobile_phone;
			}
			$dpd = $row['overdue'];
			$os_ar_amount = $row['osar'];
			$kode_cabang = $row['kode_cabang'];
			$object_group = $row['objt_group_code'];
			$score_result = $row['score_result'];
			
			$a = "INSERT IGNORE INTO `hdr_calltrack`(`id_contact_code`, `id_ptp`, `id_location_code`, `id_risk_code`, `id_handling_debt`, `id_handling_code`, `deliquency_code`, `type`, 
					`ptp_status`, `primary_1`, `cname`, `debtor_name`, `spv_name`, `location_code`, `contact_code`, `risk_code`, `next_action_code`, `id_call_cat`, `id_action_call_track`, 
					`code_call_track`, `id_user`, `id_spv`, `username`, `surveyor`, `angsuran_ke`, `remarks`, `no_contacted`, `new_phone_number`, `new_office_number`, `new_emergency_phone`, 
					`new_hp`, `new_address`, `new_pos_code`, `memo`, `date_in`, `dpd`, `call_date`, `call_month`, `call_time`, `createdate`, `total_call_time`, `ptp_date`, `ptp_amount`, `due_date`, 
					`due_time`, `call_attempt`, `incomming`, `is_current`, `in_use`, `sta`, `cycling`, `ptp_fu`, `fu`, `broken_date`, `os_ar_amount`, `kode_cabang`, `object_group`, 
					`is_flag`, `score_result`)
				VALUES('03','0','0','0','04','04',null,'0',
					'0','$primary_1','$cname',null,null,'0','0','0',null,'2','8',
					'OCNA','1','1','ADMIN','0','$angsuran_ke','Not Contacted by System','$no_contacted',null,null,null,
					null,null,null,null,'0000-00-00','$dpd','$date','$month','$time','$datetime',null,null,null,null,
					null,'1','0','1','1','0','1','0','0','0000-00-00','$os_ar_amount','$kode_cabang','$object_group',
					null,'$score_result')";
			$this->db->query($a);
			//var_dump($this->db->last_query());die();
		}
		/*$sql = "INSERT INTO adira_collectionv2.`hdr_calltrack`(`id_contact_code`, `id_ptp`, `id_location_code`, `id_risk_code`, `id_handling_debt`, `id_handling_code`, `deliquency_code`, `type`, `ptp_status`, `primary_1`, `cname`, `debtor_name`, `spv_name`, `location_code`, `contact_code`, `risk_code`, `next_action_code`, `id_call_cat`, `id_action_call_track`, `code_call_track`, `id_user`, `id_spv`, `username`, `surveyor`, `angsuran_ke`, `remarks`, `no_contacted`, `new_phone_number`, `new_office_number`, `new_emergency_phone`, `new_hp`, `new_address`, `new_pos_code`, `memo`, `date_in`, `dpd`, `call_date`, `call_month`, `call_time`, `createdate`, `total_call_time`, `ptp_date`, `ptp_amount`, `due_date`, `due_time`, `call_attempt`, `incomming`, `is_current`, `in_use`, `sta`, `cycling`, `ptp_fu`, `fu`, `broken_date`, `os_ar_amount`, `kode_cabang`, `object_group`, `is_flag`, `score_result`) 
				SELECT `id_contact_code`, `id_ptp`, `id_location_code`, `id_risk_code`, `id_handling_debt`, `id_handling_code`, `deliquency_code`, `type`, `ptp_status`, `primary_1`, `cname`, `debtor_name`, `spv_name`, `location_code`, `contact_code`, `risk_code`, `next_action_code`, `id_call_cat`, `id_action_call_track`, `code_call_track`, `id_user`, `id_spv`, `username`, `surveyor`, `angsuran_ke`, `remarks`, `no_contacted`, `new_phone_number`, `new_office_number`, `new_emergency_phone`, `new_hp`, `new_address`, `new_pos_code`, `memo`, `date_in`, `dpd`, `call_date`, `call_month`, `call_time`, `createdate`, `total_call_time`, `ptp_date`, `ptp_amount`, `due_date`, `due_time`, `call_attempt`, `incomming`, `is_current`, `in_use`, `sta`, `cycling`, `ptp_fu`, `fu`, `broken_date`, `os_ar_amount`, `kode_cabang`, `object_group`, `is_flag`, `score_result` from adira_new.`hdr_calltrack` where call_date = date(now())";
		$this->db->query($a);*/
		die('done');
	}
	
	function report_uncontact_blast_2(){
		//die('test donk, ini belum selesai');
		$date = date('Y-m-d');
		//$date = "2020-02-25";
		$month = date('m');
		//$db_vb = $this->load->database("vb_blast",true);
		$sql = "SELECT *
FROM `hdr_debtor_main`
WHERE called =0 limit 1";
		$q = $this->db->query($sql);
		//$this->db->query($sql);
		//if($q->num_rows() > 0){
        $i=0;
        $selectedTime = "19:30:00";
            
		 foreach ($q->result_array() as $row)
	      {
            $i++;
            /*   
            $time = date('H:i:s');
            $timeplus = strtotime("+1 second", strtotime($time));
            $datetime = $date." ".date('h:i:s', $timeplus);
            */
            $endTime = strtotime("+$i second", strtotime($selectedTime));
            $time =  date('H:i:s', $endTime);
            $datetime = $date." ".$time;
            echo $i.'-'.$datetime.'<br />';
			//$row = $q->row_array();
			//var_dump($this->db->last_query());die();
			$primary_1 = $row['primary_1'];
			$cname = $row['cname'];
			$angsuran_ke = $row['angsuran_ke'];
			$mobile_phone = $row['cell_phone2'];
			$phone1 = $row['cell_phone1'];
			$phone2 = $row['phone2'];
			$phone3 = $row['phone3'];
			if($mobile_phone == ''){
				if($phone1 == ''){
					if($phone2 == ''){
						if($phone3 == ''){
							$no_contacted = $phone3;
						}else{
							$no_contacted = $phone3;
						}
					}else{
						$no_contacted = $phone2;
					}
				}else{
					$no_contacted = $phone1;
				}
			}else{
				$no_contacted = $mobile_phone;
			}
			$dpd = $row['dpd'];
			$os_ar_amount = $row['os_ar'];
			$kode_cabang = $row['kode_cabang'];
			$object_group = $row['object_group_code'];
			$score_result = $row['score_result'];
			
			$a = "INSERT IGNORE INTO `hdr_calltrack`(`id_contact_code`, `id_ptp`, `id_location_code`, `id_risk_code`, `id_handling_debt`, `id_handling_code`, `deliquency_code`, `type`, 
					`ptp_status`, `primary_1`, `cname`, `debtor_name`, `spv_name`, `location_code`, `contact_code`, `risk_code`, `next_action_code`, `id_call_cat`, `id_action_call_track`, 
					`code_call_track`, `id_user`, `id_spv`, `username`, `surveyor`, `angsuran_ke`, `remarks`, `no_contacted`, `new_phone_number`, `new_office_number`, `new_emergency_phone`, 
					`new_hp`, `new_address`, `new_pos_code`, `memo`, `date_in`, `dpd`, `call_date`, `call_month`, `call_time`, `createdate`, `total_call_time`, `ptp_date`, `ptp_amount`, `due_date`, 
					`due_time`, `call_attempt`, `incomming`, `is_current`, `in_use`, `sta`, `cycling`, `ptp_fu`, `fu`, `broken_date`, `os_ar_amount`, `kode_cabang`, `object_group`, 
					`is_flag`, `score_result`)
				VALUES('03','0','0','0','04','04',null,'0',
					'0','$primary_1','$cname',null,null,'0','0','0',null,'2','8',
					'OCNA','1','1','ADMIN','0','$angsuran_ke','Not Contacted by System','$no_contacted',null,null,null,
					null,null,null,null,'0000-00-00','$dpd','$date','$month','$time','$datetime',null,null,null,null,
					null,'1','0','1','1','0','1','0','0','0000-00-00','$os_ar_amount','$kode_cabang','$object_group',
					null,'$score_result')";
			$this->db->query($a);
			//var_dump($this->db->last_query());die();
		}
		/*$sql = "INSERT INTO adira_collectionv2.`hdr_calltrack`(`id_contact_code`, `id_ptp`, `id_location_code`, `id_risk_code`, `id_handling_debt`, `id_handling_code`, `deliquency_code`, `type`, `ptp_status`, `primary_1`, `cname`, `debtor_name`, `spv_name`, `location_code`, `contact_code`, `risk_code`, `next_action_code`, `id_call_cat`, `id_action_call_track`, `code_call_track`, `id_user`, `id_spv`, `username`, `surveyor`, `angsuran_ke`, `remarks`, `no_contacted`, `new_phone_number`, `new_office_number`, `new_emergency_phone`, `new_hp`, `new_address`, `new_pos_code`, `memo`, `date_in`, `dpd`, `call_date`, `call_month`, `call_time`, `createdate`, `total_call_time`, `ptp_date`, `ptp_amount`, `due_date`, `due_time`, `call_attempt`, `incomming`, `is_current`, `in_use`, `sta`, `cycling`, `ptp_fu`, `fu`, `broken_date`, `os_ar_amount`, `kode_cabang`, `object_group`, `is_flag`, `score_result`) 
				SELECT `id_contact_code`, `id_ptp`, `id_location_code`, `id_risk_code`, `id_handling_debt`, `id_handling_code`, `deliquency_code`, `type`, `ptp_status`, `primary_1`, `cname`, `debtor_name`, `spv_name`, `location_code`, `contact_code`, `risk_code`, `next_action_code`, `id_call_cat`, `id_action_call_track`, `code_call_track`, `id_user`, `id_spv`, `username`, `surveyor`, `angsuran_ke`, `remarks`, `no_contacted`, `new_phone_number`, `new_office_number`, `new_emergency_phone`, `new_hp`, `new_address`, `new_pos_code`, `memo`, `date_in`, `dpd`, `call_date`, `call_month`, `call_time`, `createdate`, `total_call_time`, `ptp_date`, `ptp_amount`, `due_date`, `due_time`, `call_attempt`, `incomming`, `is_current`, `in_use`, `sta`, `cycling`, `ptp_fu`, `fu`, `broken_date`, `os_ar_amount`, `kode_cabang`, `object_group`, `is_flag`, `score_result` from adira_new.`hdr_calltrack` where call_date = date(now())";
		$this->db->query($a);*/
		die('done');
	}
	
	function copy_tmp_log(){
		$this->db->truncate('hdr_tmp_log');
		$sql = "INSERT INTO adira_new.`hdr_tmp_log`(`id_debtor_det`, `primary_1`, `value`, `is_reminder`, `createdate`, `id_upload`) 
				SELECT `id_debtor_det`, `primary_1`, `value`, `is_reminder`, `createdate`, `id_upload` FROM adira_collectionv2.`hdr_tmp_log`";
		$this->db->query($sql);
	}
	function truncate_debtor_main(){
		$this->db->truncate('hdr_debtor_main');
	}
}
?>
