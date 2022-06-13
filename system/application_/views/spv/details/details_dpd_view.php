<div style="width:500px;height:300px;overflow:auto;" align="center">
    <table frame=void cellspacing=0 cols=3 rules=none border=0>
        <colgroup><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100><col width=100></colgroup>
        <tbody>
            <tr>
                <td>dpd</td>
                <td>Data Clean</td>
                <td>Need Call</td>
                <td>Dont Call</td>
                <td>Already Call</td>
                <td>Remaining</td>
            </tr>
            <?php $b = 0; ?>
            <?php
              foreach ($dpd_list as $row_dpd) {
                  $b++;
                  $class_type = $b % 2 == 0 ? 'a' : 'b';
                  $class = $row_dpd->dpd <= '4' && $row_dpd->dpd != '0' ? 'class="dpd_real' . $class_type . '"' : '';
            ?>

                  <tr>

                      <td <?= $class; ?>><?= $row_dpd->dpd ?></td>
                      <td <?= $class; ?>><?= $row_dpd->list ?></td>
                      <td <?= $class; ?>><?= $row_dpd->dpd_call ?></td>
                  <td <?= $class; ?>><?= $row_dpd->dpd_out ?></td>
                  <td <?= $class; ?>><?= $row_dpd->dpd_called ?></td>
                  <td <?= $class; ?>><?= $row_dpd->remaining ?></td>
              </tr>
            <?php } ?>

        </tbody>
    </table>
</div>