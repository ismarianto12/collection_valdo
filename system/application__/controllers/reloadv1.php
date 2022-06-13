<?php

/**
 * wallboard controller.
 */
class reload extends Controller
{
	public function __construct()
	{
		parent::Controller();
	}

	function index()
	{

	}

	function topfive()
	{
		$data = array();

		//Top Five
		$sql = "select * from wallboard_topfive order by total_call desc limit 5";
		$q = $this->db->query($sql);

		foreach($q->result_array() as $row)
		{
			$data[] = $row;
		}
		$q->free_result();
		$arrdata['data'] = $data;

		$this->load->view("reload_topfive", $arrdata);
  }

	function worstfive()
	{
		$data = array();

		//Worst Five
		$sql = "select * from wallboard_topfive order by total_call asc limit 5";
		$q = $this->db->query($sql);

		$data = array();
		foreach($q->result_array() as $row)
		{
			$data[] = $row;
		}
		$q->free_result();
		$arrdata['worst'] = $data;

		$this->load->view("reload_worstfive", $arrdata);
  }

	function monitoring()
	{
		//migrate
		$sql = "truncate table wallboard_topfive";
		$this->db->query($sql);

		$today = date("Y-m-d");
		$sql = "insert into wallboard_topfive
			select hc.id_user, hu.username, count(*) as total_call, hl.username as leader_name, hu.id_leader
			from hdr_calltrack hc, hdr_user hu, hdr_user hl
			where hc.call_date='$today'
			and hc.id_user=hu.id_user
			and hu.id_leader=hl.id_user
			group by hc.id_user";
		$this->db->query($sql);

		$sql = "select datediff(now(),due_date) as od,
			count(case when id_debtor>0 and skip=0 and (is_paid is null or is_paid=0) then datediff(now(),due_date) end) as total_data,
			count(case when id_debtor>0 and in_use>0 and called>0 and skip=0 and (is_paid is null or is_paid=0) and id_user>0 then datediff(now(),due_date) end) as total_tounch,
			count(case when id_debtor>0 and in_use=0 and called=0 and skip=0 and (is_paid is null or is_paid=0) and id_user=0 then datediff(now(),due_date) end) as total_sisa,
			count(case when id_debtor>0 and in_use>0 and called>0 and skip=0 and (is_paid is null or is_paid=0) and id_user>0 then datediff(now(),due_date) end) /
			count(case when id_debtor>0 and skip=0 and (is_paid is null or is_paid=0) then datediff(now(),due_date) end) * 100 as percentage
			from hdr_debtor_main
			where datediff(now(),due_date) <= 10
			group by datediff(now(),due_date)";
		$q = $this->db->query($sql);

		$data = array();
		foreach($q->result_array() as $row)
		{
			$data[] = $row;
		}
		$q->free_result();
		$arrdata['data'] = $data;

		$this->load->view("reload_monitoring", $arrdata);
	}

}
?>