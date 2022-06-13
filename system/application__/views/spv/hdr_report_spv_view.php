
<script>
     function Repair(url){
        //notif.hide();
        loading('<h2>Repairing Data Please wait...<br/></h2>');
        jQuery.get(url,{
        }, function(html) {
            telli(html);
        });
    }
    $(document).ready(function() {
        var begindate = '<?= date('Y-m-d') ?>';
        var enddate = '<?= date('Y-m-d') ?>';
        // $("#responsecontainer").load("response.php");
  
    });

    $(document).ready(function(){
        var begindate = $('.begindate').val();
        var enddate = $('.enddate').val();
        $('.sum_report').load('<?= site_url() ?>spv/hdr_spv_report_ctrl/sum_report/'+begindate+'/'+enddate)	
    });
    

	
    function reloadSumCases(begindate,enddate){
        //notif.hide();
        $(document).ready(function(){
            $('.sum_report').load('<?= site_url() ?>spv/hdr_spv_report_ctrl/sum_report/'+begindate+'/'+enddate)	
        });	
    }
    function goSumCases(){
    	var url = '<?php echo base_url() ?>assets/images/loader.gif';
        loading('<img src="'+url+'"></br>Please Wait...<br/>if take more than 180 sec press F5');
        $(document).ready(function(){
            var begindate = $('.begindate').val();
            var enddate = $('.enddate').val();
            //alert(filterdate);
            reloadSumCases(begindate,enddate);
        });

    }
    
    function dataskipDownload(){
	var flag = $("#flag").val();
//alert(flag);die();
    	url = '<?php echo site_url() ?>spv/hdr_spv_report_ctrl/get_dataskip/'+flag;
    	window.location = url;
    } 

    function dialyTeam(){
    	url = '<?php echo site_url() ?>spv/hdr_spv_report_ctrl/get_spvDialyWork';
    	window.location = url;
    }
    
    function get_full_report(){
	var begindate =  $('.begindate').val();
    	var location = "<?php echo site_url(); ?>spv/hdr_spv_report_ctrl/get_full_report/"+begindate;
    	//alert(location);
    	//return;
    	this.location.href = location;
    }

    function result_handling(){
	var begindate =  $('.begindate').val();
    	var enddate =  $('.enddate').val();
    	
    	var location = '<?php echo site_url(); ?>spv/hdr_spv_report_ctrl/get_handling/'+begindate+'/'+enddate;    	//alert(location);
    	//return;
    	this.location.href = location;
    }

</script>
<div class="content">
    <!-- start of CONTENT FULL -->
    <div class="cnfull">
        <span class="boxfull_top"></span>
        <div class="boxfull_box">
        	
            <center><h2 class="tit">&nbsp;CALL TRACK REPORT</h2></center>
            <br/>
            <br/>
            <center>
            <!--    <input type="button" class="but_reg" value="View Details" onclick="boxPopup('View Details','<?php echo site_url('spv/hdr_spv_report_ctrl/summary_details_dpd/') ?>')"/>  -->
            </center> 
            <br/>   
            <center>
            <input type="button" class="but_reg" value="Repair" onclick="Repair('<?php echo site_url('spv/hdr_spv_report_ctrl/repair/') ?>')"/>
	    <input type="button" class="but_reg" value="Skip Data Download" onclick="dataskipDownload()"/>
	    <input type="button" class="but_reg" value="Dialy Team Work" onclick="dialyTeam()"/>
			<br />
	    <select name="flag" id="flag">
	    	<option value="0" selected>All</option>
		    <option value="1">Nomor 0 (Kosong)</option>
		    <option value="2">Tlp Alphabet</option>
		    <option value="3">Kurang 5 digit</option>
		    <option value="6">Payment</option>
		    <option value="7">Active On</option>
	    </select>
	   </center>

            <h2 class="tit">&nbsp;Filter</h2>
            <br/>
            <label class="batch" style="width:50px;">Date</label><input type="text" class="begindate" id="datepicker" size="9" value="<?= date('Y-m-d') ?>"  /> to <input type="text" class="enddate" id="datepicker2"  size="9" value="<?= date('Y-m-d') ?>" />&nbsp;&nbsp;&nbsp;<input type="button" value="GO / Refresh" class="but_reg" onclick="goSumCases();return false;">&nbsp;&nbsp;&nbsp;<input type="button" value="FULL REPORT" class="but_reg" onclick="get_full_report()">&nbsp;&nbsp;&nbsp;<input type="button" value="RESULT HANDLING" class="but_reg" onclick="result_handling()">
            <br/>
            <br/>
            <div class="sum_report"><center><img src="<?= base_url() ?>assets/images/loader.gif" /><center></div>
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
