<table border="0" cellpadding="4" cellspacing="0" id="tbl-list">
<thead>
<tr>
	<th>OD</th>
	<th>Total Data</th>
	<th>Pengerjaan</th>
	<th>Sisa</th>
	<th>%</th>
</tr>
</thead>
<tbody>
<?php
	foreach($data as $i => $row)
	{
	 	$class = ($i % 2 == 1) ? 'odd' : 'even';

		echo '<tr class="' . $class . '">';
		echo '	<td align="center">' . $row['od'] . '</td> ' . "\r\n" ;
		echo '	<td align="right">' . number_format($row['total_data']) . '</td> ' . "\r\n" ;
		echo '	<td align="right">' . number_format($row['total_tounch']) . '</td> ' . "\r\n" ;
		echo '	<td align="right">' . number_format($row['total_sisa']) . '</td> ' . "\r\n" ;
		echo '	<td align="center">' . $row['percentage'] . '</td> ' . "\r\n" ;
		echo '</tr> ' ;
	}
?>
</tbody>
</table>

