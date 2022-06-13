<?php

/*
  This script software package is NOT FREE And is Copyright 2010 (C) Valdo-intl all rights reserved.
  we do supply help or support or further modification to this script by Contact
  Haidar Mar'ie
  e-mail = haidar.m@valdo-intl.com
  e-mail = coder5@ymail.com
 */

class Hdr_upload_model extends Model {

    public function __construct() {
        parent::Model();
    }

    function debug_query($param) {
        //echo $param;
        $querycount = @$querycount;
        $totaltime = @$totaltime;
        list($result2, $querycount, $totaltime) = query($param, $querycount, $totaltime);
        return display_time($querycount, $totaltime);
    }

    public function uploader($json) {
        if (isset($_POST['types'])) {
            $posting = @$_POST['types'];
            //echo $posting;
            $ur_ges = $posting;
            date_default_timezone_set('Asia/Jakarta');

            $script_tz = date_default_timezone_get();
            $ext = $json->file_ext;
            $cms_name = $json->file_name;
            if ($ext == '.txt' || $ext == '.TXT' || $ext == '.csv' || $ext == '.CSV') {
                echo '<br/>';
                echo 'correct';
                echo '<br/>';
                //echo $this->get_field_name($posting);
                $tempFile = $_FILES['Filedata']['tmp_name'];
                $targetPath = $json->file_path;
                $correct_p = $json->file_path;
                $file_path = $json->file_path;
                $locate = explode('/', $_SERVER['SCRIPT_NAME']);
                $call_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $locate[1] . '/call/';
                //echo $call_path;
                $root = "http://" . $_SERVER['HTTP_HOST'];
                if ($ext == '.txt' || $ext == '.TXT' || $ext == '.csv' || $ext == '.CSV') {
                    if (file_exists($targetPath)) {
                        $fh = fopen($targetPath, 'r');
                        $contents = fread($fh, 5120); // 5KB
                        //$contents = fread($fh, filesize($tempFile)); // 5KB
                        fclose($fh);
                        $fileLines = explode("\n", $contents);
                        $fieldList = explode('|', $fileLines[0]);
                        $first_field_f = $fileLines[0];
                    } else {
                        $first_field_f = '1';
                    }
                } elseif ($ext == 'csv') {
                    if (file_exists($targetPath)) {
                        $fh = fopen($targetPath, 'r');
                        $contents = fread($fh, 5120); // 5KB
                        //$contents = fread($fh, filesize($tempFile)); // 5KB
                        fclose($fh);
                        $fileLines = explode("\n", $contents);
                        $fieldList = explode(',', $fileLines[0]);
                        $first_field_f = $fileLines[0];
                    } else {
                        $first_field_f = '1';
                    }
                }
                $l_s_field = c_str_s($this->get_field_name($posting));
                $l_f_field = c_str_s($first_field_f);

                ## debug header file ##
                 var_dump($l_s_field);
                 var_dump($l_f_field);
                 //die();
                #######################

                $sucs = 'Success Upload ' . str_replace('_', ' ', strtoupper($ur_ges));
                if ($l_s_field == $l_f_field) {
                	//var_dump($ur_ges);
                	//die();
                    if ($ur_ges == 'master') {
                        //empty_filter_name();
                        $this->empty_table($table = "hdr_debtor_main_temp");
                        $this->empty_table($table = "hdr_tmp_log_temp");
			$this->empty_table($table = "hdr_debtor_main");
                        $this->regular_upload($file_path);
                    } elseif ($ur_ges == 'payment') {
                      	//die($file_path);
                      	$this->payment_upload($file_path);
                        //$this->empty_folder($correct_p);
                        echo $sucs;
                    } elseif ($ur_ges == 'call_track') {
                        name_ex(dir_rep($exbs[3], $ur_ges));
                        $mystr = mysql_info();
                        echo $mystr;
                        $this->empty_folder($correct_p);
                        echo $sucs;
                    } elseif ($ur_ges == 'action_code') {
                        $exbsactioncode2 = "LOAD DATA LOCAL INFILE '" . $correct_p . "' INTO TABLE hdr_action_code   FIELDS TERMINATED BY '|' ESCAPED BY '\\\'   IGNORE 1 LINES (region_desc,primary_1,@cust_no,cust_name,@nik_head,nama_head,@nik_kolektor,nama_kolektor,jabatan,@sisa_piutang,@tunggakan,@risk_code,activity_date,action_name,action_desc,contact_desc,location_desc,@od_months)";
                        echo $exbsactioncode2;
                        $this->debug_query($exbsactioncode2, $ur_ges);

                        echo $sucs;
                    } elseif ($ur_ges == 'active_agency') {
                        empty_act();
                        name_ex(dir_rep($exbs[5], $ur_ges));
                        $this->empty_folder($correct_p);
                        echo $sucs;
                    } elseif ($ur_ges == 'reschedule') {
                        empty_res();
                        name_ex(dir_rep($exbs[6], $ur_ges));
                        echo $mystr;
                        $this->empty_folder($correct_p);
                        echo $sucs;
                    } elseif ($ur_ges == 'sta') {
                        empty_sta();
                        name_ex(dir_rep($exbs[8], $ur_ges));
                        echo $mystr;
                        $this->empty_folder($correct_p);
                        echo $sucs;
                    } elseif ($ur_ges == 'branch') {
                    		$this->branch_upload($file_path);
                    } elseif ($ur_ges == 'untouch') {
                      	//var_dump($ur_ges);die($ur_ges);
                      	$this->untouch_upload($file_path);
                        //$this->empty_folder($correct_p);
                        echo $sucs;
                    }
                } else {
                    echo 'File salah pastikan nama file ';
                }
            }
        }
    }

    function regular_upload($file_path) {
		$this->debug_query($this->upload_master_temp($file_path));
       $this->debug_query($this->upload_master_log_temp($file_path));
       //$this->debug_query($this->dpd_status());

				//die();
        $this->upload_master();
        $this->upload_log();
        $this->new_data_recognition();

        $sql = "UPDATE hdr_debtor_main
								SET
								skip = 1 WHERE
								(
									LENGTH(TRIM(LEADING '0' FROM cell_phone1)) < 5 AND
									LENGTH(TRIM(LEADING '0' FROM phone_1)) < 5 AND
									LENGTH(TRIM(LEADING '0' FROM phone_2)) < 5 AND
									LENGTH(TRIM(LEADING '0' FROM phone_3)) < 5 and
								LENGTH(TRIM(LEADING '0' FROM emergency_phone_no)) < 5
								
								)
								OR
								(

									cell_phone1 IS NULL AND
									phone_1 IS NULL AND
									phone_2 IS NULL AND
									phone_3 IS NULL and 
								emergency_phone_no is null
								)";
						$this->db->simple_query($sql);



        //$this->debug_query($this->call_status());
					//skip yg voice blaster
					/*
					$sql = "update `hdr_debtor_main` 
						set skip = 1
						WHERE (left ( kode_cabang, '2' ) = '02' or left ( kode_cabang, '2' ) = '04') and dpd='1'";
					$this->db->simple_query($sql);

					$sql = "update `hdr_debtor_main` 
						set skip = 1
						where dpd='-3'";
					$this->db->simple_query($sql);
					*/

					/*$sql = "update `hdr_debtor_main` 
						set skip = 1
						where dpd in (1,'-3','-2','0')and `object_group_code` not in('003')";
					$this->db->simple_query($sql);*/

					$sql = "update `hdr_debtor_main` 
						set skip = 1
						where dpd in ('1','-3','-2','0')";
					//$this->db->simple_query($sql);//dimatikan karena dilepas semua
					
					$sql = "update `hdr_debtor_main` 
						set skip = 0
						where dpd = '1' and object_group_code = '003'";
					//$this->db->simple_query($sql);
        
        $this->clearingDataSeq();
        $this->change();
        $this->releaseAll(); 
    }

    function reset_is_new() {
    	$sql = "UPDATE hdr_debtor_main SET is_new = 0";
    	$this->db->simple_query($sql);
    }

    /*Martin Add for Branch Data Injection */
    function branch_upload($file){
    	$DBsby = $this->load->database('sby',TRUE);

			//hdr_calltrack_sby
    	$sql = "LOAD DATA LOCAL INFILE '" . $file . "' INTO TABLE hdr_calltrack_sby
        FIELDS TERMINATED BY ';' ENCLOSED BY '\"' IGNORE 1 LINES
        (id_contact_code,id_ptp,id_location_code,id_risk_code,id_handling_debt,id_handling_code,deliquency_code,TYPE,ptp_status,primary_1,cname,debtor_name,spv_name,location_code,contact_code,risk_code,next_action_code,id_call_cat,id_action_call_track,code_call_track,id_user,id_spv,username,surveyor,angsuran_ke,remarks,no_contacted,new_phone_number,new_office_number,new_emergency_phone,new_hp,new_address,new_pos_code,memo,date_in,dpd,call_date,call_month,call_time,createdate,total_call_time,ptp_date,ptp_amount,due_date,due_time,call_attempt,incomming,is_current,in_use,sta,cycling,ptp_fu,fu,broken_date,os_ar_amount,kode_cabang,object_group,score_result)
        ";
			//die($sql);
        $DBsby->query($sql);
return $sql;
			//hdr_calltrack
    	$sql = "LOAD DATA LOCAL INFILE '" . $file . "' INTO TABLE hdr_calltrack
        FIELDS TERMINATED BY ';' ENCLOSED BY '\"' IGNORE 1 LINES
        (id_contact_code,id_ptp,id_location_code,id_risk_code,id_handling_debt,id_handling_code,deliquency_code,TYPE,ptp_status,primary_1,cname,debtor_name,spv_name,location_code,contact_code,risk_code,next_action_code,id_call_cat,id_action_call_track,code_call_track,id_user,id_spv,username,surveyor,angsuran_ke,remarks,no_contacted,new_phone_number,new_office_number,new_emergency_phone,new_hp,new_address,new_pos_code,memo,date_in,dpd,call_date,call_month,call_time,createdate,total_call_time,ptp_date,ptp_amount,due_date,due_time,call_attempt,incomming,is_current,in_use,sta,cycling,ptp_fu,fu,broken_date,os_ar_amount,kode_cabang,object_group,score_result)
        ";
	//die($sql);
        $DBsby->query($sql);

			//beda database
    	$sql = "LOAD DATA LOCAL INFILE '" . $file . "' INTO TABLE adira_collection_sby.hdr_calltrack
        FIELDS TERMINATED BY ';' ENCLOSED BY '\"' IGNORE 1 LINES
        (id_contact_code,id_ptp,id_location_code,id_risk_code,id_handling_debt,id_handling_code,deliquency_code,TYPE,ptp_status,primary_1,cname,debtor_name,spv_name,location_code,contact_code,risk_code,next_action_code,id_call_cat,id_action_call_track,code_call_track,id_user,id_spv,username,surveyor,angsuran_ke,remarks,no_contacted,new_phone_number,new_office_number,new_emergency_phone,new_hp,new_address,new_pos_code,memo,date_in,dpd,call_date,call_month,call_time,createdate,total_call_time,ptp_date,ptp_amount,due_date,due_time,call_attempt,incomming,is_current,in_use,sta,cycling,ptp_fu,fu,broken_date,os_ar_amount,kode_cabang,object_group,score_result)
        ";
	//die($sql);
        $DBsby->query($sql);



			## Updating PTP_DATE from 0000-00-00 to NULL ##
			$sql_update = "UPDATE hdr_calltrack SET ptp_date = null WHERE ptp_date = '0000-00-00'";
			$DBsby->query($sql_update);
    }

    function new_data_recognition() {
    	## reset status isnew to default
    	$this->reset_is_new();

    	## Optimizing debtor_main
       $sql = "OPTIMIZE TABLE hdr_debtor_main";
       $this->db->simple_query($sql);
	   
	   $sql = "update hdr_debtor_main set last_handling_date = '0000-00-00' where last_handling_date is not null";
	   $this->db->simple_query($sql);
	   //LAST HANDLING DATE
		$min = date("Y-01-01");
		$max = date("Y-m-d");
		$sql = "UPDATE hdr_debtor_main a, 
				(SELECT primary_1, call_date
				FROM `hdr_calltrack`
				WHERE call_date
				BETWEEN '$min'
				AND '$max'
				ORDER BY call_date DESC , call_time DESC) b SET a.last_handling_date = b.call_date WHERE a.primary_1 = b.primary_1";
		$this->db->simple_query($sql);

    	## recognize new data step 1
    		/*$sql = "UPDATE hdr_debtor_main
          	  SET is_new = 1
          		WHERE primary_1 NOT IN (
					  		SELECT primary_1 FROM account_used_bag
					  	)";*/
				//patch 31 mei 2016
				$min = date("Y-m-d");
				$tgl = strtotime($min);
				$d = date("d", $tgl);
				$m = date("m", $tgl);
				$y = date("Y", $tgl);
				$max = date("Y-m-d",mktime(0,0,0,date($m),date($d)-2,date($y)));
				$min = date("Y-m-d",mktime(0,0,0,date($m),date($d)-1,date($y)));
				$sql = "UPDATE hdr_debtor_main set is_new = 1 
				WHERE dpd < 1 OR (last_handling_date = '0000-00-00' OR (last_handling_date BETWEEN '2000-01-01' AND '$max'))"; 
       $this->db->simple_query($sql);

       ## Optimizing debtor_main step 2
       $sql = "OPTIMIZE TABLE hdr_debtor_main";
       $this->db->simple_query($sql);


       //$bdate = date("Y-m-01");

       ## recognize clean retouch data
       /*$sql = "UPDATE hdr_debtor_main
          		SET is_new = 2
          		WHERE primary_1 IN (
									SELECT primary_1 FROM retouch_bag
							)";*/
				//$min = date("Y-m-01");
				$max = date("Y-m-d");
				$sql = "UPDATE hdr_debtor_main SET is_new = 2
				WHERE dpd > 0 AND last_handling_date BETWEEN '$min' AND '$max'";
				$this->db->simple_query($sql);
				unset($sql);
    }

     function payment_upload($file_path) {
     		$sql = "LOAD DATA LOCAL INFILE '" . $file_path . "' REPLACE INTO TABLE hdr_payment
            		FIELDS TERMINATED BY '|' ESCAPED BY '\\\'  IGNORE 1 LINES (kode_cabang,branch,primary_1,name,angsuran_ke,dpd,amount_pay,amount_ins,amount_due,trx_date,trx_time,entry_date,source,valdo_cc,fin_type)";
       	//die($sql);
       	$query = $this->db->query($sql);

				$sql_update = "UPDATE hdr_debtor_main a LEFT JOIN hdr_payment	b ON a.primary_1 = b.primary_1 AND a.angsuran_ke = b.angsuran_ke SET a.is_paid = 1 WHERE b.angsuran_ke IS NOT NULL ";
				$this->db->simple_query($sql_update);
    }

		function pump_data()
		{
      $this->debug_query($this->dpd_status());
      $this->upload_master();
      $this->upload_log();
		}

    function dpd_status(){
    	$sql = "update hdr_debtor_main_temp set dpd = datediff(now(),due_date) where due_date is not null and due_date <> '0000-00-00'";
			return $sql;
    }

    function call_status() {
        $call_status = "UPDATE hdr_debtor_main hdm
                                    SET call_status = '1'
                                    ";
        return $call_status;
    }

    function keep_promise() {
        $keep_promise = "UPDATE hdr_calltrack  hdc
                                          INNER JOIN hdr_payment hp ON hp.primary_1 = hdc.primary_1
                                          SET hdc.ptp_status = '2'
                                          WHERE  hp.trx_date <= hdc.ptp_date
                                          AND hp.trx_date >= hdc.call_date   AND MONTH(hdc.call_date) <= MONTH(hp.trx_date)
                                          AND  hdc.id_action_call_track = '28' ";
        return $keep_promise;
    }

    function broken_promise() {
        $broken_promise = " UPDATE hdr_calltrack  hdc
                                              INNER JOIN hdr_debtor_main hdm  ON hdm.primary_1 = hdc.primary_1
                                              INNER JOIN hdr_payment hp ON hp.primary_1 = hdc.primary_1
                                              SET hdc.ptp_status = '1' ,hdc.broken_date = DATE_ADD( hdc.ptp_date, INTERVAL 2 DAY )
                                              WHERE  hp.trx_date > DATE_ADD( hdc.ptp_date, INTERVAL 1 DAY )
                                               AND hp.is_current ='1'
                                              AND  hdc.id_action_call_track = '28'  AND hdm.dpd != '0'  AND hdc.ptp_status !='2' ";
        return $broken_promise;
    }

    function broken_promise2() {
        $broken_promise2 = "UPDATE hdr_calltrack  hdc
                                                  INNER JOIN  hdr_debtor_main  hdm
                                                  ON hdc.primary_1 = hdm.primary_1
                                                  SET hdc.ptp_status = '1' , hdc.broken_date = DATE_ADD( hdc.ptp_date, INTERVAL 2 DAY )
                                                  WHERE DATE_ADD( hdc.ptp_date, INTERVAL 1 DAY ) < '" . date_now() . "'  AND hdm.dpd != '0' AND hdc.ptp_status ='0' ";
        return $broken_promise2;
    }

    function set_call() {
        $set_call = "UPDATE hdr_debtor_main hdm
                              INNER JOIN hdr_calltrack hdc ON hdm.primary_1 = hdc.primary_1
                              SET hdm.not_ptp = '1'
                              WHERE hdc.call_date = '" . date_now() . "' AND hdc.ptp_date >= '" . date_now() . "' AND hdc.id_action_call_track ='28'; ";

        return $set_call;
    }

    function set_call2() {
        $set_call2 = "UPDATE hdr_debtor_main hdm
                                INNER JOIN hdr_calltrack hdc ON hdm.primary_1 = hdc.primary_1
                                SET hdm.not_ptp = '1'
                                WHERE hdc.ptp_date >= '" . date_now() . "' AND hdc.id_action_call_track ='28'; ";
        return $set_call2;
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

    function check_upload_date() {
        $sql = "SELECT date_in FROM hdr_debtor_main LIMIT 1 ";
        $query = $this->db->query($sql);
        $data = $query->row();
        if ($query->num_rows() > 0) {
            $date_in = $data->date_in;
        } else {
            $date_in = '0000-00-00';
        }
        return $date_in;
    }

    function empty_table($table) {
        $sql = "TRUNCATE " . $table . " ;";
        $query = $this->db->query($sql);
        return $query;
    }

    function upload_master_temp($file) {
        $sql = "LOAD DATA LOCAL INFILE '" . $file . "' INTO TABLE hdr_debtor_main_temp
        FIELDS TERMINATED BY '|' ESCAPED BY '\\\' IGNORE 1 LINES
        (`kode_cabang`,`branch`,`primary_1`,`name`,`angsuran_ke`,`tenor`,`DPD`,`debt_amount`,`amount_due`,`os_ar`,`police_no`,`phone_1`,`phone_2`,`phone_3`,`cell_phone1`,`region`,`product`,`due_date`,`last_handling_date`,`last_remark`,`last_ptp_date`,`last_action`,`last_result`,`object_group_code`,`valdo_cc`,`fin_type`,product_flag, bucket_coll, emergency_contact_name, emergency_phone_no, nama_penjamin,no_telp_penjamin,alamat_nasabah,alamat_kantor,`score_result`)
        SET date_in ='" . date_now() . "' ";
        //die($sql);

				return $sql;

    }

		function upload_master()
		{

			//update master
			$sql = "replace into hdr_debtor_main
			(`kode_cabang`,`branch`,`primary_1`,`name`,`angsuran_ke`,`tenor`,`DPD`,`debt_amount`,`amount_due`,`os_ar`,`police_no`,`phone_1`,`phone_2`,`phone_3`,`cell_phone1`,`region`,`product`,`due_date`,`last_handling_date`,`last_remark`,`last_ptp_date`,`last_action`,`last_result`,`object_group_code`,`valdo_cc`,`fin_type`,product_flag, bucket_coll, emergency_contact_name, emergency_phone_no, nama_penjamin,no_telp_penjamin,alamat_nasabah,alamat_kantor,score_result)
			select `kode_cabang`,`branch`,`primary_1`,`name`,`angsuran_ke`,`tenor`,`DPD`,`debt_amount`,`amount_due`,`os_ar`,`police_no`,`phone_1`,`phone_2`,`phone_3`,`cell_phone1`,`region`,`product`,`due_date`,`last_handling_date`,`last_remark`,`last_ptp_date`,`last_action`,`last_result`,`object_group_code`,`valdo_cc`,`fin_type`,product_flag, bucket_coll, emergency_contact_name, emergency_phone_no, nama_penjamin,no_telp_penjamin,alamat_nasabah,alamat_kantor,score_result
			from hdr_debtor_main_temp ";

			$this->db->query($sql);
			$bag['replaced'] = $this->db->affected_rows();

			$this->lockAll();
			//skip
			$sql = "update `hdr_debtor_main` set skip=1 WHERE `primary_1`in(012618202458,010317202835)";
			$this->db->simple_query($sql);

			//clearing inventory to prevent multiple upload data
			$sql = "delete from hdr_debtor_main_inventory WHERE data_date = DATE(NOW())";
			//$this->db->simple_query($sql);

			//update inventory
			$sql = "insert into hdr_debtor_main_inventory
			(`kode_cabang`,`branch`,`primary_1`,`name`,`angsuran_ke`,`tenor`,`DPD`,`debt_amount`,`amount_due`,`os_ar`,`police_no`,`phone_1`,`phone_2`,`phone_3`,`cell_phone1`,`region`,`product`,`due_date`,`last_handling_date`,`last_remark`,`last_ptp_date`,`last_action`,`last_result`,`object_group_code`,`valdo_cc`,`data_date`,`fin_type`,product_flag, bucket_coll, emergency_contact_name, emergency_phone_no, nama_penjamin,no_telp_penjamin,alamat_nasabah,alamat_kantor,score_result)
			select `kode_cabang`,`branch`,`primary_1`,`name`,`angsuran_ke`,`tenor`,`DPD`,`debt_amount`,`amount_due`,`os_ar`,`police_no`,`phone_1`,`phone_2`,`phone_3`,`cell_phone1`,`region`,`product`,`due_date`,`last_handling_date`,`last_remark`,`last_ptp_date`,`last_action`,`last_result`,`object_group_code`,`valdo_cc`,DATE_FORMAT(`createdate`,'%Y-%m-%d'),`fin_type`,product_flag, bucket_coll, emergency_contact_name, emergency_phone_no, nama_penjamin,no_telp_penjamin,alamat_nasabah,alamat_kantor,score_result
			from hdr_debtor_main_temp ";

			//$this->db->query($sql);

			//insert into
			/*$sql = "insert ignore into hdr_debtor_main
(`primary_1`,`due_date`,`angsuran_ke`,`region`,`dpd`,`bucket`,`ovd`,`paid`,`in_use`,`id_user`,`branch`,`shift`,`is_reminder`,`call_status`,`not_ptp`,`called`,`skip`,`name`,`cycle`,`debt_amount`,`sales_date`,`credit_limit`,`balance`,`amount_due`,`ptp_date`,`ptp_amount`,`last_paid_date`,`last_paid_amount`,`last_trx_date`,`home_address1`,`city`,`home_zip_code1`,`email`,`area`,`company_name`,`office_address1`,`office_zip_code1`,`home_address2`,`billing_address`,`brand`,`cell_phone1`,`home_phone1`,`office_phone1`,`home_phone2`,`cell_phone2`,`office_phone2`,`dob`,`id_card`,`date_in`,`createdate`,`kode_cabang`,`product`,`category`)
select `primary_1`,`due_date`,`angsuran_ke`,`region`,`dpd`,`bucket`,`ovd`,`paid`,`in_use`,`id_user`,`branch`,`shift`,`is_reminder`,`call_status`,`not_ptp`,`called`,`skip`,`name`,`cycle`,`debt_amount`,`sales_date`,`credit_limit`,`balance`,`amount_due`,`ptp_date`,`ptp_amount`,`last_paid_date`,`last_paid_amount`,`last_trx_date`,`home_address1`,`city`,`home_zip_code1`,`email`,`area`,`company_name`,`office_address1`,`office_zip_code1`,`home_address2`,`billing_address`,`brand`,`cell_phone1`,`home_phone1`,`office_phone1`,`home_phone2`,`cell_phone2`,`office_phone2`,`dob`,`id_card`,`date_in`,`createdate`,`kode_cabang`,`product`,`category`
from hdr_debtor_main_temp ";
			$this->db->query($sql);
			$bag['added'] = $this->db->affected_rows();
			*/

/*
			//update
			$sql = "replace into hdr_debtor_main
(`primary_1`,`due_date`,`angsuran_ke`,`region`,`dpd`,`bucket`,`ovd`,`paid`,`in_use`,`id_user`,`branch`,`shift`,`is_reminder`,`call_status`,`not_ptp`,`called`,`skip`,`name`,`cycle`,`debt_amount`,`sales_date`,`credit_limit`,`balance`,`amount_due`,`ptp_date`,`ptp_amount`,`last_paid_date`,`last_paid_amount`,`last_trx_date`,`home_address1`,`city`,`home_zip_code1`,`email`,`area`,`company_name`,`office_address1`,`office_zip_code1`,`home_address2`,`billing_address`,`brand`,`cell_phone1`,`home_phone1`,`office_phone1`,`home_phone2`,`cell_phone2`,`office_phone2`,`dob`,`id_card`,`date_in`,`createdate`,`kode_cabang`,`product`,`category`)
select `primary_1`,`due_date`,`angsuran_ke`,`region`,`dpd`,`bucket`,`ovd`,`paid`,`in_use`,`id_user`,`branch`,`shift`,`is_reminder`,`call_status`,`not_ptp`,`called`,`skip`,`name`,`cycle`,`debt_amount`,`sales_date`,`credit_limit`,`balance`,`amount_due`,`ptp_date`,`ptp_amount`,`last_paid_date`,`last_paid_amount`,`last_trx_date`,`home_address1`,`city`,`home_zip_code1`,`email`,`area`,`company_name`,`office_address1`,`office_zip_code1`,`home_address2`,`billing_address`,`brand`,`cell_phone1`,`home_phone1`,`office_phone1`,`home_phone2`,`cell_phone2`,`office_phone2`,`dob`,`id_card`,`date_in`,`createdate`,`kode_cabang`,`product`,`category`
from hdr_debtor_main_temp ";

			$this->db->query($sql);

			//insert into
			$sql = "insert ignore into hdr_debtor_main
(`primary_1`,`due_date`,`angsuran_ke`,`region`,`dpd`,`bucket`,`ovd`,`paid`,`in_use`,`id_user`,`branch`,`shift`,`is_reminder`,`call_status`,`not_ptp`,`called`,`skip`,`name`,`cycle`,`debt_amount`,`sales_date`,`credit_limit`,`balance`,`amount_due`,`ptp_date`,`ptp_amount`,`last_paid_date`,`last_paid_amount`,`last_trx_date`,`home_address1`,`city`,`home_zip_code1`,`email`,`area`,`company_name`,`office_address1`,`office_zip_code1`,`home_address2`,`billing_address`,`brand`,`cell_phone1`,`home_phone1`,`office_phone1`,`home_phone2`,`cell_phone2`,`office_phone2`,`dob`,`id_card`,`date_in`,`createdate`,`kode_cabang`,`product`,`category`)
select `primary_1`,`due_date`,`angsuran_ke`,`region`,`dpd`,`bucket`,`ovd`,`paid`,`in_use`,`id_user`,`branch`,`shift`,`is_reminder`,`call_status`,`not_ptp`,`called`,`skip`,`name`,`cycle`,`debt_amount`,`sales_date`,`credit_limit`,`balance`,`amount_due`,`ptp_date`,`ptp_amount`,`last_paid_date`,`last_paid_amount`,`last_trx_date`,`home_address1`,`city`,`home_zip_code1`,`email`,`area`,`company_name`,`office_address1`,`office_zip_code1`,`home_address2`,`billing_address`,`brand`,`cell_phone1`,`home_phone1`,`office_phone1`,`home_phone2`,`cell_phone2`,`office_phone2`,`dob`,`id_card`,`date_in`,`createdate`,`kode_cabang`,`product`,`category`
from hdr_debtor_main_temp ";

			$this->db->query($sql);
*/

		//Gunawan, selain senin
		$sql="update hdr_calltrack a, hdr_debtor_main s 
			set a.ptp_status='1'
			WHERE a.`primary_1` = s.`primary_1` 
			AND a.call_date = DATE_ADD(curdate(), INTERVAL -1 DAY) 
			AND s.dpd =  '8'
			AND a.ptp_date>=curdate()";
		$this->db->query($sql);

		//khusus senin
		$sql="update `hdr_calltrack` a, hdr_debtor_main s 
			set a.ptp_status='1'
			WHERE a.`primary_1` = s.`primary_1` 
			AND a.call_date = DATE_ADD(curdate(), INTERVAL -2 DAY) 
			AND s.dpd =  '8'
			AND a.ptp_date>=curdate() 
			and DAYNAME(curdate()) = 'Monday' ";
		$this->db->query($sql);

		}


    function upload_master_log_temp($file) {
        $sql = "LOAD DATA LOCAL INFILE '" . $file . "' INTO TABLE hdr_tmp_log_temp
            IGNORE 1 LINES (VALUE) SET primary_1 = SUBSTRING_INDEX(SUBSTRING_INDEX(VALUE,'|',3),'|',-1), createdate = CURRENT_TIMESTAMP;";
        //die($sql);
        return $sql;
    }

		function upload_log()
		{
			$sql = "replace into hdr_tmp_log
(`primary_1`,`value`,`is_reminder`,`createdate`,`id_upload`)
select `primary_1`,`value`,`is_reminder`,`createdate`,`id_upload` from hdr_tmp_log_temp";

			$this->db->query($sql);

			$sql = "delete from hdr_tmp_log where `primary_1`='012616202191'";
			$this->db->query($sql);

			$sql = "insert ignore into hdr_tmp_log
(`primary_1`,`value`,`is_reminder`,`createdate`,`id_upload`)
select `primary_1`,`value`,`is_reminder`,`createdate`,`id_upload` from hdr_tmp_log_temp";

			$this->db->query($sql);

		}

    function upload_payment($file) {
        $sql = "LOAD DATA LOCAL INFILE '" . $file . "' REPLACE INTO TABLE hdr_payment
            FIELDS TERMINATED BY '|' ESCAPED BY '\\\'  IGNORE 1 LINES (primary_1,@nama_cust,@gender,@marital_status,@wo_status,@sales_date,@dealer,@surveyor,@ang_bulan,@od_due_date,@old_due_no,@tenor,@od_amount,@os_ar,@os_penalty,@address,@area_desc,@pos_code,@office_address,@office_post_code,@branch,@no_polisi,@brand,@phone_no,@office_phone,@emergency_phone,@hp,@emergency_name,@emergency_relation,@field_name,@field_phone,@last_action_code,@last_action_date,@last_action_collector,@memo,@ptp_date,@ptp_amount,trx_date,amount,description,@last_action_code2,@last_action_date2,@last_action_collector2,@memo2,@last_action_code3,@last_action_date3,@last_action_collector3,@memo3,@kode_cabang,valdo_cc)";
        $query = $this->db->query($sql);
        return $query;
    }

    function upload_action_code($file) {
        $sql = "LOAD DATA LOCAL INFILE '" . $file . "' REPLACE  INTO TABLE hdr_action_code
            FIELDS TERMINATED BY '|' ESCAPED BY '\\\' LINES TERMINATED BY '\\r\\n'  IGNORE 1 LINES (primary_1,@nama_cust,@gender,@marital_status,@wo_status,@sales_date,@dealer,@surveyor,@ang_bulan,@od_due_date,@old_due_no,@tenor,@od_amount,@os_ar,@os_penalty,@address,@area_desc,@pos_code,@office_address,@office_post_code,@branch,@no_polisi,@brand,@phone_no,@office_phone,@emergency_phone,@hp,@emergency_name,@emergency_relation,@field_name,@field_phone,last_action_code,last_action_date,last_action_collector,memo,@ptp_date,@ptp_amount,@last_payment_date,@last_payment,@payment_via,@last_action_code2,@last_action_date2,@last_action_collector2,@memo2,@last_action_code3,@last_action_date3,@last_action_collector3,@memo3,@kode_cabang)";
        $query = $this->db->query($sql);
        return $query;
    }

    function set_call_status() {
        $sql = "UPDATE hdr_debtor_main hdm
			SET call_status = '1'
			WHERE dpd BETWEEN '1' AND '4'";
        $query = $this->db->query($sql);
        return $query;
    }

    function set_keep_promise() {
        $sql = "UPDATE hdr_calltrack  hdc
				  INNER JOIN hdr_payment hp ON hp.primary_1 = hdc.primary_1
				  SET hdc.ptp_status = '2'
				  WHERE  hp.trx_date <= hdc.ptp_date
				  AND hp.trx_date >= hdc.call_date   AND MONTH(hdc.call_date) <= MONTH(hp.trx_date)
        			  AND  hdc.id_action_call_track = '28' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function set_broken_promise() {
        $sql = " UPDATE hdr_calltrack  hdc
				  INNER JOIN hdr_debtor_main hdm  ON hdm.primary_1 = hdc.primary_1
INNER JOIN hdr_payment hp ON hp.primary_1 = hdc.primary_1
				  SET hdc.ptp_status = '1' ,hdc.broken_date = DATE_ADD( hdc.ptp_date, INTERVAL 2 DAY )
				  WHERE  hp.trx_date > DATE_ADD( hdc.ptp_date, INTERVAL 1 DAY )
				   AND hp.is_current ='1'
				  AND  hdc.id_action_call_track = '28'  AND hdm.dpd != '0'  AND hdc.ptp_status !='2' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function set_broken_promise2() {
        $sql = " UPDATE hdr_calltrack  hdc
				  INNER JOIN  hdr_debtor_main  hdm
				  ON hdc.primary_1 = hdm.primary_1
				  SET hdc.ptp_status = '1' , hdc.broken_date = DATE_ADD( hdc.ptp_date, INTERVAL 2 DAY )
				  WHERE DATE_ADD( hdc.ptp_date, INTERVAL 1 DAY ) < '" . date_now() . "'  AND hdm.dpd != '0' AND hdc.ptp_status ='0'  ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_field_name($cat) {
        $sql = $this->db->get_where('hdr_debtor_field_name', array('catagory_file' => $cat));
        $query = $sql->row();
        $fieldname_s = $query->field_name;
        #$name_c = $fieldname_s->catagory_file;
        return $fieldname_s;
    }

    function c_str_f($strp) {
        $lens = strlen($strp) - 1;
        return $lens;
    }

    function c_str_s($strp) {
        $lens = strlen($strp);
        return $lens;
    }

    function lockAll(){
    	$sql = "UPDATE hdr_debtor_main SET in_use = 1;";
    	$this->db->simple_query($sql);
    }

    function releaseAll(){
    	$sql = "UPDATE hdr_debtor_main SET in_use = 0;";
    	$this->db->simple_query($sql);
    }

    function clearingDataSeq(){
    	$sql = "TRUNCATE TABLE data_sequence_log";
    	$this->db->simple_query($sql);
    }

    function change(){
    	$sql = "update hdr_debtor_main set valdo_cc = '01' where valdo_cc = '02' and object_group_code='003'";
    	$this->db->simple_query($sql);
    }
    
     function untouch_upload($file_path) {//var_dump($file_path);die('d');

    	$sql = "TRUNCATE TABLE tes1";
    	$this->db->simple_query($sql);
//return $sql;
     		$sql = "LOAD DATA LOCAL INFILE '" . $file_path . "' REPLACE INTO TABLE tes1
            		FIELDS TERMINATED BY ',' ESCAPED BY '\\\'  IGNORE 1 LINES (primary_1,id_user,used_by)";
       	
       	$this->db->query($sql);
				return $sql;
				
				$sql = "update tes1 set `primary_1`= concat('0',`primary_1`) WHERE left(`primary_1`,1)!='0'";
				$query = $this->db->query($sql);
				
				$sql_update = "update hdr_debtor_main set called=1 WHERE dpd between '1' and '7' and object_group_code in(001,002)"; 
				$this->db->query($sql_update);

				$sql = "update hdr_debtor_main set called='0' WHERE dpd ='7' and object_group_code in(001,002) and score_result = 'HIGH'";
				$query = $this->db->query($sql);

				$sql = "update hdr_debtor_main a, tes1 s set called='0' WHERE a.primary_1=s.primary_1 and dpd between'1' and '7' and object_group_code in(001,002) ";
				$query = $this->db->query($sql);
			
				//$sql_update = "insert into `tes11` select * from tes1 ";
				//$this->db->query($sql_update);
			 }


}
?>
