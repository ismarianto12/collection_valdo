<?php
class Monitoring extends Controller{

	function __construct(){
		parent::Controller();
	}


	function index(){
		redirect('spv/monitoring/agent_monitoring');
	}

    function agent_monitoring(){
        $id_user = $_SESSION['bid_user_s'];
        $data['title'] = 'SPV - Agent Monitoring';
        $data['agent_list'] = array(); //initalization

        ## Auto Kick
        $this->autoKickModule();

        if(!empty($id_user)){
           $where = array(
            'id_level'=> 3,
            'blocked'=> 0,
            'id_leader'=> $id_user
           );
           $this->db->where($where);
           $qObj = $this->db->get('hdr_user');
           $qArr = $qObj->num_rows() > 0 ? $qObj->result_array() : array();
           $loopid = 0;

           foreach($qArr as $agent){
            ## Get Online Status
            if($agent['user_status'] == 'online' && substr($agent['last_login'],0,10) == DATE('Y-m-d')){
                $qArr[$loopid]['status'] = 'ONLINE';
                $qArr[$loopid]['xdiff'] = '-';
                $qArr[$loopid]['logout_count'] = $this->get_logoutcount($agent['id_user']);
                $qArr[$loopid]['lastdial_diff'] = $this->get_lastdial_diff($agent['datetime_lastdial']);
            } else {
                $qArr[$loopid]['status'] = $agent['leave_reason'] != NULL ? $this->translateLeaveReason($agent['leave_reason']): 'OFFLINE';
                $qArr[$loopid]['status_code'] = $agent['leave_reason'] != NULL ? $agent['leave_reason'] : 'OFFLINE';
                $qArr[$loopid]['xdiff'] = $this->get_awaydifftime($agent['datetime_leave']);
                $qArr[$loopid]['logout_count'] = $this->get_logoutcount($agent['id_user']);
                $qArr[$loopid]['lastdial_diff'] =  $this->get_lastdial_diff($agent['datetime_lastdial']);
            }
            $loopid++;
           }

           $data['agent_list'] = $qArr;
        }
        $this->load->view('spv/hdr_header_spv', $data);
        $this->load->view('spv/agent_monitoring_view', $data);
        $this->load->view('spv/hdr_footer', $data);
    }

    function get_awaydifftime($datetime){
        $return = "-";
        if(!empty($datetime)){
            $SQL = "SELECT TIMEDIFF(NOW(), '$datetime') AS xdiff";
            $qObj = $this->db->query($SQL);
            if($qObj->num_rows() > 0){
                $qArr = $qObj->row_array();
                $return = $qArr['xdiff'];
            }
        }
        return $return;
    }

    function get_lastdial_diff($datetime_lastdial){
        if(!empty($datetime_lastdial)){
            $this->load->model('misc/misc_model');

            $sql = "SELECT TIME_TO_SEC(TIMEDIFF(NOW(), '$datetime_lastdial')) as diff";
            $qObj = $this->db->query($sql);
            //var_dump($this->db->last_query());
            $rowArr = $qObj->row_array();
            return $this->misc_model->humanize_time($rowArr['diff']);
        } else {
            return '-';
        }
    }

    function translateLeaveReason($reason){
        $return = "";
            $this->db->where('code', $reason);
            $qObj = $this->db->get('tb_logoutreason');
            if($qObj->num_rows() > 0){
                $qArr = $qObj->row_array();
                $return = $qArr['description'];
            }
        return $return;
    }

    function get_logoutcount($id_user=0){
        $this->db->select('IFNULL(COUNT(idx),0) AS cnt', FALSE);
        $this->db->where('user_id', $id_user);
        $this->db->where('curdate', date('Y-m-d'));
        $this->db->where('type', 'LOGOUT');
        $this->db->where('status', 'SUCCESS');

        if($id_user != 0){
            $qObj = $this->db->get('access_log');
            $qArr = $qObj->row_array();
            return $qArr['cnt'];
        } else {
            return "-";
        }
    }

    function logout_detail($id_user="", $period="", $cmd=""){
        $data['txt_title'] = "Logout Detail";
        $period = $period == "" ? DATE('Y-m-d') : $period;

        $data['prevdate'] = "#";
        $data['nextdate'] = "#";

        if($id_user != ""){
            ## load misc Model
            $this->load->model('misc/misc_model');

            $this->db->where('user_id', $id_user);
            $this->db->where('curdate', $period);
            $this->db->where_in('type', array('LOGOUT','LOGIN'));
            $this->db->where('status', 'SUCCESS');
            $this->db->order_by('timestamp', 'DESC');
            $qObj = $this->db->get('access_log');
            $rArr = $qObj->result_array();

            $data['access_log'] = $rArr;
            $data['miscModel'] = $this->misc_model;
            $data['period'] = $period;
            $chunk = explode('-', $period);

            $data['prevdate'] = site_url().'spv/monitoring/logout_detail/'.$id_user.'/'.DATE( 'Y-m-d', mktime(0,0,0,$chunk[1],($chunk[2]-1),$chunk[0]) );
            $data['nextdate'] = site_url().'spv/monitoring/logout_detail/'.$id_user.'/'.DATE( 'Y-m-d', mktime(0,0,0,$chunk[1],($chunk[2]+1),$chunk[0]) );
            $data['export'] = site_url().'spv/monitoring/logout_detail/'.$id_user.'/'.DATE( 'Y-m-d', mktime(0,0,0,$chunk[1],($chunk[2]),$chunk[0])).'/export';

            if($cmd=='export'){
                $config['delimiter'] = ";";
		        $config['changeline'] = "\r\n";
		        $config['nulldata'] = "-";
        		$config['filename'] = "LogoutDetail_".strtoupper($this->misc_model->get_tableDataById('hdr_user', $id_user, 'id_user', 'fullname')).'_'.$period;
                $headerArr = array('NO', 'USERNAME', 'TYPE', 'REASON', 'TIMESTAMP');
                ## Create Row Template;
                $excelArr = array();
                $idx = 0;
                foreach($rArr as $row):
                 $excelArr[$idx]['NO'] = $idx+1;
                 $excelArr[$idx]['USERNAME'] = $row['user_name'];
                 $excelArr[$idx]['TYPE'] = $row['type'];
                 $excelArr[$idx]['REASON'] = $this->misc_model->get_tableDataById('tb_logoutreason', $row['code'], 'code', 'description');
                 $excelArr[$idx]['TIMESTAMP'] = $row['timestamp'];
                 $idx++;
                endforeach;
                $this->createfile($excelArr, $headerArr, $config);
            }

            $this->load->view('spv/hdr_header_spv', $data);
            $this->load->view('spv/agent_logout_detail', $data);
            $this->load->view('spv/hdr_footer', $data);
        } else {
            die('<p>-No Data-</p>');
        }
    }

    function autoKickModule(){
       $update = array(
        'user_status'=> 'offline',
        'leave_reason'=> NULL
       );
       $this->db->where('id_level', 3);
       $this->db->where('TIME_TO_SEC(TIMEDIFF(NOW(), datetime_lastdial)) > 3600', NULL, FALSE);
       $this->db->where('DATE(datetime_lastdial)', DATE('Y-m-d'), FALSE);
       $this->db->update('hdr_user', $update);
       //var_dump($this->db->last_query());
    }

   function createfile($qArr, $headerArr, $config){
    $txt_data = ""; // initial Value

	## Create Header
    foreach($headerArr as $header){
  	 $txt_data .= '"'.$header.'"'.$config['delimiter'];
    }
    $txt_data .= $config['changeline'];

    ## Create Data Row
      foreach($qArr as $row){
       foreach($row as $field){
       	if(!empty($field)){
       	 $cleandata = $this->clean_field($field, $config['delimiter']);
       	 $txt_data .= '"'.$cleandata.'"'.$config['delimiter'];
        } else {
        	$txt_data .= '"'.$config['nulldata'].'"'.$config['delimiter'];
        }
        unset($field);
       }
        $txt_data .= $config['changeline'];
        unset($row);
      }
      unset($qArr);

     $this->load->helper('download');
     force_download($config['filename'].'.xls', $txt_data);
	}

    function clean_field($field, $delimiter){
		$pattern = "![\\r\\n\\\"$delimiter]!";
		$cleandata = preg_replace($pattern, '', $field);
		return $cleandata;
	}
}