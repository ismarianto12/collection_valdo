<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<title>Valdo Inc | Wallboard</title>
<link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>component/images/favicon.ico">
<script type="text/javascript" src="<?php echo base_url() ?>/component/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/component/js/jquery.price_format.2.0.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/component/jquery/jquery.json-2.3.min.js"></script>
<script src="<?php echo base_url()?>component/js/jquery.blockUI.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>component/js/hdr_ajax.js" type="text/javascript"></script>
<script language="javascript" src="<?php echo base_url() ?>/component/jquery/boxy/src/javascripts/jquery.boxy.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>/component/script/function.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/component/js/themes/base/ui.all.css"/>
<script type="text/javascript" src="<?php echo base_url() ?>/component/js/ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/component/js/ui.datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>/component/css/style.css" type="text/css" media="screen" title="style" charset="utf-8" />
<style>
 #fkiri, #fkanan {
    width:100%; height: 100%; overflow:auto; background-color: #FFD;
 }
 #fkanan { overflow: hidden; }
 .th_head th {
    background-color: Gray; color: #FFF; font-family: Callibri; font-weight: Bold; border:3px solid DarkGray; font-size:1.2em;
 }
 .th_prehead { text-align: center; font-family: Callibri; border:3px solid DarkGray; font-weight: Bold; font-size:1.5em; }
 .idle { background-color: rgba(152, 251, 152, 0.2); }
 .oncall { background-color: rgba(255, 165, 20, 0.2); }
 .striped { border-bottom: 1px solid LightGray; font-family: Callibri; }
 .bold { font-weight: bold; font-size: 2em; }
 .loginol { font-weight: bold; font-size: 1em; color: red; text-transform: uppercase;}
 .centerize { text-align: center; }
 .ratio_bar { font-weight: bold; font-size: 1.8em; text-align: center; height: 40px; background: LightSkyBlue; border-radius: 5px 40px 40px 5px; box-shadow: 5px 0px 2px LightBlue; margin-bottom: 10px; color: #000; text-shadow: 3px 1px 3px WhiteSmoke; font-family: "Trabuchet MS" }
 .ratio_bar2 { font-weight: bold; font-size: 1.8em; text-align: center; height: 40px; background: LightCoral; border-radius: 5px 40px 40px 5px; box-shadow: 5px 0px 2px Maroon; margin-bottom: 10px; color: #000; text-shadow: 3px 1px 3px WhiteSmoke; font-family: "Trabuchet MS" }
 .xdate { color: #FFF; font-weight: Bold; font-size: 1.3em; background-color: LightCoral; padding: 8px; border-radius: 5px; font-family: Dotum; }
 td { padding: 0px; padding-left: 5px; padding-right: 5px; }
</style>


</head>

<div id="wrap_header">
 <div class="header">
  <span class="logo"><a href="#"><img src="" alt="" /></a></span>
  <span class="tele"><img src="<?php echo base_url(); ?>/component/images/telesys-logo_.png" alt="" /></span>
  <div class="user">
   <span class="xdate"><img src="<?=base_url();?>/component/images/talktime.gif" alt="clock" height="16" /> <?=date('D, d-M Y');?> &nbsp <span id="xdate"></span></span>
  </div>
 </div>
</div>

<div style="width:100%; height:95%; border: 0px solid red;">
 <table style="width:100%; height:95%;">
  <tr>
    <td width="60%">
        <div id="fkiri">
         <center><img src="<?=base_url()?>component/images/loader.gif" alt="loader" /></center>
        </div>
    </td>
    <td class="kanan">
        <div id="fkanan">
         <center><img src="<?=base_url()?>component/images/loader.gif" alt="loader" /></center>
        </div>
    </td>
  </tr> 
 </table>
</div>

<script>
$(document).ready(function(){
    //alert();
    $('.kanan').hide();
    load_fkiri();
    //load_fkanan();
   // auto_refresh();
    
    setInterval(function(){setTime()}, 1000);
    
    function setTime(){
      var d = new Date();
      $('#xdate').html(d.toLocaleTimeString());
    }
});

function load_fkiri(){
    xurl = "<?=site_url();?>wallboard/getajax_sipmonitoring";
    $.ajax({
        url: xurl,
        type: "POST",
        success: function(resp){
            $('#fkiri').html(resp);
        }
    });
}

function load_fkanan(){
    xurl = "<?=site_url();?>wallboard/getajax_usertier";
    $.ajax({
        url: xurl,
        type: "POST",
        success: function(resp){
            $('#fkanan').html(resp);
        }
    });
    
    setTimeout(function(){
        load_fkanan();
    }, 60000);
}

function auto_refresh(){
    setTimeout(function(){
        location.reload();
    }, 900000);
}
</script>