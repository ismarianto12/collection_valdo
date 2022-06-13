<script>
function loadListUser(){
//notif.hide();
$(document).ready(function(){
	$('.viewUser').load('<?=site_url()?>spv/hdr_setup_filter_cont/list_details_user/')
 });
}
loadListUser();
</script>

<div class="content">
	<!-- start of CONTENT FULL -->
	<div class="cnfull">
		<span class="boxfull_top"></span>
		<div class="boxfull_box">
			<h2 class="tit">&nbsp;User Filtering</h2>
			<br/>
			<div class="viewUser"><center><img src="<?=base_url()?>assets/images/loader.gif" /><center></div>
			</div>
		<span class="boxfull_bot"></span>
	<!-- end of CONTENT FULL 
<input type="button" id="view_dbo" value="Button Uncontact Joko" style="background-color: #990000" onclick="boxPopup('Memo BDO','<?php echo site_url() ?>spv/hdr_setup_filter_cont/change_form/ ');return false;" />
<input type="button" id="view_dbo" value="Button Uncontact Rani" style="background-color: #b30059" onclick="boxPopup('Memo BDO','<?php echo site_url() ?>spv/hdr_setup_filter_cont/change_form_rani/ ');return false;" />-->
<input type="button" id="view_dbo" value="Button Uncontact DC1" style="background-color: #FFFF00"onclick="boxPopup('Memo BDO','<?php echo site_url() ?>spv/hdr_setup_filter_cont/change_form_nisa/ ');return false;" />

<!--input type="button" id="view_dbo" value="Senen" onclick="boxPopup('Memo BDO','<?php echo site_url() ?>spv/hdr_setup_filter_cont/change_form_senen/ ');return false;" /-->         
</div>
</div>