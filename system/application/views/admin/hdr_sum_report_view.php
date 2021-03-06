<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery.columnhover.pack.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#listHover').columnHover({eachCell:true, hoverClass:'betterhover'}); 
    });
    
</script>
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
<?php

  function findinside_filter($start, $string) {
      $start_f = 'hdm.' . $start . ' IN("';
      preg_match_all('/' . preg_quote($start_f, '/') . '([^\.)]+)' . preg_quote('")', '/') . '/i', $string, $m);
      $output = preg_replace("/[,\"]+/", ',', $m[1]);
      return $output[0];
  }

  function findinside_filter_p($start, $string) {
      $start_f = 'hdm.' . $start;
      preg_match_all('/' . preg_quote($start_f, '/') . '([^\.)]+)' . preg_quote('"', '/') . '/i', $string, $m);
      $output = preg_replace("/[,\"]+/", ' ', $m[1]);
      return $output[0];
  }

  function match_f($string) {
      if (preg_match('/bucket/', $string)) {
          return 1;
      } else {
          return 0;
      }
  }
?>
<table class="hdrtable" id="listHover" cellspacing="0" style="width:100%;margin-top:10px">
      <thead>
          <tr class="tit">
              <th sort="no" class="th_bg">No</th>
              <th sort="" class="th_bg">Region</th>
              <th sort="" class="th_bg">Cabang</th>
              <th sort="" class="th_bg">SPV</th>
              <th sort="tc" class="th_bg">User</th> 
              <th sort="tc" class="th_bg">Product</th>
        			<th sort="acc" class="th_bg">Target Acc Work</th> 
              <th sort="acc" class="th_bg">Acc. Worked</th>
              <th sort="call" class="th_bg">Contacted</th>
              <th sort="un" class="th_bg">No Contact</th>
              <th sort="ptp" class="th_bg">PTP</th>
              <th sort="ptp" class="th_bg">Keep</th>
              <th sort="ptp" class="th_bg">Broken</th>
              <th sort="ptp" class="th_bg">Amount Collected</th>             
              <th sort="ptp" class="th_bg">OS AR</th>
              
              
              <!--<th sort="ptp" class="th_bg">Incomming Call</th>
<th sort="ptp" class="th_bg">Remaining notClose</th>
<th sort="ptp" class="th_bg">Remaining notCall</th>-->
          </tr>
      </thead>
      <tbody>
        <?php
          $id_role = '3';
          $id_user = $_SESSION['bid_user_s'];
          $a = 0;
          $b = 0;
        ?>

        <?php $hide = $a > 10 ? 'hideTR' : '' ?>
          <tr class="spec<?php echo $b % 2 == 0 ? ' ' . $hide : 'alt ' . $hide ?>">
              <td class="mon"  align="right">-</td>
              <td class="alt">Export All Calltrack</td>
              <td class="alt"> - </td>
              <td class="alt"> - </td>
              <td class="alt"> - </td>
              <td class="alt"> - </td>
              <!-- <td class="alt"><a   onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/all/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')">ALL CALL</a></td>-->
              <td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/all/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export To Excel</a></td>
              <td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/acc/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export To Excel</a></td>
              <!-- <td class="alt"><a onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/acc/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')"></a></td>-->
              <td class="alt"><a onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/1/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')">ALL</a></td>
              <td class="alt"><a onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/2/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')">ALL</a></td>
              <td class="alt"><a onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/ptp/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')">ALL</a></td>
              <td class="alt"><a onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/keep/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')">ALL</a></td>
              <td class="alt"><a onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/broken/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')">ALL</a></td>
              <td class="alt"><a onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/keep/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')">ALL Amount</a></td>
             <td class="alt"><a onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/keep/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')">ALL Amount</a></td> 
          </tr>
         
        <?php
                $p = 'a';
                foreach ($all_report->result() as $row) {
                
                    $b++;
                    $a++;
        ?>
                    <tr class="spec<?php echo $b % 2 == 0 ? ' ' . $hide : 'alt ' . $hide ?>">

                        <td style="padding:4px;margin:4px;  text-align:center " class="mon"  align="right"><?php echo $a ?></td>
                        <td class="alt"><strong><? $qr = "SELECT region_name FROM hdr_branches WHERE region_id="."'".$row->region_area."' LIMIT 1"; $res = mysql_query($qr); $res1= mysql_fetch_array($res); print($res1['region_name']); ?></strong></td> 
                        <td class="alt"><strong><? $qr = "SELECT branch_name FROM hdr_branches WHERE code="."'".$row->branch_area."' LIMIT 1"; $res = mysql_query($qr); $res1= mysql_fetch_array($res); print($res1['branch_name']); ?></strong></td>                        
                        <td class="alt"><strong><? $qr = "SELECT username FROM hdr_user WHERE id_user="."'".$row->id_leader."' LIMIT 1"; $res = mysql_query($qr); $res1= mysql_fetch_array($res); print($res1['username']); ?></strong></td>
                        <td class="alt"><strong><?= $row->username ?></strong></td>
                        <td class="alt"><strong><?= $row->product ?></strong></td>
                <td class="alt"><!---Total Call--><?php $no_acc_tc = $row->target_work; $i[] = $row->target_work;
                    echo $contact = $no_acc_tc >= 1 ? '<p   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/all/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_acc_tc . '</p>' : '0' ?>   </td>
                <td class="alt"><!---Acct Work--><?php $no_acc_tc = $row->acct_work; $i2[] = $row->acct_work;
                    echo $contact = $no_acc_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/acc/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_acc_tc . '</a>' : '0' ?> </td>
                <td class="alt"><!---Contact--><?php $no_contact_tc = $row->contact; $i3[] = $row->contact;
                    echo $contact = $no_contact_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/1/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_contact_tc . '</a>' : '0' ?> </td>
                <td class="alt"><!---No Contact--><?php $no_uncontact_tc = $row->no_contact; $i4[] = $row->no_contact;
                    echo $contact = $no_uncontact_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/2/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_uncontact_tc . '</a>' : '0' ?> </td>
                <td class="alt"><!---PTP--><?php $no_ptp_tc = $row->ptp; $i5[] = $row->ptp;
                    echo $contact = $no_ptp_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/ptp/' . $begindate . '/' . $enddate . '/' . "0" . '\')">' . $no_ptp_tc . '</a>' : '0' ?> </td>
                <!-- 					keep -->
                <td class="alt"><?php $no_ptp_tc = $row->keep; $i6[] = $row->keep;
                    echo $contact = $no_ptp_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/keep/' . $begindate . '/' . $enddate . '/' . "0" . '\')">' . $no_ptp_tc . '</a>' : '0' ?> </td>
                <!-- 					broken -->
                <td class="alt"><?php $no_ptp_tc = $row->broken; $i7[] = $row->broken;
                    echo $contact = $no_ptp_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/broken/' . $begindate . '/' . $enddate . '/' . "0" . '\')">' . $no_ptp_tc . '</a>' : '0' ?> </td>
                 <td class="alt"><?php $acc_coll_tc = $row->amount_collected; $i8[] = $row->amount_collected;
                    echo $amount = $acc_coll_tc != '' ? @price_format($acc_coll_tc) : '' ?> </td>
                 <td class="alt"><?php $acc_ar = $row->os_ar; $i9[] = $row->os_ar;
                    echo $amount = $acc_ar != '' ? @price_format($acc_ar) : '' ?> </td> 
                
                
                
            </tr>
        <?php  }?>
        
        <?php

if ( isset($i,$i2,$i3,$i4,$i5,$i6,$i7,$i8,$i9) == "true") {
echo '          
         <tr class="spec">
         	<td class="alt"><strong>Total</strong></td>
         	<td class="alt">-</td>
         	<td class="alt">-</td>
         	<td class="alt">-</td>
         	<td class="alt">-</td>
         	<td class="alt">-</td>
         	<td class="alt"><strong>'.array_sum($i).'</strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all/'. $row->id_user . '/acc/' . $begindate . '/' . $enddate . '/' . $report = "0"."'".')">'.array_sum($i2).'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all/'. $row->id_user . '/1/' . $begindate . '/' . $enddate . '/' . $report = "0"."'".')">'.array_sum($i3).'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all/'. $row->id_user . '/2/' . $begindate . '/' . $enddate . '/' . $report = "0"."'".')">'.array_sum($i4).'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all/'. $row->id_user . '/ptp/' . $begindate . '/' . $enddate . '/' . "0"."'".')">'.array_sum($i5).'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all/'. $row->id_user . '/keep/' . $begindate . '/' . $enddate . '/' ."0"."'".')">'.array_sum($i6).'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all/'. $row->id_user . '/broken/' . $begindate . '/' . $enddate . '/' ."0"."'".')">'.array_sum($i7).'</a></strong></td>
         	<td class="alt"><strong>'.@price_format(array_sum($i8)).'</a></strong></td>
          <td class="alt"><strong>'.@price_format(array_sum($i9)).'</a></strong></td>
        </tr>
        
      '; }
      
      
?>	

    </tbody>
</table>
