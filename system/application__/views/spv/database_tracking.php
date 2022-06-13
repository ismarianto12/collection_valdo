<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery.columnhover.pack.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#listHover').columnHover({eachCell:true, hoverClass:'betterhover'}); 
    });
</script>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/hdr_tables.css" type="text/css"  />
<style type="text/css">
    table.hdrtable
    {
        width: 400px;
    }
    td.hover, #listHover tbody tr:hover
    {
        background-color: LemonChiffon;
    }
    td.betterhover, #listHover tbody tr:hover
    {
        background: LightCyan;
    }

    
</style>
<center>
<div>
	<table class="hdrtable" id="listHover" cellspacing="0" style="width:1024px">
	<thead>
		<tr class="tit">
			<th class="th_bg">Data Segment</th>
			<th class="th_bg">Object Group</th>
			<th class="th_bg">Fin Type</th>	
			<th class="th_bg">Total Data</th>	
			<th class="th_bg">Non Categorize</th>	
			<th class="th_bg">Untouch</th>	
			<th class="th_bg">Retouch</th>	
			<th class="th_bg">Skipped</th>	
			<th class="th_bg">Locked</th>	
		</tr>
	</thead>
<? $i = 0; foreach ($data_array as $data) { ?>
		<tr style="text-align:center;">
			<td <?php if($i % 2 == 0){ echo 'style="background-color:lightblue" '; } ?> class="alt"><?= $data['DATA_SEGMENT']; ?></td>
			<td <?php if($i % 2 == 0){ echo 'style="background-color:lightblue" '; } ?> class="alt"><?= $data['OBJ_GRP']; ?></td>
			<td <?php if($i % 2 == 0){ echo 'style="background-color:lightblue" '; } ?> class="alt"><?= $data['FINTYPE']; ?></td>
			<td <?php if($i % 2 == 0){ echo 'style="background-color:lightblue" '; } ?> class="alt"><?= $data['TTL_DATA_CALLED']; ?> / <?= $data['TTL_DATA']; ?></td>
			<td <?php if($i % 2 == 0){ echo 'style="background-color:lightblue" '; } ?> class="alt"><?= $data['NON_CATEGORIZE_CALLED']; ?> / <?= $data['NON_CATEGORIZE']; ?></td>
			<td <?php if($i % 2 == 0){ echo 'style="background-color:lightblue" '; } ?> class="alt"><?= $data['UNTOUCH_CALLED']; ?> / <?= $data['UNTOUCH']; ?></td>
			<td <?php if($i % 2 == 0){ echo 'style="background-color:lightblue" '; } ?> class="alt"><?= $data['RETOUCH_CALLED']; ?> / <?= $data['RETOUCH']; ?></td>
			<td <?php if($i % 2 == 0){ echo 'style="background-color:lightblue" '; } ?> class="alt"><?= $data['SKIPPED']; ?></td>
			<td <?php if($i % 2 == 0){ echo 'style="background-color:lightblue" '; } ?> class="alt"><?= $data['LOCKED']; ?></td>
		</tr>
<? $i++ ; } ?>		
		</table>
</div>
</center>