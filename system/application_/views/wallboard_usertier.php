<table style="width: 100%; height:97%;">
 <tr>
    <th colspan="2" style="font-size: 1.5em; font-family: Callibri; text-align:center;border:3px solid DarkGray;"> Activity Level</th>
 </tr>
 <tr style="height:50%;">
    <td>
        <table style="width: 100%; height:99%">
            <tr>
             <th colspan="3" class="centerize" style="color: #FFF; background-color: Gold; font-size:1em;">High Tier</th>
            </tr>
            <?php $idx = 0; ?>
            <?php if(count($toptier) > 0) { ?>
             <?php foreach($toptier as $topuser) { ?>
                <tr>
                  <td class="striped"><?=$crown[$idx];?></td>
                  <td class="striped">
                    <p class="ratio_bar" style="width:<?=$topuser['ratio']?>%;"><?=$topuser['todayduration'];?></p>
                    <p style="font-size: 1em; font-weight: bold; font-family: Arial"><?=$topuser['fullname'];?> - <span style="color: Coral;"><?=$miscModel->get_tableDataById('tb_users', $topuser['id_leader'], 'id_user', 'fullname'); ?></span></p>
                  </td>
                  <td class="striped bold" style="width:10%"><?=$topuser['ratio']?>%</td>
                </tr>
                <?php $idx++; ?>
             <?php } ?>
            <?php } ?>
        </table>
    </td>
 </tr>
 <tr style="height:50%;">
    <td>
    <table style="width: 100%; height:99%">
            <tr>
                <th colspan="3" class="centerize" style="color: #FFF; background-color: Tomato; font-size:1em;">Low Tier</th>
            </tr>
            <?php if(count($lowtier) > 0) { ?>
             <?php foreach($lowtier as $lowuser) { ?>
                <tr>
                  <td class="striped"><img src="<?=base_url()?>component/images/sad_ico.png" alt="warning" /></td>
                  <td class="striped">
                    <p class="ratio_bar2" style="width:<?=$lowuser['ratio']?>%;"><?=$lowuser['todayduration'];?></p>
                    <p style="font-size: 1em; font-weight: bold; font-family: Arial"><?=$lowuser['fullname'];?> - <span style="color: Coral;"><?=$miscModel->get_tableDataById('tb_users', $lowuser['id_leader'], 'id_user', 'fullname'); ?></span></p>
                  </td>
                  <td class="striped bold" style="width:10%"><?=$lowuser['ratio']?>%</td>
                </tr>
             <?php } ?>
            <?php } ?>
        </table>
    </td>
 </tr>
</table>