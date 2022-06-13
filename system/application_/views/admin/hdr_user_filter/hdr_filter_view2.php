

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/ui.dropdownchecklist.css" />
<script type="text/javascript" src="<?php echo base_url()?>assets/js/ui.dropdownchecklist-min.js"></script>
<script type="text/javascript">
function proceedFilter(url){
var id_users = jQuery('#id_user').val();
if(confirm("Do you want to proceed this filter?")){

		jQuery.post(url,{
								//bucket : jQuery('.bucket').serialize(),
								//cycle : jQuery('.cycle').serialize(),
								//from_balance : jQuery('#from_balance').val(),
								//to_balance : jQuery('#to_balance').val(),
								//from_dpd : jQuery('#from_dpd').val(),
								//to_dpd : jQuery('#to_dpd').val(),
								//from_credit_limit : jQuery('#from_credit_limit').val(),
								//to_credit_limit : jQuery('#to_credit_limit').val(),
								//kode_cabang : jQuery('.kode_cabang').serialize(),
								//cardblock : jQuery('.cardblock').serialize(),
								//accblock : jQuery('.accblocks').serialize(),
								//card_type : jQuery('.card_type').serialize(),
								product : jQuery('#product').val(),
								priority : jQuery('#priority').val(),
								ovrday : jQuery('#ovrday').val(),
								region : jQuery('#grp_region').val(),
								branch : jQuery('#grp_branch').val(),
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

					<dt><label class="lblfl">Product</label>
							<select id="product" name="product[]" class="product" multiple="multiple" size="5">
								<option value="ALL">All</option>
								<option value="KMB">KMB</option>
								<option value="ELEKTRONIK">Elektronik</option>
								<option value="MOBIL">Mobil</option>
							</select>
					</dt>

					<dt><label class="lblfl">Priority</label>
							<select id="priority" name="priority" class="priority">
								<option value="">Silahkan pilih</option>
								<option value="PTP">PTP</option>
								<option value="OVERDUE">Over due</option>
								<option value="NOTOVERDUE">Not Over due</option>
								<option value="ANGSKE1">Angs ke-1</option>
							</select>
					</dt>

					<dt><label class="lblfl">Over Days</label>
							<select id="ovrday" name="ovrday" class="ovrday">
								<option value="">Silahkan pilih</option>
								<option value="3">3</option>
								<option value="2">2</option>
								<option value="1">1</option>
								<option value="0">0</option>
								<option value="-1">-1</option>
								<option value="-2">-2</option>
								<option value="-3">-3</option>
								</select>
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

							<select id="grp_branch" name="branch_code">
								<option value="">All</option>
							</select>

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
				$('<option />').attr('value', "").html("Pilih").appendTo('#grp_branch');
				$.each(bag.items, function(i, item)
				{
					$('<option />').attr('value', item.branch_id).html(item.branch_name).appendTo('#grp_branch');
				});
			}
		);
	}

});



</script>
</div>
