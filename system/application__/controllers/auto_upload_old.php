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
    	$is_dir = is_dir($url);
    	$today = date('Y_m_d');
    	if($is_dir == 1){
    		$dir = opendir($url);
    		while (($read = readdir($dir))!== false) {
    			if($read != ".." && $read != ".") { 	
    			$file[] = $read; //available file
    			} else {$read = "";}
    		}
    	
    } else { die("Not a Dir"); }

  		//file name DC = Data Customer <- Validation
    	foreach($file as $cfile){
    		if(substr($cfile,0,2) == "DC") { $master_arr[] = $cfile;}
    	} 
   		
   		//upload only today file <- Validation
   		$is_success = 0;
   		foreach ($master_arr as $master){
   		if(substr($master,2,10) == $today){
   			
   			$this->upload_model->empty_table($table = "hdr_debtor_main_temp");
   			$this->upload_model->empty_table($table = "hdr_tmp_log_temp");
				$this->upload_model->empty_table($table = "hdr_debtor_main");
   			$this->upload_model->regular_upload($url."/".$master);
   			$master_file = $master;
   			$countsql = "SELECT count(id_debtor) as num FROM hdr_debtor_main";
   			$result = $this->db->query($countsql);
   			$resultcount_arr = $result->row();
   			$resultcount = $resultcount_arr->num;
   			   			
   			$is_success = 1 ;
   			}
   		} 
   		## Create Log File ##
   		if($is_success == 1){
   			
   			$sql = "insert into auto_upload_log(upload_type,filename,datacount) values ('master','$master_file','$resultcount')";
   			$this->db->simple_query($sql);
   		} else { 
   			
   			$sql = "insert into auto_upload_log(upload_type,filename,datacount) values ('master','No Valid Master File Found','0')";
   			$this->db->simple_query($sql);
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
				//die();
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
			$sftp_config['debug'] = TRUE;
			
		
			//try connect
			$this->sftp->connect($sftp_config);
		  
		  //begin uploading to server
		  $success = $this->sftp->upload($localprefix,$to_prefix);
		  if($success == 1 || $success == "1") 
		  { 
		  		$sql = "insert into auto_upload_log(upload_type,filename) values ('finalReport','$fileprefix')";
		  		$this->db->simple_query($sql);
		  }else {
			  	$sql = "insert into auto_upload_log(upload_type,filename) values ('finalReport','FinalReport File Not Found')";
			  	$this->db->simple_query($sql);
		  }
		  
		
		}
		
}
?>
