<link rel="stylesheet" href="<?=base_url()?>assets/css/uploadify.css" type="text/css" />
<script type="text/javascript" src="<?=base_url()?>assets/js/swfobject.js"></script>
<!--
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.uploadify.v2.1.0.min.js"></script>
-->
<script type="text/javascript" src="<?=site_url()?>assets/js/uploadify/jquery.uploadify.js"></script>
<script type="text/javascript">
function startUpload(id, conditional)
{
	if(conditional.value.length != 0) {
		$('#'+id).fileUploadStart();
	} else
		alert("You must enter your name. Before uploading");
}
</script>
<script type="text/javascript">
$(document).ready(function() {
	$("#fileUploadname").fileUpload({
		'uploader': '<?=base_url()?>assets/js/uploadify/uploader.swf',
		'cancelImg': '<?=base_url()?>assets/uploadify/cancel.png',
		'script': '/womdc/assets/upload.php',
		'folder': '/womdc/assets/upload/master/',
		'multi': true,
		'displayData': 'percentage',
		onComplete: function (evt, queueID, fileObj, response, data) {
			alert("This: "+response);
		}
	});
	$('#name_upload').bind('change', function(){
		$('#fileUploadname').fileUploadSettings('scriptData','&name_upload='+$(this).val()+'&description='+$('#description').val());
	});
	$('#description').bind('change', function(){
		$('#fileUploadname').fileUploadSettings('scriptData','&name_upload='+$('#upload_date').val()+'&description='+$(this).val());
	});
	// When setting scriptData you must enter the full parameter string. More checks need to be done in this case
	// because what you will experience is if you enter a name it will wipe location:Australia unless Australia is
	// written in the location field. The same applies visa versa, the only difference is there is an "isEmpty" check
	// on the name field.
	});
function download(){
	var begindate = $('.begindate').val();
	var enddate = $('.enddate').val();
	location.href="<?php echo site_url()?>admin/hdr_download_ctrl/download_<?=$file_type?>/"+begindate+"/"+enddate;
}
function download_active_agency(type){
	var begindate = $('.begindate').val();
	var enddate = $('.enddate').val();
	location.href="<?php echo site_url()?>admin/hdr_download_ctrl/download_active_agency/"+type+"/"+begindate+"/"+enddate;
}
function download_monitor_agen(type){
	var begindate = $('.begindate').val();
	var enddate = $('.enddate').val();
	location.href="<?php echo site_url()?>admin/hdr_download_ctrl/download_monitor_agen/"+type+"/"+begindate+"/"+enddate;
}
function download_all(){
	location.href="<?php echo site_url()?>admin/hdr_download_ctrl/download_<?=$file_type?>/";
}
</script>
<?php
			$date_filter = '<label class="batch" style="width:50px;">Date</label><input type="text" class="begindate" id="datepicker" size="9" value="'.date("Y-m-d").'"  /> to <input type="text" class="enddate" id="datepicker2"  size="9" value="'.date("Y-m-d").'" />&nbsp;&nbsp;&nbsp;';
			$download_type = $file_type;
            switch($download_type) {
			case "master":
			$download_for = "";
				break;
            case "monitor_agen":
                    $download_for = $date_filter.'<input type="button" value="Download by TGL Input" class="but_reg" onclick="download_monitor_agen(\'tgl_input\');return false;">&nbsp;&nbsp;<input type="button" value="Download by Visit Date" class="but_reg" onclick="download_monitor_agen(\'visit_date\');return false;">';
                    break;
            case "reschedule":
                    $download_for =  '<input type="button" value="Download" class="but_reg" onclick="download_all();return false;">';
                    break;
            case "call_track":
					$download_for = $date_filter.'<input type="button" value="Download" class="but_reg" onclick="download();return false;">';
                    $download_for .= "<p>Untuk Download Calltrack sebelum 04-Mar-2010 pengaturan tanggal batas akhir (to) harus diset tanggal 04-Mar-2010 </p>";
                    break;
            case "active_agency":
                    $download_for = $date_filter.'<input type="button" value="Download Tgl Serah" class="but_reg" onclick="download_active_agency(\'tgl_serah\');return false;">&nbsp;&nbsp;<input type="button" value="Download  Tgl Tarik" class="but_reg" onclick="download_active_agency(\'tgl_tarik\');return false;">&nbsp;&nbsp;<input type="button" value="Download  ALL" class="but_reg" onclick="download_active_agency(\'all\');return false;">';
                    break;
            default:
                     $download_for = $date_filter.'<input type="button" value="Download" class="but_reg" onclick="download();return false;">';
            }

?>
	 
        <div id="content">
			
            <h2><span></span>Upload Foto Baru&nbsp;</h2>
            
            <p>Silahkan Pilih gambar / Foto yg akan di upload</p>
            <table>
            <tr><td><strong>Name:  </strong></td>
				<!-- Adding the value="John Doe" does not update the scriptData. It purley gives startUpload() something to pass in the conditional,
				and if the user deletes the name it will still trigger the alert -->
            <td><input type="text" id="datepicker3" name="upload_date"  class="upload_date" size="15"/></td></tr><input type="hidden" id="name_upload" value="haidate" class="name_upload"/>
             <tr>
             <td><strong>Ketarangan:</strong> </td>
         <td><textarea name="description" id="description" cols="20" rows="10"></textarea></td>
         </table>
            <p><div id="fileUploadname">You have a problem with your javascript</div></tr>
		<a href="javascript:startUpload('fileUploadname', document.getElementById('name_upload'))">Start Upload</a> |  <a href="javascript:$('#fileUploadname').fileUploadClearQueue()">Clear Queue</a></p>
         
        </div> <!-- /col-text -->
    
    </div> <!-- /col -->
    </div>
