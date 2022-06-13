<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Halaman 2</title>
	<link rel="stylesheet" href="style2.css" type="text/css" media="screen" />
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
		    	<h1>Monitoring Leader</h1>
		    </div>

		    <div id="inbound-body">
		    	<div id="inbound-body-inner" class="pkg">
		    		<!-- Monitoring Leader -->
						<table border="0" cellpadding="4" cellspacing="0" id="tbl-list">
						<thead>
						<tr>
							<th>Team&nbsp;Leader</th>
							<th>Jan</th>
							<th>Feb</th>
							<th>Mar</th>
							<th>Apr</th>
							<th>Mei</th>
							<th>Jun</th>
							<th>Jul</th>
							<th>Aug</th>
							<th>Sep</th>
							<th>Okt</th>
							<th>Nov</th>
							<th>Dec</th>
							<th>Total</th>
						</tr>
						</thead>
						<tbody>
						<?php
							foreach($absen as $i => $row)
							{
							 	$class = ($i % 2 == 1) ? 'odd' : 'even';

								echo '<tr class="' . $class . '">';
								echo '	<td align="left">' . $row['leader_name']  . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_jan'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_feb'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_mar'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_apr'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_may'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_jun'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_jul'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_aug'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_sep'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_okt'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_nov'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['total_dec'] . '</td> ' . "\r\n" ;
								echo '	<td align="center">' . $row['subtotal'] . '</td> ' . "\r\n" ;
								echo '</tr> ' ;
							}
						?>
						</tbody>
						</table>
						<!-- Monitoring Leader -->
		    	</div>
		    </div>

			</div>
		</div>
		<!-- /alpha -->

		<!-- beta -->
		<div id="beta">
			<div id="beta-inner" class="pkg">

		    <div id="outbound-title">
		    	<h1>Absensi</h1>
		    </div>

		    <div id="outbound-body">
		    	<div id="outbound-body-inner" class="pkg">

						<!-- Monitoring User -->
						<table border="0" cellpadding="5" cellspacing="0">
						<tr>
						<td valign="top">
							<!-- kolom1 -->
							<table border="0" cellpadding="4" cellspacing="0" id="tbl-list2">
							<thead>
							<tr>
								<th>No</th>
								<th>Desk&nbsp;Coll</th>
								<th>Absensi</th>
								<th>Team&nbsp;Leader</th>
							</tr>
							</thead>
							<tbody>
							<?php
								$j=0;
								foreach($absen1 as $i => $row)
								{
									$j++;
								 	$class = ($i % 2 == 1) ? 'odd' : 'even';

									echo '<tr class="' . $class . '">';
									echo '	<td align="left">' . $j  . '</td> ' . "\r\n" ;
									echo '	<td align="left">' . $row['username']  . '</td> ' . "\r\n" ;
									echo '	<td align="center">' . $row['total_hadir'] . '</td> ' . "\r\n" ;
									echo '	<td align="left">' . $row['leader_name'] . '</td> ' . "\r\n" ;
									echo '</tr> ' ;

								}
							?>
							</tbody>
							</table>
						</td>
						<td valign="top">
							<!-- kolom2 -->
							<table border="0" cellpadding="4" cellspacing="0" id="tbl-list2">
							<thead>
							<tr>
								<th>No</th>
								<th>Desk&nbsp;Coll</th>
								<th>Absensi</th>
								<th>Team&nbsp;Leader</th>
							</tr>
							</thead>
							<tbody>
							<?php
								$j=0;
								foreach($absen2 as $i => $row)
								{
									$j++;
								 	$class = ($i % 2 == 1) ? 'odd' : 'even';

									echo '<tr class="' . $class . '">';
									echo '	<td align="left">' . $j  . '</td> ' . "\r\n" ;
									echo '	<td align="left">' . $row['username']  . '</td> ' . "\r\n" ;
									echo '	<td align="center">' . $row['total_hadir'] . '</td> ' . "\r\n" ;
									echo '	<td align="left">' . $row['leader_name'] . '</td> ' . "\r\n" ;
									echo '</tr> ' ;

								}
							?>
							</tbody>
							</table>
						</td>
						<td valign="top">
							<!-- kolom3 -->
							<table border="0" cellpadding="4" cellspacing="0" id="tbl-list2">
							<thead>
							<tr>
								<th>No</th>
								<th>Desk&nbsp;Coll</th>
								<th>Absensi</th>
								<th>Team&nbsp;Leader</th>
							</tr>
							</thead>
							<tbody>
							<?php
								$j=0;
								foreach($absen3 as $i => $row)
								{
									$j++;
								 	$class = ($i % 2 == 1) ? 'odd' : 'even';

									echo '<tr class="' . $class . '">';
									echo '	<td align="left">' . $j  . '</td> ' . "\r\n" ;
									echo '	<td align="left">' . $row['username']  . '</td> ' . "\r\n" ;
									echo '	<td align="center">' . $row['total_hadir'] . '</td> ' . "\r\n" ;
									echo '	<td align="left">' . $row['leader_name'] . '</td> ' . "\r\n" ;
									echo '</tr> ' ;

								}
							?>
							</tbody>
							</table>
						</td>
						<td valign="top">
							<!-- kolom4 -->
							<table border="0" cellpadding="4" cellspacing="0" id="tbl-list2">
							<thead>
							<tr>
								<th>No</th>
								<th>Desk&nbsp;Coll</th>
								<th>Absensi</th>
								<th>Team&nbsp;Leader</th>
							</tr>
							</thead>
							<tbody>
							<?php
								$j=0;
								foreach($absen4 as $i => $row)
								{
									$j++;
								 	$class = ($i % 2 == 1) ? 'odd' : 'even';

									echo '<tr class="' . $class . '">';
									echo '	<td align="left">' . $j  . '</td> ' . "\r\n" ;
									echo '	<td align="left">' . $row['username']  . '</td> ' . "\r\n" ;
									echo '	<td align="center">' . $row['total_hadir'] . '</td> ' . "\r\n" ;
									echo '	<td align="left">' . $row['leader_name'] . '</td> ' . "\r\n" ;
									echo '</tr> ' ;

								}
							?>
							</tbody>
							</table>
						</td>
						</tr>
						</table>
		    	</div>
		    </div>
				<!-- /Monitoring User -->

			</div>
		</div>
		<!-- /beta -->

    </div>
  </div>
  <!-- /container -->

</div>
</body>
</html>
