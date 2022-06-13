
<script>

$(document).ready(function(){
	$('.viewDebtor').load('<?=site_url()?>spv/hdr_spv_debtor_cont/list_details_debtor/<?php echo $is_approved ?>')
});

function goSearch()
{
	var begindate = $('.begindate').val();
	var enddate = $('.enddate').val();

	var is_approved = $('#is_approved').val();

	//alert('<?=site_url()?>spv/hdr_spv_debtor_cont/list_details_debtor/'+is_approved+'/'+begindate+'/'+enddate);

	$('.viewDebtor').load('<?=site_url()?>spv/hdr_spv_debtor_cont/list_details_debtor/'+is_approved+'/'+begindate+'/'+enddate);

}
function goApproved(){

	var frm = document.forms['form1'];
	frm.action = 'approved';
	frm.submit();

}
function goRejected(){

	var frm = document.forms['form1'];
	frm.action = 'rejected';
	frm.submit();

}
function goPending(){

	var frm = document.forms['form1'];
	frm.action = 'pending';
	frm.submit();

}




</script>

<div class="content">
	<!-- start of CONTENT FULL -->
	<div class="cnfull">
		<span class="boxfull_top"></span>
		<div class="boxfull_box">
			<center><h2 class="tit">&nbsp;Other Phone</h2></center>
			<br/>
			<h2 class="tit">&nbsp;Filter</h2>
			<br/>
			<form action="<?php print site_url(); ?>/spv/hdr_spv_debtor_cont/" method="post">
			<table border="0" cellpadding="3" cellspacing="2">
			<tr>
     		<td>Activity Date</td>
     	  <td><input type="text" name="start_date" class="begindate" id="datepicker" size="20" maxlength="15" />
     	  To<input type="text" name="finish_date" class="enddate" id="datepicker2" size="20" maxlength="15" />
     	  </td>
     	</tr>
			<tr>
     		<td>Status</td>
     	  <td>
	     	  	<select name="is_approved" id="is_approved">
		        	<option value="-" <?php echo $is_approved == '' ? 'selected' : '' ?> >Pending</option>
		          <option value="1" <?php echo $is_approved == '1' ? 'selected' : '' ?> >Approved</option>
		          <option value="2" <?php echo $is_approved == '2' ? 'selected' : '' ?> >Rejected</option>
	         </select>
        </td>
     	</tr>
     	<tr>
     		<td colspan="2">
     			<input type="button" value="Search" onclick="goSearch();return false;" />
     		</td>
     	</tr>
			</table>
      </form>

			<div class="viewDebtor"><center><img src="<?=base_url()?>assets/images/loader.gif" /><center></div>
			<br/>
			<br/>
			<br/>
			</div>
		<span class="boxfull_bot"></span>
	</div>
	<!-- end of CONTENT FULL -->
</div>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>