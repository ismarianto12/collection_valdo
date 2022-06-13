<?php

class Hdr_spv_debtor_model extends Model {

	function model_debtor() {
	    parent::Model();
	}

  function all_debtor($is_approved, $begindate, $enddate)
	{
		$spv_id = @$_SESSION['bid_user_s'] ? @$_SESSION['bid_user_s'] : '';
		$data = array();
		$this->db->order_by('id_phone','asc');

		$where = "";
		$where .= $is_approved == '-' ? " and (aa.is_approved is null or aa.is_approved=0) " : "";
		$where .= $is_approved == '1' ? " and aa.is_approved=1 " : "";
		$where .= $is_approved == '2' ? " and aa.is_approved=2 " : "";
		$where .= $spv_id > 1 ? " and hu.id_leader=$spv_id " : "";

		if($begindate != '' && $enddate != '')
		{
			$where .= " and aa.createdate between '$begindate' and '$enddate' ";
		}

		//die("eheheheh" . $begindate . ' ' . $enddate);

		$sql = "SELECT aa.id_phone, aa.username, aa.primary_1, aa.phone_type,
			aa.phone_no, aa.createdate,
			CASE
			WHEN aa.is_approved=1 THEN 'Approved'
			WHEN aa.is_approved=2 THEN 'Rejected'
			ELSE 'Pending'
			END AS xstatus, bb.name as card_holder_name
			FROM hdr_debtor_phone_no aa, hdr_debtor_main bb, hdr_user hu
			where aa.primary_1=bb.primary_1
			and aa.username=hu.username
			$where ";
		//die($sql);
		$query=$this->db->query($sql);

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$data[] = $row;
			}
			$query->free_result();
			return $data;
		}
	}

  function all_debtor_memo($is_approved, $begindate, $enddate)
	{
		$data = array();
		$this->db->order_by('id','asc');

		$where = "";
		$where .= $is_approved == '-' ? " and (aa.is_approved is null or aa.is_approved=0) " : "";
		$where .= $is_approved == '1' ? " and aa.is_approved=1 " : "";
		$where .= $is_approved == '2' ? " and aa.is_approved=2 " : "";
		$where .= $is_approved == '3' ? " and aa.is_approved=3 " : "";

		if($begindate != '' && $enddate != '')
		{
			$where .= " and aa.createdate between '$begindate' and '$enddate' ";
		}

		//die("eheheheh" . $begindate . ' ' . $enddate);

		$sql = "SELECT aa.id, aa.username, aa.primary_1, aa.usulan,
			aa.amt_discount, aa.percent_discount, aa.remarks, aa.createdate,
			CASE
			WHEN aa.is_approved=1 THEN 'Approved'
			WHEN aa.is_approved=2 THEN 'Rejected'
			WHEN aa.is_approved=3 THEN 'Paid Off'
			ELSE 'Pending'
			END AS xstatus, bb.card_holder_name, bb.accno, bb.balance
			FROM hdr_debtor_bdo aa, hdr_debtor_main bb
			where aa.primary_1=bb.primary_1
			and date(aa.createdate) between '$begindate' and '$enddate'";
		//die($sql);
		$query=$this->db->query($sql);

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{

				$sisa_amount = 0;
				$paid_amount = 0;

				$accno = $row['accno'];
				//cari payment ptp
				$sql_ptp = "
					select sum(amount) as amt_payment
					from hdr_payment hp, hdr_debtor_main hdm, hdr_assignment ha
					where hdm.accno=hp.card_no
					and hdm.primary_1=ha.primary_1
					and hdm.accno=$accno";
				$q_ptp = $this->db->query($sql_ptp);

				if($q_ptp->num_rows() > 0)
				{
					$int_amount = 0;
					$row_ptp = $q_ptp->row_array();
					$paid_amount = $row_ptp['amt_payment'];
				}

				$usulan = $row['usulan'];
				$sisa_amount = $usulan - $paid_amount;

				$row['sisa_amount'] = $sisa_amount;
				$row['paid_amount'] = $paid_amount;

				$data[] = $row;
			}
			$query->free_result();

			//var_dump($data);
			//die();
			return $data;
		}
	}
	function search_debtor_memo($is_approved, $begindate, $enddate)
	{
		$data = array();
		$this->db->order_by('id','asc');

		$where = "";
		/*
		$where .= $is_approved == '-' ? " and (aa.is_approved is null or aa.is_approved=0) " : "";
		$where .= $is_approved == '1' ? " and aa.is_approved=1 " : "";
		$where .= $is_approved == '2' ? " and aa.is_approved=2 " : "";
		$where .= $is_approved == '3' ? " and aa.is_approved=3 " : "";
		*/

		if($begindate != '' && $enddate != '')
		{
			$where .= " and date(aa.createdate) between '$begindate' and '$enddate' ";
		}

		//die("eheheheh" . $begindate . ' ' . $enddate);

		$sql = "SELECT aa.id, aa.username, aa.primary_1, aa.usulan,
			aa.amt_discount, aa.percent_discount, aa.remarks, aa.createdate,
			CASE
			WHEN aa.is_approved=1 THEN 'Approved'
			WHEN aa.is_approved=2 THEN 'Rejected'
			WHEN aa.is_approved=3 THEN 'Paid Off'
			ELSE 'Pending'
			END AS xstatus, bb.card_holder_name, bb.accno, bb.balance
			FROM hdr_debtor_bdo aa, hdr_debtor_main bb
			where aa.primary_1=bb.primary_1 $where group by aa.primary_1";
		//die($sql);
		$query=$this->db->query($sql);

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$sisa_amount = 0;
				$paid_amount = 0;

				$accno = $row['accno'];
				//cari payment ptp
				$sql_ptp = "
					select sum(amount) as amt_payment
					from hdr_payment hp, hdr_debtor_main hdm, hdr_assignment ha
					where hdm.accno=hp.card_no
					and hdm.primary_1=ha.primary_1
					and hdm.accno=$accno";
				$q_ptp = $this->db->query($sql_ptp);

				if($q_ptp->num_rows() > 0)
				{
					$int_amount = 0;
					$row_ptp = $q_ptp->row_array();
					$paid_amount = $row_ptp['amt_payment'];
				}

				$primary_1 = $row['primary_1'];
				$sql_ct = "select ptp_date from hdr_calltrack where primary_1='$primary_1'
					and ptp_date is not null
					and month(ptp_date)=month(now())
					and year(ptp_date)=year(now())
					limit 1";
				$q_ct = $this->db->query($sql_ct);

				$ptp_date = "";
				if($q_ct->num_rows() > 0)
				{
					$row_ct = $q_ct->row_array();
					$ptp_date = $row_ct['ptp_date'];
				}

				$usulan = $row['usulan'];
				$sisa_amount = $usulan - $paid_amount;

				$row['sisa_amount'] = $sisa_amount;
				$row['paid_amount'] = $paid_amount;
				$row['ptp_date'] = $ptp_date;

				$data[] = $row;
			}
			$query->free_result();
			return $data;
		}
	}


	function get_list_debtor()
	{
		$sql = "SELECT * FROM hdr_debtor_phone_no  ORDER BY id_phone ASC";
		return $query = $this->db->query($sql);
	}

	function get_list_debtor_bdo()
	{
		$sql = "SELECT * FROM hdr_debtor_bdo  ORDER BY id ASC";
		return $query = $this->db->query($sql);
	}

	function get_debtor($id_phone)
	{
		$query = $this->db->get_where('hdr_debtor_phone_no',array('id_phone'=>$id_phone))	;
		return $query->row();
	}

	function get_debtor_bdo($id)
	{
		$this->db->join('hdr_user','hdr_user.username=hdr_debtor_bdo.username');
		$this->db->join('hdr_debtor_main','hdr_debtor_bdo.primary_1=hdr_debtor_main.primary_1');
		$this->db->join('hdr_debtor_main_temp','hdr_debtor_main.primary_1=hdr_debtor_main_temp.primary_1');
		$query = $this->db->get_where('hdr_debtor_bdo',array('id'=>$id))	;
	  return $query->row();
	}

	function edit_debtor($data)
	{
		$where = "id_phone = ".$data['id_phone']."";
		$sql = $this->db->update_string('hdr_debtor_phone_no', $data, $where);
		return $this->db->query($sql);
		//die($this->db->last_query());
	}

	function edit_debtor_bdo($data)
	{
		$where = "id = ".$data['id']."";
		$sql = $this->db->update_string('hdr_debtor_bdo', $data, $where);
		$q1 = $this->db->query($sql);

		//update is_paid
		//$data['is_approved'] = 3;
		if($data['is_approved'] == 3)
		{
			$id = $data['id'];
			$sql2 = "select primary_1 from hdr_debtor_bdo where id=$id";
			$q2 = $this->db->query($sql2);

			$row2 = $q2->row_array();
			$primary_1 = $row2['primary_1'];
			$sql3 = "update hdr_debtor_main set is_paid=1 where primary_1='$primary_1'";
			$this->db->query($sql3);
		}

		//die($this->db->last_query());

		return $q1;
	}

  function all_debtor_assignment($id_user, $begindate, $enddate, $card_holder_name)
	{
		$data = array();
		$this->db->order_by('created','desc');

		$where = "";
		$where .= $id_user != '-' ? " and aa.id_user=$id_user " : "";
		$where .= $card_holder_name != '-' ? " and hdm.card_holder_name like '%$card_holder_name%' " : "";

		if($begindate != '-' && $enddate != '-')
		{
			$where .= " and date(aa.created) between '$begindate' and '$enddate' ";
		}

		//die("eheheheh" . $begindate . ' ' . $enddate);

		$sql = "SELECT aa.*, aa.created as assignment_date, hdm.*, hu.username as user_assign
			FROM hdr_assignment aa, hdr_debtor_main hdm, hdr_user hu
			where aa.primary_1=hdm.primary_1 and aa.is_active=1
			and aa.id_user=hu.id_user
			$where limit 100";
		//die($sql);
		$query=$this->db->query($sql);

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$data[] = $row;
			}
			$query->free_result();
		}

		return $data;

	}

	function get_users($spv_id)
	{
		$sql = "select * from hdr_user where id_leader=$spv_id";
		$q = $this->db->query($sql);

		$data = array();
		if($q->num_rows() > 0)
		{
			foreach($q->result_array() as $row)
			{
				$data[] = $row;
			}
		}
		$q->free_result();
		return $data;
	}
	function createNewAssignment($bucket,$transDest)
{
	$data_insert = array(
	'primary_1'=> $bucket[0],
	'id_user'=> $transDest,
	'is_active'=> 1,
	'created'=> date("Y-m-d h:i:s")
	);

	$ins_str = $this->db->insert_string('hdr_assignment',$data_insert);
	$this->db->query($ins_str);
}
function updateLastAssignment($bucket)
{
	$data_update = array(
	'is_active'=> 0,
	);
	$this->db->where('primary_1',$bucket[0]);
	$this->db->where('id_user',$bucket[1]);
	$this->db->where('is_active',1);
	$this->db->update('hdr_assignment',$data_update);
}

 function all_debtor_payment($trx_date = '', $start_date = '', $finish_date = '')
	{
		$arr_result = array();

		//utk paging
		$sql = "SELECT hp.trx_date,count(*) as total
			FROM hdr_payment hp
			WHERE month(hp.trx_date)=month(now())-1 and year(hp.trx_date)=year(now())
			group by hp.trx_date
			order by trx_date";
		$query = $this->db->query($sql);

		$data = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$data[] = $row;
			}
			$query->free_result();
		}

		$arr_result['paging'] = $data;

		//mencari tanggal trx data awal bulan
		$sqlmin = "SELECT min(hp.trx_date) as mindate
		FROM hdr_payment hp
		WHERE month(hp.trx_date)=month(now()) and year(hp.trx_date)=year(now())";
		$q_min = $this->db->query($sqlmin);
		$row_min = $q_min->row_array();
		$min_date = $row_min['mindate'];

		//where
		$where = "";
		$where .= $trx_date != "ALL" && $trx_date != "" ?
			" and hp.trx_date='$trx_date' " : "";
		$where .= $trx_date == "ALL" && ($start_date == '' && $finish_date == '') ? " and year(hp.trx_date)=year(now()) and month(hp.trx_date)=month(now()) " : "";
		$where .= $trx_date == "" ? " and hp.trx_date='$min_date' " : "";

		$where .= $start_date != '' && $finish_date != '' ? " and hp.trx_date between '$start_date' and '$finish_date' " : "";

		//utk tampilan list
		$sql = "select hp.trx_date,hp.card_no,hp.amount,hp.description,hp.createdate,hdm.card_holder_name, hu.username, hu.fullname, hp.fiche_ref
		from hdr_payment hp, hdr_debtor_main hdm
		left join hdr_user hu on hdm.used_by=hu.id_user
		where hp.card_no=hdm.accno $where order by trx_date,hdm.card_holder_name ";
		//echo $sql;
		$query = $this->db->query($sql);

		$data = array();
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$data[] = $row;
			}
			$query->free_result();
		}

		$arr_result['data'] = $data;

		return $arr_result;
	}

	 function search_debtor_payment($id_user, $begindate, $enddate, $card_no)
	{
		$this->load->library('pagination');
		$data = array();
		$this->db->order_by('createdate','desc');

		$where = "";
		$where .= $card_no != '-' ? " and hp.card_no like '%$card_no%' " : "";
		$where .= $id_user != '-' ? " and hu.id_user=$id_user " : "";


		if($begindate != '-' && $enddate != '-')
		{
			$where .= " and date(hp.trx_date) between '$begindate' and '$enddate' ";
		}

		//die("eheheheh" . $begindate . ' ' . $enddate);

		$sql = "SELECT hp.*, hu.`fullname`, hdm.`card_holder_name`
						FROM hdr_payment hp,hdr_debtor_main hdm,hdr_assignment ha, hdr_user hu
						WHERE hp.card_no=hdm.accno
						AND hdm.`primary_1`=ha.`primary_1`
						AND ha.`id_user`=hu.`id_user`
						AND ha.`is_active`=1

						$where limit 100 ";
	//	die($sql);
		$query=$this->db->query($sql);

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$data[] = $row;
			}
			$query->free_result();
		}

		return $data;
}
function approvephone($bucket)
{
	$data_update = array(
	'is_approved'=> 1,
	);
	$this->db->where('primary_1',$bucket[0]);
	$this->db->where('id_phone',$bucket[1]);
	$this->db->update('hdr_debtor_phone_no',$data_update);
}
function rejectedphone($bucket)
{
	$data_update = array(
	'is_approved'=> 2,
	);
	$this->db->where('primary_1',$bucket[0]);
	$this->db->where('id_phone',$bucket[1]);
	$this->db->update('hdr_debtor_phone_no',$data_update);
}
function pendingphone($bucket)
{
	$data_update = array(
	'is_approved'=> 0,
	);
	$this->db->where('primary_1',$bucket[0]);
	$this->db->where('id_phone',$bucket[1]);
	$this->db->update('hdr_debtor_phone_no',$data_update);
}
}
?>