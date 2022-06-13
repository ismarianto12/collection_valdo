<link rel="stylesheet" href="<?=base_url()?>assets/css/uploadify.css" type="text/css" />
<script type="text/javascript" src="<?=base_url()?>assets/js/swfobject.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript">
function startUpload(id, conditional)
{
	if(conditional.value.length != 0) {
		$('#'+id).uploadifyUpload();
	} else
		alert("You must enter your Subject. Before uploading");
}
function reloadPage(){
	location.reload();	
}
</script>
<script type="text/javascript">
 var allDialogs = [];
  var seq = 0;
  function create(options) {
  //alert(seq);
  if(seq == '0'){
  options = $.extend({title: "Dialog"}, options || {});
  var dialog = new Boxy("<div><p>This is dialog " + (++seq) + ". <a href='index.html#' onclick='Boxy.get(this).hide(); return false'>Close me!</a></p></div>", options);
  allDialogs.push(dialog);
  return false;
  }
  } 
  function recent() { return allDialogs[allDialogs.length-1]; }
  function tweenUp() { recent().tween(400,400); }
  function tweenDown() { recent().tween(100,100); }
  function getTitle() { alert(recent().getTitle()); }
  function setTitle() { recent().setTitle(prompt("Enter new title:")); }
  
function pl_wait(html){
$(document).ready(function() { 
        $.blockUI({ 
            message: '<h1><img src="<?=base_url()?>assets/images/busy.gif" />  '+(html)+'</h1>'
        }); 
  
}); 
}
$(document).ready(function() {
	$("#uploadify").uploadify({
		'cancelImg': '<?=base_url()?>assets/images/cancel.png',
		'multi': false,
		'folder'         : 'admin-<?=$file_type?>',
		'displayData': 'percentage',
		onProgress: function (evt, queueID, fileObj, data) {
                   
					if(data.percentage == '100'){
							 pl_wait('Loading please wait...'+ data.speed);
					}
             },
			 onCancel: function (evt, queueID, fileObj, data) {
                    $('input,textarea').removeAttr("disabled");
                    $('#upload_status').html("");
             },
		onComplete: function (evt, queueID, fileObj, response, data) {
			jQuery.unblockUI();
			set_berhasil(response);
			//reloadPage();
		}
		
	});
	$('#subject').bind('change', function(){
		$('#uploadify').uploadifySettings('scriptData','&subject='+$(this).val()+'&description='+$('#description').val());
	});
	$('#description').bind('change', function(){
		$('#uploadify').uploadifySettings('scriptData','&subject='+$('#subject').val()+'&description='+$(this).val());
	});
	});
</script>
<div class="content">
	<!-- start of CONTENT FULL -->
	<div class="cnfull">
		<span class="boxfull_top"></span>
		<div class="boxfull_box">
		<?php $upload_title = str_replace('_',' ',strtoupper($file_type));?>
		<h1>Upload <?=$upload_title?></h1>
		<br>
		<br>
<form action="#" method="post">
<table>
    <tr>
      <td valign="top" class="upload">Description<div id="upload_status">status</div></td>
      <td align="left" class="upload"><textarea name="description" id="description" cols="40" rows="8"></textarea></td>
      <td align="left" class="upload">Correct Header File<textarea name="header_file" id="header_file" readonly="true" cols="50" rows="15"><?=$header_file->field_name?></textarea></td>
    </tr>
    <tr>
      <td valign="top" class="upload">Upload</td>
      <td align="left" class="upload"><div id="uploadify">You have a problem with your javascript</div></td>
      <td align="left" class="upload">&nbsp;</td>
    </tr>
  </table>
  <br>
		<br>
  <input type="button" style=" background:url(<?=base_url()?>assets/images/but_upload.png)  no-repeat; cursor:pointer; no-repeat; border:none; width:93px; height:34px;" onclick="javascript:startUpload('uploadify', document.getElementById('subject'))"><a href="javascript:$('#uploadify').uploadifyClearQueue()"><input type="button" value=""  style=" background:url(<?=base_url()?>assets/images/but_delete.png)  no-repeat; cursor:pointer; no-repeat; border:none; width:93px; height:34px;"  /></a>
  <input type="button" value=""  onclick='jQuery.unblockUI();return false;' style=" background:url(<?=base_url()?>assets/images/but_cancel.png)  no-repeat; cursor:pointer; border:none; width:93px; height:34px;" />
  <input type="hidden" id="subject" name="subject" value="1" />
</form>
		</div>
		<span class="boxfull_bot"></span>
	</div>
	<!-- end of CONTENT FULL -->
</div>