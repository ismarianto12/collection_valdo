

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/ui.dropdownchecklist.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/ui.dropdownchecklist-min.js"></script>
<script type="text/javascript">
function proceedFilter(url){
var id_users = jQuery('#id_user').val();
if(confirm("Do you want to proceed this filter?")){
	jQuery.post(url,{ 
							bucket : jQuery('.bucket').serialize(),
							cycle : jQuery('.cycle').serialize(),
							from_balance : jQuery('#from_balance').val(),
							to_balance : jQuery('#to_balance').val(),
							from_dpd : jQuery('#from_dpd').val(),
							to_dpd : jQuery('#to_dpd').val(),
							from_credit_limit : jQuery('#from_credit_limit').val(),
							to_credit_limit : jQuery('#to_credit_limit').val(),
							kode_cabang : jQuery('.kode_cabang').serialize(),
							cardblock : jQuery('.cardblock').serialize(),
							accblock : jQuery('.accblocks').serialize(),
							card_type : jQuery('.card_type').serialize(),
							id_user : id_users,
							//next_remarks : jQuery('#next_remarks').val(),
							post : true
						}, function(html) {
						//alert(buckets);
					set_berhasil(html);//reload_flexiCalltrack(html);
	});
	}
}
function resetFilter(url){
var id_users = jQuery('#id_user').val();
	if(confirm("Do you want to proceed this filter?")){
		jQuery.post(url,{ 
								id_user : id_users,
								post : true
							}, function(html) {
			   			set_berhasil(html);//reload_flexiCalltrack(html);
							
						//http://development.areasons.com/orion/user/
		});
		}
}
function alertMulti(){
/* jQuery(document).ready(function(){
 var bucket = $('#bucket1').val(),
	alert(bucket);
 }); */
 }
        $(document).ready(function() {
			//$("#cardblock1").dropdownchecklist({ firstItemChecksAll: true, maxDropHeight: 200, width: 176  });
			//$("#accblocks1").dropdownchecklist({ firstItemChecksAll: true, maxDropHeight: 200, width: 176  });
			//$("#card_type1").dropdownchecklist({ firstItemChecksAll: true, maxDropHeight: 113, width: 135  });
			//$("#cycle1").dropdownchecklist({ firstItemChecksAll: true, maxDropHeight: 200, width: 300  });
			$("#kode_cabang1").dropdownchecklist({ firstItemChecksAll: true, maxDropHeight: 400, width: 700  });
            //$("#bucket1").dropdownchecklist({ firstItemChecksAll: true, maxDropHeight: 250, width: 300  });
			$("#s6").dropdownchecklist();
			$("#s7").dropdownchecklist({ maxDropHeight: 200 });
        });
    </script>
	<?php 
			function findinside_filter($start, $string) {
				$start_f = 'hdm.'.$start.' IN("';
				preg_match_all('/' . preg_quote($start_f, '/') . '([^\.)]+)'. preg_quote('")', '/').'/i', $string, $m);
				$output = preg_replace("/[,\"]+/",',' ,$m[1]);
				if(!empty($output[0])) {
					return $output[0];
				} else{
					return '';
				}
			}
			function findinside_filter_p($start, $string) {
				$start_f = 'hdm.'.$start;
				preg_match_all('/' . preg_quote($start_f, '/') . '([^\.)]+)'. preg_quote('"', '/').'/i', $string, $m);
				$output = preg_replace("/[,\"]+/",'' ,$m[1]);
				if(!empty($output[0])) {
					return $output[0];
				} else{
					return '';
				}
			}
			 function match_f($filter,$string){
				if(preg_match('/'.$filter.'/',$string)){
					return 1;
				}else{
					return 0;
				}
			  }
			?>
<div class="content">
	<!-- start of CONTENT FULL -->
	<div class="cnfull">
		<span class="boxfull_top"></span>
		<div class="boxfull_box">
		<center><a href="#"><img src="<?=base_url()?>assets/images/but_is_close.png" id="close" /></a></center>
				<br/>
				<br/>
				<center><h2><?=$get_user->fullname?></h2></center>
				<dl>
					
					
					<dt><label class="lblfl">Balance</label>
							<input type="text" id="from_balance" class="from_balance" value="<?php echo $balancefrom_rec = findinside_filter_p('balance >=',$get_user->filter_debtor);?>" name="from_balance" />
								to
							<input type="text" id="to_balance" class="to_balance" name="to_balance" value="<?php echo $balanceto_rec = findinside_filter_p('balance <=',$get_user->filter_debtor);?>"/></dt>
					
					<dt><label class="lblfl">Kode Cabang</label>
						<?php $areas = explode(',',$all_kode_cabang); ?>
						<?php  $area_rec = findinside_filter('kode_cabang',$get_user->filter_debtor); ?>
						<select id="kode_cabang1" name="kode_cabang" class="kode_cabang" multiple="multiple">
						<option value="">ALL</option>
						<?php foreach($areas as $row_areas)  {?> 
								<option value="<?=$row_areas?>" <?php echo $sel = match_f($row_areas,$area_rec)==1?'selected':''?>><?=$row_areas?></option>
						<?php } ?>
						</select>
						<dt><label class="lblfl">DPD</label>
					<input type="text" id="from_dpd" class="from_dpd" value="<?php echo $dpdfrom_rec = findinside_filter_p('dpd >=',$get_user->filter_debtor);?>" name="from_dpd" />
								to
							<input type="text" id="to_dpd" class="to_dpd" name="to_dpd" value="<?php echo $dpdto_rec = findinside_filter_p('dpd <=',$get_user->filter_debtor);?>"/>
					</dt>
								
				</dl>
			
		  <p>
	   <label class="filter">
      	<input type="hidden" name="post2" value="1" />
      	<input type="hidden" name="id_user" id="id_user" value="<?=$get_user->id_user?>" />
      	&nbsp;&nbsp;&nbsp;&nbsp;
<input class="but_proceed" type="button"  name="btnsubmit" onclick="proceedFilter('<?=site_url()?>/admin/hdr_setup_filter_cont/proceed_filter')" value="" />
		
      </label>
	  </p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		</div>
		<span class="boxfull_bot"></span>
	</div>
	<!-- end of CONTENT FULL -->
</div>
<script>
$('.from_balance').priceFormat({prefix: '',centsSeparator: '',thousandsSeparator: '.',centsLimit: 0}); 
$('.to_balance').priceFormat({prefix: '',centsSeparator: '',thousandsSeparator: '.',centsLimit: 0}); 
$('.from_credit_limit').priceFormat({prefix: '',centsSeparator: '',thousandsSeparator: '.',centsLimit: 0}); 
$('.to_credit_limit').priceFormat({prefix: '',centsSeparator: '',thousandsSeparator: '.',centsLimit: 0}); 
</script>
</div>
