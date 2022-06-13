<script>
function update_user(url){
	jQuery("#loading").html('Submiting data...');
	jQuery.post(url,{
					fullname : jQuery('#fullname').val(),
					id_user : jQuery('#id_user').val(),
					post : true
				}, function(html) {
			telli(html);

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
			telli(html);
		});
}
function update_phone_pass(url){
	jQuery("#loading").html('Submiting data...');
	jQuery.post(url,{
					id_user : jQuery('#id_user').val(),
					phone_pass : jQuery('#phone_pass').val(),
					post : true
				}, function(html) {
			telli(html);
		});
}
function update_local_no(url){
	jQuery("#loading").html('Submiting data...');
	jQuery.post(url,{
					id_user : jQuery('#id_user').val(),
					local_no : jQuery('#local_no').val(),
					post : true
				}, function(html) {
			telli(html);
		});
}

</script> 

<script type="text/javascript">
	function confirmation(url,txt){

		if(confirm(txt)){
			location.href=url;
		}
		return false;
	}
</script> 
<div class="cnfull"> <span class="boxfull_top"></span> 
  <div class="boxfull_box"> 
    <form action="#" method="post">
    <script src="<?php echo base_url()?>assets/js/jquery.tools.tabs-1.0.4.min.js"type="text/javascript"></script> 
    <link href="<?php echo base_url()?>assets/css/tabs.css" rel="stylesheet"   type="text/css" />
    <script type="text/javascript">
		// perform JavaScript after the document is scriptable.
		$(function() {
			// setup ul.tabs to work as tabs for each div directly under div.panes
			$("div.tabs").tabs("div.panes > div");
		});
    </script> 
    <div class="user_info" style=" margin:0px auto;height:auto;width:600px;"> 
      <h2 class="tit">User Setting</h2> 
	  <br/>
	  <br/>
      <div id="add_user" style=" margin:0px auto;height:auto; width:650px;"> 
        <div class="tabs"> <b style="cursor:pointer"><img src="<?php echo base_url() ?>assets/images/ico_individu.png" />&nbsp;&nbsp;User
          Profile</b>&nbsp;&nbsp;&nbsp; <b style="cursor:pointer"><img src="<?php echo base_url() ?>assets/images/ico_individu_pass.png" />&nbsp;&nbsp;Change  Password</b> <b style="cursor:pointer"><img src="<?php echo base_url() ?>assets/images/ico_individu_pass.png" />&nbsp;&nbsp;Change  PhonePassword</b> <b style="cursor:pointer"><img src="<?php echo base_url() ?>assets/images/ico_individu_pass.png" />&nbsp;&nbsp;Set Local Number</b>
        </div>

        <p class="space"></p>
        <div class="panes"> 
          <div> 
            <table>
              <tr>
                <td>Fullname</td>
                <td><input id="fullname" name="fullname" type="text" value="<?php echo $user_setting->fullname?>" /></td>
              </tr>
           
              <tr>
                <td valign="bottom">&nbsp;</td>
                <td height="50px"><input class="but_sp" id="password" onclick="location.href='<?php echo site_url('user/hdr_contact_cont/contact')?>'"type="button" value="CANCEL" /> 
                  <input class="but_proceed" id="password" onclick="update_user('<?php echo site_url('user/hdr_user_setting_cont/edit_user_ajax')?>')" type="button" /></td>
              </tr>
            </table>
            <input id="post" name="post" type="hidden" value="post" /> 
           
            <br> 
          </div>
          <div> 
            <table>
              <tr>
                <td>New Password</td>
                <td><input id="passwd" name="passwd" type="password" value="" /></td>
              </tr>
              <tr>
                <td>Re-type Password</td>
                <td><input id="repasswd" name="repasswd" type="password"
                           value="" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td height="50px"><input class="but_sp" onclick="location.href='<?php echo site_url('user/hdr_contact_cont/contact')?>'" type="button" value="CANCEL" /><input class="but_proceed"  onclick="update_user_pass('<?php echo site_url('user/hdr_user_setting_cont/edit_pass')?>')"  type="button" />
                  
                </td>
              </tr>
            </table>
            <input id="post" name="post" type="hidden" value="post" /> 
          </div>
		   <div> 
            <table>
              <tr>
                <td>New Phone Password</td>
                <td><input id="phone_pass" name="phone_pass" type="text" value="" /></td>
              </tr>
             
              <tr>
                <td>&nbsp;</td>
                <td height="50px"><input class="but_sp" onclick="location.href='<?php echo site_url('user/hdr_contact_cont/contact')?>'" type="button" value="CANCEL" /><input class="but_proceed"  onclick="update_phone_pass('<?php echo site_url('user/hdr_user_setting_cont/edit_phone_pass')?>')"  type="button" />
                  
                </td>
              </tr>
            </table>
            <input id="post" name="post" type="hidden" value="post" /> 
          </div>
		    <div> 
            <table>
              <tr>
                <td>Set Local Number</td>
                <td><input id="local_no" name="local_no" type="text" value="<?=$_SESSION['local_no']?>" size="5" /> &nbsp;&nbsp;example for jakarta is 021</td>
              </tr>
             
              <tr>
                <td>&nbsp;</td>
                <td height="50px"><input class="but_sp" onclick="location.href='<?php echo site_url('user/hdr_contact_cont/contact')?>'" type="button" value="CANCEL" /><input class="but_proceed"  onclick="update_local_no('<?php echo site_url('user/hdr_user_setting_cont/edit_local_no')?>')"  type="button" />
                  
                </td>
              </tr>
            </table>
            <input id="post" name="post" type="hidden" value="post" /> 
          </div>
        </div>
      </div>
    </div>
	 </form>
  </div><span class="boxfull_bot"></span> 
</div>

