<script>
function test(com,grid)
{
		
		if (com=='Export')
        { 	
					location.href="<?php echo site_url()?>user/hdr_export_csv_ctrl/export_<?=$hist_type?>/<?=$primary_1?>";
        }
		
} 
</script>
<a href="#"><img src="<?=base_url()?>assets/images/but_is_close.png" id="close" /></a>
<?php echo $js_grid;?>
<div class="det" style="margin-left:29px"><table id="flex1" style="display:none"></table></div><br />
