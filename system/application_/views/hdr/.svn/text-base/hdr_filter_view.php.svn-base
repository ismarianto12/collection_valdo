<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/ui.dropdownchecklist.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/ui.dropdownchecklist-min.js"></script>
<script type="text/javascript">
function proceedFilter(url){
var id_users = jQuery('#id_user').val();
if(confirm("Do you want to proceed this filter?")){
	jQuery.post(url,{ 
						
							from_balance : jQuery('#from_balance').val(),
							to_balance : jQuery('#to_balance').val(),
							
							area : jQuery('.area').serialize(),
							
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
		
			$("#area1").dropdownchecklist({ firstItemChecksAll: true, maxDropHeight: 400, width: 700  });
        });
    </script>
<div class="content">
	<!-- start of CONTENT FULL -->
	<div class="cnfull">
		<span class="boxfull_top"></span>
		<div class="boxfull_box">
		<?php $last_record;  @$ex_last_record = explode(',',@$last_record);?>
			<p> -Setup Filtering- </p>
				<dl>
				
				
					<dt><label class="lblfl">Balance</label>
							<input type="text" id="from_balance" class="from_balance" value="<?php  @$ex_last_record[2]?>" name="from_balance" />
								to
							<input type="text" id="to_balance" class="to_balance" name="to_balance" value="<?php  @$ex_last_record[3]?>"/></dt>
				
					<dt><label class="lblfl">Kode Cabang</label>
						<?php $kod_cab = explode(',',$all_kode_cabang); ?>
						<select id="area1" name="kode_cabang" class="area" multiple="multiple">
						<option value="">ALL</option>all_area
						<?php foreach($kod_cab as $row_kod_cab)  {?> 
								<option value="<?=$row_kod_cab?>"  <?php echo $sel = @$ex_last_record[6]==$row_kod_cab?'selected':''?>><?=$row_kod_cab?></option>
						<?php } ?>
						</select>
					</dt>
					<dt><label class="lblfl">DPD</label>
					<input type="text" id="from_dpd" class="from_dpd" value="<?php  @$ex_last_record[2]?>" name="from_dpd" />
								to
							<input type="text" id="to_balance" class="to_balance" name="to_balance" value="<?php  @$ex_last_record[3]?>"/>
					</dt>
				
								
				</dl>
<script>
$('.from_balance').priceFormat({prefix: '',centsSeparator: '',thousandsSeparator: '.',centsLimit: 0}); 
$('.to_balance').priceFormat({prefix: '',centsSeparator: '',thousandsSeparator: '.',centsLimit: 0}); 
$('.from_credit_limit').priceFormat({prefix: '',centsSeparator: '',thousandsSeparator: '.',centsLimit: 0}); 
$('.to_credit_limit').priceFormat({prefix: '',centsSeparator: '',thousandsSeparator: '.',centsLimit: 0}); 
</script>