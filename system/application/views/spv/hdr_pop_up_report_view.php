<script>
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
		if (com=='Export')
        { 	
           if(jQuery('.trSelected',grid).length>0){
			   var items = jQuery('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
						itemlist+= items[i].id.substr(3);
					}
			   if(confirm('Export this debtor ?')){
					data: "items="+itemlist,
					location.href="<?php echo site_url()?>spv/hdr_spv_report_ctrl/report_to_csv/<?=$id_user?>/<?=$status?>/<?=$begindate?>/<?=$enddate?>/1";
					//+itemlist;
					//.$row_tc->id_user.'/1/'.$begindate.'/'.$enddate.'/'.$report="0".'\'
				}
			} 
        }
		if (com=='Export All')
        { 	
					location.href="<?php echo site_url()?>spv/hdr_spv_report_ctrl/report_to_csv/<?=$id_user?>/<?=$status?>/<?=$begindate?>/<?=$enddate?>/1";
					//+itemlist;
					//.$row_tc->id_user.'/1/'.$begindate.'/'.$enddate.'/'.$report="0".'\'
			
			
        }
        
        if (com=='Export All SPV')
        { 	
					location.href="<?php echo site_url()?>spv/hdr_spv_report_ctrl/report_to_csv_spv/<?=$id_user?>/<?=$status?>/<?=$begindate?>/<?=$enddate?>/1";
					//+itemlist;
					//.$row_tc->id_user.'/1/'.$begindate.'/'.$enddate.'/'.$report="0".'\'
				
        }
        
        if (com=='Export All ADM')
        { 	
					location.href="<?php echo site_url()?>spv/hdr_spv_report_ctrl/report_to_csv_adm/<?=$id_user?>/<?=$status?>/<?=$begindate?>/<?=$enddate?>/1";
					//+itemlist;
					//.$row_tc->id_user.'/1/'.$begindate.'/'.$enddate.'/'.$report="0".'\'
				
        }
} 
</script>
<a href="#"><img src="<?=base_url()?>assets/images/but_is_close.png" id="close" /></a>
<?php echo $js_grid;?>
<div class="det" style="margin-left:29px"><table id="flex1" style="display:none"></table></div><br />