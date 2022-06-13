<?php
class Message extends Controller{
	public function __construct(){
		parent::Controller();
		if(@!$_SESSION["role"]){
			redirect('login');
		}
		$this->load->helper('form');
		$this->load->model('message_model');
		//$this->load->library('session');
	}
	public function role() {
		if(isset($_SESSION['role'])){
			if ($_SESSION['role']=='supervisor')
				$_SESSION['role'] = 'spv';
			else
				$_SESSION['role'];
	}
	return $_SESSION['role'];
	}
	public function index(){
		redirect('message/inbox');
	}
	
	public function inbox($alert=''){
		//$alert = $this->uri->segment(4);
		if(!empty($alert)){
			$data['modal'] = 'tell()';	
		}
		$id_user = $_SESSION['id_user_s'];
		$data['id_user'] = $_SESSION['id_user_s'];
		$data['txt_title'] = "Your Private Message";
		$data["list"] = $this->message_model->list_message($id_user);
		$this->load->view($this->role().'/header',$data);
		$this->load->view('message/header_message',$data);
		$this->load->view('message/inbox',$data);
		$this->load->view($this->role().'/footer',$data);
	}
	public function read(){
		$data['txt_title'] = "Your inbox";
		$id_message = $this->uri->segment(3);
		$data['pm'] = $this->message_model->read_message($id_message);
		$status = $data['pm'];
		$rows = $status->row();
		$is_read = $rows->is_read;
		if($is_read == 0){
			$this->message_model->status($id_message);
		}
		$this->load->view($this->role().'/header',$data);
		$this->load->view('message/header_message',$data);
		$this->load->view('message/read',$data);
		$this->load->view($this->role().'/footer',$data);
	}
	public function reply() {
		$data['txt_title'] = "Reply Message";
		$id_message = $this->uri->segment(3);
		$data['pm'] = $this->message_model->read_message($id_message);
		if(isset($_POST['post'])){
			$id_user_from =$_SESSION['id_user_s'];
			$id_user_to = $_POST['id_user_to'];
			$subject = $_POST['subject'];
			$message = $_POST['message'];
			//$fullname = $_POST['fullname'];
			$send = $this->message_model->send($id_user_from,$id_user_to,$subject,$message);
			$alert = 1;
			redirect('message/inbox/'.$alert.'/');
		}
		$this->load->view($this->role().'/header',$data);
		$this->load->view('message/header_message',$data);
		$this->load->view('message/reply',$data);
		$this->load->view($this->role().'/footer',$data);
	}
	
	public function compose(){
		$data['txt_title'] = "Compose ";
		$id_leader =  $_SESSION['id_user_s'];
		$data['list'] = $this->message_model->list_users($id_leader);
		if(isset($_POST['post'])){
			$id_user_from =$_SESSION['id_user_s'];
			$id_user_to = $_POST['id_user_to'];
			$subject = $_POST['subject'];
			$message = $_POST['message'];	
			$send = $this->message_model->send($id_user_from,$id_user_to,$subject,$message);
			$get = $this->message_model->get_users($id_user_to);
			$ms = $get->fullname;
			$alert = 1;
			redirect('message/inbox/'.$alert.'/');
		}
		$this->load->view($this->role().'/header',$data);
		$this->load->view('message/header_message',$data);
		$this->load->view('message/compose',$data);
		$this->load->view($this->role().'/footer',$data);
	}
	
	public function composetodownline(){
		$data['txt_title'] = "Send to Group";
		$id_leader =  $_SESSION['id_user_s'];
		$role = $_SESSION['role'];
		$id_leader = $_SESSION['id_user_s'];
		$data['list'] = $this->message_model->group_message($id_leader);
		//$data['role'] = $this->message_model->list_role($role,$team);
		$get = $data['list'] ;
		if(isset($_POST['post'])){
			$id_user_from =$_SESSION['id_user_s'];
			$id_user_to = $_POST['id_user_to'];
			$id_user_to_down = $id_user_to;
			$subject = $_POST['subject'];
			$message = $_POST['message'];	
			$send = $this->message_model->send($id_user_from,$id_user_to,$subject,$message);
			$sendtodwown = $this->message_model->group_message($id_user_to_down);
			foreach($sendtodwown->result() as $row){
				$id_user_from_up = $id_user_to_down; 
				$id_user_to = $row->id_user;
				$subject = $_POST["subject"];
				$message = $_POST["message"];
				$this->message_model->sendtoall($id_user_from_up,$id_user_to,$subject,$message);
			}
			$get = $this->message_model->get_users($id_user_to);
			$alert = 1;
			redirect('message/inbox/'.$alert.'/');
		}
		
		$this->load->view($this->role().'/header',$data);
		$this->load->view('message/header_message',$data);
		$this->load->view('message/composedownline',$data);
		$this->load->view($this->role().'/footer',$data);
	}
	public function composetoall(){
		$data['txt_title'] = "Broadcast Message";
		$id_leader =  $_SESSION['id_user_s'];
		$data['list'] = $this->message_model->group_message($id_leader);
		$get = $data['list'] ;
		$all = $this->message_model->list_users($id_leader);
		if ($_SESSION['role']=='supervisor'){
			if(isset($_POST['post'])) {
			foreach($get->result() as $row){
				$id_user_from = $_SESSION["id_user_s"]; 
				$id_user_to = $row->id_user;
				$subject = $_POST["subject"];
				$message = $_POST["message"];
				$this->message_model->sendtoall($id_user_from,$id_user_to,$subject,$message);
				
			}
				$alert = 1;
				redirect('message/inbox/'.$alert.'/');
		}
		}else{
		if(isset($_POST['post'])) {
			foreach($all->result() as $row){
				$id_user_from = $_SESSION["id_user_s"]; 
				$id_user_to = $row->id_user;
				$subject = $_POST["subject"];
				$message = $_POST["message"];
				$this->message_model->sendtoall($id_user_from,$id_user_to,$subject,$message);
				
			}
				$alert = 1;
				redirect('message/inbox/'.$alert.'/');
		}
		}
		$this->load->view($this->role().'/header',$data);
		$this->load->view('message/header_message',$data);
		$this->load->view('message/composetoall',$data);
		$this->load->view($this->role().'/footer',$data);
	}
	public function delete(){
		$id_message = $this->uri->segment(3);
		$this->message_model->delete($id_message);
		redirect('message/inbox');
	}
}
?>