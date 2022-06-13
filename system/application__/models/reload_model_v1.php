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