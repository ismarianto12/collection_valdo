<link rel="stylesheet" href="<?= base_url() ?>assets/css/uploadify.css" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/swfobject.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.uploadify.v2.1.4.min.js"></script>
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
                message: '<h1><img src="<?= base_url() ?>assets/images/busy.gif" />  '+(html)+'</h1>'
            });
  
        });
    }
    $(document).ready(function() {
        $("#uploadify").uploadify({
            uploader : '<?php echo base_url(); ?>assets/swf/uploadify.swf',
            cancelImg: '<?= base_url() ?>assets/images/cancel.png',
            script: '<?php echo site_url(); ?>admin/hdr_upload_cont/uploading',
            multi: false,
            //folder         : '/uploads',
            displayData: 'percentage',
            scriptAccess: 'always',
            method: 'POST',
            'scriptData': {'types':'<?= $file_type ?>'},
            'onError' : function (a, b, c, d) {
                if (d.status == 404)
                    alert('Could not find upload script.');
                else if (d.type === "HTTP")
                    alert('error '+d.type+": "+d.status);
                else if (d.type ==="File Size")
                    alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
                else
                    alert('error '+d.type+": "+d.text);
            },
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
               /* $.post('<?= site_url(); ?>/admin/hdr_upload_cont/uploadify',{filearray: response},function(info){
                    //$("#target").append(info);  //Add response returned by controller
                    set_berhasil(info);
                });*/
                set_berhasil(response);
                //reloadPage();
            }
            
		
        });
       
    });
    function download(){
        var begindate = $('.begindate').val();
        var enddate = $('.enddate').val();
        location.href="<?php echo site_url() ?>admin/hdr_download_ctrl/download_<?= $file_type ?>/"+begindate+"/"+enddate;
    }
    
    function cleanup_data()
    {
			var cf = confirm("Are you sure want truncate data?");
			if(cf)
			{
				boxPopup('Truncate Data','<?php echo base_url()?>index.php/admin/hdr_upload_cont/set_truncate');
				return false;
			}
			else
				return false;
    }
    
    function download_active_agency(type){
        var begindate = $('.begindate').val();
        var enddate = $('.enddate').val();
        location.href="<?php echo site_url() ?>admin/hdr_download_ctrl/download_active_agency/"+type+"/"+begindate+"/"+enddate;
    }
    function download_monitor_agen(type){
        var begindate = $('.begindate').val();
        var enddate = $('.enddate').val();
        location.href="<?php echo site_url() ?>admin/hdr_download_ctrl/download_monitor_agen/"+type+"/"+begindate+"/"+enddate;
    }
    function download_all(){
        location.href="<?php echo site_url() ?>admin/hdr_download_ctrl/download_<?= $file_type ?>/";
    }
    function downloadDataCount(){
    	goUrl = '<?php echo base_url()?>index.php/admin/hdr_upload_cont/dataCountDownload/';
    	location.href= goUrl;
    }
</script>
<?php
$date_filter = '<label class="batch" style="width:50px; display:none;">Date</label><input type="hidden" class="begindate"  size="9" value="' . date("Y-m-d") . '"  />  <input type="hidden" class="enddate"   size="9" value="' . date("Y-m-d") . '" />&nbsp;&nbsp;&nbsp;';
$download_type = $file_type;
switch ($download_type) {
    case "master":
        $download_for = "";
        break;
    case "dpd_minus":
        $download_for = "";
        break;
    case "action_code":
        $download_for = '';
        break;
    case "reschedule":
        //$download_for = '<input type="button" value="Download" class="but_reg" onclick="download_all();return false;">';
        break;
    case "call_track":
        //echo 'calltrack';
        //$download_for = $date_filter . '<input type="button" value="Download" class="but_reg" onclick="download();return false;">';
        //$download_for .= "<p>Untuk Download Calltrack sebelum 04-Mar-2010 pengaturan tanggal batas akhir (to) harus diset tanggal 04-Mar-2010 </p>";
        break;
    case "active_agency":
        $download_for = $date_filter . '<input type="button" value="Download Tgl Serah" class="but_reg" onclick="download_active_agency(\'tgl_serah\');return false;">&nbsp;&nbsp;<input type="button" value="Download  Tgl Tarik" class="but_reg" onclick="download_active_agency(\'tgl_tarik\');return false;">&nbsp;&nbsp;<input type="button" value="Download  ALL" class="but_reg" onclick="download_active_agency(\'all\');return false;">';
        break;
    default:
        $download_for = $date_filter . '<input type="hidden" value="Download" class="but_reg" onclick="download();return false;">';
}
?>
<div class="content">
    <!-- start of CONTENT FULL -->
    <div class="cnfull">
        <span class="boxfull_top"></span>
        <div class="boxfull_box">
            <?php $upload_title = str_replace('_', ' ', strtoupper($file_type)); ?>
            <h1>Upload <?= $upload_title ?></h1>
            <br>
            <br>
            <h2 class="tit"><?php if($file_type!='dpd_minus') { ?>&nbsp;Filter <input type="button" class="but_reg" value="View Details" onclick="boxPopup('View Details','<?php echo site_url('admin/hdr_upload_cont/summary_details_dpd/') ?>')"/><?php } ?>
            	<input type="button" class="but_reg" value="Data Count" onclick="downloadDataCount()"/>
            	</h2></center>
            <br/>
            
            <br/>
							<strong>Petunjuk Upload Data</strong><br/>
								Step 1. Truncate Data, ini di lakukan hanya sekali saja (JIKA UPLOAD PAYMENT ABAIKAN STEP INI).<br/>
								Step 2. Select Files.<br/>
								Step 3. Proses Upload.<br/>
								Step 4. View Details untuk melihat hasil Upload.<br/>

            <?php echo  $download_for ?>
            <br/>
            <form action="<?= site_url() ?>hdr_upload_cont/uploading" method="post">
                <table>
                    <tr>
                        <td valign="center" class="upload">Description<div id="upload_status">status</div></td>
                        <td valign="bottom" align="left" class="upload"><textarea name="description" id="description" cols="40" rows="8"></textarea></td>
                        <td align="left" class="upload">Correct Header File<textarea name="header_file" id="header_file" readonly="true" cols="50" rows="15"><?= $header_file->field_name ?></textarea></td>
                    </tr>
                    <tr>
                        <td valign="top" class="upload">Upload</td>
                        <td align="left" class="upload"><div id="uploadify">You have a problem with your javascript</div></td>
                        <td align="left" class="upload">&nbsp;</td>
                    </tr>
                </table>
                <br>
                <br>
											<!-- Truncate Data-->
											<input onclick="javascript:cleanup_data()" type="button" name="cleanup" value="<<TRUNCATE DATA>>" style="border: 1px solid gray; height=50px; padding=10px;" />
					
                <input type="button" style=" background:url(<?= base_url() ?>assets/images/but_upload.png)  no-repeat; cursor:pointer; no-repeat; border:none; width:93px; height:34px;" onclick="javascript:startUpload('uploadify', document.getElementById('subject'))"><a href="javascript:$('#uploadify').uploadifyClearQueue()"><input type="button" value=""  style=" background:url(<?= base_url() ?>assets/images/but_delete.png)  no-repeat; cursor:pointer; no-repeat; border:none; width:93px; height:34px;"  /></a>
                <input type="button" onclick='jQuery.unblockUI();return false;' style=" background:url(<?= base_url() ?>assets/images/but_cancel.png)  no-repeat; cursor:pointer; border:none; width:93px; height:34px;" />
                <input type="hidden" id="subject" name="subject" value="1" />
            </form>
        </div>
        <span class="boxfull_bot"></span>
    </div>
    <!-- end of CONTENT FULL -->
</div>
