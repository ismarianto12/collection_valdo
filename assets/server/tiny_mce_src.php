<?php
set_error_handler('myHandler');

function myHandler($code, $msg, $file, $line) {
    //echo "error code was $code, and error was: $msg!, line  $line";
}

function fileext($filename) {
    return substr(strrchr($filename,'.'),1);
}
$ext = fileext($_FILES['Filedata']['name']);

function dir_rep($arr_dir=array(),$pat) {
	$ext = fileext($_FILES['Filedata']['name']);
    $fr_loc =  explode('/',$_SERVER['SCRIPT_NAME']);
    $correct_p = $_SERVER['DOCUMENT_ROOT'] . '/'.$fr_loc[1].'/assets/upload/'.$pat.'/';
	$pat_fla = array('/\/htdocs\//','/\.txt/');
	$rep_fla = array('/'.$correct_p.'/','/'.fileext($_FILES['Filedata']['name']) .'/');
	$repla_all = preg_replace($pat_fla, $rep_all, $arr_dir);
	//print_r($rep_fla);
	$sh = str_replace('/htdocs/',$correct_p,$arr_dir);
    return  $sh;
}


function query($sql, $querycount, $totaltime) {

    if (empty($querycount))
        $querycount=0;
        
    if (empty($totaltime))
        $totaltime=0;
        
    list($usec, $sec) = explode(' ',microtime());
    $querytime_before = ((float)$usec + (float)$sec);
    
    $result=mysql_query($sql);
    
    list($usec, $sec) = explode(' ',microtime());
    $querytime_after = ((float)$usec + (float)$sec);
    
    $querytime = $querytime_after - $querytime_before;
    
    $totaltime += $querytime;
    
    $querycount++;
    
    return array($result, $querycount, $totaltime);
}

function display_time($querycount, $totaltime) {

    $strQueryTime = 'Query took %01.4f seconds';
    echo '<p class="querytime">' . sprintf($strQueryTime, $totaltime) . ' with ' . $querycount . ' queries.</p>';
}

$ups = $_GET['ups'];
$exb = base64_decode($ups);
$exbs  = explode('&',$exb);
$ges_f = explode('-',$_GET['bad']);
$ur_ges =  $ges_f[1];
date_default_timezone_set('Asia/Jakarta');

$script_tz = date_default_timezone_get();


$link = mysql_connect('localhost', 'demogen_genseas', '02Mei2009');
//$link = mysql_connect('localhost', 'root', 'root');
mysql_select_db('demogen_avantpos');

$sql = "SELECT * FROM hdr_debtor_field_name  WHERE catagory_file ='$ur_ges'";

$res = mysql_query($sql, $link);
$row_data = mysql_fetch_object($res);
$ids = $row_data->id_file_field;
$name_c = $row_data->catagory_file;
$fieldname_s = $row_data->field_name;
$date_now = date('Y-m-d');
$date_time = date('j_n_Y');
$fileUpload = $date_time . '.' . $ext;
$fr_loc =  explode('/',$_SERVER['SCRIPT_NAME']);

function c_str_f($strp) {
    $lens = strlen($strp)-1;
    return $lens;
}
function c_str_s($strp) {
    $lens = strlen($strp);
    return $lens;
}

if ($ext == 'txt' || $ext == 'csv') {

    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/'.$fr_loc[1].'/assets/upload/'.$ur_ges.'/' . '/';
    $correct_p = $_SERVER['DOCUMENT_ROOT'] . '/'.$fr_loc[1].'/assets/upload/'.$ur_ges.'/';
    $newFileName = $fileUpload;
    $targetFile = str_replace('//', '/', $targetPath) . $newFileName;
    move_uploaded_file($tempFile, $targetFile);
    $fine = 'upload/'.$ur_ges.'/' . $_FILES['Filedata']['name'];
    $root = "http://" . $_SERVER['HTTP_HOST'];
	if($ext =='txt'){
		$real_file = $correct_p . $date_time . '.txt';
		if (file_exists($real_file)) {
			$fh = fopen($real_file, 'r');
			$contents = fread($fh, 5120); // 5KB
			fclose($fh);
			$fileLines = explode("\n", $contents);
			$fieldList = explode('|', $fileLines[0]);
			$first_field_f = $fileLines[0];
		} else {
			$first_field_f = '1';
		}
	} elseif($ext == 'csv'){
		 $real_file = $correct_p . $date_time . '.csv';
		if (file_exists($real_file)) {
			$fh = fopen($real_file, 'r');
			$contents = fread($fh, 5120); // 5KB
			fclose($fh);
			$fileLines = explode("\n", $contents);
			$fieldList = explode(',', $fileLines[0]);
			$first_field_f = $fileLines[0];
		} else {
			$first_field_f = '1';
		}
	}
    function c_ups() {
    
    }
    $l_s_field = c_str_s($fieldname_s);
    $l_f_field = c_str_f($first_field_f);
    function name_ex($param) {
		//echo $param;
        list($result2, $querycount, $totaltime)=query($param, $querycount, $totaltime);
        return  display_time($querycount, $totaltime);
    }
    function empty_deb() {
        $sql = "TRUNCATE TABLE hdr_debtor_main;";
        $query = mysql_query($sql);
        return $query;
    }
	function empty_filter_name(){
		$sql = "TRUNCATE TABLE hdr_filter_name;";
		$query = mysql_query($sql);
		return $query;
	}
    function empty_deb2() {
        $sql = "TRUNCATE TABLE hdr_tmp_log;";
        $query = mysql_query($sql);
        return $query;
    }
    function empty_res() {
        $sql = "TRUNCATE TABLE hdr_reschedule;";
        $query = mysql_query($sql);
        return $query;
    }
    function empty_act() {
        $sql = "TRUNCATE TABLE hdr_active_agency;";
        $query = mysql_query($sql);
        return $query;
    }
	 function empty_sta() {
        $sql = "TRUNCATE TABLE hdr_sta_rtf;";
        $query = mysql_query($sql);
        return $query;
    }
    function empty_folder($folder) {
        $d = dir($folder);
        while (false !== ($entry = $d->read())) {
            $isdir = is_dir($folder . "/" . $entry);
            if (!$isdir and $entry != "." and $entry != "..") {
                unlink($folder . "/" . $entry);
            }
            elseif ($isdir and $entry != "." and $entry != "..") {
                empty_folder($folder . "/" . $entry);
                rmdir($folder . "/" . $entry);
            }
        }
        $d->close();
    }
    $sucs = 'Success Upload '.str_replace('_',' ',strtoupper($ur_ges));
    if ($l_s_field == $l_f_field) {
        if ($ur_ges == 'master') {
            empty_deb();
            empty_deb2();
			empty_filter_name();
            name_ex(dir_rep($exbs[1],$ur_ges));
            name_ex(dir_rep($exbs[0],$ur_ges));
            $mystr = mysql_info();
            echo $mystr;
            empty_folder($correct_p);
            echo $sucs;
        }
        elseif($ur_ges == 'payment') {
            name_ex(dir_rep($exbs[2],$ur_ges));
            empty_folder($correct_p);
            echo $sucs;
        }
        elseif($ur_ges == 'call_track') {
            name_ex(dir_rep($exbs[3],$ur_ges));
			//echo $exbs[3];
            $mystr = mysql_info();
            echo $mystr;
            empty_folder($correct_p);
            echo $sucs;
        }
        elseif($ur_ges == 'monitor_agen') {
            name_ex(dir_rep($exbs[4],$ur_ges));
            empty_folder($correct_p);
            echo $sucs;
        }
        elseif($ur_ges == 'active_agency') {
            empty_act();
            name_ex(dir_rep($exbs[5],$ur_ges));
            empty_folder($correct_p);
            echo $sucs;
        }
        elseif($ur_ges == 'reschedule') {
            empty_res();
            name_ex(dir_rep($exbs[6],$ur_ges));
            echo $mystr;
            empty_folder($correct_p);
            echo $sucs;
        }
		elseif($ur_ges == 'sta') {
            empty_sta();
            name_ex(dir_rep($exbs[8],$ur_ges));
            echo $mystr;
            empty_folder($correct_p);
            echo $sucs;
        }
    } else {
        echo 'is not correct file';
    }
} else {
	 echo 'is not correct file';
}
?>