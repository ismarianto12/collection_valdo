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
	foreach($data as $i => $row)
	{
	 	$class = ($i % 2 == 1) ? 'odd' : 'even';

		echo '<tr class="' . $class . '">';
		echo '	<td align="left">' . $row['username'] . '</td> ' . "\r\n" ;
		echo '	<td align="center">' . number_format($row['total_call']) . '</td> ' . "\r\n" ;
		echo '	<td align="left">' . $row['leader_name'] . '</td> ' . "\r\n" ;
		echo '</tr> ' ;
	}
?>
</tbody>
</table>

