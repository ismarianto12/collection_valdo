<?php

  class Hdr_security_model extends Model {

      function __construct() {
          parent::Model();
          $this->load->model('admin/hdr_user_model', 'user_model');
      }

      public function is_online($get_user) {
          $sql = "SELECT username, passwd, last_login, SUBTIME( NOW( ) , '1:00:00.000000' ) AS 'hour_ago'
				FROM hdr_user WHERE username='" . $get_user['username'] . "'
				AND passwd='" . md5($get_user['password']) . "'
				AND blocked='0'
				AND last_login < 'hour_ago'";
	  //echo $sql;
          $query = $this->db->query($sql);
          $online = $query->num_rows();
          return true;
      }

      public function is_block($get_user) {
          $query = $this->db->get_where('hdr_user', array('username' => $get_user));
          $data = $query->row();
          return @$data->blocked;
      }

      function login($get_user) {
          $sql = 'SELECT * FROM hdr_user WHERE username="' . $get_user['username'] . '" AND passwd="' . md5($get_user['password']) . '" AND blocked="0"';
          $query = $this->db->query($sql);
          $data = $query->row();
          if (!empty($data)) {
              //$detail_level = $this->user_model->get_list_level('id_level="'.$data->id_level.'"');
              $sql2 = "SELECT * FROM  hdr_level WHERE id_level ='" . $data->id_level . "'   ";
              $query2 = $this->db->query($sql2);
              //die($sql2);
              $detail_level = $query2->row();

              $filtering = $data->filter_debtor != '' ? $data->filter_debtor : 'WHERE hdm.primary_1 !="0"';
              $_SESSION['bsname_s'] = $data->username;
              $_SESSION['bid_user_s'] = $data->id_user;
              $_SESSION['bid_spv'] = $data->id_leader;
              $_SESSION['filter_debtor'] = '  ' . $filtering;
              $_SESSION['last_login'] = date('Y-m-d H:i:s');
              $_SESSION['fullname'] = $data->fullname;
              $_SESSION['blevel'] = $detail_level->level;
              $_SESSION['bidlevel'] = $data->id_level;
              $_SESSION['phone_pass'] = $data->phone_pass;
              $_SESSION['local_no'] = $data->local_no;
              $_SESSION['shift'] = $data->shift;
              $_SESSION['is_reminder'] = $data->is_reminder;
              $_SESSION['keep'] = 'keep';
              $_SESSION['broken'] = 'broken';
              $new_log['user_status'] = 'online';
              $new_log['last_login'] = $_SESSION['last_login'];

              //print_r($_SESSION);
              $this->db->update('hdr_user', $new_log, array('id_user' => $_SESSION['bid_user_s']));
              $this->producivity($call = 0, $work = 0, $contact = 0, $no_contact = 0, $ptp = 0);
              $last_id = $this->absen($_SESSION['bid_user_s'], 1);
              $_SESSION['last_attend_id'] = $last_id;
              return true;
          } else {
              return false;
          }
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
                    SET hua.id_user = '$id_user', hua.username = hu.username, hua.logout_time = '" . get_now() . "', hua.attempt = hua.attempt+1
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

      public function producivity($call, $work, $contact, $no_contact, $ptp) {
          $month = date('n');
          $day = date('j');
          $id_user = $_SESSION['bid_user_s'];
          $username = $_SESSION['bsname_s'];
          $select_sql = "SELECT *,max(id_productivity) as max_prod FROM hdr_call_productivity WHERE id_user ='$id_user' AND date ='" . date_now() . "' ";
          $query_select = $this->db->query($select_sql);
          $last_prod_id = $query_select->row();
          if (!empty($last_prod_id->id_productivity) && date_now() == $last_prod_id->date) {
              $this->clear_ptp_status();
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
                    SET hcp.keep = (SELECT COUNT(DISTINCT hc.primary_1)  FROM hdr_calltrack  hc WHERE hc.ptp_status ='2' AND hc.id_user ='" . $id_user . "' AND hc.id_action_call_track ='28'  AND hc.call_month='" . month_now() . "')
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

      function logout() {
          $data->user_status = 'offline';
          $data->last_logout = date('Y-m-d H:i:s');
          $this->db->update('hdr_user', $data, array('id_user' => @$_SESSION['bid_user_s']));
          //$this->session->sess_destroy();
          $this->absen($_SESSION['bid_user_s'], 2);
          session_destroy();
          return true;
      }

      function insert_loginstatus($user_id, $username = 'Anonymous', $type = '', $status = '', $code=NULL){

      	$toInsert = array(
      		'user_id'=> $user_id,
      		'user_name'=> $username,
      		'type'=> $type,
      		'status'=> $status,
      		'curdate'=> DATE('Y-m-d'),
            'code'=> $code
      	);

      	$this->db->insert('access_log', $toInsert);

      }


  }

?>
