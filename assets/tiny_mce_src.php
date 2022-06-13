<?php
set_error_handler('myHandler');

function myHandler($code, $msg, $file, $line) {
    //echo "error code was $code, and error was: $msg!, line  $line";
}


switch ($_FILES['Filedata']['error'])
{     
     case 0:
             $msg = "No Error"; // comment this out if you don't want a message to appear on success.
             break;
     case 1:
              $msg = "The file is bigger than this PHP installation allows";
              break;
      case 2:
              $msg = "The file is bigger than this form allows";
              break;
       case 3:
              $msg = "Only part of the file was uploaded";
              break;
       case 4:
             $msg = "No file was uploaded";
              break;
       case 6:
             $msg = "Missing a temporary folder";
              break;
       case 7:
             $msg = "Failed to write file to disk";
             break;
       case 8:
             $msg = "File upload stopped by extension";
             break;
       default:
            $msg = "unknown error ".$_FILES['Filedata']['error'];
            break;
}

If ($msg)
    $stringData = "Error: ".$_FILES['Filedata']['error']." Error Info: ".$msg;
else
   $stringData = "1"; // This is required for onComplete to fire on Mac OSX
echo $stringData;

//die($_POST['types']);
function fileext($filename) {
    return substr(strrchr($filename, '.'), 1);
}

$ext = fileext($_FILES['Filedata']['name']);

function dir_rep($arr_dir=array(), $pat) {
    $ext = fileext($_FILES['Filedata']['name']);
    $fr_loc = explode('/', $_SERVER['SCRIPT_NAME']);
    $correct_p = $_SERVER['DOCUMENT_ROOT'] . '/' . $fr_loc[1] . '/assets/upload/' . $pat . '/';
    $pat_fla = array('/\/htdocs\//', '/\.txt/');
    $rep_fla = array('/' . $correct_p . '/', '/' . fileext($_FILES['Filedata']['name']) . '/');
    $repla_all = preg_replace($pat_fla, $rep_all, $arr_dir);
    //print_r($rep_fla);
    $sh = str_replace('/htdocs/', $correct_p, $arr_dir);
    return $sh;
}

function query($sql, $querycount, $totaltime) {
    if (empty($querycount))
        $querycount = 0;
    if (empty($totaltime))
        $totaltime = 0;
    list($usec, $sec) = explode(' ', microtime());
    $querytime_before = ((float) $usec + (float) $sec);
    $result = mysql_query($sql);
    list($usec, $sec) = explode(' ', microtime());
    $querytime_after = ((float) $usec + (float) $sec);
    $querytime = $querytime_after - $querytime_before;
    $totaltime += $querytime;
    $querycount++;
    return array($result, $querycount, $totaltime);
}

function display_time($querycount, $totaltime) {

    $strQueryTime = 'Query took %01.4f seconds';
    echo '<p class="querytime">' . sprintf($strQueryTime, $totaltime) . ' with ' . $querycount . ' queries.</p>';
}

$posting = $_POST['types'];
$ur_ges = $posting;
date_default_timezone_set('Asia/Jakarta');

$script_tz = date_default_timezone_get();


$link = mysql_connect('localhost', 'root', 'root');
//$link = mysql_connect('localhost', 'root', 'root');
mysql_select_db('womdc');

$sql = "SELECT * FROM hdr_debtor_field_name  WHERE catagory_file ='$ur_ges'";

$res = mysql_query($sql, $link);
$row_data = mysql_fetch_object($res);
$ids = $row_data->id_file_field;
$name_c = $row_data->catagory_file;
$fieldname_s = $row_data->field_name;
$date_now = date('Y-m-d');
$date_time = date('j_n_Y');
$fileUpload = $date_time . '.' . $ext;
$fr_loc = explode('/', $_SERVER['SCRIPT_NAME']);

function c_str_f($strp) {
    $lens = strlen($strp) - 1;
    return $lens;
}

function c_str_s($strp) {
    $lens = strlen($strp);
    return $lens;
}

if ($ext == 'txt' || $ext == 'TXT' || $ext == 'csv') {

    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $fr_loc[1] . '/assets/upload/' . $ur_ges . '/' . '/';
    $correct_p = $_SERVER['DOCUMENT_ROOT'] . '/' . $fr_loc[1] . '/assets/upload/' . $ur_ges . '/';
    $call_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $fr_loc[1] . '/call/';
    //echo $call_path;
    $newFileName = $fileUpload;
    $targetFile = str_replace('//', '/', $targetPath) . $newFileName;
    move_uploaded_file($tempFile, $targetFile);
    $fine = 'upload/' . $ur_ges . '/' . $_FILES['Filedata']['name'];
    $root = "http://" . $_SERVER['HTTP_HOST'];
    if ($ext == 'txt' || $ext == 'TXT') {
        $real_file = $correct_p . $date_time . '.' . $ext;
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
    } elseif ($ext == 'csv') {
        $real_file = $correct_p . $date_time . '.' . $ext;
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
    $l_s_field = c_str_s($fieldname_s);
    $l_f_field = c_str_f($first_field_f);

    function name_ex($param) {
        //echo $param;
        list($result2, $querycount, $totaltime) = query($param, $querycount, $totaltime);
        return display_time(@$querycount, @$totaltime);
    }

    function empty_table($table) {
        $sql = "TRUNCATE TABLE " . $table . ";";
        $query = mysql_query($sql);
        return $query;
    }

    function empty_folder($folder) {
        $d = dir($folder);
        while (false !== ($entry = $d->read())) {
            $isdir = is_dir($folder . "/" . $entry);
            if (!$isdir and $entry != "." and $entry != "..") {
                unlink($folder . "/" . $entry);
            } elseif ($isdir and $entry != "." and $entry != "..") {
                empty_folder($folder . "/" . $entry);
                rmdir($folder . "/" . $entry);
            }
        }
        $d->close();
    }

    $sucs = 'Success Upload ' . str_replace('_', ' ', strtoupper($ur_ges));
    echo 'SQL' . $l_s_field;
    echo 'FILE' . $l_f_field;
    $date_now = date('Y-m-d');

    if ($l_s_field <= $l_f_field + 5) {
        if ($ur_ges == 'master') {
            //empty_filter_name();
            empty_table($table = "hdr_debtor_main");
            empty_table($table = "hdr_tmp_log");
            empty_table($table = "hdr_set_shift");
            $exbsmaster = "LOAD DATA LOCAL INFILE '" . $real_file . "' INTO TABLE hdr_debtor_main  FIELDS TERMINATED BY '|' ESCAPED BY '\\\'  IGNORE 1 LINES (primary_1,name,@gender,@marital_status,@wo_status,sales_date,@dealer,@surveyor,@ang_bulan,od_due_date,old_due_no,@tenor,@od_amount,debt_amount,@os_penalty,home_address1,@area_desc,home_zip_code1,office_address1,office_zip_code1,@branch,@no_polisi,@brand,home_phone1,office_phone1,@emergency_phone,cell_phone1,@emergency_name,@emergency_relation,@field_name,@field_phone,@last_action_code,@last_action_date,@last_action_collector,@memo,ptp_date,ptp_amount,last_paid_date,last_paid_amount,@payment_via,@last_action_code2,@last_action_date2,@last_action_collector2,@memo2,@last_action_code3,@last_action_date3,@last_action_collector3,@memo3,kode_cabang,dpd) SET date_in ='$date_now' ";
            echo $exbsmaster;
            $exbsactioncode = "LOAD DATA LOCAL INFILE '" . $real_file . "' REPLACE  INTO TABLE hdr_action_code FIELDS TERMINATED BY '|' ESCAPED BY '\\\' LINES TERMINATED BY '\\r\\n'  IGNORE 1 LINES (primary_1,@nama_cust,@gender,@marital_status,@wo_status,@sales_date,@dealer,@surveyor,@ang_bulan,@od_due_date,@old_due_no,@tenor,@od_amount,@os_ar,@os_penalty,@address,@area_desc,@pos_code,@office_address,@office_post_code,@branch,@no_polisi,@brand,@phone_no,@office_phone,@emergency_phone,@hp,@emergency_name,@emergency_relation,@field_name,@field_phone,last_action_code,last_action_date,last_action_collector,memo,@ptp_date,@ptp_amount,@last_payment_date,@last_payment,@payment_via,@last_action_code2,@last_action_date2,@last_action_collector2,@memo2,@last_action_code3,@last_action_date3,@last_action_collector3,@memo3,@kode_cabang)";
            //echo $exbsactioncode;
            $exbspayment = "LOAD DATA LOCAL INFILE '" . $real_file . "' REPLACE INTO TABLE hdr_payment  FIELDS TERMINATED BY '|' ESCAPED BY '\\\'  IGNORE 1 LINES (primary_1,@nama_cust,@gender,@marital_status,@wo_status,@sales_date,@dealer,@surveyor,@ang_bulan,@od_due_date,@old_due_no,@tenor,@od_amount,@os_ar,@os_penalty,@address,@area_desc,@pos_code,@office_address,@office_post_code,@branch,@no_polisi,@brand,@phone_no,@office_phone,@emergency_phone,@hp,@emergency_name,@emergency_relation,@field_name,@field_phone,@last_action_code,@last_action_date,@last_action_collector,@memo,@ptp_date,@ptp_amount,trx_date,amount,description,@last_action_code2,@last_action_date2,@last_action_collector2,@memo2,@last_action_code3,@last_action_date3,@last_action_collector3,@memo3,@kode_cabang)";
            //echo $exbspayment;
            //echo $exbs[1];
            //$exbsfull ="LOAD DATA LOCAL INFILE '".$real_file."' INTO TABLE hdr_tmp_log IGNORE 1 LINES (VALUE) SET primary_1 = MID(VALUE,1,12);";
            $exbsfull = "LOAD DATA LOCAL INFILE '" . $real_file . "' INTO TABLE hdr_tmp_log IGNORE 1 LINES (VALUE) SET primary_1 = (VALUE), createdate = CURRENT_TIMESTAMP;";
            echo $exbsfull;
            $call_status = "UPDATE hdr_debtor_main hdm
			SET call_status = '1'
			WHERE dpd BETWEEN '1' AND '4'";
            /*
              old    AND hdm.dpd ='0' "; */
            $keep_promise = "UPDATE hdr_calltrack  hdc
				  INNER JOIN hdr_payment hp ON hp.primary_1 = hdc.primary_1
				  SET hdc.ptp_status = '2' 
				  WHERE  hp.trx_date <= hdc.ptp_date
				  AND hp.trx_date >= hdc.call_date   AND MONTH(hdc.call_date) <= MONTH(hp.trx_date)
				  AND  hdc.id_action_call_track = '28' ";
            /* UPDATE hdr_calltrack  hdc
              INNER JOIN  hdr_payment  hp
              ON hdc.primary_1 = hp.primary_1
              SET hdc.ptp_status = '1' , hdc.broken_date = DATE_ADD( hdc.ptp_date, INTERVAL 2 DAY )
              WHERE DATE_ADD( hdc.ptp_date, INTERVAL 2 DAY ) < '2010-07-05'  AND hp.trx_date > DATE_ADD( hdc.ptp_date, INTERVAL 1 DAY )  AND hdc.id_action_call_track = '28'

             */
            $broken_promise = " UPDATE hdr_calltrack  hdc
				  INNER JOIN hdr_debtor_main hdm  ON hdm.primary_1 = hdc.primary_1
INNER JOIN hdr_payment hp ON hp.primary_1 = hdc.primary_1
				  SET hdc.ptp_status = '1' ,hdc.broken_date = DATE_ADD( hdc.ptp_date, INTERVAL 2 DAY )
				  WHERE  hp.trx_date > DATE_ADD( hdc.ptp_date, INTERVAL 1 DAY ) 
				   AND hp.is_current ='1'
				  AND  hdc.id_action_call_track = '28'  AND hdm.dpd != '0'  AND hdc.ptp_status !='2' ";
            $broken_promise2 = "UPDATE hdr_calltrack  hdc
				  INNER JOIN  hdr_debtor_main  hdm
				  ON hdc.primary_1 = hdm.primary_1 
				  SET hdc.ptp_status = '1' , hdc.broken_date = DATE_ADD( hdc.ptp_date, INTERVAL 2 DAY )
				  WHERE DATE_ADD( hdc.ptp_date, INTERVAL 1 DAY ) < '" . $date_now . "'  AND hdm.dpd != '0' AND hdc.ptp_status ='0' ";
//            
            $set_call = "UPDATE hdr_debtor_main hdm
                                  INNER JOIN hdr_calltrack hdc
                                    ON hdm.primary_1 = hdc.primary_1
                                SET hdm.not_ptp = '1'
                                WHERE hdc.call_date = '" . $date_now . " ";
             $set_call2 = "UPDATE hdr_debtor_main hdm
                                  INNER JOIN hdr_calltrack hdc
                                    ON hdm.primary_1 = hdc.primary_1
                                SET hdm.not_ptp = '1'
                                WHERE hdc.ptp_date > '" . $date_now . "'; ";
            //echo $set_call;
            name_ex($exbsfull, $ur_ges);
            name_ex($exbsmaster, $ur_ges);
            name_ex($exbsactioncode, $ur_ges);
            name_ex($exbspayment, $ur_ges);
            //name_ex($update_zero_payment,$ur_ges);
            //name_ex($update_current_payment,$ur_ges);
            name_ex($call_status, $ur_ges);
            name_ex($keep_promise, $ur_ges);
            name_ex($broken_promise2, $ur_ges);
            name_ex($broken_promise, $ur_ges);
            name_ex($set_call, $ur_ges);
            name_ex($set_call2, $ur_ges);
            $mystr = mysql_info();
            echo $mystr;
            //empty_folder($correct_p);$call_path
            empty_folder($call_path);
            echo $sucs;
        } elseif ($ur_ges == 'payment') {
            name_ex(dir_rep($exbs[2], $ur_ges));
            empty_folder($correct_p);
            echo $sucs;
        } elseif ($ur_ges == 'call_track') {
            name_ex(dir_rep($exbs[3], $ur_ges));
            $mystr = mysql_info();
            echo $mystr;
            empty_folder($correct_p);
            echo $sucs;
        } elseif ($ur_ges == 'action_code') {
            $exbsactioncode2 = "LOAD DATA LOCAL INFILE '" . $real_file . "' INTO TABLE hdr_action_code   FIELDS TERMINATED BY '|' ESCAPED BY '\\\'   IGNORE 1 LINES (region_desc,primary_1,@cust_no,cust_name,@nik_head,nama_head,@nik_kolektor,nama_kolektor,jabatan,@sisa_piutang,@tunggakan,@risk_code,activity_date,action_name,action_desc,contact_desc,location_desc,@od_months)";
//region_desc,primary_1,cust_name,nama_head,nama_kolektor,jabatan,activity_date,action_name,action_desc,contact_desc,location_desc
// LOAD DATA LOCAL INFILE '/tmp/phpBbCa8R' INTO TABLE `hdr_action_code` FIELDS TERMINATED BY '|' LINES TERMINATED BY '\n'(
// `region_desc` , `primary_1` , `cust_name` , `nama_head` , `nama_kolektor` , `jabatan` , `activity_date` , `action_name` , `action_desc` , `contact_desc` , `location_desc`
// )
            echo $exbsactioncode2;
            name_ex(dir_rep($exbsactioncode2, $ur_ges));
//             empty_folder($correct_p);
            echo $sucs;
        } elseif ($ur_ges == 'active_agency') {
            empty_act();
            name_ex(dir_rep($exbs[5], $ur_ges));
            empty_folder($correct_p);
            echo $sucs;
        } elseif ($ur_ges == 'reschedule') {
            empty_res();
            name_ex(dir_rep($exbs[6], $ur_ges));
            echo $mystr;
            empty_folder($correct_p);
            echo $sucs;
        } elseif ($ur_ges == 'sta') {
            empty_sta();
            name_ex(dir_rep($exbs[8], $ur_ges));
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
