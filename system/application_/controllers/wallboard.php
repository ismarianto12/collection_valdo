<?php
class Wallboard extends Controller{
    
    function wallboard(){
        parent::Controller();
        $this->load->library('asmanager');
    }
    
    function index(){
        $parser = array();
        $this->load->model('misc/misc_model');
        $data['miscModel'] = $this->misc_model;
        
        $this->load->view('wallboard', $parser);
    }
    
    function getajax_sipmonitoring(){
        $parser = array();
        $this->load->model('misc/misc_model');
        $parser['miscModel'] = $this->misc_model;
        $this->load->helper('cyrusenyx');
        
        $spv = array();
        
        $today = date('Y-m-d');
        
        
        //echo 'test';exit;
        ## GET Active SPV
        $this->db->select("*");
        $this->db->select("(SELECT COUNT(id_asterisk) FROM hdr_user b WHERE id_leader = a.id_user  AND blocked = 0) AS child", FALSE);
        //  $this->db->where('id_asterisk', );
        $this->db->where('blocked', 0);
        $this->db->where('date(last_login)', $today);
        
        $this->db->where('pabx_ext <>', 'NULL');
        
                //$this->db->where('pabx_ext<>', 'NULL',false);
                //$this->db->where('ai', 1);
                //$this->db->where('date(last_call)', $today);
        $this->db->order_by('id_asterisk');
        //$this->db->where('ai', 1);
        //$this->db->where('user_status', 'online');
        $qObj = $this->db->get('hdr_user AS a');
        
        //echo $this->db->last_query();exit;
        
        
        if($qObj->num_rows() > 0){
         $qArr = $qObj->result_array();
         
 
         foreach($qArr as $spvlist){
             
             //echo $spvlist['child'] * 1 .'<br />';
            //if($spvlist['child'] * 1 > 0){
             array_push($spv, $spvlist['id_user']);   
            //}
         }
         //var_dump($spv); die();
         //echo $this->db->last_query();
        }
        
        //echo $this->db->last_query();exit;
        
        
        
        $today = date('Y-m-d');
        $spvlist = array();
        $idx = 0;
        if(COUNT($spv) > 0){
            foreach($spv as $id_spv){
                $agentdata = array();
                ## Get Active TSR
                //$this->db->where('id_role', 5);
                //$this->db->where('id_user', $id_spv);
                $this->db->where('blocked', 0);
                $this->db->where('pabx_ext <>', 'NULL');
                $this->db->order_by('id_asterisk');  
                $this->db->where('date(last_login)', $today);
                //$this->db->where('pabx_ext<>', 'NULL',false);
                //$this->db->where('ai', 1);
                //$this->db->where('date(last_call)', $today);
                $this->db->order_by('id_asterisk');
                $qObj = $this->db->get('hdr_user');
                //echo $this->db->last_query();
                if($qObj->num_rows() > 0){
                   $qArr = $qObj->result_array();
                   $img_online = '<img src="'.base_url().'component/images/online.gif" alt="online" width="24" height="24" />';
                   $img_offline = '<img src="'.base_url().'component/images/offline.gif" alt="offline" width="24" height="24" />';
                   $idx2 = 0;
                   $i=1;
                   foreach($qArr as $agent){
                    $agentdata[$idx2]['nums'] = $i++;
                    $agentdata[$idx2]['loginstat_image'] = $agent['user_status'] == 'online' ? $img_online : $img_offline;
                    $agentdata[$idx2]['id_user'] = $agent['id_user'];
                    $agentdata[$idx2]['username'] = $agent['username'];
                    $agentdata[$idx2]['fullname'] = $agent['username'].' - '.$agent['pabx_ext'].' - '.$agent['id_asterisk'];
                    //$agentdata[$idx2]['fullname'] = char_limiter($agent['username'], 10).' - '.$agent['pabx_ext'].' - '.$agent['id_asterisk'];
                    $agentdata[$idx2]['user_status'] = $agent['user_status'];
                    $agentdata[$idx2]['last_call'] = $agent['last_call'];
                    $agentdata[$idx2]['id_asterisk'] = $agent['id_asterisk'];
                    $idx2++;
                   }
                } else {
                   $qArr = array();
                }
                $spvlist[$idx]['id_spv'] = $id_spv;
                $spvlist[$idx]['agentlist'] = $agentdata;
                $idx++;
            }
            
            
        }
        
        //var_dump($agentdata);
        
        $parser['spvlist'] = $spvlist;
        $this->load->view('wallboard_sipmonitoring', $parser);
    }
    
        function get_sipinuse(){
            
            
            if ($this->asmanager->connect()) {
            $asresponse = $this->asmanager->command('sip show inuse');
            
            $asdata = $asresponse['data'];
            //var_dump($asdata);
            $lines = explode("\n", $asdata);
            //var_dump($lines);
            $curline = 0;
            $response = '';
            $response_line = 0;
            
            foreach($lines as $line){
                if($curline > 1){
                  $line = preg_replace('/\s+/', ' ', $line);
                  $chunk = explode(' ',$line);
                  $stat = explode('/',@$chunk[1]);
                  $response .= $chunk[0].'|'.$stat[0]."\n"; //MARTIN-> pake cara ini karena diservernya gak support json, jd pake string
                }
                $curline++;
            }
            $this->asmanager->disconnect();
            //echo $response;
            
            $response2 = array();
            
            if(strlen($response) > 25){
                $lines = explode("\n", $response);
                
                //var_dump($lines);
                foreach($lines as $line){
                   $chunk = explode("|", $line);
                   $response2[$chunk[0]] = @$chunk[1];
                 }
            } else {
                $lines = '';
                $response2 = array();
            }    
            
            return ($response2);
            }else{
                echo 'no konak';
            }
            
            
                                           
    }
    
    
    function upd_wallboardkiri(){
        $this->load->model('misc/misc_model');
        $data['miscModel'] = $this->misc_model;
        
        $bucket = array();
        $sip_data = $this->get_sipinuse();
        $sip_login = $this->status_agent();
        
        //var_dump($sip_login);  exit;
        
        
        
        ## Cari semua user non blocked;
        $today = date('Y-m-d');
        
        $this->db->select('*, "" AS lastdial_sec', FALSE);
        //$this->db->where('id_role'  , 5);
        $this->db->where('blocked', 0);
        $this->db->where('pabx_ext <>', 'NULL');
        $this->db->where('date(last_login)', $today);
        //$this->db->where('id_asterisk <>', '0000');
        //$this->db->where('id_asterisk <>', '');
        //$this->db->where('ai', 1);
        $this->db->order_by('id_asterisk');          
        $qObj = $this->db->get('hdr_user');
        //echo $this->db->last_query();exit;
        
        //echo $this->db->last_status();
        $qArr = $qObj->result_array();
        //var_dump($qArr);
        $totdata = $this->get_totcalltrack();
        
        $talktime_data = $this->get_talktime();
        
        //var_dump($talktime_data);exit;
        
        $img_online = '<img src="'.base_url('').'component/images/online.gif" alt="online" width="24" height="24" />';
        $img_offline = '<img src="'.base_url().'component/images/offline.gif" alt="offline" width="24" height="24" />';
        
        $login_online = '<img src="'.base_url().'component/images/phone_login.gif" alt="offline" width="25" height="25" />';
        $login_off = '<img src="'.base_url().'component/images/phone_off.gif" alt="offline" width="25" height="25" />';
        $login_pause = '<img src="'.base_url().'component/images/phone_pause.gif" alt="offline" width="25" height="25" />';
        $login_talk = '<img src="'.base_url().'component/images/phone_ringing.png" alt="offline" width="25" height="25" />';
        
        $img_talking = '<img src="'.base_url().'component/images/talking_phone.png" alt="talking" width="24" height="24" />';
        $img_idle = '<img src="'.base_url().'component/images/idle_phone.png" alt="idle" width="24" height="24" />';
        
        
          //var_dump($qArr);EXIT;
        ## Looping Data;
        $i=1;
        $tot_aktif = 0;
        $tot_non_aktif = 0;
        $val_aktif = 0;
        $val_non_aktif = 0;
        $tot_offline = 0;
        $val_offline = 0;
        
        $tot_online =0;
        $tot_waiting=0;
        $tot_offline_pause=0;
        $tot_offline_unvailabe=0;
        
        foreach($qArr as $tsr){
            $status = @$sip_data[$tsr['pabx_ext']];
            $status_login  = @$sip_login[$tsr['pabx_ext']];
            $sts_login = "";
            
            if($status_login == "Not in use"){
                $sts_login = $login_online;   
                
                $tot_waiting++;
            }else if($status_login == "paused"){
                $sts_login = $login_pause;
                
                $val_offline = $tot_offline++;       
                
                $tot_offline_pause++;
                
            }elseif($status_login == "Unavailable" || empty($status_login)){
                $sts_login = $login_off;      
                
                $val_offline = $tot_offline++; 
                
                $tot_offline_unvailabe++;
            }else{
                $sts_login = $img_talking; 
                
                $tot_online++;
            }
            
            if($status == '1'){
                $val_aktif = $tot_aktif++;
            }
            
            if($status != '1'){
                $val_non_aktif = $tot_non_aktif++;
            }
            
            $id_agent = $tsr['id_asterisk'];
            $DB2 = $this->load->database('cc2', TRUE);
            $qry_idle = $DB2->query("SELECT datetime_end,TIMEDIFF(NOW(),datetime_end) AS idle_time FROM call_entry WHERE id_agent = '$id_agent' AND datetime_end >= CONCAT(CURRENT_DATE(),' 00:00:00') AND datetime_end <= CONCAT(CURRENT_DATE(),' 23:59:59') order by datetime_end desc limit 1" );
            $rslt_idle =   $qry_idle->row();
            
            $call_end_date =  $rslt_idle->datetime_end;
            $idle_time =  $rslt_idle->idle_time;
            
            
            //echo $call_end_date;exit;
 
             
             
             
            
            
            
          //  echo var_dump($status).'<br />'; 
          //if(!empty($status)){  
            $bucket[$tsr['id_user']]['nums'] = $i++;
            $bucket[$tsr['id_user']]['loginstat'] = $tsr['user_status'] == 'online' ? $img_online : $img_offline;
            $bucket[$tsr['id_user']]['status_login'] = $sts_login ;
            $bucket[$tsr['id_user']]['id_asterisk'] = $tsr['id_asterisk'];
            $bucket[$tsr['id_user']]['status'] = $status == '1' ? $img_talking : $img_idle;
            $bucket[$tsr['id_user']]['status_string'] = $status;
            $bucket[$tsr['id_user']]['last_call'] = "";//$this->misc_model->humanize_time($tsr['lastdial_sec']);
            $bucket[$tsr['id_user']]['talktime'] = @$talktime_data[$tsr['id_asterisk']]['todayduration'];
            $bucket[$tsr['id_user']]['ratio'] = @$talktime_data[$tsr['id_asterisk']]['ratio'];
            $bucket[$tsr['id_user']]['totcall'] = @$talktime_data[$tsr['id_asterisk']]['totcall'];
            $bucket[$tsr['id_user']]['tottrack'] = @$totdata[$tsr['username']]['tottrack'];
            $bucket[$tsr['id_user']]['last_call'] = $call_end_date;
            $bucket[$tsr['id_user']]['idle_time'] = $idle_time;
            //}
        }
        /*
        
        $tot_online =0;
        $tot_waiting=0;
        $tot_offline_pause=0;
        $tot_offline_unvailabe=0;
        */
        $bucket['tot_all'] = $i-1;
        $bucket['tot_offline'] = ($tot_offline_pause + $tot_offline_unvailabe);
        $bucket['tot_aktif'] = $tot_online;
        $bucket['tot_non_aktif'] =  $tot_waiting;
        //exit;
        echo json_encode($bucket);
    }
    
  function get_talktime(){
         $curdate = DATE('Y-m-d');
         $return = array();
         
         $DB2 = $this->load->database('cc2', TRUE);
         
        //$DB2->select('userid');
        //$DB2->select('channel');
         $DB2->select('id_agent AS sip', FALSE);
         $DB2->select('SEC_TO_TIME(SUM(duration)) AS todayduration', FALSE);
         $DB2->select('count(id_agent) AS totcall', FALSE);
         $DB2->select('ROUND(((SUM(duration) / (TIME_TO_SEC(TIMEDIFF(CURTIME(), "08:00:00"))))*100),0) AS ratio', NULL, FALSE);
         $DB2->where("datetime_entry_queue  >= '$curdate 00:00:00'");
         $DB2->where("datetime_entry_queue  <= '$curdate 23:59:59'");
         //$this->db->where('datetime_entry_queue >=', "$curdate 00:00:00",NULL,FALSE);
         //$this->db->where('datetime_entry_queue <=', "$curdate 23:59:59",NULL,FALSE);
        // $DB2->where('lastapp', 'Dial');
         $DB2->group_by('id_agent');
         $qObj = $DB2->get('call_entry');
            //echo $DB2->last_query();exit;           
         //$DB2->reconnect();
         if($qObj->num_rows() > 0){
             $qArr = $qObj->result_array();
             foreach($qArr AS $row_data){
                 //$return[$row_data['sip']] = $row_data['todayduration'].'#'.$row_data['ratio'];
                $return[$row_data['sip']]['todayduration'] = $row_data['todayduration'];
                $return[$row_data['sip']]['ratio'] = $row_data['ratio'];
                $return[$row_data['sip']]['totcall'] = $row_data['totcall'];
             }
            //var_dump($return); die();
             return ($return);
         } else { return ''; }
    }
    
    
    function get_totcalltrack(){
         $curdate = DATE('Y-m-d');
         $return = array();
         
         //$DB2 = $this->load->database('cc2', TRUE);
         
        //$DB2->select('userid');
        //$DB2->select('channel');
         $this->db->select('username', FALSE);
         
         
         $this->db->select('count(username) AS tottrack', FALSE);
         $this->db->where("call_date = '$curdate'", NULL, FALSE);
        // $DB2->where('lastapp', 'Dial');
         $this->db->group_by('username');
         $qObj = $this->db->get('hdr_calltrack');
         
  //          echo $this->db->last_query();exit;           
         //$DB2->reconnect();
         if($qObj->num_rows() > 0){
             $qArr = $qObj->result_array();
             foreach($qArr AS $row_data){
                 //$return[$row_data['sip']] = $row_data['todayduration'].'#'.$row_data['ratio'];
                
                $return[$row_data['username']]['tottrack'] = $row_data['tottrack'];
             }
  //          var_dump($return); die();
             return ($return);
         } else { return ''; }
    }
    
    
    
    
  public function status_agent()
    {
        $arrSIP = array();
        if ($this->asmanager->connect()) {
            $asresponse = $this->asmanager->command('queue show');
            $asdata = $asresponse['data'];
            
            
            $lines = explode("\n", $asdata);
            //  var_dump($lines);
            
            $curline = 0;
            $idx = 0;
            $response2 = array();
            
            foreach ($lines as $line) {
                if ($curline > 2) {
                    $line = str_replace(" (ringinuse disabled) (dynamic) ", ' ', $line);
                    //echo $line.'-'.strpos($line, "(Not in use)").'<br />' ;
                    
                     $exp = explode(' (',$line);
                    
                    
                     $status = explode(')',$exp[2]);
                    if(!empty($status)){
                     $sip_rep = str_ireplace(')','',$exp[1]);
                     $sip = explode('from',$sip_rep);
                     $sipexp = explode('/',$sip[0]);
                     //$sip_exp =  explode('',$sip);
                     //echo  $sipexp[1].' - '.$status[0].'<br />'; 
                     $response2[str_ireplace(' ','',$sipexp[1])] = $status[0];
                     
                   } 
                   
                    
                    
                    
                }
                
                $curline++;
            }
            
            
                   
            
        } else {
            $response2 = array();
            
        }
        
        
    
    return($response2);
    }  
    
    function cek_sip(){
        $sip_data = $this->get_sipinuse();
        var_dump($sip_data);
        
        $sts_agent = $this->status_agent();
        var_dump($sts_agent);exit;        
        
    }
    
    
  function log_user_ai(){
        $this->load->model('misc/misc_model');
        $data['miscModel'] = $this->misc_model;
        
        $bucket = array();
        $sip_data = $this->get_sipinuse();
        $sip_login = $this->status_agent();
        
        //var_dump($sip_login);  exit;
        
        
        
        ## Cari semua user non blocked;
        $today = date('Y-m-d');
        
        $this->db->select('*, "" AS lastdial_sec', FALSE);
        //$this->db->where('id_role'  , 5);
        $this->db->where('blocked', 0);
        $this->db->where('pabx_ext <>', 'NULL');
        $this->db->where('date(last_login)', $today);
        //$this->db->where('id_asterisk <>', '0000');
        //$this->db->where('id_asterisk <>', '');
        //$this->db->where('ai', 1);
        $this->db->order_by('id_asterisk');          
        $qObj = $this->db->get('hdr_user');
        //echo $this->db->last_query();exit;
        
        //echo $this->db->last_status();
        $qArr = $qObj->result_array();
        //var_dump($qArr);
        $totdata = $this->get_totcalltrack();
        
        $talktime_data = $this->get_talktime();
        
        //var_dump($talktime_data);exit;
        
        $img_online = '<img src="'.base_url('').'component/images/online.gif" alt="online" width="24" height="24" />';
        $img_offline = '<img src="'.base_url().'component/images/offline.gif" alt="offline" width="24" height="24" />';
        
        $login_online = '<img src="'.base_url().'component/images/phone_login.gif" alt="offline" width="25" height="25" />';
        $login_off = '<img src="'.base_url().'component/images/phone_off.gif" alt="offline" width="25" height="25" />';
        $login_pause = '<img src="'.base_url().'component/images/phone_pause.gif" alt="offline" width="25" height="25" />';
        $login_talk = '<img src="'.base_url().'component/images/phone_ringing.png" alt="offline" width="25" height="25" />';
        
        $img_talking = '<img src="'.base_url().'component/images/talking_phone.png" alt="talking" width="24" height="24" />';
        $img_idle = '<img src="'.base_url().'component/images/idle_phone.png" alt="idle" width="24" height="24" />';
        
        
          //var_dump($qArr);EXIT;
        ## Looping Data;
        $i=1;
        $tot_aktif = 0;
        $tot_non_aktif = 0;
        $val_aktif = 0;
        $val_non_aktif = 0;
        $tot_offline = 0;
        $val_offline = 0;
        
        
        $tot_online =0;
        $tot_waiting=0;
        $tot_offline_pause=0;
        $tot_offline_unvailabe=0;
        
         
        $stVal = "";
        foreach($qArr as $tsr){
            $status = @$sip_data[$tsr['pabx_ext']];
            $status_login  = @$sip_login[$tsr['pabx_ext']];
            $sts_login = "";
            if($status_login == "Not in use"){
                $sts_login = $login_online;
                   
                $tot_waiting++;
            }else if($status_login == "paused"){
                $sts_login = $login_pause;
                $val_offline = $tot_offline++;        
                
                $tot_offline_pause++;
            }elseif($status_login == "Unavailable" || empty($status_login)){
                $sts_login = $login_off;      
                $val_offline = $tot_offline++;  
                
                $tot_offline_unvailabe++;
            }else{
                $sts_login = $img_talking;
                
                $tot_online++;
            }
            
            if($status == '1'){
                $val_aktif = $tot_aktif++;
            }
            
            if($status != '1'){
                $val_non_aktif = $tot_non_aktif++;
            }
            
 
             
             
             
            
            
            
          //  echo var_dump($status).'<br />'; 
          //if(!empty($status)){  
            $bucket[$tsr['id_user']]['nums'] = $i++;
            $bucket[$tsr['id_user']]['loginstat'] = $tsr['user_status'] == 'online' ? $img_online : $img_offline;
            $bucket[$tsr['id_user']]['status_login'] = $sts_login ;
            $bucket[$tsr['id_user']]['id_asterisk'] = $tsr['id_asterisk'];
            $bucket[$tsr['id_user']]['status'] = $status == '1' ? $img_talking : $img_idle;
            $bucket[$tsr['id_user']]['status_string'] = $status;
            $bucket[$tsr['id_user']]['last_call'] = "";//$this->misc_model->humanize_time($tsr['lastdial_sec']);
            $bucket[$tsr['id_user']]['talktime'] = @$talktime_data[$tsr['id_asterisk']]['todayduration'];
            $bucket[$tsr['id_user']]['ratio'] = @$talktime_data[$tsr['id_asterisk']]['ratio'];
            $bucket[$tsr['id_user']]['totcall'] = @$talktime_data[$tsr['id_asterisk']]['totcall'];
            $bucket[$tsr['id_user']]['tottrack'] = @$totdata[$tsr['username']]['tottrack'];
            
            $stVal2 .= $i-1 .'|'.$tsr['username'].'|'.@$talktime_data[$tsr['id_asterisk']]['totcall'].'|'.@$totdata[$tsr['username']]['tottrack'].'|'.date('Y-m-d');
            $stVal2 .="\r\n";
        
            
            
            
            //}
        }   
        
        $tot_data_ai =  $this->get_totdata();
        
            
        $tot_all = $i-1;
        $tot_offline = ($tot_offline_pause + $tot_offline_unvailabe);;
        $tot_aktif = $tot_online;
        $tot_non_aktif = $tot_waiting;
        
        $stVal .= $tot_all.'|'.$tot_aktif.'|'.$tot_non_aktif.'|'.$tot_offline.'|'.date('Y-m-d H:i:s');
        $stVal .="\r\n";
        
                $date = date('my');
                $createdir = "./log/$date";
                //echo $createdir;
                if (!file_exists("$createdir")){
                            mkdir("$createdir",0777,true);
                            chmod("$createdir", 0777);
                            //echo 'tesdt';
                    }
                
                
                
                //$myfile = fopen("/var/www/html/konektordb/log/log_ai_".date('Ymd').".txt", "w") or die("Unable to open file!");
                $myfile_dir = "$createdir/LOG_USER_AI_".date('Ymd').".txt";
                $stHeader = "User AI|Online|Waiting|Off Line|Date";
                //echo $stCnt; 
                //file_put_contents($myfile, $stCnt,'FILE_APPEND');                        
               
               if(date('H:i') < '17:01'){
                    $myfile = fopen($myfile_dir, "a") or die("Unable to open file!");
                    $row = 0;
                    if (($fp = fopen($myfile_dir, "r")) !== FALSE) { 
                        while (($record = fgetcsv($fp)) !== FALSE) {
                            $row++;
                            }

                            //echo $row;
                            
                  }  
                
                   $stCnt = ($row > 0 ?"":"Total Data | $tot_data_ai \r\n".$stHeader."\r\n").str_ireplace("'"," ",str_ireplace(","," ",$stVal));
                 
                    fwrite($myfile, $stCnt);
                    fclose($myfile);
               }
               
               
              
              
               $myfile_dir2 = "$createdir/LOG_USER_AI_TOT_".date('Ymd').".txt";
                $stHeader2 = "NO|Username|Total Call|Tot Data|Date";
                //echo $stCnt; 
                //file_put_contents($myfile, $stCnt,'FILE_APPEND');                        
               
               if(date('H:i') > '17:00'){
                    $myfile2 = fopen($myfile_dir2, "w") or die("Unable to open file!");
                    $row = 0;
                    if (($fp = fopen($myfile_dir2, "r")) !== FALSE) { 
                        while (($record = fgetcsv($fp)) !== FALSE) {
                            $row++;
                            }

                            //echo $row;
                            
                  }  
                
                   $stCnt2 = ($row > 0 ?"":"Total Data | $tot_data_ai \r\n".$stHeader2."\r\n").str_ireplace("'"," ",str_ireplace(","," ",$stVal2));
                 
                    fwrite($myfile2, $stCnt2);
                    fclose($myfile2);
               }
               
              
               
               
               
               

                //echo 'selesai';
                //exit;
        
        
                //echo json_encode($bucket);
    } 
    
    function get_totdata(){
        $db_ems = $this->load->database('ems', TRUE);             
               
               $qry = $db_ems->query("SELECT COUNT(*) AS tot_data
                                            FROM campains A1
                                            WHERE A1.telp !='' AND A1.company=0  AND A1.overdue < 8 AND DATE(tgl)=CURRENT_DATE()");
               $rslt = $qry->row();                                                                         
                $tot_data=0;         
                if($qry->num_rows() > 0)
                       $tot_data = $rslt->tot_data;
        $db_ems->close();
        
        return $tot_data;               
    }
}
?>