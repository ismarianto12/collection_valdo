<script>
function loadListUser(){
//notif.hide();
$(document).ready(function(){
	$('.viewUser').load('<?=site_url()?>admin/hdr_setup_filter_cont/list_details_user/')	
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
	<!-- end of CONTENT FULL -->
</div>
</div>