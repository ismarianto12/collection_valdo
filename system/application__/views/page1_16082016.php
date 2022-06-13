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

		<!-- Monitoring -->
		<div id="monitor">
			<div id="monitor-inner" class="pkg">
			
			    <div id="inbound-title">
			    	<h1>MONITORING</h1>
			    </div>

				<table border="0" cellpadding="4" cellspacing="0" id="tbl-list">
				<thead>
				<tr>
					<th rowspan="2">OD</th>
					<th colspan="4" align="center">REMINDER</th>
					<th colspan="7" align="center">DC01</th>
					<th colspan="9" align="center">DC02</th>
					<th rowspan="2">TOTAL</th>				
				</tr>
				<tr>
					<th>-3</th>
					<th>-2</th>
					<th>-1</th>
					<th>0</th>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>5</th>
					<th>6</th>
					<th>7</th>
					<th>8</th>
					<th>9</th>
					<th>10</th>
					<th>11</th>
					<th>12</th>
					<th>13</th>
					<th>14</th>
					<th>15</th>
					<th>15+</th>
				</tr>
				</thead>
				<tbody>
					<tr class="odd">
						<td align="left">TOTAL CUST</td>
						<td><?php echo number_format($debtor_main['total_min3']) ?></td>
						<td><?php echo number_format($debtor_main['total_min2']) ?></td>
						<td><?php echo number_format($debtor_main['total_min1']) ?></td>
						<td><?php echo number_format($debtor_main['total_null']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus1']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus2']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus3']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus4']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus5']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus6']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus7']) ?></td>
						
						<td><?php echo number_format($debtor_main['total_plus8']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus9']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus10']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus11']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus12']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus13']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus14']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus15']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus15plus']) ?></td>
						
						<td><?php echo number_format($debtor_main['total_cust']) ?></td>						
					</tr>
					<tr class="even">
						<td align="left">TOTAL OSAR</td>
						<td><?php echo number_format($debtor_main['total_min3_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_min2_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_min1_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_null_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus1_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus2_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus3_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus4_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus5_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus6_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus7_amount']) ?></td>
						
						<td><?php echo number_format($debtor_main['total_plus8_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus9_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus10_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus11_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus12_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus13_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus14_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus15_amount']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus15plus_amount']) ?></td>
						
						<td><?php echo number_format($debtor_main['total_cust_amount']) ?></td>						
					</tr>
					<tr class="odd">
						<td align="left">TOTAL SKIP</td>
						<td><?php echo number_format($debtor_main['total_min3_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_min2_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_min1_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_null_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus1_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus2_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus3_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus4_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus5_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus6_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus7_skip']) ?></td>
						
						<td><?php echo number_format($debtor_main['total_plus8_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus9_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus10_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus11_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus12_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus13_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus14_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus15_skip']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus15plus_skip']) ?></td>
						
						<td><?php echo number_format($debtor_main['total_cust_skip']) ?></td>						
					</tr>										
					<tr class="even">
						<td align="left">PENGERJAAN</td>
						<td><?php echo number_format($calltrack['total_min3']) ?></td>
						<td><?php echo number_format($calltrack['total_min2']) ?></td>
						<td><?php echo number_format($calltrack['total_min1']) ?></td>
						<td><?php echo number_format($calltrack['total_null']) ?></td>
						<td><?php echo number_format($calltrack['total_plus1']) ?></td>
						<td><?php echo number_format($calltrack['total_plus2']) ?></td>
						<td><?php echo number_format($calltrack['total_plus3']) ?></td>
						<td><?php echo number_format($calltrack['total_plus4']) ?></td>
						<td><?php echo number_format($calltrack['total_plus5']) ?></td>
						<td><?php echo number_format($calltrack['total_plus6']) ?></td>
						<td><?php echo number_format($calltrack['total_plus7']) ?></td>
						
						<td><?php echo number_format($calltrack['total_plus8']) ?></td>
						<td><?php echo number_format($calltrack['total_plus9']) ?></td>
						<td><?php echo number_format($calltrack['total_plus10']) ?></td>
						<td><?php echo number_format($calltrack['total_plus11']) ?></td>
						<td><?php echo number_format($calltrack['total_plus12']) ?></td>
						<td><?php echo number_format($calltrack['total_plus13']) ?></td>
						<td><?php echo number_format($calltrack['total_plus14']) ?></td>
						<td><?php echo number_format($calltrack['total_plus15']) ?></td>
						<td><?php echo number_format($calltrack['total_plus15plus']) ?></td>
						
						<td><?php echo number_format($calltrack['total_cust']) ?></td>												
					</tr>
					<tr class="odd">
						<td align="left">SISA</td>
						<td><?php echo number_format($debtor_main['total_min3']-$calltrack['total_min3']) ?></td>
						<td><?php echo number_format($debtor_main['total_min2']-$calltrack['total_min2']) ?></td>
						<td><?php echo number_format($debtor_main['total_min1']-$calltrack['total_min1']) ?></td>
						<td><?php echo number_format($debtor_main['total_null']-$calltrack['total_null']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus1']-$calltrack['total_plus1']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus2']-$calltrack['total_plus2']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus3']-$calltrack['total_plus3']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus4']-$calltrack['total_plus4']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus5']-$calltrack['total_plus5']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus6']-$calltrack['total_plus6']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus7']-$calltrack['total_plus7']) ?></td>
						
						<td><?php echo number_format($debtor_main['total_plus8']-$calltrack['total_plus8']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus9']-$calltrack['total_plus9']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus10']-$calltrack['total_plus10']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus11']-$calltrack['total_plus11']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus12']-$calltrack['total_plus12']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus13']-$calltrack['total_plus13']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus14']-$calltrack['total_plus14']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus15']-$calltrack['total_plus15']) ?></td>
						<td><?php echo number_format($debtor_main['total_plus15plus']-$calltrack['total_plus15plus']) ?></td>
						
						<td><?php echo number_format($debtor_main['total_cust']-$calltrack['total_cust']) ?></td>						
					</tr>
					<tr class="even">
						<td align="left">%WORK</td>
						<td><?php echo worked_percent($calltrack['total_min3'],$debtor_main['total_min3']) ?></td>
						<td><?php echo worked_percent($calltrack['total_min2'],$debtor_main['total_min2']) ?></td>
						<td><?php echo worked_percent($calltrack['total_min1'],$debtor_main['total_min1']) ?></td>
						<td><?php echo worked_percent($calltrack['total_null'],$debtor_main['total_null']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus1'],$debtor_main['total_plus1']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus2'],$debtor_main['total_plus2']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus3'],$debtor_main['total_plus3']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus4'],$debtor_main['total_plus4']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus5'],$debtor_main['total_plus5']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus6'],$debtor_main['total_plus6']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus7'],$debtor_main['total_plus7']) ?></td>
						
						<td><?php echo worked_percent($calltrack['total_plus8'],$debtor_main['total_plus8']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus9'],$debtor_main['total_plus9']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus10'],$debtor_main['total_plus10']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus11'],$debtor_main['total_plus11']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus12'],$debtor_main['total_plus12']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus13'],$debtor_main['total_plus13']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus14'],$debtor_main['total_plus14']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus15'],$debtor_main['total_plus15']) ?></td>
						<td><?php echo worked_percent($calltrack['total_plus15plus'],$debtor_main['total_plus15plus']) ?></td>
						
						<td><?php echo worked_percent($calltrack['total_cust'],$debtor_main['total_cust']) ?></td>						
					</tr>
				</tbody>
				</table><br />
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
			</div>
		</div>


		<!-- alpha -->
		<div id="alpha">
			<div id="alpha-inner" class="pkg">

		    <div id="inbound-title">
		    	<h1>TOP Five DURABLE</h1>
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
		    	<h1>Worst 5 DURABLE</h1>
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

			    <div id="outbound-body">
			    	<div id="outbound-body-inner" class="pkg">
					
					<!-- OTOMOTIF -->
					
				    <div id="inbound-title">
				    	<h1>TOP Five OTOMOTIF</h1>
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
									foreach($data_top_oto as $i => $row)
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
				    	<h1>Worst 5 OTOMOTIF</h1>
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
									foreach($worst_oto as $i => $row)
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
					
					<!-- /OTOMOTIF -->

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
