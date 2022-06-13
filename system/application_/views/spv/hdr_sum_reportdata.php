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
              <th sort="tc" class="th_bg">Total Data</th>
              <th sort="acc" class="th_bg">Data Contact</th>
              <th sort="acc" class="th_bg">Data UnContact</th>
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
                 <?php
                $p = 'a';
                foreach ($total_report->result() as $row) {
                		
                    $b++;
                    $a++;
                    
                   
        ?>
                    <tr class="spec<?php echo $b % 2 == 0 ? ' ' . $hide : 'alt ' . $hide ?>">
           <td class="alt"><!---Total Call--><?php $no_acc_tc = $row->tootal; $i[] = $row->tootal;
                    echo $contact = $no_acc_tc >= 1 ? '<p   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/all/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_acc_tc . '</p>' : 'FreeDay' ?>   </td>
                    <?php  } ?>
                     <?php
                $p = 'a';
                foreach ($all_data->result() as $row) {
                		
                    $b++;
                    $a++;
                    
                   
        ?>
                <td class="alt"><!---Acct Work--><?php $no_acc_tc = $row->call; $i2[] = $row->call;
                    echo $contact = $no_acc_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/acc/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_acc_tc . '</a>' : '0' ?> </td>
                <td class="alt"><!---Arch Work--><?php $no_acc_tc = $row->uncall; $t1 = $row->uncall;
                    echo $contact = $no_acc_tc >= 1 ? '<a   onclick="popBlock(\'' . site_url() . 'spv/hdr_spv_report_ctrl/detail_status/' . $row->id_user . '/acc/' . $begindate . '/' . $enddate . '/' . $report = "0" . '\')">' . $no_acc_tc . '</a>' : '0' ?> </td> </tr>
        <?php  } ?>

    </tbody>
</table>
