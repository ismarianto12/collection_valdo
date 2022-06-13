<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/hdr_tables.css" type="text/css"  />
<style type="text/css">
    table.hdrtable { width: 400px; font-size: 0.8em; }
    td.hover, #listHover tbody tr:hover { background-color: LemonChiffon; }
    td.betterhover, #listHover tbody tr:hover { background: LightCyan; }
    #mainDiv { width:auto; height:auto; margin: 5px; }
    #period { width: 100px; padding: 5px; border-radius: 5px; }
</style>

<script>
    $(function() {
			$("#period").datepicker({showOn: 'button', buttonImage: '<?php echo base_url() ?>/assets/images/calendar.gif',dateFormat: 'yy-mm-dd', buttonImageOnly: true, changeMonth: true,
			changeYear: true});
	});
    
</script>

<br />
<div id="mainDiv">
    
    <h4> <a href="<?=$prevdate;?>">&lt&lt</a> &nbsp Period: <?=DATE('D, d M Y', strtotime($period));?> &nbsp <a href="<?=$nextdate;?>">&gt&gt</a>
    
    <br /> 
    <br /><hr /><br />
    <a href="<?=$export;?>"><img src="<?=base_url()?>assets/images/but_excel.png" /></a><br /><br />
    
    <table id="listHover" class="hdrtable" style="width:80%">
    <tr class="tit">
        <th class="th_bg">#</th>
        <th class="th_bg">USERNAME</th>
        <th class="th_bg">TYPE</th>
        <th class="th_bg">REASON</th>
        <th class="th_bg">TIMESTAMP</th>
    </tr>
    <?php $idx = 1; ?>
    <?php foreach($access_log as $log): ?>
     <tr class="spec<?=$idx % 2 == 0 ? 'alt': ''; ?>">
        <td class="alt"><?=$idx;?></td>
        <td class="alt"><?=strtoupper($log['user_name']);?></td>
        <td class="alt"><?=$log['type'];?></td>
        <td class="alt"><?=$log['code']. ' - '. $miscModel->get_tableDataById('tb_logoutreason', $log['code'], 'code', 'description');?></td>
        <td class="alt"><?=$log['timestamp'];?></td>
     </tr>
     <?php $idx++; ?>
    <?php endforeach; ?>
    </table>
</div>
<br />
<br />
<br />