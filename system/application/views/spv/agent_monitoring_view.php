<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/hdr_tables.css" type="text/css"  />

<style type="text/css">
    table.hdrtable { width: 400px; }
    td.hover, #listHover tbody tr:hover { background-color: LemonChiffon; }
    td.betterhover, #listHover tbody tr:hover { background: LightCyan; }
    .colorMaroon { color: crimson; font-weight:bold; }
    .colorBlue { color: darkslateblue; font-weight:bold; }
    .colorYellow { color: Orange; font-weight:bold; }
	.colorRed { color: Red; font-weight:bold; }
	.colorGreen { color: Green; font-weight:bold; }
</style>

<?php
 function colorize($status){
  if($status == 'ONLINE'){
    return 'colorBlue';
  } else if($status == 'OFFLINE'){
    return 'colorMaroon';
  } else if(substr($status, 0, 5) == 'PAUSE'){
    return 'colorYellow';
  } else {
    return 'colorMaroon';
  }
 }

 function colorize1($jam,$menit,$leave_reason,$user_status){
	if($leave_reason == 'P1' && $user_status == 'offline'){
		if($jam == 0){
			if($menit >= 16){
				return 'colorRed';
			} else {
				return 'colorBlue';
			}

		} else {
			return 'colorRed';
		}
	} else if($leave_reason == 'P2' && $user_status == 'offline'){
		if($jam == 0){
			if($menit >= 31){
				return 'colorRed';
			} else {
				return 'colorBlue';
			}

		} else {
			return 'colorRed';
		}
	} else if($leave_reason == 'P3' && $user_status == 'offline'){
		if($jam == 0){
			if($menit >= 16){
				return 'colorRed';
			} else {
				return 'colorBlue';
			}

		} else {
			return 'colorRed';
		}
	} else if($leave_reason == 'P4' && $user_status == 'offline'){
		if($jam == 0){
			if($menit >= 30){
				return 'colorRed';
			} else {
				return 'colorBlue';
			}

		} else {
			return 'colorRed';
		}
	} else if($leave_reason == 'P5' && $user_status == 'offline'){
		if($jam == 0){
			if($menit >= 11){
				return 'colorRed';
			} else {
				return 'colorBlue';
			}

		} else {
			return 'colorRed';
		}
	} else if($leave_reason == 'L1' && $user_status == 'offline'){

	} else {
		return 'colorGreen';
	}

 }
?>

<div class="content">
    <div class="cnfull">
        <span class="boxfull_top"></span>
            <div class="boxfull_box">
            <center><h2 class="tit">&nbsp;Agent Monitoring</h2></center>
                <br/>
                <br/>
            <table class="hdrtable" style="width:100%">
                <tr class="tit">
                    <th class="th_bg">#</th>
                    <th class="th_bg">Username</th>
                    <th class="th_bg">Fullname</th>
                    <th class="th_bg">SIP</th>
                    <th class="th_bg">Last Login</th>
                    <th class="th_bg">Last Dial</th>
                    <th class="th_bg">Status</th>
                    <th class="th_bg">Time</th>
                    <th class="th_bg" style="width:30px">Logout Count</th>
                </tr>
            <?php if(COUNT($agent_list) > 0) : ?>
                <?php $idx = 1; ?>
                <?php foreach($agent_list as $agent): ?>
                <tr class="spec<?=$idx % 2 == 0 ? 'alt': ''; ?>">
                    <td class="alt"><?=$idx;?></td>
                    <td class="alt"><span class="<?=colorize1(DATE('H', strtotime($agent['xdiff'])),DATE('i', strtotime($agent['xdiff'])),$agent['leave_reason'],$agent['user_status'])?>"><?=$agent['username'];?></span></td>
                    <td class="alt"><?=strtoupper($agent['fullname']);?></td>
                    <td class="alt"><?=$agent['pabx_ext'];?></td>
                    <td class="alt"><?=DATE('D, dMy H:i', strtotime($agent['last_login']));?></td>
                    <td class="alt"><?=$agent['lastdial_diff'];?></td>
                    <td class="alt"><span class="<?=colorize($agent['status'])?>"><?=$agent['status'];?></span></td>
                    <td class="alt"><span id="xtimediff_<?=$idx;?>" name="xtimediff_<?=$idx;?>"><?=$agent['xdiff'];?></span></td>
                    <td class="alt">
                    <?php if($agent['logout_count'] > 0):?>
                        <a href="<?=site_url();?>spv/monitoring/logout_detail/<?=$agent['id_user'];?>" target="_blank"><?=$agent['logout_count'];?></a>
                    <?php else: ?>
                     <?=$agent['logout_count'];?>
                    <?php endif; ?>
                    </td>
                </tr>
                <?php $idx++; endforeach; ?>
            <?php endif; ?>
            </table>
            </div>
        <span class="boxfull_bot"></span>
    </div>
</div>

<script type="text/javascript">
 $(document).ready(function(){
    setTimeout(function(){
        updateTimers();
    },1000);

    setTimeout(function(){
       autoReload();
    }, 15000);
 });

 function updateTimers(){
    //alert('a');
    var xObj = $('[name^="xtimediff_"]');
    $.each(xObj, function(idx, key){
        var htmlObjName = $(key).attr('name');
        var time = $('#'+htmlObjName).html();
        if(time != '-'){
         var chunk = time.split(":");
         var xtime = new Date();
         xtime.setHours(chunk[0]);
         xtime.setMinutes(chunk[1]);
         xtime.setSeconds((chunk[2]*1) + 1);
         $('#'+htmlObjName).html(pad('00', xtime.getHours(), true) +':'+ pad('00', xtime.getMinutes(), true) +':'+ pad('00', xtime.getSeconds(), true));
        }
    });
    setTimeout(function(){
        updateTimers();
    },1000);
 }

 function autoReload(){
    new Boxy('<h2>Refreshing..</h2>', {modal:true});
    setTimeout(function(){
        location.reload();
    },1000);
 }

  function pad(pad, str, padLeft) {
        if (typeof str === 'undefined')
            return pad;
        if (padLeft) {
            return (pad + str).slice(-pad.length);
        } else {
            return (str + pad).substring(0, pad.length);
        }
   }
</script>