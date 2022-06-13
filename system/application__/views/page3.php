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
			
			    <div id="monitor-title">
			    	<h1>MONITORING</h1>
			    </div>

			    <div id="inbound-title-time">
			    	<?php echo date("Y-m-d H:i:s"); ?>
			    </div>
			    

		<!-- /beta -->
		
		<div id="monitor-title">
			    	<h1>VOICE BLAST</h1>
			    </div>
		</div>
			<table border="0" cellpadding="4" cellspacing="0" id="tbl-list">
				<thead>
				<tr>
					<th align="center">TGLNOW</th>						
				</tr>
				</thead>
				<tbody>
				<?php foreach($ems as $ems){ ?>
					<tr class="odd">

						<td align="center"><?php echo $ems['totdat']; ?></td>
					</tr>
				<?php } ?>	
				</tbody>
				</table>

    </div>
  </div>
  <!-- /container -->

</div>
</body>
</html>
