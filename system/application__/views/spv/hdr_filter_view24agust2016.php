

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/ui.dropdownchecklist.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/ui.dropdownchecklist-min.js"></script>
<script type="text/javascript">
function proceedFilter(url){
var id_users = jQuery('#id_user').val();
if(confirm("Do you want to proceed this filter?")){

		var cekProduct = $('#product').val();
		var cekFintype = $('#fin_type').val();
		var cekPriority = $('#priority').val();
		var cekOverdays = $('#over_days').val();
		var branch = $('#grp_branch').val();


		if(cekProduct == null){
			Boxy.alert('Product kosong, mohon periksa kembali filter anda !!');
			return;
		}
		if(cekFintype == null){
			Boxy.alert('Data Type kosong, mohon periksa kembali filter anda !!');
			return;
		}
		if(cekPriority == null){
			Boxy.alert('Priority kosong, mohon periksa kembali filter anda !!');
			return;
		}
		if(cekOverdays == null){
			Boxy.alert('Overdays kosong, mohon periksa kembali filter anda !!');
			return;
		}
		if(branch == null){
			Boxy.alert('Cabang wajib terpilih minimal 1, mohon periksa kembali filter anda !!');
			return;
		}


		jQuery.post(url,{
								product : jQuery('#product').val(),
								priority : jQuery('#priority').val(),
								ovrday : jQuery('#ovrday').val(),
								region : jQuery('#grp_region').val(),
								branch : jQuery('#grp_branch').val(),
								over_days : jQuery('#over_days').val(),
								from_dpd : jQuery('#from_dpd').val(),
								to_dpd : jQuery('#to_dpd').val(),
								id_user : id_users,
								//exmode : jQuery('#exmode').attr('checked'),
								fin_type : jQuery('#fin_type').val(),
								product_flag : jQuery('#product_flag').val(),
								bucket_coll : jQuery('#bucket_coll').val(),
								bucket_od : jQuery('#bucket_od').val(),
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
				<center><h2><?=$get_user->fullname?></h2></center>
				<dl>
					<dt><label class="lblfl">Product</label>
							<select id="product" name="product[]" class="product" multiple="multiple" size="5" style="height:50px;">
								<!-- <option value="ALL">All</option> -->
								<option value="002" SELECTED>MOBIL</option>
								<option value="001" SELECTED>MOTOR</option>
								<option value="003" SELECTED>DURABEL</option>
								<option value="004" SELECTED>DURABEL TOKO</option>
							</select>
					</dt>
					<span style="color:red">*Wajib dipilih minimal 1 Product</span>

					<dt><label class="lblfl">Data Type</label>
							<select id="fin_type" name="fin_type[]" multiple="multiple" size="5" style="height:50px;">
								<option value="1" SELECTED >CONVENTIONAL</option>
								<option value="2" SELECTED >SYARIAH</option>
							</select>
					</dt>
					<span style="color:red">*Wajib dipilih minimal 1 Type</span>

					<dt><label class="lblfl">Priority</label>
							<select id="priority" name="priority" class="priority" size="5" style="height:50px;">
								<option value="">All</option>
								<option value="PTP">PTP</option>
								<option value="UNTOUCH" SELECTED >UNTOUCH</option>
								<option value="RETOUCH">RETOUCH</option>
							</select>
					</dt>

					<dt><label class="lblfl">Over Days</label>
							<select id="over_days" name="over_days[]" class="over_days" multiple="multiple" size="5">
								<option value="" SELECTED>All</option>
								<option value="10plus">10+</option>
								<option value="9">9</option>
								<option value="8">8</option>
								<option value="7">7</option>
								<option value="6">6</option>
								<option value="5">5</option>
								<option value="4">4</option>
								<option value="3">3</option>
								<option value="2">2</option>
								<option value="1">1</option>
								<option value="0">0</option>
								<option value="-1">-1</option>
								<option value="-2">-2</option>
								<option value="-3">-3</option>							</select>
					</dt>
					<span style="color:red">*Pilihan "All" akan mengabaikan semua option yang dipilih</span>

					<dt><label class="lblfl">DPD</label>
					<input type="text" id="from_dpd" class="from_dpd" value="<?php echo $dpdfrom_rec = findinside_filter_p('dpd >=',$get_user->filter_debtor);?>" name="from_dpd" />
								to
							<input type="text" id="to_dpd" class="to_dpd" name="to_dpd" value="<?php echo $dpdto_rec = findinside_filter_p('dpd <=',$get_user->filter_debtor);?>"/>
					</dt>

					<dt><label class="lblfl">Region</label>
							<select id="grp_region" name="region" class="region">
								<option value="">All</option>
								<?php
								foreach($regions as $region)
								{
									echo '<option value="'.$region['region_id'].'">'.$region['region_name'].'</option>';
								}
								?>
							</select>
					</dt>

					<dt><label class="lblfl">Cabang</label>

							<select id="grp_branch" name="branch_code[]" multiple="multiple" size="5" style="height:50px;">
								<option value="" SELECTED>All</option>
							</select>
					</dt>
					<dt><label class="lblfl">Product Flag</label>
						<select id="product_flag" name="product_flag[]" multiple="multiple" style="height:50px;">
								<option value="">All</option>
								<option value="1">Otomotif</option>
								<option value="2">Durable</option>
						</select>
					</dt>
					<dt>
					<label class="lblfl">Bucket Coll</label>
						<select id="bucket_coll" name="bucket_coll[]" multiple="multiple" style="height:50px;">
								<option value="">All</option>
								<option value="1">Cabang Project</option>
								<!--
								<option value="2">BE</option>
								-->
						</select>
					</dt>
					<dt>
					<label class="lblfl">Bucket OD</label>
						<select id="bucket_od" name="bucket_od">
								<option value="">All</option>
								<option value="1">OD 1-7</option>
								<option value="2">OD 8 > UP</option>
						</select>
					</dt>

				</dl>
		<!--
				<dt><label class="lblfl">Exclude Mode</label>
					<input type="checkbox" id="exmode" name="exmode"> Enable
			</dl>
		-->
		  <p>
	   <label class="filter">
      	<input type="hidden" name="post2" value="1" />
      	<input type="hidden" name="id_user" id="id_user" value="<?=$get_user->id_user?>" />
      	&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="but_proceed" type="button"  name="btnsubmit" onclick="proceedFilter('<?=site_url()?>/spv/hdr_setup_filter_cont/proceed_filter')" value="" />

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

/*
$('.from_balance').priceFormat({prefix: '',centsSeparator: '',thousandsSeparator: '.',centsLimit: 0});
$('.to_balance').priceFormat({prefix: '',centsSeparator: '',thousandsSeparator: '.',centsLimit: 0});
$('.from_credit_limit').priceFormat({prefix: '',centsSeparator: '',thousandsSeparator: '.',centsLimit: 0});
$('.to_credit_limit').priceFormat({prefix: '',centsSeparator: '',thousandsSeparator: '.',centsLimit: 0});
*/

//Region Combo box
$("#grp_region").change(function(event){

	var region_value = $("#grp_region").val();
	if(region_value != "")
	{
		var sturl = '<?=site_url()?>json/get_allbranch/' + region_value;
		//alert(sturl);
		$.getJSON(sturl,
			function(bag)
			{
				$("#grp_branch").empty();
				//$('<option />').attr('value', "").html("All").appendTo('#grp_branch');
				$.each(bag.items, function(i, item)
				{
					$('<option />').attr('value', item.branch_id).html(item.branch_name).appendTo('#grp_branch');
				});
			}
		);
	} else {
		$("#grp_branch").empty();
		$('<option />').attr('value', "").attr('SELECTED',"TRUE").html("All").appendTo('#grp_branch');
	}

});



</script>
</div>
