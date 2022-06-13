<script>

        $(document).ready(function(){
        		$('#leftpanel').html('<img src="<?= base_url() ?>assets/images/loader.gif" /> <br/> <h2>Listing file.. Please Wait ..</h2>').fadeOut(1000);
        		setTimeout("leftload()",1000);
        });	
	
	function reload_left(){
		$('#leftpanel').html('<img src="<?= base_url() ?>assets/images/loader.gif" /> <br/> <h2>Listing file.. Please Wait ..</h2>').fadeOut(1000);
		setTimeout("leftload()",1000);
	}
	
	function leftload(){		
		$('#leftpanel').load('<?= site_url() ?>admin/hdr_upload_cont/redownload_list').fadeIn('slow');
	}
	
</script>

<div class="content">
    <!-- start of CONTENT FULL -->
    <div class="cnfull">
        <span class="boxfull_top"></span>
        <div class="boxfull_box">
        <!-- start here -->        
        	<div class="main_panel" align="center">
        	<table width="90%" height="300px" style="border:2px solid gray;box-shadow: 5px 0px 25px #888888;border-radius:15px;">
        		<tr>
        			<!-- Left Panel -->
        			<td width="60%"> 
        				<div id="leftpanel" name="left_panel" align="right"> 
        					
        				</div> 
        			</td>
        			<!-- Right Panel -->
        			<td width="40%">
        				<input type="button" class="but_reg" name="left_reload" id="left_reload" value="Reload Data" onclick="reload_left()">	
        			</td>
        			
        		</tr>
        	</table>
        	</div>
        <!-- end here -->
			</div>
		<span class="boxfull_bot"></span>
	</div>	
</div>