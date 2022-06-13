
<script>
function update_debtor(url){
	jQuery("#loading").html('Submiting data...');
	jQuery.post(url,{
	       	id_phone : jQuery('#id_phone').val(),
					username : jQuery('#username').val(),
					phone_type : jQuery('#phone_type').val(),
					phone_no : jQuery('#phone_no').val(),
					createdate : jQuery('#createdate').val(),
					is_approved : jQuery('#is_approved').val(),
					post : true
   			}, function(html) {
			updated(html);

		});
}
function updated(html){
$(document).ready(function() {
        $.blockUI({
            message: (html),
            timeout: 3000
        });

});
}

</script>
<script type="text/javascript">
// perform JavaScript after the document is scriptable.
$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("ul.tabs").tabs("div.panes > div");
});
</script>
<script type="text/javascript">
	function confirmation(url,txt){

		if(confirm(txt)){
			location.href=url;
		}
		return false;
	}
</script>
<form action="#" method="post">
<?php
$id_phone = array();
foreach($list_debtor->result() as $row){
$id_phone[$row->id_phone] = $row->username;
}
?>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.tools.tabs-1.0.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/tabs.css"/>
<script type="text/javascript">
// perform JavaScript after the document is scriptable.
$(function() {
	// setup ul.tabs to work as tabs for each div directly under div.panes
	$("div.tabs").tabs("div.panes > div");
});
</script>
<div class="content">
<div class="viewCenter">
	<!-- start of CONTENT FULL -->
	<span class="boxcontright_top"></span>
      <div class="boxcontright_box">
        <div class="inside_boxright_center">

<p class="space"></p>

<div class="panes">

<div>
<table>
			<tr>
    		<td><input type="hidden" name="id_phone" id="id_phone" value="<?php echo $get_debtor->id_phone?>"/></td>
    </tr>
	<tr>
    	<td>UserName</td>
    	<td><input type="text" name="username" id="username" value="<?php echo $get_debtor->username?>"/></td>
    </tr>
      <tr>
    	<td>Phone Type</td>
    	<td><input type="text" name="phone_type" id="phone_type" value="<?php echo $get_debtor->phone_type?>"/></td>
    </tr>
    <tr>
    	<td>Phone No</td>
    	<td><input type="text" name="phone_no" id="phone_no" value="<?php echo $get_debtor->phone_no?>"/></td>
    </tr>
    <tr>
    	<td>Create Date</td>
    	<td><input type="text" class="datepicker" name="createdate" id="createdate" value="<?php echo $get_debtor->createdate?>" />
    	</td>
    </tr>

 <tr>
     	<td>Status</td>
        <td><select name="is_approved" id="is_approved">
        	<option value="0">Pending</option>
          <option value="1">Approved</option>
          <option value="2">Rejected</option>
         </select>
        </td>
    </tr>

    <tr>
      <td valign="bottom">&nbsp;</td>
      <td  height="50px" ><input type="button" class="but_sp"  value="CANCEL" onclick="location.href='<?php echo site_url('spv/hdr_spv_debtor_cont')?>'"/>
      <input type="button" class="but_proceed"  onclick="update_debtor('<?php echo site_url('spv/hdr_spv_debtor_cont/edit_debtor_ajax')?>')" /></td>
    </tr>

</table>
<input type="hidden" name="post" id="post" value="post" />
</form><br>
</div>
<div>


</div>
</div>
</div>
      </div>
      <span class="boxcontright_bot"></span> </div>
  <p class="clear"></p>
  </div>
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