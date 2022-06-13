<?php

/*
  This script software package is NOT FREE And is Copyright 2010 (C) Valdo-intl all rights reserved.
  we do supply help or support or further modification to this script by Contact
  Haidar Mar'ie
  e-mail = haidar.m@valdo-intl.com
  e-mail = coder5@ymail.com
 */

class Hdr_call_track_model extends Model {

    private $hdr_debtor_main;
    private $hdr_debtor_field_name;
    private $hdr_payment;
    private $hdr_calltrack;
    private $hdr_action_call_track;
    private $hdr_reschedule;
    private $hdr_agen_monitor;

    public function __construct() {
        parent::Model();
        $this->CI = & get_instance();
        $this->hdr_debtor_main = 'hdr_debtor_main';
        $this->hdr_payment = 'hdr_payment';
        $this->hdr_calltrack = 'hdr_calltrack';
        $this->hdr_action_call_track = 'hdr_action_call_track';
        $this->hdr_debtor_details = 'hdr_tmp_log';
        $this->hdr_debtor_field_name = 'hdr_debtor_field_name';
        $this->hdr_reschedule = 'hdr_reschedule';
        $this->hdr_agen_monitor = 'hdr_agen_monitor';
    }

    public function action_call_track($ptp_status) {
        $not_ptp = $ptp_status == 1 ? "WHERE id_action_call_track !='28' " : "";
        $sql = "SELECT * FROM hdr_action_call_track $not_ptp ORDER BY sequence,id_call_cat,code_call_track";
        $query = $this->db->query($sql);
        return $query;
    }

    public function find_session() {

    		/*
    		//patch martin untuk pembayaran
				$sql2 = "UPDATE hdr_debtor_main hdm, hdr_payment hdp
					SET hdm.is_paid=1
					WHERE hdm.primary_1=hdp.primary_1
					AND hdp.trx_date = (SELECT MAX(trx_date) FROM hdr_payment hdp2 WHERE hdp2.primary_1 = hdm.primary_1)
					AND MONTH(hdp.trx_date) = MONTH(NOW())
					AND YEAR(hdp.trx_date)   = YEAR(NOW())
					AND (hdm.is_paid=0 OR hdm.is_paid IS NULL)";
				$this->db->simple_query($sql2);
    	*/

        $dpd_minus_array = array(0 => 0, 1 => -1, 2 => -2, 3 => -3);
        if ($this->dpd_sql($dpd_minus_array[0])) {
            $_SESSION['finansia_dpd'] = $dpd_minus_array[0];
            //die();
            return $_SESSION['finansia_dpd'];
           	//die();
        } else {
            if ($this->dpd_sql($dpd_minus_array[0])) {
                $_SESSION['finansia_dpd'] = $dpd_minus_array[0];
            } elseif ($this->dpd_sql($dpd_minus_array[1]) > 0) {
                $_SESSION['finansia_dpd'] = $dpd_minus_array[1];
            } elseif ($this->dpd_sql($dpd_minus_array[2]) > 0) {
                $_SESSION['finansia_dpd'] = $dpd_minus_array[2];
            } elseif ($this->dpd_sql($dpd_minus_array[3]) > 0) {
                $_SESSION['finansia_dpd'] = $dpd_minus_array[3];
            }
            //echo $_SESSION['finansia_dpd'];
            //die();
            return $_SESSION['finansia_dpd'];
        }
    }

    public function dpd_sql($dpd) {

    		$id = $_SESSION['bid_user_s'];
        $get_due_date = get_dpd_date($dpd);
        //echo $get_due_date;

        //die();

        $due_date = $dpd != 'all' ? 'AND due_date ="' . $get_due_date . '"' : '';
        //echo $dpd;
        //die();
        $sql = "SELECT due_date FROM hdr_debtor_main WHERE
                    in_use = '0'
                    AND not_ptp ='0'
                    AND (id_user = '0' or id_user = $id)
                    AND called = '0'
                    " . $due_date . "
                     LIMIT 1 ";
        //echo($due_date);
        $query = $this->db->query($sql);
				//$num_rows = 0;
				//$a = $this->db->last_query();
				//die($a);
				//if($query)
        	$num_rows = $query->num_rows();
        	//echo $num_rows ;
        	//die();

        //die('s'.$num_rows);
        return $num_rows;
    }

    public function get_dpds($dpd) {
    	//die("dpd");
        $get_due_date = get_dpd_date($dpd);
        $id_user = $_SESSION['bid_user_s'];
        //die($id_user);
        $get_last = "";


				/*
        $sql = "SET @update_id = 0;
                    UPDATE hdr_debtor_main SET in_use = '1',
                    id_user = ' $id_user',
                    primary_1 = ( SELECT @update_id := primary_1 )
                    WHERE in_use = '0'
                    AND not_ptp ='0'
                    AND id_user = '0'
                    AND called = '0'
                    AND due_date ='" . $get_due_date . "'
                     ORDER BY  angsuran_ke ASC LIMIT 1 ;SELECT @update_id as last";
        //die($sql);
        $queries = preg_split("/;+(?=([^'|^\\\']*['|\\\'][^'|^\\\']*['|\\\'])*[^'|^\\\']*[^'|^\\\']$)/", $sql);
        foreach ($queries as $query) {
            $res = $this->db->query($query);
            if ($this->db->last_query() == 'SELECT @update_id as last') {
                $get_prim = $res->row();
                $get_last = $get_prim->last;
                //die($get_last);
                if ($get_last > 1) {
                    $_SESSION['finansia_dpd'] = $dpd;
                } else {
                    //die('else');
                    $this->find_session();
                }
            }
        }
        */

				$where = array(
					"id_user" => $id_user
				);
				$q = $this->db->get_where("hdr_user", $where);
				$row = $q->row_array();
				//var_dump($row);
				//die();

				$product = $row['product'];
				$priority = $row['priority'];
				$branch_area = $row['branch_area'];
				$over_days = $row['over_days'];
				$fin_type = $row['fin_type'];

				### Martin-> escaping value branch ###
				if($branch_area != ''){
					$tmp_arr = explode(",",$branch_area);
					$index = 0;
					foreach($tmp_arr as $row) {
						$tmp_arr[$index] = $this->db->escape($row);
						$index++;
					}

					$branch_area = implode(",",$tmp_arr);
				}
				### end escaping value branch ###

				$where =  " where id_debtor > 0 ";
				$where .= " and in_use = 0 ";
				//$where .= " and not_ptp = '0' ";
				$where .= " and called = 0 ";
				$where .= " and skip = 0 ";
				$where .= " and (is_paid IS NULL or is_paid = 0)";
				$where .= " and (id_user = 0 or id_user=$id_user) ";
				$where .= " and valdo_cc = '01' "; //JAKARTA FLAG
				//$where .= " and due_date = '$get_due_date' ";

				$where .= $branch_area != "" ? " and kode_cabang IN ($branch_area) " : "";

				if($product != "ALL")
				{
					$arr_temp = array();
					$where .= " and (";
					$arrdata = explode(",", $product);
					$arrdata2 = explode(",", $product);
					for($i=0;$i<count($arrdata);$i++)
					{
						$arr_temp[] .= " object_group_code = (".$arrdata[$i].") ";
					}
					$where .= implode("or",$arr_temp) . ")";
				}

					if($over_days != "")
					{
						$arr_temp = "";
						$where .= " and (";
						$arrdata = explode(",", $over_days);

						for($i=0;$i<count($arrdata);$i++)
						{
//die('hehehehe'.$arrdata[$i]);
							if($arrdata[$i] != '10plus'
								&& $arrdata[$i] != '180plus'
								&& $arrdata[$i] != '120plus'
								&& $arrdata[$i] != '3minus'
								&& $arrdata[$i] != '2minus'
								&& $arrdata[$i] != '1minus'){
								$arr_temp[] .= " datediff(now(),due_date) = ('".$arrdata[$i]."') ";
							} elseif ($arrdata[$i] == '120plus'){
								$arr_temp[] .= " dpd > 120 ";
							} elseif ($arrdata[$i] == '180plus'){
								$arr_temp[] .= " dpd > 180 ";
							} elseif ($arrdata[$i] == '3minus'){
								$arr_temp[] .= " dpd <= -3";
							} elseif ($arrdata[$i] == '2minus'){
								$arr_temp[] .= " dpd <= -2 ";
							} elseif ($arrdata[$i] == '1minus'){
								$arr_temp[] .= " dpd <= -1 ";
							} else {
								$arr_temp[] .= " datediff(now(),due_date) >= ('10') ";
							}
						}
						$where .= implode("or",$arr_temp) . ")";
					}
					else
					{
						$where .= "and (datediff(now(),due_date) >= 0)";
					}
//die($where);

/*
				if($over_days != "")
				{
					$arr_temp = "";
					$where .= " and (";
					$arrdata = explode(",", $over_days);
					for($i=0;$i<count($arrdata);$i++)
					{
						if($arrdata[$i] != '10plus'
							&& $arrdata[$i] != '180plus'
							&& $arrdata[$i] != '120plus'){
							$arr_temp[] .= " datediff(now(),due_date) = ('".$arrdata[$i]."') ";
						} elseif ($arrdata[$i] == '120plus'){
								$arr_temp[] .= " dpd > 120 ";
						} elseif ($arrdata[$i] == '180plus'){
								$arr_temp[] .= " dpd > 180 ";
						} else {
							$arr_temp[] .= " datediff(now(),due_date) >= ('10') ";
						}
					}
					$where .= implode("or",$arr_temp) . ")";
				}
				else
					{
						$where .= "and (datediff(now(),due_date) >= 0)";
					}
*/
				//die($where);

				if($priority != "")
				{
					$arrdata_prod = explode(",", $priority);
					for($i=0;$i<count($arrdata_prod);$i++)
					{
						switch($arrdata_prod[$i])
						{
							case "PTP":
							$where .= " and ptp_date is not null and id_user = '$id_user' and month(ptp_date)=month(now()) and year(ptp_date)=year(now())";
							//die($where);
							break;

							case "UNTOUCH":
								$where .= " and (is_new = 1) ";
							break;

							case "RETOUCH":
								$where .= " and is_new = 2 ";
							break;
						}
					}
				}

					### Data Type ###

					$find_me = ",";
					$pos_flag = strpos($fin_type,$find_me); //IF FALSE THEN THERE IS ONLY 1 OPTION SELECTED



					if(!$pos_flag){
						$fin_type_arr = $fin_type;
						if($fin_type_arr != '0'){
							$where .= "AND ( fin_type IN (";
							$where .= $fin_type_arr;
							$where .= "))";
						} else {
							$where .= "";
						}
					}
					else{
						$fin_type_arr = explode($find_me,$fin_type);
						$where .= "AND ( fin_type IN(";
						foreach($fin_type_arr as $fin_type_row){
								$where .= $fin_type_row.",";
						}
						$where = substr_replace($where,"",-1,1);
						$where .= "))";
					}

				#################

//die("d" . $over_days);

				$orderby = "";
				$arr_temp1 = array();
				/*if($priority != "")
				{
					$orderby = " order by ";
					$arrdata1 = explode(",",$priority);
					for($i=0;$i<count($arrdata1);$i++)
					{
						switch($arrdata1[$i])
						{
							case 'PTP':
								$arr_temp1[] .= 'ptp_date asc';
							break;
							case 'NOTOVERDUE':
								$arr_temp1[] .= 'dpd asc';
							break;
							case 'ANGSKE1':
								$arr_temp1[] .= 'angsuran_ke asc';
							break;
						}
					}
					$orderby .= implode(",", $arr_temp1);
					//die($orderby);
				}*/

				//update payment
				$sql = "update hdr_debtor_main hdm, hdr_payment hdp
					set hdm.is_paid=1
					where hdm.primary_1=hdp.primary_1
					and hdm.angsuran_ke=hdp.angsuran_ke
					and (hdm.is_paid=0 OR hdm.is_paid is null)";
				//$this->db->query($sql);


		/*
			$sql_time = "SELECT MINUTE(NOW()) AS menit;";
			$result = $this->db->query($sql_time);

				foreach($result->result() as $row)
				{
					$menit = $row->menit;
				}

				#### function refresh payment setiap 30menit ####
				if($menit == "0" || $menit == "30"){
				//patch martin untuk pembayaran
				$sql2 = "UPDATE hdr_debtor_main hdm, hdr_payment hdp
					SET hdm.is_paid=1
					WHERE hdm.primary_1=hdp.primary_1
					AND hdp.trx_date = (SELECT MAX(trx_date) FROM hdr_payment hdp2 WHERE hdp2.primary_1 = hdm.primary_1)
					AND MONTH(hdp.trx_date) = MONTH(NOW())
					AND YEAR(hdp.trx_date)   = YEAR(NOW())
					AND (hdm.is_paid=0 OR hdm.is_paid IS NULL)";
				$this->db->simple_query($sql2);
				}
				#################################################
			*/

				//jika fungsi aktif
				$modechecksql = "select is_excluded from hdr_user where id_user="."'".$id_user."' LIMIT 1";
				$mode = $this->db->query($modechecksql);
				$rowmode = $mode->row();
				$is_active = $rowmode->is_excluded;
				if($is_active == "true")
				{
					$sql = "update hdr_debtor_main hdm, hdr_payment hdp
						set hdm.is_paid=0
						where hdm.primary_1=hdp.primary_1
						and hdm.angsuran_ke=hdp.angsuran_ke
						and hdp.angsuran_ke=1 and hdm.product='KMB'
						and hdm.is_paid=1 ";
					//$this->db->query($sql);


				}


						## setting priority order ##

							$priority = "ORDER BY ";
							$priority .= " RAND()";

						############################
						$sql_lock = "LOCK TABLES hdr_debtor_main AS lock".$id_user." WRITE";
						$sql = "select primary_1 from hdr_debtor_main AS lock".$id_user.
						" $where and (is_paid is null or is_paid='0') $orderby $priority limit 1";
						$toupdate = array(
							"id_user" => $id_user,
							"in_use" => "1"
						);
						$sql_unlock = "UNLOCK TABLE";


					$this->db->simple_query($sql_lock);
					$q = $this->db->query($sql);
					//echo $this->db->last_query();

					if($q->num_rows() > 0)
					{
						$row_main = $q->row_array();
						$get_last = $row_main['primary_1'];
						//die($get_last);
					}
					else {
						$get_last = 0;
					}

				$where_lock = array(
							"primary_1" => $get_last
				);
				$this->db->update("hdr_debtor_main AS lock".$id_user."", $toupdate, $where_lock);
				//echo $this->db->last_query();
				$this->db->simple_query($sql_unlock);
				//die();
				//die();
				$this->release_uncalled($id_user,$get_last);

        //die($get_last);;
        return $get_last;
    }

    public function get_main_info($primary_1) {
        $query = $this->db->get_where('hdr_debtor_main', array('primary_1' => $primary_1));
        return $query->row();
    }

    public function debtor_details($primary_1) {
        $sql = "SELECT  value as en_value FROM " . $this->hdr_debtor_details . " WHERE primary_1 = '$primary_1'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            $bad = 'no_debtor';
            return $bad;
        }
    }

    public function insert_call_track($data, $insert) {
        $primary_1 = $data['primary_1'];
        $id_user = $data['id_user'];
        $id_action_call_track = $data['id_action_call_track'];
        $data['is_current'] = '1';
        $data['in_use'] = '1';
        $data['cycling'] = '1';
        $not_ptp = $data['id_call_cat'] == 1 ? 1 : 0;
        //var_dump($data);
        //die();
        //$data['called'] = '1';
        if (!empty($data['ptp_fu'])) {
            if ($data['ptp_fu'] == '1')
                $this->update_ptp_fu($primary_1);
        }elseif (!empty($data['fu'])) {
            if ($data['fu'] == '1')
                $this->update_fu($primary_1);
        }
        //echo $data['id_ptp'];
        $this->in_use_debtor($primary_1, $id_user, $not_ptp);
        $this->db->insert('hdr_calltrack', $data);
        $sql = "INSERT IGNORE INTO data_sequence_log (`id_user`,`primary_1`,`type`,`log`) VALUES ($id_user,'$primary_1','Insert Calltrack','Inserting Calltrack for $primary_1')";
      	$this->db->simple_query($sql);
        $id_calltrack = $this->db->insert_id();
        $a = $this->db->last_query();
		//echo $id_calltrack;
        //die();

        $acc_work = @$_SESSION['primary_1'] == $data['primary_1'] ? 0 : 1;
        if (empty($id_calltrack)) {
            echo "Maaf Tidak bisa input double \n"; }
        if (!empty($id_calltrack)) {
						$this->producivity($call = 0, $work = 0, $contact = 0, $no_contact = 0, $ptp = 0);
            if ($data['id_call_cat'] == 1 && $data['id_ptp'] != 1)
                $this->producivity($call = 1, $work = $acc_work, $contact = 1, $no_contact = 0, $ptp = 0);
            elseif ($data['id_call_cat'] == 2)
                $this->producivity($call = 1, $work = $acc_work, $contact = 0, $no_contact = 1, $ptp = 0);
            elseif ($data['id_ptp'] == 1)
                $this->producivity($call = 1, $work = $acc_work, $contact = 1, $no_contact = 0, $ptp = 1);
        }
        $_SESSION['primary_1'] = $data['primary_1'];
        //$work = $_SESSION['work']==1?1:0
        $_SESSION['work'] = '0';
        $this->absen($id_user, 2);
        return $id_calltrack;
    }

    public function producivity($call, $work, $contact, $no_contact, $ptp) {
        $month = date('n');
        $day = date('j');
        $id_user = $_SESSION['bid_user_s'];
        $username = $_SESSION['bsname_s'];
        $select_sql = "SELECT *,max(id_productivity) as max_prod FROM hdr_call_productivity WHERE id_user ='$id_user' AND date ='" . date_now() . "' ";
        $query_select = $this->db->query($select_sql);
        $last_prod_id = $query_select->row();
        if (!empty($last_prod_id->id_productivity) && date_now() == $last_prod_id->date) {
            $sql = "UPDATE hdr_call_productivity hpv
                    INNER JOIN hdr_user hu ON hpv.id_user = hu.id_user
                    SET hpv.id_user = '$id_user', hpv.username = hu.username,
                    hpv.call = hpv.call+$call, hpv.work = hpv.work+$work, hpv.contact = hpv.contact+$contact, hpv.no_contact = hpv.no_contact+$no_contact,
                    hpv.ptp = hpv.ptp+$ptp
                    WHERE hpv.id_user = '$id_user'  AND hpv.id_productivity ='$last_prod_id->max_prod';
            ";
            $query = $this->db->query($sql);
            //die($sql);
            return $query;
        } else {
            $this->insert_prod();
        }
    }

    function insert_prod() {
        $sql = "INSERT INTO hdr_call_productivity
                        (id_user , username, date)
                       VALUES ('" . id_user() . "','" . user_name() . "','" . date_now() . "')";
        $query = $this->db->query($sql);
        //die($sql);
        $this->clear_ptp_status();
        return $this->db->insert_id();
    }

    function summary_prod() {
        $id_user = $_SESSION['bid_user_s'];
        $sql = "SELECT * from hdr_call_productivity WHERE date = '" . date_now() . "' AND id_user='" . $id_user . "';";
        $query = $this->db->query($sql);
        return $query;
    }

    function summary_compatitor() {
        $sql = "SELECT hcp.*,hu.username from hdr_call_productivity hcp
                    INNER JOIN hdr_user hu ON hu.id_user = hcp.id_user
                    WHERE date = '" . date_now() . "'
                    ORDER BY keep DESC  LIMIT 10 ;";
        $query = $this->db->query($sql);
        return $query;
    }

    function clear_ptp_status() {
        $id_user = $_SESSION['bid_user_s'];
        $sql_check = "SELECT * FROM hdr_call_productivity WHERE id_user='" . $id_user . "' AND date='" . date_now() . "';";
        $query = $this->db->query($sql_check);
        if ($query->num_rows > 0) {
            $data = $query->row();
            $keep = $data->keep;
            $broken = $data->broken;
            if ($keep == 0) {
                $sql_keep = "UPDATE hdr_call_productivity  hcp
                    SET hcp.keep = (SELECT COUNT(DISTINCT hc.primary_1)  FROM hdr_calltrack  hc WHERE hc.ptp_status ='2' AND hc.id_user ='" . $id_user . "' AND hc.id_action_call_track ='28'   AND hc.call_month='" . month_now() . "')
                    WHERE hcp.date = '" . date_now() . "' AND hcp.id_user='" . $id_user . "'";
                $query_keep = $this->db->query($sql_keep);
            } else {
                $not = '';
            }
            if ($broken == 0) {
                $sql_broken = "UPDATE hdr_call_productivity  hcp
                    SET hcp.broken = (SELECT COUNT(DISTINCT hc.primary_1)  FROM hdr_calltrack  hc WHERE hc.ptp_status ='1' AND hc.id_user ='" . $id_user . "' AND hc.id_action_call_track ='28'   AND hc.call_month='" . month_now() . "')
                    WHERE hcp.date = '" . date_now() . "' AND hcp.id_user='" . $id_user . "'";
                $query_broken = $this->db->query($sql_broken);
            } else {
                $not = '';
            }
        }
    }

    public function get_reminder_now() {
        $sql = "SELECT primary_1 FROM hdr_calltrack WHERE";
    }

    //patch by Nudi 23 mei
    public function set_in_use($primary_1)
    {
    	$where = array(
    		"primary_1" => $primary_1
    	);
    	$data_toupdate = array(
    		"in_use" => "1",
    		"id_user" => id_user()
    	);
    	$this->db->update("hdr_debtor_main", $data_toupdate, $where);
    }

    public function reset_uncall($id_user) {
        $sql = "UPDATE hdr_debtor_main hdm
			SET hdm.in_use = '0'
			WHERE id_user='$id_user' ";
        $query = $this->db->query($sql);

				$dtnow = date("Y-m-d");

				$sql = "update hdr_debtor_main hdm, hdr_calltrack hc
					set hdm.called=1
					where hc.call_date = '$dtnow'
					and hdm.primary_1=hc.primary_1
					and hdm.id_user='$id_user'
					and hdm.called=0";
				//die($sql);
				$query = $this->db->query($sql);

        return $query;
    }

    public function in_use_debtor($primary_1, $id_user, $not_ptp) {
        $sql = "UPDATE hdr_debtor_main SET in_use ='1', id_user='$id_user', called='1' WHERE primary_1 = '$primary_1'  ";
        $query = $this->db->query($sql);

        $sql = "INSERT IGNORE INTO data_sequence_log (`id_user`,`primary_1`,`type`,`log`) VALUES ($id_user,'$primary_1','Set Called','Setting Called for $primary_1')";
      	$this->db->simple_query($sql);

        return $query;
        //echo $this->db->last_query();
    }

    public function reset_uncall_spv() {
        $sql = "UPDATE hdr_debtor_main hdm
			SET hdm.in_use = '0', hdm.id_user='0'
			WHERE hdm.called='0'   ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_ptp() {
        $get_day_4 = strtotime(date("Y-m-d", strtotime(date_now())) . " -4 days");
        $last_day = date('Y-m-d', $get_day_4);
        $sql = " SELECT hdm.primary_1  FROM " . $this->hdr_debtor_main . " AS hdm
                   INNER JOIN hdr_calltrack hdc ON hdc.primary_1 = hdm.primary_1
                   WHERE hdc.id_action_call_track ='28' AND  hdm.call_status ='1' AND hdc.ptp_fu ='0' AND hdc.id_user = '" . id_user() . "'
                   AND hdc.call_date >='" . $last_day . "'
                    GROUP BY hdm.primary_1 ORDER BY hdm.debt_amount DESC LIMIT 1";
        //die($sql);
        $query = $this->db->query($sql);
        $data = $query->row();
        if ($query->num_rows() < 1) {
            $bad = '0';
            return $bad;
        } else {
            return $data->primary_1;
        }
    }

    public function get_no_contact_fu() {
        $today = date('Y-m-d');
        $now = date('Y-m-d 00:00:00');
        $sql = " SELECT  hdm.primary_1 FROM hdr_debtor_main hdm
                   INNER JOIN hdr_calltrack hdc ON hdc.primary_1 = hdm.primary_1
                   WHERE hdc.id_call_cat ='2'  AND   hdm.call_status ='1'  AND hdm.shift = '" . $_SESSION['shift'] . "' AND hdc.fu ='0' AND hdm.skip='0' AND hdm.id_user = '" . id_user() . "'
                   GROUP BY hdm.primary_1 ORDER BY hdm.debt_amount DESC LIMIT 1";
        //die($sql);
        $query = $this->db->query($sql);
        $data = $query->row();
        if ($query->num_rows() < 1) {
            $bad = '0';
            return $bad;
        } else {
            return $data->primary_1;
        }
    }

    public function get_contact_fu() {
        $today = date('Y-m-d');
        $now = date('Y-m-d 00:00:00');
        $sql = " SELECT hdm.primary_1  FROM hdr_debtor_main hdm
                   INNER JOIN hdr_calltrack hdc ON hdc.primary_1 = hdm.primary_1
                   WHERE hdc.id_call_cat ='1' AND   hdm.call_status ='1' AND hdm.skip='0'   AND  hdm.shift = '" . $_SESSION['shift'] . "'   AND hdc.id_action_call_track !='28'
                   AND hdc.fu ='0' AND hdm.id_user = '" . id_user() . "'
                    GROUP BY hdm.primary_1 ORDER BY hdm.debt_amount DESC LIMIT 1";
        //die($sql);
        $query = $this->db->query($sql);
        $data = $query->row();
        if ($query->num_rows() < 1) {
            $bad = '0';
            return $bad;
        } else {
            return $data->primary_1;
        }
    }

    public function call_catagory() {
        //$query = $this->db->get('hdr_call_catagory');
        $sql = "SELECT * FROM hdr_call_catagory WHERE type !='P' ";
        $query = $this->db->query($sql);
        return $query;
    }
    public function ptp_catagory() {
       $query = $this->db->get_where('hdr_call_catagory', array('type' => 'P'));
       return $query;
    }

    public function action_agen_track() {
        $query = $this->db->get('hdr_action_agen_track');
        return $query;
    }

    public function get_active_agen($primary_1) {
        $this->db->order_by('id_active_agency', 'asc');
        $query = $this->db->get_where('hdr_active_agency', array('primary_1' => $primary_1), 1);
        if ($query->num_rows() > 0) {
            return $data = $query->row();
        } else {
            return '0';
        }
    }

    public function get_reschedule($primary_1) {
        $this->db->order_by('id_reschedule', 'asc');
        $query = $this->db->get_where('hdr_reschedule', array('primary_1' => $primary_1), 1);
        if ($query->num_rows() > 0) {
            return $data = $query->row();
        } else {
            return '0';
        }
    }

    public function get_reminder($primary_1) {
        $this->db->order_by('due_date', 'asc');
        $query = $this->db->get_where('hdr_calltrack', array('primary_1' => $primary_1, 'is_current' => 1, 'id_action_call_track' => 4), 1);
        if ($query->num_rows() > 0) {
            return $data = $query->row();
        } else {
            return '0';
        }
    }

    public function insert_phone_no($data) {
        $sql = $this->db->insert_string('hdr_debtor_phone_no', $data);
        $query = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function edit_phone_no($id_phone, $data) {
        $where = "id_phone = $id_phone";
        $sql = $this->db->update_string('hdr_debtor_phone_no', $data, $where);
        $query = $this->db->query($sql);
        return $id_phone;
    }

    public function get_phone($primary_1) {
        $sql = "SELECT  * FROM hdr_debtor_phone_no WHERE primary_1= '$primary_1' ";
        //$this->db->order_by('id_phone','desc');
        //$query = $this->db->get_where('hdr_debtor_phone_no',array('primary_1'=>$primary_1));
        $query = $this->db->query($sql);
        return $data = $query;
    }

    public function get_one_phone($id_phone) {
        $results = array();
        $query = $this->db->query("SELECT * FROM hdr_debtor_phone_no WHERE id_phone = '$id_phone' LIMIT 1");

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $query_results['id_phone'] = $row['id_phone'];
            $query_results['phone_type'] = $row['phone_type'];
            $query_results['phone_no'] = $row['phone_no'];
            $results = $query_results;
        } else {
            $results = false;
        }

        return $results;
    }

    public function delete_phone($id_phone) {
        $this->db->delete('hdr_debtor_phone_no', array('id_phone' => $id_phone));
    }

    public function insert_info($data) {
        $sql = $this->db->insert_string('hdr_debtor_info', $data);
        $query = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function edit_info($data) {
        $where = "primary_1 = " . $data['primary_1'] . "";
        $sql = $this->db->update_string('hdr_debtor_info', $data, $where);
        $query = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function get_info($primary_1) {
        $this->db->order_by('id_debtor_info', 'desc');
        $query = $this->db->get_where('hdr_debtor_info', array('primary_1' => $primary_1));
        return $data = $query;
    }

    public function get_one_info($id_debtor_info) {
        $results = array();
        $query = $this->db->query("SELECT * FROM hdr_debtor_info WHERE id_debtor_info = '$id_debtor_info' LIMIT 1");

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $query_results['id_debtor_info'] = $row['id_debtor_info'];
            $query_results['info'] = $row['info'];
            $results = $query_results;
            //print_r($results);
        } else {
            $results = false;
        }

        return $results;
    }

    public function skip_debtor($primary_1, $id_user) {
        $sql = "UPDATE hdr_debtor_main SET skip ='1', id_user='$id_user' WHERE primary_1 = '$primary_1'";
        $query = $this->db->query($sql);
        return $query;
        //echo $this->db->last_query();
    }

    public function get_latest_use($primary_1, $id_user, $in_use) {
        $get_tag_condition = $in_use ? get_tag_condition($in_use, ' AND ') : '';
        $sql = "SELECT *, id_action_call_track FROM hdr_calltrack WHERE primary_1 = '$primary_1'
                $get_tag_condition  LIMIT 1";
        $query = $this->db->query($sql);
        //echo $sql;
        $data = $query->row();
        if ($query->num_rows() >= 1) {
            return $data;
        } else {
            return '0';
        }
    }

    public function update_current($primary_1, $id_user) {
        $date = date('Y-m-d');
        $sql = "UPDATE hdr_calltrack SET is_current = '0' WHERE primary_1 = '$primary_1' AND call_date ='$date' AND id_user = '$id_user' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function absen($id_user, $type) {
        $last_attend = @$_SESSION['last_attend_id'];
        $month = date('n');
        $day = date('j');
        $select_sql = "SELECT *,max(id_attend) as max_attend FROM hdr_user_attend WHERE id_user ='$id_user' AND call_date ='" . date_now() . "' ";
        $query_select = $this->db->query($select_sql);
        $last_attend_id = $query_select->row();
        if (!empty($last_attend_id->id_attend) && date_now() == $last_attend_id->call_date) {
            $sql = "UPDATE hdr_user_attend hua
                    INNER JOIN hdr_user hu ON hua.id_user = hu.id_user
                    SET hua.id_user = '$id_user', hua.username = hu.username, hua.logout_time = '" . get_now() . "'
                    WHERE hua.id_user = '$id_user'  AND hua.id_attend ='$last_attend_id->max_attend';
            ";
            $query = $this->db->query($sql);
            //die($sql);
            return $query;
        } else {
            $sql = "INSERT INTO hdr_user_attend
                        (id_user , username, login_time , month,day,log_type,query,attempt,call_date)
                        SELECT '$id_user', username, '" . get_now() . "', '$month','$day' ,'$type','1','1','" . date_now() . "'  FROM hdr_user
                        WHERE id_user = '$id_user' ";
            $query = $this->db->query($sql);
            //die($sql);
            return $this->db->insert_id();
        }
    }

    public function update_called($primary, $id_user) {
        $sql = "UPDATE hdr_debtor_main SET called = '1' WHERE primary_1='$primary'  AND id_user ='$id_user' ";
        $query = $this->db->query($sql);
        return $query;
        // $sql = "UPDATE hdr_debtor_main SET in_use = '0'"
    }

    public function update_ptp_fu($primary_1) {
        $sql = "UPDATE hdr_calltrack SET ptp_fu ='1' WHERE primary_1 = '$primary_1'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function update_fu($primary_1) {
        $sql = "UPDATE hdr_calltrack SET fu ='1' WHERE primary_1 = '$primary_1'";
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_call_track_info($primary_1) {
        $sql = "SELECT DISTINCT ptp_status, call_date, username FROM hdr_calltrack
            WHERE primary_1='" . $primary_1 . "' AND id_handling_code='02'
                GROUP BY call_date
                ORDER BY call_date DESC";
        $query = $this->db->query($sql);

        //echo $this->db->last_query();
        return $query;
    }

    public function get_payment_via($code) {
        $query = $this->db->get_where('hdr_payment_via', array('code' => $code));
        return $query;
    }

    public function insert_contact_code($data) {

        //$this->update_current($primary_1,$id_user);
        $sql = $this->db->insert_string('hdr_contact_code', $data);
        $query = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function insert_agen_track($data) {
        $sql = $this->db->insert_string('hdr_agen_monitor', $data);
        $query = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function insert_stat_call($id_user, $status) {
        $now = date('Y-m-d');
        $record->id_user = $id_user;
        $record->$status = $status;
        $record->createdate = $now;
        return $this->db->insert('hdr_stat_call', $record);
    }

    public function update_stat_call($id_user, $status) {
        //$status;
        $sql = "UPDATE hdr_stat_call SET $status = $status+1 WHERE id_user = '$id_user' AND createdate = CURDATE( ) ";
        return $this->db->query($sql);
    }

    public function get_field_name($id_field_name) {
        $query = $this->db->get_where('hdr_debtor_field_name', array('id_file_field' => $id_field_name));
        return $query->row();
    }

    public function get_broken($id_user) {

    }

    public function get_keep($id_user) {

    }

    public function call_attempt_debtor($primary_1) {
        $sql = "SELECT COUNT( hdc.primary_1) AS total
		    FROM hdr_calltrack  AS hdc WHERE primary_1 = '$primary_1' AND id_action_call_track !=0";
        $query = $this->db->query($sql);
        $data = $query->row();
        if ($query->num_rows() < 1) {
            $never = 'never call';
            return $never;
        } else {
            return $data->total;
        }
    }

    public function count_assign_debtor_tc($id_tc) {
        if ($_SESSION['filter_debtor'] == '') {
            return 'Not Filtered';
        } else {
            $sql = " SELECT COUNT(DISTINCT hdm.primary_1) AS total_debtor  FROM " . $this->hdr_debtor_main . " AS hdm  " . $_SESSION['filter_debtor'] . " ";
            //echo $sql;
            //echo $id_tc;
            $query = $this->db->query($sql);
            $data = $query->row();
            if ($query->num_rows() < 1) {
                $bad = ' "No Debtor" ';
                return $bad;
            } else {
                return $data->total_debtor;
            }
        }
    }

    public function count_notcontacted_debtor_tc($id_tc) {
        $sql = " SELECT COUNT(DISTINCT hdm.primary_1) AS total_not_contact_debtor  FROM " . $this->hdr_debtor_main . " AS hdm  " . $_SESSION['filter_debtor'] . " AND hdm.primary_1 NOT IN (SELECT hct.primary_1 FROM hdr_calltrack AS hct WHERE hct.cycling ='1' AND hct.id_action_call_track !='4' AND hct.id_action_call_track ='1'  )";
        $query = $this->db->query($sql);
        $data = $query->row();
        if ($query->num_rows() < 1) {
            $bad = ' "No Debtor" ';
            return $bad;
        } else {
            return $data->total_not_contact_debtor;
        }
    }

    public function count_nottouch_debtor_tc($id_tc) {
        $sql = " SELECT COUNT(DISTINCT hdm.primary_1) AS total_not_contact_debtor  FROM " . $this->hdr_debtor_main . " AS hdm  " . $_SESSION['filter_debtor'] . "  AND hdm.primary_1 NOT IN (SELECT hct.primary_1 FROM hdr_calltrack AS hct   )";
        $query = $this->db->query($sql);
        $data = $query->row();
        if ($query->num_rows() < 1) {
            $bad = ' "No Debtor" ';
            return $bad;
        } else {
            return $data->total_not_contact_debtor;
        }
    }

    public function status_call($id_user, $status="", $begindate, $enddate) {
        $group_bys = 'hdc.primary_1';
        $query_ptp = "";
        $month_now = $sum = date("n", strtotime(date_now()));
        if ($begindate != "") {
            $bg = " AND hc.call_date>='$begindate ' ";
        } else {
            $bg = " ";
        }
        if ($enddate != "") {
            $ed = " AND hc.call_date<='$enddate ' ";
        } else {
            $ed = " ";
        }

        //die($status);
        if ($status == '1') {
            $status = " WHERE hdc.id_action_call_track ='1' ";
            // 	$bg = " AND hdc.ptp_date>='$begindate' ";
            // 	$ed = "   AND hdc.ptp_date<='$enddate' ";
        } elseif ($status == '2') {
            $status = "WHERE hac.id_call_cat ='2' ";
        } elseif ($status == '3') {

            $status = " WHERE hac.id_call_cat ='1' ";
        } elseif ($status == 'no_ptp') {
            $group_bys = '  hdc.primary_1 ';
            $status = "WHERE hac.id_call_cat ='1' AND hdc.id_action_call_track != '28' ";
        } elseif ($status == 'acct_worked') {
            $status = "WHERE hdc.is_current ='1'";
            $group_bys = 'DISTINCT  hdc.primary_1 ';
        } elseif ($status == 'ptp') {
            $group_bys = 'DISTINCT  hdc.primary_1 ';
            //echo "<h1>ptp</h1>";
            $status = " WHERE hdc.id_action_call_track='28' ";
        } elseif ($status == 'all') {
            $group_bys = ' hdc.primary_1 ';
            $status = 'WHERE hdc.id_action_call_track !="0" ';
        } else {
            $status = 'WHERE hdc.id_action_call_track !="0"   ';
        }
        $user = $id_user != 'all' ? '  hc.id_user ="' . $id_user . '"   ' : '';
        $month =
                $sql = "SELECT
                      hc.username,hc.id_user,
                      COUNT( CASE WHEN hc.id_call_cat = '1' THEN  hc.id_calltrack  END ) AS 'contact',
                      COUNT( CASE WHEN hc.id_call_cat = '2' THEN hc.id_calltrack  END ) AS 'no_contact',
                      COUNT( CASE WHEN hc.id_action_call_track = '28' THEN hc.id_calltrack END ) AS 'ptp',
                     (SELECT COUNT( primary_1) FROM hdr_calltrack WHERE ptp_status='2' AND hc.id_action_call_track ='28'  AND call_month='" . $month_now . "'  and id_user ='$id_user') as keep,
                     (SELECT COUNT( primary_1) FROM hdr_calltrack WHERE ptp_status='1' AND hc.id_action_call_track ='28'  AND call_month='" . $month_now . "'  and id_user ='$id_user') as broken
                      FROM hdr_calltrack hc
                      WHERE  $user AND  hc.call_date ='" . date_now() . "' ";
        //echo $sql . '</br>';
        $query = $this->db->query($sql);
        //$data = $query->row();
        return $query;
    }

    public function compatitor_dashboard() {
        $month_now = $sum = date("n", strtotime(date_now()));
        $remove = " -- COUNT(DISTINCT id_calltrack) as total_call, COUNT(DISTINCT hc.primary_1,hc.call_date) as acct_work, SUM(DISTINCT CASE WHEN hc.ptp_status = '2' AND call_month='" . $month_now . "'  THEN hc.ptp_amount  END ) AS 'amount_collected'";
        $sql = " SELECT
                      hc.username,hc.id_user,
                     '" . date_now() . "' as 'begindate',
                     '" . date_now() . "' as 'enddate',
                      COUNT( CASE WHEN hc.id_call_cat = '1' AND  hc.call_date ='" . date_now() . "'   THEN  hc.id_calltrack  END ) AS 'contact',
                      COUNT( CASE WHEN hc.id_call_cat = '2' AND  hc.call_date ='" . date_now() . "'  THEN hc.id_calltrack  END ) AS 'no_contact',
                      COUNT( CASE WHEN hc.id_action_call_track = '28' AND  hc.call_date ='" . date_now() . "'  THEN hc.id_calltrack END ) AS 'ptp',
                      COUNT( CASE WHEN hc.ptp_status = '2' AND call_month='" . $month_now . "' THEN hc.primary_1 END ) AS 'keep',
                      COUNT( CASE WHEN hc.ptp_status = '1' AND call_month='" . $month_now . "'  THEN hc.primary_1 END ) AS 'broken'
                      FROM hdr_calltrack hc
                      GROUP BY hc.id_user
                      ORDER BY keep DESC LIMIT 10";
        //echo $sql;
        //echo $sql.'</br>';
        //die($sql);
        //echo $status;
        $query = $this->db->query($sql);
        return $query;
    }

    public function status_ptp($id_user, $status, $begindate, $enddate) {
        $group_bys = 'DISTINCT hdc.primary_1';
        $query_ptp = "";
        if ($begindate != "") {
            $bg = " AND hdc.call_date>='$begindate ' ";
        } else {
            $bg = " ";
        }
        if ($enddate != "") {
            $ed = " AND hdc.call_date<='$enddate ' ";
        } else {
            $ed = " ";
        }

        //die($status);
        if ($status == 'keep') {
            $say = 'keep';
            if ($begindate != "") {
                $bg = "AND hdc.call_date>='$begindate'  AND MONTH(hdp.trx_date) >= MONTH(hdc.call_date) ";
            } else {
                $bg = " ";
            }
            if ($enddate != "") {
                $ed = " AND hdc.call_date<='$enddate'   ";
            } else {
                $ed = " ";
            }
            $status_p = " AND hdc.ptp_status ='2' ";
        } elseif ($status == 'broken') {
            $say = 'broken';
            if ($begindate != "") {
                $bg = "AND hdc.call_date>='$begindate' ";
            } else {
                $bg = " ";
            }
            if ($enddate != "") {
                $ed = "  AND hdc.call_date<='$enddate' ";
            } else {
                $ed = " ";
            }
            $status_p = " AND hdc.ptp_status ='1'   ";
        }
        $user = $id_user != 'all' ? ' AND hdc.id_user ="' . $id_user . '"   ' : '';
        $sql = " SELECT COUNT($group_bys) AS total
					FROM hdr_calltrack  AS hdc
					INNER JOIN hdr_payment AS hdp ON hdp.primary_1 = hdc.primary_1
					WHERE hdc.id_action_call_track ='28'
                $status_p   	$user
                $bg $ed ";
        if ($status == 'keep') {
            //echo $sql.'</br>';
        }
        if ($status == 'broken') {
            //echo $sql.'</br>';
        }
        $query = $this->db->query($sql);
        $data = $query->row();
        return $count = $data->total;
    }

    function get_last_ten_calltrack($primary_1) {
        $sql = "SELECT  hco.username,hco.code_call_track,hco.remarks,hco.call_date,hco.call_time,hco.ptp_date,hco.no_contacted, hco.ptp_amount,hco.dpd  FROM hdr_calltrack hco
					WHERE hco.primary_1 = '" . $primary_1 . "'
					AND hco.remarks !='' GROUP BY id_action_call_track,call_date,no_contacted order by call_date DESC,call_time DESC
					  limit 10 ";

        //echo $sql;
        $query = $this->db->query($sql);
        return $query;
    }

    public function export_calltrack($primary_1) {
        $this->load->helper('csv');
        $sql = "SELECT hco.username,hco.code_call_track,hco.remarks,hco.call_date,hco.call_time FROM hdr_calltrack hco
					WHERE hco.primary_1 = '" . $primary_1 . "'
					AND hco.remarks !='' AND hco.username !='' order by call_date DESC
					  ";
        $query = $this->db->query($sql);
        $fileName = 'calltrack_' . $primary_1 . date('Y_m_d_h_i_s') . '.csv';
        query_to_csv($query, TRUE, $fileName);
    }

    public function export_payment($primary_1) {
        $this->load->helper('csv');
        $sql = "SELECT hp.trx_date,hp.posting_date,hp.amount,hp.description FROM hdr_payment hp
					WHERE hp.primary_1 = '" . $primary_1 . "'
					order by posting_date DESC
					  ";
        $query = $this->db->query($sql);
        $fileName = 'payment_' . $primary_1 . date('Y_m_d_h_i_s') . '.csv';
        query_to_csv($query, TRUE, $fileName);
    }

    public function export_monitor_agen($primary_1) {
        $this->load->helper('csv');
        $sql = "SELECT ham.primary_1, ham.date_in, ham.time, ham.visit_date,ham.action_code,ham.ptp_date, ham.ptp_amount, ham.remark,ham.username,ham.agency,ham.coll_agency FROM hdr_agen_monitor ham
					WHERE ham.primary_1 = '" . $primary_1 . "'
					order by ham.date_in DESC
					  ";
        $query = $this->db->query($sql);
        $fileName = 'monitor_agen_' . $primary_1 . date('Y_m_d_h_i_s') . '.csv';
        query_to_csv($query, TRUE, $fileName);
    }

    function get_action_code_wom($primary_1) {
        $sql = "SELECT  region_desc, nama_kolektor,activity_date, action_desc FROM hdr_action_code where primary_1 = '" . $primary_1 . "' LIMIT 10";

        //echo $sql;
        $hasil = $this->db->query($sql);
        return $hasil;
    }

    public function get_motor_brand($item_no) {
        $sql = "SELECT * FROM  hdr_motor_type
		WHERE item_no = '$item_no' ";
        $query = $this->db->query($sql);
        return $query;
    }

    public function insert_address($data) {
        $sql = $this->db->insert_string('hdr_address', $data);
        $query = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function get_address_all($primary_1) {
        $SQL = "SELECT * FROM hdr_address WHERE  primary_1='$primary_1' ORDER BY id_address ASC";
        $query = $this->db->query($SQL);
        return $query;
    }

    public function delete_address($id_address) {
        $this->db->delete('hdr_address', array('id_address' => $id_address));
    }

    /* public function get_one_address($primary, $id_address) {
      $sql = "SELECT * FROM hdr_address WHERE id_address = '$id_address' AND primary_1='$primary' LIMIT 1";
      $query = $this->db->query($sql);
      return $query->result();
      }
     */

    public function get_one_address($id_address) {
        $results = array();
        $query = $this->db->query("SELECT * FROM hdr_address WHERE id_address = '$id_address' LIMIT 1");

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $query_results['id_address'] = $row['id_address'];
            $query_results['address'] = $row['address'];
            $query_results['type'] = $row['type'];
            $query_results['city'] = $row['city'];
            $query_results['zip_code'] = $row['zip_code'];
            $query_results['is_tagih'] = $row['is_tagih'];
            $query_results['phone_no'] = $row['phone_no'];
            $results = $query_results;
        } else {
            $results = false;
        }

        return $results;
    }

    public function edit_address($id_address, $data) {
        $where = "id_address = $id_address";
        $sql = $this->db->update_string('hdr_address', $data, $where);
        $query = $this->db->query($sql);
        return $id_address;
    }

    public function release_uncalled($id_user,$get_last){
    	$sql = "UPDATE hdr_debtor_main SET in_use = 0, id_user = 0
    					WHERE called = 0 AND id_user = '$id_user' AND primary_1 != '$get_last' AND not_ptp = 0;
    	";
    	$this->db->simple_query($sql);

    	$sql = "INSERT IGNORE INTO data_sequence_log (`id_user`,`primary_1`,`type`,`log`) VALUES ($id_user,'$primary_1','unlock_inuse','Unlocking All Uncalled except $get_last')";
      $this->db->simple_query($sql);

    }

    public function checkUserLock($primary_1,$id_user){
    	$sql_lock = "LOCK TABLES hdr_debtor_main AS lock".$id_user." WRITE;";
    	$sql_main = "SELECT primary_1 FROM hdr_debtor_main AS lock".$id_user." WHERE primary_1 = ? AND in_use = 1 AND id_user = ? AND called = 0";
    	$sql_unlock = "UNLOCK TABLES;";
    	$is_allow = 0;
    	$this->db->simple_query($sql_lock);
    	$query = $this->db->query($sql_main,array($primary_1,$id_user));
    	$this->db->simple_query($sql_unlock);

    	$flag = intval($query->num_rows()) > 0 ? $is_allow = 1 : $is_allow = 0;

    	return $is_allow;
    }

    public function get_reminder_new($primary_1,$id_user){
    	$sql = "
    	SELECT *,TIMESTAMPDIFF(MINUTE,remind_at,NOW()) AS 'diff',
						TIME(remind_at) AS 'remind_at_fix'
						FROM reminder_history a
						LEFT JOIN hdr_debtor_main b
						ON a.primary_1 = b.primary_1
						WHERE
						is_done = 0
						AND a.data_date = CURDATE()
						AND user_id = $id_user
						AND TIMESTAMPDIFF(MINUTE,remind_at,NOW()) >= -5
						LIMIT 3
    	";
			$query = $this->db->query($sql);
			$return = 0;

			if($query){
				$return = $query->result_array();
			}

			return $return;
    }

}
?>
