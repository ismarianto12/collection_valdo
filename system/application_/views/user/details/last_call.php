				 <?php                if($last_calltrack->num_rows() > 0):                               $r = 1;                 ?>				<h3>Last 10 Calltrack</h3>                <br />                <br />               <div class="last_ten" style="width:400px;height:400px;overflow:scroll;" >                <table border="0" style="">                <tr class="<?php echo $r % 2 == 1 ? "listA":"listB"?>">                    <td class="status">Username</td>                    <td class="status">Remark</td>                    <td class="status">Code Call</td>		    <td class="status">Call Date</td>		    <td class="status">Call Time</td>		    <td class="status">PTP Date</td>		    <td class="status">PTP Amount</td>				  </tr>                <?php                 foreach($last_calltrack->result() as $row):                ?>				<tr class="<?php echo $r % 2 == 0 ? "listA":"listB"?>">                    <td class="status"><?php echo $row->username;?></td>                    <td class="status"><?php echo $row->remarks;?></td>                    <td class="status"><?php echo $row->code_call_track;?></td>		    <td class="status"><?php echo $row->call_date;?></td>		    <td class="status"><?php echo $row->call_time;?></td>		    <td class="status"><?php echo $row->ptp_date;?></td>		    <td class="status"><?php echo $row->ptp_amount;?></td>				  </tr>				                <?php                 $r++;                 endforeach;                ?>				</table>				</div>                <?php else:                echo "There is no data calltrack";                endif;                ?>