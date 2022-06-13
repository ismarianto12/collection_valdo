  <p>
	   <label class="filter">
      	<input type="hidden" name="post2" value="1" />
		<input class="but_reg" type="button"  name="reset" onclick="resetFilter('<?=site_url()?>/admin/hdr_view_debtor_cont/reset_filter')" value="RESET"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input class="but_proceed" type="button"  name="btnsubmit" onclick="proceedFilter('<?=site_url()?>/admin/hdr_view_debtor_cont/proceed_filter_view_only')" value=""  />
		
      </label>
	  </p>
		<p>&nbsp;</p>

     </div>
		<span class="boxfull_bot"></span>
	</div>
	<!-- end of CONTENT FULL -->
</div>
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
		if (com=='Edit')
        { 	
           if(jQuery('.trSelected',grid).length>0){
			   var items = jQuery('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
						itemlist+= items[i].id.substr(3);
					}
			   if(confirm('Edit this debtor ?')){
					data: "items="+itemlist,
					location.href="<?php echo site_url()?>admin/cases/edit/"+itemlist;
				}
			} 
        }
	
} 
function loadFlexiDebtor(){
//notif.hide();
$(document).ready(function(){
	$('.viewDebtor').load('<?=site_url()?>admin/hdr_view_debtor_cont/debtor_view/')	
 });	
}
loadFlexiDebtor();
</script>

<div class="content">
	<!-- start of CONTENT FULL -->
	<div class="cnfull">
		<span class="boxfull_top"></span>
		<div class="boxfull_box">
  <h2>Debtors Data</h2>
		<div class="viewDebtor"><center><img src="<?=base_url()?>assets/images/loader.gif" /><center></div>
	   
	  <p>&nbsp;</p>
	</div>
		<span class="boxfull_bot"></span>
	</div>
	<!-- end of CONTENT FULL -->
</div>