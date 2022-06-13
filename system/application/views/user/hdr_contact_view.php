<!--
  This script software package is NOT FREE And is Copyright 2010 (C) Valdo-intl all rights reserved.
  we do supply help or support or further modification to this script by Contact
  Haidar Mar'ie
  e-mail = haidar.m@valdo-intl.com
  e-mail = coder5@ymail.com
-->
<script  type="text/javascript">

	$(function() {
		var limit;
		var type = '<?php echo $a_value[23]; ?>';
		var score_r = '<?php echo $a_value[34]; ?>';
		var od = '<?php echo $a_value[6]; ?>';
		var d = '<?php echo date('d'); ?>';
		var m = '<?php echo date('m'); ?>';
		var Y = '<?php echo date('Y'); ?>';
		limit = jQuery('#limit').val();
		/*alert(Y);
		if(m == '01' || m == '03' || m == '05' || m == '07' || m == '08' || m == '10' || m == '12'){
			if(d == '31'){
				var her1 = 'now';
				var her2 = 'now';
				var her3 = 'now';
			}else if(d == '29'){
				var her1 = '+2d';
				var her2 = '+2d';
				var her3 = '+1d';
			}else if(d == '30'){
				var her1 = '+1d';
				var her2 = '+1d';
				var her3 = '+1d';
			}else{
				var her1 = '+3d';
				var her2 = '+2d';
				var her3 = '+1d';
			}
		}else if(m == '04' || m == '06' || m == '09' || m == '11'){
			if(d == '30'){
				var her1 = 'now';
				var her2 = 'now';
				var her3 = 'now';
			}else if(d == '28'){
				var her1 = '+2d';
				var her2 = '+2d';
				var her3 = '+1d';
			}else if(d == '29'){
				var her1 = '+1d';
				var her2 = '+1d';
				var her3 = '+1d';
			}else{
				var her1 = '+3d';
				var her2 = '+2d';
				var her3 = '+1d';
			}
		}else if(m == '02'){
			
			if(Y % 4 == 0 && d == '29'){
				
				var her1 = 'now';
				var her2 = 'now';
				var her3 = 'now';
			}else if(Y % 4 != '0' && d == '28'){
				var her1 = 'now';
				var her2 = 'now';
				var her3 = 'now';
			}else{
				var her1 = '+3d';
				var her2 = '+2d';
				var her3 = '+1d';
			}
		}
		//alert(her1);
		//var today = new Date();
		//var ptp_max = today.setDate(today.getDate() + her1);
		//$('#datepicker_r').datepicker('getDate', her1);
		//alert(ptp_max);
		/*
		if(type == '003' || type == '004'){
			if(od == '-3' || od == '1' || od == '2' || od == '3' || od == '4' || od == '8' || od == '9' || od == '10' || od == '11' || od == '12'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: her1,
						changeYear: false
						//changeMonth: true,
						//changeYear: true
					});
			}else if(od == '-2' || od == '5' || od == '13'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: her2,
						changeYear: false
						//changeMonth: true,
						//changeYear: true
					});
			}else if(od == '-1' || od == '6' || od == '14'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: her3,
						changeYear: false
						//changeMonth: true,
						//changeYear: true
					});
			}else if(od == '0' || od == '7' || od == '15'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
						//changeMonth: true,
						//changeYear: true
					});
			}
					
		}  else*/	
if(28 == d){
		$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '3',
						maxDate: '3',
						changeYear: false
						//changeMonth: true,
						//changeYear: true
					});

		}else if(29 == d){
		$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
						//changeMonth: true,
						//changeYear: true
					});

		}else if(30 == d ){
		$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
						//changeMonth: true,
						//changeYear: true
					});

		}else if(31 == d ){
		$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
						//changeMonth: true,
						//changeYear: true
					});

		}else if(type == '001' && score_r=='HIGH'){
				 if(od == '4'|| od == '8'|| od == '13'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
					});
				}else if(od == '5'|| od == '9'|| od == '14'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
					});
				}else if(od == '6'|| od == '10'|| od == '15'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
					});
				}else{
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '3',
						maxDate: '3',
						changeYear: false
					});
				} 
			}else if(type == '001' && score_r=='MEDIUM'){
				 if(od == '5'|| od == '9' || od == '18'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
					});
				} else if(od == '6'|| od == '10' || od == '19'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
					});
				}else if(od == '7'|| od == '11'|| od == '20'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
					});
				}else{
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '3',
						maxDate: '3',
						changeYear: false
					});
				}												
			}	else if(type == '001' && score_r=='LOW'){
				 if(od == '9'|| od == '14' || od == '23'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
					});
				}else if(od == '10'|| od == '15' || od == '24'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
					});
				}else if(od == '11'|| od == '16' || od == '25'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
					});
				}else{
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '3',
						maxDate: '3',
						changeYear: false
					});
				}																
			}else if(type == '002' && score_r=='MEDIUM'){
				 if(od == '13' || od == '19'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
					});
				}else if(od == '8'|| od == '14' || od == '20'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
					});
				}else if(od == '7'|| od == '9'|| od == '15' || od == '21'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
					});				
				}else{
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '3',
						maxDate: '3',
						changeYear: false
					});
				}																
				}else if(type == '002' && score_r=='HIGH'){
				  if(od == '5'|| od == '11' || od == '17'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
					});
				}else if(od == '6'|| od == '12' || od == '18'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
					});
				}else if(od == '7'|| od == '13' || od == '19'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
					});
				}else{
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '3',
						maxDate: '3',
						changeYear: false
					});
				}																
				}else if(type == '002' && score_r=='LOW'){
				  if(od == '9'|| od == '16' || od == '23'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
					});
				}else if(od == '10'|| od == '17' || od == '24'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
					});
				}else if(od == '11'|| od == '18' || od == '25'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
					});
				}else{
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '3',
						maxDate: '3',
						changeYear: false
					});
				}																
				}else if(type == '003' && score_r=='HIGH'){
				 if(od =='1'||od == '4'||od =='8'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
					});
				}else if(od =='2'||od=='5' ||od=='9'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
					});
				}else if(od =='10'|| od == '3'|| od == '6'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
					});
				}															
				}else if(type == '003' && score_r=='MEDIUM'){
				  if(od == '3'|| od =='8'||od=='13'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
					});
				}else if(od == '4'|| od == '9' || od == '14'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
					});
				}else if(od == '5'|| od == '10' || od == '15'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
					});
				}else{
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '3',
						maxDate: '3',
						changeYear: false
					});
				}																
				}else if(type == '003' && score_r == 'LOW'){
				  if(od =='8'||od =='15'||od =='22'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
					});
				}else if(od =='9'||od =='16'||od=='23'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
					});
				}else if(od=='10'||od=='17'||od=='24'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
					});
				}													
				}else if(type == '004' && score_r=='LOW'){
				  if(od == '11'|| od == '18' || od == '25'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
					});
				}else if(od == '12'|| od == '19' || od == '26'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
					});
				}else if(od == '13'|| od == '20' || od == '27'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
					});
				}else{
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '3',
						maxDate: '3',
						changeYear: false
					});
				}																
				}else if(type == '004' && score_r=='MEDIUM'){
				  if(od == '8'|| od == '15' || od == '22'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
					});
				}else if(od == '9'|| od == '16' || od == '23'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
					});
				}else if(od == '10'|| od == '17' || od == '24'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
					});
				}else{
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '3',
						maxDate: '3',
						changeYear: false
					});
				}																
				}else if(type == '004' && score_r=='HIGH'){
				 if(od == '6'|| od == '13' || od == '20'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '2',
						maxDate: '2',
						changeYear: false
					});
				}else if(od == '7'|| od == '14' || od == '21'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '1',
						maxDate: '1',
						changeYear: false
					});
				}else if(od == '8'|| od == '15' || od == '22'){
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: 'now',
						maxDate: 'now',
						changeYear: false
					});
				}else{
					$('#datepicker_r').datepicker({
						showOn: 'button',
						buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',
						buttonImageOnly: true,
						dateFormat: 'yy-mm-dd',
						minDate: '3',
						maxDate: '3',
						changeYear: false
					});
				}																
				}
			});


    function get_input(url){
    jQuery.post(url,{

    search_acct : jQuery('input[name=search_acct]').val(),
    search_card_no : jQuery('input[name=search_card_no]').val(),
    name_debt : jQuery('input[name=name_debt]').val(),
    nxt_card : jQuery('input[name=nxt_card]').val(),
    post : jQuery('#post').val(),
    post : true
    }, function(html) {
    showPopUp('Confirmation','<div style="width:250px"><center>'+html+'</center></div>','Cancel [x]');
    });

    }
    function changePTP(value){
    //alert(value);
    if(value=='02,Janji Bayar'){
    jQuery('#cont_ptp').fadeIn(1000);
  
    var date = jQuery('#datepicker_r').val();
    calculate_due(date);
    jQuery('#id_action_call_track').val('11,OCAA,1');
  		
    }else if(value=='03,CUSTOMER TIDAK DIKENAL/SALAH SAMBUNG'){
    //jQuery('#cont_ptp').fadeIn(1000);
  
    //var date = jQuery('#datepicker_r').val();
    //calculate_due(date);
    jQuery('#id_action_call_track').val('30,OFAC,1');
  		
    }else if(value=='01,TITIP PESAN'){
    jQuery('#cont_ptp').fadeOut(1000);
  
    //var date = jQuery('#datepicker_r').val();
    //calculate_due(date);
    jQuery('#id_action_call_track').val('29,OCAC,1');
  		
    }else if(value=='07,CUSTOMER KEBERATAN MEMBAYAR'){
    //jQuery('#cont_ptp').fadeIn(1000);
  
    //var date = jQuery('#datepicker_r').val();
    //calculate_due(date);
    jQuery('#id_action_call_track').val('12,OCAB,1');
  		
    }
    else{
    jQuery('#cont_ptp').fadeOut(1000);
    }

    if(value=='52,DXXX,0'){
    jQuery('#call_back').fadeIn(1000);
    }	else {
    jQuery('#call_back').fadeOut(1000);
    }
    }

  /*
    function res(value){
    	var new_val;
    	var min_val = '<?php echo($a_value[7]); ?> ';
    	new_val = value.replace('.','');
    	min_val = min_val*1;
    	new_val = new_val*1;
    		if(new_val < min_val){
    			$('#ptp_amount').val(addCommas(min_val));
    		}
    	return false;
    }
    */
    function addCommas(nStr)
	{
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}

    function calculate_due(date){

    	var due_date_tmp = "<?php echo $a_value[17]; ?>";

    	var due_date = new Date;
    	var sel_date = new Date;

      //selected_date
   	  var new_date = date.split("-");
   	  new_date[1] = (new_date[1] - 1) ;
   	  sel_date.setFullYear(new_date[0],new_date[1],new_date[2]);

   	  //due_date
   	  var new_due_date = due_date_tmp.split("-");
   	  new_due_date[1] = (new_due_date[1] - 1);
   	  due_date.setFullYear(new_due_date[0],new_due_date[1],new_due_date[2]);

   	  //alert(sel_date)
   	  //alert(due_date);
   	  var difTime = (sel_date.getTime()  - due_date.getTime());
   	  var dif = (difTime/(24*3600*1000));

   	  //alert(dif);



   	  //get type product
   	  var type = "<?php echo trim($a_value[23]); ?>";
   	  var angsuran = "<?php echo trim($a_value[7]); ?>";
   	  angsuran = (angsuran*1);
   	  //motor
   	  if (type == "001" || type == 001){
   	  	charge = (0.005*angsuran*dif);
   	  	totalcharge = (angsuran+charge);
   	  }else
   	  	{
   	  		charge = (0.002*angsuran*dif);
   	  		totalcharge = (angsuran+charge);
   	  	}
   	  	//alert(dif);
   	 	jQuery('#due_val').html(charge);
   	  jQuery('#ptp_amount').val(totalcharge);
   	   /*
   	   $('.ptp_amount').priceFormat({
    			prefix: '',
    			centsSeparator: '',
    			thousandsSeparator: '.',
    			centsLimit: 0
   			 });
   			*/
   		$('.due_val').priceFormat({
    			prefix: '',
    			centsSeparator: '',
    			thousandsSeparator: '.',
    			centsLimit: 0
   			 });
   			 //alert('a');

    }



    function changeAction(value){
    	var code;
    	code = "";
    	code = value.substr(0,2);

    	//reset deliquency dan ptp selection box
    	$("#id_ptp").val('0');

    	//alert(code);
    		if(code==28 || code==13 || code==30)
    		{
    			//contacted
    		 jQuery('#handling_debt').fadeIn(1000);
    		 jQuery('#id_ptp').fadeIn(1000);
    		 //alert("A");
    		}
    		// Line Busy
    		else if(code=="9,")
    		{
    			//no contact

    			jQuery('#id_ptp').fadeOut(1000)
    			jQuery('#cont_ptp').fadeOut(1000);
    			jQuery('#id_handling_debt').fadeOut(1000);
    			//alert("B");
    		}
    		//No Answer
    		else if(code=="8,")
    		{
    			//no contact

    			jQuery('#id_ptp').fadeOut(1000)
    			jQuery('#cont_ptp').fadeOut(1000);
    			jQuery('#id_handling_debt').fadeOut(1000);
    			//alert("C");
    		}
    		//Invalid Number
    		else if(code=="10")
    		{
    			//no contact
    			jQuery('#id_ptp').fadeOut(1000)
    			jQuery('#cont_ptp').fadeOut(1000);
    			jQuery('#id_handling_debt').fadeOut(1000);
    			//alert("D");
    		}
    		else {
    			//contacted
    			jQuery('#handling_debt').fadeOut(1000)
    		 	jQuery('#id_ptp').fadeIn(1000)
    		 	jQuery('#id_handling_debt').fadeIn(1000);
    		 	$('#handling_debt').find("option[value='00']").attr("selected",true);
    		 	//alert("E");
    		}
    }


    function ptpKey(value){
    if(value =="PTP" || value =="ptp"){
    jQuery('#cont_ptp').fadeIn(1000)
    }
    else{
    jQuery('#cont_ptp').fadeOut(1000);
    }
    }
    function changePTPagen(value){
    if(value==6 ){
    jQuery('#agen_ptp').fadeIn(1000)
    }
    else{
    jQuery('#agen_ptp').fadeOut(1000);
    }
    }
    function callPopup(url,value){
    //notif.hide();
    loading('<h2>Calling '+value+'  Please wait......<br/>if take more than 5 sec press F5</h2>');
    jQuery.get(url,{
    }, function(html) {
    finsihCall(html);
    });
    }
    function finsihCall(html){
    notif.hide();
    notif = new Boxy('<div id="load" style="text-align:center">'+html+'&nbsp;&nbsp;<a href="#" onclick="Boxy.get(this).hide(); return false">[X] Close!</a></div>', {
    modal: false,unloadOnHide:true
    });
    //jQuery('#loading_content').html("");

    }
    function addPhone(url,id){
    if(id !='add'){
    jQuery("#phone_"+id).remove();
    }
    var phone_no = jQuery('#phone_no').val();
    //var phone = +phone_no.replace(/\D/g,'');
    //alert(url);
    jQuery.post(url,{
    phone_no : phone_no,
    phone_type : jQuery('#phone_type').val(),
    primary_1 : jQuery('#primary_1').val(),
    id_phone : jQuery('#id_phone').val(),
    post : true
    }, function(html) {
    setSubmitPhone(html)
    //alert(html);
    });
    }
    function addAddress(url,id){
    if(id !=''){
    jQuery("#address_"+id+"_a").remove();
    jQuery("#address_"+id+"_b").remove();
    jQuery("#address_"+id+"_c").remove();
    jQuery("#address_"+id+"_d").remove();
    jQuery("#address_"+id+"_e").remove();
    jQuery("#address_"+id+"_f").remove();
    jQuery("#address_"+id+"_g").remove();
    }
    jQuery.post(url,{
    type : jQuery('#type').val(),
    address : jQuery('#address').val(),
    city : jQuery('#city').val(),
    zip_code : jQuery('#zip_code').val(),
    id_address : jQuery('#id_address').val(),
    phone_no : jQuery('#phone_no').val(),
    is_tagih: jQuery('input[name=is_tagih]:checked').val(),
    primary_1 : jQuery('#primary_1').val(),
    flag : jQuery('#flag').val(),
    post : true
    }, function(html) {
    setSubmitAddress(html)
    //alert(html);
    });
    }
    function deletePhone(url,id){
    if(confirm("Do you want to proceed?")){
    jQuery.post(url,{
    }, function(html) {
    telli(html);
    jQuery("#phone_"+id).remove();
    });
    }
    }
    function deleteAddress(url,id){
    if(confirm("Do you want to proceed?")){
    jQuery.post(url,{
    }, function(html) {
    telli(html);
    jQuery("#address_"+id+"_a").remove();
    jQuery("#address_"+id+"_b").remove();
    jQuery("#address_"+id+"_c").remove();
    jQuery("#address_"+id+"_d").remove();
    jQuery("#address_"+id+"_e").remove();
    jQuery("#address_"+id+"_f").remove();
    jQuery("#address_"+id+"_g").remove();
    });
    }
    }
    function addInfo(url,id){
    if(id !='add'){
    jQuery("#info_"+id).remove();
    }
    var info = jQuery('#info').val();
    jQuery.post(url,{
    info : info,
    primary_1 : jQuery('#primary_1').val(),
    id_debtor_info : jQuery('#id_debtor_info').val(),
    post : true
    }, function(html) {
    setSubmitInfo(html)
    //alert(html);
    });
    }
    function setSubmitPhone(html){
    notif.hide();
    set_berhasil("New Phone No Has been added");
    jQuery("#debtor_info").append(html);
    }

    function setSubmitAddress(html){
    notif.hide();
    set_berhasil("New Address has been added");
    jQuery("#address_info").append(html);
    }

    function setSubmitInfo(html){
    notif.hide();
    set_berhasil("New Info  Has been added");
    jQuery("#addInfo").append(html);
    jQuery("#view_info").remove();
    }

    // for valdo dial

    function get_phone(value){
    //var phone = +value.replace(/\D/g,'');
    //alert(phone);

    /*if(confirm("Apakah ingin telefon otomatis?")){
    if(value!=""){
    location.href='<?php echo site_url() ?>/user/hdr_contact_cont/call_debtor/'+value;
    }
    }*/
    location.href='<?php echo site_url() ?>/user/hdr_contact_cont/call_debtor/'+value;
    $('#no_contacted').val(value);
    }

   //## Martin-> fungsi call baru ##//

   function call(val,val2) {
   	var is_paid = '<?php echo($get_main_info->is_paid); ?>';
   	var is_called = '<?php echo($get_main_info->called); ?>';
	var last_call_code = '<?php echo($get_main_info->last_call_code); ?>';
   	//alert(is_called);
   	//return;
   	if(!val || val == "" || val.length <= 5){
   		alert('Invalid Number');
   		return;
   	}
   	else if (is_paid == "1" || is_paid == 1){
   		alert('This Debtor Already Paid !!');
   		return;
   	}
   	/*else if ((is_called == "1" || is_called == 1) && last_call_code != 'OCNA'){
   		alert('Same Debtor Cannot be Called More Than Once,Try Again Tomorrow !!');
   		return;
   	}*/
   	else
   		{
   			var primary_1 = $('#primary_1').val();
   			var channel_user = '<?php echo($user_info->pabx_ext); ?>';
   			var phone_num = val;
   			var cust_id = '<?php echo($a_value[2]); ?>';
   			var custname = '<?php echo($a_value[3]); ?>';
   			var checkUrl = '<?php echo site_url() ?>/user/hdr_contact_cont/checkRealTimeLock/';
   			redUrl = '<?php echo site_url() ?>/user/hdr_contact_cont/contact/call';
   		  // start RealTime Checker

   		  $.post(checkUrl,{primary_1:primary_1},function(feedback){

   		  	if(feedback*1 == 1){
   		  		callerHandler();
   		  	} else {
				if(last_call_code == 'OCNA'){
					callerHandler();
				}else{
					alert('Account ini terkunci diuser lain, hindari penggunaan banyak tab secara bersamaan. \nSystem akan mengalihkan layar anda.');
					location.href = redUrl;
				}
   		  		
   		  	}

   		  });

   		  function callerHandler(){

   		  	var html = "<center><div style='width:128px;height:128px'><img src='<?php echo base_url() ?>assets/images/call.gif' width='64' height='64'><br/><br/><img src='<?php echo base_url() ?>assets/images/connecting.gif'></div></center>";

   		  	notif = new Boxy(html, {
    					title:"Calling",modal: true,unloadOnHide:true,closeText:"[X] Close!"
    			});

    			notif.tween(300,128,goCall());
    			notif.show();


    			//ajax Caller
    			function goCall(){

    				//var callerInitLink = 'http://172.25.150.201/cc-adira/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user;
				if(channel_user == '3001' || channel_user == '3002' || channel_user == '3003'|| channel_user == '3004' || channel_user == '3005' || channel_user == '3006' || channel_user == '3007' || channel_user == '3008' || channel_user == '3009'|| channel_user == '3010' || channel_user == '3011' || channel_user == '3012'  
					||channel_user == '3013' || channel_user == '3014' || channel_user == '3015'|| channel_user == '3016' || channel_user == '3017' || channel_user == '3018' || channel_user == '3019' || channel_user == '3020' || channel_user == '3021'|| channel_user == '3022' || channel_user == '3023' || channel_user == '3024'
					||channel_user == '3025' || channel_user == '3026' || channel_user == '3027'|| channel_user == '3028' || channel_user == '3029' || channel_user == '3030' || channel_user == '3031' || channel_user == '3032' || channel_user == '3033'|| channel_user == '3034' || channel_user == '3035' || channel_user == '3036'
					||channel_user == '3037' || channel_user == '3038' || channel_user == '3039'|| channel_user == '3040' || channel_user == '3041' || channel_user == '3042' || channel_user == '3043' || channel_user == '3044' || channel_user == '3045'|| channel_user == '3046' || channel_user == '3047' || channel_user == '3048'
					||channel_user == '3049' || channel_user == '3050' || channel_user == '3051'|| channel_user == '3052' || channel_user == '3053' || channel_user == '3054' || channel_user == '3055' || channel_user == '3056' || channel_user == '3057'|| channel_user == '3058' || channel_user == '3059' || channel_user == '3060'
					||channel_user == '3061' || channel_user == '3062' || channel_user == '3063'|| channel_user == '3064' || channel_user == '3065' || channel_user == '3066' || channel_user == '3067' || channel_user == '3068' || channel_user == '3069'|| channel_user == '3070' || channel_user == '3071' || channel_user == '3072'
					||channel_user == '3073' || channel_user == '3074' || channel_user == '3075'|| channel_user == '3076' || channel_user == '3077' || channel_user == '3078' || channel_user == '3079' || channel_user == '3080' || channel_user == '3081'|| channel_user == '3082' || channel_user == '3083' || channel_user == '3084'
					||channel_user == '3085' || channel_user == '3086' || channel_user == '3087'|| channel_user == '3088' || channel_user == '3089' || channel_user == '3090' || channel_user == '3091' || channel_user == '3092' || channel_user == '3093'|| channel_user == '3094' || channel_user == '3095' || channel_user == '3096' || channel_user == '3097' || channel_user == '3098' || channel_user == '3099')
				{
					//var callerInitLink = 'http://172.25.150.201/cc-frontend-erza/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user;
					//var callerInitLink = 'http://172.25.150.201/cc-jogja/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user;
					//var callerInitLink = 'http://172.25.150.131/cc-jogja/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user;
					//var callerInitLink = 'http://172.25.55.232/cc-jogja/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user;
					//var callerInitLink = 'http://10.14.14.12/cc-jogja/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user;
					//var callerInitLink = 'http://172.25.150.21/cc-frontend/api/injectcall?recid='+cust_id+'&line_number='+channel_user+'&dari=SIP/'+channel_user+'&to='+phone_num+'&no_kontrak='+cust_id+'&custname='+custname;
					var callerInitLink = 'http://10.14.14.146/cc-frontend/api/injectcall?recid='+cust_id+'&line_number='+channel_user+'&dari=SIP/'+channel_user+'&to='+phone_num+'&no_kontrak='+cust_id+'&custname='+custname;

					
				}
				else if(channel_user == '2001' || channel_user == '2002' || channel_user == '2003'|| channel_user == '2004' || channel_user == '2005' || channel_user == '2006' || channel_user == '2007' || channel_user == '2008' || channel_user == '2009'|| channel_user == '2010' || channel_user == '2011' || channel_user == '2012'  
					||channel_user == '2013' || channel_user == '2014' || channel_user == '2015'|| channel_user == '2016' || channel_user == '2017' || channel_user == '2018' || channel_user == '2019' || channel_user == '2020' || channel_user == '2021'|| channel_user == '2022' || channel_user == '2023' || channel_user == '2024'
					||channel_user == '2025' || channel_user == '2026' || channel_user == '2027'|| channel_user == '2028' || channel_user == '2029' || channel_user == '2030' || channel_user == '2031' || channel_user == '2032' || channel_user == '2033'|| channel_user == '2034' || channel_user == '2035' || channel_user == '2036'
					||channel_user == '2037' || channel_user == '2038' || channel_user == '2039'|| channel_user == '2040' || channel_user == '2041' || channel_user == '2042' || channel_user == '2043' || channel_user == '2044' || channel_user == '2045'|| channel_user == '2046' || channel_user == '2047' || channel_user == '2048'
					||channel_user == '2049' || channel_user == '2050' || channel_user == '2051'|| channel_user == '2052' || channel_user == '2053' || channel_user == '2054' || channel_user == '2055' || channel_user == '2056' || channel_user == '2057'|| channel_user == '2058' || channel_user == '2059' || channel_user == '2060'
					||channel_user == '2061' || channel_user == '2062' || channel_user == '2063'|| channel_user == '2064' || channel_user == '2065' || channel_user == '2066' || channel_user == '2067' || channel_user == '2068' || channel_user == '2069'|| channel_user == '2070' || channel_user == '2071' || channel_user == '2072'
					||channel_user == '2073' || channel_user == '2074' || channel_user == '2075'|| channel_user == '2076' || channel_user == '2077' || channel_user == '2078' || channel_user == '2079' || channel_user == '2080' || channel_user == '2081'|| channel_user == '2082' || channel_user == '2083' || channel_user == '2084'
					||channel_user == '2085' || channel_user == '2086' || channel_user == '2087'|| channel_user == '2088' || channel_user == '2089' || channel_user == '2090' || channel_user == '2091' || channel_user == '2092' || channel_user == '2093'|| channel_user == '2094' || channel_user == '2095' || channel_user == '2096' || channel_user == '2097' || channel_user == '2098' || channel_user == '2099')
				{
					//var callerInitLink = 'http://172.25.150.5/cc-frontend/api/injectcall?recid='+cust_id+'&line_number='+channel_user+'&dari=SIP/'+channel_user+'&to='+phone_num+'&no_kontrak='+cust_id+'&custname='+custname;
					var callerInitLink = 'http://10.14.14.145/cc-frontend/api/injectcall?recid='+cust_id+'&line_number='+channel_user+'&dari=SIP/'+channel_user+'&to='+phone_num+'&no_kontrak='+cust_id+'&custname='+custname;
	
				} else
				{
					//var callerInitLink = 'http://172.25.150.201/cc-jogja/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user;
					//var callerInitLink = 'http://172.25.150.201/cc-frontend/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user;
					//var callerInitLink = 'http://172.25.116.163/cc-project/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user;
					//var callerInitLink = 'http://172.25.55.232/cc-jogja/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user;
					var callerInitLink = 'http://10.14.14.12/cc-jogja/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user;


				}

    				var jqxhr = $.post(callerInitLink,function(data){

    				});

   					setTimeout(function(){
   						notif.hide();
   						$('#remarks').attr('disabled',false);
   					},2000);

   					$('#no_contacted').val(val);
						$('#call_handling').val(val2);

   				}
   		  }

   			//var url = 'http://172.25.150.201/cc/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user,'Dialup','width=400,height=200';
   			//window.open('http://172.25.150.201/cc-adira/dial_number.php?dari=SIP/'+channel_user+'&to='+phone_num+'&recid='+cust_id+'&custname='+custname+'&line_number='+channel_user,'Dialup','width=400,height=200');
   		}
   }

       //submiting callback
    function callbackInputCheck(){
    $('#example3').attr('disabled','disabled');
   	$('#cb_notes').attr('disabled','disabled');
   	$('#cb_submit').fadeOut('fast');
   	$('#cb_indicator').html('Submiting ...').fadeIn('slow');
   	var err_flag = 0;

   	var time_remind = $('#example3').val();
   	var notes = $('#cb_notes').html();

   	notes = notes.replace(/[^A-Z0-9\s\.:,]/gi,'');
   	notes = notes.replace(/\s(\s+)/gi,' ');

   	if(time_remind.match(/[0-9][0-9]:[0-9][0-9]/g) == null){
   		telli('Please Submit Your Remind Time');
   		$('#example3').attr('disabled',false);
   		$('#cb_notes').attr('disabled',false);
   		$('#cb_submit').fadeIn('slow');
   		$('#cb_indicator').html('Failed !!').fadeOut('slow');
   		err_flag = 1;
   		return;
   	}
   	if(notes.length > 50 ){
   		telli('Only 50 Char Allowed');
   		$('#example3').attr('disabled',false);
   		$('#cb_notes').attr('disabled',false);
   		$('#cb_submit').fadeIn('slow');
   		$('#cb_indicator').html('Failed !!').fadeOut('slow');
   		err_flag = 1;
   		return;
   	}

   			if(err_flag == 0){
   				submitCallback(time_remind,notes);
   			}

    }

    function submitCallback(time_remind,notes){
   		var url = "<?= site_url() ?>user/hdr_contact_cont/submitCallback/";
   		var primary_1 = $('#primary_1').val();
   		var id_user = jQuery('#id_user').val();
			$.post(url,{
						time_remind : time_remind,
						notes : notes,
						primary_1 : primary_1,
						id_user : id_user
					}
			,function(data){
				if(data && data > 0){
					telli('System Will Remind You Later at '+time_remind);
					$('#cb_indicator').fadeOut('fast');
					$('#cb_indicator').html('Done !!').fadeIn('slow');
					var nextUrl = "<?= site_url() ?>user/hdr_contact_cont/contact/call/";
					setTimeout(function(){
							location.href = nextUrl;
						},2000);
				}else if(data && data == -1){
					telli('You cannot add more then 10 active reminder, be wise');
					$('#cb_indicator').fadeOut('fast');
					$('#cb_indicator').html('Failed !!').fadeIn('slow');
				}
				//alert(data);
			});
   }

   	  function upperThis(obj_id){
	    var str = $('#'+obj_id).val();
	    	//try another method
	    if(str == undefined){
	    	var str = $('#'+obj_id).html();
	    }
	    var countChar = str.length;
	    str = str.toUpperCase();
	    $('#'+obj_id).val(str);
	    $('#'+obj_id).html(str);
	    $('#notes_charCount').html(countChar);
	    if(countChar > 50){
	    		$('#notes_charCount').css(
	    			'color','red');
	    } else {
	    		$('#notes_charCount').css(
	    				'color','green');
	    }
	  }

	  function clearThis(obj_id,def){
   	  var str = $('#'+obj_id).val();
    	//try another method
    	if(str == undefined){
    		var str = $('#'+obj_id).html();
    	}

    	if(str == def){
	   		$('#'+obj_id).val('');
	   		$('#'+obj_id).html('');
   		}
   }

   //#################################//

    <?php
    $_SESSION['work'] = '1';

    $today = date("Y-m-d");
    $sum = strtotime(date("Y-m-d", strtotime("$today")) . " +3 days");
    $maxptpdate = date('Y-m-d', $sum);
    $dateTo = date('l') . ' ' . date_formating(date('Y-m-d', $sum));

   	## Martin-> Generate Limit PTP based on Overdue ##

   	$overdue = $a_value[6];
   	$remaining = (7-$overdue);
   	//$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");
   	$type = $a_value[23];

$score_r = $a_value[34]; 
		//var_dump($type);
		
		$d = date('d');
		$m = date('m'); 
		$Y = date('Y'); 
		
			if('28' == $d){

   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif('29' == $d){

   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif('30' == $d){

   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
	}elseif('31' == $d ){

   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($type == '001'){
   		if($overdue=='6'||$overdue=='10'||$overdue=='15'){
   	$remaining = (7-$overdue);
   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='9'||$overdue=='5'||$overdue=='14'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='8'||$overdue=='4'||$overdue=='13'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}else{
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}
	}elseif($type == '001'){
   		if($overdue=='7'||$overdue=='20'||$overdue=='11'){
   	$remaining = (7-$overdue);
   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='6'||$overdue=='10'||$overdue=='19'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='5'||$overdue=='9'||$overdue=='18'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}else{
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}
	}elseif($type == '001'){
   		if($overdue=='25'||$overdue=='16'||$overdue=='11'){
   	$remaining = (7-$overdue);
   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='15'||$overdue=='10'||$overdue=='24'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='9'||$overdue=='14'||$overdue=='23'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}else{
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}
	}elseif($type == '002'){
   		if($overdue=='25'||$overdue=='18'||$overdue=='11'){
   	$remaining = (7-$overdue);
   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='17'||$overdue=='10'||$overdue=='24'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='9'||$overdue=='16'||$overdue=='23'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}else{
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}
	}elseif($type == '002'){
   		if($overdue=='7'||$overdue=='13'||$overdue=='19'){
   	$remaining = (7-$overdue);
   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='18'||$overdue=='12'||$overdue=='6'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='5'||$overdue=='11'||$overdue=='17'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}else{
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}
	}elseif($type == '002'){
   		if($overdue=='13'||$overdue=='19'){
   	$remaining = (7-$overdue);
   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='8'||$overdue=='14'||$overdue=='20'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='7'||$overdue=='21'||$overdue=='15'||$overdue=='9'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}else{
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}
	}elseif($type == '003'){
   		if($overdue=='3'||$overdue=='13'||$overdue=='8'){
   	$remaining = (7-$overdue);
   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='4'||$overdue=='14'||$overdue=='9'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='5'||$overdue=='15'||$overdue=='10'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}else{
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}
	}elseif($type == '003'){
   		if($overdue=='4'||$overdue=='1'||$overdue=='8'){
   	$remaining = (7-$overdue);
   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='2'||$overdue=='5'||$overdue=='9'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='6'||$overdue=='3'||$overdue=='10'||$overdue=='4'||$overdue=='5'||$overdue=='6'){  
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}else{
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}
	}elseif($type == '003'){
   		if($overdue=='22'||$overdue=='15'||$overdue=='8'){
   	$remaining = (7-$overdue);
   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='16'||$overdue=='23'||$overdue=='9'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='24'||$overdue=='17'||$overdue=='10'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}else{
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}
	}elseif($type == '004'){
   		if($overdue=='25'||$overdue=='18'||$overdue=='11'){
   	$remaining = (7-$overdue);
   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='12'||$overdue=='26'||$overdue=='19'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='27'||$overdue=='13'||$overdue=='20'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}else{
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}
	}elseif($type == '004'){
   		if($overdue=='25'||$overdue=='8'||$overdue=='15'){
   	$remaining = (7-$overdue);
   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='16'||$overdue=='23'||$overdue=='9'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='24'||$overdue=='17'||$overdue=='10'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}else{
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}
	}elseif($type == '004'){
   		if($overdue=='20'||$overdue=='6'||$overdue=='13'){
   	$remaining = (7-$overdue);
   	$remaining_fix = "+"."2"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='14'||$overdue=='21'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."1"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}elseif($overdue=='22'||$overdue=='15'||$overdue=='8'||$overdue=='7'){ 
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."0"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}else{
				$remaining = (7-$overdue);
   	$remaining_fix = "+"."3"." day";
   	$today = date("Y-m-d");

		$limit_ptp = strtotime ($remaining_fix,strtotime($today));
		//var_dump($limit_ptp);die();
		$limit_ptp = date('Y-m-j' , $limit_ptp);
		}
	}
	
   	## End Generate Limit ptp##

   	## Generate fixed PTP amount ##
   		$fixed_ptp_amount = ($a_value[7]+$a_value[8]);
   	## End Fixed PTP##

    ## martin debug ##
    //var_dump($a_value);
    //die();
    ## end martin debug ##
    ?>
    function checkCalltrack(url,go){
    var id_action_call_track = jQuery('#id_action_call_track').val();
    var id_handling_debt_arr = jQuery('#id_ptp').val().split(',');
    var id_handling_code_sub = id_handling_debt_arr[0];
    var handling_debt = jQuery('#id_handling_debt').val();
    var last_ptp_status = '<?php echo $last_ptp_status ?>';
    //alert(last_ptp_status);
    //return;
    var id_action = id_action_call_track.split(',');
    var remarks = jQuery('#remarks').val();
    var no_contacted = jQuery('#no_contacted').val();
    var handling_code = jQuery('#handling_code').val();
    var incomming = jQuery('input[name=incomming]').val();

    var object_group = jQuery('#object_group').val();
    var angsuran_ke = jQuery('#angsuran_ke').val();
    var min_amount = '<?php echo($a_value[7]); ?>';
    var dpdpd2 =[1,2,9,11,12,14,16,17,18,20,21,23,24,25,26,27]; //high
    var dpdpd3 =[1,2,3,4,6,8,12,13,14,16,18,19,21,22,23,25,26,27]; //medium
   	var dpdpd1 =[1,2,3,4,5,6,7,8,9,12,14,15,19,21,22,23,26]; //low
    var dpd = '<?php echo($a_value[6]); ?>';
        var ptp_date_stat =jQuery('#ptp_date_stat').val(); 
   	//alert(id_contact_co[1]);
    //return false;
    var ptp_date = jQuery('input[name=ptp_date]').val();
    var ptp_amount = jQuery('#ptp_amount').val();
    var due_date = jQuery('input[name=due_date]').val();
    var due_time = jQuery('input[name=due_time]').val();
    var handling_code = jQuery('handling_debt').val();
    var incomming = $('input[name=incomming]').attr('checked')?no_contacted='0':0;
    var ptp = [28];
    var ptpr = [4];
    var code_f = jQuery('#id_action_call_track').val();
    var object_group = jQuery('#object_group').val();
    var score_result = jQuery('#score_result').val();
    //Fixed value - No Answer AND Line Busy
    if(code_f == "8,OCNA,2" || code_f == "9,OCLB,2"){
    //alert("aaaa");
    	id_handling_code_sub = "04";
    	id_ptp = 0;
    	id_handling_debt = "04";
    	ptp_date = null;
    	ptp_amount = "";

    }
    //Fixed value - Invalid Number
    else if(code_f == "10,OCIN,2") {
    	id_handling_code_sub = "05";
    	id_ptp = 0;
    	id_handling_debt = "04";
    	ptp_date = null;
    	ptp_amount = "";

    }

    //alert(id_contact_code);
    //return;
    var today = '<?= date('Y-m-d')
    ?>';
    var maxptp = '<?= $maxptpdate
    ?>';
    var angsur = '<?= $a_value[7]
    ?>';
    var ptp_amount_ex = ptp_amount;
    //alert(ptp_date);
    if (go !='loc'){
    if (id_action_call_track == "0"){
    telli("Please select Status");
    }
    else if(inArray(dpd,dpdpd3) && last_ptp_status == "A" && id_handling_code_sub == '02' && ptp_date_stat > today){
    telli("This Account Currently In Active PTP Status !");
    }
    else if(inArray(dpd,dpdpd1) && last_ptp_status == "A" && id_handling_code_sub == '02' && ptp_date_stat > today){
    telli("This Account Currently In Active PTP Status !");
    }
    else if(inArray(dpd,dpdpd2) && last_ptp_status == "A" && id_handling_code_sub == '02' && ptp_date_stat > today){
    telli("This Account Currently In Active PTP Status !");
    }
    else if(id_handling_code_sub == ""){
    telli("Please select Handling Status");
    }
    else if((ptp_amount < min_amount) && id_handling_code_sub == '02' ){
    telli("PTP Amount Incorrect");
    }else if((code_f == "13,OFAA,1" || code_f == "28,OFAB,1" || code_f == "30,OFAC,1") && (handling_debt == "00" || handling_debt == 00) ){
    telli("Please Select Handling Debitur");
    }else if (remarks == ""){
    telli("Please filled out Remarks");
    }else if (remarks.length > 100){
     telli("Remarks too long, Max 100 char");
    }

    else if (no_contacted == "" ){
    //alert(incomming);
    telli("Please Choose the phone No fist ");
    }else if (inArray(id_action[0], ptp)){
    //alert(maxptp);
    if(ptp_date==""){
    telli("Please select PTP Date");
    }else {
    proceedCalltrack(url);
    }
    }else if (inArray(id_action_call_track, ptpr)){
    if(due_date==""){
    telli("Please select Reminder Date");
    }else if(due_time==""){
    telli("Please select Reminder  Time");
    }else {
    proceedCalltrack(url);
    }
    }else {
    proceedCalltrack(url);
    return false;
    }
    } else {

    window.location = url;
    }
    }
    function proceedCalltrack(url){

    var id_debtor = new Array();
    jQuery("#id_debtor option:selected").each(function(id) {
    message = jQuery("#id_debtor option:selected").get(id);
    id_debtor.push(message.value);
    });
    var incomming_c = jQuery('#incomming').val();
    //var id_risk_code = jQuery('#id_risk_code').val();
    var ptp_amount = jQuery('input[name=ptp_amount]').val();
    var ptp_amount_ex = ptp_amount.replace(/\./g,'');
    var ptp_date = jQuery('input[name=ptp_date]').val();
		var angsuran_ke = jQuery('#angsuran_ke').val();
    var incomming = $('input[name=incomming]').attr('checked')?incomming_c='1':0;
    var id_ptp_co = jQuery('#id_ptp').val().split(',');
    var id_action_call_track = jQuery('#id_action_call_track').val();
    var id_handling_debt = jQuery('#id_handling_debt').val();
    var id_call = id_action_call_track.split(',');
    var id_handling_code_arr = jQuery('#id_ptp').val().split(',');
    var id_handling_code_sub = id_handling_code_arr[0];
    var code_f = jQuery('#id_action_call_track').val();
    var call_handling = jQuery('#call_handling').val();
    var score_result = jQuery('#score_result').val();
    var id_ptp;
    if(id_handling_code_sub == '02'){
    	id_ptp = '1';
    }else {id_ptp = '0'; }
    //Fixed value - No Answer 
    //if(code_f == "8,OCNA,2" || code_f == "9,OCLB,2"){
    if(code_f == "8,OCNA,2"){
    //alert("aaaa");
    	id_handling_code_sub = "04";
    	id_ptp = 0;
    	id_handling_debt = "04";
    	ptp_date = null;
    	ptp_amount = "";

    }
    //Fixed value - Invalid Number
    else if(code_f == "10,OCIN,2") {
    	id_handling_code_sub = "05";
    	id_ptp = 0;
    	id_handling_debt = "04";
    	ptp_date = null;
    	ptp_amount = "";

    }
    //AND Line Busy
     else if(code_f == "9,OCLB,2") {
    	id_handling_code_sub = "9O";
    	id_ptp = 0;
    	id_handling_debt = "04";
    	ptp_date = null;
    	ptp_amount = "";

    }
    //alert(id_handling_code_sub);
    //return false;
    //alert(id_call[1]);
    //alert(ptp_date);
    //alert(ptp_amount);
    //alert(id_ptp);
    //return;
    if(confirm("Do you want to proceed?")){
    //alert("aaa");
    //return false;
    //alert(ptp_date);
    //return;
    jQuery.post(url,{
    id_calltrack : jQuery('#id_calltrack').val(),
    id_action_call_track : id_call[0],
    id_handling_debt : id_handling_debt,
    code_call_track : id_call[1],
    id_call_cat : id_call[2],
    remarks : jQuery('#remarks').val(),
    kode_cabang : jQuery('#kode_cabang').val(),
    region : jQuery('#region').val(),
    bucket : jQuery('#bucket').val(),
    primary_1 : jQuery('#primary_1').val(),
    cname : jQuery('#cname').val(),
    angsuran_ke : jQuery('#angsuran_ke').val(),
    no_contacted : jQuery('#no_contacted').val(),
    handling_code : id_handling_code_sub,
    call_handling : call_handling,
    id_ptp : id_ptp,


    id_user : jQuery('#id_user').val(),
    username : jQuery('#username').val(),
    os_ar_amount : jQuery('#os_ar_amount').val(),
    ptp_date : ptp_date,
    ptp_amount : ptp_amount,
    due_date : jQuery('input[name=due_date]').val(),
    due_time : jQuery('input[name=due_time]').val(),
    date_in : jQuery('#date_in').val(),
    surveyor : jQuery('#surveyor').val(),
    dpd : jQuery('#dpd').val(),
    object_group : jQuery('#object_group').val(),
    score_result : jQuery('#score_result').val(),
    <?php
//echo $contact_type;
    switch ($contact_type) {
        case "ptp":
            echo "ptp_fu : jQuery('#ptp_fu').val(), \n";
            break;
        case "no_contact_fu":
            echo "fu : jQuery('#fu').val(),\n";
            break;
        case "contact_fu":
            echo "fu : jQuery('#fu').val(),\n";
            break;
        default:
            echo "\n";
    }
    ?>
    incomming : incomming_c,
    //previous : jQuery('#previous').val(),
    //id_mytask : jQuery('#id_mytask').val(),
	last_call_code : jQuery('#last_call_code').val(),
    post : true
    }, function(html) {
    //alert(html);
    //return;
    telli(html);//reload_flexiCalltrack(html);
    //jQuery('#nextButton').fadeIn(1000);
    jQuery('.but_proceed').fadeOut(800);
    jQuery('#skip_call').fadeOut(800);
	setTimeout(function(){ window.location = "<?php echo site_url()?>user/hdr_contact_cont/contact/call/"; }, 3000);
	
    });
    }
    }


    function sumaryPop(url){
    jQuery.get(url,{
    }, function(html) {
    notif = new Boxy(html, {
    title:"Summary",modal: false,unloadOnHide:true,closeText:"[X] Close!"
    });
    notif.show();
    });

    }
    function popBlock2(url){
    //notif.hide();
    loading('<h2>Get Data Please wait...<br/>if take more than 5 sec press F5</h2>');
    jQuery.get(url,{
    }, function(html) {
    uiPopUp2(html);
    });
    }
    function uiPopUp2(html){
    notif.hide();
    jQuery.blockUI({ message: html,
    css: { padding:0, margin:0,width:'885px',top:'5%',left:($(window).width() - 885) /2 + 'px',textAlign:'center',color:'#000',border:'7px solid #000',backgroundColor:'#48B8F3','-webkit-border-radius': '10px','-moz-border-radius': '10px',cursor:'default'},baseZ: 1500, showOverlay: false,  constrainTabKey: false,  focusInput: false,  onUnblock: null,});

    jQuery('#close').click(function() {
    jQuery.unblockUI();
    //notif.hide();
    return false;
    });
    }
</script>

<?php 
function hide_5digit_phone($val){
  $val = trim($val);
  $temp = substr($val,0,strlen($val)-5) . 'xxxxx';
  return $temp;
}
?>

<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.autocomplete.min.js"></script>
<link href="<?php echo base_url() ?>assets/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script  type="text/javascript">

    $(function() {
    $("#name").autocomplete('<?= site_url() ?>user/hdr_contact_cont/autocomplete_name',
    {
    delay:400,
    minChars:3,
    max:50,
    matchSubset:1,
    matchContains:1,
    cacheLength:0,
    onItemSelect:selectItem,
    //autoFill:true
    }
    );
    });
    $(function() {
    $("#search_acct").autocomplete('<?= site_url() ?>user/hdr_contact_cont/autocomplete_primary_1',
    {
    delay:10,
    minChars:5,
    max:50,
    matchSubset:1,
    matchContains:1,
    cacheLength:10,
    onItemSelect:selectItem,
    autoFill:false
    }
    );
    });
    $(function() {
    $("#nxt_card").autocomplete('<?= site_url() ?>user/hdr_contact_cont/autocomplete_card_no',
    {
    delay:10,
    minChars:5,
    max:50,
    matchSubset:1,
    matchContains:1,
    cacheLength:10,
    onItemSelect:selectItem,
    autoFill:false
    }
    );
    });
    $(function() {
    $("#search_card_no").autocomplete('<?= site_url() ?>user/hdr_contact_cont/autocomplete_card_no',
    {
    delay:10,
    minChars:8,
    max:50,
    matchSubset:1,
    matchContains:1,
    cacheLength:10,
    onItemSelect:selectItem,
    autoFill:false
    }
    );
    });
    $(function() {
    $("#search_remark").autocomplete('<?= site_url() ?>user/hdr_contact_cont/autocomplete_remark',
    {
    delay:10,
    minChars:1,
    matchSubset:1,
    matchContains:1,
    cacheLength:10,
    onItemSelect:selectItem,
    autoFill:true
    }
    );
    });

    function selectItem(li, elementID) {
    $("#"+elementID).val(0);
    var setVal = (li.extra) ? li.extra[0] : 0;
    $("#"+elementID).val(setVal);
    }
</script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery.jeditable.mini.js"></script>
<script>
    $(document).ready(function() {
    $(".editphone").editable("<?= site_url() ?>user/hdr_contact_cont/blocked/", {
    indicator : "<img src='<?= base_url() ?>assets/images/ajax-loader.gif'> Saving...",
    type   : 'textarea',
    submit : 'OK',
    name     : 'phone_no',
    id        : 'primary_1',
    tooltip    : 'Click to edit...',
    cancel    : 'Cancel',
    submit    : 'Save',
    });
    });
    $(document).ready(function() {
    $(".editInfo").editable("<?= site_url() ?>user/hdr_contact_cont/get_info/edit", {

    indicator : "<img src='<?= base_url() ?>assets/images/ajax-loader.gif'> Saving...",
    type   : 'textarea',
    height   : '150px',
    submit : 'OK',
    name     : 'info',
    id        : 'primary_1',
    tooltip    : 'Click to edit...',
    cancel    : 'Cancel',
    submit    : 'Save',
    });
    });
    //load last Calltrackt
    $(document).ready(function(){
    $('.last_call').load('<?= site_url() ?>user/hdr_contact_cont/last_call/<?= $primary_1 ?>');
    });
    $(document).ready(function(){
    $('.action_code_wom').load('<?= site_url() ?>user/hdr_contact_cont/action_code_wom/<?= $primary_1 ?>');
    });
    $(document).ready(function(){
    $('.other_info').load('<?= site_url() ?>user/hdr_contact_cont/other_info/<?= $primary_1 ?>');
    });
</script>
<link href="<?php echo base_url() ?>assets/css/timepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.utils.lite.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/ui.timepicker.js"></script>
<script type="text/javascript">
    $(function(){
    //$('#call_back_time').timepickr().focus();
    $('#call_back_time').timepickr({handle: '#trigger-test', convention: 24});
    $('#visit_time').timepickr({handle: '#trigger-test', convention: 24});
    $('#example3').timepickr({ trigger: 'focus'});
    // $('#time').timepickr({handle: '#trigger-test', convention: 24});
    });

    $(document).ready(function() {
    $('a.title').cluetip({splitTitle: '|'});
    });

</script>
<noscript>
	<a href="<?php echo base_url()."error" ; ?>">
</noscript>
<style>
.meter-wrap{
    position: relative;
		}

		.meter-wrap, .meter-value, .meter-text {
		    /* The width and height of your image */
		    width: 950px; height: 15px;
		    border-radius:0 20px 20px 0;
		}

		.meter-wrap, .meter-value {
		    background: #bdbdbd url(<?php echo base_url() ?>assets/images/meter-outline-copy.png) top left no-repeat;

		}

		.meter-text {
		    position: absolute;
		    top:0; left:0;
		    padding-top: 1px;
		    font-size: 9px;
		    font-family: cursive;
		    color: brown;
		    text-align: center;
		    width: 100%;
		    height: 100%;
		}
</style>

<?php
    $today = @$get_main_info->dpd;
    $shift_now = @$get_main_info->shift;
    $dpd = $today;
?>

<?php

            function clean_phone($phones) {
                $clean_no = preg_replace('/[^0-9]/', '', $phones);
                return $clean_no;
            }
?>
<!-- Call Progess Bar-->

<div class="meter-wrap">
    <div class="meter-value" style="background-color: hsla(175,275%,50%,0.8); width: <?php if($work_percentage > 100) { echo "100"; $work_text = "Target Archived"; } else {echo $work_percentage ; $work_text = "Work Progress";} ?>%;border-radius:0px 20px 20px 10px ;box-shadow: 3px 0px 0px #888888;">
        <div class="meter-text">
          <b><?php echo $work_text.' '.$work_percentage ;?>%</b>
        </div>
    </div>
</div>
<!-- End Progress Bar -->
    <div class="cmidleft">
        <span class="boxmid_top"></span>
        <div class="boxmid_box">
            <table class="midleft">
                <form action="#" method="post">
                  <!-- <tr class="listB"><td class="tit">Name</td> <td><input type="text" value="" style="width:200px" name="name_debt" id="name"  /><input type="button" onclick="get_input('<?= site_url()?>user/hdr_contact_cont/go_filter');return false;"  name="submit" value="GO" /><img src="<?= base_url()?>assets/images/ico_company.png" style="" width="30" /></td></tr> -->
                	<!-- <tr class="listA"><td class="tit">SEARCH ACCOUNT </td> <td><input type="text" value="" style="width:200px" name="search_acct" id="search_acct"  /><input type="submit" name="button" onclick="get_input('<?= site_url()?>user/hdr_contact_cont/go_filter');return false;"  value="GO" /></td></tr> -->
              		<tr class="listB"><td class="tit">0. <?php if(@$fin_type == 2) { echo "PEMBIAYAAN MURABAHAH"; } else { echo "PERJANJIAN KREDIT" ;}?> </td> <td><?= $a_value[2] ?>&nbsp <?php if(@$fin_type == 2) { echo "<img src='".base_url()."assets/images/syariah.gif' />"; }?>
								</form>
						<!-- is_new IMAGE -->
						<?php
							$is_new = @$get_main_info->is_new ;
							$is_new_flag = $is_new == '1' ? $image = '<img src="'.base_url().'assets/images/new.gif">' : $image= '';
						?>
						<!-- end Is_new IMAGE -->

            <tr class="listA"><td class="tit">1. <?php if(@$fin_type == 2) { echo "KONSUMEN"; } else { echo "DEBITUR" ;} ?></td> <td><h1><?= $a_value[3]. ' ' .$image  ?></h1></td></tr>

            <?php if ($get_ptp_status->num_rows() > 0): ?>
            <?php
                    foreach ($get_ptp_status->result() as $ptp_row) {
                       $ptp_status = $ptp_row->ptp_status;
                        $dpd = $ptp_row->dpd;
                        $score_result = $ptp_row->score_result;
                        $dpd1 =array('4','5','6','7','8','16');
                       $dpd2 =array('1','2','3','4','6','8','12','13','14','16','18','19','21','22','23','25','26','27');
                        $dpd3 =array('1','2','9','11','12','14','16','17','18','20','21','23','24','25','26','27');
                        $dpd4 =array('1','2','3','4','5','6','7','8','9','12','14','15','19','21','22','23','26');
                        $score_result1 = array('MEDIUM','LOW');
                        $ptp_status1 = array('0','2');
                        $ptp_date1 = $ptp_row->ptp_date;

if ($ptp_status == '0' || $ptp_status == '2' || $ptp_status == '1' && (in_array($dpd,$dpd4)) && $score_result == 'LOW'&& $ptp_date1 > $today)
                            $ptp_status = 'KEEP';
                        elseif ($ptp_status == '0' || $ptp_status == '2' || $ptp_status == '1' && (in_array($dpd,$dpd2)) && $score_result == 'MEDIUM'&& $ptp_date1 >= $today)
                            $ptp_status = 'KEEP';
                        elseif ($ptp_status == '0' || $ptp_status == '2' || $ptp_status == '1' && (in_array($dpd,$dpd3)) && $score_result == 'HIGH'&& $ptp_date1 >= $today)
                            $ptp_status = 'KEEP';
                        elseif ((in_array($ptp_status,$ptp_status1)) && (in_array($dpd,$dpd1)) && $score_result == 'HIGH')
                            $ptp_status = 'BROKEN';
                        else $ptp_status = 'KEEP';            ?>

<input type="hidden" name="ptp_date_stat" id="ptp_date_stat" value="$ptp_date1">
                        <tr class="listA"><td class="tit">PTP STATUS</td><td><span class="max_ptp"><?= $ptp_status;
            ?> ON <?= date_formating($ptp_row->call_date)
            ?> <?= $ptp_row->username
            ?></span></td> </tr>
<?php } ?>
<?php endif; ?>

            <tr class="listB"><td class="tit">2. TYPE PRODUCT</td> <td><?php
            if($a_value[23] == '001' || $a_value[23] == 001 ) {
            	echo "MOTOR";
            	} else if ($a_value[23] == '002' || $a_value[23] == 002){
            	echo "MOBIL";
            	} else if ($a_value[23] == '003' || $a_value[23] == 003){
            	echo "DURABLE";
            	}else { echo "No Data";}  ?></td></tr>
            <!-- <tr class="listB"><td class="tit">3. TYPE PRODUCT</td> <td><?php $qry = "SELECT a.desc FROM hdr_object_group a WHERE a.code = trim('$a_value[23]')"; $res = $this->db->query($qry);  foreach($res->result() as $row) { echo ($row->desc); } ?></td></tr> -->
            <tr class="listA"><td class="tit">3. Overdue</td> <td><?= $a_value[6] ?></td></tr>
            <tr class="listB"><td class="tit">4. TENOR</td> <td><?= $a_value[5] ?></td></tr>
            <tr class="listA"><td class="tit">5. DUE DATE</td> <td> <?= date_formating($a_value[17]) ?> </td></tr>
            <tr class="listB"><td class="tit">6. Angs ke</td> <td><?= $a_value[4] ?></td></tr>
            <tr class="listA"><td class="tit">7. <?php if(@$fin_type == 2) { echo "POKOK UTANG"; } else { echo "OS/AR" ;}?></td> <td><?= ($a_value[9] != 'no DATA' && trim($a_value[9]) != '' && isset($a_value[9]) ? number_format($a_value[9]) : '')  ?></td></tr>
            <tr class="listB"><td class="tit">8. AMOUNT DUE</td> <td class="currency"><h2><?= @price_format($a_value[7]) ?></h2></td></tr>
            <tr class="listA"><td class="tit">9. <?php if(@$fin_type == 2) { echo "SANKSI KETERLAMBATAN"; } else { echo "DENDA" ;} ?></td> <td class="currency"><h2><span id="due_val" class="due_val"></span></h2></td></tr>

        </table>
        <table class="midleft" id="addInfo">
                <center>Click Personal Messages di bawah ini untuk Edit</center>
                <br/>
                <?php
                if ($get_other_info->num_rows() > 0) {
                    $i = 1;
                    $no_p = 65;
                ?>
                <?php foreach ($get_other_info->result() as $new_info) {
                        $i++; ?>
                        <tr class="listA" id="info_<?= $new_info->primary_1 ?>"><td class="tit" style="font-weight:bold;"><div class="editInfo"id="<?= $a_value[2] ?>"><?= strtoupper($new_info->info) ?></div><a class="title" id="no_under" title="Created by : <?= $new_info->username ?>|Created Date : <?= $new_info->createdate ?>" href="#">&nbsp;&nbsp;- Edit By -&nbsp;&nbsp; </td></a></tr>
                <?php
            }
        } else {

        }
                ?>
            </table>
    </div>
    <span class="boxmid_bot"></span>

    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <table class="midleft" cellpadding="3" cellspacing="2">
            <tr class="listB"><td class="tit">10. AREA COLLECTION</td> <td><span><?= $a_value[15] ?></span></td></tr>
            <tr class="listA"><td class="tit">11. BRANCH</td> <td><?= $a_value[1] ?></td></tr>
		 <!-- <tr class="listB"><td class="tit">13. RESIDENCE CITY</td> <td><?= $a_value[14] ?></td></tr>
            <tr class="listA"><td class="tit">14. RESIDENCE KECAMATAN</td> <td><?= $a_value[14] ?></td></tr>
            <tr class="listB"><td class="tit">15. RESIDENCE KELURAHAN</td> <td><?= $a_value[16] ?></td></tr>
            <tr class="listA"><td class="tit">16. ALAMAT KTP</td> <td><?= ($a_value[49] . ' ' . $a_value[50] . ' ' . $a_value[51] . ' ' . $a_value[52]) ?></td></tr>
            <tr class="listB"><td class="tit">17. ALAMAT TAGIH</td> <td><?= $a_value[18]; ?></td></tr>
            <tr class="listA"><td class="tit">18. ALAMAT LAIN</td> <td><?= $a_value[18] ?></td></tr>
 			 -->
        </table>
    </div>
    <span class="boxmid_bot"></span>

    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <table class="midleft">
       <!-- <tr class="listA"><td class="tit">18. YEAR SALES</td> <td><?= $a_value[23] ?></td></tr>
            <tr class="listB"><td class="tit">19. MONTH SALES</td> <td><?= $a_value[24] ?></td></tr>
            <tr class="listA"><td class="tit">20. CMO/CRO NAME </td> <td><?= $a_value[25] ?></td></tr>
            <tr class="listB"><td class="tit">21. COLLECTOR NAME</td> <td><?= $a_value[26] ?></td></tr>
            <tr class="listA"><td class="tit">22. DEALER NAME</td> <td><?= $a_value[27] ?></td></tr>
        -->
            <tr class="listA"><td class="tit">12. STATUS RESTRUKTUR</td> <td><?= $a_value[35] ?></td></tr>
            <tr class="listB"><td class="tit">13. BRAND/MODEL</td> <td><?= $a_value[16] ?></td></tr>
		<tr class="listB"><td class="tit">14. SCORE RESULT</td> <td><?= $a_value[34] ?></td></tr>
       <tr class="listA"><td class="tit">15. CL_ID_MULTI_UNIT</td><?= $a_value[36] ?> </td></tr>
            <tr class="listB"><td class="tit">16. JENIS_PP</td> <td><?= $a_value[37] ?></td></tr>
            <tr class="listA"><td class="tit">17. NO_WA</td> <td><?= $a_value[38] ?></td></tr>
		<tr class="listA"><td class="tit">17. KONTRAK_ASAL</td> <td><?= $a_value[39] ?></td></tr>
         
        <!--    <tr class="listA"><td class="tit">24. BRAND</td> <td><?= (isset($a_value[0]) ? $a_value[0] : '') ?></td></tr>
            <tr class="listB"><td class="tit">25. MODEL</td> <td><?= $a_value[0] ?></td></tr>
            <tr class="listA"><td class="tit">26. NO RANGKA, NO MESIN / NO Serial</td> <td><?= $a_value[0] ?></td></tr>
            <tr class="listB"><td class="tit">26. NO POL</td> <td><?= $a_value[0] ?></td></tr>
            <tr class="listA"><td class="tit">27. WARNA</td> <td><?= $a_value[0] ?></td></tr>
         -->
         <tr class="listB"><td class="tit">26. NO POLISI</td> <td><?= $a_value[10] ?></td></tr>
        </table>
    </div>
    <span class="boxmid_bot"></span>

      <!-- <span class="boxmid_top"></span>
  		<div class="boxmid_box" style="<?php if ($get_other_address->num_rows() > 0)
            echo 'height: 200px;width: 430px;overflow: scroll;'; ?>">
        <center><h3>New Other Address</h3><br />
            <input type="button" id="view_phone" value="Add New Address" style="text-align:center; font-size:12px;  padding-bottom:5px; background:url(<?php echo base_url() ?>assets/images/but_clean.png); border:none;width:115px; height:31px;" onclick="boxPopup('Add New  Address','<?php echo site_url() ?>user/hdr_contact_cont/get_address/<?= $a_value[2] ?>');return false;" />
        </center><br />
        <table class="midleft" id="address_info">
            <?php
            if ($get_other_address->num_rows() > 0) {
                $noadd = 1;
                foreach ($get_other_address->result() as $new_address) {
            ?>
                <tr class="listB" id="address_<?= $new_address->id_address
            ?>_a">
                <td class="tit">NEW ADDRESS</td>
                <td style="font-weight:bold;"><?= $new_address->address
            ?></td>
            </tr>
            <tr class="listA" id="address_<?= $new_address->id_address
            ?>_b">
                <td class="tit">CITY</td>
                <td style="font-weight:bold;"><?= $new_address->city
            ?></td>
            </tr>
            <tr class="listB" id="address_<?= $new_address->id_address
            ?>_c">
                <td class="tit">POS CODE</td>
                <td style="font-weight:bold;"><?= $new_address->zip_code
            ?></td>
            </tr>
            <tr class="listA" id="address_<?= $new_address->id_address
            ?>_d">
                <td class="tit">ADDRESS TYPE</td>
                <td style="font-weight:bold;"><?= $new_address->type
            ?></td>
            </tr>
            <tr class="listB" id="address_<?= $new_address->id_address
            ?>_d">
                <td class="tit">Phone No</td>
                <td style="font-weight:bold;"><?= $new_address->phone_no
            ?></td>
            </tr>
            <tr class="listA" id="address_<?= $new_address->id_address
            ?>_e">
                <td class="tit">ALAMAT TAGIH</td>
                <td style="font-weight:bold;"><?= ($new_address->is_tagih == 1) ? 'Yes' : 'No' ?></td>
            </tr>
            <tr class="listB" id="address_<?= $new_address->id_address
            ?>_f">
                <td class="tit">&nbsp;</td>
                <td style="font-weight:bold;text-align:right;">
                    <a id="no_under" class="title" title="Created by : <?= $new_address->username
            ?>|Created Date : <?= $new_address->createdate
            ?>" href="#">Info</a>
                    | <a href="#" onclick="boxPopup('Edit New Address','<?= site_url()
            ?>user/hdr_contact_cont/get_address/edit/<?= $new_address->id_address
            ?>');return false;">Edit</a> |
                    <a href="#" onclick="deleteAddress('<?= site_url()
            ?>user/hdr_contact_cont/delete_address/<?= $new_address->id_address
            ?>','<?= $new_address->id_address
            ?>')">Delete</a>
                    &nbsp;</td>
            </tr>
            <tr id="address_<?= $new_address->id_address
            ?>_g">
                           <td>&nbsp;</td>
                           <td>&nbsp;</td>
                       </tr>
            <?php
                       $noadd++;
                   }
               }
            ?>
           </table>
       </div>
       <span class="boxmid_bot"></span>
-->
       <span class="boxmid_top"></span>
       <div class="boxmid_box">
           <table class="midleft">
               <!--Inside Calltrack-->
               <div class="last_call" style=""><center><img src="<?= base_url()
            ?>assets/images/loader.gif" /></center></div>
        </table>
    </div>
    <span class="boxmid_bot"></span>
    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <center>

<?php /* $details = $a_value[1] . '&' . $a_value[15] . '&' . $a_value[23] . '&' . $a_value[0] . '&' . $a_value[8] . '&' . $a_value[13] . '&' . $a_value[2];
               $details2 = $a_value[1] . '&' . $a_value[15] . '&' . $a_value[23] . '&' . $a_value[0] . '&' . $a_value[8] . '&' . $a_value[13] . '&' . $a_value[2]; */ ?>
<?php $name = base64_encode($a_value[3]); ?>
               <input type="button" class="but_sp" onclick="popBlock('<?= site_url() ?>user/hdr_contact_cont/hist_payment/<?= $this->uri->segment(5) ?>/<?= $name ?>'); return false;" value="HISTORY PAYMENT" />
              <!--  <input type="button" class="but_sp"  value="HISTORY REMINDER" onclick="popBlock('<?= site_url() ?>user/hdr_contact_cont/hist_call_track/all/rem/<?= $name ?>'); return false;"/>-->
              	<br />
               <input type="button" class="but_htcall" onclick="popBlock('<?= site_url() ?>user/hdr_contact_cont/hist_call_track/<?= $this->uri->segment(5) ?>/all/<?= $name ?>'); return false;"/>

                                                                                                                                                       <!--<input type="button" class="but_htagen" onclick="popBlock('<?= site_url() ?>user/hdr_contact_cont/hist_agen_track/<?= $a_value[0] ?>/<?= $name ?>'); return false;" />-->
            <input type="button" class="but_histptp" onclick="popBlock('<?= site_url() ?>user/hdr_contact_cont/hist_call_track/<?= $this->uri->segment(5) ?>/ptp/<?= $name ?>'); return false;" />
            <br/>

<?php if ($get_other_info->num_rows() == 0) { ?>
                <input type="button" class="but_sp" id="view_info" value="Add Notes" onclick="boxPopup('Add New Notes','<?php echo site_url() ?>user/hdr_contact_cont/get_info/popup/<?= $a_value[2] ?>');return false;" />
<?php } ?>
            <br />
            <br />

        </center>
    </div>
    <span class="boxmid_bot"></span>


    <!-- Finish Calltrack-->
</div>

<div class="cmidleft">


    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <table class="midleft">
          <!--
            <tr class="listA"><td class="tit">EMERGENCY CONTACT</td> <td><?= ($a_value[49] != 'NULL' ? $a_value[49] : '') ?></td></tr>
            <tr class="listB"><td class="tit">HUBUNGAN DENGAN EMERGENCY</td> <td><?= $a_value[50]
                ?></td></tr>
            <tr class="listA"><td class="tit">TELP RUMAH</td> <td><?= ($a_value[20] != 'NULL' ? @hide_5digit_phone($a_value[20]) : '') ?></td><td class="call"><input type="button" value="Call" onclick="get_phone('<?= clean_phone($a_value[20])
                ?>')" /></td></tr>
            <tr class="listB"><td class="tit">TELP KANTOR</td> <td><?= ($a_value[19] != 'NULL' ? @hide_5digit_phone($a_value[19]) : '') ?></td><td class="call"><input type="button" value="Call" onclick="get_phone('<?= clean_phone($a_value[19])
                ?>')" /></td></tr>
                <tr class="listA"><td class="tit">For Incoming Call</td> <td><input type="checkbox" name="incomming" id="incomming"  value="" /> <td class="call"></td></tr>
           -->

           <!-- Martin-> Cleaning Regional Area Jakarta and Alpha Character -->
          	<?php
          	$a_value[11] = clean_phone($a_value[11]);
          	$a_value[12] = clean_phone($a_value[12]);
          	$a_value[13] = clean_phone($a_value[13]);
          	$a_value[14] = clean_phone($a_value[14]);
          	$is_cleaned14 = 0 ;
          	$is_cleaned11 = 0 ;
          	$is_cleaned12 = 0 ;
          	$is_cleaned13 = 0 ;

          	if(substr(trim($a_value[14]),0,3) == '021'){
          			//$a_value[14] = substr_replace(trim($a_value[14]),'',0,3);
          			$is_cleaned14 = 1 ;
          			$is_cleaned14 = 0 ;
          		}
          	if(substr(trim($a_value[11]),0,3) == '021'){
          			//$a_value[11] = substr_replace(trim($a_value[11]),'',0,3);
          			$is_cleaned11 = 1 ;
          			$is_cleaned11 = 0 ;
          		}
          	if(substr(trim($a_value[12]),0,3) == '021'){
          			//$a_value[12] = substr_replace(trim($a_value[12]),'',0,3);
          			$is_cleaned12 = 1 ;
          			$is_cleaned12 = 0 ;
          		}
          	if(substr(trim($a_value[13]),0,3) == '021'){
          			//$a_value[13] = substr_replace(trim($a_value[13]),'',0,3);
          			$is_cleaned13 = 1 ;
          			$is_cleaned13 = 0 ;
          		}
          	?>
           <!-- End Clean-->

						<?php
						$cell_phone = $a_value[14];
						$is_status = $this->call_track_model->chk_status_phone($primary_1, $cell_phone);
						//die("d".$is_status);
						if($is_status > 0){
						?>
            <tr class="listA"><td class="tit">27. HP</td> <td><?php if($is_cleaned14 == 1) {echo "<span style='color:grey'>021</span>";} ?><span style="color:<?php echo ($is_status == 1 ? 'green' : '#999618' ) ?>"><?= ($a_value[14] != '' ? @hide_5digit_phone($a_value[14]) : '<span style="color:grey">-NoData-</span>') ?></span></td><td class="call"><input type="button" id="mobile_phone" value="Call" onclick="call('<?php echo(trim($a_value[14]));?>','03')" /></td></tr>
						<?php }else{ ?>
            <tr class="listA"><td class="tit">27. HP</td> <td><?php if($is_cleaned14 == 1) {echo "<span style='color:grey'>021</span>";} ?><?= ($a_value[14] != '' ? @hide_5digit_phone($a_value[14]) : '<span style="color:grey">-NoData-</span>') ?></td><td class="call"><input type="button" id="mobile_phone" value="Call" onclick="call('<?php echo(trim($a_value[14]));?>','03')" /></td></tr>
						<?php } ?>

						<?php
						$cell_phone = $a_value[11];
						$is_status = $this->call_track_model->chk_status_phone($primary_1, $cell_phone);
						//die("d".$is_status);
						if($is_status > 0){
						?>
            <tr class="listB"><td class="tit">28. Telp Rumah</td> <td><?php if($is_cleaned11 == 1) {echo "<span style='color:grey'>021</span>";} ?><span style="color:<?php echo ($is_status == 1 ? 'green' : '#999618' ) ?>"><?= ($a_value[11] != '' ? @hide_5digit_phone($a_value[11]) : '<span style="color:grey">-NoData-</span>') ?></span></td><td class="call"><input type="button" id="telp_1" value="Call" onclick="call('<?php echo(trim($a_value[11]));?>','01')" /></td></tr>
						<?php }else{ ?>
            <tr class="listB"><td class="tit">28. Telp Rumah</td> <td><?php if($is_cleaned11 == 1) {echo "<span style='color:grey'>021</span>";} ?><?= ($a_value[11] != '' ? @hide_5digit_phone($a_value[11]) : '<span style="color:grey">-NoData-</span>') ?></td><td class="call"><input type="button" id="telp_1" value="Call" onclick="call('<?php echo(trim($a_value[11]));?>','01')" /></td></tr>
						<?php } ?>

						<?php
						$cell_phone = $a_value[12];
						$is_status = $this->call_track_model->chk_status_phone($primary_1, $cell_phone);
						//die("d".$is_status);
						if($is_status > 0){
						?>
            <tr class="listA"><td class="tit">29. Telp Kantor</td> <td><?php if($is_cleaned12 == 1) {echo "<span style='color:grey'>021</span>";} ?><span style="color:<?php echo ($is_status == 1 ? 'green' : '#999618' ) ?>"><?= ($a_value[12] != '' ? @hide_5digit_phone($a_value[12]) : '<span style="color:grey">-NoData-</span>') ?></span></td><td class="call"><input type="button" id="telp_2" value="Call" onclick="call('<?php echo(trim($a_value[12]));?>','02')" /></td></tr>
						<?php }else{ ?>
            <tr class="listA"><td class="tit">29. Telp Kantor</td> <td><?php if($is_cleaned12 == 1) {echo "<span style='color:grey'>021</span>";} ?><?= ($a_value[12] != '' ? @hide_5digit_phone($a_value[12]) : '<span style="color:grey">-NoData-</span>') ?></td><td class="call"><input type="button" id="telp_2" value="Call" onclick="call('<?php echo(trim($a_value[12]));?>','02')" /></td></tr>
						<?php } ?>

						<?php
						$cell_phone = $a_value[13];
						$is_status = $this->call_track_model->chk_status_phone($primary_1, $cell_phone);
						//die("d".$is_status);
						if($is_status > 0){
						?>
            <tr class="listB"><td class="tit">30. Telp Lain</td> <td><?php if($is_cleaned13 == 1) {echo "<span style='color:grey'>021</span>";} ?><span style="color:<?php echo ($is_status == 1 ? 'green' : '#999618' ) ?>"><?= ($a_value[13] != '' ? @hide_5digit_phone($a_value[13]) : '<span style="color:grey">-NoData-</span>') ?></span></td><td class="call"><input type="button" id="telp_3" value="Call" onclick="call('<?php echo(trim($a_value[13]));?>','04')" /></td></tr>
						<?php }else{ ?>
            <tr class="listB"><td class="tit">30. Telp Lain</td> <td><?php if($is_cleaned13 == 1) {echo "<span style='color:grey'>021</span>";} ?><?= ($a_value[13] != '' ? @hide_5digit_phone($a_value[13]) : '<span style="color:grey">-NoData-</span>') ?></td><td class="call"><input type="button" id="telp_3" value="Call" onclick="call('<?php echo(trim($a_value[13]));?>','04')" /></td></tr>
						<?php } ?>

						<?php
						$cell_phone = $a_value[29];
						$is_status = $this->call_track_model->chk_status_phone($primary_1, $cell_phone);
						//die("d".$is_status);
						if($is_status > 0){
						?>
            <tr class="listB"><td class="tit">30. Emergency Phone </td> <td><?php if($is_cleaned13 == 1) {echo "<span style='color:grey'>021</span>";} ?><span style="color:<?php echo ($is_status == 1 ? 'green' : '#999618' ) ?>"><?= ($a_value[29] != '' ? @hide_5digit_phone($a_value[29]) : '<span style="color:grey">-NoData-</span>') ?></span></td><td class="call"><input type="button" id="telp_4" value="Call" onclick="call('<?php echo(trim($a_value[29]));?>','05')" /></td></tr>
						<?php }else{ ?>
            <tr class="listB"><td class="tit">30. Emergency Phone</td> <td><?php if($is_cleaned13 == 1) {echo "<span style='color:grey'>021</span>";} ?><?= ($a_value[29] != '' ? @hide_5digit_phone($a_value[29]) : '<span style="color:grey">-NoData-</span>') ?></td><td class="call"><input type="button" id="telp_4" value="Call" onclick="call('<?php echo(trim($a_value[29]));?>','05')" /></td></tr>
						<?php } ?>

						<!--
            <tr class="listB"><td class="tit">28. Telp Rumah</td> <td><?php if($is_cleaned11 == 1) {echo "<span style='color:grey'>021</span>";} ?><?= ($a_value[11] != '' ? $a_value[11] : '<span style="color:grey">-NoData-</span>') ?></td><td class="call"><input type="button" id="telp_1" value="Call" onclick="call('<?php echo(trim($a_value[11]));?>','01')" /></td></tr>
            <tr class="listA"><td class="tit">29. Telp_Kantor</td> <td><?php if($is_cleaned12 == 1) {echo "<span style='color:grey'>021</span>";} ?><?= ($a_value[12] != '' ? $a_value[12] : '<span style="color:grey">-NoData-</span>') ?></td><td class="call"><input type="button" id="telp_2" value="Call" onclick="call('<?php echo(trim($a_value[12]));?>','02')" /></td></tr>
            <tr class="listB"><td class="tit">30. Telp_Lain</td> <td><?php if($is_cleaned13 == 1) {echo "<span style='color:grey'>021</span>";} ?><?= ($a_value[13] != '' ? $a_value[13] : '<span style="color:grey">-NoData-</span>') ?></td><td class="call"><input type="button" id="telp_3" value="Call" onclick="call('<?php echo(trim($a_value[13]));?>','04')" /></td></tr>
            -->

            <!-- <tr class="listA"><td class="tit">31. <strong>108</strong></td> <td><h3>108</h3></td><td class="call"><input type="button" value="Call" onclick="get_phone('108')" /></td></tr> -->
        </table>
    </div>
    <span class="boxmid_bot"></span>

    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <center><h2>New Phone No.</h2></center>

        <br/>
        <center><input type="button" id="view_phone" value="Add New Phone" style="text-align:center; font-size:12px;  padding-bottom:5px; background:url(<?php echo base_url() ?>assets/images/but_clean.png); border:none;width:115px; height:31px;" onclick="boxPopup('Add New Phone Number','<?php echo site_url() ?>user/hdr_contact_cont/get_phone_no/<?= $a_value[0] ?>');return false;" /></center>
        <table id="debtor_info" class="midleft" >


<?php
            if ($get_other_phone->num_rows() > 0) {
                $i = 1;
                $no_p = 65;
?>
            <?php foreach ($get_other_phone->result() as $new_phone) {
                    $i++; ?>
                    <tr class="list<?= $i % 2 == 0 ? "A" : "B"; ?>" id="phone_<?= $new_phone->id_phone ?>">
                <td class="tit"><?= $no_p + $i ?>. <?= $new_phone->phone_type ?></td>
                <td><?= $new_phone->phone_no ?></td>
                <td class="call"><input type="button" value="Call" onclick="call('<?php echo (trim($new_phone->phone_no)); ?>','04')"/> &nbsp;&nbsp;
                    <a id="no_under" class="title" title="Created by : <?= $new_phone->username ?>|Created Date : <?= $new_phone->createdate ?>" href="#">Info</a>&nbsp;&nbsp;
                    <a href="#" onclick="boxPopup('Edit Phone No','<?= site_url() ?>user/hdr_contact_cont/get_phone_no/edit/<?= $new_phone->id_phone ?>');return false;">Edit</a>&nbsp;|&nbsp;
                    <a href="#" onclick="deletePhone('<?= site_url() ?>user/hdr_contact_cont/delete_phone/<?= $new_phone->id_phone ?>','<?= $new_phone->id_phone ?>')">Delete</a>
                </td>
            </tr>
<?php
        }
    } else {

    }
?>

            <br></br>
        </table>
    </div>
    <span class="boxmid_bot"></span>

    <!-- Callback -->

    <span class="boxmid_top"></span>
    	<div class="boxmid_box">
    		<div style="text-align:left">
    			<center><h2>Callback Setup .</h2></center>
    		</div>
    		<!-- Enyx -->
    		<br/>
    			<input type="text" id="example3" name="example3" value="- CallBack Time -" /><br/><br/>
    			<textarea id="cb_notes" rows="2" maxlength="100" style="width:98%" onkeyup="upperThis('cb_notes')" onclick="clearThis('cb_notes','-Notes-')">-Notes-</textarea><br/><span id="notes_charCount">0</span>/50<br/>

    			<span id="cb_indicator"></span><br/>
    			<input type="button" class="but_proceed" id="cb_submit" onclick="callbackInputCheck()" />

    	</div>
    	<span class="boxmid_bot"></span>


<!--
    <span class="boxmid_top"></span>

    <div class="boxmid_box">
        <table class="midleft">
            <tr class="listB"><td class="tit">36. TEMPAT/TGL LAHIR</td> <td><?= $a_value[0]
?></td></tr>
            <tr class="listB"><td class="tit">37. STATUS PERKAWINAN</td> <td><?= $a_value[0]
?></td></tr>
            <tr class="listB"><td class="tit">38. UMUR</td> <td><?= $a_value[0]
?></td></tr>
            <tr class="listA"><td class="tit">39. NAMA IBU KANDUNG</td> <td class="currency"><?= $a_value[02]
?></td></tr>
            <tr class="listB"><td class="tit">40. STATUS RUMAH</td><td class="currency"><?= $a_value[0]
?></td></tr>
            <tr class="listB"><td class="tit">41. PEKERJAAN</td> <td class="currency"><?= $a_value[0]
?></td>
            </tr>
        </table>

    </div>

    <span class="boxmid_bot"></span>
 -->
    <span class="boxmid_top"></span>
    <div class="boxmid_box">

                                 <br />
                                 <br />
                                 <select class="fbsx" id="id_action_call_track" name="id_action_call_track"  style="width:32em;" onchange="changeAction(this.value)">
                                     <option selected="selected" value="0">Action Code</option>
<?php foreach ($action_call_track->result() as $row_call) { ?>
                                         <option value="<?= $row_call->id_action_call_track ?>,<?= $row_call->code_call_track ?>,<?= $row_call->id_call_cat ?>"><?= $row_call->description ?>&nbsp;&nbsp;&nbsp;(<?= $row_call->contact ?>)</option>
<?php } ?>
        </select>
        <br />
        <br />

        <br />

        <!-- Jika Janji Bayar -->
        <div style="display:none;" id="cont_ptp">
        	<?php
$dpdd = $a_value[6];
        	if($dpdd==7){
        		$ptp_date_max = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
        	}else if($dpdd==6){
        		$ptp_date_max = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
        	}else  if($dpdd==5){
        		$ptp_date_max = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+2,date("Y")));
        	}else { 
        		$ptp_date_max = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+3,date("Y")));
        	}      		
		$bulan_berjalan = date("m");
        		$bulan_berjalan_ptp = date("m",mktime(0,0,0,date("m"),date("d")+3,date("Y")));
        		
        		if($bulan_berjalan != $bulan_berjalan_ptp)
        		{
        			$bulan_berjalan_ptp2 = date("m",mktime(0,0,0,date("m"),date("d")+2,date("Y")));
        			if($bulan_berjalan != $bulan_berjalan_ptp2)
        			{
        				$bulan_berjalan_ptp3 = date("m",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
        				if($bulan_berjalan != $bulan_berjalan_ptp3)
        					$ptp_date_max = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
        				else
        					$ptp_date_max = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
        			}
        			else
        				$ptp_date_max = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+2,date("Y")));
        		}
        		
        	?>
            <br />PTP Date
            <input type="text" id="datepicker_r" name="ptp_date"  class="ptp_date" size="15" value="<?=$limit_ptp?>" onchange="calculate_due(this.value)" readonly />
     	      <input type="hidden" name="limit" id="limit" value="<?php echo $remaining;?>" />                                                                                                                                                                                                                                                                                                                                                                                                                            					  PTP Amount
            <input type="text" name="ptp_amount" id="ptp_amount" class="ptp_amount" value=""/>
        </div>
        <!-- END jika janji bayar -->

        <!-- Jika Tidak Contact dengan customer langsung -->
         <div style="display:none;" id="handling_debt">
            &nbsp;
            <select class="fbsx" style="width:32em;" id="id_handling_debt" name="id_handling_debt">
            		<option value="00"> Handling Debitur </option>
            		<?php
            		$sql = "select * from hdr_handling_debitur_name WHERE HAND_DEBT_CODE != '00'";
            		$res = $this->db->query($sql);

            		foreach($res->result() as $row){
            			echo "<option value=\"$row->HAND_DEBT_CODE\">$row->HAND_DEBT_DESC</option>";
            		}
            		?>
            </select>
        </div>
        <!-- End Jika tidak contact dengan customer langsung -->

        <br />

        <div style="display:none;" id="call_back">
            <br />Reminder Date
            <input type="text" id="datepicker2" name="due_date"  class="due_date" size="15"/>
                                                                                                                                                                                                                                                                                                                                                                                                                                   					  Time Call
            <input type="text" name="due_time" class="call_b" id="call_back_time" value=""  />
<!--<img src="<?= base_url() ?>assets/images/clock.png" alt="Time" border="0" style="position:absolute;margin:4px 0 0 6px;" id="trigger-test" />-->
            <br />
            <br />
            <br />
        </div>
        <br />
        <!--
        <h3><span class="max_ptp">Maximum Tanggal PTP adalah <?= $limit_ptp ?></span></h3>
        -->
        <br />
        <!--select class="fbsx" id="id_contact_code" name="id_contact_code" style="width:10em;">
            <option selected value=",NO SELECT">Delinquency</option>
<?php foreach ($call_catagory->result() as $row_loc) { ?>
            <option value="<?= $row_loc->code ?>,<?= $row_loc->description ?>"><?= $row_loc->description ?></option>
<?php } ?>
        </select-->
        <select class="fbsx" id="id_ptp" name="id_ptp" onchange="changePTP(this.value)" style="width:10em;">
            <option selected="selected" value="">Handling</option>
<?php foreach ($ptp_catagory->result() as $row_ptp) { ?>
            <option value="<?= $row_ptp->code ?>,<?= $row_ptp->description ?>"><?= $row_ptp->description ?></option>
<?php } ?>
        </select>
        <br />
        <textarea class="fbtx" id="remarks" name="remarks" value="" disabled="true" ></textarea>
        <br />
        <br />
        <input type="button" class="but_proceed"  onclick="checkCalltrack('<?php echo site_url() ?>user/hdr_contact_cont/insert_calltrack/','1');return false;" />
             <input  type="button" class="but_sp" value="Next"
<?php
        switch ($contact_type) {
            case "ptp":
                echo 'onclick="checkCalltrack(\'' . site_url() . 'user/hdr_contact_cont/contact/ptp\',\'loc\');return false;"';
                break;
            case "no_contact_fu":
                echo 'onclick="checkCalltrack(\'' . site_url() . 'user/hdr_contact_cont/contact/no_contact_fu\',\'loc\');return false;"';
                break;
            case "contact_fu":
                echo 'onclick="checkCalltrack(\'' . site_url() . 'user/hdr_contact_cont/contact/contact_fu\',\'loc\');return false;"';
                break;
            default:
                echo 'onclick="checkCalltrack(\'' . site_url() . '/user/hdr_contact_cont/contact/call\',\'loc\');return false;"';
        }
?>/>
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <!--input type="button" class="but_reg" id="rep" value='REPETISI' onclick="checkCalltrack('<?php echo site_url() ?>user/hdr_contact_cont/insert_calltrack_rep/','1');return false;" /-->
       <br/>
        <br/>
            <?php if ($this->uri->segment(4) != 'call') {
            ?>
            <input type="button" class="but_reg" value='SKIP CALL' id="skip_call" onclick="parent.location='<?php echo site_url() ?>user/hdr_contact_cont/contact/<?= $contact_type ?>'" />
            <?php } ?>
        <br/>
        <br/>
        <br/>


        <div style="display:none;" id="nextButton">

            <br/>
            <br/>
            <br/>
            <input  type="button" class="but_sp" value="Next"
<?php
        switch ($contact_type) {
            case "ptp":
                echo 'onclick="checkCalltrack(\'' . site_url() . 'user/hdr_contact_cont/contact/ptp\',\'loc\');return false;"';
                break;
            case "no_contact_fu":
                echo 'onclick="checkCalltrack(\'' . site_url() . 'user/hdr_contact_cont/contact/no_contact_fu\',\'loc\');return false;"';
                break;
            case "contact_fu":
                echo 'onclick="checkCalltrack(\'' . site_url() . 'user/hdr_contact_cont/contact/contact_fu\',\'loc\');return false;"';
                break;
            default:
                echo 'onclick="checkCalltrack(\'' . site_url() . '/user/hdr_contact_cont/contact/call\',\'loc\');return false;"';
        }
?>/></form>
        </div>
        <input type="hidden" id="primary_1" name="primary_1" value="<?= $a_value[2]
?>"   />
        <input type="hidden" id="id_user" name="id_user" value="<?= $id_user
?>"   />
               <?php
               switch ($contact_type) {
                   case "ptp":
                       echo '<input type="hidden" id="ptp_fu" name="ptp_fu" value="1"   />';
                       break;
                   case "no_contact_fu":
                       echo '<input type="hidden" id="fu" name="fu" value="1"   />';
                       break;
                   case "contact_fu":
                       echo '<input type="hidden" id="fu" name="fu" value="1"   />';
                       break;
                   default:
                       echo '';
               }
               ?>
<?php //$get_in_use = $this->call_track_model->get_latest_use($a_value[0],$id_user,$in_use);         ?>
        <input type="hidden" id="id_calltrack" name="id_calltrack" value="<?php //@$get_in_use->id_calltrack            ?>"   />
        <input type="hidden" id="username" name="username" value="<?= $username ?>"   />
        <input type="hidden" id="cname" name="cname" value="<?= $a_value[3] ?>"   />
        <input type="hidden" id="kode_cabang" name="kode_cabang" value="<?= $a_value[0] ?>"   />
        <input type="hidden" id="no_contacted" name="no_contacted" value=""   />
        <input type="hidden" id="score_result" name="score_result" value="<?= $a_value[34] ?>"   />
        

        <!-- Master Handling-->
        <input type="hidden" id="call_handling" name="call_handling" value=""   />
        <!-- ############## -->
        <!-- Master Result-->
        <input type="hidden" id="handling_code" name="handling_code" value=""   />
        <!-- ############## -->
        <!-- Deliquency Code-->
        <!--input type="hidden" id="id_contact_code" name="id_contact_code" value=""   />
        < ############## -->

	 <!-- Object Group Code--> <!-- 30 Jan 2011 -->
	<input type="hidden" id="object_group" name="object_group" value="<?= $a_value[23] ?>" />
	<!-- ############## -->

        <input type="hidden" id="os_ar_amount" name="os_ar_amount" value="<?= $a_value[9] ?>"   />
        <!-- <input type="hidden" id="surveyor" name="surveyor" value="<?= $a_value[7] ?>"   /> -->
        <input type="hidden" id="dpd" name="dpd" value="<?= $dpd ?>"   />
        <input type="hidden" id="region" name="region" value="<?= $a_value[11] ?>"   />
        <input type="hidden" id="angsuran_ke" name="angsuran_ke" value="<?= $a_value[4] ?>"   />
		<input type="hidden" id="last_call_code" name="last_call_code" value="<?= $get_main_info->last_call_code ?>"   />
        <br />
        <br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

 
        <br />
        <center><input type="button" class="but_reg" value="View Dashboard" onclick="boxPopup('View Dashboard','<?php echo site_url('user/hdr_contact_cont/summary_pop/' . $primary_1) ?>')"/></center>
        <br />
 
        <br />

        <!-- Other info Reminder , Active Records,  Reschedule -->
                <!--<div class='other_info'><center><img src="<?= base_url() ?>assets/images/loader.gif" /></div>-->
    </div>
    <span class="boxmid_bot"></span>
</div>
<p class="clear"></p>

<script>

    $('.phone_no').priceFormat({
    prefix: '',
    centsSeparator: '',
    thousandsSeparator: '',
    centsLimit: 0
    });
    
    
	//QUEING CONTACT SAAT AKTIF
	/*$(document).ready(function(){
		var ai_user = '<?php echo($user_info->ai); ?>';
		if(ai_user == '1' || ai_user == 1){
			call('<?php echo(trim($a_value[14]));?>','03');
		}
	});*/
	//QUEING PREDICTIVE DIAL
	$(document).ready(function() {
		//alert('d');
		call('<?php echo(trim($get_main_info->cell_phone2))?>','03');
	});
    
</script>
