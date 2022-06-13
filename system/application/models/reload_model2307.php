<?php

  class Reload_model extends Model {

      function __construct() {
          parent::Model();
      }

			//bahan data
      public function od_monitor_debtor_main()
      {
      	$sql = "select 
			count(distinct(case when dpd=-3 then primary_1 end)) as total_min3,
      			count(distinct(case when dpd=-3 and (skip=1 or is_paid=1) then primary_1 end)) as total_min3_skip,
      		sum(case when dpd=-3 then os_ar end) as total_min3_amount,      			
			count(distinct(case when dpd=0 then primary_1 end)) as total_null,
      			count(distinct(case when dpd=0 and (skip=1 or is_paid=1) then primary_1 end)) as total_null_skip,
      		sum(case when dpd=0 then os_ar  end) as total_null_amount,
			count(distinct(case when dpd=1 then primary_1 end)) as total_plus1,
      			count(distinct(case when dpd=1 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus1_skip,
      		sum(case when dpd=1 then os_ar end) as total_plus1_amount,
			count(distinct(case when dpd=4 then primary_1 end)) as total_plus4,
      			count(distinct(case when dpd=4 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus4_skip,
      		sum(case when dpd=4 then os_ar end) as total_plus4_amount,
			count(distinct(case when dpd=7 then primary_1 end)) as total_plus7,
      			count(distinct(case when dpd=7 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus7_skip,
      		sum(case when dpd=7 then os_ar end) as total_plus7_amount,
			count(distinct(case when dpd=8 then primary_1 end)) as total_plus8,
      			count(distinct(case when dpd=8 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus8_skip,
      		sum(case when dpd=8 then os_ar end) as total_plus8_amount,
			count(distinct(case when dpd=11 then primary_1 end)) as total_plus11,
      			count(distinct(case when dpd=11 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus11_skip,
      		sum(case when dpd=11 then os_ar end) as total_plus11_amount,
			count(distinct(case when dpd=14 then primary_1 end)) as total_plus14,
      			count(distinct(case when dpd=14 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus14_skip,
      		sum(case when dpd=14 then os_ar end) as total_plus14_amount,
			count(distinct(case when dpd=15 then primary_1 end)) as total_plus15,
      			count(distinct(case when dpd=15 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus15_skip,
      		sum(case when dpd=15 then os_ar end) as total_plus15_amount,
			count(distinct(case when dpd>15 then primary_1 end)) as total_plus15plus,
      			count(distinct(case when dpd>15 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus15plus_skip,
      		sum(case when dpd>15 then os_ar end) as total_plus15plus_amount
			from hdr_debtor_main where valdo_cc='01' ";
      	//die($sql);
      	$query = $this->db->query($sql);
      	$data = $query->row_array();

		//reset
		$sql = "update hdr_debtor_main set wb_date_min1=null,wb_date_min2=null where valdo_cc='01'";
		$this->db->query($sql);
		
		$sql = "update hdr_debtor_main set last_call_code='' where last_call_code is null and valdo_cc='01'";
		$this->db->query($sql);

		$sql = "update hdr_debtor_main hdm,hdr_calltrack hc 
				set hdm.id_user=hc.id_user, hdm.in_use=1, hdm.called=1 
			where hdm.valdo_cc='01' 
			and hdm.skip=0 
			and hdm.primary_1=hc.primary_1 
			and hdm.id_user=0
			and hc.call_date=date(INTERVAL 0 DAY + now())";
		$this->db->query($sql);
		
		//syncronize		
      	//Update WB Date H-1	
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.wb_date_min1=hc.call_date
			where hdm.valdo_cc='01' and hc.call_date=date(INTERVAL -1 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.wb_date_min1 is null";
      	$this->db->query($sql);

      	//Update WB Date H-2
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.wb_date_min2=hc.call_date
			where hdm.valdo_cc='01' and hc.call_date=date(INTERVAL -2 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.wb_date_min2 is null";
      	$this->db->query($sql);
      	 
      	$sql = "select 
      		count(case when dpd=-2 then primary_1 end) as total_wk_min2,
      		sum(case when dpd=-2 then os_ar end) as total_wk_min2_amount,
      		count(case when dpd=-2 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_min2_skip,      			
      		count(case when dpd=-1 then primary_1 end) as total_wk_min1,
      		sum(case when dpd=-1 then os_ar end) as total_wk_min1_amount,
      		count(case when dpd=-1 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_min1_skip,      			

      		count(case when dpd=2 then primary_1 end) as total_wk_plus2,
      		sum(case when dpd=2 then os_ar end) as total_wk_plus2_amount,
      		count(case when dpd=2 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus2_skip,      			
      		count(case when dpd=3 then primary_1 end) as total_wk_plus3,
      		sum(case when dpd=3 then os_ar end) as total_wk_plus3_amount,
      		count(case when dpd=3 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus3_skip,      			

      		count(case when dpd=5 then primary_1 end) as total_wk_plus5,
      		sum(case when dpd=5 then os_ar end) as total_wk_plus5_amount,
      		count(case when dpd=5 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus5_skip,      			
      		count(case when dpd=6 then primary_1 end) as total_wk_plus6,
      		sum(case when dpd=6 then os_ar end) as total_wk_plus6_amount,
      		count(case when dpd=6 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus6_skip,      			

      		count(case when dpd=9 then primary_1 end) as total_wk_plus9,
      		sum(case when dpd=9 then os_ar end) as total_wk_plus9_amount,
      		count(case when dpd=9 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus9_skip,      			
      		count(case when dpd=10 then primary_1 end) as total_wk_plus10,
      		sum(case when dpd=10 then os_ar end) as total_wk_plus10_amount,
      		count(case when dpd=10 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus10_skip,      			

      		count(case when dpd=12 then primary_1 end) as total_wk_plus12,
      		sum(case when dpd=12 then os_ar end) as total_wk_plus12_amount,
      		count(case when dpd=12 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus12_skip,      			
      		count(case when dpd=13 then primary_1 end) as total_wk_plus13,
      		sum(case when dpd=13 then os_ar end) as total_wk_plus13_amount,
      		count(case when dpd=13 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus13_skip      			
      			
			from hdr_debtor_main where valdo_cc='01'";
      	//die($sql);
      	$q1 = $this->db->query($sql);
      	$row1 = $q1->row_array();     	       	

      	//DR -2
      	//total data sisa hari sebelumnya days -1
      	//total data -2 di tabel hdr_debtor_main, dikurangi data followup H-1 hari kemaren
      	$data['total_min2'] = $row1['total_wk_min2'];
      	$data['total_min2_skip'] =  $row1['total_wk_min2_skip'];
      	$data['total_min2_amount'] = $row1['total_wk_min2_amount'];

      	//DR -1
      	//total data sisa hari sebelumnya days -2
      	//total data -2 di tabel hdr_debtor_main, dikurangi data followup H-1 dan H-2 hari yg lalu      	    
      	$data['total_min1'] = $row1['total_wk_min1'];
      	$data['total_min1_skip'] = $row1['total_wk_min1_skip'];
      	$data['total_min1_amount'] = $row1['total_wk_min1_amount'];
      	       	
      	//D1 2
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0
      	$data['total_plus2'] = $row1['total_wk_plus2'];
      	$data['total_plus2_skip'] = $row1['total_wk_plus2_skip'];
      	$data['total_plus2_amount'] = $row1['total_wk_plus2_amount'];
      	 
      	//D1 3
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0      	      	 
      	$data['total_plus3'] = $row1['total_wk_plus3'];
      	$data['total_plus3_skip'] = $row1['total_wk_plus3_skip'];
      	$data['total_plus3_amount'] = $row1['total_wk_plus3_amount'];
      	
      	//D1 5
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0      	 
      	$data['total_plus5'] = $row1['total_wk_plus5'];
      	$data['total_plus5_skip'] = $row1['total_wk_plus5_skip'];
      	$data['total_plus5_amount'] = $row1['total_wk_plus5_amount'];
      	
      	//D1 6
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0      	 
      	$data['total_plus6'] = $row1['total_wk_plus6'];
      	$data['total_plus6_skip'] = $row1['total_wk_plus6_skip'];
      	$data['total_plus6_amount'] = $row1['total_wk_plus6_amount'];

      	//D1 9
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0      	
      	$data['total_plus9'] = $row1['total_wk_plus9'];
      	$data['total_plus9_skip'] = $row1['total_wk_plus9_skip'];
      	$data['total_plus9_amount'] = $row1['total_wk_plus9_amount'];
      	 
      	//D1 10
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0      	 
      	$data['total_plus10'] = $row1['total_wk_plus10'];
      	$data['total_plus10_skip'] = $row1['total_wk_plus10_skip'];
      	$data['total_plus10_amount'] = $row1['total_wk_plus10_amount'];
      	       	
      	//D1 12
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0      	 
      	$data['total_plus12'] = $row1['total_wk_plus12'];
      	$data['total_plus12_skip'] = $row1['total_wk_plus12_skip'];
      	$data['total_plus12_amount'] = $row1['total_wk_plus12_amount'];
      	
      	//D1 13
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0
      	$data['total_plus13'] = $row1['total_wk_plus13'];
      	$data['total_plus13_skip'] = $row1['total_wk_plus13_skip'];
      	$data['total_plus13_amount'] = $row1['total_wk_plus13_amount'];

      	/*
      	count(distinct(case when dpd >= -3 then primary_1 end)) as total_cust,
      	count(distinct(case when dpd >= -3 and (skip=1 or is_paid=1) then primary_1 end)) as total_cust_skip,
      	sum(case when dpd >= -3 then os_ar end) as total_cust_amount
      	*/
      	
      	$total_cust = $data['total_min3'] + $data['total_min2'] + $data['total_min1'] + $data['total_null'] + $data['total_plus1'] + $data['total_plus2'] +
      		$data['total_plus3'] + $data['total_plus4'] + $data['total_plus5'] + $data['total_plus6'] + $data['total_plus7'] + $data['total_plus8'] +
      		$data['total_plus9'] + $data['total_plus10'] + $data['total_plus11'] + $data['total_plus12'] + $data['total_plus13'] + $data['total_plus14'] +
      		$data['total_plus15'] + $data['total_plus15plus'];
      	$total_cust_skip = $data['total_min3_skip'] + $data['total_min2_skip'] + $data['total_min1_skip'] + $data['total_null_skip'] + $data['total_plus1_skip'] + $data['total_plus2_skip'] +
      		$data['total_plus3_skip'] + $data['total_plus4_skip'] + $data['total_plus5_skip'] + $data['total_plus6_skip'] + $data['total_plus7_skip'] + $data['total_plus8_skip'] +
      		$data['total_plus9_skip'] + $data['total_plus10_skip'] + $data['total_plus11_skip'] + $data['total_plus12_skip'] + $data['total_plus13_skip'] + $data['total_plus14_skip'] +
      		$data['total_plus15_skip'] + $data['total_plus15plus_skip'];
      	$total_cust_amount = $data['total_min3_amount'] + $data['total_min2_amount'] + $data['total_min1_amount'] + $data['total_null_amount'] + $data['total_plus1_amount'] + $data['total_plus2_amount'] +
      		$data['total_plus3_amount'] + $data['total_plus4_amount'] + $data['total_plus5_amount'] + $data['total_plus6_amount'] + $data['total_plus7_amount'] + $data['total_plus8_amount'] +
      		$data['total_plus9_amount'] + $data['total_plus10_amount'] + $data['total_plus11_amount'] + $data['total_plus12_amount'] + $data['total_plus13_amount'] + $data['total_plus14_amount'] +
      		$data['total_plus15_amount'] + $data['total_plus15plus_amount'];
      	
      	$data['total_cust'] = $total_cust;
      	$data['total_cust_skip'] = $total_cust_skip;
      	$data['total_cust_amount'] = $total_cust_amount;
      	
      	//die();
      	return $data;      	 
      }

			//total cust
      public function od_monitor_debtor_main_cust()
      {/*
      	$sql = "select 
			count(distinct(case when dpd=-3 then primary_1 end)) as total_min3,
      			count(distinct(case when dpd=-3 and (skip=1 or is_paid=1) then primary_1 end)) as total_min3_skip,
      		sum(case when dpd=-3 then os_ar end) as total_min3_amount,      			
			count(distinct(case when dpd=0 and object_group_code='003' and last_call_code<>'OCIN' then primary_1 end)) as total_null,
      			count(distinct(case when dpd=0 and object_group_code='003' and last_call_code<>'OCIN' and (skip=1 or is_paid=1) then primary_1 end)) as total_null_skip,
      		sum(case when dpd=0 and object_group_code='003' and last_call_code<>'OCIN' then os_ar  end) as total_null_amount,
			count(distinct(case when dpd=1 and last_call_code<>'OCIN' then primary_1 end)) as total_plus1,
      			count(distinct(case when dpd=1 and (skip=1 or is_paid=1) and last_call_code<>'OCIN' then primary_1 end)) as total_plus1_skip,
      		sum(case when dpd=1 and last_call_code<>'OCIN' then os_ar end) as total_plus1_amount,
			count(distinct(case when dpd=4 and last_call_code<>'OCIN' then primary_1 end)) as total_plus4,
      			count(distinct(case when dpd=4 and last_call_code<>'OCIN' and (skip=1 or is_paid=1) then primary_1 end)) as total_plus4_skip,
      		sum(case when dpd=4 and last_call_code<>'OCIN' then os_ar end) as total_plus4_amount,
			count(distinct(case when dpd=7 and last_call_code<>'OCIN' then primary_1 end)) as total_plus7,
      			count(distinct(case when dpd=7 and last_call_code<>'OCIN' and (skip=1 or is_paid=1) then primary_1 end)) as total_plus7_skip,
      		sum(case when dpd=7 and last_call_code<>'OCIN' then os_ar end) as total_plus7_amount,
			count(distinct(case when dpd=8 and last_call_code<>'OCIN' then primary_1 end)) as total_plus8,
      			count(distinct(case when dpd=8 and last_call_code<>'OCIN' and (skip=1 or is_paid=1) then primary_1 end)) as total_plus8_skip,
      		sum(case when dpd=8 and last_call_code<>'OCIN' then os_ar end) as total_plus8_amount,
			count(distinct(case when dpd=11 and last_call_code<>'OCIN' then primary_1 end)) as total_plus11,
      			count(distinct(case when dpd=11 and last_call_code<>'OCIN' and (skip=1 or is_paid=1) then primary_1 end)) as total_plus11_skip,
      		sum(case when dpd=11 and last_call_code<>'OCIN' then os_ar end) as total_plus11_amount,
			count(distinct(case when dpd=14 and last_call_code<>'OCIN' then primary_1 end)) as total_plus14,
      			count(distinct(case when dpd=14 and last_call_code<>'OCIN' and (skip=1 or is_paid=1) then primary_1 end)) as total_plus14_skip,
      		sum(case when dpd=14 and last_call_code<>'OCIN' then os_ar end) as total_plus14_amount,
			count(distinct(case when dpd=15 and last_call_code<>'OCIN' then primary_1 end)) as total_plus15,
      			count(distinct(case when dpd=15 and last_call_code<>'OCIN' and (skip=1 or is_paid=1) then primary_1 end)) as total_plus15_skip,
      		sum(case when dpd=15 and last_call_code<>'OCIN' then os_ar end) as total_plus15_amount,
			count(distinct(case when dpd>15 and last_call_code<>'OCIN' then primary_1 end)) as total_plus15plus,
      			count(distinct(case when dpd>15 and last_call_code<>'OCIN' and (skip=1 or is_paid=1) then primary_1 end)) as total_plus15plus_skip,
      		sum(case when dpd>15 and last_call_code<>'OCIN' then os_ar end) as total_plus15plus_amount
			from hdr_debtor_main where valdo_cc='01' ";
*/
      	$sql = "select 
			count(distinct(case when dpd=-3 then primary_1 end)) as total_min3,
      			count(distinct(case when dpd=-3 and (skip=1 or is_paid=1) then primary_1 end)) as total_min3_skip,
      		sum(case when dpd=-3 then os_ar end) as total_min3_amount,      			
			count(distinct(case when dpd=0 then primary_1 end)) as total_null,
      			count(distinct(case when dpd=0 and (skip=1 or is_paid=1) then primary_1 end)) as total_null_skip,
      		sum(case when dpd=0 then os_ar  end) as total_null_amount,
			count(distinct(case when dpd=1 then primary_1 end)) as total_plus1,
      			count(distinct(case when dpd=1 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus1_skip,
      		sum(case when dpd=1 then os_ar end) as total_plus1_amount,
			count(distinct(case when dpd=4 then primary_1 end)) as total_plus4,
      			count(distinct(case when dpd=4 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus4_skip,
      		sum(case when dpd=4 then os_ar end) as total_plus4_amount,
			count(distinct(case when dpd=7 then primary_1 end)) as total_plus7,
      			count(distinct(case when dpd=7 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus7_skip,
      		sum(case when dpd=7 then os_ar end) as total_plus7_amount,
			count(distinct(case when dpd=8 then primary_1 end)) as total_plus8,
      			count(distinct(case when dpd=8 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus8_skip,
      		sum(case when dpd=8 then os_ar end) as total_plus8_amount,
			count(distinct(case when dpd=11 then primary_1 end)) as total_plus11,
      			count(distinct(case when dpd=11 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus11_skip,
      		sum(case when dpd=11 then os_ar end) as total_plus11_amount,
			count(distinct(case when dpd=14 then primary_1 end)) as total_plus14,
      			count(distinct(case when dpd=14 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus14_skip,
      		sum(case when dpd=14 then os_ar end) as total_plus14_amount,
			count(distinct(case when dpd=15 then primary_1 end)) as total_plus15,
      			count(distinct(case when dpd=15 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus15_skip,
      		sum(case when dpd=15 then os_ar end) as total_plus15_amount,
			count(distinct(case when dpd>15 then primary_1 end)) as total_plus15plus,
      			count(distinct(case when dpd>15 and (skip=1 or is_paid=1) then primary_1 end)) as total_plus15plus_skip,
      		sum(case when dpd>15 then os_ar end) as total_plus15plus_amount
			from hdr_debtor_main where valdo_cc='01' ";
      	//die($sql);
      	$query = $this->db->query($sql);
      	$data = $query->row_array();

		//reset
		$sql = "update hdr_debtor_main set wb_date_min1=null,wb_date_min2=null where valdo_cc='01'";
		$this->db->query($sql);
		
		$sql = "update hdr_debtor_main set last_call_code='' where last_call_code is null and valdo_cc='01'";
		$this->db->query($sql);
		
		//syncronize		
      	//Update WB Date H-1	
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.wb_date_min1=hc.call_date
			where hdm.valdo_cc='01' and hc.call_date=date(INTERVAL -1 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.wb_date_min1 is null";
      	$this->db->query($sql);

      	//Update WB Date H-2
      	$sql = "update hdr_debtor_main hdm,hdr_calltrack hc
			set hdm.wb_date_min2=hc.call_date
			where hdm.valdo_cc='01' and hc.call_date=date(INTERVAL -2 DAY + now())
			and hdm.primary_1=hc.primary_1
			and hdm.wb_date_min2 is null";
      	$this->db->query($sql);
      	
/* 
      	$sql = "select 
      		count(case when dpd=-2 and wb_date_min1 is null and last_call_code<>'OCIN' then primary_1 end) as total_wk_min2,
      		sum(case when dpd=-2 and wb_date_min1 is null and last_call_code<>'OCIN' then os_ar end) as total_wk_min2_amount,
      		count(case when dpd=-2 and wb_date_min1 is null and (skip=1 or is_paid=1) then primary_1 end) as total_wk_min2_skip,      			
      		count(case when dpd=-1 and (wb_date_min1 is null and wb_date_min2 is null) and last_call_code<>'OCIN' then primary_1 end) as total_wk_min1,
      		sum(case when dpd=-1 and (wb_date_min1 is null and wb_date_min2 is null) and last_call_code<>'OCIN' then os_ar end) as total_wk_min1_amount,
      		count(case when dpd=-1 and (wb_date_min1 is null and wb_date_min2 is null) and (skip=1 or is_paid=1) then primary_1 end) as total_wk_min1_skip,      			

      		count(case when dpd=2 and wb_date_min1 is null then primary_1 end) as total_wk_plus2,
      		sum(case when dpd=2 and wb_date_min1 is null then os_ar end) as total_wk_plus2_amount,
      		count(case when dpd=2 and wb_date_min1 is null and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus2_skip,      			
      		count(case when dpd=3 and wb_date_min1 is null and last_call_code='' then primary_1 end) as total_wk_plus3,
      		sum(case when dpd=3 and wb_date_min1 is null and last_call_code='' then os_ar end) as total_wk_plus3_amount,
      		count(case when dpd=3 and wb_date_min1 is null and last_call_code='' and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus3_skip,      			

      		count(case when dpd=5 and wb_date_min1 is null then primary_1 end) as total_wk_plus5,
      		sum(case when dpd=5 and wb_date_min1 is null then os_ar end) as total_wk_plus5_amount,
      		count(case when dpd=5 and wb_date_min1 is null and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus5_skip,      			
      		count(case when dpd=6 and (wb_date_min1 is null or wb_date_min2 is null) then primary_1 end) as total_wk_plus6,
      		sum(case when dpd=6 and (wb_date_min1 is null or wb_date_min2 is null) then os_ar end) as total_wk_plus6_amount,
      		count(case when dpd=6 and (wb_date_min1 is null or wb_date_min2 is null) and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus6_skip,      			

      		count(case when dpd=9 and wb_date_min1 is null then primary_1 end) as total_wk_plus9,
      		sum(case when dpd=9 and wb_date_min1 is null then os_ar end) as total_wk_plus9_amount,
      		count(case when dpd=9 and wb_date_min1 is null and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus9_skip,      			
      		count(case when dpd=10 and (wb_date_min1 is null or wb_date_min2 is null) then primary_1 end) as total_wk_plus10,
      		sum(case when dpd=10 and (wb_date_min1 is null or wb_date_min2 is null) then os_ar end) as total_wk_plus10_amount,
      		count(case when dpd=10 and (wb_date_min1 is null or wb_date_min2 is null) and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus10_skip,      			

      		count(case when dpd=12 and wb_date_min1 is null then primary_1 end) as total_wk_plus12,
      		sum(case when dpd=12 and wb_date_min1 is null then os_ar end) as total_wk_plus12_amount,
      		count(case when dpd=12 and wb_date_min1 is null and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus12_skip,      			
      		count(case when dpd=13 and (wb_date_min1 is null or wb_date_min2 is null) then primary_1 end) as total_wk_plus13,
      		sum(case when dpd=13 and (wb_date_min1 is null or wb_date_min2 is null) then os_ar end) as total_wk_plus13_amount,
      		count(case when dpd=13 and (wb_date_min1 is null or wb_date_min2 is null) and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus13_skip      			
      			
			from hdr_debtor_main where valdo_cc='01'";
*/
      	$sql = "select 
      		count(case when dpd=-2 then primary_1 end) as total_wk_min2,
      		sum(case when dpd=-2 then os_ar end) as total_wk_min2_amount,
      		count(case when dpd=-2 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_min2_skip,      			
      		count(case when dpd=-1 then primary_1 end) as total_wk_min1,
      		sum(case when dpd=-1 then os_ar end) as total_wk_min1_amount,
      		count(case when dpd=-1 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_min1_skip,      			

      		count(case when dpd=1 then primary_1 end) as total_wk_plus1,
      		sum(case when dpd=1 then os_ar end) as total_wk_plus1_amount,
      		count(case when dpd=1 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus1_skip,  
  
      		count(case when dpd=2 then primary_1 end) as total_wk_plus2,
      		sum(case when dpd=2 then os_ar end) as total_wk_plus2_amount,
      		count(case when dpd=2 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus2_skip,      			
      		count(case when dpd=3 then primary_1 end) as total_wk_plus3,
      		sum(case when dpd=3 then os_ar end) as total_wk_plus3_amount,
      		count(case when dpd=3 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus3_skip,      			

      		count(case when dpd=5 then primary_1 end) as total_wk_plus5,
      		sum(case when dpd=5 then os_ar end) as total_wk_plus5_amount,
      		count(case when dpd=5 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus5_skip,      			
      		count(case when dpd=6 then primary_1 end) as total_wk_plus6,
      		sum(case when dpd=6 then os_ar end) as total_wk_plus6_amount,
      		count(case when dpd=6 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus6_skip,      			

      		count(case when dpd=9 then primary_1 end) as total_wk_plus9,
      		sum(case when dpd=9 then os_ar end) as total_wk_plus9_amount,
      		count(case when dpd=9 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus9_skip,      			
      		count(case when dpd=10 then primary_1 end) as total_wk_plus10,
      		sum(case when dpd=10 then os_ar end) as total_wk_plus10_amount,
      		count(case when dpd=10 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus10_skip,      			

      		count(case when dpd=12 then primary_1 end) as total_wk_plus12,
      		sum(case when dpd=12 then os_ar end) as total_wk_plus12_amount,
      		count(case when dpd=12 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus12_skip,      			
      		count(case when dpd=13 then primary_1 end) as total_wk_plus13,
      		sum(case when dpd=13 then os_ar end) as total_wk_plus13_amount,
      		count(case when dpd=13 and (skip=1 or is_paid=1) then primary_1 end) as total_wk_plus13_skip      			
      			
			from hdr_debtor_main where valdo_cc='01'";
      	//die($sql);
      	$q1 = $this->db->query($sql);
      	$row1 = $q1->row_array();     	       	

      	//DR -2
      	//total data sisa hari sebelumnya days -1
      	//total data -2 di tabel hdr_debtor_main, dikurangi data followup H-1 hari kemaren
      	$data['total_min2'] = $row1['total_wk_min2']-$row1['total_wk_min2_skip'];
      	$data['total_min2_skip'] =  $row1['total_wk_min2_skip'];
      	$data['total_min2_amount'] = $row1['total_wk_min2_amount'];

      	//DR -1
      	//total data sisa hari sebelumnya days -2
      	//total data -2 di tabel hdr_debtor_main, dikurangi data followup H-1 dan H-2 hari yg lalu      	    
      	$data['total_min1'] = $row1['total_wk_min1']-$row1['total_wk_min1_skip'];
      	$data['total_min1_skip'] = $row1['total_wk_min1_skip'];
      	$data['total_min1_amount'] = $row1['total_wk_min1_amount'];
      	
      		//DR 1
      	//total data sisa hari sebelumnya days -2
      	//total data -2 di tabel hdr_debtor_main, dikurangi data followup H-1 dan H-2 hari yg lalu      	    
      	$data['total_plus1'] = $row1['total_wk_plus1']-$row1['total_wk_plus1_skip'];
      	$data['total_plus1_skip'] = $row1['total_wk_plus1_skip'];
      	$data['total_plus1_amount'] = $row1['total_wk_plus1_amount'];
      	       	
      	//D1 2
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0
      	$data['total_plus2'] = $row1['total_wk_plus2']-$row1['total_wk_plus2_skip'];
      	$data['total_plus2_skip'] = $row1['total_wk_plus2_skip'];
      	$data['total_plus2_amount'] = $row1['total_wk_plus2_amount'];
      	 
      	//D1 3
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0      	      	 
      	$data['total_plus3'] = $row1['total_wk_plus3']- $row1['total_wk_plus3_skip'];
      	$data['total_plus3_skip'] = $row1['total_wk_plus3_skip'];
      	$data['total_plus3_amount'] = $row1['total_wk_plus3_amount'];
      	
      	//D1 5
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0      	 
      	$data['total_plus5'] = $row1['total_wk_plus5']-$row1['total_wk_plus5_skip'];
      	$data['total_plus5_skip'] = $row1['total_wk_plus5_skip'];
      	$data['total_plus5_amount'] = $row1['total_wk_plus5_amount'];
      	
      	//D1 6
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0      	 
      	$data['total_plus6'] = $row1['total_wk_plus6']-$row1['total_wk_plus6_skip'];
      	$data['total_plus6_skip'] = $row1['total_wk_plus6_skip'];
      	$data['total_plus6_amount'] = $row1['total_wk_plus6_amount'];

      	//D1 9
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0      	
      	$data['total_plus9'] = $row1['total_wk_plus9']-$row1['total_wk_plus9_skip'];
      	$data['total_plus9_skip'] = $row1['total_wk_plus9_skip'];
      	$data['total_plus9_amount'] = $row1['total_wk_plus9_amount'];
      	 
      	//D1 10
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0      	 
      	$data['total_plus10'] = $row1['total_wk_plus10']-$row1['total_wk_plus10_skip'];
      	$data['total_plus10_skip'] = $row1['total_wk_plus10_skip'];
      	$data['total_plus10_amount'] = $row1['total_wk_plus10_amount'];
      	       	
      	//D1 12
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0      	 
      	$data['total_plus12'] = $row1['total_wk_plus12']-$row1['total_wk_plus12_skip'];
      	$data['total_plus12_skip'] = $row1['total_wk_plus12_skip'];
      	$data['total_plus12_amount'] = $row1['total_wk_plus12_amount'];
      	
      	//D1 13
      	//All Data Muncul Kecuali Object Group 3 data invalid H-3,H-2,H-1 dan 0
      	$data['total_plus13'] = $row1['total_wk_plus13']-$row1['total_wk_plus13_skip'];
      	$data['total_plus13_skip'] = $row1['total_wk_plus13_skip'];
      	$data['total_plus13_amount'] = $row1['total_wk_plus13_amount'];

      	/*
      	count(distinct(case when dpd >= -3 then primary_1 end)) as total_cust,
      	count(distinct(case when dpd >= -3 and (skip=1 or is_paid=1) then primary_1 end)) as total_cust_skip,
      	sum(case when dpd >= -3 then os_ar end) as total_cust_amount
      	*/
      	
      	$total_cust = $data['total_min3'] + $data['total_min2'] + $data['total_min1'] + $data['total_null'] + $data['total_plus1'] + $data['total_plus2'] +
      		$data['total_plus3'] + $data['total_plus4'] + $data['total_plus5'] + $data['total_plus6'] + $data['total_plus7'] + $data['total_plus8'] +
      		$data['total_plus9'] + $data['total_plus10'] + $data['total_plus11'] + $data['total_plus12'] + $data['total_plus13'] + $data['total_plus14'] +
      		$data['total_plus15'] + $data['total_plus15plus'];
      	$total_cust_skip = $data['total_min3_skip'] + $data['total_min2_skip'] + $data['total_min1_skip'] + $data['total_null_skip'] + $data['total_plus1_skip'] + $data['total_plus2_skip'] +
      		$data['total_plus3_skip'] + $data['total_plus4_skip'] + $data['total_plus5_skip'] + $data['total_plus6_skip'] + $data['total_plus7_skip'] + $data['total_plus8_skip'] +
      		$data['total_plus9_skip'] + $data['total_plus10_skip'] + $data['total_plus11_skip'] + $data['total_plus12_skip'] + $data['total_plus13_skip'] + $data['total_plus14_skip'] +
      		$data['total_plus15_skip'] + $data['total_plus15plus_skip'];
      	$total_cust_amount = $data['total_min3_amount'] + $data['total_min2_amount'] + $data['total_min1_amount'] + $data['total_null_amount'] + $data['total_plus1_amount'] + $data['total_plus2_amount'] +
      		$data['total_plus3_amount'] + $data['total_plus4_amount'] + $data['total_plus5_amount'] + $data['total_plus6_amount'] + $data['total_plus7_amount'] + $data['total_plus8_amount'] +
      		$data['total_plus9_amount'] + $data['total_plus10_amount'] + $data['total_plus11_amount'] + $data['total_plus12_amount'] + $data['total_plus13_amount'] + $data['total_plus14_amount'] +
      		$data['total_plus15_amount'] + $data['total_plus15plus_amount'];
      	
      	$data['total_cust'] = $total_cust;
      	$data['total_cust_skip'] = $total_cust_skip;
      	$data['total_cust_amount'] = $total_cust_amount;
      	
      	//die();
      	return $data;      	 
      }
            
      public function od_monitor_calltrack() {
          $sql = "select 
			count(case when hdm.dpd=-3 then hdm.primary_1 end) as total_min3,			
			count(case when hdm.dpd=-2 then hdm.primary_1 end) as total_min2,
			count(case when hdm.dpd=-1 then hdm.primary_1 end) as total_min1,
			count(case when hdm.dpd=0  then hdm.primary_1 end) as total_null,
			count(case when hdm.dpd=1  then hdm.primary_1 end) as total_plus1,
			count(case when hdm.dpd=2  then hdm.primary_1 end) as total_plus2,
			count(case when hdm.dpd=3  then hdm.primary_1 end) as total_plus3,
			count(case when hdm.dpd=4  then hdm.primary_1 end) as total_plus4,
			count(case when hdm.dpd=5  then hdm.primary_1 end) as total_plus5,
			count(case when hdm.dpd=6  then hdm.primary_1 end) as total_plus6,
			count(case when hdm.dpd=7  then hdm.primary_1 end) as total_plus7,
			count(case when hdm.dpd=8  then hdm.primary_1 end) as total_plus8,
			count(case when hdm.dpd=9  then hdm.primary_1 end) as total_plus9,
			count(case when hdm.dpd=10  then hdm.primary_1 end) as total_plus10,
			count(case when hdm.dpd=11  then hdm.primary_1 end) as total_plus11,
			count(case when hdm.dpd=12  then hdm.primary_1 end) as total_plus12,
			count(case when hdm.dpd=13  then hdm.primary_1 end) as total_plus13,
			count(case when hdm.dpd=14  then hdm.primary_1 end) as total_plus14,
			count(case when hdm.dpd=15  then hdm.primary_1 end) as total_plus15,
			count(case when hdm.dpd>15  then hdm.primary_1 end) as total_plus15plus        		
          	from hdr_debtor_main hdm 
          		where hdm.valdo_cc='01' and hdm.id_user>0 and hdm.skip=0 and (hdm.is_paid=0 or hdm.is_paid is null) ";
          $query = $this->db->query($sql);
          $data = $query->row_array();

	      	$total_cust = $data['total_min3'] + $data['total_min2'] + $data['total_min1'] + $data['total_null'] + $data['total_plus1'] + $data['total_plus2'] +
	      		$data['total_plus3'] + $data['total_plus4'] + $data['total_plus5'] + $data['total_plus6'] + $data['total_plus7'] + $data['total_plus8'] +
	      		$data['total_plus9'] + $data['total_plus10'] + $data['total_plus11'] + $data['total_plus12'] + $data['total_plus13'] + $data['total_plus14'] +
	      		$data['total_plus15'] + $data['total_plus15plus'];
	      	
	      	$data['total_cust'] = $total_cust;
          
          return $data;
      }

      public function od_monitor_calltrack_invalid() {
          $sql = "select 
			count(distinct(case when hdm.dpd=-3 then hdm.primary_1 end)) as total_min3,			
			count(distinct(case when hdm.dpd=-2 then hdm.primary_1 end)) as total_min2,
			count(distinct(case when hdm.dpd=-1 then hdm.primary_1 end)) as total_min1,
			count(distinct(case when hdm.dpd=0  then hdm.primary_1 end)) as total_null,
			count(distinct(case when hdm.dpd=1  then hdm.primary_1 end)) as total_plus1,
			count(distinct(case when hdm.dpd=2  then hdm.primary_1 end)) as total_plus2,
			count(distinct(case when hdm.dpd=3  then hdm.primary_1 end)) as total_plus3,
			count(distinct(case when hdm.dpd=4  then hdm.primary_1 end)) as total_plus4,
			count(distinct(case when hdm.dpd=5  then hdm.primary_1 end)) as total_plus5,
			count(distinct(case when hdm.dpd=6  then hdm.primary_1 end)) as total_plus6,
			count(distinct(case when hdm.dpd=7  then hdm.primary_1 end)) as total_plus7,
			count(distinct(case when hdm.dpd=8  then hdm.primary_1 end)) as total_plus8,
			count(distinct(case when hdm.dpd=9  then hdm.primary_1 end)) as total_plus9,
			count(distinct(case when hdm.dpd=10  then hdm.primary_1 end)) as total_plus10,
			count(distinct(case when hdm.dpd=11  then hdm.primary_1 end)) as total_plus11,
			count(distinct(case when hdm.dpd=12  then hdm.primary_1 end)) as total_plus12,
			count(distinct(case when hdm.dpd=13  then hdm.primary_1 end)) as total_plus13,
			count(distinct(case when hdm.dpd=14  then hdm.primary_1 end)) as total_plus14,
			count(distinct(case when hdm.dpd=15  then hdm.primary_1 end)) as total_plus15,
			count(distinct(case when hdm.dpd>15 then hdm.primary_1 end)) as total_plus15plus        		
          	from hdr_calltrack hc, hdr_debtor_main hdm 
          		where hc.primary_1=hdm.primary_1 
          		and hdm.valdo_cc='01' and hc.code_call_track='OCIN'
          		and date(hc.call_date)=date(now())";
          $query = $this->db->query($sql);
          $data = $query->row_array();

	      	$total_cust = $data['total_min3'] + $data['total_min2'] + $data['total_min1'] + $data['total_null'] + $data['total_plus1'] + $data['total_plus2'] +
	      		$data['total_plus3'] + $data['total_plus4'] + $data['total_plus5'] + $data['total_plus6'] + $data['total_plus7'] + $data['total_plus8'] +
	      		$data['total_plus9'] + $data['total_plus10'] + $data['total_plus11'] + $data['total_plus12'] + $data['total_plus13'] + $data['total_plus14'] +
	      		$data['total_plus15'] + $data['total_plus15plus'];
	      	
	      	$data['total_cust'] = $total_cust;
          
          return $data;
      }
	function getAllDashboardAdira(){
		$this->db = $this->load->database('ems',true);
		$whr = "WHERE `company`=0";
		
		$query = $this -> db -> query( "SELECT date(tgl) as tglnow,
				total_data AS totdat,
				 od30,
				od1,
				od0,
				od2 as od_2,
				od3 AS od_3,
				contact AS statdone,
				c_od30 AS 30done,
				c_od1 AS 1done,
				c_od0 AS 0done,
				c_od2 AS _2done,
				c_od3 AS _3done,
				uncontact AS statrun,
				uc_od30 AS 30run,
				uc_od1 AS 1run,
				uc_od0 AS 0run,
				uc_od2 AS _2run,
				uc_od3 AS _3run,
				data_invalid as invalid,
				in_od30 as 30invalid,
				in_od1 as 1invalid,
				in_od0 as 0invalid,
				in_od2 as _2invalid,
				in_od3 as _3invalid
				FROM `temp_campains` AS t1 
				where date(tgl) = curdate() group by tglnow" );
		$result = $query->result_array();		
		return $result;
	}
	function get_data(){
		//$this->db = $this->load->database('ems',true);
		$query = $this-> db -> query( "SELECT tgl AS tglnow,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='08' ORDER BY jam ASC LIMIT 1) AS 8pm,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='08' AND MINUTE(jam) ='30' ORDER BY jam ASC LIMIT 1) AS 830pm,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='09' ORDER BY jam ASC LIMIT 1) AS 9pm,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='09' AND MINUTE(jam) ='30' ORDER BY jam ASC LIMIT 1) AS 930pm,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='10' ORDER BY jam ASC LIMIT 1) AS 10pm,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='10' AND MINUTE(jam) ='30' ORDER BY jam ASC LIMIT 1) AS 1030pm,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='11' ORDER BY jam ASC LIMIT 1) AS 11pm,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='11' AND MINUTE(jam) ='30' ORDER BY jam ASC LIMIT 1) AS 1130pm,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='12' ORDER BY jam ASC LIMIT 1) AS 12pm,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='12' AND MINUTE(jam) ='30' ORDER BY jam ASC LIMIT 1) AS 1230pm,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='13' ORDER BY jam ASC LIMIT 1) AS 1am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='13' AND MINUTE(jam) ='30' ORDER BY jam ASC LIMIT 1) AS 130am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='14' ORDER BY jam ASC LIMIT 1) AS 2am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='14' AND MINUTE(jam) ='30' ORDER BY jam ASC LIMIT 1) AS 230am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='15' ORDER BY jam ASC LIMIT 1) AS 3am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='15' AND MINUTE(jam) ='30' ORDER BY jam ASC LIMIT 1) AS 330am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='16' ORDER BY jam ASC LIMIT 1) AS 4am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='16' AND MINUTE(jam) ='30' ORDER BY jam ASC LIMIT 1) AS 430am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='17' ORDER BY jam ASC LIMIT 1) AS 5am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='17' AND MINUTE(jam) ='30' ORDER BY jam ASC LIMIT 1) AS 530am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='18' ORDER BY jam ASC LIMIT 1) AS 6am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='18' AND MINUTE(jam) ='30' ORDER BY jam ASC LIMIT 1) AS 630am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='19' ORDER BY jam ASC LIMIT 1) AS 7am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='19' AND MINUTE(jam) ='30' ORDER BY jam ASC LIMIT 1) AS 730am,
						(SELECT IFNULL(total,0) FROM temp_campains2 WHERE HOUR(jam) ='20' ORDER BY jam ASC LIMIT 1) AS 8am
						FROM temp_campains2 WHERE DATE(NOW()) GROUP BY tgl" );
		$result = $query->result_array();
		return $result;
	}


  }