<?php

  class Reload_model extends Model {

      function __construct() {
          parent::Model();
      }

      public function od_monitor_debtor_main()
      {
      	$sql = "select 
			count(distinct(case when dpd=-3 then primary_1 end)) as total_min3,
      			count(distinct(case when dpd=-3 and (skip=1 or is_paid=1) then primary_1 end)) as total_min3_skip,
      		sum(case when dpd=-3 then os_ar end) as total_min3_amount,
			count(distinct(case when dpd=-2 then primary_1 end)) as total_min2,
      			count(distinct(case when dpd=-2 and (skip=1 or is_paid=1) then primary_1 end)) as total_min2_skip,
      		sum(case when dpd=-2 then os_ar end) as total_min2_amount,
			count(distinct(case when dpd=-1 then primary_1 end)) as total_min1,
      			count(distinct(case when dpd=-1 and (skip=1 or is_paid=1) then primary_1 end)) as total_min1_skip,
      		sum(case when dpd=-1 then os_ar end) as total_min1_amount,
			count(distinct(case when dpd=0 then primary_1 end)) as total_null,
      			count(distinct(case when dpd=0 and (skip=1 or is_paid=1) then primary_1 end)) as total_null_skip,
      		sum(case when dpd=0 then os_ar end) as total_null_amount,
			count(distinct(case when dpd=1 then primary_1 end)) as total_plus1,
      			count(distinct(case when dpd=1 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus1_skip,
      		sum(case when dpd=1 then os_ar end) as total_plus1_amount,
			count(distinct(case when dpd=2 then primary_1 end)) as total_plus2,
      			count(distinct(case when dpd=2 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus2_skip,
      		sum(case when dpd=2 then os_ar end) as total_plus2_amount,
			count(distinct(case when dpd=3 then primary_1 end)) as total_plus3,
      			count(distinct(case when dpd=3 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus3_skip,
      		sum(case when dpd=3 then os_ar end) as total_plus3_amount,
			count(distinct(case when dpd=4 then primary_1 end)) as total_plus4,
      			count(distinct(case when dpd=4 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus4_skip,
      		sum(case when dpd=4 then os_ar end) as total_plus4_amount,
			count(distinct(case when dpd=5 then primary_1 end)) as total_plus5,
      			count(distinct(case when dpd=5 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus5_skip,
      		sum(case when dpd=5 then os_ar end) as total_plus5_amount,
			count(distinct(case when dpd=6 then primary_1 end)) as total_plus6,
      			count(distinct(case when dpd=6 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus6_skip,
      		sum(case when dpd=6 then os_ar end) as total_plus6_amount,
			count(distinct(case when dpd=7 then primary_1 end)) as total_plus7,
      			count(distinct(case when dpd=7 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus7_skip,
      		sum(case when dpd=7 then os_ar end) as total_plus7_amount,
			count(distinct(case when dpd=8 then primary_1 end)) as total_plus8,
      			count(distinct(case when dpd=8 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus8_skip,
      		sum(case when dpd=8 then os_ar end) as total_plus8_amount,
			count(distinct(case when dpd=9 then primary_1 end)) as total_plus9,
      			count(distinct(case when dpd=9 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus9_skip,
      		sum(case when dpd=9 then os_ar end) as total_plus9_amount,
			count(distinct(case when dpd=10 then primary_1 end)) as total_plus10,
      			count(distinct(case when dpd=10 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus10_skip,
      		sum(case when dpd=10 then os_ar end) as total_plus10_amount,
			count(distinct(case when dpd=11 then primary_1 end)) as total_plus11,
      			count(distinct(case when dpd=11 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus11_skip,
      		sum(case when dpd=11 then os_ar end) as total_plus11_amount,
			count(distinct(case when dpd=12 then primary_1 end)) as total_plus12,
      			count(distinct(case when dpd=12 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus12_skip,
      		sum(case when dpd=12 then os_ar end) as total_plus12_amount,
			count(distinct(case when dpd=13 then primary_1 end)) as total_plus13,
      			count(distinct(case when dpd=13 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus13_skip,
      		sum(case when dpd=13 then os_ar end) as total_plus13_amount,
			count(distinct(case when dpd=14 then primary_1 end)) as total_plus14,
      			count(distinct(case when dpd=14 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus14_skip,
      		sum(case when dpd=14 then os_ar end) as total_plus14_amount,
			count(distinct(case when dpd=15 then primary_1 end)) as total_plus15,
      			count(distinct(case when dpd=15 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus15_skip,
      		sum(case when dpd=15 then os_ar end) as total_plus15_amount,
			count(distinct(case when dpd>15 then primary_1 end)) as total_plus15plus,
      			count(distinct(case when dpd>15 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus15plus_skip,
      		sum(case when dpd>15 then os_ar end) as total_plus15plus_amount,      			      			
      		count(distinct(case when dpd >= -3 then primary_1 end)) as total_cust,
      			count(distinct(case when dpd >= -3 and (skip=1 or is_paid=1) then primary_1 end)) as total_cust_skip,
      		sum(case when dpd >= -3 then os_ar end) as total_cust_amount
			from hdr_debtor_main where valdo_cc='01' ";
      	//die($sql);
      	$query = $this->db->query($sql);
      	$data = $query->row_array();
      	
      	//DR -2
      	//total data sisa hari sebelumnya days -1
      	//total data -2 di tabel hdr_debtor_main, dikurangi data followup hari kemaren
      	//syncronize dulu
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc 
			set hdm.last_handling_date=hc.call_date
			where hdm.dpd=-2 and hdm.valdo_cc='01' and hc.call_date=date(INTERVAL -1 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.last_handling_date='0000-00-00'";
      	$this->db->query($sql);
      			
      	$total_data_minus2_master = $data['total_min2'];
      	$total_data_minus2_master_amount = $data['total_min2_amount'];
      	
      	$sql = "select count(primary_1) as total_wk_min1,
      		sum(os_ar) as total_wk_min1_amount
			from hdr_debtor_main where valdo_cc='01' and dpd=-2 and last_handling_date=date(INTERVAL -1 DAY + now())";
      	$q1 = $this->db->query($sql);
      	$row1 = $q1->row_array();
      	$total_wk_min1 = $row1['total_wk_min1'];
      	$total_wk_min1_amount = $row1['total_wk_min1_amount'];
     	       	
      	$data['total_min2'] = $total_data_minus2_master - $total_wk_min1;
      	$data['total_min2_skip'] = 0;
      	$data['total_min2_amount'] = $total_data_minus2_master_amount - $total_wk_min1_amount;
		
      	//DR -1
      	//total data sisa hari sebelumnya days -2
      	//total data -2 di tabel hdr_debtor_main, dikurangi data followup 2 hari yg lalu
      	//syncronize dulu
		$sql = "update hdr_debtor_main hdm,hdr_calltrack hc 
			set hdm.last_handling_date=hc.call_date
			where hdm.dpd=-1 and hdm.valdo_cc='01' and hc.call_date=date(INTERVAL -2 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.last_handling_date='0000-00-00'";
		$this->db->query($sql);
		
      	$total_data_minus1_master = $data['total_min1'];
      	$total_data_minus1_master_amount = $data['total_min1_amount'];

      	$sql = "select count(primary_1) as total_wk_min1,
      		sum(os_ar) as total_wk_min1_amount
			from hdr_debtor_main where valdo_cc='01' and dpd=-1 and last_handling_date=date(INTERVAL -2 DAY + now())";     	 
      	$q1 = $this->db->query($sql);
      	$row1 = $q1->row_array();
      	$total_wk_min1 = $row1['total_wk_min1'];
      	$total_wk_min1_amount = $row1['total_wk_min1_amount'];
      	      	 
      	$data['total_min1'] = $total_data_minus1_master - $total_wk_min1;
      	$data['total_min1_skip'] = 0;
      	$data['total_min1_amount'] = $total_data_minus1_master_amount - $total_wk_min1_amount;      	       	 
      	//var_dump($data);
      	
      	//D1 2
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0
      	//syncronize dulu
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.last_handling_date=hc.call_date
			where hdm.dpd=2 and hdm.valdo_cc='01' and hc.call_date=date(INTERVAL -1 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.last_handling_date='0000-00-00'";
      	$this->db->query($sql);
      	 
      	$total_data_plus2_master = $data['total_plus2'];
      	$total_data_plus2_master_amount = $data['total_plus2_amount'];
      	 
      	$sql = "select count(primary_1) as total_wk_plus2,
      		sum(os_ar) as total_wk_plus2_amount
			from hdr_debtor_main where valdo_cc='01' and dpd=2 and last_handling_date=date(INTERVAL -1 DAY + now())";
      	$q1 = $this->db->query($sql);
      	$row1 = $q1->row_array();
      	$total_wk_plus2 = $row1['total_wk_plus2'];
      	$total_wk_plus2_amount = $row1['total_wk_plus2_amount'];
      	
      	$data['total_plus2'] = $total_data_plus2_master - $total_wk_plus2;
      	$data['total_plus2_skip'] = 0;
      	$data['total_plus2_amount'] = $total_data_plus2_master_amount - $total_wk_plus2_amount;
      	 
      	//D1 3
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.last_handling_date=hc.call_date
			where hdm.dpd=3 and hdm.valdo_cc='01' and hc.call_date=date(INTERVAL -2 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.last_handling_date='0000-00-00'";
      	$this->db->query($sql);
      	
      	$total_data_plus3_master = $data['total_plus3'];
      	$total_data_plus3_master_amount = $data['total_plus3_amount'];
      	
      	$sql = "select count(primary_1) as total_wk_plus3,
      		sum(os_ar) as total_wk_plus3_amount
			from hdr_debtor_main where valdo_cc='01' and dpd=3 and last_handling_date=date(INTERVAL -2 DAY + now())";
      	$q1 = $this->db->query($sql);
      	$row1 = $q1->row_array();
      	$total_wk_plus3 = $row1['total_wk_plus3'];
      	$total_wk_plus3_amount = $row1['total_wk_plus3_amount'];
      	 
      	$data['total_plus3'] = $total_data_plus3_master - $total_wk_plus3;
      	$data['total_plus3_skip'] = 0;
      	$data['total_plus3_amount'] = $total_data_plus3_master_amount - $total_wk_plus3_amount;
      	
      	//D1 5
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0
      	//syncronize dulu
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.last_handling_date=hc.call_date
			where hdm.dpd=5 and hdm.valdo_cc='01' and hc.call_date between DATE_FORMAT(concat(year(now()),'-',month(now()),'-01'),'%Y-%m-%d') and date(INTERVAL -1 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.last_handling_date='0000-00-00'";
      	$this->db->query($sql);
      	
      	$total_data_plus5_master = $data['total_plus5'];
      	$total_data_plus5_master_amount = $data['total_plus5_amount'];
      	
      	$sql = "select count(primary_1) as total_wk_plus5,
      		sum(os_ar) as total_wk_plus5_amount
			from hdr_debtor_main where valdo_cc='01' and dpd=5 and last_handling_date='0000-00-00'";
      	$q1 = $this->db->query($sql);
      	$row1 = $q1->row_array();
      	$total_wk_plus5 = $row1['total_wk_plus5'];
      	$total_wk_plus5_amount = $row1['total_wk_plus5_amount'];
      	 
      	$data['total_plus5'] = $total_wk_plus5;
      	$data['total_plus5_skip'] = 0;
      	$data['total_plus5_amount'] = $total_wk_plus5_amount;
      	
      	//D1 6
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.last_handling_date=hc.call_date
			where hdm.dpd=6 and hdm.valdo_cc='01' and hc.call_date between DATE_FORMAT(concat(year(now()),'-',month(now()),'-01'),'%Y-%m-%d') and date(INTERVAL -2 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.last_handling_date='0000-00-00'";
      	$this->db->query($sql);
      	 
      	$total_data_plus6_master = $data['total_plus6'];
      	$total_data_plus6_master_amount = $data['total_plus6_amount'];
      	 
      	$sql = "select count(primary_1) as total_wk_plus6,
      		sum(os_ar) as total_wk_plus6_amount
			from hdr_debtor_main where valdo_cc='01' and dpd=6 and last_handling_date='0000-00-00'";
      	$q1 = $this->db->query($sql);
      	$row1 = $q1->row_array();
      	$total_wk_plus6 = $row1['total_wk_plus6'];
      	$total_wk_plus6_amount = $row1['total_wk_plus6_amount'];
      	
      	$data['total_plus6'] = $total_wk_plus6;
      	$data['total_plus6_skip'] = 0;
      	$data['total_plus6_amount'] = $total_wk_plus6_amount;

      	//D1 9
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0
      	//syncronize dulu
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.last_handling_date=hc.call_date
			where hdm.dpd=9 and hdm.valdo_cc='01' and hc.call_date between DATE_FORMAT(concat(year(now()),'-',month(now()),'-01'),'%Y-%m-%d') and date(INTERVAL -1 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.last_handling_date='0000-00-00'";
      	$this->db->query($sql);
      	 
      	$total_data_plus9_master = $data['total_plus9'];
      	$total_data_plus9_master_amount = $data['total_plus9_amount'];
      	 
      	$sql = "select count(primary_1) as total_wk_plus9,
      		sum(os_ar) as total_wk_plus9_amount
			from hdr_debtor_main where valdo_cc='01' and dpd=9 and last_handling_date='000-00-00'";
      	$q1 = $this->db->query($sql);
      	$row1 = $q1->row_array();
      	$total_wk_plus9 = $row1['total_wk_plus9'];
      	$total_wk_plus9_amount = $row1['total_wk_plus9_amount'];
      	
      	$data['total_plus9'] = $total_wk_plus9;
      	$data['total_plus9_skip'] = 0;
      	$data['total_plus9_amount'] = $total_wk_plus9_amount;
      	 
      	//D1 10
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.last_handling_date=hc.call_date
			where hdm.dpd=10 and hdm.valdo_cc='01' and hc.call_date between DATE_FORMAT(concat(year(now()),'-',month(now()),'-01'),'%Y-%m-%d') and date(INTERVAL -2 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.last_handling_date='0000-00-00'";
      	$this->db->query($sql);
      	
      	$total_data_plus10_master = $data['total_plus10'];
      	$total_data_plus10_master_amount = $data['total_plus10_amount'];
      	
      	$sql = "select count(primary_1) as total_wk_plus10,
      		sum(os_ar) as total_wk_plus10_amount
			from hdr_debtor_main where valdo_cc='01' and dpd=10 and last_handling_date='0000-00-00'";
      	$q1 = $this->db->query($sql);
      	$row1 = $q1->row_array();
      	$total_wk_plus10 = $row1['total_wk_plus10'];
      	$total_wk_plus10_amount = $row1['total_wk_plus10_amount'];
      	 
      	$data['total_plus10'] = $total_wk_plus10;
      	$data['total_plus10_skip'] = 0;
      	$data['total_plus10_amount'] = $total_wk_plus10_amount;
      	       	
      	//D1 12
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0
      	//syncronize dulu
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.last_handling_date=hc.call_date
			where hdm.dpd=12 and hdm.valdo_cc='01' and hc.call_date between DATE_FORMAT(concat(year(now()),'-',month(now()),'-01'),'%Y-%m-%d') and date(INTERVAL -1 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.last_handling_date='0000-00-00'";
      	$this->db->query($sql);
      	
      	$total_data_plus12_master = $data['total_plus12'];
      	$total_data_plus12_master_amount = $data['total_plus12_amount'];
      	
      	$sql = "select count(primary_1) as total_wk_plus12,
      		sum(os_ar) as total_wk_plus12_amount
			from hdr_debtor_main where valdo_cc='01' and dpd=12 and last_handling_date='0000-00-00'";
      	$q1 = $this->db->query($sql);
      	$row1 = $q1->row_array();
      	$total_wk_plus12 = $row1['total_wk_plus12'];
      	$total_wk_plus12_amount = $row1['total_wk_plus12_amount'];
      	 
      	$data['total_plus12'] = $total_wk_plus12;
      	$data['total_plus12_skip'] = 0;
      	$data['total_plus12_amount'] = $total_wk_plus12_amount;
      	
      	//D1 13
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.last_handling_date=hc.call_date
			where hdm.dpd=13 and hdm.valdo_cc='01' and hc.call_date between DATE_FORMAT(concat(year(now()),'-',month(now()),'-01'),'%Y-%m-%d') and date(INTERVAL -2 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.last_handling_date='0000-00-00'";
      	$this->db->query($sql);
      	 
      	$total_data_plus13_master = $data['total_plus13'];
      	$total_data_plus13_master_amount = $data['total_plus13_amount'];
      	 
      	$sql = "select count(primary_1) as total_wk_plus13,
      		sum(os_ar) as total_wk_plus13_amount
			from hdr_debtor_main where valdo_cc='01' and dpd=13 and last_handling_date='0000-00-00'";
      	$q1 = $this->db->query($sql);
      	$row1 = $q1->row_array();
      	$total_wk_plus13 = $row1['total_wk_plus13'];
      	$total_wk_plus13_amount = $row1['total_wk_plus13_amount'];
      	
      	$data['total_plus13'] = $total_wk_plus13;
      	$data['total_plus13_skip'] = 0;
      	$data['total_plus13_amount'] = $total_wk_plus13_amount;
      	       	
      	//die();
      	return $data;      	 
      }
      
      public function od_monitor_calltrack() {
          $sql = "select 
			count(distinct(case when hdm.dpd=-3 then hdm.primary_1 end)) as total_min3,			
			count(distinct(case when hdm.dpd=-2 then hdm.primary_1 end)) as total_min2,
			count(distinct(case when hdm.dpd=-1 then hdm.primary_1 end)) as total_min1,
			count(distinct(case when hdm.dpd=0 then hdm.primary_1 end)) as total_null,
			count(distinct(case when hdm.dpd=1 then hdm.primary_1 end)) as total_plus1,
			count(distinct(case when hdm.dpd=2 then hdm.primary_1 end)) as total_plus2,
			count(distinct(case when hdm.dpd=3 then hdm.primary_1 end)) as total_plus3,
			count(distinct(case when hdm.dpd=4 then hdm.primary_1 end)) as total_plus4,
			count(distinct(case when hdm.dpd=5 then hdm.primary_1 end)) as total_plus5,
			count(distinct(case when hdm.dpd=6 then hdm.primary_1 end)) as total_plus6,
			count(distinct(case when hdm.dpd=7 then hdm.primary_1 end)) as total_plus7,
			count(distinct(case when hdm.dpd=8 then hdm.primary_1 end)) as total_plus8,
			count(distinct(case when hdm.dpd=9 then hdm.primary_1 end)) as total_plus9,
			count(distinct(case when hdm.dpd=10 then hdm.primary_1 end)) as total_plus10,
			count(distinct(case when hdm.dpd=11 then hdm.primary_1 end)) as total_plus11,
			count(distinct(case when hdm.dpd=12 then hdm.primary_1 end)) as total_plus12,
			count(distinct(case when hdm.dpd=13 then hdm.primary_1 end)) as total_plus13,
			count(distinct(case when hdm.dpd=14 then hdm.primary_1 end)) as total_plus14,
			count(distinct(case when hdm.dpd=15 then hdm.primary_1 end)) as total_plus15,
			count(distinct(case when hdm.dpd>15 then hdm.primary_1 end)) as total_plus15plus,          		
			count(distinct(case when hdm.dpd >= -3 then hdm.primary_1 end)) as total_cust
          	from hdr_calltrack hc, hdr_debtor_main hdm 
          		where hc.primary_1=hdm.primary_1 
          		and hdm.valdo_cc='01' and hdm.skip=0 and (hdm.is_paid IS NULL or hdm.is_paid = 0)
          		and date(hc.call_date)=date(now())";
          $query = $this->db->query($sql);
          $data = $query->row_array();
          return $data;
      }
  }