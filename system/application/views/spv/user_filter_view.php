<script language="javascript">
function makeSublist(parent,child,isSubselectOptional,childVal)
{
	$("body").append("<select style='display:none' id='"+parent+child+"'></select>");
	$('#'+parent+child).html($("#"+child+" option"));
	
		var parentValue = $('#'+parent).attr('value');
		$('#'+child).html($("#"+parent+child+" .sub_"+parentValue).clone());
	
	childVal = (typeof childVal == "undefined")? "" : childVal ;
	$("#"+child+' option[value="'+ childVal +'"]').attr('selected','selected');
	
	$('#'+parent).change( 
		function()
		{
			var parentValue = $('#'+parent).attr('value');
			$('#'+child).html($("#"+parent+child+" .sub_"+parentValue).clone());
			if(isSubselectOptional) $('#'+child).prepend("<option value='none'> -- Select -- </option>");
			$('#'+child).trigger("change");
                        $('#'+child).focus();
		}
	);
}

	$(document).ready(function()
	{
		makeSublist('id_level','id_leader', false, '1');	
	});
</script>
<script>
function checkUser(url){
	var password = jQuery('#passwd').val();
	var repassword = jQuery('#repasswd').val();
	var username = jQuery('#username').val();
	var fullname = jQuery('#fullname').val();
	if(password ==''){
		telli("Please fillout both password");
	}else if(repassword==''){
		telli("Please fillout both password");
	}else if(password!=repassword){
		telli("Entered passwords do not match");
	}else if(username==''){
		telli("Please Enter the Username");
	}else if(fullname==''){
		telli("Please Enter the Fullname");
	}else{
		add_user(url);
	}
}
function add_user(url){
	jQuery("#loading").html('Submiting data...');
	jQuery.post(url,{ 
					fullname : jQuery('#fullname').val(),
					username : jQuery('#username').val(),
					password : jQuery('#passwd').val(),
					id_leader : jQuery('#id_leader').val(),
					id_level : jQuery('#id_level').val(),
					post : true
				}, function(html) {
			updated(html);
		});
}


function updated(html){
$(document).ready(function() { 
        $.blockUI({ 
            message: (html), 
            timeout: 1000
        }); 
  
}); 	
}

</script>
<form action="#" method="post">
<?php
/*$user = array();
foreach($level->result() as $row){
$user[$row->id_level] = $row->level;
}
$id_level = array();
foreach($level->result() as $row){
$id_level[$row->id_level] = $row->level;
}*/
?>
<div class="content">
<div class="viewCenter">
	<!-- start of CONTENT FULL -->
	<span class="boxcontright_top"></span>
      <div class="boxcontright_box">
        <div class="inside_boxright_center">
<h2 class="tit">Add User</h2>

<table>	
	<tr>
    	<td>Fullname</td>
    	<td><input type="text" name="fullname" id="fullname" value=""/></td>
        <td></td>
    </tr>
    <tr>
    	<td>Username</td>
    	<td><input type="text" name="username" id="username" value=""/></td>
        <td></td>
    </tr>
     <tr>
    	<td>Password</td>
    	<td><input type="password" name="password" id="passwd" value=""/></td>
        <td></td>
    </tr>
    <tr>
    	<td>Re-type Password</td>
    	<td><input type="password" name="repassword" value="" id="repasswd" /></td>
        <td></td>
    </tr>
    <tr valign="middle">
    	<td valign="middle">level</td>
    	<td><select id="id_level">
        <?php foreach($level->result() as $row ){?>
        <option value="<?php echo $row->id_level?>"><?php echo $row->desc?></option>
        <?php } ?>
        </select>
</select>


 		</td>
        <td></td>
    </tr>
    <tr valign="middle">
    	<td valign="middle">Leader</td>
        <td valign="middle">
        <select id="id_leader">
<?php foreach($level->result() as $row_r ){?>
<?php $list = $this->user_model->get_leader($row_r->id_level-1,$id_user=''); ?>
<?php $a=1; foreach($list as $row_l){?>
<option class="sub_<?php echo $row_r->id_level?>" value="<?php echo $row_l->id_user?>"><?php echo $row_l->username?></option>
    <?php }?>
    <?php }?>
</select>
        </td><td><input type="button" class="but_proceed" style="margin-left:10px" onclick="checkUser('<?php echo site_url()?>admin/hdr_setup_user_cont/add_user_ajax')" /></td>
    </tr>
    
</table>

<input type="hidden" name="post" id="post" value="post" />
<input type="hidden" name="id_user" id="id_user" value="<?php echo $this->uri->segment(4)?>" />
</form>
 </div>
      </div>
      <span class="boxcontright_bot"></span> </div>
  <p class="clear"></p>
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