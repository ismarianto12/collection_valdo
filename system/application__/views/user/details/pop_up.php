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
</script>
<a href="#"><img src="<?=base_url()?>assets/images/but_is_close.png" id="close" /></a>
<?php echo $js_grid;?>
<div class="det" style="margin-left:29px"><table id="flex1" style="display:none"></table></div><br />