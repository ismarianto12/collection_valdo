

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
								over_days : jQuery('#over_days').val(),
								id_user : id_users,
								exmode : jQuery('#exmode').attr('checked'),
								fin_type : jQuery('#fin_type').val(),
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
								<!-- <option value="ALL">All</option> -->
								<option value="002">MOBIL</option>
								<option value="001">MOTOR</option>
							</select>
					</dt>
					
					<dt><label class="lblfl">Data Type</label>
							<select id="fin_type" name="fin_type[]" multiple="multiple" size="5">
								<option value="1" SELECTED >CONVENTIONAL</option>
								<option value="2" SELECTED >SYARIAH</option>
							</select>
					</dt>
 					
					<dt><label class="lblfl">Priority</label>
							<select id="priority" name="priority" class="priority" size="5">
								<option value="">All</option>
								<option value="PTP">PTP</option>
								<option value="UNTOUCH">UNTOUCH</option>	
								<option value="RETOUCH">RETOUCH</option>
							</select>
					</dt>

					<dt><label class="lblfl">Over Days</label>
							<select id="over_days" name="over_days[]" class="over_days" multiple="multiple" size="5">
								<option value="">All</option>
								<option value="180">180</option>
								<option value="179">179</option>
								<option value="178">178</option>
								<option value="177">177</option>
								<option value="176">176</option>
								<option value="175">175</option>
								<option value="174">174</option>
								<option value="173">173</option>
								<option value="172">172</option>
								<option value="171">171</option>
								<option value="170">170</option>
								<option value="169">169</option>
								<option value="168">168</option>
								<option value="167">167</option>
								<option value="166">166</option>
								<option value="165">165</option>
								<option value="164">164</option>
								<option value="163">163</option>
								<option value="162">162</option>
								<option value="161">161</option>
								<option value="160">160</option>
								<option value="159">159</option>
								<option value="158">158</option>
								<option value="157">157</option>
								<option value="156">156</option>
								<option value="155">155</option>
								<option value="154">154</option>
								<option value="153">153</option>
								<option value="152">152</option>
								<option value="151">151</option>
								<option value="150">150</option>
								<option value="149">149</option>
								<option value="148">148</option>
								<option value="147">147</option>
								<option value="146">146</option>
								<option value="145">145</option>
								<option value="144">144</option>
								<option value="143">143</option>
								<option value="142">142</option>
								<option value="141">141</option>
								<option value="140">140</option>
								<option value="139">139</option>
								<option value="138">138</option>
								<option value="137">137</option>
								<option value="136">136</option>
								<option value="135">135</option>
								<option value="134">134</option>
								<option value="133">133</option>
								<option value="132">132</option>
								<option value="131">131</option>
								<option value="130">130</option>
								<option value="129">129</option>
								<option value="128">128</option>
								<option value="127">127</option>
								<option value="126">126</option>
								<option value="125">125</option>
								<option value="124">124</option>
								<option value="123">123</option>
								<option value="122">122</option>
								<option value="121">121</option>
								<option value="120">120</option>
								<option value="7">7</option>
								<option value="6">6</option>
								<option value="5">5</option>
								<option value="4">4</option>
								<option value="3">3</option>
								<option value="2">2</option>
								<option value="1">1</option>
								<option value="0">0</option>
								<option value="-1">-1</option>															
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

							<select id="grp_branch" name="branch_code[]" multiple="multiple" size="5">
								<option value="">All</option>
							</select>
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
	}

});



</script>
</div>
