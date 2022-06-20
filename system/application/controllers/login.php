<?php
class Login extends Controller
{
	function __construct()
	{
		parent::Controller();
		$this->load->model('Hdr_security_model', 'security_model');
		$this->load->model('admin/hdr_user_model');
		if (!empty($_SESSION['blevel'])) {
			if ($_SESSION["blevel"] == 'admin') {
				redirect(site_url() . 'admin/hdr_upload_cont/untouch');
			} elseif ($_SESSION["blevel"] == 'user') {
				redirect(site_url() . 'user/hdr_contact_cont/contact/call');
			} elseif ($_SESSION["blevel"] == 'spv') {
				redirect(site_url() . 'spv/hdr_spv_report_ctrl');
			} elseif ($_SESSION["blevel"] == 'spv_sta') {
				redirect(site_url() . 'spv/hdr_spv_send_to_agen_ctrl');
			}
		}
	}
	function index()
	{
		$data['title'] = 'Login';
		$this->load->view('login', $data);
	}
	public function info()
	{
		echo phpinfo();
	}
	public function jam()
	{
		echo date("H:i:s");
	}
	public function logg()
	{
		//die("Maaf, tidak bisa login. Harap login <a href='https://www.google.com/' target='_tab'>disini</a>");
		//$this->output->enable_profiler("TRUE");
		if (isset($_POST['post'])) {
			$data['username'] = strtolower($this->input->post('username', TRUE));
			$data['password']  = strtolower($this->input->post('password', TRUE));
			$get_user = $this->security_model->is_online($data);
			if ($this->security_model->is_block($data['username']) == 1) {
				echo 'You cannot Acces, because your account is block, Please Ask Admin to Unblocked it';
			} elseif ($this->security_model->login($data)) {
				$this->user_model->set_login_failed($data['username'], 0);
				echo json_encode([
					'status' => 1,
					'msg' => 'login berhasil'
				]);
			} else {
				http_response_code(403);
				echo "Please type the correct username and password";
			}
		}
	}

	function redirect_logged()
	{
		if (!empty($_SESSION['blevel'])) {
			if ($_SESSION["blevel"] == 'admin') {
				echo  "Please wait, <p>This page will automatically redirecting to Admin Page</p>";
				//echo '<script>location.href="'.site_url().'admin/hdr_upload_cont/master"</script>';
				echo '<script>location.href="' . site_url() . 'admin/hdr_upload_cont/untouch"</script>';
			} elseif ($_SESSION["blevel"] == 'user') {
				echo  "Please wait, <p>This page is automatically redirecting to Telecollector Page</p>";
				echo '<script>location.href="' . site_url() . 'user/hdr_contact_cont/contact/call"</script>';
			} elseif ($_SESSION["blevel"] == 'spv') {
				//$this->output->enable_profiler("TRUE");
				echo  "Please wait, <p>This page is automatically redirecting to Supervisor Page</p>";
				echo '<script>location.href="' . site_url() . 'spv/hdr_spv_report_ctrl"</script>';
			} elseif ($_SESSION["blevel"] == 'spv_sta') {
				echo  "Please wait, <p>This page is automatically redirecting to Supervisor Agen Page</p>";
				echo '<script>location.href="' . site_url() . 'spv/hdr_spv_send_to_agen_ctrl"</script>';
			}
		}
		return false;
	}
}
