<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery.columnhover.pack.js"></script>
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
<script>
	function changeFlag(flag){
		$('#isSearch').val(flag);
		document.formSearch.submit();
	}
	$(document).ready(function(){
		var bulan = '<?=date('m')?>';
		var tahun = '<?=date('Y')?>';
		var area = 'jkt';
		var refreshId = setInterval(function() {
		reloadSumCases(bulan,tahun,area);
		}, 1800000000000000000000000);
	});

	$(document).ready(function(){
		var bulan = $('.bulan').val();
		var tahun = $('.tahun').val();
		var area = $('.area').val();
		var tl = $('.tl').val();
		var cabang = $('.cabang').val();
		var deskcoll = $('.deskcoll').val();
		$('.sum_report').load('<?=site_url()?>spv/hdr_spv_report_ctrl/report_adira_view/'+bulan+'/'+tahun+'/'+area+'/'+tl+'/'+cabang+'/'+deskcoll)
	});
	function reloadSumCases(bulan,tahun,area,tl,cabang,deskcoll){	
		$(document).ready(function(){
			$('.sum_report').load('<?=site_url()?>spv/hdr_spv_report_ctrl/report_adira_view/'+bulan+'/'+tahun+'/'+area+'/'+tl+'/'+cabang+'/'+deskcoll)	
		});	
	}
	
	function goSumCases(){
		telli('Please Wait...');
		//loading("Please Wait...");
		$(document).ready(function(){
			var bulan = $('.bulan').val();
			var tahun = $('.tahun').val();
			var area = $('.area').val();
			var tl = $('.tl').val();
			var cabang = $('.cabang').val();
			var deskcoll = $('.deskcoll').val();
			reloadSumCases(bulan,tahun,area,tl,cabang,deskcoll);
		});
	}
</script>
<div class="content">
	<div class="cnfull">
		<span class="boxfull_top"></span>
		<div class="boxfull_box">
		<!--form id="formSearch" name="formSearch" method="post" action="" /-->
		<form action="<?php echo site_url();?>spv/hdr_spv_report_ctrl/report_adira_view/" method="post" id="Fm">
			<input type="hidden" id="isSearch" name="isAssign" value="0" />
			<!--label class="batch" style="width:50px;">Date </label><input type="text" class="begindate" name="fromdate" id="datepicker" size="9" value="<?=date('Y-m-d')?>"  /> to <input type="text" class="enddate" name="enddate" id="datepicker2"  size="9" value="<?=date('Y-m-d')?>" /-->
			<label class="batch" style="width:50px;">Bulan </label>
			<select name="bulan" id="bulan" class="bulan">
				<option value="1" <?php echo 1 == date("m") ? 'Selected' : '' ?>>January</option>
				<option value="2" <?php echo 2 == date("m") ? 'Selected' : '' ?>>February</option>
				<option value="3" <?php echo 3 == date("m") ? 'Selected' : '' ?>>March</option>
				<option value="4" <?php echo 4 == date("m") ? 'Selected' : '' ?>>April</option>
				<option value="5" <?php echo 5 == date("m") ? 'Selected' : '' ?>>May</option>
				<option value="6" <?php echo 6 == date("m") ? 'Selected' : '' ?>>Juny</option>
				<option value="7" <?php echo 7 == date("m") ? 'Selected' : '' ?>>July</option>
				<option value="8" <?php echo 8 == date("m") ? 'Selected' : '' ?>>August</option>
				<option value="9" <?php echo 9 == date("m") ? 'Selected' : '' ?>>September</option>
				<option value="10" <?php echo 10 == date("m") ? 'Selected' : '' ?>>October</option>
				<option value="11" <?php echo 11 == date("m") ? 'Selected' : '' ?>>November</option>
				<option value="12" <?php echo 12 == date("m") ? 'Selected' : '' ?>>December</option>
			</select>&nbsp;&nbsp;
			<label class="batch" style="width:50px;">Tahun </label>
			<select name="tahun" id="tahun" class="tahun">
				<?php 
						$tahun = date("Y",mktime(0,0,0,date("m"),date("d"),date("Y")-4));
						$tahunvalue = date("Y",mktime(0,0,0,date("m"),date("d"),date("Y")-4));
						$tahunselect = date("Y",mktime(0,0,0,date("m"),date("d"),date("Y")-4));
				?>
				<option value="<?php echo $tahunvalue++; ?>" ><?php echo $tahun++; ?></option>
				<option value="<?php echo $tahunvalue++; ?>" ><?php echo $tahun++; ?></option>
				<option value="<?php echo $tahunvalue++; ?>" ><?php echo $tahun++; ?></option>
				<option value="<?php echo $tahunvalue++; ?>" ><?php echo $tahun++; ?></option>
				<option value="<?php echo $tahunvalue++; ?>" selected><?php echo $tahun++; ?></option>
			</select>&nbsp;&nbsp;
			<label class="batch" style="width:50px;">Area </label>
			<select name="area" id="area" class="area">
				<option value="01" >Jakarta</option>
				<option value="02" >Surabaya</option>
			</select>&nbsp;&nbsp;
			<label class="batch" style="width:50px;">TL </label>
			<select name="tl" id="tl" class="tl">
				<option value="hery" >All</option>
				<?php $sql = "select id_user, fullname from hdr_user where id_level = '2' order by fullname asc";
					  $q = $this->db->query($sql);
					  foreach($q->result_array() as $row){ ?>
						  <option value="<?php echo $row['id_user']; ?>" ><?php echo $row['fullname']; ?></option>
					  <?php }
				?>
			</select>&nbsp;&nbsp;
			<label class="batch" style="width:50px;">ID Cabang </label>
			<select name="cabang" id="cabang" class="cabang">
				<option value="hery" >All</option>
				<?php $sql = "select area_code, branch_name from hdr_branches";
					  $q = $this->db->query($sql);
					  foreach($q->result_array() as $row){ ?>
						  <option value="<?php echo $row['area_code']; ?>" ><?php echo $row['area_code']." - ". $row['branch_name']; ?></option>
					  <?php }
				?>
			</select>&nbsp;&nbsp;<br/><br/>
			<label class="batch" style="width:50px;">Deskcoll </label>
			<select name="deskcoll" id="deskcoll" class="deskcoll">
				<option value="hery" >All</option>
				<?php $no = 1; $sql = "select id_user, fullname from hdr_user where id_level = '3' order by fullname asc";
					  $q = $this->db->query($sql);
					  foreach($q->result_array() as $row){ ?>
						  <option value="<?php echo $row['id_user']; ?>" ><?php echo $no++.". ".$row['fullname']; ?></option>
					  <?php }
				?>
			</select>&nbsp;&nbsp;&nbsp;<br/><br/><input type="button" value="GO / Refresh" class="but_reg" onclick="goSumCases();return false;">&nbsp;&nbsp;&nbsp;<input type="button" value="Export To Excel" class="but_reg" onclick="jQuery('#export').val(1);jQuery('#Fm').submit()">
			<input name="export" id="export" value="0" type="hidden"/>
			<!--input type="button" id="goSearch" name="goSearch" value=" View Data " onclick="changeFlag(1)" /-->
				<br/><br/>
				<!--div style="width:100%;overflow:scroll;">
				<table border="0" class="hdrtable" id="listHover" cellspacing="0" style="width:100%;margin-top:10px">
				<thead>
					<tr class="tit">
						<th class="th_bg">Total Accounts (Mentah)</th>
						<th class="th_bg">Total Accounts (System)</th>
						<th class="th_bg">Selisih</th>
						<th class="th_bg">Untouch available</th>
						<th class="th_bg">SKIP</th>
						<th class="th_bg">Active On</th>
						<th class="th_bg">Total Data On work</th>
						<th class="th_bg">% Untouch</th>
						<th class="th_bg">% Skip</th>
						<th class="th_bg">% Active On</th>
					</tr>
					</thead>
					<tbody>
					<tr <?php $row_index=1; $flag = $row_index % 2 == 0 ? $cls = 'class="specalt"' : $cls = 'class="spec"'; echo $cls; ?>>
						<td class="alt"><?php echo @($daily_report['mentah']); ?></td>
						<td class="alt"><?php echo @($daily_report['total']); ?></td>
						<td class="alt"><?php echo @($daily_report['selisih']); ?></td>
						<td class="alt"><?php echo @($daily_report['untouch']); ?></td>
						<td class="alt"><?php echo @($daily_report['skip']); ?></td>
						<td class="alt"><?php echo @($daily_report['active_on']); ?></td>
						<td class="alt"><?php echo @($daily_report['data_work']); ?></td>
						<td class="alt"><?php echo @($daily_report['untouch_persen']); ?></td>
						<td class="alt"><?php echo @($daily_report['skip_persen']); ?></td>
						<td class="alt"><?php echo @($daily_report['data_work_persen']); ?></td>
					</tr>
					</tbody>
				</table>
				</div-->
		</form>
			<br/>
			<br/>
			<div class="sum_report"><center><img src="<?=base_url()?>assets/images/loader.gif" /><center></div>
			<br/>
			<br/>
		</div>
		<span class="boxfull_bot"></span>
	</div>
</div>
<script type="text/javascript">
	function openHandleList(primary_1){
		var url = '<?php echo site_url(); ?>/user/hdr_contact_cont/contact/'+primary_1+'/';
		var win = window.open(url, '_blank');
		win.focus();
	}
	function openHandleList1(bucket,type){
		var url = '<?php echo site_url(); ?>/user/hdr_ptp_account_cont/detail_assign/'+bucket+'/'+type+'/';
		var config = 'width = 1100, height = 450';
		var title = 'List Debtor';
		window.open(url,title,config);
	}
</script>