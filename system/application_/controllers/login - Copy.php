<?php
class Login extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model('Hdr_security_model','security_model');
		$this->load->model('admin/hdr_user_model');
	}
	function index(){
		$data['title'] = 'Login';
		$this->load->view('login',$data);
	}
	public function info(){
		echo phpinfo();
	}
	public function jam(){
		echo date("H:i:s");
	}
	public function logg(){
		//die("Maaf, tidak bisa login. Harap login <a href='https://www.google.com/' target='_tab'>disini</a>");
	//$this->output->enable_profiler("TRUE");
		if(isset($_POST['post'])){
				$data['username'] = strtolower($this->input->post('username', TRUE));
				$data['password']  = strtolower($this->input->post('password', TRUE));
				$get_user = $this->security_model->is_online($data);
				if($this->security_model->is_block($data['username'])==1){
					echo 'You cannot Acces, because your account is block, Please Ask Admin to Unblocked it';
				}elseif($this->security_model->login($data)){
					$this->user_model->set_login_failed($data['username'],0);
					//print_r($_SESSION);
					
					$this->redirect_logged();
				}else{
					echo "Please type the correct username and password";
				
				}
		}
		
	}
	
	function redirect_logged(){
		if(!empty($_SESSION['blevel'])){
			if($_SESSION["blevel"]=='admin'){
				echo  "Please wait, <p>This page will automatically redirecting to Admin Page</p>";
				echo '<script>location.href="'.site_url().'admin/hdr_upload_cont/master"</script>';
			}
			elseif($_SESSION["blevel"]=='user'){
				if ($_SESSION['leave_reason'] == 'L1') {//var_dump($_SESSION["bsname_s"],$_SESSION['ext'],$_SESSION['id_user'],$_SESSION['queue']);die();
					$this->unpause_asterisk_api($_SESSION["bsname_s"],$_SESSION['ext'],$_SESSION['id_user'],$_SESSION['queue']);
					$this->login_asterisk_api($_SESSION["bsname_s"],$_SESSION['ext'],$_SESSION['id_user'],$_SESSION['queue']);
				} else {//var_dump($_SESSION["bsname_s"],$_SESSION['ext'],$_SESSION['id_user'],$_SESSION['queue']);die();
					$this->unpause_asterisk_api($_SESSION["bsname_s"],$_SESSION['ext'],$_SESSION['id_user'],$_SESSION['queue']);
					$this->login_asterisk_api($_SESSION["bsname_s"],$_SESSION['ext'],$_SESSION['id_user'],$_SESSION['queue']);
				}
				
				echo  "Please wait, <p>This page is automatically redirecting to Telecollector Page</p>";
				echo '<script>location.href="'.site_url().'user/hdr_contact_cont/contact/call"</script>';
			}
			elseif($_SESSION["blevel"]=='spv'){
                                //$this->output->enable_profiler("TRUE");
                                echo  "Please wait, <p>This page is automatically redirecting to Supervisor Page</p>";
				echo '<script>location.href="'.site_url().'spv/hdr_spv_report_ctrl"</script>';
			}
			elseif($_SESSION["blevel"]=='spv_sta'){
				echo  "Please wait, <p>This page is automatically redirecting to Supervisor Agen Page</p>";
				echo '<script>location.href="'.site_url().'spv/hdr_spv_send_to_agen_ctrl"</script>';
			}
		}
		return false;
	}	

	public function login_asterisk_api($username,$sip,$user_id,$queue)
    {
        /* API URL */
        $url = 'http://10.14.14.11/login/api_login/login';
   
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
             //var_dump($result);die();
        /* close cURL resource */
		curl_close($ch);
		
		echo 'Login';
	}
	
	public function unpause_asterisk_api($username,$sip,$user_id,$queue)
    {
        /* API URL */
        $url = 'http://10.14.14.11/login/api_login/unpause';
   
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
    
    function login_manual($username,$pabx_ext,$id_asterisk,$queue){
        $login = $this->login_asterisk_api($username,$pabx_ext,$id_asterisk,$queue); 
        //SELECT username,pabx_ext,id_asterisk,queue FROM hdr_user    
        echo $login;
    }
}
?>