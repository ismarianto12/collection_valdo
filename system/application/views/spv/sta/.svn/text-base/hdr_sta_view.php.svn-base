<script>



function goSumCases(){
//loading('Please Wait');
$(document).ready(function(){
      var begindate = $('.begindate').val();
	  var enddate = $('.enddate').val();
	  //alert(filterdate);
     // reloadSumCases(begindate,enddate);
       jQuery('#flex1').flexOptions({url: '<?=site_url()?>/hdr/hdr_ajax/get_sta_track/'+begindate+'/'+enddate+'/1'}).flexReload();
    });

}
$(document).ready(function(){
 $('#listHover').columnHover({eachCell:true, hoverClass:'betterhover'}); 
});
  
function test(com,grid)
{
		 if (com=='Select All')
		{
			$('.bDiv tbody tr',grid).addClass('trSelected');
		}
		if (com=='DeSelect All')
		{
			$('.bDiv tbody tr',grid).removeClass('trSelected');
		}
		if (com=='Reject')
        { 	
           if(jQuery('.trSelected',grid).length>0){
			   var items = jQuery('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
						itemlist+= items[i].id.substr(3)+",";
					}
				<?php if($this->uri->segment(3)=='sta_rtf'){ ?>
				if(confirm('Reject this debtor ?')){
					$.ajax({
							   type: "POST",
							   url: "<?php echo site_url("spv/hdr_spv_send_to_agen_ctrl/reject_debtor_sta_rtf");?>/",
							   data: "items="+itemlist,
							   success: function(data){
								$('#flex1').flexReload();
							  Boxy.alert(data, null, {title: 'Notice'});
							   }
							});
				}
				<?php } elseif($this->uri->segment(3)=='sta') {?>
			   if(confirm('Reject this debtor ?')){
					$.ajax({
							   type: "POST",
							   url: "<?php echo site_url("spv/hdr_spv_send_to_agen_ctrl/reject_debtor_sta");?>/",
							   data: "items="+itemlist,
							   success: function(data){
								$('#flex1').flexReload();
							  Boxy.alert(data, null, {title: 'Notice'});
							   }
							});
				}
				<?php } ?>
			} 
        }
		if (com=='Export CSV')
        { 	
				  var begindate = $('.begindate').val();
				  var enddate = $('.enddate').val();
					location.href="<?php echo site_url()?>spv/hdr_spv_send_to_agen_ctrl/sta_to_csv/"+begindate+"/"+enddate+"/1";
					//+itemlist;
					//.$row_tc->id_user.'/1/'.$begindate.'/'.$enddate.'/'.$report="0".'\'
        }
		if (com=='Export RTF')
        { 	
					location.href="<?php echo site_url()?>spv/hdr_spv_send_to_agen_ctrl/rtf/";
					//+itemlist;
					//.$row_tc->id_user.'/1/'.$begindate.'/'.$enddate.'/'.$report="0".'\'
        }
} 
</script>

<div class="content">
	<!-- start of CONTENT FULL -->
	<div class="cnfull">
		<span class="boxfull_top"></span>
		<div class="boxfull_box">
			<center><h2 class="tit">&nbsp;Send To Agen</h2></center>
			<br/>
			<?php if($page =='sta'){ ?>
			<h2 class="tit">&nbsp;Filter</h2>
			<br/>
			<label class="batch" style="width:50px;">Date</label><input type="text" class="begindate" id="datepicker" size="9" value="<?=date('Y-m-d')?>"  /> to <input type="text" class="enddate" id="datepicker2"  size="9" value="<?=date('Y-m-d')?>" />&nbsp;&nbsp;&nbsp;<input type="button" value="GO / Refresh" class="but_reg" onclick="goSumCases();return false;">
			<?php  } ?>
		<br/>
			<br/>
			<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery.columnhover.pack.js"></script>
<?php echo $js_grid;?>
<div class="det" style="margin-left:29px"><table id="flex1" style="display:none"></table></div><br />
	</table>
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