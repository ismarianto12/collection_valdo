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
		if(@$_SESSION['blevel']=='user'){
			$this->call_track_model->reset_uncall($id_user);
		}elseif(@$_SESSION['blevel']=='spv'){
			//$this->call_track_model->reset_uncall_spv();
		}
		$this->security_model->logout();
		redirect('login');
	}

  function logoutv2($type=""){
      //var_dump($type);
      //$this->output->enable_profiler('TRUE');
	$this->load->model('user/hdr_call_track_model','call_track_model');
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
		//$this->call_track_model->reset_uncall($id_user);
		//$this->security_model->insert_loginstatus($_SESSION['bid_user_s'], $_SESSION['bsname_s'], 'LOGOUT', 'SUCCESS');
		//$this->security_model->signout_limiter($id_user, 3);
	} elseif(@$_SESSION['blevel']=='spv'){
		//$this->security_model->insert_loginstatus($_SESSION['bid_user_s'], $_SESSION['bsname_s'], 'LOGOUT', 'SUCCESS');
		//$this->call_track_model->reset_uncall_spv();
	}
	$this->security_model->insert_loginstatus($_SESSION['bid_user_s'], $_SESSION['bsname_s'], 'LOGOUT', 'SUCCESS', $type);
	$this->security_model->logout();
	redirect('login');
  }

}
?>