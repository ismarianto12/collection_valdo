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
              <th sort="tc" class="th_bg">User</th>
              <!-- <th sort="assign" class="th_bg">Shift</th> -->
              <th sort="acc" class="th_bg">Target Work</th>
              <th sort="acc" class="th_bg">Work</th>
              <th sort="acc" class="th_bg">Arc Work</th>
              <th sort="call" class="th_bg">Cont</th>
              <th sort="call" class="th_bg">Arc Cont</th>
              <th sort="un" class="th_bg">No Cont</th>
              <th sort="ptp" class="th_bg">PTP</th>
              <th sort="ptp" class="th_bg">Arc PTP</th>
              <th sort="ptp" class="th_bg">Keep</th>
              <th sort="ptp" class="th_bg">Arc Keep</th>
              <th sort="ptp" class="th_bg">Broken</th>
              <th sort="ptp" class="th_bg">Perf</th>
              <!-- <th sort="ptp" class="th_bg">Amount Collected</th>             
              <th sort="ptp" class="th_bg">OS AR</th> -->
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
              <td class="alt">Export All</td>
             	<!-- <td class="alt"> - </td> -->
                      
              <!-- <td class="alt"><a   onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/all/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')">ALL CALL</a></td>-->
              <td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/all/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export All</a></td>
              <td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/acc/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export All</a></td>
              	<td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/acc/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export All</a></td>
              <!-- <td class="alt"><a onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/acc/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')"></a></td>-->
              <td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/1/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export All</a></td>
              	<td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/1/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export All</a></td>
              <td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/2/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export All</a></td>
              <td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/ptp/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export All</a></td>
              <td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/ptp/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export All</a></td>
              <td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/keep/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export All</a></td>
              <td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/keep/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export All</a></td>
              <td class="alt"><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report_to_csv/all/broken/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>">Export All</a></td>
              <td class="alt">-</td>
              <!-- <td class="alt"><a onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/keep/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')">ALL Amount</a></td>
              <td class="alt"><a onclick="popBlock('<?= site_url() ?>spv/hdr_spv_report_ctrl/detail_status/all/keep/<?= $begindate ?>/<?= $enddate ?>/<?= $report = "0" ?>')">ALL Amount</a></td> -->
          </tr>
         
        <?php
                $p = 'a';
                foreach ($all_report->result() as $row) {
                		
                    $b++;
                    $a++;
                    
                   
        ?>
                    <tr class="spec<?php echo $b % 2 == 0 ? ' ' . $hide : 'alt ' . $hide ?>">
                    	

                        <td style="padding:4px;margin:4px;  text-align:center " class="alt"  align="right"><?php echo $a ?></td>
                        <td class="alt"><strong><?= $row->username ?></strong></td>
                       <!-- <td class="alt"><?= $row->shift; ?></td> -->
                        <td class="alt"><!---Total Call--><?php $no_acc_tc = $row->target_work; $i[] = $row->target_work;
                    echo $contact = $no_acc_tc >= 1 ? '<p   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/all/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_acc_tc . '</p>' : 'FreeDay' ?>   </td>
                <td class="alt"><!---Acct Work--><?php $no_acc_tc = $row->acct_work; $i2[] = $row->acct_work;
                    echo $contact = $no_acc_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/acc/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_acc_tc . '</a>' : '0' ?> </td>
                <td class="alt"><!---Arch Work--><?php $no_acc_tc = $row->arch_work."%"; $t1 = $row->arch_work;
                    echo $contact = $no_acc_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/acc/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_acc_tc . '</a>' : '0%' ?> </td>
                <td class="alt"><!---Contact--><?php $no_contact_tc = $row->contact; $i3[] = $row->contact;
                    echo $contact = $no_contact_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/1/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_contact_tc . '</a>' : '0' ?> </td>
                <td class="alt"><!---Arch Contact--><?php $no_contact_tc = $row->arch_contact.'%'; $t2 = $row->arch_contact;
                    echo $contact = $no_contact_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/1/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_contact_tc . '</a>' : '0%' ?> </td>
                <td class="alt"><!---No Contact--><?php $no_uncontact_tc = $row->no_contact; $i4[] = $row->no_contact;
                    echo $contact = $no_uncontact_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/2/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_uncontact_tc . '</a>' : '0' ?> </td>
                <td class="alt"><!---PTP--><?php $no_ptp_tc = $row->ptp; $i5[] = $row->ptp;
                    echo $contact = $no_ptp_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/ptp/' . $begindate . '/' . $enddate . '/' . "0" . '\')">' . $no_ptp_tc . '</a>' : '0' ?> </td>
                <td class="alt"><!---Arch PTP--><?php $no_ptp_tc = $row->arch_ptp.'%'; $t3 = $row->arch_ptp;
                    echo $contact = $no_ptp_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/ptp/' . $begindate . '/' . $enddate . '/' . "0" . '\')">' . $no_ptp_tc . '</a>' : '0%' ?> </td>
                <!-- 					keep -->
                <td class="alt"><?php $no_ptp_tc = $row->keep; $i6[] = $row->keep;
                    echo $contact = $no_ptp_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/keep/' . $begindate . '/' . $enddate . '/' . "0" . '\')">' . $no_ptp_tc . '</a>' : '0' ?> </td>
                <!-- 				Arch keep  -->
                <td class="alt"><?php $no_ptp_tc = $row->arch_keep.'%'; $t4 = $row->arch_keep;
                    echo $contact = $no_ptp_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/keep/' . $begindate . '/' . $enddate . '/' . "0" . '\')">' . $no_ptp_tc . '</a>' : '0%' ?> </td>
                <!-- 					broken -->
                <td class="alt"><?php $no_ptp_tc = $row->broken; $i7[] = $row->broken;
                    echo $contact = $no_ptp_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/broken/' . $begindate . '/' . $enddate . '/' . "0" . '\')">' . $no_ptp_tc . '</a>' : '0' ?> </td>
                <!-- Performance -->
                <?php $t1+$t2+$t3+$t4 <= 50 ? $sty = 'style="color:red"' : $sty = 'style="color:green"' ; ?>
                <td class="alt" <?php echo $sty ;?> ><strong><?php echo ($t1+$t2+$t3+$t4)."%"; ?></strong></td>
                <!-- <td class="alt"><?php $acc_coll_tc = $row->amount_collected; $i8[] = $row->amount_collected;
                    echo $amount = $acc_coll_tc != '' ? @price_format($acc_coll_tc) : '' ?> </td>
                <td class="alt"><?php $acc_ar = $row->os_ar; $i9[] = $row->os_ar;
                    echo $amount = $acc_ar != '' ? @price_format($acc_ar) : '' ?> </td>  -->
            </tr>
        <?php  } ?>
<?php

if ( isset($i,$i2,$i3,$i4,$i5,$i6,$i7,$i8,$i9,$t1,$t2,$t3,$t4) == "true") {
echo '          
         <tr class="spec">
         	<td class="alt"><strong>Total</strong></td>
         	
         	<td class="alt">-</td>
         	<td class="alt"><strong>'.array_sum($i).'</strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all_spv/'. $row->id_user . '/acc/' . $begindate . '/' . $enddate . '/' . $report = "0"."'".')">'.array_sum($i2).'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all_spv/'. $row->id_user . '/acc/' . $begindate . '/' . $enddate . '/' . $report = "0"."'".')">'.''.'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all_spv/'. $row->id_user . '/1/' . $begindate . '/' . $enddate . '/' . $report = "0"."'".')">'.array_sum($i3).'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all_spv/'. $row->id_user . '/1/' . $begindate . '/' . $enddate . '/' . $report = "0"."'".')">'.''.'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all_spv/'. $row->id_user . '/2/' . $begindate . '/' . $enddate . '/' . $report = "0"."'".')">'.array_sum($i4).'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all_spv/'. $row->id_user . '/ptp/' . $begindate . '/' . $enddate . '/' . "0"."'".')">'.array_sum($i5).'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all_spv/'. $row->id_user . '/ptp/' . $begindate . '/' . $enddate . '/' . "0"."'".')">'.''.'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all_spv/'. $row->id_user . '/keep/' . $begindate . '/' . $enddate . '/' ."0"."'".')">'.array_sum($i6).'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all_spv/'. $row->id_user . '/keep/' . $begindate . '/' . $enddate . '/' ."0"."'".')">'.''.'</a></strong></td>
         	<td class="alt"><strong><a onclick="popBlock('."'".site_url().'spv/hdr_spv_report_ctrl/detail_status_all_spv/'. $row->id_user . '/broken/' . $begindate . '/' . $enddate . '/' ."0"."'".')">'.array_sum($i7).'</a></strong></td>
         	<td class="alt"><strong></strong></td>
         <!--	<td class="alt"><strong>'.@price_format(array_sum($i8)).'</strong></td>
          <td class="alt"><strong>'.@price_format(array_sum($i9)).'</strong></td> -->
        </tr>
        
      '; }
      
      
?>				
    </tbody>
</table>
