<?php
/*
 * WEBBASE APPLIKASI
 *
 * Copyright (c) 2014
 *
 * file 	: akses.php
  */
/*----------------------------------------------------------*/
?>
<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>system</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/themes/default/easyui.css">

	<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/jquery-1.8.0.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/jquery.easyui.min.js"></script>
	<!--Chart-->
	<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/highchart/highcharts.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/highchart/modules/exporting.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/highchart/modules/offline-exporting.js"></script>

</head>
<script type="text/javascript">
	$(document).ready(function() {
		setInterval(function() {
			location.reload();
		}, 60000); // refresh browser

		function updateWallboard() {
			$('#tt').datagrid('reload');
			location.href = 'reload/insert_blast/';
			setTimeout(function() {
				updateWallboard();
			}, 5000);
		}
	});

	function ajak(urlnya, datanya) {
		var resp = $.ajax({
			type: "POST",
			url: urlnya,
			async: false,
			data: datanya,
			dataType: 'JSON'
		}).responseText;
		return resp;
	}
	var url;
	/* function loaddatablast(){
		$('#tt').datagrid('reload');
		location.href = 'reload/insert_blast/';
	}
	setInterval(function(){ loaddatablast() }, 10000); */
</script>

<?php
if (count($idlegraph) > 0) {
	foreach ($idlegraph as $row) {
		$tanggal 		= $row['tglnow'];
		$jam8	 		= $row["8pm"];
		$jam830	 		= $row["830pm"];
		$jam9	 		= $row["9pm"];
		$jam930	 		= $row["930pm"];
		$jam10	 		= $row["10pm"];
		$jam1030		= $row["1030pm"];
		$jam11	 		= $row["11pm"];
		$jam1130	 	= $row["1130pm"];
		$jam12	 		= $row["12pm"];
		$jam1230	 	= $row["1230pm"];
		$jam13	 		= $row["1am"];
		$jam1330	 	= $row["130am"];
		$jam14	 		= $row["2am"];
		$jam1430	 	= $row["230am"];
		$jam15	 		= $row["3am"];
		$jam1530	 	= $row["330am"];
		$jam16	 		= $row["4am"];
		$jam1630	 	= $row["430am"];
		$jam17	 		= $row["5am"];
		$jam1730	 	= $row["530am"];
		$jam18	 		= $row["6am"];
		$jam1830	 	= $row["630am"];
		$jam19	 		= $row["7am"];
		$jam1930	 	= $row["730am"];
		$jam20	 		= $row["8am"];
	}

	$waktu8 		= !is_null($jam8) ? $jam8 : 0;
	$waktu830 		= !is_null($jam830) ? $jam830 : 0;
	$waktu9 		= !is_null($jam9) ? $jam9 : 0;
	$waktu930 		= !is_null($jam930) ? $jam930 : 0;
	$waktu10 		= !is_null($jam10) ? $jam10 : 0;
	$waktu1030 		= !is_null($jam1030) ? $jam1030 : 0;
	$waktu11 		= !is_null($jam11) ? $jam11 : 0;
	$waktu1130 		= !is_null($jam1130) ? $jam1130 : 0;
	$waktu12 		= !is_null($jam12) ? $jam12 : 0;
	$waktu1230 		= !is_null($jam1230) ? $jam1230 : 0;
	$waktu13 		= !is_null($jam13) ? $jam13 : 0;
	$waktu1330 		= !is_null($jam1330) ? $jam1330 : 0;
	$waktu14 		= !is_null($jam14) ? $jam14 : 0;
	$waktu1430 		= !is_null($jam1430) ? $jam1430 : 0;
	$waktu15 		= !is_null($jam15) ? $jam15 : 0;
	$waktu1530 		= !is_null($jam1530) ? $jam1530 : 0;
	$waktu16 		= !is_null($jam16) ? $jam16 : 0;
	$waktu1630 		= !is_null($jam1630) ? $jam1630 : 0;
	$waktu17 		= !is_null($jam17) ? $jam17 : 0;
	$waktu1730 		= !is_null($jam1730) ? $jam1730 : 0;
	$waktu18 		= !is_null($jam18) ? $jam18 : 0;
	$waktu1830 		= !is_null($jam1830) ? $jam1830 : 0;
	$waktu19 		= !is_null($jam19) ? $jam19 : 0;
	$waktu1930 		= !is_null($jam1930) ? $jam1930 : 0;
	$waktu20 		= !is_null($jam20) ? $jam20 : 0;
}

if (count($urllist1) > 0) {
	foreach ($urllist1 as $row) {
		$tgldatz 		= $row['tglnow'];
		$totdatz 		= $row["totdat"];
		$od30z	 		= $row["od30"];
		$od1z	 		= $row["od1"];
		$od0z	 		= $row["od0"];
		$od_2z	 		= $row["od_2"];
		$od_3z			= $row["od_3"];
		$statdonez	 	= $row["statdone"];
		$done30z	 	= $row["30done"];
		$done1z	 		= $row["1done"];
		$done0z	 		= $row["0done"];
		$done2z	 		= $row["_2done"];
		$done3z	 		= $row["_3done"];
		$statrunz	 	= $row["statrun"];
		$run30z	 		= $row["30run"];
		$run1z	 		= $row["1run"];
		$run0z	 		= $row["0run"];
		$run2z	 		= $row["_2run"];
		$run3z	 		= $row["_3run"];
		$invalidz	 	= $row["invalid"];
		$invalid30z	 	= $row["30invalid"];
		$invalid1z	 	= $row["1invalid"];
		$invalid0z	 	= $row["0invalid"];
		$invalid2z	 	= $row["_2invalid"];
		$invalid3z	 	= $row["_3invalid"];
	}

	$tgldat 	= !is_null($tgldatz) ? $tgldatz : 0;
	$totdat 	= !is_null($totdatz) ? $totdatz : 0;
	$od30 		= !is_null($od30z) ? $od30z : 0;
	$od1 		= !is_null($od1z) ? $od1z : 0;
	$od0 		= !is_null($od0z) ? $od0z : 0;
	$od_2 		= !is_null($od_2z) ? $od_2z : 0;
	$od_3 		= !is_null($od_3z) ? $od_3z : 0;
	$statdone 	= !is_null($statdonez) ? $statdonez : 0;
	$done30 	= !is_null($done30z) ? $done30z : 0;
	$done1 		= !is_null($done1z) ? $done1z : 0;
	$done0 		= !is_null($done0z) ? $done0z : 0;
	$done2 		= !is_null($done2z) ? $done2z : 0;
	$done3 		= !is_null($done3z) ? $done3z : 0;
	$statrun 	= !is_null($statrunz) ? $statrunz : 0;
	$run30 		= !is_null($run30z) ? $run30z : 0;
	$run1 		= !is_null($run1z) ? $run1z : 0;
	$run0 		= !is_null($run0z) ? $run0z : 0;
	$run2 		= !is_null($run2z) ? $run2z : 0;
	$run3 		= !is_null($run3z) ? $run3z : 0;
	$invalid 	= !is_null($invalidz) ? $invalidz : 0;
	$invalid30 	= !is_null($invalid30z) ? $invalid30z : 0;
	$invalid1 	= !is_null($invalid1z) ? $invalid1z : 0;
	$invalid0 	= !is_null($invalid0z) ? $invalid0z : 0;
	$invalid2 	= !is_null($invalid2z) ? $invalid2z : 0;
	$invalid3 	= !is_null($invalid3z) ? $invalid3z : 0;

	$cRet = "<tr>
	        	<td width='auto' sortable='true'>$tgldat</td>
	        	<td width='auto' sortable='true'>$totdat</td>
	        	<td width='auto' sortable='true'>$od30</td>
	        	<td width='auto' sortable='true'>$od1</td>
	        	<td width='auto' sortable='true'>$od0</td>
	        	<td width='auto' sortable='true'>$od_2</td>
	        	<td width='auto' sortable='true'>$od_3</td>
	        	<td width='auto' sortable='true'>$statdone</td>
	        	<td width='auto' sortable='true'>$done30</td>
	        	<td width='auto' sortable='true'>$done1</td>
	        	<td width='auto' sortable='true'>$done0</td>
	        	<td width='auto' sortable='true'>$done2</td>
	        	<td width='auto' sortable='true'>$done3</td>
	        	<td width='auto' sortable='true'>$statrun</td>
	        	<td width='auto' sortable='true'>$run30</td>
	        	<td width='auto' sortable='true'>$run1</td>
	        	<td width='auto' sortable='true'>$run0</td>
	        	<td width='auto' sortable='true'>$run2</td>
	        	<td width='auto' sortable='true'>$run3</td>
	        	<td width='auto' sortable='true'>$invalid</td>
	        	<td width='auto' sortable='true'>$invalid30</td>
	        	<td width='auto' sortable='true'>$invalid1</td>
	        	<td width='auto' sortable='true'>$invalid0</td>
	        	<td width='auto' sortable='true'>$invalid2</td>
	        	<td width='auto' sortable='true'>$invalid3</td>
			</tr>";
} else {
	$cRet = "<tr> 
					<td colspan='20'>No Data</td> 
				</tr>";
}

?>

<script type="text/javascript">
	var chart;
	$(document).ready(function() {
		//loaddatagraf();
		setTimeout(function() {
			loaddatagraf(99);
		}, 1000);
	});

	function loaddatagraf() {
		chart = new Highcharts.Chart({
			credits: {
				enabled: false
			},
			chart: {
				renderTo: 'container',
				type: 'line',
				marginRight: 130,
				marginBottom: 60
			},
			title: {
				text: 'Total IDLE Per Hari',
				x: -20 //center
			},
			subtitle: {
				text: 'Adira Highcharts',
				x: -20
			},
			xAxis: { //X axis menampilkan data tahun
				categories: ['8AM', '8.30AM', '9AM', '9.30AM', '10AM', '10.30AM', '11AM', '11.30AM', '12AM', '12.30AM', '1PM', '1.30PM', '2PM', '2.30PM', '3PM', '3.30PM', '4PM', '4.30PM', '5PM', '5.30PM', '6PM', '6.30PM', '7PM', '7.30PM', '8PM']
				/* lineWidth: 0,
				minorGridLineWidth: 0,
				lineColor: 'transparent',     
				labels: {
				   enabled: false
				},
				minorTickLength: 0,
				tickLength: 0 */

			},
			yAxis: {
				title: { //label yAxis
					text: 'DATA IDLE'
				},
				plotLines: [{
					value: 0,
					width: 2,
					color: '#808080' //warna dari grafik line
				}]
			},
			tooltip: {
				formatter: function() {
					return '<b>' + this.series.name + '</b><br/>' +
						this.x + ': ' + this.y;
				}
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true
					}
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -10,
				y: 100,
				borderWidth: 0
			},
			series: [{
				name: 'IDLE',
				data: [<?php echo $waktu8 . "," . $waktu830 . "," . $waktu9 . "," . $waktu930 . "," . $waktu10 . "," . $waktu1030 . "," . $waktu11 . "," . $waktu1130 . "," . $waktu12 . "," . $waktu1230 . "," . $waktu13 . "," . $waktu1330 . "," . $waktu14 . "," . $waktu1430 . "," . $waktu15 . "," . $waktu1530 . "," . $waktu16 . "," . $waktu1630 . "," . $waktu17 . "," . $waktu1730 . "," . $waktu18 . "," . $waktu1830 . "," . $waktu19 . "," . $waktu1930 . "," . $waktu20; ?>]
			}]
		});
	}
	setTimeout(function() {
		loaddatagraf(value - 1);
	}, 1000);
</script>

<body>
	<table id="tt" class="easyui-datagrid" style="width:auto;" fit="true" title="" url="<? //=$urllist1;
																						?>" rownumbers="true" pagination="true" striped="true" pageSize="20" pageList="[20,30,60]" singleSelect="true">
		<thead frozen="true">
			<tr>
				<th field="tglnow" width="auto" sortable="true">TANGGAL</th>
				<th field="totdat" width="auto" sortable="true">DATA</th>
				<th field="od30" width="auto" sortable="true">OD30</th>
				<th field="od1" width="auto" sortable="true">OD1</th>
				<th field="od0" width="auto" sortable="true">OD0</th>
				<th field="od_2" width="auto" sortable="true">OD-2</th>
				<th field="od_3" width="auto" sortable="true">OD-3</th>
				<th field="statdone" width="auto" sortable="true">CONTACT</th>
				<th field="30done" width="auto" sortable="true">OD30</th>
				<th field="1done" width="auto" sortable="true">OD1</th>
				<th field="0done" width="auto" sortable="true">OD0</th>
				<th field="_2done" width="auto" sortable="true">OD-2</th>
				<th field="_3done" width="auto" sortable="true">OD-3</th>
				<th field="statrun" width="auto" sortable="true">UNCONTACT</th>
				<th field="30run" width="auto" sortable="true">OD30</th>
				<th field="1run" width="auto" sortable="true">OD1</th>
				<th field="0run" width="auto" sortable="true">OD0</th>
				<th field="_2run" width="auto" sortable="true">OD-2</th>
				<th field="_3run" width="auto" sortable="true">OD-3</th>
				<th field="invalid" width="auto" sortable="true">DATA INVALID</th>
				<th field="invalid30" width="auto" sortable="true">OD30</th>
				<th field="invalid1" width="auto" sortable="true">OD1</th>
				<th field="invalid0" width="auto" sortable="true">OD0</th>
				<th field="invalid2" width="auto" sortable="true">OD-2</th>
				<th field="invalid3" width="auto" sortable="true">OD-3</th>
			</tr>
		</thead>
		<?php echo $cRet; ?>
		<div class="row">
			<div id="container" style="min-width: 400px; height: 450px; margin: 0 auto"></div>
		</div>
		</thead>
	</table>

</body>

</html>