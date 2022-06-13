<?php
//script for crontab use <- Martin [31 Dec 2011]
class Auto_leech extends Controller {

    public function __construct() {
      parent::Controller();
      
    }


    public function index()
    {
      
    }

    public function fetchControl(){
    	//load and configuring
    	$this->load->library('sftp');
    	$sftp_config['hostname'] = '202.158.47.38';
			$sftp_config['username'] = 'valdo';
			$sftp_config['password'] = 'sayaganteng';
			$sftp_config['debug'] = TRUE;	
    	$is_connect = FALSE;
    	$list_file = "NULL";
    	
    	$is_connect = $this->sftp->connect($sftp_config);
    	var_dump($is_connect);
    	
    		if($is_connect && intval($is_connect) == 1){
    				$list_file = $this->sftp->list_files("/tmp/test/", TRUE);
    		}
    	
    	echo $list_file;
    }
		
		function info(){
			echo phpinfo();
		}
		
}
?>
