<?php

class Upload extends Controller {

    function Upload() {
        parent::Controller();
        $this->load->helper('form');
        $this->load->helper('url');
    }

    /*
     * 	Display upload form
     */

    function index() {

        $this->load->view('upload/view');
    }

    /*
     * 	Handles JSON returned from /js/uploadify/upload.php
     */

    function set_filename($path, $filename, $file_ext, $encrypt_name = FALSE) {
        if ($encrypt_name == TRUE) {
            mt_srand();
            $filename = md5(uniqid(mt_rand())) . $file_ext;
        }

        if (!file_exists($path . $filename)) {
            return $filename;
        }

        $filename = str_replace($file_ext, '', $filename);

        $new_filename = '';
        for ($i = 1; $i < 100; $i++) {
            if (!file_exists($path . $filename . $i . $file_ext)) {
                $new_filename = $filename . $i . $file_ext;
                break;
            }
        }

        if ($new_filename == '') {
            return FALSE;
        } else {
            return $new_filename;
        }
    }

    function prep_filename($filename) {
        if (strpos($filename, '.') === FALSE) {
            return $filename;
        }
        $parts = explode('.', $filename);
        $ext = array_pop($parts);
        $filename = array_shift($parts);
        foreach ($parts as $part) {
            $filename .= '.' . $part;
        }
        $filename .= '.' . $ext;
        return $filename;
    }

    function get_extension($filename) {
        $x = explode('.', $filename);
        return '.' . end($x);
    }

    function uploading() {
        if (!empty($_FILES)) {
            $locate = explode('/', $_SERVER['SCRIPT_NAME']);
            $base_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $locate[1];
            $path = $base_path . $_REQUEST['folder'] . '/';
            //$client_id = $_GET['client_id'];
            $file_temp = $_FILES['Filedata']['tmp_name'];
            $names = date('Y-m-d') . 'txt';
            $file_name = prep_filename($_FILES['Filedata']['name']);
            $file_ext = get_extension($_FILES['Filedata']['name']);
            $real_name = $names;
            $newf_name = set_filename($path, $file_name, $file_ext);
            $file_size = round($_FILES['Filedata']['size'] / 1024, 2);
            $file_type = preg_replace("/^(.+?);.*$/", "\\1", $_FILES['Filedata']['type']);
            $file_type = strtolower($file_type);
            $targetFile = str_replace('//', '/', $path) . $newf_name;
            move_uploaded_file($file_temp, $targetFile);
            $filearray = array();
            $filearray['file_name'] = $names;
            $filearray['real_name'] = $names;
            $filearray['file_ext'] = $file_ext;
            $filearray['file_size'] = $file_size;
            $filearray['file_path'] = $targetFile;
            $filearray['file_temp'] = $file_temp;
            //$filearray['client_id'] = $client_id;

            $json_array = json_encode($filearray);
            echo $json_array;
        } else {
            echo "1";
        }

        //$this->load->view('upload/uploadify', $data);
    }

    public function uploadify() {
        //$this->output->enable_profiler('TRUE');
        //Decode JSON returned by /js/uploadify/upload.php
        $file = $this->input->post('filearray');
        $data['json'] = json_decode($file);
        $jcode = json_decode($file);
        $paths = $jcode->file_path;
        //echo $paths;
       // $this->cust_model->import_data_cust($paths);
        $this->load->view('upload/uploadify', $data);
    }

}

/* End of File /application/controllers/upload.php */