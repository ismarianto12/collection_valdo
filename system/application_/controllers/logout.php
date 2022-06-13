<?php
class Logout extends Controller{
	public function __construct(){
		parent::Controller();
		$this->load->model('hdr_security_model','security_model');
	}

	public function index(){
		//$this->output->enable_profiler('TRUE');
		$this->load->model('user/hdr_call_track_model','call_track_model');
		$id_user = @$_SESSION['bid_user_s'];
        $session_name = $_SESSION['session_name'];
		if(@$_SESSION['blevel']=='user'){
			$this->call_track_model->reset_uncall($id_user);
		    
                    $this->load->model('curl_model');
                    ## Logout Softphone
                    $c_input['session_name'] = $_SESSION['session_name'];
                    
                    $target_url_pause = $this->config->item('url_asterisk')."api/agent/set_agentPause";
                    $this->curl_model->curlpost($target_url_pause, $session_name);                                
                    
//                    echo $c_input['session_name'];exit;
                
                    $target_url = $this->config->item('url_asterisk')."/api/softphone/logout";
                    $this->curl_model->curlpost($target_url, $session_name);

        
        }elseif(@$_SESSION['blevel']=='spv'){
			//$this->call_track_model->reset_uncall_spv();
		}
		//logout asterisk
		$asterisk = $this->logout_asterisk_api($_SESSION["bsname_s"],$_SESSION['ext'],$_SESSION['id_user'],$_SESSION['queue']);
		

		//logout apps
		$this->security_model->logout();


		redirect('login');
	}

  function logoutv2($type=""){
      //var_dump($type);
      //$this->output->enable_profiler('TRUE');
	$this->load->model('user/hdr_call_track_model','call_track_model');
  $pabx_ext = $_SESSION['ext'];
  //var_dump($pabx_ext);die();
	$id_user = @$_SESSION['bid_user_s'];
      if($type != "" && !empty($id_user)){
         ## Update Leave Reason
         $toUpdate = array(
           'leave_reason'=> $type,
           'datetime_leave'=> date('Y-m-d H:i:s')
         );
         $this->db->where('id_user', $id_user);
         $this->db->update('hdr_user', $toUpdate);
      }
	if(@$_SESSION['blevel']=='user'){

		//pause asterisk
		if ($type == 'L1') {
			//logout asterisk
			$asterisk = $this->logout_asterisk_api($_SESSION["bsname_s"],$_SESSION['ext'],$_SESSION['id_user'],$_SESSION['queue']);
		} else {
			$this->pause_asterisk_api($_SESSION["bsname_s"],$_SESSION['ext'],$_SESSION['id_user'],$_SESSION['queue']);
		}
		

		$this->call_track_model->reset_uncall($id_user);
		//$this->security_model->insert_loginstatus($_SESSION['bid_user_s'], $_SESSION['bsname_s'], 'LOGOUT', 'SUCCESS');
		//$this->security_model->signout_limiter($id_user, 3);
        
        $this->load->model('curl_model');
                    ## Logout Softphone
        $c_input['session_name'] = $_SESSION['session_name'];
        //echo $_SESSION['session_name'];exit;
        $target_url = $this->config->item('url_asterisk')."/api/softphone/logout";
        $this->curl_model->curlpost($target_url, $c_input);
        
	} elseif(@$_SESSION['blevel']=='spv'){
		//$this->security_model->insert_loginstatus($_SESSION['bid_user_s'], $_SESSION['bsname_s'], 'LOGOUT', 'SUCCESS');
		//$this->call_track_model->reset_uncall_spv();
	}
	$this->security_model->insert_loginstatus($_SESSION['bid_user_s'], $_SESSION['bsname_s'], 'LOGOUT', 'SUCCESS', $type);
	$this->security_model->logout();
	redirect('login');
  }



  public function logout_asterisk_api($username,$sip,$user_id,$queue)
    {
        /* API URL */
        $url = 'http://10.14.14.11/login/api_logout/logout';
   
        /* Init cURL resource */
        $ch = curl_init($url);
   
        /* Array Parameter Data */
		$data = [
			'username'=>$username, 
			'sip'=>$sip,
			'user_id'=>$user_id,
			'queue'=>$queue
		];
   
        /* pass encoded JSON string to the POST fields */
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            
        /* set the content type json */
        #curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            
        /* set return type json */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
        /* execute request */
        $result = curl_exec($ch);
             
        /* close cURL resource */
		curl_close($ch);
		
		return $result;
	}
	
	public function pause_asterisk_api($username,$sip,$user_id,$queue)
    {
        /* API URL */
        $url = 'http://10.14.14.11/login/api_logout/pause';
   
        /* Init cURL resource */
        $ch = curl_init($url);
   
        /* Array Parameter Data */
		$data = [
			'username'=>$username, 
			'sip'=>$sip,
			'user_id'=>$user_id,
			'queue'=>$queue
		];
   
        /* pass encoded JSON string to the POST fields */
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            
        /* set the content type json */
        #curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            
        /* set return type json */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
        /* execute request */
        $result = curl_exec($ch);
             
        /* close cURL resource */
		curl_close($ch);
		
		return $result;
    }

  function logout_manual($username,$pabx_ext,$id_asterisk,$queue){
    //$asterisk = $this->logout_asterisk_api($_SESSION["bsname_s"],$_SESSION['ext'],$_SESSION['id_user'],$_SESSION['queue']);
    $logout = $this->logout_asterisk_api($username,$pabx_ext,$id_asterisk,$queue);      
    echo $logout; 
  }

}
?>