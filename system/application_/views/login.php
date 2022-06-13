<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<title>Debt Collection Management | Login</title>
<script type="text/javascript" src="<?php echo base_url()?>assets/pngfix/iepngfix_tilebg.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/boxy.css" type="text/css"  />
<?php if (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 8") || strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 6.0")) { ?>
<script src="<?php echo base_url() ?>assets/js/jquery-1.3.2.min.js"></script>
<?php } else {?>
<script src="<?php echo base_url() ?>assets/js/jquery-1.4.min.js"></script>
<?php } ?>
<script language="javascript" src="<?php echo base_url() ?>assets/js/jquery.boxy.js" type="text/javascript"></script>
<style type="text/css">
img, div, ul, input, a, span {
behavior: url(<?php echo base_url() ?>/assets/pngfix/iepngfix.htc)
}
</style>
<script>
function loginx(url){
	jQuery.post(url,{ 
				  username : jQuery('#username').val(),
				  password : jQuery('#password').val(),
				  post : jQuery('#post').val(),
				  post : true
			  }, function(html) {
		 showPopUp('Confirmation','<div style="width:250px"><center>'+html+'</center></div>','Cancel [x]');
		});
	
}

function showPopUp(tit,html,cls){
	
	notif = new Boxy(html, {
                title:tit,modal: false,unloadOnHide:true,closeText:cls
              });
	notif.show();
}
</script>
</head>
<body class="login">

<form method="post" action="#">
  <div id="login_wrap">
    <center>
      <a href="#"> <img src="<?=base_url()?>/assets/images/logo.png"  /></a> 
    </center>
     
    <div class="login_box">
      <dl class="login">
        <dt class="autoheight">
          <label class="lblogin">User Name</label>
          <input type="text" id="username" name="username" class="txtlogin" />
        </dt>
        <dt class="autoheight">
          <label class="lblogin">Password</label>
          <input type="password" id="password" name="password" class="txtlogin" />
        </dt>
        <dt class="autoheight">
          <label class="lblogin">&nbsp;</label>
          <input type="submit" class="but_sublogin" value="" onclick="loginx('<?php echo site_url()?>login/logg');return false" />
        </dt>
      </dl>
    </div>
  </div>
  <input type="hidden" id="post" name="post" value="post" />
</form>
    <script type="text/javascript">
// <![CDATA[
function PMA_focusInput()
{
    var input_username = document.getElementById('username');
    var input_password = document.getElementById('password');
    if (input_username.value == '') {
        input_username.focus();
    } else {
        input_password.focus();
    }
}

window.setTimeout('PMA_focusInput()', 500);
// ]]>
</script>

</body>
</html>
