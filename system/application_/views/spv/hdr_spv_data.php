
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
        $('.sum_data').load('<?= site_url() ?>spv/hdr_spv_report_ctrl/sum_data/'+begindate+'/'+enddate)	
    });
    

</script>
<div class="content">
    <!-- start of CONTENT FULL -->
    <div class="cnfull">
        <span class="boxfull_top"></span>
        <div class="boxfull_box">
        	
            <center><h2 class="tit">&nbsp;TOTAL DATA</h2></center>
            <br/>
            <br/>
            <center>
            <!--    <input type="button" class="but_reg" value="View Details" onclick="boxPopup('View Details','<?php echo site_url('spv/hdr_spv_report_ctrl/summary_details_dpd/') ?>')"/>  -->
            </center> 
           <br/>
            <br/>
            <div class="sum_data"><center><img src="<?= base_url() ?>assets/images/loader.gif" /><center></div>
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
