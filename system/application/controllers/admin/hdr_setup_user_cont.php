<?php
class Hdr_setup_user_cont extends Controller{
	
	public function __construct(){
		parent::Controller();
		if(@$_SESSION['blevel']!='admin'){
			redirect('login');	
		}
		$this->load->model('admin/hdr_user_model','user_model');
		//$this->load->model();
	}
	
	public function index(){
		$this->user();
	}
	
	public function user(){
		$data['title'] = 'User title'; 
		$data['list_user'] = $this->user_model->all_user($user_cond='');
		$data['list_spv'] = $this->user_model->all_user($user_cond=' hdu.id_level ="2"');
		$data['active_user'] = $this->user_model->all_user($user_cond=' user_status="online"');
		$this->load->view('admin/hdr_header_admin',$data);
		$this->load->view('admin/hdr_user_manage/hdr_user_set_view',$data);
		$this->load->view('admin/hdr_footer',$data);
	}
	
	public function add_user(){
		$data['txt_title'] = "Add User";
		$data['get_user'] = $this->user_model->get_user($id_user='');
		$data['level'] = $this->user_model->get_list_level($cond='id_level NOT IN (\'1\')');
		//$data['get_leader'] = $this->user_model->get_leader();
		$this->load->view('admin/hdr_header_admin',$data);
		$this->load->view('admin/hdr_user_manage/hdr_add_user',$data);
		$this->load->view('admin/hdr_footer',$data);
	}
	
	public function add_user_ajax(){
		if(isset($_POST['post'])){
		$data = $this->user_value();
		$data['username'] = $this->input->post('username', TRUE);
		$data['passwd'] = $this->input->post('password', TRUE);
		$data['pabx_ext'] = $this->input->post('channel', TRUE);
		$data['id_level'] = $this->input->post('id_level', TRUE);
		$data['createdate'] = date('Y-m-d H:i:s');
		//var_dump($data);
		//die();
					$check =$this->user_model->check_username($data['username']);
					if($check > 0){
						echo '<h1>'.$data['username'].' already registered in system</h1>';
					}if ($check ==0){
						$this->user_model->add_user($data);
						echo '<h1>'.$data['username'].' has been insert!</h1>';
						echo '<script>location.href="'.site_url().'admin/hdr_setup_user_cont/user"</script>';
					} 
		}
	}
	public function user_value(){
		$data['fullname'] = $this->input->post('fullname', TRUE);
		$data['id_leader'] = $this->input->post('id_leader', TRUE);
		$data['blocked'] = '0';
		return $data;
	}
	public function edit_user(){
		$data['txt_title'] = 'Edit This User';
		$id_user = $this->uri->segment(4);
		$data['level'] = $this->user_model->get_list_level($cond='');
		$data['get_user'] = $this->user_model->get_user($id_user);
		//$data['get_leader'] = $this->user_model->get_leader();
		$data['list_user'] = $this->user_model->get_list_user($cond);
			
		$this->load->view('admin/hdr_header_admin',$data);
		$this->load->view('admin/hdr_user_manage/hdr_edit_user',$data);
		$this->load->view('admin/hdr_footer',$data);
	}
	public function edit_user_ajax(){
	if(isset($_POST['post'])){
				$data = $this->user_value();
				$data['id_user'] = $this->input->post('id_user', TRUE);
				$this->user_model->edit_user($data);	
				echo '<h1>'.$data['fullname'].' has been updated!</h1>';
				echo '<script>location.href="'.site_url().'admin/hdr_setup_user_cont/user"</script>';
					
			}	
	}
	public function edit_pass(){
		if(!empty($_POST)){
			$data['passwd'] = $this->input->post('passwd', TRUE);
			$repasswd = $this->input->post('repasswd', TRUE);
			$data['id_user'] = $this->input->post('id_user', TRUE);
			if ($repasswd == '' || $data['passwd'] == ''){
					echo '<h1>Fill out both password fields</h1>';
			}elseif($data['passwd']!=$repasswd){
					echo '<h1>Entered passwords do not match</h1>';
			}elseif($data['passwd']==$repasswd){
				//$data['passwd'] =  md5($data['passwd']);
				$this->user_model->edit_user($data);	
				echo '<h1>Password updated</h1>';
				echo '<script>location.href="'.site_url().'admin/hdr_setup_user_cont/user"</script>';
			} 
		}
	}
	public function edit_spv(){
		//$this->output->enable_profiler('TRUE');
		$data['id_user'] = $this->input->post('id_user', TRUE);
		$data['id_leader'] = $this->input->post('id_spv', TRUE);
		$this->user_model->edit_user($data);
		$spv_name = $this->user_model->get_user($data['id_leader']);
		echo $spv_name->username;
	}
        public function edit_shift(){
		//$this->output->enable_profiler('TRUE');
		$id_user = $this->input->post('id_user', TRUE);
		$shift = $this->input->post('shift', TRUE);
		$this->user_model->edit_shift($shift,$id_user);
		echo $shift;
	}
	public function blocked(){
		//$this->output->enable_profiler('TRUE');
		$data['id_user'] = $this->input->post('id_user', TRUE);
		$data['blocked'] = $this->input->post('blocked', TRUE);
		$this->user_model->edit_user($data);
		echo $block = $data['blocked']==1?'Blocked':'Unblocked';
	}
	public function delete_user($id_user){
		$this->user_model->delete_user($id_user);
		redirect('admin/hdr_setup_user_cont/user');
	}


}
?>