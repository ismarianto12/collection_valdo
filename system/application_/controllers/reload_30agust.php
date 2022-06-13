<?php

/**
 * wallboard controller.
 */
class reload extends Controller
{
	public function __construct()
	{
		parent::Controller();
		$this->load->model("Reload_model");
	}

	function test()
	{
		echo simple_formated(6270618);
		die();
	}
	
	function index()
	{

	}

	function hal1()
	{
		$arrdata = array();
		
		$arrdata["data_top"] = $this->topfive(1);
		$arrdata["worst"] = $this->worstfive(1);

		$arrdata["data_top_oto"] = $this->topfive(2);
		$arrdata["worst_oto"] = $this->worstfive(2);
		
		//$arrdata["data_un"] = $this->monitoring();
		
		$arrdata["user"] = $this->agent_status();
		$arrdata["user_active"] = $this->agent_status_total();

		$arrdata["debtor_main"] = $this->Reload_model->od_monitor_debtor_main();
		$arrdata["calltrack"] = $this->Reload_model->od_monitor_calltrack();
				
		$this->load->view("page1",$arrdata);
	}

	function agent_status_total()
	{
		$sql = "SELECT count(*) as total_active FROM `hdr_user` WHERE blocked=0 and pabx_ext is not null";
		$q = $this->db->query($sql);
		$row = $q->row_array();

		$total_active = $row['total_active'];
		return $total_active;
	}

	function agent_status()
	{
		/*
		$sql = "select pabx_ext	from hdr_user where id_leader>1 and user_status='online'";
		$q = $this->db->query($sql);

		foreach($q->result_array() as $row)
		{
			$ext = $row['pabx_ext'];
			$arrdata[] = $ext;
		}

		$st_data = implode($arrdata,"|");

		$arrview = array();
		$arrview["st_data"] = $st_data;

		$this->load->view("agent_status",$arrview);
		*/
		
		$hasil = "";
		try{
			$st_url = "http://172.25.150.201/cc-adira1/status_agent_adira.php";
			$hasil = file_get_contents($st_url);
		}catch(Exception $ex)
		{
			echo 'Caught exception: ',  $ex->getMessage(), "\n";
		}
		
		
		//$hasil = "";
		//var_dump($hasil);
		return $hasil;
	}

	function user_status()
	{

		$sql = "select
			count(case when user_status='online' then id_user end) as total_online,
			count(case when user_status='offline' then id_user end) as total_offline
			from hdr_user
			where id_leader>1";
		$q = $this->db->query($sql);
		$data = $q->row_array();

		return $data;
	}

	function topfive($product_flag)
	{
		$data = array();

		$wh = "where id_user>0 ";	
		switch($product_flag)
		{
			case 1:
				//durabel
				$wh .= " and product_flag in ('003','004') ";
				break;
			case 2:
				//otomotif
				$wh .= " and product_flag in ('001','002') ";
				break;		
		}
		
		//Top Five
		$sql = "select * from wallboard_topfive $wh order by total_call desc limit 5";
		$q = $this->db->query($sql);

		foreach($q->result_array() as $row)
		{
			$data[] = $row;
		}
		$q->free_result();

		return $data;
  }

	function worstfive($product_flag)
	{
		$data = array();

		$wh = "where id_user>0 ";
		switch($product_flag)
		{
			case 1:
				//durabel
				$wh .= " and product_flag in ('003','004') ";
				break;
			case 2:
				//otomotif
				$wh .= " and product_flag in ('001','002') ";
				break;
		}
		
		//Worst Five
		$sql = "select * from wallboard_topfive $wh order by total_call asc limit 5";
		$q = $this->db->query($sql);

		$data = array();
		foreach($q->result_array() as $row)
		{
			$data[] = $row;
		}
		$q->free_result();

		return $data;
  }

	function monitoring()
	{
		//migrate
		$sql = "truncate table wallboard_topfive";
		$this->db->query($sql);

		$today = date("Y-m-d");
		//$today = "2015-04-06";

		$sql = "
			insert into wallboard_topfive
			SELECT
			  hc.id_user,
			  hc.username,
			  (ROUND((COUNT(DISTINCT hc.id_calltrack)/(1*350)*5),'2') +
			  ROUND(((COUNT(DISTINCT CASE WHEN (hc.id_call_cat='1') THEN hc.id_calltrack END ))/(0.7*(1*350))*10),'2') +
			  ROUND(((COUNT(DISTINCT CASE WHEN hc.id_handling_code = '02' AND hc.ptp_date IS NOT NULL AND hc.ptp_date != '0000-00-00' THEN hc.id_calltrack END ))/(ROUND((0.8*((0.7*(1*350))))))*15),'2') +
			  ROUND((COUNT(DISTINCT CASE WHEN hc.ptp_status = '2' AND hc.id_handling_code = '02' THEN hc.primary_1 END ))/(ROUND((0.8 * ROUND((0.8*((0.7*(1*350))))))))*70,'2'))
			  as total_data,
			  hl.username as leader_name,
			  hu.id_leader, hdm.product_flag			
			FROM hdr_calltrack hc
			  INNER JOIN hdr_debtor_main hdm on hc.primary_1=hdm.primary_1	
			  LEFT JOIN hdr_user hu
			    ON hu.id_user = hc.id_user
			  LEFT JOIN (SELECT
			               sum(assign_total)    AS assign_total,
			               user_id
			             FROM hdr_report_filter
			             WHERE created = '$today') hh
			    on hh.user_id = hc.id_user
			  LEFT JOIN (SELECT
			               sum(ptp_amount)      AS sum_ptp_amount,
			               id_user
			             FROM hdr_calltrack
			             WHERE call_date = '$today'
			                 AND ptp_status = '2'
			                 AND id_action_call_track = '11'
			             GROUP BY id_user) jj
			    ON jj.id_user = hc.id_user
			  inner join hdr_user hl on hu.id_leader=hl.id_user
			WHERE hc.call_date = '$today'
			and hdm.valdo_cc='01'
			GROUP BY hc.id_user, hu.id_leader, hdm.product_flag";
		$this->db->query($sql);

		//data jakarta saja
/*
		$sql = "select datediff(now(),due_date) as od,
			count(case when id_debtor>0 and skip=0 and (is_paid is null or is_paid=0) then datediff(now(),due_date) end) as total_data,
			count(case when id_debtor>0 and in_use>0 and called>0 and skip=0 and (is_paid is null or is_paid=0) and id_user>0 then datediff(now(),due_date) end) as total_tounch,
			count(case when id_debtor>0 and in_use=0 and called=0 and skip=0 and (is_paid is null or is_paid=0) and id_user=0 then datediff(now(),due_date) end) as total_sisa,
			count(case when id_debtor>0 and in_use>0 and called>0 and skip=0 and (is_paid is null or is_paid=0) and id_user>0 then datediff(now(),due_date) end) /
			count(case when id_debtor>0 and skip=0 and (is_paid is null or is_paid=0) then datediff(now(),due_date) end) * 100 as percentage
			from hdr_debtor_main
			where datediff(now(),due_date) <= 10
			and valdo_cc='01'
			group by datediff(now(),due_date)";
*/
		$sql = "select datediff(now(),due_date) as od,
			SUM(os_ar) as total_os,
			count(case when id_debtor>0 then datediff(now(),due_date) end) as total_data,
			count(case when id_debtor>0 and called>0 and id_user>0 then datediff(now(),due_date) end) as total_tounch,
			(count(case when id_debtor>0 then datediff(now(),due_date) end)-count(case when id_debtor>0 and called>0 and id_user>0 then datediff(now(),due_date) end)) as total_sisa,
			count(case when id_debtor>0 and called>0 and id_user>0 then datediff(now(),due_date) end) /
			count(case when id_debtor>0 then datediff(now(),due_date) end) * 100 as percentage
			from hdr_debtor_main
			where valdo_cc='01'
			group by datediff(now(),due_date)";


		$q = $this->db->query($sql);

		$data = array();
		foreach($q->result_array() as $row)
		{
			$data[] = $row;
		}
		$q->free_result();

		return $data;
	}

	function hal2()
	{
		$arrdata = array();
		$arrdata["absen"] = $this->monitoring_spv();

		$absen_user = $this->monitoring_user();
		$arrdata["absen1"] = $absen_user["absen1"];
		$arrdata["absen2"] = $absen_user["absen2"];
		$arrdata["absen3"] = $absen_user["absen3"];
		$arrdata["absen4"] = $absen_user["absen4"];

		$this->load->view("page2",$arrdata);
	}

	function monitoring_user()
	{
		//monitoring Absensi
		$arrdata = array();
		$absen = array();
		$sql = "select hua.id_user, hu.username, count(*) as total_hadir, hl.username as leader_name
			from hdr_user_attend hua, hdr_user hu, hdr_user hl
			where hua.id_user=hu.id_user
			and hu.id_leader=hl.id_user
			and month(hua.login_time)=month(now()) and year(hua.login_time)=year(now())
			and hu.id_leader>1
			group by hua.id_user";
		$q2 = $this->db->query($sql);

		$absen1 = array();
		$absen2 = array();
		$absen3 = array();
		$absen4 = array();

		$j=0;
		foreach($q2->result_array() as $row2)
		{

			//for($i=0;$i<8;$i++)
			//{

				$j++;
				if($j <= 15 && $j >= 1) $absen1[] = $row2;
				if($j <= 30 && $j >= 16) $absen2[] = $row2;
				if($j <= 45 && $j >= 31) $absen3[] = $row2;
				if($j <= 60 && $j >= 46) $absen4[] = $row2;
			//}

		}
		$q2->free_result();

		//var_dump($absen1);
		//die();

		$arrdata['absen1'] = $absen1;
		$arrdata['absen2'] = $absen2;
		$arrdata['absen3'] = $absen3;
		$arrdata['absen4'] = $absen4;

		return $arrdata;
	}

	function monitoring_spv()
	{
		//monitoring Absensi
		$arrdata = array();
		$absen = array();
		$sql = "select hl.username as leader_name, hl.id_user
			from hdr_user_attend hua, hdr_user hu, hdr_user hl
			where hua.id_user=hu.id_user
			and hu.id_leader=hl.id_user
			and month(hua.login_time)=month(now()) and year(hua.login_time)=year(now())
			and hu.id_leader>1
			group by hl.username";
		$q2 = $this->db->query($sql);

		foreach($q2->result_array() as $row2)
		{
			//total_user
			//jan
			$id_leader = $row2['id_user'];
			$ttl_jan = $this->get_total_user_login(1,$id_leader);
			$ttl_feb = $this->get_total_user_login(2,$id_leader);
			$ttl_mar = $this->get_total_user_login(3,$id_leader);
			$ttl_apr = $this->get_total_user_login(4,$id_leader);
			$ttl_may = $this->get_total_user_login(5,$id_leader);
			$ttl_jun = $this->get_total_user_login(6,$id_leader);
			$ttl_jul = $this->get_total_user_login(7,$id_leader);
			$ttl_aug = $this->get_total_user_login(8,$id_leader);
			$ttl_sep = $this->get_total_user_login(9,$id_leader);
			$ttl_okt = $this->get_total_user_login(10,$id_leader);
			$ttl_nov = $this->get_total_user_login(11,$id_leader);
			$ttl_dec = $this->get_total_user_login(12,$id_leader);

			$row2['total_jan'] = $ttl_jan;
			$row2['total_feb'] = $ttl_feb;
			$row2['total_mar'] = $ttl_mar;
			$row2['total_apr'] = $ttl_apr;
			$row2['total_may'] = $ttl_may;
			$row2['total_jun'] = $ttl_jun;
			$row2['total_jul'] = $ttl_jul;
			$row2['total_aug'] = $ttl_aug;
			$row2['total_sep'] = $ttl_sep;
			$row2['total_okt'] = $ttl_okt;
			$row2['total_nov'] = $ttl_nov;
			$row2['total_dec'] = $ttl_dec;

			$row2['subtotal'] = $this->get_total_user_login(0,$id_leader,0);

			$absen[] = $row2;
		}
		$q2->free_result();

		return $absen;
	}

	function get_total_user_login($month,$id_leader,$flag=1)
	{
		$where = ($flag == 1 ? " and DATE_FORMAT(bb.login_date,'%c')='$month' " : "");
		$sql = "select ld.id_user as id_leader,ld.username as leader_name, bb.*
		from hdr_user ld,
		(
		 select hua.id_user, hu.fullname, count(*) as total_hadir, hu.id_leader,
		 date_format(hua.login_time,'%b') as bulan_hadir, DATE_FORMAT(hua.login_time,'%Y') as tahun_hadir,
		 date_format(hua.login_time,'%Y-%m-%d') as login_date
		 from hdr_user_attend hua, hdr_user hu
		 where hua.id_user=hu.id_user and hu.id_user>1
		 group by hua.id_user, date_format(hua.login_time,'%c%Y')
		) bb
		where ld.id_leader=1 and ld.id_user>1
		and ld.id_user=bb.id_leader
		and DATE_FORMAT(bb.login_date,'%Y')=date_format(now(),'%Y')
		$where
		and ld.id_user=$id_leader
		order by ld.username, bb.fullname, bb.login_date";
		$q = $this->db->query($sql);

		$total_data = $q->num_rows();

		return $total_data;
	}

}
?>