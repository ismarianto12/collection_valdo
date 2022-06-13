<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Halaman 1</title>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	<script src="../assets/js/jquery-1.3.2.min.js"></script>

</head>
<body>
<div id="pagebody">
  <!-- container -->
  <div id="container">
    <div id="container-inner" class="pkg">

		<!-- alpha -->
		<div id="alpha">
			<div id="alpha-inner" class="pkg">

		    <div id="inbound-title">
		    	<h1>TOP Five</h1>
		    </div>

		    <div id="inbound-body">
		    	<div id="inbound-body-inner" class="pkg">
		    		<!-- Top Five -->
						<table border="0" cellpadding="4" cellspacing="0" id="tbl-list">
						<thead>
						<tr>
							<th>Desk Coll</th>
							<th>Performance</th>
							<th>Team Leader</th>
						</tr>
						</thead>
						<tbody>
						<?php
							foreach($data_top as $i => $row)
							{
							 	$class = ($i % 2 == 1) ? 'odd' : 'even';

								echo '<tr class="' . $class . '">';
								echo '	<td align="left">' . $row['username'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_call'] . '%</td> ' . "\r\n" ;
								echo '	<td align="left">' . $row['leader_name'] . '</td> ' . "\r\n" ;
								echo '</tr> ' ;
							}
						?>
						</tbody>
						</table>
						<!-- /Top Five -->
		    	</div>
		    </div>

		    <div id="inbound-title">
		    	<h1>Worst 5</h1>
		    </div>

		    <div id="inbound-body">
		    	<div id="inbound-body-inner" class="pkg">
						<!-- Worst 5 -->
						<table border="0" cellpadding="4" cellspacing="0" id="tbl-list-w">
						<tr>
							<th>Desk Coll</th>
							<th>Performance</th>
							<th>Team Leader</th>
						</tr>
						</thead>
						<tbody>
						<?php
							foreach($worst as $i => $row)
							{
							 	$class = ($i % 2 == 1) ? 'odd' : 'even';

								echo '<tr class="' . $class . '">';
								echo '	<td align="left">' . $row['username'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_call'] . '%</td> ' . "\r\n" ;
								echo '	<td align="left">' . $row['leader_name'] . '</td> ' . "\r\n" ;
								echo '</tr> ' ;
							}
						?>
						</tbody>
						</table>
						<!-- /Worst 5 -->
		    	</div>
		    </div>

			</div>
		</div>
		<!-- /alpha -->

		<!-- beta -->
		<div id="beta">
			<div id="beta-inner" class="pkg">

		    <div id="outbound-title">
		    	<h1>Monitoring Data</h1>
		    </div>

		    <div id="outbound-body">
		    	<div id="outbound-body-inner" class="pkg">
						<table border="0" cellpadding="4" cellspacing="0" id="tbl-list">
						<thead>
						<tr>
							<th>
							<?php
								$total_offline = $user_active - $user;
								echo $total_offline . ' Offline Calls';
							?></th>
						</tr>
						<tr>
							<th><?php echo $user ?> ONLINE CALLS</th>
						</tr>
						</thead>
						</table>
						<br />
		    		<!-- Monitoring -->
						<table border="0" cellpadding="4" cellspacing="0" id="tbl-list">
						<thead>
						<tr>
							<th>OD</th>
							<th>Total Data</th>
							<th>Total OS</th>
							<th>Pengerjaan</th>
							<th>Sisa</th>
							<th>%</th>
						</tr>
						</thead>
						<tbody>
						<?php
							$total_data_all=0;
							$total_os_all=0;
							$total_tounch_all=0;
							$total_sisa_all=0;
							foreach($data_un as $i => $row)
							{
							 	$class = ($i % 2 == 1) ? 'odd' : 'even';

								echo '<tr class="' . $class . '">';
								echo '	<td align="center">' . $row['od'] . '</td> ' . "\r\n" ;
								echo '	<td align="right">' . number_format($row['total_data']) . '</td> ' . "\r\n" ;
								echo '	<td align="right">' . number_format($row['total_os']) . '</td> ' . "\r\n" ;
								echo '	<td align="right">' . number_format($row['total_tounch']) . '</td> ' . "\r\n" ;
								echo '	<td align="right">' . number_format($row['total_sisa']) . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['percentage'] . '</td> ' . "\r\n" ;
								echo '</tr> ' ;
								
								$total_data_all += $row['total_data'];
								$total_os_all += $row['total_os'];
								$total_tounch_all += $row['total_tounch'];
								$total_sisa_all += $row['total_sisa'];
							}
						?>
						<tr>
							<td>Total</td>
							<td align="right"><?php echo number_format($total_data_all) ?></td>
							<td align="right"><?php echo number_format($total_os_all) ?></td>
							<td align="right"><?php echo number_format($total_tounch_all) ?></td>
							<td align="right"><?php echo number_format($total_sisa_all) ?></td>
							<td></td>
						</tr>
						</tbody>
						</table>

						<br /><br />
						<!-- /Monitoring -->
		    	</div>
		    </div>

			</div>
		</div>
		<!-- /beta -->

    </div>
  </div>
  <!-- /container -->

</div>
</body>
</html>
