<?php
class Hdr_user_setting_cont extends Controller{
	
	public function __construct(){
		parent::Controller();
		if(@$_SESSION['blevel']=='user' || @$_SESSION['blevel']=='spv' || @$_SESSION['blevel']=='admin'  || @$_SESSION['blevel']=='spv_sta'){
			//
		} else{
			redirect('login');	
		}
		$this->load->model('admin/hdr_user_model','user_model');
	}
	
	public function index(){
		$this->setting();
	}
	
	public function setting(){
		$data['title'] = 'User Setting';
		$id_user = $_SESSION['bid_user_s'];
		$data['user_setting'] = $this->user_model->get_user($id_user);
		$this->load->view('user/hdr_header_user',$data);
		$this->load->view('user/setup/hdr_user_setting_view',$data);
		$this->load->view('user/hdr_footer',$data);
	}
	public function edit_user_ajax(){
	if(isset($_POST['post'])){
				$data['id_user'] = $_SESSION['bid_user_s'];
				$data['fullname']  = $this->input->post('fullname', TRUE);
				$this->user_model->edit_user($data);	
				echo '<h1>'.$data['fullname'].' has been updated!</h1>';
					
			}	
	}
	public function edit_pass(){
	if(!empty($_POST)){
			$data['passwd'] = $this->input->post('passwd', TRUE);
			$repasswd = $this->input->post('repasswd', TRUE);
			$data['id_user'] = $_SESSION['bid_user_s'];
			if ($repasswd == '' || $data['passwd'] == ''){
					echo '<h1>Fill out both password fields</h1>';
			}elseif($data['passwd']!=$repasswd){
					echo '<h1>Entered passwords do not match</h1>';
			}elseif($data['passwd']==$repasswd){
				$this->user_model->edit_user($data);	
				echo '<h1>Password updated</h1>';
				echo '<script>location.href="'.site_url().'user/hdr_contact_cont/"</script>';
			} 
		}
	}
	public function edit_phone_pass(){
		if(!empty($_POST)){
			$data['phone_pass'] = $this->input->post('phone_pass', TRUE);
			$data['id_user'] = $_SESSION['bid_user_s'];
			$_SESSION['phone_pass'] = $data['phone_pass'];
				$this->user_model->edit_user($data);	
				echo '<h1>Password updated</h1>';
			}
		
	}
	public function edit_local_no(){
		if(!empty($_POST)){
			$data['local_no'] = $this->input->post('local_no', TRUE);
			$data['id_user'] = $_SESSION['bid_user_s'];
			$_SESSION['local_no'] =$data['local_no'] ;
				$this->user_model->edit_user($data);	
				echo '<h1>Local number updated</h1>';
			}
		
	}

}
?>