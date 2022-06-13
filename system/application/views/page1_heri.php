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
					<div id="inbound-title">
						<h1>MONITORING</h1>
					</div>
					<table border="0" cellpadding="4" cellspacing="0" id="tbl-list">
						<thead>
						<tr>
							<th>OD</th>
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
							<th>TOTAL</th>
						</tr>
						</thead>
						<tbody>
						<tr bgcolor="#E6EAF9">
							<td align="center"><b>TOTAL CUST</td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-3','total_cust'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-2','total_cust'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-1','total_cust'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('0','total_cust'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('1','total_cust'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('2','total_cust'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('3','total_cust'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('4','total_cust'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('5','total_cust'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('6','total_cust'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('7','total_cust'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('total','total_cust'); echo number_format($data); ?></b></td>
						<tr>
						<tr bgcolor="#D4D7E1">
							<td align="center"><b>TOTAL OSAR</td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-3','total_os'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-2','total_os'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-1','total_os'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('0','total_os'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('1','total_os'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('2','total_os'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('3','total_os'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('4','total_os'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('5','total_os'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('6','total_os'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('7','total_os'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('total','total_os'); echo number_format($data); ?></b></td>
						<tr>
						<tr bgcolor="#E6EAF9">
							<td align="center"><b>PENGERJAAN</td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-3','pengerjaan'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-2','pengerjaan'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-1','pengerjaan'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('0','pengerjaan'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('1','pengerjaan'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('2','pengerjaan'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('3','pengerjaan'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('4','pengerjaan'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('5','pengerjaan'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('6','pengerjaan'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('7','pengerjaan'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('total','pengerjaan'); echo number_format($data); ?></b></td>
						<tr>
						<tr bgcolor="#D4D7E1">
							<td align="center"><b>SISA</td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-3','sisa'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-2','sisa'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-1','sisa'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('0','sisa'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('1','sisa'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('2','sisa'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('3','sisa'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('4','sisa'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('5','sisa'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('6','sisa'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('7','sisa'); echo number_format($data); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('total','sisa'); echo number_format($data); ?></b></td>
						<tr>
						<tr bgcolor="#E6EAF9">
							<td align="center"><b>%WORK</td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-3','work'); echo number_format($data,4); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-2','work'); echo number_format($data,4); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('-1','work'); echo number_format($data,4); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('0','work'); echo number_format($data,4); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('1','work'); echo number_format($data,4); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('2','work'); echo number_format($data,4); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('3','work'); echo number_format($data,4); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('4','work'); echo number_format($data,4); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('5','work'); echo number_format($data,4); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('6','work'); echo number_format($data,4); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('7','work'); echo number_format($data,4); ?></b></td>
							<td align="center"><b><?php $data = $this->filter_model->monitoring_detail('total','work'); echo number_format($data); ?></b></td>
						<tr>
						</tbody>
					</table>
					<br/><br/>
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
							foreach($data_top2 as $i => $row)
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
							foreach($worst2 as $i => $row)
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
		<!-- /beta -->

    </div>
  </div>
  <!-- /container -->

</div>
</body>
</html>
