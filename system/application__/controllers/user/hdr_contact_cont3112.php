<?php

/*
  This script software package is NOT FREE And is Copyright 2010 (C) Valdo-intl all rights reserved.
  we do supply help or support or further modification to this script by Contact
  Haidar Mar'ie
  e-mail = haidar.m@valdo-intl.com
  e-mail = coder5@ymail.com
 */

class Hdr_contact_cont extends Controller {

    public function __construct() {
        parent::Controller();
        $this->CI = & get_instance();

        if (@$_SESSION['blevel'] == 'user' || @$_SESSION['blevel'] == 'spv' || @$_SESSION['blevel'] == 'admin' || @$_SESSION['blevel'] == 'spv_sta') {
            //
        } else {
            redirect('login');
        }
        $this->load->model('hdr_debtor/hdr_debtor_model', 'debtor_model');
        $this->load->model('user/hdr_call_track_model', 'call_track_model');
    }

    public function index() {
        redirect('user/hdr_contact_cont/contact');
    }

    public function contact() {
				//echo '<img src="'. base_url() . 'assets/images/loader.gif">'; echo "<br/>";
        //die("<br/>Mohon Maaf, Aplikasi sedang diupdate, Refresh (tekan F5) lagi setelah 3 Menit <br/><br/> -- <br/>Martin <br/> IT Developer <br/> Valdo International");
        //$this->load->library('Multicache');
        //$this->output->cache(7200);
        //$this->output->enable_profiler("TRUE");
        $data['title'] = 'Contact Menu';
        $data['contact_type'] = $this->uri->segment(4);
        $id_user = $_SESSION['bid_user_s'];
        $username = $_SESSION['bsname_s'];
        $data['id_user'] = $id_user;
        $data['username'] = $username;
        $post = @$_POST['post'];
        $search_acct = @$_POST['search_acct'];
        $search_card_no = @$_POST['search_card_no'];
        $name_debt = @$_POST['name_debt'];

		if (isset($post)) {

            if (!empty($search_acct)) {

                redirect('user/hdr_contact_cont/contact/call/' . $search_acct);
            } elseif (!empty($search_card_no)) {

                $primary_card = $this->debtor_model->get_primary_1($search_card_no);
                redirect('user/hdr_contact_cont/contact/call/' . $primary_card);
            } elseif (!empty($name_debt)) {

                $primary_name = $this->debtor_model->get_primary_name($name_debt);
                redirect('user/hdr_contact_cont/contact/call/' . $primary_name);
            }
        } else {

            $primary_1 = $this->uri->segment(5);

            if($primary_1 != '' && $primary_1 != '0'){
            	$primary_1 = base64_decode($primary_1);
            	$chunk = explode("_",$primary_1);
            	$minute_stamp = $chunk[1];
            	$minute_now = date("i");

            	if($minute_stamp != $minute_now){
            		//stamp not match
            		redirect('user/hdr_contact_cont/contact/call/');
            	} else {
            		$primary_1 = $chunk[0];
            	}
            }

            $type_calling = $this->uri->segment(4);
            $data['primary_1'] = $primary_1;
		
            if ($_SESSION['blevel'] == 'user') :
                if ($primary_1 == "") {
                    if ($type_calling == 'call') {

                        //die('session dpd='.@$_SESSION['finansia_dpd']);
                        if (isset($_SESSION['finansia_dpd'])) {

                        		$dtnow = date("Y-m-d");

														$sql = "update hdr_debtor_main hdm, hdr_calltrack hc
																	set hdm.called=1
																	where hc.call_date = '$dtnow'
																	and hdm.primary_1=hc.primary_1
																	and hdm.id_user='$id_user'
																	and hdm.called=0";
																	//die($sql);
																	$query = $this->db->query($sql);
  	    										//$a = $this->call_track_model->find_session();
  	    										//echo $a;
  	    										//die($a);
                            $get_last = base64_encode($this->call_track_model->get_dpds(0)."_".DATE("i"));
        										//die("aa");
                            //die('last'.$get_last);
                            //die("dorrr");
				//var_dump($get_last);
                            redirect('user/hdr_contact_cont/contact/' . $type_calling . '/' . $get_last);
                        } else {
                            $find_session = $this->call_track_model->find_session();

                            //die('ses'.$find_session);
                            //die('session dpd='.@$_SESSION['finansia_dpd']);
                            if ($find_session == '') {
                                //die('redir');

                                redirect('user/hdr_contact_cont/contact/' .$type_calling);
                            } else {
                                //die('no_redir');
                                //die();

                                redirect('user/hdr_contact_cont/contact/call/0');
                            }
                        }
                    } elseif ($type_calling == 'ptp') {
                        //die();
                        $get_next = $this->call_track_model->get_ptp();
                        redirect('user/hdr_contact_cont/contact/' . $type_calling . '/' . $get_next);
                    } elseif ($type_calling == 'contact_fu') {
                        $get_next = $this->call_track_model->get_contact_fu();
                        $this->call_track_model->skip_debtor($get_next, $id_user);
                        redirect('user/hdr_contact_cont/contact/' . $type_calling . '/' . $get_next);
                    } elseif ($type_calling == 'no_contact_fu') {
                        $get_next = $this->call_track_model->get_no_contact_fu();
                        $this->call_track_model->skip_debtor($get_next, $id_user);
                        redirect('user/hdr_contact_cont/contact/' . $type_calling . '/' . $get_next);
                    } else {
                        $get_next = $this->call_track_model->get_real_debtor();
                    }
                } else {
                    // die($primary_1) ;

                    $primary_1;
                }
            endif;
        }

				//patch nudi 23 mei
				//update hdr_debtor_main set in_use=1 where primary_1
				$this->call_track_model->set_in_use($primary_1);

        $id_field_name = 1;
        $begindate = date('Y-m-01');
        $enddate = date('Y-m-31');

        $data['call_catagory'] = $this->call_track_model->call_catagory();
        $data['ptp_catagory'] = $this->call_track_model->ptp_catagory();
        $data['get_other_address'] = $this->call_track_model->get_address_all($primary_1);
        $data['get_other_phone'] = $this->call_track_model->get_phone($primary_1);
        $data['get_other_info'] = $this->call_track_model->get_info($primary_1);


				$qry = $this->db->get_where('hdr_user', array('id_user' => $id_user));
				$data['user_info'] = $qry->row();
				//var_dump($data['user_info']);
				//die();

        $getstr = $this->call_track_model->debtor_details($primary_1);

				### patch martin PTP untuk Berulang###
				//$sql = "SELECT ptp_status FROM hdr_calltrack WHERE primary_1 = '$primary_1' AND ptp_date IS NOT NULL AND ptp_date >= DATE(NOW()) LIMIT 1";
				$sql = "SELECT a.ptp_status,s.dpd,s.score_result FROM hdr_calltrack a, hdr_debtor_main s WHERE a.primary_1 =s.primary_1 and
				a.primary_1 = '$primary_1' AND s.dpd not in (9) and a.ptp_date IS NOT NULL and a.ptp_date >= DATE(NOW())  LIMIT 1";
				
				$result = $this->db->query($sql);
				if($result->num_rows() > 0) {
				$row = $result->row();
							if($row->ptp_status == 0) { $data['last_ptp_status'] = "A"; } // Active
						else if ($row->ptp_status == 1 ) { $data['last_ptp_status'] = "B"; } // Broken
						else { $data['last_ptp_status'] = "K"; } // Keep
				} else { $data['last_ptp_status'] = "false"; }
			
				################################

				## Martin Add -> GET REMINDER ##
        $data['get_reminder_new'] = $this->call_track_model->get_reminder_new($primary_1,$id_user);
        $reminder_count = count($data['get_reminder_new']);
        if($reminder_count > 0) { $data['div_state'] = "block"; } else { $data['div_state'] = "none"; }
    		################

				#### Count Call Today ####
				$today = date("Y-m-d");
				$sql = "SELECT COUNT(id_calltrack) AS work from hdr_calltrack WHERE call_date = '$today' AND id_user = '$id_user'";
				$query = $this->db->query($sql);
				$result = $query->row();
				$work_count = $result->work;
				$work_percentage = (($work_count/250)*100);
				$data['work_percentage'] = $work_percentage;

				##########################

				#### Data Type #####
				$sql = "SELECT fin_type FROM hdr_debtor_main WHERE primary_1 = '$primary_1' LIMIT 1";
				$query = $this->db->query($sql);
				$row_arr = $query->row_array();
				if(count($row_arr) > 0 ){
						$data['fin_type'] = $row_arr['fin_type'];
				} else {
					$data['fin_type'] = 0;
				}

				######################


        $data['get_main_info'] = $this->call_track_model->get_main_info($primary_1);
        $data['get_ptp_status'] = $this->call_track_model->get_call_track_info($primary_1);
        $data['get_signout_option'] = $this->call_track_model->get_signout_option();
        $last_ptp = 0;

        /* Log This Account */
        $sql = "INSERT IGNORE INTO data_sequence_log (`id_user`,`primary_1`,`type`,`log`) VALUES ($id_user,'$primary_1','lock_inuse','Locking Inuse $primary_1')";
        $this->db->simple_query($sql);


        if ($data['get_ptp_status']->num_rows() > 0) {

            $get_last_ptp = $data['get_ptp_status']->row();
            $max_ptp = $_SESSION['shift'] == 3 ? 3 : 7;
            $get_ptp_7 = strtotime(date("Y-m-d", strtotime("$get_last_ptp->call_date")) . " +" . $max_ptp . " days");
            $maxptpdate = date('Y-m-d', $get_ptp_7);
            $last_ptp = $maxptpdate >= date_now() ? 1 : 0;
            //die('ja' . $maxptpdate.'-'.date_now());
        }
        $data['action_call_track'] = $this->call_track_model->action_call_track($last_ptp);
        if ($getstr == 'no_debtor') {
            $str_ars = array();
            for ($i = 1; $i <= 80; $i++) {
                $str_ars[$i] = 'no DATA';
            }
            $str_ars[0] = '1';
            $debt_data = $str_ars == '' ? 'no DATA' : $str_ars;
            $data['a_value'] = $str_ars;
        } else {
            $str_ars = $getstr->en_value;
            $debt_data = strs_to_arrs($str_ars);

            //var_dump($getstr);
            //die();

            $data['a_value'] = $debt_data;
        }

        if(intval($data['fin_type']) == 2){
        	$this->load->view('user/hdr_header_user_syr', $data);
      	}else{
      		$this->load->view('user/hdr_header_user', $data);
      	}
        	$this->load->view('user/hdr_contact_view', $data);
        if(intval($data['fin_type']) == 2){
        	$this->load->view('user/hdr_footer_syr', $data);
      	}else {
      		$this->load->view('user/hdr_footer', $data);
      	}
    }

    public function last_call($primary_1="") {
        //$this->output->enable_profiler("TRUE");
        $last_calltrack = $this->call_track_model->get_last_ten_calltrack($primary_1);
        $html = "<div style=\"width:434px;overflow:auto;\" > ";
        $html .="<colgroup><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100></colgroup>
    <tbody>";
        if ($last_calltrack->num_rows() > 0) {
            $r = 1;

            $html .=' 		<h3>Last 10 Calltrack</h3>
                <br />
                <br />
               <div class="last_ten" style="width:400px;height:400px;overflow:scroll;" >
                <table border="0" style="" cellspacing=0 cols=3 rules=none >';
            $list = $r % 2 == 1 ? "listA" : "listB";
            $html .=' <tr class="' . $list . '">
                    <td class="status">Username</td>
                    <td class="status">Remark(NOTE)</td>
                    <td class="status">CodeCall</td>
		    <td class="status">CallDate</td>
		    <td class="status">CallTime</td>
		    <td class="status">PTPDate</td>
                    <td class="status">Phone</td>
                    <td class="status">DPD</td>
		</tr>';

            foreach ($last_calltrack->result() as $row):

                $list = $r % 2 == 1 ? "listA" : "listB";
                $html .='<tr class="' . $list . '">';
                $html .='<td class="status">' . $row->username . "</td>\n";
                $html .='<td class="status">' . $row->remarks . "</td>\n";
                $html .='<td class="status">' . $row->code_call_track . "</td>\n";
                $html .='<td class="status">' . date_formating($row->call_date) . "</td>\n";
                $html .='<td class="status">' . $row->call_time . "</td>\n";
                $html .='<td class="status">' . date_formating($row->ptp_date) . "</td>\n";
                $html .='<td class="status">' . $row->no_contacted . "</td>\n";
                $html .='<td class="status">' . $row->dpd . "</td>\n";
                $html .="</tr>\n";

                $r++;
            endforeach;
            $html .='		</table>
				</div>';

            $html .='</tbody></div>';
        }else {
            echo "There is no data calltrack";
        }
        echo $html;
    }

    public function other_info($primary_1="") {
        $data['get_reminder'] = $this->call_track_model->get_reminder($primary_1);
        $data['get_active_agen'] = $this->call_track_model->get_active_agen($primary_1);
        $data['get_reschedule'] = $this->call_track_model->get_reschedule($primary_1);
        $this->load->view('user/details/other_info', $data);
    }

    public function summary_pop($primary_1='') {
        $id_user = $_SESSION['bid_user_s'];
        $username = $_SESSION['bsname_s'];
        $begindate = date('Y-m-d');
        $beginmonth = date('Y-m-01');
        $enddate = date('Y-m-d');
        $endmonth = date('Y-m-31');
        $data['username'] = $_SESSION['bsname_s'];
        $data['summary'] = $this->call_track_model->summary_prod();
        $data['compatitor'] = $this->call_track_model->summary_compatitor();
        $this->load->view('user/details/summary_popup', $data);
    }

    public function go_filter() {
        $search_card_no = @$_POST['search_card_no'] != '' ? @$_POST['search_card_no'] : @$_POST['nxt_card'];
        $search_acct = @$_POST['search_acct'];
        $name_debt = @$_POST['name_debt'];
        $this->load->model('hdr/hdr_ajax_model', 'ajax_model');
        //if()
        if (!empty($search_acct)) {
            $correct_primary_1 = $this->ajax_model->get_correct_primary_1($search_acct);
            if ($correct_primary_1->num_rows > 0) {
                $data = $correct_primary_1->row();
                echo "Please wait, <p>" . $data->primary_1 . "  is available in database and will redirecting to new page</p>";
                echo '<script>location.href="' . site_url() . 'user/hdr_contact_cont/contact/call/' . $data->primary_1 . '"</script>';
            } else {
                echo $search_acct . ' Account is not available in  database';
            }
        } elseif (!empty($name_debt)) {
            $correct_name = $this->ajax_model->get_correct_name($name_debt);
            if ($correct_name->num_rows > 0) {
                $data = $correct_name->row();
                echo "Please wait, <p>" . $data->name . "  is available in database and will redirecting to new page</p>";
                echo '<script>location.href="' . site_url() . 'user/hdr_contact_cont/contact/call/' . $data->primary_1 . '"</script>';
            } else {
                echo $name_debt . ' name is not available in  database';
            }
        }
    }

    function autocomplete_name() {
        $name = $this->uri->segment(4);
        $name = strtolower($_POST["q"]);
        //$this->output->enable_profiler("TRUE");
        if (isset($name) && strlen($name) > 2) {
            $this->load->model('hdr/hdr_ajax_model', 'ajax_model');
            $query = $this->ajax_model->get_name($name);
            //echo $query;
            foreach ($query->result() as $row) {
                echo $row->name . "\n";
            }
        }
    }

    function autocomplete_primary_1() {

        $primary_1 = $this->uri->segment(4);
        $primary_1 = strtolower($_POST["q"]);
        if (isset($primary_1) && strlen($primary_1) > 2) {
            $this->load->model('hdr/hdr_ajax_model', 'ajax_model');
            $query = $this->ajax_model->get_primary_1($primary_1);
            foreach ($query->result() as $row) {
                echo $row->primary_1 . "\n";
            }
        }
    }

    function autocomplete_card_no() {
        $card_no = $this->uri->segment(4);
        $card_no = strtolower($_POST["q"]);
        if (isset($card_no) && strlen($card_no) > 2) {
            $this->load->model('hdr/hdr_ajax_model', 'ajax_model');
            $query = $this->ajax_model->get_card_no($card_no);
            foreach ($query->result() as $row) {
                echo $row->card_no . "\n";
            }
        }
    }

    function autocomplete_remark() {
        $remark_code = $this->uri->segment(4);
        $remark_code = strtolower($_POST["q"]);
        if (isset($remark_code) && strlen($remark_code) > 0) {
            $this->load->model('hdr/hdr_ajax_model', 'ajax_model');
            $query = $this->ajax_model->get_remark($remark_code);
            foreach ($query->result() as $row) {
                echo $row->code_call_track . "\n";
            }
        }
    }

    public function call_debtor($no_telp) {

        //die(get_local_no($no_telp));
        $passwd = '#' . $_SESSION['phone_pass'];
        $html = "@ECHO OFF\r\n";
        $html .= "start C:\\valdodial.exe " . get_local_no($no_telp) . $passwd . "\r\n";
        $html .= "exit";
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=telp.bat");
        header("Content-Transfer-Encoding: binary");
        echo $html;
    }

    public function get_phone_value() {
        $data['primary_1'] = $this->input->post('primary_1', FALSE);
        $data['phone_no'] = preg_replace('/[^0-9.]*/', '', $this->input->post('phone_no', TRUE));
        $data['phone_type'] = $this->input->post('phone_type', TRUE);
        $data['username'] = $_SESSION['bsname_s'];
        $data['createdate'] = date('Y-m-d');
        return $data;
    }

    public function get_phone_no() {
        $id_phone = $this->input->post('id_phone');
        $phone_no = $this->input->post('phone_no');
        $i = 1;
        $i++;
        $no = 65 + $i;
        if (!empty($phone_no) && empty($id_phone)) {
            $data = $this->get_phone_value();
            $phone_no = $data['phone_no'];
            $id_last_phone = $this->call_track_model->insert_phone_no($data);
            $edit = level() == 'spv' ? '&nbsp;&nbsp;<a href="#" onclick="boxPopup(\'Edit Phone No\',\'' . site_url() . 'user/hdr_contact_cont/get_phone_no/edit/' . $id_last_phone . '\');return false;">Edit</a>&nbsp;&nbsp;<a href="javaScript:void(0);" onclick="deletePhone(\'' . site_url() . 'user/hdr_contact_cont/delete_phone/' . $id_last_phone . '\',\'' . $id_last_phone . '\')">Delete</td></tr>' : "";
            //echo '<tr class="listB"  id="phone_' . $id_last_phone . '"><td class="tit">' . $no . '.' . $data['phone_type'] . '</td><td>' . $data['phone_no'] . '<td class="call"><input type="button" value="Call" onclick="call(\'' . $data['phone_no'] . '\',\'04\')" /> &nbsp;&nbsp;<a class="title" id="no_under"  title="Created by : ' . $data['username'] . '|Created Date : ' . $data['createdate'] . '"     href="#" >Info</a>&nbsp;|&nbsp;' . $edit;
		 echo '<tr class="listB"  id="phone_' . $id_last_phone . '"><td class="tit">' . $no . '.' . $data['phone_type'] . '</td><td>' . $data['phone_no'] . '<td class="call">&nbsp;&nbsp;<a class="title" id="no_under"  title="Created by : ' . $data['username'] . '|Created Date : ' . $data['createdate'] . '"     href="#" >Info</a>&nbsp;|&nbsp;' . $edit;

        } elseif (!empty($id_phone)) {
            $data = $this->get_phone_value();
            $id_last_phone = $this->call_track_model->edit_phone_no($id_phone, $data);
            $edit = level() == 'spv' ? '&nbsp;&nbsp;<a href="#" onclick="boxPopup(\'Edit Phone No\',\'' . site_url() . 'user/hdr_contact_cont/get_phone_no/edit/' . $id_last_phone . '\');return false;">Edit</a>&nbsp;|&nbsp;<a href="javaScript:void(0);" onclick="deletePhone(\'' . site_url() . 'user/hdr_contact_cont/delete_phone/' . $id_last_phone . '\',\'' . $id_last_phone . '\')">Delete</td></tr>' : "";
            //echo '<tr class="listB"  id="phone_' . $id_phone . '"><td class="tit">' . $no . '.' . $data['phone_type'] . '</td><td>' . $data['phone_no'] . '<td class="call"><input type="button" value="Call" onclick="call(\'' . $data['phone_no'] . '\',\'04\')" /> &nbsp;&nbsp;<a class="title" id="no_under"  title="Created by : ' . $data['username'] . '|Created Date : ' . $data['createdate'] . '"     href="#" >Info</a>&nbsp;&nbsp;' . $edit;
 		echo '<tr class="listB"  id="phone_' . $id_phone . '"><td class="tit">' . $no . '.' . $data['phone_type'] . '</td><td>' . $data['phone_no'] . '<td class="call">&nbsp;&nbsp;<a class="title" id="no_under"  title="Created by : ' . $data['username'] . '|Created Date : ' . $data['createdate'] . '"     href="#" >Info</a>&nbsp;&nbsp;' . $edit;
        } else {
            $id_phone = $this->uri->segment(5);
            $data = $this->call_track_model->get_one_phone($id_phone);
            $data['action'] = 'add';
            $data['id_phone'] = $id_phone;
            $data['title'] = 'Add new Phone';
            $this->load->view('user/details/add_phone_popup', $data);
        }
    }

    public function get_address_value() {
        $data['primary_1'] = $this->input->post('primary_1', FALSE);
        $data['address'] = $this->input->post('address', TRUE);
        $data['zip_code'] = preg_replace('/[^0-9.]*/', '', $this->input->post('zip_code', TRUE));
        $data['city'] = $this->input->post('city');
        $data['type'] = $this->input->post('type');
        $data['is_tagih'] = $this->input->post('is_tagih');
        $data['phone_no'] = $this->input->post('phone_no');
        $data['id_user'] = id_user();
        $data['username'] = user_name();
        return $data;
    }

    public function get_address() {
        $id_address = $this->input->post('id_address');
        $address = $this->input->post('address');
        $edit = $this->uri->segment(4);
        if (!empty($address) && empty($id_address)) {
            $data = $this->get_address_value();
            $id_last_address = $this->call_track_model->insert_address($data);
            echo ' <tr class="listB" id="address_' . $id_last_address . '_a"><td class="tit">NEW ADDRESS</td><td style="font-weight:bold;">' . $data['address'] . '</td></tr> ';
            echo ' <tr class="listA" id="address_' . $id_last_address . '_b"><td class="tit">CITY</td><td style="font-weight:bold;">' . $data['city'] . '</td></tr> ';
            echo ' <tr class="listB" id="address_' . $id_last_address . '_c"><td class="tit">POS CODE</td><td style="font-weight:bold;">' . $data['zip_code'] . '</td></tr> ';
            echo ' <tr class="listA" id="address_' . $id_last_address . '_d"><td class="tit">ADDRESS TYPE</td><td style="font-weight:bold;">' . $data['type'] . '</td></tr> ';
            echo ' <tr class="listB" id="address_' . $id_last_address . '_e"><td class="tit">PHONE NO</td><td style="font-weight:bold;">' . $data['phone_no'] . '</td></tr> ';
            echo ' <tr class="listA" id="address_' . $id_last_address . '_f"><td class="tit">ALAMAT TAGIH</td><td style="font-weight:bold;">' . $data['is_tagih'] . '</td></tr> ';
            echo ' <tr class="listB" id="address_' . $id_last_address . '_g"><td class="tit">&nbsp;</td><td style="font-weight:bold;text-align:right;"> ';
            echo ' <a id="no_under" class="title" title="Created by : ' . $data['username'] . ' |Created Date : ' . date_now() . ' " href="#">Info</a> | ';
            echo ' <a href="#" onclick="boxPopup(\'Edit New Address\',\'' . site_url() . 'user/hdr_contact_cont/get_address/edit/' . $id_last_address . '/' . $data['address'] . '\');return false;">Edit</a> | ';
            echo ' <a href="#" onclick="deleteAddress(\'' . site_url() . 'user/hdr_contact_cont/delete_address/' . $id_last_address . '\',\'' . $id_last_address . '\')">Delete</a>&nbsp;</td></tr>';
            echo ' </tr><tr id="address_' . $id_last_address . '_g"><td>&nbsp;</td><td>&nbsp;</td></tr> ';
        } elseif (!empty($id_address)) {
            $data = $this->get_address_value();
            $id_last_address = $this->call_track_model->edit_phone_no($id_address, $data);
            echo ' <tr class="listB" id="address_' . $id_address . '_a"><td class="tit">NEW ADDRESS</td><td style="font-weight:bold;">' . $data['address'] . '</td></tr> ';
            echo ' <tr class="listA" id="address_' . $id_address . '_b"><td class="tit">CITY</td><td style="font-weight:bold;">' . $data['city'] . '</td></tr> ';
            echo ' <tr class="listB" id="address_' . $id_address . '_c"><td class="tit">POS CODE</td><td style="font-weight:bold;">' . $data['zip_code'] . '</td></tr> ';
            echo ' <tr class="listA" id="address_' . $id_address . '_d"><td class="tit">ADDRESS TYPE</td><td style="font-weight:bold;">' . $data['type'] . '</td></tr> ';
            echo ' <tr class="listB" id="address_' . $id_last_address . '_e"><td class="tit">PHONE NO</td><td style="font-weight:bold;">' . $data['phone_no'] . '</td></tr> ';
            echo ' <tr class="listA" id="address_' . $id_address . '_f"><td class="tit">ALAMAT TAGIH</td><td style="font-weight:bold;">' . $data['is_tagih'] . '</td></tr> ';
            echo ' <tr class="listB" id="address_' . $id_address . '_g"><td class="tit">&nbsp;</td><td style="font-weight:bold;text-align:right;"> ';
            echo ' <a id="no_under" class="title" title="Created by : ' . $data['username'] . ' |Created Date : ' . date_now() . ' " href="#">Info</a> | ';
            echo ' <a href="#" onclick="boxPopup(\'Edit New Address\',\'' . site_url() . 'user/hdr_contact_cont/get_address/edit/' . $id_address . '/\');return false;">Edit</a> | ';
            echo ' <a href="#" onclick="deleteAddress(\'' . site_url() . 'user/hdr_contact_cont/delete_address/' . $id_address . '\',\'' . $id_address . '\')">Delete</a>&nbsp;</td></tr>';
            echo ' </tr><tr id="address_' . $id_address . '_g"><td>&nbsp;</td><td>&nbsp;</td></tr> ';
        } else {
            $id_address = $this->uri->segment(5);
            $data = $this->call_track_model->get_one_address($id_address);
            $data['action'] = 'add';
            //print_r($data);
            $data['id_address'] = $id_address;
            $data['title'] = 'Add new Address';
            $this->load->view('user/details/add_address_popup', $data);
        }
    }

    public function delete_phone($id_phone) {
        $this->call_track_model->delete_phone($id_phone);
        echo 'Phone Has been deleted!';
    }

    public function delete_address($id_address) {
        $this->call_track_model->delete_address($id_address);
        echo 'Address Has been deleted!';
    }

    public function get_info($action) {
        $primary_1 = $this->input->post('primary_1', TRUE);
        $info = $this->input->post('info', TRUE);
        if ($action == 'add') {
            $data = $this->get_info_value();
            $id_last_info = $this->call_track_model->insert_info($data);
            echo '<tr class="listB" id="' . $primary_1 . '"><td class="tit"><div class="editInfo"id="' . $data['primary_1'] . '">' . $info . '</div>&nbsp;&nbsp;<a class="title" title="Created by : ' . $data['username'] . '|Created Date : ' . $data['createdate'] . '" id="no_under"     href="#" >Info</a></td></tr>';
        } elseif ($action == 'edit') {
            $data = $this->get_info_value();
            $id_last_info = $this->call_track_model->edit_info($data);
            echo $info;
        } elseif ($action == 'popup') {
            $primary_1 = $this->uri->segment(5);
            $data = $this->call_track_model->get_one_info($primary_1);
            //$data['info'] = $this->input->post('info', TRUE);
            $data['id_debtor_info'] = $primary_1;
            $data['title'] = 'Add new Info';
            $this->load->view('user/details/add_info_popup', $data);
        }
    }

    public function get_info_value() {
        $data['primary_1'] = $this->input->post('primary_1', TRUE);
        $data['info'] = $this->input->post('info', TRUE);
        $data['username'] = $_SESSION['bsname_s'];
        $data['createdate'] = date('Y-m-d H:i:s');
        return $data;
    }

    public function insert_calltrack() {
        //$this->output->enable_profiler("TRUE");
        $primary_1 = $_POST['primary_1'];

        $data = $this->data_call_record();
        //var_dump($data);
        //die();
        //print_r($data);
        //exit;
        if (isset($primary_1)) {
            $id_user = $data['id_user'];

            $sql_lock = "LOCK TABLES hdr_calltrack AS lock".$id_user." READ;";
            $sql = "SELECT id_calltrack FROM hdr_calltrack WHERE primary_1 = ? AND call_date = CURDATE()";
            $sql_unlock = "UNLOCK TABLES;";
            //$this->db->simple_query($sql_lock);
        		$query = $this->db->query($sql,array($primary_1));
						//$this->db->simple_query($sql_unlock);

						if(!$query || $query->num_rows() == 0){
							$this->call_track_model->insert_call_track($data, $insert = '1');
							$this->call_track_model->in_use_debtor($primary_1, $id_user, $not_ptp = 0);
							echo 'Case has been updated!';
          	}
						else {
							echo 'This case already submited by another DeskColl!';
						}

        }
    }

    public function skip_call() {
        $primary_1 = $_POST['primary_1'];

        $data = $this->data_call_record();
        if (isset($primary_1)) {
            $id_user = $data['id_user'];

            $this->call_track_model->insert_call_track($data, $insert = '1');

            echo 'Case has been updated!';
        }
    }

    public function data_call_record() {

        $ptp = $this->input->post('id_ptp', TRUE);
        $data['id_action_call_track'] = $this->input->post('id_action_call_track', TRUE);
        $data['id_handling_debt'] = $this->input->post('id_handling_debt', TRUE);
        $data['id_call_cat'] = $this->input->post('id_call_cat', TRUE);
        $data['id_location_code'] = $this->input->post('id_location_code', TRUE);
        $data['angsuran_ke'] = $this->input->post('angsuran_ke', TRUE);
        $data['location_code'] = $this->input->post('location_code', TRUE);
        $data['id_contact_code'] = $this->input->post('call_handling', TRUE);
        $data['id_ptp'] = $ptp=='1'?1:0;
        $data['deliquency_code'] = $this->input->post('id_contact_code', TRUE);
        $data['cname'] = strtoupper($this->input->post('cname', TRUE));
        $data['contact_code'] = $this->input->post('contact_code', TRUE);
        $data['id_risk_code'] = $this->input->post('id_risk_code', TRUE);
        $data['risk_code'] = $this->input->post('risk_code', TRUE);
        $data['code_call_track'] = $this->input->post('code_call_track', TRUE);
        $data['username'] = strtoupper($this->input->post('username', TRUE));
        $data['kode_cabang'] = strtoupper($this->input->post('kode_cabang', TRUE));
        $data['os_ar_amount'] = strtoupper($this->input->post('os_ar_amount', TRUE));
	$data['object_group'] = $this->input->post('object_group', TRUE);
	$data['score_result'] = $this->input->post('score_result', TRUE);
        //$data['region'] = $this->input->post('region', TRUE);
        //die("aaaaa".$data['region']);
        $remarks_raw = strtoupper($this->input->post('remarks', TRUE));
        // replacement on remarks
        $patterns_filter = array("/\\n/", "/\|/", '/\~/');
        $replacements = array(' ');
        $clean_remarks = preg_replace($patterns_filter, $replacements, $remarks_raw);
        $data['remarks'] = $clean_remarks;
        $data['primary_1'] = $this->input->post('primary_1', TRUE);
        $data['id_user'] = $this->input->post('id_user', TRUE);
        $data['id_spv'] = $_SESSION['bid_spv'];
        $data['surveyor'] = $this->input->post('surveyor', TRUE);
        $data['dpd'] = $this->input->post('dpd', TRUE);
        $data['no_contacted'] = $this->input->post('no_contacted', TRUE);
        $data['id_handling_code'] = $this->input->post('handling_code', TRUE);
        //echo $data['no_contacted'];
        $data['date_in'] = $this->input->post('date_in', TRUE);
        $data['call_date'] = date('Y-m-d');
        $data['call_time'] = date('H:i:s');
        $data['call_month'] = date('m');
        $today = date_now();
        $sum = strtotime(date("Y-m-d", strtotime("$today")) . " +3 days");
        $maxptpdate = date('Y-m-d', $sum);
        $ptp_d = $data['id_ptp']==1 ? $data['ptp_date'] = $this->input->post('ptp_date') : FALSE;
        //$incom = !empty($_POST['incomming']) ? $data['incomming'] = $this->input->post('incomming') : FALSE;
        $ptp_a =  $data['id_ptp']==1 ? $data['ptp_amount'] = $this->input->post('ptp_amount') : FALSE;
        $due_d = !empty($_POST['due_date']) ? $data['due_date'] = $this->input->post('due_date') : FALSE;
        $due_t = !empty($_POST['due_time']) ? $data['due_time'] = $this->input->post('due_time') : FALSE;
        $ptp_fu = !empty($_POST['ptp_fu']) ? $data['ptp_fu'] = $this->input->post('ptp_fu') : FALSE;
        $fu = !empty($_POST['fu']) ? $data['fu'] = $this->input->post('fu') : FALSE;
        //var_dump($data);
        //die();
        return $data;
    }

    public function data_contact_code() {
        return $data;
    }

    public function insert_sta() {
        //$this->output->enable_profiler("TRUE");
        $this->load->model('spv/hdr_sta_model', 'sta_model');
        $primary_1 = $_POST['primary_1'];
        //print_r($_POST);
        if (isset($primary_1)) {
            $data = $this->sta_record();
            $data['primary_1'] = $primary_1;
            $this->sta_model->insert_sta($data);
            echo 'STA Case has been added!';
        }
    }

    public function insert_agen_track() {
        //$this->output->enable_profiler("TRUE");
        $primary_1 = $_POST['primary_1'];
        //print_r($_POST);
        if (isset($primary_1)) {
            $data = $this->agen_record();
            $data['primary_1'] = $primary_1;
            $this->call_track_model->insert_agen_track($data);
            echo 'Agen  Case has been updated!';
        }
    }

    public function agen_record() {
        $data['id_action_agen_track'] = $this->input->post('id_action_agen_track', TRUE);
        $data['action_code'] = $this->input->post('action_code', TRUE);
        $data['username'] = $this->input->post('username', TRUE);
        $data['id_user'] = $this->input->post('id_user', TRUE);
        $data['remark'] = $this->input->post('remarks_agen', TRUE);
        $data['no_contacted'] = $this->input->post('no_contacted', TRUE);
        $data['ptp_amount'] = !empty($_POST['ptp_amount_agen']) ? $data['ptp_amount'] = $this->input->post('ptp_amount_agen') : FALSE;
        $data['ptp_date'] = !empty($_POST['ptp_date_agen']) ? $data['ptp_date'] = $this->input->post('ptp_date_agen') : FALSE;
        $data['visit_date'] = $this->input->post('visit_date', TRUE);
        ;
        $data['time'] = $this->input->post('time', TRUE);
        $data['date_in'] = $this->input->post('date_in', TRUE);
        return $data;
    }

    public function sta_record() {
        $data['username'] = $this->input->post('username', TRUE);
        $data['id_user'] = $this->input->post('id_user', TRUE);
        $data['createdate'] = date('Y-m-d H:i:s');
        $data['date'] = date('Y-m-d');
        return $data;
    }

    public function hist_payment($primary_1, $name) {

			//Update payment
			/*
      $db_finansia = $this->load->database('db_finansia', TRUE);

			$today = date('Y-m-d');
      $sql = "SELECT ID,AgreementNo, convert(varchar, DateTransaction, 120) as trx_date,
          convert(varchar, DateTimeUpdate, 120) as update_date,AngsuranKe,
          Amount,JenisTransaksi
          FROM PaymentTypeValdo where month(DateTransaction)=month(getdate()) and year(DateTransaction)=year(getdate()) order by DateTransaction ";
      //die($sql);
      $query = $db_finansia->query($sql);

			if($query->num_rows() > 0)
			{
	      foreach ($query->result() as $row)
	      {
	          $sql = "INSERT IGNORE INTO  `finansia_collection`.`hdr_payment` (`primary_1` ,`trx_date` ,update_date ,`angsuran_ke` ,`amount` ,`description` ,`create_date`) VALUES (
							'" . $row->AgreementNo . "',  '" . $row->trx_date . "' , '" . $row->update_date . "', '" . $row->AngsuranKe . "', '" . $row->Amount . "','" . $row->JenisTransaksi . "',CURRENT_TIMESTAMP);
							 ";
	          //die($sql);
	          $this->db->query($sql);
	      }
			}
			*/

        $data['pop_title'] = 'History Payment';
        $this->load->helper('flexigrid');
        $this->load->model('hdr/hdr_load_ajax_model', 'load_ajax');
        $data = $this->load_ajax->get_history_payment($primary_1, $name);
        $data['text'] = "History Payment";
        $data['primary_1'] = $primary_1;
        $data['hist_type'] = 'payment';
        $this->load->view('hdr/hdr_pop_up_view', $data);
    }

    public function view_payment($primary_1) {
        $this->db_finansia = $this->load->database('db_finansia', TRUE);
        $sql = "SELECT *,convert(varchar, DateTransaction, 120) as trx_date,convert(varchar, DateTimeUpdate, 120) as update_date FROM vzPaymentTypeValdo WHERE AgreementNo = '$primary_1'";
        $sql2 = "SELECT TOP 30  * FROM vzPaymentTypeValdo WHERE DateTransaction = '2011-05-04' ORDER BY DateTransaction DESC ";
        $query = $this->db_finansia->query($sql);
        $data = $query->result();
        foreach ($data as $row) {
            $row->trx_date;
        }
        print_r($data);
    }

    public function insert_payment() {
        $this->db_finansia = $this->load->database('db_finansia', TRUE);
        $sql = "SELECT   ID,AgreementNo,convert(varchar, DateTransaction, 120) as trx_date, convert(varchar, DateTimeUpdate, 120) as update_date,AngsuranKe,
            Amount,JenisTransaksi
            FROM PaymentTypeValdo WHERE DateTransaction = '".date('Y-m-d')."'";
        //die($sql);
        $query = $this->db_finansia->query($sql);
        $data = $query->result();
        foreach ($data as $row) {
            $sql = "INSERT IGNORE INTO  `finansia_collection`.`hdr_payment` (`id_payment`,
`primary_1` ,`trx_date` ,update_date ,`angsuran_ke` ,`amount` ,`description` ,`create_date`) VALUES (
'".$row->ID."' ,'" . $row->AgreementNo . "',  '" . $row->trx_date . "' , '" . $row->update_date . "', '" . $row->AngsuranKe . "', '" . $row->Amount . "','" . $row->JenisTransaksi . "',CURRENT_TIMESTAMP);
 ";
            //die($sql);
            $this->db->query($sql);
        }
        echo 'Success';
    }

    public function hist_call_track($primary_1, $id_action_call_track, $name) {
        $data['pop_title'] = 'History Call Track';
        $this->load->helper('flexigrid');
        //$id_action_call_track ='All';
        $this->load->model('hdr/hdr_load_ajax_model', 'load_ajax');
        $data = $this->load_ajax->get_history_call_track($primary_1, $id_action_call_track, $name);

        $data['text'] = "History Calltrack";
        $data['primary_1'] = $primary_1;
        $data['hist_type'] = 'call_track';
        //var_dump($data);
        //die();
        $this->load->view('hdr/hdr_pop_up_view', $data);
    }

    public function hist_user_call_track($id_action_call_track, $begindate, $enddate) {
        $data['pop_title'] = 'History Call Track';
        $this->load->helper('flexigrid');
        $id_user = $_SESSION['bid_user_s'];
        //$id_action_call_track ='All';
        //echo 'ctrl'.$begindate;
        $this->load->model('hdr/hdr_load_ajax_model', 'load_ajax');
        //echo $id_action_call_track.$id_user.$begindate.$enddate;
        $data = $this->load_ajax->get_history_user_call_track($id_action_call_track, $id_user, $begindate, $enddate);
        $data['text'] = "History Calltrack";
        $this->load->view('hdr/hdr_pop_up_view', $data);
    }

    public function hist_reschedule($primary_1, $name) {
        $data['pop_title'] = 'History Reschedule';
        $this->load->helper('flexigrid');
        $this->load->model('hdr/hdr_load_ajax_model', 'load_ajax');
        $data = $this->load_ajax->get_history_reschedule($primary_1, $name);
        $data['text'] = "History Reschedule";
        $this->load->view('hdr/hdr_pop_up_view', $data);
    }

    public function hist_agen_track($primary_1, $name) {
        $data['pop_title'] = 'History Agen Track';
        $this->load->helper('flexigrid');
        $this->load->model('hdr/hdr_load_ajax_model', 'load_ajax');
        $data = $this->load_ajax->get_history_agen_track($primary_1, $name);
        $data['text'] = "History Reschedule";
        $data['primary_1'] = $primary_1;
        $data['hist_type'] = 'monitor_agen';
        $this->load->view('hdr/hdr_pop_up_view', $data);
    }

    function sp() {
        $this->load->library('cezpdf');
        $this->load->helper('pdf');
        prep_pdf();
        $mainFont = './fonts/Helvetica.afm';
        $this->cezpdf->selectFont($mainFont);
        $this->cezpdf->ezSetDy(-10);
        $get_details = $this->uri->segment(5);
        $sp = $this->uri->segment(4);
        //echo $sp;
        $details = base64_decode($get_details);
        $det = explode('&', $details);
        $name = $det[0];
        $address = wordwrap($det[1], 40, "\n", true);
        $phone_no = $det[2];
        $card_no = $det[3];
        $debt_amount = 'Rp ' . price_format($det[4]);
        $balance = 'Rp ' . price_format($det[5]);
        $gender = $det[6];
        $letter_type;
        $jk = $gender == 'MALE' ? 'Bapak' : 'Ibu';
        $header = "JL. Raden Saleh I No. 3A Jakarta 10340,Phone 021 31990588 Fax 021 3900005.\n\n";
        $header .= "001/SPI/COLL-CC/02/2007";
        $yth = "Yth, Bapak/Ibu\n\n";
        $yth .= $name;
        $body = 'Dengan hormat';
        //$alamat .= "SUDIRMAN KAV.32 - 10220";
        if ($sp == 'sp1' || $sp == 'sp2') {
            $body .= "\n\n";
            $body .= "Sehubungan dengan keterlambatan Bapak/Ibu melaksanakan kewajiban dan tanggung jawab \n";
            $body .= "atas Kartu Kredit Bank Bumiputera sebagai berikut: \n\n";
        } elseif ($sp == 'sp3') {
            $body .= "\n\n";
            $pri_sp = 'III';
            $body .= "Sampai saat ini kami belum menerima pembayaran kartu kredit Bank Bumiputera Bapak/Ibu, \nmenindak lanjuti surat peringatan sebelumnya, kami tegaskan untuk segera menyelesaikan \nkewajiban sebagai berikut : \n\n";
            $content = "Mohon perhatian kepada  Bapak/Ibu  untuk segera melunasi kewajiban tersebut. Untuk \nketerangan lebih lanjut silahkan hubungi kami dengan nomor telepon 021-31990588 dan\n021-31990577  \n\n";
        }
        if ($sp == 'sp1') {
            $pri_sp = '';
            $content = "Kami mohon pengertian Bapak/Ibu  untuk segera melunasi minimum pembayaran yang \n";
            $content .= "tertunggak. Mohon maaf atas ketidaknyaman  Bapak/Ibu atas surat ini dan apabila sudah\n";
            $content .= "melakukan pembayaran harap diabaikan. Untuk keterangan lebih lanjut silahkan hubungi\n";
            $content .= "kami dengan nomor telepon 021-31990588 dan 021-31990577 \n\n";
        } elseif ($sp == 'sp2') {
            $pri_sp = 'II';
            $content = "Kami mohon perhatian kepada  Bapak/Ibu untuk segera melunasi kewajiban tersebut. Untuk \nketerangan lebih lanjut silahkan hubungi kami dengan nomor telepon  021-31990588 dan \n021-31990577 \n\n";
        }
        $content .= "Demikian surat ini kami buat, atas perhatiannya kami ucapkan terima kasih \n\nAtas kerjasama dan perhatiannya kami ucapkan terima kasih";
        $data = array(
            array('num' => 1, 'name' => 'No Kartu', 'type' => ': ' . $card_no)
            , array('num' => 2, 'name' => 'Nama', 'type' => ': ' . $name)
            , array('num' => 3, 'name' => 'Total Tagihan', 'type' => ': ' . $balance)
            , array('num' => 4, 'name' => 'Minimum Pembayaran', 'type' => ': ' . $debt_amount)
        );
        $img = ImageCreatefromjpeg(base_url() . 'assets/images/bp.jpg');
        $this->cezpdf->addImage($img, 50, 780, 200, 50, 100);
        $this->cezpdf->ezText($header, 8);
        $this->cezpdf->ezText("\n" . $yth, 13);
        $this->cezpdf->ezText("\n\n" . $address, 10);
        $this->cezpdf->ezText("\n\n\n" . '<b>Perihal : Surat Peringatan ' . $pri_sp . '</b>', 10);
        $this->cezpdf->setLineStyle(2, 1);
        $this->cezpdf->line(500, 767, 50, 767);
        $this->cezpdf->ezText("\n\n\n" . $body, 11, array('justification' => 'left'));
        //$this->cezpdf->ezTable($data);
        $this->cezpdf->ezTable($data, array('name' => '', 'type' => ''), '', array('xPos' => 'left', 'xPos' => 185, 'showHeadings' => 0, 'shaded' => 0, 'showLines' => 0));
        $this->cezpdf->ezText("\n" . $content, 11, array('justification' => 'left'));
        $this->cezpdf->ezText("\n\n\n\n\n" . '<b>Hormat  Kami ,</b>', 11, array('justification' => 'left'));
        $this->cezpdf->ezText("\n\n\n\n\n" . '<b><u>COLLECTION BUMIPUTERA</u></b>', 12, array('justification' => 'left'));
        $this->cezpdf->stream(array('Content-Disposition' => $sp));
    }

    public function action_code_wom($primary_1="") {
        //$this->output->enable_profiler("TRUE");
        $data['last_action_code_wom'] = $this->call_track_model->get_action_code_wom($primary_1);
        $this->load->view('user/details/last_action_code_wom', $data);
    }

    /* Martin Add for prevent double call */
		public function checkRealTimeLock(){

		$id_user = $_SESSION['bid_user_s'];
		$primary_1 = $this->input->post('primary_1',TRUE);

		## Initial Value
		$is_allow = 0;

			if($primary_1){
				$is_allow = $this->call_track_model->checkUserLock($primary_1,$id_user);
			}

			echo $is_allow;
		}

		/* Martin-> add callback function */
		public function submitCallback(){

    	$primary_1 = $this->input->post('primary_1',TRUE);
    	$id_user = $this->input->post('id_user',TRUE);
    	$notes = $this->input->post('notes',TRUE); $notes = preg_replace('![\\r\\n]!',' ',$notes);
    	$time_remind = $this->input->post('time_remind',TRUE);
    	$today = date("Y-m-d");
    	$remind_at_prefix = $today.' '.$time_remind.':00';

    	$is_overlimit  = $this->checkCallbackLimit($id_user, $limit = 10);

    	if($is_overlimit > 0){
    		echo -1;
    		die();
    	}

    	$insert_data = array(
    		'primary_1' => $primary_1,
    		'user_id' => $id_user,
    		'remind_at' => $remind_at_prefix,
    		'notes' => $notes,
    		'data_date' => $today
    	);

    	$insert_str = $this->db->insert_string('reminder_history',$insert_data);
    	$this->db->query($insert_str);
    	$insert_id = $this->db->insert_id();



    	## SET called 2 for data remainder
    	$sql_lock = "LOCK TABLES hdr_debtor_main AS lock".$id_user." WRITE;";
    	$sql = "UPDATE hdr_debtor_main AS lock".$id_user." SET called = 2 WHERE primary_1 = '".$primary_1."' LIMIT 1;";
    	$sql_unlock = "UNLOCK TABLES;";

    	$this->db->simple_query($sql_lock);
    	$this->db->simple_query($sql);
    	$this->db->simple_query($sql_unlock);

    	echo $insert_id;
    }

    /* Martin Add for callback */
    public function fetch_reminder($method,$primary_1){
    	$id_user = $_SESSION['bid_user_s'];

    	if($method == 'call'){
    		$sql_lock = "LOCK TABLES hdr_debtor_main AS lock".$primary_1." WRITE;";
    		$sql_lock_2 = "LOCK TABLES reminder_history AS lock".$primary_1." WRITE;";
    		$sql = "UPDATE hdr_debtor_main AS lock".$primary_1." SET called = 0,id_user = $id_user, in_use = 1 WHERE primary_1 = '$primary_1' LIMIT 1";
    		$sql_2 = "UPDATE reminder_history AS lock".$primary_1." SET is_done = 1 WHERE is_done = 0 AND data_date = CURDATE() AND primary_1 = '$primary_1' LIMIT 1";
    		$sql_unlock = "UNLOCK TABLES";

    		$this->db->simple_query($sql_lock);
    		$this->db->simple_query($sql);
    		$this->db->simple_query($sql_unlock);
    		$this->db->simple_query($sql_lock_2);
    		$this->db->simple_query($sql_2);
    		$this->db->simple_query($sql_unlock);
    		$encoded_primary = base64_encode($primary_1."_".date("i"));
    		redirect('user/hdr_contact_cont/contact/call/' . $encoded_primary);
    	}
    	else if($method == 'paid'){
    		$sql_lock = "LOCK TABLES reminder_history AS lock".$primary_1." WRITE;";
    		$sql = "UPDATE reminder_history AS lock".$primary_1." SET is_done = 1 WHERE is_done = 0 AND data_date = CURDATE() AND primary_1 = '$primary_1' LIMIT 1";
    		$sql_unlock = "UNLOCK TABLES";

    		$this->db->simple_query($sql_lock);
    		$this->db->simple_query($sql);
    		$this->db->simple_query($sql_unlock);
    		redirect('user/hdr_contact_cont/contact/call/');
    	}

    }

    public function checkCallbackLimit($id_user, $limit){
    		$this->db->where('data_date', date("Y-m-d"));
    		$this->db->where('is_done', 0);
    		$this->db->where('user_id', $id_user);
    		$this->db->select('COUNT(id_reminder) AS listing', FALSE);

    		$qryObj = $this->db->get('reminder_history');
    		$qryRes = $qryObj->row_array();

    		$listing = ($qryRes['listing']*1);
    		$is_overlimit = 0;
    			if($listing > $limit){
    				$is_overlimit = 1;
    			}
    		return $is_overlimit;
   }

}
?>
