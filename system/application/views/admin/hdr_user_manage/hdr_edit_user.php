<script>
function update_user(url){
	jQuery("#loading").html('Submiting data...');
	jQuery.post(url,{ 
					fullname : jQuery('#fullname').val(),
					id_user : jQuery('#id_user').val(),
					id_leader : jQuery('#id_leader').val(),
					blocked : jQuery('#blocked').val(),
					post : true
				}, function(html) {
			updated(html);
			
		});
}
function update_user_pass(url){
	jQuery("#loading").html('Submiting data...');
	jQuery.post(url,{ 
					fullname : jQuery('#fullname').val(),
					id_user : jQuery('#id_user').val(),
					passwd : jQuery('#passwd').val(),
					repasswd : jQuery('#repasswd').val(),
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
$id_level = array();
foreach($level->result() as $row){
$id_level[$row->id_level] = $row->level;
}
$user = array();
foreach($list_user->result() as $row){
$user[$row->id_user] = $row->fullname;	
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
<div class="tabs">
	<b style="cursor:pointer"><img src="<?php echo base_url() ?>assets/images/ico_individu.png" />&nbsp;&nbsp;User Profile</b>&nbsp;&nbsp;&nbsp;
    <b style="cursor:pointer"><img src="<?php echo base_url() ?>assets/images/ico_individu_pass.png" />&nbsp;&nbsp;Change Password</b>
	
</div>
<p class="space"></p>

<div class="panes">

<div>
<table>
	<tr>
    	<td>Fullname</td>
    	<td><input type="text" name="fullname" id="fullname" value="<?php echo $get_user->fullname?>"/></td>
    </tr>
    
     <?php $id_level = $get_user->id_level; if($id_level!='1'):?>
    <tr> 
    	<td>Leader</td>
       
    	<td id="subjectdiv"><select name="id_leader" id="id_leader">
        
        <?php 
		if($id_level=='2'){
				$list = $this->user_model->get_spv_leader($id_user='');
					if(!empty($list)){
						$data ='<option value="1">admin</option>';	
						echo $data;
			}	
		}elseif($id_level =='3'){
		?>
            <?php $list = $this->user_model->get_spv_leader($get_user->id_user); ?>
            <?php foreach($list as $row){?>
			<option value="<?php echo $row->id_user?>"><?php echo $row->fullname?></option>
			<?php } } ?>
			</select>
            
        </td>
    </tr>
    <tr>
    	<td valign="top">Status</td>
        <td><select name="blocked" id="blocked">
        	<option value="0">Unblocked</option>
            <option value="1">Blocked</option>
            </select>
            <?php endif;?>
            
        </td>
    </tr>
    <tr>
      <td valign="bottom">&nbsp;</td>
      <td  height="50px" ><input type="button" class="but_sp"  value="CANCEL" onclick="location.href='<?php echo site_url('admin/hdr_setup_user_cont/user')?>'" id="password"/>
            <input type="button" class="but_proceed"  onclick="update_user('<?php echo site_url('admin/hdr_setup_user_cont/edit_user_ajax')?>')" id="password"/></td>
    </tr>
    
</table>
<input type="hidden" name="post" id="post" value="post" />
</form><br>
</div>
<div>

<form action="<?=site_url()?>admin/hdr_setup_user_cont/edit_pass/" method="post">
<table>
<tr>
    	<td>New Password</td>
    	<td><input type="password" name="passwd" value="" id="passwd"/></td>
    </tr>
    <tr>
    	<td>Re-type Password</td>
    	<td><input type="password" name="repasswd" value="" id="repasswd" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td height="50px"><input type="button" class="but_sp"  value="CANCEL"  onclick="location.href='<?php echo site_url('admin/hdr_setup_user_cont/user')?>'" /><input type="button" class="but_proceed"  onclick="update_user_pass('<?php echo site_url('admin/hdr_setup_user_cont/edit_pass')?>')" />        </td>
    </tr>
</table>
<input type="hidden" name="post" id="post" value="post" />
<input type="hidden" name="fullname" id="fullname" value="<?php echo $get_user->fullname?>" />
<input type="hidden" name="id_user" id="id_user" value="<?php echo $get_user->id_user?>" />
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