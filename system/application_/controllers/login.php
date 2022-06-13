<?php
class Login extends Controller{
	function __construct(){
		parent::Controller();
		$this->load->model('Hdr_security_model','security_model');
		$this->load->model('admin/hdr_user_model');
        $this->load->model('M_crud'); 
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
 
        //die($this->config->item('url_asterisk'));
		if(isset($_POST['post'])){
		        $data['username'] = strtolower($this->input->post('username', TRUE));
				$data['password']  = strtolower($this->input->post('password', TRUE));
	            
                $username  = $data['username'];
                   
                    $where = "where username = '$username' "; //
                    $field = " phone_login,phone_pwd,agent_login,agent_pwd,kategori ";
                    $rslt_dt = $this->M_crud->proses_select_rows_fields_dc('hdr_user',$where,$field); 
                    $phone_login = ""; //
                    $phone_pwd = ""; //
                    
                    //echo $this->db->last_query();exit;
                    
                    //die($rslt_dt);
                    if($rslt_dt != "false")
                            $phone_login = $rslt_dt->phone_login;
                            $phone_pwd = $rslt_dt->phone_pwd;
                            $agent_login = $rslt_dt->agent_login;
                            $agent_pwd = $rslt_dt->agent_pwd;
                            $kategori = $rslt_dt->kategori;
                    
                    //die($agent_login);exit;
                    
                    $forminput = array(
                     'VD_login'=> $agent_login,
                     'VD_pass'=> $agent_pwd,
                     'phone_login'=> $phone_login,
                     'phone_pass'=> $phone_pwd,
                     'VD_campaign'=> $kategori
                    );
                    
                   // var_dump($forminput);die;                 
    
    
    			$get_user = $this->security_model->is_online($data);
				if($this->security_model->is_block($data['username'])==1){
					echo 'You cannot Acces, because your account is block, Please Ask Admin to Unblocked it';
				}elseif($this->security_model->login($data)){
					    if(!empty($phone_login)){
                            $this->load->model('curl_model');
                            $targeturl = $this->config->item('url_asterisk')."/api/softphone/login";
                            $curl_response = $this->curl_model->curlpost($targeturl, $forminput);
                            //die($curl_response);
                            
                            if(!$curl_response['error']){
                                    $curl_result = json_decode($curl_response['result'], TRUE);
                                    
                                    
                                    if(!$curl_result['error']){
                                        // Berhasil Create Session
                                        $this->createSession($curl_result,$username);
                                        $this->user_model->set_login_failed($data['username'],0);
                                        $this->security_model->insert_loginstatus($_SESSION['bid_user_s'], $_SESSION['bsname_s'], 'LOGIN', 'SUCCESS');
                                        $this->redirect_logged();
                                    } else {
                                        echo  $curl_result['message'];
                                    }             
                                                   
                            } else {
                              echo 'Auth API Call Failed'; 
                            }  
                          }else{
                              $this->createSession($curl_result,$username);
                                $this->user_model->set_login_failed($data['username'],0);
                                $this->security_model->insert_loginstatus($_SESSION['bid_user_s'], $_SESSION['bsname_s'], 'LOGIN', 'SUCCESS');
                                $this->redirect_logged();
                              
                          }
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
				//echo '<script>location.href="'.site_url().'user/hdr_contact_cont/contact/call"</script>';
                echo '<script>location.href="'.site_url().'user/hdr_contact_cont/refresh_predictive"</script>';
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
    
    
    public function createSession($curl_result,$username)
    {
        $session_arr = $curl_result['session'];

        $_SESSION['session_name']   = $session_arr['session_name'];
        $_SESSION['conf_exten']     = $session_arr['conf_exten'];
        $_SESSION['user']           = $session_arr['user'];
        $_SESSION['campaign_id']    = $session_arr['campaign_id'];
        $_SESSION['extension']      = $session_arr['extension'];
        $_SESSION['login_time']     = $session_arr['login_time'];
        $_SESSION['channel']        = $session_arr['channel'];
     
        $sess_name = $session_arr['session_name'];
        
        //echo $sess_name;exit;
        
        $a = "update hdr_user set session_vici = '$sess_name' where username = '$username' limit 1";
        $this->db->query($a);
        
    }
}
?>