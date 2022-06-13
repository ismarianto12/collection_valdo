<?php

/*
  This script software package is NOT FREE And is Copyright 2010 (C) Valdo all rights reserved.
  we do supply help or support or further modification to this script by Contact
  Haidar Mar'ie
  e-mail = coder5@ymail.com
 */

class Hdr_upload_cont extends Controller {

    public function __construct() {
        parent::Controller();

        $this->load->model('admin/hdr_setup_model', 'setup_model');
        $this->load->model('hdr_debtor/hdr_debtor_model', 'debtor_model');
        $this->load->helper('flexigrid');
        $this->id_user = @$_SESSION["id_user"];
        $this->role = @$_SESSION["role"];
    }

    public function index() {
        $this->master();
    }

    public function master() {


        $data['title'] = 'Please Choose Master File to be upload';
        $data['file_type'] = "master";
        $data['header_file'] = $this->setup_model->field_file($id_upload_cat = '1');
        $this->load->view('admin/hdr_header_admin', $data);
        $this->load->view('admin/hdr_upload/hdr_upload_view', $data);
        $this->load->view('admin/hdr_footer', $data);
    }
    public function dpd_minus() {
        $data['title'] = 'Please Choose DPD Minus File to be upload';
        $data['file_type'] = "dpd_minus";
        $data['header_file'] = $this->setup_model->field_file($id_upload_cat = '1');
        $this->load->view('admin/hdr_header_admin', $data);
        $this->load->view('admin/hdr_upload/hdr_upload_view', $data);
        $this->load->view('admin/hdr_footer', $data);
    }

    public function summary_details_dpd() {
        //hdr_details_dpd
        $this->load->model('spv/hdr_details_dpd_model', 'details_dpd');
        $id_user = $_SESSION['bid_user_s'];
        $begindate = date('Y-m-d');
        $beginmonth = date('Y-m-01');
        $enddate = date('Y-m-d');
        $endmonth = date('Y-m-31');
        $data['dpd_list'] = $this->details_dpd->dpd_list();

        $this->load->view('spv/details/details_dpd_view', $data);
    }

    public function payment() {
        $data['title'] = 'Please Choose Payment File to be upload';
        $data['file_type'] = "payment";
        $data['header_file'] = $this->setup_model->field_file($id_upload_cat = '2');
        $this->load->view('admin/hdr_header_admin', $data);
        $this->load->view('admin/hdr_upload/hdr_upload_view', $data);
        $this->load->view('admin/hdr_footer', $data);
    }

    public function call_track() {
        $data['title'] = 'Please Choose File to be upload';
        $data['file_type'] = "call_track";
        $data['header_file'] = $this->setup_model->field_file($id_upload_cat = '3');
        $this->load->view('admin/hdr_header_admin', $data);
        $this->load->view('admin/hdr_upload/hdr_upload_view', $data);
        $this->load->view('admin/hdr_footer', $data);
    }

    public function action_code() {
        $data['title'] = 'Please Choose File to be upload';
        $data['file_type'] = "action_code";
        $data['header_file'] = $this->setup_model->field_file($id_upload_cat = '4');
        $this->load->view('admin/hdr_header_admin', $data);
        $this->load->view('admin/hdr_upload/hdr_upload_view', $data);
        $this->load->view('admin/hdr_footer', $data);
    }

    public function active_agency() {
        $data['title'] = 'Please Choose File to be upload';
        $data['file_type'] = "active_agency";
        $data['header_file'] = $this->setup_model->field_file($id_upload_cat = '5');
        $this->load->view('admin/hdr_header_admin', $data);
        $this->load->view('admin/hdr_upload/hdr_upload_view', $data);
        $this->load->view('admin/hdr_footer', $data);
    }
    
    public function set_truncate() {

				$sql = "truncate table hdr_debtor_main";
				//echo "<b>$sql</b>";
				$this->db->query($sql);

				$sql = "truncate table hdr_tmp_log";
				$this->db->query($sql);

				echo "<b>Data has been truncate</b>";
      }

    public function reschedule() {
        $data['title'] = 'Please Choose File to be upload';
        $data['file_type'] = "reschedule";
        $data['header_file'] = $this->setup_model->field_file($id_upload_cat = '6');
        $this->load->view('admin/hdr_header_admin', $data);
        $this->load->view('admin/hdr_upload/hdr_upload_view', $data);
        $this->load->view('admin/hdr_footer', $data);
    }

    public function upload_test() {
        //$this->debtor_model->insert_db();
        //$this->debtor_model->insert_db2();
        $this->load->model('admin/hdr_upload_model', 'upload_model');
        $this->upload_model->uploading();
        echo 'Data Has been Insert To Database And please Wait!';

        //echo "<script>jQuery('#flex1').flexReload();</script>";
    }

    public function pump_data()
    {
      $this->load->model('admin/hdr_upload_model', 'upload_model');
      $this->upload_model->pump_data();
      echo 'Data Has been Insert To Database!';
    }

    function uploading() {

        //print_r($_POST);
        if (!empty($_FILES)) {
            $this->load->model("admin/hdr_upload_model", "upload_model");
            $locate = explode('/', $_SERVER['SCRIPT_NAME']);
            $file_post = $_POST['types'];

            //$base_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $locate[1];
            $path = basic_path() .'/assets/upload/'. $file_post . '/';
            //$client_id = $_GET['client_id'];

            $file_link = str_replace(basic_path(), "", $path);
            $file_temp = $_FILES['Filedata']['tmp_name'];
            $file_ext = get_extension($_FILES['Filedata']['name']);
            $names = date('Y-m-d') . $file_ext;

            $file_name = prep_filename($_FILES['Filedata']['name']);
            $newf_name = set_filename($path, $names, $file_ext);

            $file_size = round($_FILES['Filedata']['size'] / 1024, 2);
            $file_type = preg_replace("/^(.+?);.*$/", "\\1", $_FILES['Filedata']['type']);
            $file_type = strtolower($file_type);

            $targetFile = str_replace('//', '/', $path) . $newf_name;
            move_uploaded_file($file_temp, $targetFile);

            $filearray = array();
            $filearray['file_name'] = $file_name;
            $filearray['real_name'] = $newf_name;
            $filearray['file_ext'] = $file_ext;
            $filearray['file_size'] = $file_size;
            $filearray['file_link'] = $file_link;
            $filearray['file_path'] = $targetFile;
            $filearray['file_temp'] = $file_temp;
            $filearray['file_post'] = $file_post;

            //$filearray['client_id'] = $client_id;
            //print_r($_POST);
            $json_array = json_encode($filearray);
            //echo $json_array;

            $file = $json_array;
            $data['json'] = json_decode($file);

            $this->upload_model->uploader($data['json']);
            $jcode = json_decode($file);
            $paths = $jcode->file_path;
            $this->load->view('admin/uploadify', $data);
        } else {
            echo "Failed";
        }

    }

    public function upload_done() {
        if (isset($_POST['post'])) {
            $subject = $_POST['subject'];
            $task_description = $_POST['task_description'];
            $due_date = $_POST['due_date'];
            $description = @$_POST['description'];
            $name = @$_POST['name'];
            $value = @$_POST['value'];
            //$this->dashboard_model->add_task($subject,$task_description,$due_date);
            echo 'New Master File Has been insert';
            echo 'haidar';
            echo "<script>jQuery('#flex1').flexReload();</script>";
            echo "<script>jQuery.unblockUI();</script>";
        }
    }

    public function insert_db() {
        $this->debtor_model->insert_db();
        $this->debtor_model->insert_db2();
    }

    public function empty_db() {
        $this->debtor_model->empty_deb();
        $this->debtor_model->empty_tmp3();
    }

}
